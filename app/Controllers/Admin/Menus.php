<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\MenuModel;
use App\Models\MenuItemModel;

class Menus extends BaseController
{
    protected $menuModel;
    protected $menuItemModel;

    public function __construct()
    {
        $this->menuModel = new MenuModel();
        $this->menuItemModel = new MenuItemModel();
    }

    public function index()
    {
        if (!session()->get('isLoggedIn') || session()->get('role') !== 'admin') {
            return redirect()->to('/admin/login');
        }

        $menus = $this->menuModel->orderBy('menu_date', 'DESC')->findAll();

        foreach ($menus as &$menu) {
            $menu['items'] = $this->menuItemModel->where('menu_id', $menu['id'])->findAll();
        }

        $data = [
            'title' => 'Meal Menus Management',
            'menus' => $menus,
        ];

        return view('admin/menus/index', $data);
    }

    public function add()
    {
        if (!session()->get('isLoggedIn') || session()->get('role') !== 'admin') {
            return redirect()->to('/admin/login');
        }

        $data = [
            'title' => 'Add New Menu',
        ];

        return view('admin/menus/add', $data);
    }

    public function store()
    {
        if (!session()->get('isLoggedIn') || session()->get('role') !== 'admin') {
            return redirect()->to('/admin/login');
        }

        $menuDate = $this->request->getPost('menu_date');
        $day = $this->request->getPost('day');

        $menuData = [
            'menu_date' => $menuDate,
            'day'       => $day,
            'status'    => $this->request->getPost('status') ?? 'active',
        ];

        if ($this->menuModel->save($menuData)) {
            $menuId = $this->menuModel->insertID();

            $this->saveMenuItems($menuId);

            return redirect()->to('/admin/menus')->with('success', 'Menu created successfully!');
        }

        return redirect()->back()->withInput()->with('error', 'Failed to create menu. Please check your input.');
    }

    public function edit($id)
    {
        if (!session()->get('isLoggedIn') || session()->get('role') !== 'admin') {
            return redirect()->to('/admin/login');
        }

        $menu = $this->menuModel->find($id);

        if (!$menu) {
            return redirect()->to('/admin/menus')->with('error', 'Menu not found!');
        }

        $menu['items'] = $this->menuItemModel->where('menu_id', $id)->findAll();

        $data = [
            'title' => 'Edit Menu',
            'menu'  => $menu,
        ];

        return view('admin/menus/edit', $data);
    }

    public function update($id)
    {
        if (!session()->get('isLoggedIn') || session()->get('role') !== 'admin') {
            return redirect()->to('/admin/login');
        }

        $menu = $this->menuModel->find($id);

        if (!$menu) {
            return redirect()->to('/admin/menus')->with('error', 'Menu not found!');
        }

        $menuData = [
            'id'        => $id,
            'menu_date' => $this->request->getPost('menu_date'),
            'day'       => $this->request->getPost('day'),
            'status'    => $this->request->getPost('status') ?? 'active',
        ];

        if ($this->menuModel->save($menuData)) {
            // Delete existing items and re-insert
            $this->menuItemModel->where('menu_id', $id)->delete();
            $this->saveMenuItems($id);

            return redirect()->to('/admin/menus')->with('success', 'Menu updated successfully!');
        }

        return redirect()->back()->withInput()->with('error', 'Failed to update menu.');
    }

    public function delete($id)
    {
        if (!session()->get('isLoggedIn') || session()->get('role') !== 'admin') {
            return redirect()->to('/admin/login');
        }

        $menu = $this->menuModel->find($id);

        if (!$menu) {
            return redirect()->to('/admin/menus')->with('error', 'Menu not found!');
        }

        // Delete menu items first
        $this->menuItemModel->where('menu_id', $id)->delete();

        if ($this->menuModel->delete($id)) {
            return redirect()->to('/admin/menus')->with('success', 'Menu deleted successfully!');
        }

        return redirect()->to('/admin/menus')->with('error', 'Failed to delete menu.');
    }

    private function saveMenuItems($menuId)
    {
        $mealTypes = $this->request->getPost('meal_type') ?? [];
        $foodNames = $this->request->getPost('food_name') ?? [];
        $descriptions = $this->request->getPost('description') ?? [];

        if (!empty($mealTypes)) {
            foreach ($mealTypes as $index => $mealType) {
                if (!empty($mealType) && !empty($foodNames[$index])) {
                    $this->menuItemModel->save([
                        'menu_id'     => $menuId,
                        'meal_type'   => $mealType,
                        'food_name'   => $foodNames[$index],
                        'description' => $descriptions[$index] ?? null,
                    ]);
                }
            }
        }
    }
}
