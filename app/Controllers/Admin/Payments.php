<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\PaymentModel;
use App\Models\FeeRecordModel;
use App\Models\StudentModel;

class Payments extends BaseController
{
    protected $paymentModel;
    protected $feeRecordModel;
    protected $studentModel;

    public function __construct()
    {
        $this->paymentModel    = new PaymentModel();
        $this->feeRecordModel  = new FeeRecordModel();
        $this->studentModel    = new StudentModel();
    }

    public function index()
    {
        if (!session()->get('isLoggedIn') || session()->get('role') !== 'admin') {
            return redirect()->to('/admin/login');
        }

        $payments = $this->paymentModel
            ->select('payments.*, students.student_id as student_code, users.name as student_name')
            ->join('students', 'students.id = payments.student_id')
            ->join('users', 'users.id = students.user_id')
            ->orderBy('payments.payment_date', 'DESC')
            ->findAll();

        $pendingFees = $this->feeRecordModel->getPendingFees();

        $data = [
            'title'       => 'Payment Management',
            'payments'    => $payments,
            'pendingFees' => $pendingFees,
        ];

        return view('admin/payments/index', $data);
    }

    public function record($feeId)
    {
        if (!session()->get('isLoggedIn') || session()->get('role') !== 'admin') {
            return redirect()->to('/admin/login');
        }

        $feeRecord = $this->feeRecordModel->find($feeId);

        if (!$feeRecord) {
            return redirect()->to('/admin/payments')->with('error', 'Fee record not found!');
        }

        $amount       = $this->request->getPost('amount');
        $paymentMethod = $this->request->getPost('payment_method');
        $paymentDate   = $this->request->getPost('payment_date');
        $transactionId = $this->request->getPost('transaction_id');
        $notes         = $this->request->getPost('notes');

        $paymentData = [
            'student_id'      => $feeRecord['student_id'],
            'fee_id'          => $feeId,
            'transaction_id'  => !empty($transactionId) ? $transactionId : 'TXN-' . strtoupper(uniqid()),
            'amount'          => $amount,
            'payment_method'  => $paymentMethod ?? 'cash',
            'payment_date'    => $paymentDate ?? date('Y-m-d'),
            'status'          => 'completed',
            'notes'           => $notes,
        ];

        if ($this->paymentModel->insert($paymentData)) {
            $this->feeRecordModel->updatePayment($feeId, $amount);
            return redirect()->to('/admin/payments')->with('success', 'Payment recorded successfully!');
        }

        return redirect()->back()->withInput()->with('error', 'Failed to record payment. Please check your input.');
    }
}