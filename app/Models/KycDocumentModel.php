<?php

namespace App\Models;

use CodeIgniter\Model;

class KycDocumentModel extends Model
{
    protected $table            = 'kyc_documents';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields    = [
        'student_id', 'document_type', 'document_number', 'document_file',
        'verification_status', 'verified_by', 'verified_at', 'rejection_reason'
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
        'document_type'   => 'required|in_list[aadhaar,pan,passport,college_id,other]',
        'document_number' => 'required',
        'document_file'   => 'required'
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

    public function getDocumentsByStudentId($studentId)
    {
        return $this->where('student_id', $studentId)->findAll();
    }

    public function getPendingDocuments()
    {
        return $this->select('kyc_documents.*, students.student_id, users.name as student_name')
                    ->join('students', 'students.id = kyc_documents.student_id')
                    ->join('users', 'users.id = students.user_id')
                    ->where('kyc_documents.verification_status', 'pending')
                    ->findAll();
    }

    public function verifyDocument($id, $verifiedBy, $status, $reason = null)
    {
        $data = [
            'verification_status' => $status,
            'verified_by' => $verifiedBy,
            'verified_at' => date('Y-m-d H:i:s')
        ];

        if ($status === 'rejected' && $reason) {
            $data['rejection_reason'] = $reason;
        }

        return $this->update($id, $data);
    }
}