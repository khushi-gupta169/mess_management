<?= $this->extend('admin/layouts/main') ?>

<?= $this->section('content') ?>

<!-- Page Header -->
<div class="page-header mb-4">
    <div class="row align-items-center">
        <div class="col-md-6">
            <h2 class="page-title mb-0"><i class="fas fa-chart-line me-2"></i>Reports Overview</h2>
            <p class="text-muted mb-0">Comprehensive analytics for your hostel</p>
        </div>
    </div>
</div>

<!-- Stat Cards Row 1 -->
<div class="row g-4 mb-4">
    <div class="col-xl-3 col-lg-6">
        <div class="stat-card">
            <div class="stat-card-body">
                <div class="d-flex align-items-center justify-content-between">
                    <div>
                        <p class="stat-label">Total Students</p>
                        <h3 class="stat-value"><?= $totalStudents ?></h3>
                        <span class="badge bg-primary-subtle text-primary"><?= $activeStudents ?> active</span>
                    </div>
                    <div class="stat-icon bg-primary-subtle text-primary"><i class="fas fa-users"></i></div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-xl-3 col-lg-6">
        <div class="stat-card">
            <div class="stat-card-body">
                <div class="d-flex align-items-center justify-content-between">
                    <div>
                        <p class="stat-label">Today's Collection</p>
                        <h3 class="stat-value text-success">₹<?= number_format($todayCollection, 2) ?></h3>
                        <span class="badge bg-success-subtle text-success">Monthly: ₹<?= number_format($monthlyCollection, 2) ?></span>
                    </div>
                    <div class="stat-icon bg-success-subtle text-success"><i class="fas fa-coins"></i></div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-xl-3 col-lg-6">
        <div class="stat-card">
            <div class="stat-card-body">
                <div class="d-flex align-items-center justify-content-between">
                    <div>
                        <p class="stat-label">Total Billed</p>
                        <h3 class="stat-value text-info">₹<?= number_format($totalBilled, 2) ?></h3>
                        <span class="badge bg-info-subtle text-info">Collected: ₹<?= number_format($totalPaid, 2) ?></span>
                    </div>
                    <div class="stat-icon bg-info-subtle text-info"><i class="fas fa-file-invoice-dollar"></i></div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-xl-3 col-lg-6">
        <div class="stat-card">
            <div class="stat-card-body">
                <div class="d-flex align-items-center justify-content-between">
                    <div>
                        <p class="stat-label">Pending Dues</p>
                        <h3 class="stat-value text-danger">₹<?= number_format($totalPending, 2) ?></h3>
                        <span class="badge bg-danger-subtle text-danger"><?= $pendingFees ?> records</span>
                    </div>
                    <div class="stat-icon bg-danger-subtle text-danger"><i class="fas fa-exclamation-triangle"></i></div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Stat Cards Row 2 -->
<div class="row g-4 mb-4">
    <div class="col-xl-3 col-lg-6">
        <div class="stat-card">
            <div class="stat-card-body">
                <div class="d-flex align-items-center justify-content-between">
                    <div>
                        <p class="stat-label">Total Collections</p>
                        <h3 class="stat-value text-success">₹<?= number_format($totalCollection, 2) ?></h3>
                        <span class="badge bg-primary-subtle text-primary"><?= $totalPayments ?> transactions</span>
                    </div>
                    <div class="stat-icon bg-success-subtle text-success"><i class="fas fa-wallet"></i></div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-xl-3 col-lg-6">
        <div class="stat-card">
            <div class="stat-card-body">
                <div class="d-flex align-items-center justify-content-between">
                    <div>
                        <p class="stat-label">Extra Meals (Monthly)</p>
                        <h3 class="stat-value text-warning">₹<?= number_format($monthlyExtraMealRevenue, 2) ?></h3>
                        <span class="badge bg-warning-subtle text-warning"><?= $approvedExtraMeals ?> approved</span>
                    </div>
                    <div class="stat-icon bg-warning-subtle text-warning"><i class="fas fa-hamburger"></i></div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-xl-3 col-lg-6">
        <div class="stat-card">
            <div class="stat-card-body">
                <div class="d-flex align-items-center justify-content-between">
                    <div>
                        <p class="stat-label">Fee Records</p>
                        <h3 class="stat-value"><?= $feePaidCount + $feePartialCount + $feePendingCount ?></h3>
                        <span class="badge bg-success-subtle text-success">Paid <?= $feePaidCount ?></span>
                        <span class="badge bg-danger-subtle text-danger">Pending <?= $feePendingCount ?></span>
                    </div>
                    <div class="stat-icon bg-info-subtle text-info"><i class="fas fa-receipt"></i></div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-xl-3 col-lg-6">
        <div class="stat-card">
            <div class="stat-card-body">
                <div class="d-flex align-items-center justify-content-between">
                    <div>
                        <p class="stat-label">Upcoming Holidays</p>
                        <h3 class="stat-value" style="color:#6f42c1"><?= count($upcomingHolidays) ?></h3>
                        <span class="badge bg-secondary-subtle text-secondary"><?= count($upcomingHolidays) ?> upcoming</span>
                    </div>
                    <div class="stat-icon" style="background:#f3e8ff;color:#6f42c1;"><i class="fas fa-calendar-alt"></i></div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Charts Row -->
<div class="row g-4 mb-4">
    <div class="col-lg-8">
        <div class="card border-0 shadow-sm">
            <div class="card-header bg-white py-3">
                <h5 class="mb-0"><i class="fas fa-chart-bar me-2 text-primary"></i>Monthly Payment Collection (Last 6 Months)</h5>
            </div>
            <div class="card-body">
                <canvas id="monthlyCollectionChart" height="300"></canvas>
            </div>
        </div>
    </div>
    <div class="col-lg-4">
        <div class="card border-0 shadow-sm">
            <div class="card-header bg-white py-3">
                <h5 class="mb-0"><i class="fas fa-chart-pie me-2 text-success"></i>Payment Methods</h5>
            </div>
            <div class="card-body">
                <canvas id="paymentMethodChart" height="300"></canvas>
            </div>
        </div>
    </div>
</div>


<!-- Recent Payments Table -->
<div class="row g-4 mb-4">
    <div class="col-lg-7">
        <div class="card border-0 shadow-sm">
            <div class="card-header bg-white py-3 d-flex justify-content-between align-items-center">
                <h5 class="mb-0"><i class="fas fa-history me-2 text-info"></i>Recent Payments</h5>
                <a href="<?= base_url('admin/payments') ?>" class="btn btn-sm btn-outline-primary">View All</a>
            </div>
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-hover align-middle mb-0">
                        <thead class="table-light">
                            <tr><th>Student</th><th>Amount</th><th>Method</th><th>Date</th><th>Status</th></tr>
                        </thead>
                        <tbody>
                            <?php if (!empty($recentPayments)): ?>
                                <?php foreach ($recentPayments as $p): ?>
                                    <tr>
                                        <td><strong><?= esc($p['student_name'] ?? 'N/A') ?></strong><br><small class="text-muted"><?= esc($p['student_code'] ?? '') ?></small></td>
                                        <td class="fw-bold text-success">₹<?= number_format($p['amount'], 2) ?></td>
                                        <td><i class="fas fa-wallet me-1"></i><?= ucfirst($p['payment_method']) ?></td>
                                        <td><?= date('d M Y', strtotime($p['payment_date'])) ?></td>
                                        <td><span class="badge bg-<?= $p['status'] === 'completed' ? 'success' : 'warning' ?>"><?= ucfirst($p['status']) ?></span></td>
                                    </tr>
                                <?php endforeach; ?>
                            <?php else: ?>
                                <tr><td colspan="5" class="text-center py-4 text-muted">No payments recorded yet</td></tr>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
    <div class="col-lg-5">
        <div class="card border-0 shadow-sm">
            <div class="card-header bg-white py-3">
                <h5 class="mb-0"><i class="fas fa-calendar-alt me-2" style="color:#6f42c1"></i>Upcoming Holidays</h5>
            </div>
            <div class="card-body">
                <?php if (!empty($upcomingHolidays)): ?>
                    <?php foreach (array_slice($upcomingHolidays, 0, 5) as $h): ?>
                        <div class="d-flex align-items-center mb-3 pb-3 border-bottom">
                            <div class="me-3 text-center" style="min-width:50px">
                                <div class="fs-4 fw-bold text-primary"><?= date('d', strtotime($h['holiday_date'])) ?></div>
                                <div class="text-muted small"><?= date('M Y', strtotime($h['holiday_date'])) ?></div>
                            </div>
                            <div>
                                <h6 class="mb-0"><?= esc($h['title']) ?></h6>
                                <small class="text-muted"><?= esc($h['description'] ?? '') ?></small><br>
                                <span class="badge bg-<?= $h['meal_status'] === 'closed' ? 'danger-subtle text-danger' : 'success-subtle text-success' ?>">
                                    <?= $h['meal_status'] === 'closed' ? 'Meals Closed' : 'Meals Open' ?>
                                </span>
                            </div>
                        </div>
                    <?php endforeach; ?>
                <?php else: ?>
                    <p class="text-muted text-center mb-0">No upcoming holidays</p>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>


<!-- Quick Links -->
<div class="row g-4 mb-4">
    <div class="col-12">
        <div class="card border-0 shadow-sm">
            <div class="card-header bg-white py-3">
                <h5 class="mb-0"><i class="fas fa-link me-2 text-secondary"></i>Detailed Reports</h5>
            </div>
            <div class="card-body">
                <div class="row g-3">
                    <div class="col-md-4">
                        <a href="<?= base_url('admin/reports/students') ?>" class="btn btn-outline-primary w-100 py-3">
                            <i class="fas fa-user-graduate fa-2x mb-2 d-block"></i>
                            <strong>Student Reports</strong>
                        </a>
                    </div>
                    <div class="col-md-4">
                        <a href="<?= base_url('admin/reports/payments') ?>" class="btn btn-outline-success w-100 py-3">
                            <i class="fas fa-rupee-sign fa-2x mb-2 d-block"></i>
                            <strong>Payment Reports</strong>
                        </a>
                    </div>
                    <div class="col-md-4">
                        <a href="<?= base_url('admin/reports/extra-meals') ?>" class="btn btn-outline-warning w-100 py-3">
                            <i class="fas fa-hamburger fa-2x mb-2 d-block"></i>
                            <strong>Extra Meal Reports</strong>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<style>.text-purple { color: #6f42c1 !important; }</style>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Monthly Collection Bar Chart
    const monthlyCtx = document.getElementById('monthlyCollectionChart');
    if (monthlyCtx) {
        new Chart(monthlyCtx, {
            type: 'bar',
            data: {
                labels: <?= json_encode($monthlyLabels) ?>,
                datasets: [{
                    label: 'Collection (₹)',
                    data: <?= json_encode($monthlyData) ?>,
                    backgroundColor: 'rgba(13, 110, 253, 0.7)',
                    borderColor: 'rgba(13, 110, 253, 1)',
                    borderWidth: 1,
                    borderRadius: 6
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                scales: { y: { beginAtZero: true, ticks: { callback: v => '₹' + v.toLocaleString('en-IN') } } },
                plugins: { legend: { display: false } }
            }
        });
    }

    // Payment Methods Doughnut Chart
    const methodCtx = document.getElementById('paymentMethodChart');
    if (methodCtx) {
        const methodData = <?= json_encode($paymentMethods) ?>;
        if (methodData.length > 0) {
            const colors = ['#0d6efd', '#198754', '#ffc107', '#dc3545', '#6f42c1'];
            new Chart(methodCtx, {
                type: 'doughnut',
                data: {
                    labels: methodData.map(m => m.payment_method.charAt(0).toUpperCase() + m.payment_method.slice(1)),
                    datasets: [{
                        data: methodData.map(m => parseFloat(m.total)),
                        backgroundColor: colors.slice(0, methodData.length),
                        borderWidth: 2
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        legend: { position: 'bottom' },
                        tooltip: { callbacks: { label: ctx => ctx.label + ': ₹' + ctx.parsed.toLocaleString('en-IN') } }
                    }
                }
            });
        }
    }
});
</script>

<?= $this->endSection() ?>