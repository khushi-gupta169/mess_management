<?php

namespace App\Models;

use CodeIgniter\Model;

class StudentModel extends Model
{
    protected $table            = 'students';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields    = [
        'user_id', 'student_id', 'enrollment_number', 'father_name', 'mother_name',
        'date_of_birth', 'gender', 'mobile', 'course', 'branch', 'year', 'semester',
        'college', 'hostel_name', 'room_number', 'admission_date', 'address', 'status'
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
        'user_id'           => 'required|is_natural_no_zero',
        'student_id'        => 'required|is_unique[students.student_id,id,{id}]',
        'enrollment_number' => 'required|is_unique[students.enrollment_number,id,{id}]',
        'father_name'       => 'required|min_length[3]|max_length[100]',
        'mother_name'       => 'required|min_length[3]|max_length[100]',
        'date_of_birth'     => 'required|valid_date',
        'mobile'            => 'required|min_length[10]|max_length[15]',
        'course'            => 'required',
        'branch'            => 'required',
        'year'              => 'required',
        'hostel_name'       => 'required',
        'room_number'       => 'required',
        'admission_date'    => 'required|valid_date'
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

    public function getStudentWithUser($id)
    {
        return $this->select('students.*, users.name, users.email')
                    ->join('users', 'users.id = students.user_id')
                    ->where('students.id', $id)
                    ->first();
    }

    public function getActiveStudents()
    {
        return $this->select('students.*, users.name, users.email')
                    ->join('users', 'users.id = students.user_id')
                    ->where('students.status', 'active')
                    ->findAll();
    }

    public function searchStudents($keyword)
    {
        return $this->select('students.*, users.name, users.email')
                    ->join('users', 'users.id = students.user_id')
                    ->groupStart()
                        ->like('users.name', $keyword)
                        ->orLike('students.student_id', $keyword)
                        ->orLike('students.enrollment_number', $keyword)
                        ->orLike('students.mobile', $keyword)
                    ->groupEnd()
                    ->findAll();
    }

    public function getStudentByUserId($userId)
    {
        return $this->select('students.*, users.name, users.email')
                    ->join('users', 'users.id = students.user_id')
                    ->where('students.user_id', $userId)
                    ->first();
    }
}