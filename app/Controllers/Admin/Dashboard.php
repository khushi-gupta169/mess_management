<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;

class Dashboard extends BaseController
{
    public function index()
    {

// Check if admin is logged in
if (!session()->get('isLoggedIn') || session()->get('role') !== 'admin') {
    return redirect()->to('/admin/login');
}

        // Get dashboard statistics
        $data = [
            'title' => 'Dashboard',
            'total_students' => $this->getTotalStudents(),
            'active_students' => $this->getActiveStudents(),
            'students_on_leave' => $this->getStudentsOnLeave(),
            'today_breakfast' => $this->getTodayMealCount('breakfast'),
            'today_lunch' => $this->getTodayMealCount('lunch'),
            'today_dinner' => $this->getTodayMealCount('dinner'),
            'monthly_collection' => $this->getMonthlyCollection(),
            'payment_due' => $this->getPaymentDue(),
            'pending_leaves' => $this->getPendingLeaves(),
            'pending_complaints' => $this->getPendingComplaints(),
            'recent_students' => $this->getRecentStudents(),
            'recent_complaints' => $this->getRecentComplaints(),
        ];

        return view('admin/dashboard', $data);
    }

    // Helper methods for statistics
    private function getTotalStudents()
    {
        $db = \Config\Database::connect();
        return $db->table('students')->countAllResults();
    }

    private function getActiveStudents()
    {
        $db = \Config\Database::connect();
        return $db->table('students')->where('status', 'active')->countAllResults();
    }

    private function getStudentsOnLeave()
    {
        $db = \Config\Database::connect();
        return $db->table('leave_requests')
            ->where('status', 'approved')
            ->where('from_date <=', date('Y-m-d'))
            ->where('to_date >=', date('Y-m-d'))
            ->countAllResults();
    }

    private function getTodayMealCount($meal_type)
    {
        $db = \Config\Database::connect();
        return $db->table('food_attendance')
            ->where('meal_type', $meal_type)
            ->where('date', date('Y-m-d'))
            ->countAllResults();
    }

    private function getMonthlyCollection()
    {
        $db = \Config\Database::connect();
        $result = $db->table('payment_transactions')
            ->selectSum('amount')
            ->where('MONTH(payment_date)', date('m'))
            ->where('YEAR(payment_date)', date('Y'))
            ->get()
            ->getRow();
        return $result->amount ?? 0;
    }

private function getPaymentDue()
{
    $db = \Config\Database::connect();
    $result = $db->table('payments')
        ->selectSum('amount')
        ->where('status', 'completed')
        ->get()
        ->getRow();
    return $result->amount ?? 0;
}

    private function getPendingLeaves()
    {
        $db = \Config\Database::connect();
        return $db->table('leave_requests')
            ->where('status', 'pending')
            ->countAllResults();
    }

    private function getPendingComplaints()
    {
        $db = \Config\Database::connect();
        return $db->table('complaints')
            ->where('status', 'pending')
            ->countAllResults();
    }

private function getRecentStudents($limit = 5)
{
    $db = \Config\Database::connect();
    return $db->table('students')
        ->select('students.*, users.name')
        ->join('users', 'users.id = students.user_id')
        ->orderBy('students.admission_date', 'DESC')
        ->limit($limit)
        ->get()
        ->getResultArray();
}

private function getRecentComplaints($limit = 5)
{
    $db = \Config\Database::connect();
    return $db->table('complaints')
        ->join('students', 'students.id = complaints.student_id')
        ->join('users', 'users.id = students.user_id')
        ->select('complaints.*, users.name as student_name')
        ->orderBy('complaints.created_at', 'DESC')
        ->limit($limit)
        ->get()
        ->getResultArray();
}
}