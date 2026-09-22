<?php

namespace App\Controllers\Student;

use App\Controllers\BaseController;
use App\Models\MenuModel;

class Menu extends BaseController
{
    protected $menuModel;

    public function __construct()
    {
        $this->menuModel = new MenuModel();
    }

    public function index()
    {
        if (!session()->get('isLoggedIn') || session()->get('role') !== 'student') {
            return redirect()->to('/student/login');
        }

        $data = [
            'title'      => 'Weekly Menu',
            'weeklyMenu' => $this->menuModel->getWeeklyMenu(),
            'todayMenu'  => $this->menuModel->getTodayMenu(),
        ];

        return view('student/menu/index', $data);
    }
}