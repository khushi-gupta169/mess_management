<?= $this->extend('admin/layouts/main') ?>

<?= $this->section('content') ?>

<!-- Page Header -->
<div class="page-header mb-4">
    <div class="row align-items-center">
        <div class="col-md-6">
            <h2 class="page-title mb-0">
                <i class="fas fa-tachometer-alt me-2"></i>Dashboard
            </h2>
            <p class="text-muted mb-0">Welcome to Hostel Mess Management System</p>
        </div>
        <div class="col-md-6 text-md-end">
            <div class="btn-group" role="group">
                <button type="button" class="btn btn-outline-primary">
                    <i class="fas fa-download me-1"></i>Export
                </button>
                <button type="button" class="btn btn-outline-primary">
                    <i class="fas fa-print me-1"></i>Print
                </button>
            </div>
        </div>
    </div>
</div>

<!-- Statistics Cards -->
<div class="row g-4 mb-4">
    <!-- Total Students -->
    <div class="col-xl-3 col-lg-6 col-md-6">
        <div class="stat-card">
            <div class="stat-card-body">
                <div class="d-flex align-items-center justify-content-between">
                    <div>
                        <p class="stat-label">Total Students</p>
                        <h3 class="stat-value"><?= $total_students ?></h3>
                        <span class="badge bg-primary-subtle text-primary">All students</span>
                    </div>
                    <div class="stat-icon bg-primary-subtle text-primary">
                        <i class="fas fa-users"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Active Students -->
    <div class="col-xl-3 col-lg-6 col-md-6">
        <div class="stat-card">
            <div class="stat-card-body">
                <div class="d-flex align-items-center justify-content-between">
                    <div>
                        <p class="stat-label">Active Students</p>
                        <h3 class="stat-value text-success"><?= $active_students ?></h3>
                        <span class="badge bg-success-subtle text-success">
                            <i class="fas fa-arrow-up me-1"></i>Currently active
                        </span>
                    </div>
                    <div class="stat-icon bg-success-subtle text-success">
                        <i class="fas fa-user-check"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Students on Leave -->
    <div class="col-xl-3 col-lg-6 col-md-6">
        <div class="stat-card">
            <div class="stat-card-body">
                <div class="d-flex align-items-center justify-content-between">
                    <div>
                        <p class="stat-label">On Leave Today</p>
                        <h3 class="stat-value text-warning"><?= $students_on_leave ?></h3>
                        <span class="badge bg-warning-subtle text-warning">Approved leave</span>
                    </div>
                    <div class="stat-icon bg-warning-subtle text-warning">
                        <i class="fas fa-user-clock"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Pending Complaints -->
    <div class="col-xl-3 col-lg-6 col-md-6">
        <div class="stat-card">
            <div class="stat-card-body">
                <div class="d-flex align-items-center justify-content-between">
                    <div>
                        <p class="stat-label">Pending Complaints</p>
                        <h3 class="stat-value text-danger"><?= $pending_complaints ?></h3>
                        <span class="badge bg-danger-subtle text-danger">Need attention</span>
                    </div>
                    <div class="stat-icon bg-danger-subtle text-danger">
                        <i class="fas fa-exclamation-triangle"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Today's Meal Stats -->
<div class="row g-4 mb-4">
    <div class="col-lg-8">
        <div class="card border-0 shadow-sm">
            <div class="card-header bg-white border-0 py-3">
                <div class="d-flex align-items-center justify-content-between">
                    <h5 class="mb-0">
                        <i class="fas fa-utensils me-2 text-primary"></i>Today's Meal Attendance
                    </h5>
                    <span class="badge bg-primary"><?= date('l, F d, Y') ?></span>
                </div>
            </div>
            <div class="card-body">
                <div class="row g-3">
                    <!-- Breakfast -->
                    <div class="col-md-4">
                        <div class="meal-stat-card breakfast">
                            <div class="meal-icon">
                                <i class="fas fa-coffee"></i>
                            </div>
                            <div class="meal-info">
                                <h6 class="meal-title">Breakfast</h6>
                                <div class="meal-count"><?= $today_breakfast ?></div>
                                <small class="text-muted">of <?= $active_students - $students_on_leave ?> expected</small>
                                <div class="progress mt-2" style="height: 6px;">
                                    <?php $breakfast_percent = ($active_students - $students_on_leave) > 0 ? ($today_breakfast / ($active_students - $students_on_leave) * 100) : 0; ?>
                                    <div class="progress-bar bg-info" style="width: <?= $breakfast_percent ?>%"></div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Lunch -->
                    <div class="col-md-4">
                        <div class="meal-stat-card lunch">
                            <div class="meal-icon">
                                <i class="fas fa-hamburger"></i>
                            </div>
                            <div class="meal-info">
                                <h6 class="meal-title">Lunch</h6>
                                <div class="meal-count"><?= $today_lunch ?></div>
                                <small class="text-muted">of <?= $active_students - $students_on_leave ?> expected</small>
                                <div class="progress mt-2" style="height: 6px;">
                                    <?php $lunch_percent = ($active_students - $students_on_leave) > 0 ? ($today_lunch / ($active_students - $students_on_leave) * 100) : 0; ?>
                                    <div class="progress-bar bg-success" style="width: <?= $lunch_percent ?>%"></div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Dinner -->
                    <div class="col-md-4">
                        <div class="meal-stat-card dinner">
                            <div class="meal-icon">
                                <i class="fas fa-pizza-slice"></i>
                            </div>
                            <div class="meal-info">
                                <h6 class="meal-title">Dinner</h6>
                                <div class="meal-count"><?= $today_dinner ?></div>
                                <small class="text-muted">of <?= $active_students - $students_on_leave ?> expected</small>
                                <div class="progress mt-2" style="height: 6px;">
                                    <?php $dinner_percent = ($active_students - $students_on_leave) > 0 ? ($today_dinner / ($active_students - $students_on_leave) * 100) : 0; ?>
                                    <div class="progress-bar bg-warning" style="width: <?= $dinner_percent ?>%"></div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Payment Summary -->
    <div class="col-lg-4">
        <div class="card border-0 shadow-sm h-100">
            <div class="card-header bg-white border-0 py-3">
                <h5 class="mb-0">
                    <i class="fas fa-rupee-sign me-2 text-success"></i>Payment Summary
                </h5>
            </div>
            <div class="card-body">
                <div class="payment-summary">
                    <div class="payment-item">
                        <div class="d-flex align-items-center justify-content-between mb-3">
                            <span class="text-muted">Monthly Collection</span>
                            <h4 class="mb-0 text-success">₹<?= number_format($monthly_collection, 2) ?></h4>
                        </div>
                        <div class="progress" style="height: 8px;">
                            <div class="progress-bar bg-success" style="width: 75%"></div>
                        </div>
                    </div>
                    
                    <hr>
                    
                    <div class="payment-item">
                        <div class="d-flex align-items-center justify-content-between mb-3">
                            <span class="text-muted">Total Due</span>
                            <h4 class="mb-0 text-danger">₹<?= number_format($payment_due, 2) ?></h4>
                        </div>
                        <div class="progress" style="height: 8px;">
                            <div class="progress-bar bg-danger" style="width: 25%"></div>
                        </div>
                    </div>

                    <hr>

                    <div class="payment-item">
                        <div class="d-flex align-items-center justify-content-between">
                            <span class="text-muted">Collection Rate</span>
                            <?php 
                                $total_expected = $active_students * 3500; // Assuming ₹3500 per student
                                $collection_rate = $total_expected > 0 ? ($monthly_collection / $total_expected * 100) : 0;
                            ?>
                            <h5 class="mb-0 text-primary"><?= number_format($collection_rate, 1) ?>%</h5>
                        </div>
                    </div>
                </div>
                
                <div class="mt-3">
                    <a href="<?= base_url('admin/payments') ?>" class="btn btn-primary w-100">
                        <i class="fas fa-eye me-1"></i>View All Payments
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Recent Activity -->
<div class="row g-4">
    <!-- Recent Students -->
    <div class="col-lg-6">
        <div class="card border-0 shadow-sm">
            <div class="card-header bg-white border-0 py-3">
                <div class="d-flex align-items-center justify-content-between">
                    <h5 class="mb-0">
                        <i class="fas fa-user-graduate me-2 text-primary"></i>Recent Students
                    </h5>
                    <a href="<?= base_url('admin/students') ?>" class="btn btn-sm btn-outline-primary">View All</a>
                </div>
            </div>
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-hover mb-0">
                        <thead class="table-light">
                            <tr>
                                <th>Student</th>
                                <th>Room</th>
                                <th>Joining Date</th>
                                <th>Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if (!empty($recent_students)): ?>
                                <?php foreach ($recent_students as $student): ?>
                                    <tr>
                                        <td>
                                            <div class="d-flex align-items-center">
                                                <div class="avatar-sm me-2">
                                                    <div class="avatar-title bg-primary-subtle text-primary rounded-circle">
                                                        <?= strtoupper(substr($student['name'], 0, 1)) ?>
                                                    </div>
                                                </div>
                                                <div>
                                                    <h6 class="mb-0"><?= esc($student['name']) ?></h6>
                                                    <small class="text-muted"><?= esc($student['student_id']) ?></small>
                                                </div>
                                            </div>
                                        </td>
                                        <td><?= esc($student['room_number']) ?></td>
                                        <td><?= date('d M, Y', strtotime($student['admission_date'])) ?></td>
                                        <td>
                                            <span class="badge bg-<?= $student['status'] == 'active' ? 'success' : 'secondary' ?>">
                                                <?= ucfirst($student['status']) ?>
                                            </span>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            <?php else: ?>
                                <tr>
                                    <td colspan="4" class="text-center py-4 text-muted">No students found</td>
                                </tr>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <!-- Recent Complaints -->
    <div class="col-lg-6">
        <div class="card border-0 shadow-sm">
            <div class="card-header bg-white border-0 py-3">
                <div class="d-flex align-items-center justify-content-between">
                    <h5 class="mb-0">
                        <i class="fas fa-comments me-2 text-warning"></i>Recent Complaints
                    </h5>
                    <a href="<?= base_url('admin/complaints') ?>" class="btn btn-sm btn-outline-warning">View All</a>
                </div>
            </div>
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-hover mb-0">
                        <thead class="table-light">
                            <tr>
                                <th>Student</th>
                                <th>Type</th>
                                <th>Subject</th>
                                <th>Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if (!empty($recent_complaints)): ?>
                                <?php foreach ($recent_complaints as $complaint): ?>
                                    <tr>
                                        <td>
                                            <div class="d-flex align-items-center">
                                                <div class="avatar-sm me-2">
                                                    <div class="avatar-title bg-warning-subtle text-warning rounded-circle">
                                                        <?= strtoupper(substr($complaint['student_name'], 0, 1)) ?>
                                                    </div>
                                                </div>
                                                <span><?= esc($complaint['student_name']) ?></span>
                                            </div>
                                        </td>
                                        <td><small><?= esc($complaint['complaint_type']) ?></small></td>
                                        <td><small><?= esc(substr($complaint['subject'], 0, 30)) ?>...</small></td>
                                        <td>
                                            <?php 
                                                $status_colors = [
                                                    'pending' => 'warning',
                                                    'in_progress' => 'info',
                                                    'resolved' => 'success',
                                                    'rejected' => 'danger'
                                                ];
                                                $color = $status_colors[$complaint['status']] ?? 'secondary';
                                            ?>
                                            <span class="badge bg-<?= $color ?>">
                                                <?= ucfirst(str_replace('_', ' ', $complaint['status'])) ?>
                                            </span>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            <?php else: ?>
                                <tr>
                                    <td colspan="4" class="text-center py-4 text-muted">No complaints found</td>
                                </tr>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Pending Actions -->
<div class="row g-4 mt-2">
    <div class="col-12">
        <div class="card border-0 shadow-sm">
            <div class="card-header bg-white border-0 py-3">
                <h5 class="mb-0">
                    <i class="fas fa-tasks me-2 text-info"></i>Pending Actions
                </h5>
            </div>
            <div class="card-body">
                <div class="row g-3">
                    <!-- Pending Leaves -->
                    <div class="col-md-4">
                        <div class="action-card">
                            <div class="action-icon bg-warning-subtle text-warning">
                                <i class="fas fa-clock"></i>
                            </div>
                            <div class="action-content">
                                <h6>Pending Leave Requests</h6>
                                <p class="mb-2"><strong><?= $pending_leaves ?></strong> requests waiting</p>
                                <a href="<?= base_url('admin/leave') ?>" class="btn btn-sm btn-warning">
                                    <i class="fas fa-eye me-1"></i>Review
                                </a>
                            </div>
                        </div>
                    </div>

                    <!-- Payment Due -->
                    <div class="col-md-4">
                        <div class="action-card">
                            <div class="action-icon bg-danger-subtle text-danger">
                                <i class="fas fa-rupee-sign"></i>
                            </div>
                            <div class="action-content">
                                <h6>Payment Collections</h6>
                                <p class="mb-2"><strong>₹<?= number_format($payment_due, 2) ?></strong> pending</p>
                                <a href="<?= base_url('admin/payments') ?>" class="btn btn-sm btn-danger">
                                    <i class="fas fa-arrow-right me-1"></i>Collect
                                </a>
                            </div>
                        </div>
                    </div>

                    <!-- Pending Complaints -->
                    <div class="col-md-4">
                        <div class="action-card">
                            <div class="action-icon bg-info-subtle text-info">
                                <i class="fas fa-exclamation-circle"></i>
                            </div>
                            <div class="action-content">
                                <h6>Complaints to Handle</h6>
                                <p class="mb-2"><strong><?= $pending_complaints ?></strong> unresolved</p>
                                <a href="<?= base_url('admin/complaints') ?>" class="btn btn-sm btn-info">
                                    <i class="fas fa-reply me-1"></i>Respond
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<?= $this->endSection() ?>