<?= $this->extend('student/layouts/main') ?>
<?= $this->section('content') ?>
<div class="row mb-4">
    <div class="col-md-3 mb-3">
        <div class="card stat-card h-100"><div class="card-body"><div class="d-flex align-items-center"><div class="flex-shrink-0 me-3"><div class="bg-success bg-opacity-10 rounded-circle p-3"><i class="bi bi-check-circle text-success fs-4"></i></div></div><div><p class="text-muted mb-0 small">Total Paid</p><h4 class="mb-0 text-success">₹<?= number_format($totalPaid, 2) ?></h4></div></div></div></div>
    </div>
    <div class="col-md-3 mb-3">
        <div class="card stat-card h-100"><div class="card-body"><div class="d-flex align-items-center"><div class="flex-shrink-0 me-3"><div class="bg-warning bg-opacity-10 rounded-circle p-3"><i class="bi bi-hourglass-split text-warning fs-4"></i></div></div><div><p class="text-muted mb-0 small">Total Pending</p><h4 class="mb-0 text-warning">₹<?= number_format($totalPending, 2) ?></h4></div></div></div></div>
    </div>
    <div class="col-md-3 mb-3">
        <div class="card stat-card h-100"><div class="card-body"><div class="d-flex align-items-center"><div class="flex-shrink-0 me-3"><div class="bg-primary bg-opacity-10 rounded-circle p-3"><i class="bi bi-receipt text-primary fs-4"></i></div></div><div><p class="text-muted mb-0 small">Total Bills</p><h4 class="mb-0 text-primary"><?= count($feeRecords) ?></h4></div></div></div></div>
    </div>
    <div class="col-md-3 mb-3">
        <div class="card stat-card h-100"><div class="card-body"><div class="d-flex align-items-center"><div class="flex-shrink-0 me-3"><div class="bg-info bg-opacity-10 rounded-circle p-3"><i class="bi bi-credit-card text-info fs-4"></i></div></div><div><p class="text-muted mb-0 small">Transactions</p><h4 class="mb-0 text-info"><?= count($payments) ?></h4></div></div></div></div>
    </div>
</div>
<div class="card stat-card mb-4">
    <div class="card-header bg-white py-3"><h5 class="mb-0"><i class="bi bi-receipt me-2 text-primary"></i>Fee Records</h5></div>
    <div class="card-body">
        <?php if (!empty($feeRecords)): ?>
        <div class="table-responsive">
            <table class="table table-hover align-middle">
                <thead class="table-light"><tr><th>Month/Year</th><th>Base</th><th>Extra Meal</th><th>Other</th><th>Total</th><th>Paid</th><th>Pending</th><th>Status</th></tr></thead>
                <tbody>
                <?php $mn = ['','January','February','March','April','May','June','July','August','September','October','November','December']; ?>
                <?php foreach ($feeRecords as $fee): ?>
                <tr>
                    <td><strong><?= $mn[$fee['month']] ?? $fee['month'] ?></strong><br><small class="text-muted"><?= esc($fee['year']) ?></small></td>
                    <td>₹<?= number_format($fee['base_amount'], 2) ?></td>
                    <td>₹<?= number_format($fee['extra_meal_amount'], 2) ?></td>
                    <td>₹<?= number_format($fee['other_amount'], 2) ?></td>
                    <td><strong>₹<?= number_format($fee['total_amount'], 2) ?></strong></td>
                    <td class="text-success">₹<?= number_format($fee['paid_amount'], 2) ?></td>
                    <td class="text-<?= $fee['pending_amount']>0?'danger':'success' ?>">₹<?= number_format($fee['pending_amount'], 2) ?></td>
                    <td>
                        <?php if ($fee['status']==='paid'): ?><span class="badge bg-success"><i class="bi bi-check-circle me-1"></i>Paid</span>
                        <?php elseif ($fee['status']==='partial'):?><span class="badge bg-warning text-dark"><i class="bi bi-hourglass-split me-1"></i>Partial</span>
                        <?php else:?><span class="badge bg-danger"><i class="bi bi-exclamation-circle me-1"></i>Pending</span><?php endif;?>
                    </td>
                </tr>
                <?php endforeach; ?>
                </tbody>
            </table>
        </div>
        <?php else: ?>
        <div class="text-center py-5"><i class="bi bi-receipt text-muted" style="font-size:3rem;"></i><h5 class="mt-3 text-muted">No fee records found</h5></div>
        <?php endif; ?>
    </div>
</div>
<div class="card stat-card mb-4">
    <div class="card-header bg-white py-3"><h5 class="mb-0"><i class="bi bi-clock-history me-2 text-primary"></i>Payment History</h5></div>
    <div class="card-body">
        <?php if (!empty($payments)): ?>
        <div class="table-responsive">
            <table class="table table-hover align-middle">
                <thead class="table-light"><tr><th>Date</th><th>Receipt No.</th><th>Amount</th><th>Method</th><th>Status</th></tr></thead>
                <tbody>
                <?php foreach ($payments as $pmt): ?>
                <tr>
                    <td><?= date('d M Y', strtotime($pmt['payment_date'])) ?></td>
                    <td><code><?= esc($pmt['receipt_number']) ?></code></td>
                    <td><strong class="text-success">₹<?= number_format($pmt['amount'], 2) ?></strong></td>
                    <td><span class="badge bg-light text-dark">
                        <?php if($pmt['payment_method']==='upi'):?><i class="bi bi-phone me-1"></i>UPI
                        <?php elseif($pmt['payment_method']==='online'):?><i class="bi bi-globe me-1"></i>Online
                        <?php elseif($pmt['payment_method']==='card'):?><i class="bi bi-credit-card me-1"></i>Card
                        <?php else:?><i class="bi bi-cash me-1"></i>Cash<?php endif;?>
                    </span></td>
                    <td>
                        <?php if ($pmt['status']==='completed'):?><span class="badge bg-success"><i class="bi bi-check-circle me-1"></i>Completed</span>
                        <?php elseif ($pmt['status']==='pending'):?><span class="badge bg-warning text-dark"><i class="bi bi-clock me-1"></i>Pending</span>
                        <?php else:?><span class="badge bg-danger"><i class="bi bi-x-circle me-1"></i>Failed</span><?php endif;?>
                    </td>
                </tr>
                <?php endforeach; ?>
                </tbody>
            </table>
        </div>
        <?php else: ?>
        <div class="text-center py-5"><i class="bi bi-credit-card text-muted" style="font-size:3rem;"></i><h5 class="mt-3 text-muted">No payment history</h5></div>
        <?php endif; ?>
    </div>
</div>
<?= $this->endSection() ?>