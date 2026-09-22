<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\StudentModel;
use App\Models\PaymentModel;
use App\Models\FeeRecordModel;
use App\Models\ExtraMealModel;
use App\Models\HolidayModel;

class Reports extends BaseController
{
    protected $studentModel;
    protected $paymentModel;
    protected $feeRecordModel;
    protected $extraMealModel;
    protected $holidayModel;

    public function __construct()
    {
        $this->studentModel   = new StudentModel();
        $this->paymentModel   = new PaymentModel();
        $this->feeRecordModel = new FeeRecordModel();
        $this->extraMealModel = new ExtraMealModel();
        $this->holidayModel   = new HolidayModel();
    }

    public function index()
    {
        if (!session()->get('isLoggedIn') || session()->get('role') !== 'admin') {
            return redirect()->to('/login');
        }

        $db = \Config\Database::connect();
        $currentMonth = (int) date('m');
        $currentYear  = (int) date('Y');

        // Student stats
        $totalStudents    = $db->table('students')->countAllResults();
        $activeStudents   = $db->table('students')->where('status', 'active')->countAllResults();
        $inactiveStudents = $totalStudents - $activeStudents;

        // Payment stats
        $todayCollection   = $this->paymentModel->getTodayCollection();
        $monthlyCollection = $this->paymentModel->getMonthlyCollection($currentMonth, $currentYear);
        $totalCollection   = (float) ($db->table('payments')->selectSum('amount')->where('status', 'completed')->get()->getRow()->amount ?? 0);
        $totalPayments     = $db->table('payments')->where('status', 'completed')->countAllResults();

        // Fee stats
        $totalBilled   = (float) ($db->table('fee_records')->selectSum('total_amount')->get()->getRow()->total_amount ?? 0);
        $totalPaid     = (float) ($db->table('fee_records')->selectSum('paid_amount')->get()->getRow()->paid_amount ?? 0);
        $totalPending  = (float) ($db->table('fee_records')->selectSum('pending_amount')->get()->getRow()->pending_amount ?? 0);
        $pendingFees   = $db->table('fee_records')->where('status !=', 'paid')->countAllResults();
        $feePaidCount  = $db->table('fee_records')->where('status', 'paid')->countAllResults();
        $feePartialCount = $db->table('fee_records')->where('status', 'partial')->countAllResults();
        $feePendingCount = $db->table('fee_records')->where('status', 'pending')->countAllResults();

        // Extra meal stats
        $approvedExtraMeals  = $db->table('extra_meals')->where('status', 'approved')->countAllResults();
        $pendingExtraMeals   = $db->table('extra_meals')->where('status', 'pending')->countAllResults();
        $monthlyExtraMealRevenue = (float) ($db->table('extra_meals')->selectSum('price')->where('status', 'approved')->where('MONTH(meal_date)', $currentMonth)->where('YEAR(meal_date)', $currentYear)->get()->getRow()->price ?? 0);

        // Holiday stats
        $upcomingHolidays = $this->holidayModel->getUpcomingHolidays();

        // Chart data - monthly collection (last 6 months)
        $monthlyLabels = [];
        $monthlyData   = [];
        for ($i = 5; $i >= 0; $i--) {
            $m = (int) date('m', strtotime("-{$i} months"));
            $y = (int) date('Y', strtotime("-{$i} months"));
            $monthlyLabels[] = date('M Y', mktime(0, 0, 0, $m, 1, $y));
            $monthlyData[]   = (float) $this->paymentModel->getMonthlyCollection($m, $y);
        }

        // Payment method breakdown
        $paymentMethods = $db->table('payments')
            ->select('payment_method, COUNT(*) as count, SUM(amount) as total')
            ->where('status', 'completed')
            ->groupBy('payment_method')
            ->get()->getResultArray();

        // Recent payments
        $recentPayments = $this->paymentModel
            ->select('payments.*, students.student_id as student_code, users.name as student_name')
            ->join('students', 'students.id = payments.student_id')
            ->join('users', 'users.id = students.user_id')
            ->orderBy('payments.created_at', 'DESC')
            ->limit(10)
            ->findAll();

        $data = [
            'title'                   => 'Reports Overview',
            'totalStudents'           => $totalStudents,
            'activeStudents'          => $activeStudents,
            'inactiveStudents'        => $inactiveStudents,
            'todayCollection'         => $todayCollection,
            'monthlyCollection'       => $monthlyCollection,
            'totalCollection'         => $totalCollection,
            'totalPayments'           => $totalPayments,
            'totalBilled'             => $totalBilled,
            'totalPaid'               => $totalPaid,
            'totalPending'            => $totalPending,
            'pendingFees'             => $pendingFees,
            'approvedExtraMeals'      => $approvedExtraMeals,
            'pendingExtraMeals'       => $pendingExtraMeals,
            'monthlyExtraMealRevenue' => $monthlyExtraMealRevenue,
            'upcomingHolidays'        => $upcomingHolidays,
            'monthlyLabels'           => $monthlyLabels,
            'monthlyData'             => $monthlyData,
            'paymentMethods'          => $paymentMethods,
            'recentPayments'          => $recentPayments,
            'feePaidCount'            => $feePaidCount,
            'feePartialCount'         => $feePartialCount,
            'feePendingCount'         => $feePendingCount,
        ];

        return view('admin/reports/index', $data);
    }
}