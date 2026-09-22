<?php

namespace App\Controllers\Student;

use App\Controllers\BaseController;
use App\Models\StudentModel;
use App\Models\MenuModel;
use App\Models\FeeRecordModel;
use App\Models\ExtraMealModel;
use App\Models\PaymentModel;

class Dashboard extends BaseController
{
    public function index()
    {
        if (!session()->get('isLoggedIn') || session()->get('role') !== 'student') {
            return redirect()->to('/student/login');
        }

        $userId = session()->get('user_id');
        $studentModel = new StudentModel();
        $student = $studentModel->getStudentByUserId($userId);

        $data = [
            'title'           => 'Student Dashboard',
            'student'         => $student,
            'user'            => [
                'name'  => session()->get('name'),
                'email' => session()->get('email'),
            ],
            'todayMenu'       => (new MenuModel())->getTodayMenu(),
            'pendingFees'     => 0,
            'extraMealCount'  => 0,
            'paymentCount'    => 0,
        ];

        if ($student) {
            $studentId = $student['id'];
            $feeRecordModel = new FeeRecordModel();
            $extraMealModel = new ExtraMealModel();
            $paymentModel   = new PaymentModel();

            $currentFee = $feeRecordModel->getCurrentMonthFee($studentId);
            $data['pendingFees'] = $currentFee ? $currentFee['pending_amount'] : 0;

            $data['extraMealCount'] = $extraMealModel->where('student_id', $studentId)->countAllResults();
            $data['paymentCount']   = $paymentModel->where('student_id', $studentId)->countAllResults();
        }

        return view('student/dashboard', $data);
    }
}