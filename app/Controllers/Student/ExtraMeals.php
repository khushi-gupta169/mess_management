<?php

namespace App\Controllers\Student;

use App\Controllers\BaseController;
use App\Models\StudentModel;
use App\Models\ExtraMealsModel;

class ExtraMeals extends BaseController
{
    protected $studentModel;
    protected $extraMealsModel;

    public function __construct()
    {
        $this->studentModel = new StudentModel();
        $this->extraMealsModel = new ExtraMealsModel();
    }

    public function index()
    {
        if (!session()->get('isLoggedIn') || session()->get('role') !== 'student') {
            return redirect()->to('/student/login');
        }

        $userId = session()->get('user_id');
        $student = $this->studentModel->getStudentByUserId($userId);

        if (!$student) {
            return redirect()->to('/student/dashboard')->with('error', 'Student profile not found!');
        }

        // Get student's extra meal requests
        $db = \Config\Database::connect();
        $extraMeals = $db->table('extra_meals')
            ->where('extra_meals.student_id', $student['id'])
            ->orderBy('extra_meals.created_at', 'DESC')
            ->get()
            ->getResultArray();

        $data = [
            'title'      => 'Extra Meal',
            'extraMeals' => $extraMeals,
            'student'    => $student,
        ];

        return view('student/extra-meals/index', $data);
    }

    public function request()
    {
        if (!session()->get('isLoggedIn') || session()->get('role') !== 'student') {
            return redirect()->to('/student/login');
        }

        $userId = session()->get('user_id');
        $student = $this->studentModel->getStudentByUserId($userId);

        if (!$student) {
            return redirect()->to('/student/dashboard')->with('error', 'Student profile not found!');
        }

        // Validate
        $rules = [
            'meal_date' => 'required|valid_date',
            'meal_type' => 'required|in_list[breakfast,lunch,evening,dinner]',
            'quantity'  => 'required|is_natural_no_zero|less_than_equal_to[10]',
            'price'     => 'required|decimal|greater_than[0]',
            'reason'    => 'required|min_length[3]|max_length[500]',
        ];

        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $mealData = [
            'student_id' => $student['id'],
            'meal_date'  => $this->request->getPost('meal_date'),
            'meal_type'  => $this->request->getPost('meal_type'),
            'quantity'   => $this->request->getPost('quantity'),
            'price'      => $this->request->getPost('price'),
            'reason'     => $this->request->getPost('reason'),
            'status'     => 'pending',
        ];

        if ($this->extraMealsModel->insert($mealData)) {
            return redirect()->to('/student/extra-meals')->with('success', 'Extra meal request submitted successfully!');
        }

        return redirect()->back()->withInput()->with('error', 'Failed to submit request. Please try again.');
    }
}