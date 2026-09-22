<?= $this->extend('student/layouts/main') ?>
<?= $this->section('content') ?>
<div class="mb-4"><p class="text-muted mb-0">Here's what's happening with your mess today</p></div>
<div class="row mb-4">
    <div class="col-md-3 mb-3">
        <div class="card stat-card gradient-purple"><div class="card-body"><div class="d-flex justify-content-between align-items-center"><div><h6 class="mb-0">Pending Amount</h6><h3 class="mb-0 mt-2">₹<?= number_format($pendingFees, 2) ?></h3></div><i class="bi bi-wallet2 fs-1"></i></div></div></div>
    </div>
    <div class="col-md-3 mb-3">
        <div class="card stat-card"><div class="card-body"><div class="d-flex justify-content-between align-items-center"><div><h6 class="text-muted mb-0">Extra Meals</h6><h3 class="mb-0 mt-2"><?= $extraMealCount ?></h3></div><i class="bi bi-plus-circle fs-1 text-info"></i></div></div></div>
    </div>
    <div class="col-md-3 mb-3">
        <div class="card stat-card"><div class="card-body"><div class="d-flex justify-content-between align-items-center"><div><h6 class="text-muted mb-0">Payments</h6><h3 class="mb-0 mt-2"><?= $paymentCount ?></h3></div><i class="bi bi-receipt fs-1 text-success"></i></div></div></div>
    </div>
    <div class="col-md-3 mb-3">
        <div class="card stat-card"><div class="card-body"><div class="d-flex justify-content-between align-items-center"><div><h6 class="text-muted mb-0">Hostel</h6><h6 class="mb-0 mt-2"><?= esc($student['hostel_name'] ?? 'N/A') ?></h6></div><i class="bi bi-building fs-1 text-warning"></i></div></div></div>
    </div>
</div>
<div class="row">
    <div class="col-md-8 mb-4">
        <div class="card stat-card">
            <div class="card-header bg-white border-0"><h5 class="mb-0"><i class="bi bi-calendar-day me-2"></i>Today's Menu</h5></div>
            <div class="card-body">
                <?php if (!empty($todayMenu) && !empty($todayMenu['items'])): $g = []; foreach ($todayMenu['items'] as $i) $g[$i['meal_type']][] = $i; ?>
                <div class="row">
                    <?php foreach (['breakfast','lunch','evening','dinner'] as $mt): ?>
                    <div class="col-md-6 mb-3">
                        <div class="p-3 bg-light rounded">
                            <h6 class="text-success mb-2"><i class="bi <?php if($mt==='breakfast'):?>bi-sunrise<?php elseif($mt==='lunch'):?>bi-sun<?php elseif($mt==='evening'):?>bi-cloud-sun<?php else:?>bi-moon-stars<?php endif;?> me-2"></i><?= ucfirst($mt) ?></h6>
                            <?php if (!empty($g[$mt])): ?><ul class="list-unstyled mb-0 small"><?php foreach ($g[$mt] as $item): ?><li><i class="bi bi-check-circle-fill text-success me-1" style="font-size:10px;"><?= esc($item['food_name']) ?></li><?php endforeach; ?></ul>
                            <?php else: ?><p class="mb-0 text-muted small">No items set</p><?php endif; ?>
                        </div>
                    </div>
                    <?php endforeach; ?>
                </div>
                <?php else: ?>
                <p class="text-muted text-center py-3">No menu set for today</p>
                <?php endif; ?>
            </div>
        </div>
    </div>
    <div class="col-md-4 mb-4">
        <div class="card stat-card">
            <div class="card-header bg-white border-0"><h5 class="mb-0"><i class="bi bi-lightning me-2"></i>Quick Actions</h5></div>
            <div class="card-body">
                <div class="d-grid gap-2">
                    <a href="<?= base_url('student/profile') ?>" class="btn btn-outline-primary"><i class="bi bi-person me-2"></i>My Profile</a>
                    <a href="<?= base_url('student/extra-meals') ?>" class="btn btn-outline-success"><i class="bi bi-plus-circle me-2"></i>Request Extra Meal</a>
                    <a href="<?= base_url('student/payments') ?>" class="btn btn-outline-info"><i class="bi bi-wallet2 me-2"></i>View Payments</a>
                    <a href="<?= base_url('student/menu') ?>" class="btn btn-outline-warning"><i class="bi bi-book me-2"></i>Full Menu</a>
                </div>
            </div>
        </div>
    </div>
</div>
<?= $this->endSection() ?>