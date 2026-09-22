<?php

namespace App\Controllers\Student;

use App\Controllers\BaseController;
use App\Models\UserModel;
use App\Models\StudentModel;

class Profile extends BaseController
{
    protected $userModel;
    protected $studentModel;

    public function __construct()
    {
        $this->userModel = new UserModel();
        $this->studentModel = new StudentModel();
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

        $data = [
            'title'   => 'My Profile',
            'student' => $student,
        ];

        return view('student/profile/index', $data);
    }

    public function edit()
    {
        if (!session()->get('isLoggedIn') || session()->get('role') !== 'student') {
            return redirect()->to('/student/login');
        }

        $userId = session()->get('user_id');
        $student = $this->studentModel->getStudentByUserId($userId);

        if (!$student) {
            return redirect()->to('/student/dashboard')->with('error', 'Student profile not found!');
        }

        $data = [
            'title'   => 'Edit Profile',
            'student' => $student,
        ];

        return view('student/profile/edit', $data);
    }

    public function update()
    {
        if (!session()->get('isLoggedIn') || session()->get('role') !== 'student') {
            return redirect()->to('/student/login');
        }

        $userId = session()->get('user_id');
        $student = $this->studentModel->getStudentByUserId($userId);

        if (!$student) {
            return redirect()->to('/student/dashboard')->with('error', 'Student profile not found!');
        }

        // Validate user data
        $userRules = [
            'name'  => 'required|min_length[3]|max_length[100]',
            'email' => 'required|valid_email|is_unique[users.email,id,' . $userId . ']',
        ];

        if (!$this->validate($userRules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        // Update user data
        $userData = [
            'name'  => $this->request->getPost('name'),
            'email' => $this->request->getPost('email'),
        ];

        $this->userModel->update($userId, $userData);

        // Update session name
        session()->set('name', $this->request->getPost('name'));
        session()->set('email', $this->request->getPost('email'));

        // Update student data
        $studentData = [
            'mobile' => $this->request->getPost('mobile'),
            'address' => $this->request->getPost('address'),
        ];

        $this->studentModel->update($student['id'], $studentData);

        return redirect()->to('/student/profile')->with('success', 'Profile updated successfully!');
    }
}