<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\HolidayModel;

class Holidays extends BaseController
{
    protected $holidayModel;

    public function __construct()
    {
        $this->holidayModel = new HolidayModel();
    }

    public function index()
    {
        if (!session()->get('isLoggedIn') || session()->get('role') !== 'admin') {
            return redirect()->to('/admin/login');
        }

        $holidays = $this->holidayModel->orderBy('holiday_date', 'DESC')->findAll();

        $data = [
            'title'    => 'Holiday Management',
            'holidays' => $holidays,
        ];

        return view('admin/holidays/index', $data);
    }

    public function add()
    {
        if (!session()->get('isLoggedIn') || session()->get('role') !== 'admin') {
            return redirect()->to('/admin/login');
        }

        $data = [
            'title' => 'Add New Holiday',
        ];

        return view('admin/holidays/add', $data);
    }

    public function store()
    {
        if (!session()->get('isLoggedIn') || session()->get('role') !== 'admin') {
            return redirect()->to('/admin/login');
        }

        $holidayData = [
            'holiday_date' => $this->request->getPost('holiday_date'),
            'title'        => $this->request->getPost('title'),
            'description'  => $this->request->getPost('description'),
            'meal_status'  => $this->request->getPost('meal_status') ?? 'closed',
            'created_by'   => session()->get('user_id'),
        ];

        if ($this->holidayModel->save($holidayData)) {
            return redirect()->to('/admin/holidays')->with('success', 'Holiday added successfully!');
        }

        return redirect()->back()->withInput()->with('error', 'Failed to add holiday. Please check your input.');
    }

    public function edit($id)
    {
        if (!session()->get('isLoggedIn') || session()->get('role') !== 'admin') {
            return redirect()->to('/admin/login');
        }

        $holiday = $this->holidayModel->find($id);

        if (!$holiday) {
            return redirect()->to('/admin/holidays')->with('error', 'Holiday not found!');
        }

        $data = [
            'title'   => 'Edit Holiday',
            'holiday' => $holiday,
        ];

        return view('admin/holidays/edit', $data);
    }

    public function update($id)
    {
        if (!session()->get('isLoggedIn') || session()->get('role') !== 'admin') {
            return redirect()->to('/admin/login');
        }

        $holiday = $this->holidayModel->find($id);

        if (!$holiday) {
            return redirect()->to('/admin/holidays')->with('error', 'Holiday not found!');
        }

        $holidayData = [
            'id'           => $id,
            'holiday_date' => $this->request->getPost('holiday_date'),
            'title'        => $this->request->getPost('title'),
            'description'  => $this->request->getPost('description'),
            'meal_status'  => $this->request->getPost('meal_status') ?? 'closed',
        ];

        if ($this->holidayModel->save($holidayData)) {
            return redirect()->to('/admin/holidays')->with('success', 'Holiday updated successfully!');
        }

        return redirect()->back()->withInput()->with('error', 'Failed to update holiday.');
    }

    public function delete($id)
    {
        if (!session()->get('isLoggedIn') || session()->get('role') !== 'admin') {
            return redirect()->to('/admin/login');
        }

        $holiday = $this->holidayModel->find($id);

        if (!$holiday) {
            return redirect()->to('/admin/holidays')->with('error', 'Holiday not found!');
        }

        if ($this->holidayModel->delete($id)) {
            return redirect()->to('/admin/holidays')->with('success', 'Holiday deleted successfully!');
        }

        return redirect()->to('/admin/holidays')->with('error', 'Failed to delete holiday.');
    }
}