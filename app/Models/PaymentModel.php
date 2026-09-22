<?php

namespace App\Models;

use CodeIgniter\Model;

class PaymentModel extends Model
{
    protected $table            = 'payments';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields    = [
        'student_id', 'fee_id', 'transaction_id', 'amount', 'payment_method',
        'payment_date', 'status', 'receipt_number', 'notes'
    ];

    protected bool $allowEmptyInserts = false;
    protected bool $updateOnlyChanged = true;

    protected array $casts = [];
    protected array $castHandlers = [];

    // Dates
    protected $useTimestamps = true;
    protected $dateFormat    = 'datetime';
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';
    protected $deletedField  = 'deleted_at';

    // Validation
    protected $validationRules      = [
        'student_id'      => 'required|is_natural_no_zero',
        'fee_id'          => 'required|is_natural_no_zero',
        'transaction_id'  => 'required|is_unique[payments.transaction_id,id,{id}]',
        'amount'          => 'required|decimal',
        'payment_method'  => 'required|in_list[cash,online,card,upi]',
        'payment_date'    => 'required|valid_date',
        'receipt_number'  => 'required|is_unique[payments.receipt_number,id,{id}]',
        'status'          => 'in_list[pending,completed,failed]'
    ];
    protected $validationMessages   = [];
    protected $skipValidation       = false;
    protected $cleanValidationRules = true;

    // Callbacks
    protected $allowCallbacks = true;
    protected $beforeInsert   = ['generateReceiptNumber'];
    protected $afterInsert    = [];
    protected $beforeUpdate   = [];
    protected $afterUpdate    = [];
    protected $beforeFind     = [];
    protected $afterFind      = [];
    protected $beforeDelete   = [];
    protected $afterDelete    = [];

    protected function generateReceiptNumber(array $data)
    {
        if (!isset($data['data']['receipt_number']) || empty($data['data']['receipt_number'])) {
            $data['data']['receipt_number'] = 'RCP-' . date('Ymd') . '-' . strtoupper(substr(uniqid(), -6));
        }
        return $data;
    }

    public function getStudentPayments($studentId)
    {
        return $this->where('student_id', $studentId)
                    ->orderBy('payment_date', 'DESC')
                    ->findAll();
    }

    public function getPaymentWithDetails($id)
    {
        return $this->select('payments.*, students.student_id, users.name as student_name, 
                             fee_records.month, fee_records.year')
                    ->join('students', 'students.id = payments.student_id')
                    ->join('users', 'users.id = students.user_id')
                    ->join('fee_records', 'fee_records.id = payments.fee_id')
                    ->where('payments.id', $id)
                    ->first();
    }

    public function getPaymentsByDateRange($startDate, $endDate)
    {
        return $this->select('payments.*, students.student_id, users.name as student_name')
                    ->join('students', 'students.id = payments.student_id')
                    ->join('users', 'users.id = students.user_id')
                    ->where('payments.payment_date >=', $startDate)
                    ->where('payments.payment_date <=', $endDate)
                    ->where('payments.status', 'completed')
                    ->orderBy('payments.payment_date', 'DESC')
                    ->findAll();
    }

    public function getTodayCollection()
    {
        $today = date('Y-m-d');
        $result = $this->selectSum('amount')
                       ->where('payment_date', $today)
                       ->where('status', 'completed')
                       ->first();
        
        return $result['amount'] ?? 0;
    }

    public function getMonthlyCollection($month, $year)
    {
        $result = $this->selectSum('amount')
                       ->where('MONTH(payment_date)', $month)
                       ->where('YEAR(payment_date)', $year)
                       ->where('status', 'completed')
                       ->first();
        
        return $result['amount'] ?? 0;
    }
}