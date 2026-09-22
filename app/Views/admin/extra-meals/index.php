<?= $this->extend('admin/layouts/main') ?>

<?= $this->section('content') ?>

<div class="page-header mb-4">
    <div class="row align-items-center">
        <div class="col-md-6">
            <h2 class="page-title mb-0"><i class="fas fa-bowl-food me-2"></i>Extra Meals Requests</h2>
            <p class="text-muted mb-0">Manage student extra meal requests</p>
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

<div class="card border-0 shadow-sm">
    <div class="card-header bg-white py-3">
        <div class="row align-items-center">
            <div class="col-md-6">
                <h5 class="mb-0"><i class="fas fa-list me-2 text-primary"></i>All Requests</h5>
            </div>
            <div class="col-md-6 text-end">
                <span class="badge bg-primary-subtle text-primary fs-6">
                    <i class="fas fa-hamburger me-1"></i><?= count($extraMeals) ?> Total
                </span>
            </div>
        </div>
    </div>
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-hover mb-0" id="extraMealsTable">
                <thead class="bg-light">
                    <tr>
                        <th class="px-4 py-3">#</th>
                        <th class="py-3">Student</th>
                        <th class="py-3">Meal Date</th>
                        <th class="py-3">Meal Type</th>
                        <th class="py-3">Qty</th>
                        <th class="py-3">Price</th>
                        <th class="py-3">Reason</th>
                        <th class="py-3">Status</th>
                        <th class="py-3 text-center">Actions</th>
                    </tr>
                </thead>
                <tbody>

                    <?php if (!empty($extraMeals)): ?>
                        <?php foreach ($extraMeals as $index => $meal): ?>
                            <tr>
                                <td class="px-4 py-3"><?= $index + 1 ?></td>
                                <td class="py-3">
                                    <strong class="text-primary"><?= esc($meal['student_name']) ?></strong>
                                    <br><small class="text-muted"><?= esc($meal['student_code']) ?></small>
                                </td>
                                <td class="py-3"><?= date('d M Y', strtotime($meal['meal_date'])) ?></td>
                                <td class="py-3"><span class="badge bg-info"><?= ucfirst($meal['meal_type']) ?></span></td>
                                <td class="py-3"><?= $meal['quantity'] ?></td>
                                <td class="py-3">&#8377;<?= number_format($meal['price'], 2) ?></td>
                                <td class="py-3"><?= esc($meal['reason'] ?? '-') ?></td>
                                <td class="py-3">
                                    <?php if ($meal['status'] === 'approved'): ?>
                                        <span class="badge bg-success"><i class="fas fa-check me-1"></i>Approved</span>
                                    <?php elseif ($meal['status'] === 'rejected'): ?>
                                        <span class="badge bg-danger"><i class="fas fa-times me-1"></i>Rejected</span>
                                    <?php else: ?>
                                        <span class="badge bg-warning text-dark"><i class="fas fa-clock me-1"></i>Pending</span>
                                    <?php endif; ?>
                                </td>
                                <td class="py-3 text-center">
                                    <?php if ($meal['status'] === 'pending'): ?>
                                        <button class="btn btn-outline-success btn-sm" title="Approve" onclick="confirmApprove(<?= $meal['id'] ?>, '<?= esc($meal['student_name']) ?>')">
                                            <i class="fas fa-check"></i>
                                        </button>
                                        <button class="btn btn-outline-danger btn-sm" title="Reject" onclick="confirmReject(<?= $meal['id'] ?>, '<?= esc($meal['student_name']) ?>')">
                                            <i class="fas fa-times"></i>
                                        </button>
                                    <?php else: ?>
                                        <span class="text-muted">-</span>
                                    <?php endif; ?>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="9" class="text-center py-5 text-muted">
                                <i class="fas fa-bowl-food fa-3x mb-3 d-block"></i>
                                <h5>No extra meal requests found</h5>
                            </td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<!-- Approve Modal -->
<div class="modal fade" id="approveModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header bg-success text-white">
                <h5 class="modal-title"><i class="fas fa-check-circle me-2"></i>Approve Request</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <p>Approve extra meal request for <strong id="approveStudent"></strong>?</p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                <a href="#" id="approveConfirmBtn" class="btn btn-success"><i class="fas fa-check me-1"></i>Approve</a>
            </div>
        </div>
    </div>
</div>

<!-- Reject Modal -->
<div class="modal fade" id="rejectModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header bg-danger text-white">
                <h5 class="modal-title"><i class="fas fa-times-circle me-2"></i>Reject Request</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <p>Reject extra meal request for <strong id="rejectStudent"></strong>?</p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                <a href="#" id="rejectConfirmBtn" class="btn btn-danger"><i class="fas fa-times me-1"></i>Reject</a>
            </div>
        </div>
    </div>
</div>

<script>
function confirmApprove(id, name) {
    document.getElementById('approveStudent').textContent = name;
    document.getElementById('approveConfirmBtn').href = '<?= base_url('admin/extra-meals/approve/') ?>' + id;
    new bootstrap.Modal(document.getElementById('approveModal')).show();
}

function confirmReject(id, name) {
    document.getElementById('rejectStudent').textContent = name;
    document.getElementById('rejectConfirmBtn').href = '<?= base_url('admin/extra-meals/reject/') ?>' + id;
    new bootstrap.Modal(document.getElementById('rejectModal')).show();
}

document.addEventListener('DOMContentLoaded', function() {
    $('#extraMealsTable').DataTable({
        pageLength: 10,
        lengthMenu: [5, 10, 25, 50, 100],
        order: [[0, 'asc']],
        language: {
            search: '<i class="fas fa-search me-1"></i>',
            searchPlaceholder: 'Search requests...',
            lengthMenu: 'Show _MENU_ entries',
            info: 'Showing _START_ to _END_ of _TOTAL_ requests',
            emptyTable: 'No extra meal requests found',
            paginate: { first: '<i class="fas fa-angle-double-left"></i>', last: '<i class="fas fa-angle-double-right"></i>', next: '<i class="fas fa-angle-right"></i>', previous: '<i class="fas fa-angle-left"></i>' }
        },
        dom: '<"row mb-3"<"col-md-6"l><"col-md-6"f>>rtip'
    });
});
</script>

<?= $this->endSection() ?>
