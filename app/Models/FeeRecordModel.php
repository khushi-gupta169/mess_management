<?php

namespace App\Models;

use CodeIgniter\Model;

class FeeRecordModel extends Model
{
    protected $table            = 'fee_records';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields    = [
        'student_id', 'month', 'year', 'base_amount', 'extra_meal_amount',
        'other_amount', 'total_amount', 'paid_amount', 'pending_amount',
        'status', 'due_date'
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
        'student_id'   => 'required|is_natural_no_zero',
        'month'        => 'required|is_natural_no_zero|less_than_equal_to[12]',
        'year'         => 'required|is_natural_no_zero|exact_length[4]',
        'base_amount'  => 'required|decimal',
        'total_amount' => 'required|decimal',
        'status'       => 'in_list[pending,partial,paid]'
    ];
    protected $validationMessages   = [];
    protected $skipValidation       = false;
    protected $cleanValidationRules = true;

    // Callbacks
    protected $allowCallbacks = true;
    protected $beforeInsert   = [];
    protected $afterInsert    = [];
    protected $beforeUpdate   = [];
    protected $afterUpdate    = [];
    protected $beforeFind     = [];
    protected $afterFind      = [];
    protected $beforeDelete   = [];
    protected $afterDelete    = [];

    public function getStudentFeeRecords($studentId)
    {
        return $this->where('student_id', $studentId)
                    ->orderBy('year', 'DESC')
                    ->orderBy('month', 'DESC')
                    ->findAll();
    }

    public function getCurrentMonthFee($studentId)
    {
        $month = date('n');
        $year = date('Y');
        
        return $this->where('student_id', $studentId)
                    ->where('month', $month)
                    ->where('year', $year)
                    ->first();
    }

    public function getPendingFees()
    {
        return $this->select('fee_records.*, students.student_id, users.name as student_name')
                    ->join('students', 'students.id = fee_records.student_id')
                    ->join('users', 'users.id = students.user_id')
                    ->where('fee_records.status !=', 'paid')
                    ->orderBy('fee_records.due_date', 'ASC')
                    ->findAll();
    }

    public function updatePayment($id, $paidAmount)
    {
        $fee = $this->find($id);
        if (!$fee) {
            return false;
        }

        $newPaidAmount = $fee['paid_amount'] + $paidAmount;
        $pendingAmount = $fee['total_amount'] - $newPaidAmount;
        
        $status = 'pending';
        if ($pendingAmount <= 0) {
            $status = 'paid';
            $pendingAmount = 0;
        } elseif ($newPaidAmount > 0) {
            $status = 'partial';
        }

        return $this->update($id, [
            'paid_amount' => $newPaidAmount,
            'pending_amount' => $pendingAmount,
            'status' => $status
        ]);
    }

    public function getTotalCollection($month, $year)
    {
        $result = $this->selectSum('paid_amount')
                       ->where('month', $month)
                       ->where('year', $year)
                       ->first();
        
        return $result['paid_amount'] ?? 0;
    }

    public function getTotalPending($month, $year)
    {
        $result = $this->selectSum('pending_amount')
                       ->where('month', $month)
                       ->where('year', $year)
                       ->first();
        
        return $result['pending_amount'] ?? 0;
    }
}