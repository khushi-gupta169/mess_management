<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\ExtraMealsModel;

class ExtraMeals extends BaseController
{
    protected $extraMealsModel;

    public function __construct()
    {
        $this->extraMealsModel = new ExtraMealsModel();
    }

    public function index()
    {
        if (!session()->get('isLoggedIn') || session()->get('role') !== 'admin') {
            return redirect()->to('/admin/login');
        }

        $data = [
            'title'      => 'Extra Meals Requests',
            'extraMeals' => $this->extraMealsModel->getWithStudent(),
        ];

        return view('admin/extra-meals/index', $data);
    }

    public function approve($id)
    {
        if (!session()->get('isLoggedIn') || session()->get('role') !== 'admin') {
            return redirect()->to('/admin/login');
        }

        $meal = $this->extraMealsModel->find($id);

        if (!$meal) {
            return redirect()->to('/admin/extra-meals')->with('error', 'Request not found!');
        }

        $adminId = session()->get('user_id');

        if ($this->extraMealsModel->update($id, [
            'status'      => 'approved',
            'approved_by' => $adminId,
            'approved_at' => date('Y-m-d H:i:s'),
        ])) {
            return redirect()->to('/admin/extra-meals')->with('success', 'Extra meal request approved!');
        }

        return redirect()->to('/admin/extra-meals')->with('error', 'Failed to approve request.');
    }

    public function reject($id)
    {
        if (!session()->get('isLoggedIn') || session()->get('role') !== 'admin') {
            return redirect()->to('/admin/login');
        }

        $meal = $this->extraMealsModel->find($id);

        if (!$meal) {
            return redirect()->to('/admin/extra-meals')->with('error', 'Request not found!');
        }

        $adminId = session()->get('user_id');

        if ($this->extraMealsModel->update($id, [
            'status'      => 'rejected',
            'approved_by' => $adminId,
            'approved_at' => date('Y-m-d H:i:s'),
        ])) {
            return redirect()->to('/admin/extra-meals')->with('success', 'Extra meal request rejected.');
        }

        return redirect()->to('/admin/extra-meals')->with('error', 'Failed to reject request.');
    }
}
