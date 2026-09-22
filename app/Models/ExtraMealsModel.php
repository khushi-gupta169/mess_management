<?php

namespace App\Models;

use CodeIgniter\Model;

class ExtraMealsModel extends Model
{
    protected $table            = 'extra_meals';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields    = [
        'student_id', 'meal_date', 'meal_type', 'quantity',
        'price', 'reason', 'status', 'approved_by', 'approved_at'
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

    public function getWithStudent()
    {
        return $this->select('extra_meals.*, students.student_id as student_code, users.name as student_name')
                     ->join('students', 'students.id = extra_meals.student_id')
                     ->join('users', 'users.id = students.user_id')
                     ->orderBy('extra_meals.created_at', 'DESC')
                     ->findAll();
    }
}
