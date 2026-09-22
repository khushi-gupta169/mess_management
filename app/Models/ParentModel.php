<?php

namespace App\Models;

use CodeIgniter\Model;

class ParentModel extends Model
{
    protected $table            = 'parents';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields    = [
        'student_id', 'father_name', 'father_mobile', 'father_occupation',
        'mother_name', 'mother_mobile', 'mother_occupation', 'guardian_name',
        'guardian_mobile', 'relationship', 'address'
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
        'father_name'     => 'required|min_length[3]|max_length[100]',
        'father_mobile'   => 'required|min_length[10]|max_length[15]',
        'mother_name'     => 'required|min_length[3]|max_length[100]',
        'mother_mobile'   => 'required|min_length[10]|max_length[15]',
        'address'         => 'required'
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

    public function getParentByStudentId($studentId)
    {
        return $this->where('student_id', $studentId)->first();
    }
}