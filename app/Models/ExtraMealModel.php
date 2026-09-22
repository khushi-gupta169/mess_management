<?php

namespace App\Models;

use CodeIgniter\Model;

class ExtraMealModel extends Model
{
    protected $table            = 'extra_meals';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields    = [
        'student_id', 'meal_date', 'meal_type', 'quantity', 'price',
        'reason', 'status', 'approved_by', 'approved_at'
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
        'student_id' => 'required|is_natural_no_zero',
        'meal_date'  => 'required|valid_date',
        'meal_type'  => 'required|in_list[breakfast,lunch,evening,dinner]',
        'quantity'   => 'required|is_natural_no_zero',
        'price'      => 'required|decimal',
        'status'     => 'in_list[pending,approved,rejected]'
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

    public function getPendingRequests()
    {
        return $this->select('extra_meals.*, students.student_id, users.name as student_name')
                    ->join('students', 'students.id = extra_meals.student_id')
                    ->join('users', 'users.id = students.user_id')
                    ->where('extra_meals.status', 'pending')
                    ->orderBy('extra_meals.meal_date', 'DESC')
                    ->findAll();
    }

    public function getStudentRequests($studentId)
    {
        return $this->where('student_id', $studentId)
                    ->orderBy('meal_date', 'DESC')
                    ->findAll();
    }

    public function approveRequest($id, $approvedBy)
    {
        return $this->update($id, [
            'status' => 'approved',
            'approved_by' => $approvedBy,
            'approved_at' => date('Y-m-d H:i:s')
        ]);
    }

    public function rejectRequest($id, $approvedBy)
    {
        return $this->update($id, [
            'status' => 'rejected',
            'approved_by' => $approvedBy,
            'approved_at' => date('Y-m-d H:i:s')
        ]);
    }

    public function getApprovedMealsByStudent($studentId, $month, $year)
    {
        return $this->where('student_id', $studentId)
                    ->where('status', 'approved')
                    ->where('MONTH(meal_date)', $month)
                    ->where('YEAR(meal_date)', $year)
                    ->findAll();
    }

    public function getTotalExtraMealAmount($studentId, $month, $year)
    {
        $result = $this->selectSum('price')
                       ->where('student_id', $studentId)
                       ->where('status', 'approved')
                       ->where('MONTH(meal_date)', $month)
                       ->where('YEAR(meal_date)', $year)
                       ->first();
        
        return $result['price'] ?? 0;
    }
}