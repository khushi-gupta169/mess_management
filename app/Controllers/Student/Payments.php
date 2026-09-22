<?php

namespace App\Controllers\Student;

use App\Controllers\BaseController;
use App\Models\StudentModel;
use App\Models\FeeRecordModel;
use App\Models\PaymentModel;

class Payments extends BaseController
{
    protected $studentModel;
    protected $feeRecordModel;
    protected $paymentModel;

    public function __construct()
    {
        $this->studentModel = new StudentModel();
        $this->feeRecordModel = new FeeRecordModel();
        $this->paymentModel = new PaymentModel();
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

        $studentId = $student['id'];

        // Get fee records
        $feeRecords = $this->feeRecordModel->getStudentFeeRecords($studentId);

        // Get payments
        $payments = $this->paymentModel->getStudentPayments($studentId);

        // Calculate totals
        $totalPaid = 0;
        $totalPending = 0;
        foreach ($feeRecords as $fee) {
            $totalPaid += $fee['paid_amount'];
            $totalPending += $fee['pending_amount'];
        }

        $data = [
            'title'       => 'Payments',
            'student'     => $student,
            'feeRecords'  => $feeRecords,
            'payments'    => $payments,
            'totalPaid'   => $totalPaid,
            'totalPending' => $totalPending,
        ];

        return view('student/payments/index', $data);
    }
}