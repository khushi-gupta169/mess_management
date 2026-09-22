<?= $this->extend('admin/layouts/main') ?>

<?= $this->section('content') ?>

<!-- Page Header -->
<div class="page-header mb-4">
    <div class="row align-items-center">
        <div class="col-md-6">
            <h2 class="page-title mb-0"><i class="fas fa-rupee-sign me-2"></i>Payment Management</h2>
            <p class="text-muted mb-0">View payments and record new payments against pending fees</p>
        </div>
    </div>
</div>

<?php if (session()->getFlashdata('success')): ?>
    <div class="alert alert-success alert-dismissible fade show">
        <i class="fas fa-check-circle me-2"></i><?= session()->getFlashdata('success') ?>
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
<?php endif; ?>

<?php if (session()->getFlashdata('error')): ?>
    <div class="alert alert-danger alert-dismissible fade show">
        <i class="fas fa-exclamation-circle me-2"></i><?= session()->getFlashdata('error') ?>
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
<?php endif; ?>

<!-- Pending Fees Section -->
<div class="card border-0 shadow-sm mb-4">
    <div class="card-header bg-white py-3">
        <h5 class="mb-0"><i class="fas fa-exclamation-triangle text-warning me-2"></i>Pending Fee Records</h5>
    </div>
    <div class="card-body">
        <?php if (!empty($pendingFees)): ?>
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0" id="pendingFeesTable">
                    <thead class="table-light">
                        <tr>
                            <th>Student</th>
                            <th>Period</th>
                            <th>Total Amount</th>
                            <th>Paid</th>
                            <th>Pending</th>
                            <th>Status</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($pendingFees as $fee): ?>
                            <tr>
                                <td><strong><?= esc($fee['student_name'] ?? 'N/A') ?></strong></td>
                                <td><?= date('M Y', mktime(0, 0, 0, $fee['month'], 1, $fee['year'])) ?></td>
                                <td>₹<?= number_format($fee['total_amount'], 2) ?></td>
                                <td>₹<?= number_format($fee['paid_amount'], 2) ?></td>
                                <td class="text-danger fw-bold">₹<?= number_format($fee['pending_amount'], 2) ?></td>
                                <td>
                                    <?php if ($fee['status'] === 'paid'): ?>
                                        <span class="badge bg-success">Paid</span>
                                    <?php elseif ($fee['status'] === 'partial'): ?>
                                        <span class="badge bg-warning">Partial</span>
                                    <?php else: ?>
                                        <span class="badge bg-danger">Pending</span>
                                    <?php endif; ?>
                                </td>
                                <td>
                                    <button class="btn btn-outline-success btn-sm" onclick="openRecordPayment(<?= $fee['id'] ?>, <?= $fee['pending_amount'] ?>, '<?= esc($fee['student_name'] ?? 'N/A') ?>', '<?= date('M Y', mktime(0, 0, 0, $fee['month'], 1, $fee['year'])) ?>')">
                                        <i class="fas fa-plus-circle me-1"></i>Record Payment
                                    </button>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        <?php else: ?>
            <div class="text-center py-4 text-muted">
                <i class="fas fa-check-circle fa-2x mb-2 d-block text-success"></i>
                <p class="mb-0">No pending fee records.</p>
            </div>
        <?php endif; ?>
    </div>
</div>

<!-- Payment History Section -->
<div class="card border-0 shadow-sm">
    <div class="card-header bg-white py-3">
        <h5 class="mb-0"><i class="fas fa-history text-primary me-2"></i>Payment History</h5>
    </div>
    <div class="card-body">
        <?php if (!empty($payments)): ?>
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0" id="paymentHistoryTable">
                    <thead class="table-light">
                        <tr>
                            <th>#</th>
                            <th>Date</th>
                            <th>Student</th>
                            <th>Amount</th>
                            <th>Method</th>
                            <th>Receipt #</th>
                            <th>Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($payments as $index => $payment): ?>
                            <tr>
                                <td><?= $index + 1 ?></td>
                                <td>
                                    <i class="fas fa-calendar-day me-1 text-primary"></i>
                                    <?= date('d M, Y', strtotime($payment['payment_date'])) ?>
                                </td>
                                <td>
                                    <strong><?= esc($payment['student_name'] ?? 'N/A') ?></strong>
                                    <br><small class="text-muted"><?= esc($payment['student_code'] ?? '') ?></small>
                                </td>
                                <td class="fw-bold text-success">₹<?= number_format($payment['amount'], 2) ?></td>
                                <td>
                                    <?php
                                    $methodIcons = [
                                        'cash'   => 'fas fa-money-bill-wave text-success',
                                        'online' => 'fas fa-globe text-primary',
                                        'card'   => 'fas fa-credit-card text-info',
                                        'upi'    => 'fas fa-mobile-alt text-purple',
                                    ];
                                    $icon = $methodIcons[$payment['payment_method']] ?? 'fas fa-question';
                                    ?>
                                    <i class="<?= $icon ?> me-1"></i>
                                    <?= ucfirst($payment['payment_method']) ?>
                                </td>
                                <td><code><?= esc($payment['receipt_number']) ?></code></td>
                                <td>
                                    <?php if ($payment['status'] === 'completed'): ?>
                                        <span class="badge bg-success">Completed</span>
                                    <?php elseif ($payment['status'] === 'pending'): ?>
                                        <span class="badge bg-warning">Pending</span>
                                    <?php else: ?>
                                        <span class="badge bg-danger">Failed</span>
                                    <?php endif; ?>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        <?php else: ?>
            <div class="text-center py-5 text-muted">
                <i class="fas fa-rupee-sign fa-3x mb-3 d-block"></i>
                <h5>No payments recorded yet</h5>
                <p>Payments will appear here once you record them against pending fees.</p>
            </div>
        <?php endif; ?>
    </div>
</div>

<!-- Record Payment Modal -->
<div class="modal fade" id="recordPaymentModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header bg-success text-white">
                <h5 class="modal-title"><i class="fas fa-rupee-sign me-2"></i>Record Payment</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>
            <form id="recordPaymentForm" method="POST">
                <?= csrf_field() ?>
                <div class="modal-body">
                    <div class="alert alert-info mb-3">
                        <strong id="modalStudentName"></strong> — <span id="modalPeriod"></span><br>
                        Pending Amount: <strong class="text-danger">₹<span id="modalPendingAmount"></span></strong>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Payment Amount <span class="text-danger">*</span></label>
                        <input type="number" class="form-control" name="amount" id="paymentAmount" step="0.01" min="0.01" required>
                    </div>
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label class="form-label">Payment Method <span class="text-danger">*</span></label>
                            <select class="form-select" name="payment_method" required>
                                <option value="cash">Cash</option>
                                <option value="upi">UPI</option>
                                <option value="online">Online Transfer</option>
                                <option value="card">Card</option>
                            </select>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Payment Date <span class="text-danger">*</span></label>
                            <input type="date" class="form-control" name="payment_date" value="<?= date('Y-m-d') ?>" required>
                        </div>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Transaction ID</label>
                        <input type="text" class="form-control" name="transaction_id" placeholder="Auto-generated if left blank">
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Notes</label>
                        <textarea class="form-control" name="notes" rows="2" placeholder="Optional notes"></textarea>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-success"><i class="fas fa-check me-1"></i>Record Payment</button>
                </div>
            </form>
        </div>
    </div>
</div>

<style>
.text-purple { color: #6f42c1 !important; }
</style>

<script>
function openRecordPayment(feeId, pendingAmount, studentName, period) {
    document.getElementById('modalStudentName').textContent = studentName;
    document.getElementById('modalPeriod').textContent = period;
    document.getElementById('modalPendingAmount').textContent = parseFloat(pendingAmount).toLocaleString('en-IN', {minimumFractionDigits: 2});
    document.getElementById('paymentAmount').max = pendingAmount;
    document.getElementById('paymentAmount').value = parseFloat(pendingAmount).toFixed(2);
    document.getElementById('recordPaymentForm').action = '<?= base_url('admin/payments/record/') ?>' + feeId;
    new bootstrap.Modal(document.getElementById('recordPaymentModal')).show();
}

document.addEventListener('DOMContentLoaded', function() {
    if (!$.fn.DataTable.isDataTable('#pendingFeesTable')) {
        var pendingTable = $('#pendingFeesTable').DataTable({
            pageLength: 10,
            lengthMenu: [5, 10, 25, 50, 100],
            order: [],
            language: {
                search: '<i class="fas fa-search me-1"></i>',
                searchPlaceholder: 'Search pending fees...',
                lengthMenu: 'Show _MENU_ entries',
                info: 'Showing _START_ to _END_ of _TOTAL_ records',
                emptyTable: 'No pending fee records',
                paginate: { first: '<i class="fas fa-angle-double-left"></i>', last: '<i class="fas fa-angle-double-right"></i>', next: '<i class="fas fa-angle-right"></i>', previous: '<i class="fas fa-angle-left"></i>' }
            },
            dom: '<"row mb-3"<"col-md-6"l><"col-md-6"f>>rtip',
            columnDefs: [{ targets: [6], orderable: false }]
        });
    }

    if (!$.fn.DataTable.isDataTable('#paymentHistoryTable')) {
        var historyTable = $('#paymentHistoryTable').DataTable({
            pageLength: 10,
            lengthMenu: [5, 10, 25, 50, 100],
            order: [[1, 'desc']],
            language: {
                search: '<i class="fas fa-search me-1"></i>',
                searchPlaceholder: 'Search payments...',
                lengthMenu: 'Show _MENU_ entries',
                info: 'Showing _START_ to _END_ of _TOTAL_ payments',
                emptyTable: 'No payments found',
                paginate: { first: '<i class="fas fa-angle-double-left"></i>', last: '<i class="fas fa-angle-double-right"></i>', next: '<i class="fas fa-angle-right"></i>', previous: '<i class="fas fa-angle-left"></i>' }
            },
            dom: '<"row mb-3"<"col-md-6"l><"col-md-6"f>>rtip'
        });
    }
});
</script>

<?= $this->endSection() ?>