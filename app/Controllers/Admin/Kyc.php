<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\KycDocumentModel;
use App\Models\StudentModel;

class Kyc extends BaseController
{
    protected $kycModel;
    protected $studentModel;

    public function __construct()
    {
        $this->kycModel = new KycDocumentModel();
        $this->studentModel = new StudentModel();
    }

    public function index()
    {
        if (!session()->get('isLoggedIn') || session()->get('role') !== 'admin') {
            return redirect()->to('/admin/login');
        }

        $db = \Config\Database::connect();
        $documents = $db->table('kyc_documents')
            ->select('kyc_documents.*, students.student_id, users.name as student_name, users.email')
            ->join('students', 'students.id = kyc_documents.student_id')
            ->join('users', 'users.id = students.user_id')
            ->orderBy('kyc_documents.created_at', 'DESC')
            ->get()
            ->getResultArray();

        $data = [
            'title' => 'KYC Documents Management',
            'documents' => $documents
        ];

        return view('admin/kyc/index', $data);
    }

    public function view($id)
    {
        if (!session()->get('isLoggedIn') || session()->get('role') !== 'admin') {
            return redirect()->to('/admin/login');
        }

        $db = \Config\Database::connect();
        $document = $db->table('kyc_documents')
            ->select('kyc_documents.*, students.student_id, students.mobile, users.name as student_name, users.email')
            ->join('students', 'students.id = kyc_documents.student_id')
            ->join('users', 'users.id = students.user_id')
            ->where('kyc_documents.id', $id)
            ->get()
            ->getRowArray();

        if (!$document) {
            return redirect()->to('/admin/kyc')->with('error', 'Document not found!');
        }

        $data = [
            'title' => 'View KYC Document',
            'document' => $document
        ];

        return view('admin/kyc/view', $data);
    }




    public function approve($id)
    {
        if (!session()->get('isLoggedIn') || session()->get('role') !== 'admin') {
            return redirect()->to('/admin/login');
        }

        $document = $this->kycModel->find($id);

        if (!$document) {
            return redirect()->to('/admin/kyc')->with('error', 'Document not found!');
        }

        $adminId = session()->get('user_id');
        
        if ($this->kycModel->verifyDocument($id, $adminId, 'approved')) {
            return redirect()->to('/admin/kyc')->with('success', 'Document approved successfully!');
        }

        return redirect()->to('/admin/kyc')->with('error', 'Failed to approve document.');
    }

    public function reject($id)
    {
        if (!session()->get('isLoggedIn') || session()->get('role') !== 'admin') {
            return redirect()->to('/admin/login');
        }

        $document = $this->kycModel->find($id);

        if (!$document) {
            return redirect()->to('/admin/kyc')->with('error', 'Document not found!');
        }

        $reason = $this->request->getPost('reason');

        if (empty($reason)) {
            return redirect()->back()->with('error', 'Please provide a rejection reason.');
        }

        $adminId = session()->get('user_id');
        
        if ($this->kycModel->verifyDocument($id, $adminId, 'rejected', $reason)) {
            return redirect()->to('/admin/kyc')->with('success', 'Document rejected successfully!');
        }

        return redirect()->to('/admin/kyc')->with('error', 'Failed to reject document.');
    }
}
