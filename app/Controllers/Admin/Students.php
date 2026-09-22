<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\StudentModel;
use App\Models\UserModel;

class Students extends BaseController
{
    protected $studentModel;
    protected $userModel;

    public function __construct()
    {
        $this->studentModel = new StudentModel();
        $this->userModel = new UserModel();
    }

    public function index()
    {
        if (!session()->get('isLoggedIn') || session()->get('role') !== 'admin') {
            return redirect()->to('/admin/login');
        }

        $db = \Config\Database::connect();
        $students = $db->table('students')
            ->select('students.*, users.name, users.email')
            ->join('users', 'users.id = students.user_id')
            ->orderBy('students.created_at', 'DESC')
            ->get()
            ->getResultArray();

        $data = [
            'title' => 'Students Management',
            'students' => $students
        ];

        return view('admin/students/index', $data);
    }

    public function add()
    {
        if (!session()->get('isLoggedIn') || session()->get('role') !== 'admin') {
            return redirect()->to('/admin/login');
        }

        $data = [
            'title' => 'Add Student',
            'validation' => \Config\Services::validation()
        ];

        return view('admin/students/add', $data);
    }



    public function store()
    {
        if (!session()->get('isLoggedIn') || session()->get('role') !== 'admin') {
            return redirect()->to('/admin/login');
        }

        $rules = [
            'name' => 'required|min_length[3]|max_length[100]',
            'email' => 'required|valid_email|is_unique[users.email]',
            'password' => 'required|min_length[6]',
            'student_id' => 'required|is_unique[students.student_id]',
            'enrollment_number' => 'required|is_unique[students.enrollment_number]',
            'father_name' => 'required|min_length[3]|max_length[100]',
            'mother_name' => 'required|min_length[3]|max_length[100]',
            'date_of_birth' => 'required|valid_date',
            'gender' => 'required|in_list[Female,Other]',
            'mobile' => 'required|min_length[10]|max_length[15]',
            'course' => 'required',
            'branch' => 'required',
            'year' => 'required',
            'semester' => 'required',
            'college' => 'required',
            'hostel_name' => 'required',
            'room_number' => 'required',
            'admission_date' => 'required|valid_date',
            'address' => 'required'
        ];

        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $db = \Config\Database::connect();
        $db->transStart();

        try {
            $userData = [
                'name' => $this->request->getPost('name'),
                'email' => $this->request->getPost('email'),
                'password' => $this->request->getPost('password'),
                'role' => 'student',
                'status' => 'active'
            ];

            $userId = $this->userModel->insert($userData);

            $studentData = [
                'user_id' => $userId,
                'student_id' => $this->request->getPost('student_id'),
                'enrollment_number' => $this->request->getPost('enrollment_number'),
                'father_name' => $this->request->getPost('father_name'),
                'mother_name' => $this->request->getPost('mother_name'),
                'date_of_birth' => $this->request->getPost('date_of_birth'),
                'gender' => $this->request->getPost('gender'),
                'mobile' => $this->request->getPost('mobile'),
                'course' => $this->request->getPost('course'),
                'branch' => $this->request->getPost('branch'),
                'year' => $this->request->getPost('year'),
                'semester' => $this->request->getPost('semester'),
                'college' => $this->request->getPost('college'),
                'hostel_name' => $this->request->getPost('hostel_name'),
                'room_number' => $this->request->getPost('room_number'),
                'admission_date' => $this->request->getPost('admission_date'),
                'address' => $this->request->getPost('address'),
                'status' => 'active'
            ];

            $this->studentModel->insert($studentData);
            $db->transComplete();

            if ($db->transStatus() === false) {
                return redirect()->back()->withInput()->with('error', 'Failed to add student.');
            }

            return redirect()->to('/admin/students')->with('success', 'Student added successfully!');
        } catch (\Exception $e) {
            $db->transRollback();
            return redirect()->back()->withInput()->with('error', 'Error: ' . $e->getMessage());
        }
    }

    public function edit($id)
    {
        if (!session()->get('isLoggedIn') || session()->get('role') !== 'admin') {
            return redirect()->to('/admin/login');
        }

        $student = $this->studentModel->getStudentWithUser($id);

        if (!$student) {
            return redirect()->to('/admin/students')->with('error', 'Student not found!');
        }

        $data = [
            'title' => 'Edit Student',
            'student' => $student,
            'validation' => \Config\Services::validation()
        ];

        return view('admin/students/edit', $data);
    }

    public function update($id)
    {
        if (!session()->get('isLoggedIn') || session()->get('role') !== 'admin') {
            return redirect()->to('/admin/login');
        }

        $student = $this->studentModel->find($id);

        if (!$student) {
            return redirect()->to('/admin/students')->with('error', 'Student not found!');
        }

        $rules = [
            'name' => 'required|min_length[3]|max_length[100]',
            'email' => "required|valid_email|is_unique[users.email,id,{$student['user_id']}]",
            'student_id' => "required|is_unique[students.student_id,id,{$id}]",
            'enrollment_number' => "required|is_unique[students.enrollment_number,id,{$id}]",
            'father_name' => 'required|min_length[3]|max_length[100]',
            'mother_name' => 'required|min_length[3]|max_length[100]',
            'date_of_birth' => 'required|valid_date',
            'gender' => 'required|in_list[Female,Other]',
            'mobile' => 'required|min_length[10]|max_length[15]',
            'course' => 'required',
            'branch' => 'required',
            'year' => 'required',
            'semester' => 'required',
            'college' => 'required',
            'hostel_name' => 'required',
            'room_number' => 'required',
            'admission_date' => 'required|valid_date',
            'address' => 'required',
            'status' => 'required|in_list[active,inactive,suspended]'
        ];

        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $db = \Config\Database::connect();
        $db->transStart();

        try {
            $userData = [
                'name' => $this->request->getPost('name'),
                'email' => $this->request->getPost('email')
            ];

            if ($this->request->getPost('password')) {
                $userData['password'] = $this->request->getPost('password');
            }

            $this->userModel->update($student['user_id'], $userData);

            $studentData = [
                'student_id' => $this->request->getPost('student_id'),
                'enrollment_number' => $this->request->getPost('enrollment_number'),
                'father_name' => $this->request->getPost('father_name'),
                'mother_name' => $this->request->getPost('mother_name'),
                'date_of_birth' => $this->request->getPost('date_of_birth'),
                'gender' => $this->request->getPost('gender'),
                'mobile' => $this->request->getPost('mobile'),
                'course' => $this->request->getPost('course'),
                'branch' => $this->request->getPost('branch'),
                'year' => $this->request->getPost('year'),
                'semester' => $this->request->getPost('semester'),
                'college' => $this->request->getPost('college'),
                'hostel_name' => $this->request->getPost('hostel_name'),
                'room_number' => $this->request->getPost('room_number'),
                'admission_date' => $this->request->getPost('admission_date'),
                'address' => $this->request->getPost('address'),
                'status' => $this->request->getPost('status')
            ];

            $this->studentModel->update($id, $studentData);
            $db->transComplete();

            if ($db->transStatus() === false) {
                return redirect()->back()->withInput()->with('error', 'Failed to update student.');
            }

            return redirect()->to('/admin/students')->with('success', 'Student updated successfully!');
        } catch (\Exception $e) {
            $db->transRollback();
            return redirect()->back()->withInput()->with('error', 'Error: ' . $e->getMessage());
        }
    }

    public function delete($id)
    {
        if (!session()->get('isLoggedIn') || session()->get('role') !== 'admin') {
            return redirect()->to('/admin/login');
        }

        $student = $this->studentModel->find($id);

        if (!$student) {
            return redirect()->to('/admin/students')->with('error', 'Student not found!');
        }

        $db = \Config\Database::connect();
        $db->transStart();

        try {
            $this->studentModel->delete($id);
            $this->userModel->delete($student['user_id']);

            $db->transComplete();

            if ($db->transStatus() === false) {
                return redirect()->to('/admin/students')->with('error', 'Failed to delete student.');
            }

            return redirect()->to('/admin/students')->with('success', 'Student deleted successfully!');
        } catch (\Exception $e) {
            $db->transRollback();
            return redirect()->to('/admin/students')->with('error', 'Error: ' . $e->getMessage());
        }
    }
}

