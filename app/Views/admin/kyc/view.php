<?= $this->extend('admin/layouts/main') ?>

<?= $this->section('content') ?>

<div class="page-header mb-4">
    <div class="row align-items-center">
        <div class="col-md-6">
            <h2 class="page-title mb-0"><i class="fas fa-file-alt me-2"></i>View KYC Document</h2>
        </div>
        <div class="col-md-6 text-md-end">
            <a href="<?= base_url('admin/kyc') ?>" class="btn btn-outline-secondary">
                <i class="fas fa-arrow-left me-1"></i>Back to KYC
            </a>
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

<div class="row">
    <!-- Left Column: Student Info & Status -->
    <div class="col-lg-4 mb-4">
        <div class="card border-0 shadow-sm">
            <div class="card-header bg-white py-3">
                <h5 class="mb-0"><i class="fas fa-user me-2 text-primary"></i>Student Information</h5>
            </div>
            <div class="card-body">
                <table class="table table-borderless mb-0">
                    <tr><th class="text-muted" style="width:40%">Name</th><td><?= esc($document['student_name']) ?></td></tr>
                    <tr><th class="text-muted">Student ID</th><td><strong class="text-primary"><?= esc($document['student_id']) ?></strong></td></tr>
                    <tr><th class="text-muted">Email</th><td><?= esc($document['email']) ?></td></tr>
                    <tr><th class="text-muted">Mobile</th><td><?= esc($document['mobile']) ?></td></tr>
                </table>
            </div>
        </div>

        <div class="card border-0 shadow-sm mt-4">
            <div class="card-header bg-white py-3">
                <h5 class="mb-0"><i class="fas fa-info-circle me-2 text-primary"></i>Document Details</h5>
            </div>
            <div class="card-body">
                <table class="table table-borderless mb-0">
                    <tr><th class="text-muted" style="width:40%">Type</th><td><?= esc(ucfirst($document['document_type'])) ?></td></tr>
                    <tr><th class="text-muted">Number</th><td><strong><?= esc($document['document_number']) ?></strong></td></tr>
                    <tr><th class="text-muted">Submitted</th><td><?= date('d M Y h:i A', strtotime($document['created_at'])) ?></td></tr>
                    <tr>
                        <th class="text-muted">Status</th>
                        <td>
                            <?php if ($document['status'] === 'approved'): ?>
                                <span class="badge bg-success"><i class="fas fa-check me-1"></i>Approved</span>
                            <?php elseif ($document['status'] === 'rejected'): ?>
                                <span class="badge bg-danger"><i class="fas fa-times me-1"></i>Rejected</span>
                            <?php else: ?>
                                <span class="badge bg-warning text-dark"><i class="fas fa-clock me-1"></i>Pending</span>
                            <?php endif; ?>
                        </td>
                    </tr>
                </table>
            </div>
        </div>
    </div>

    <!-- Right Column: Document Preview & Actions -->
    <div class="col-lg-8 mb-4">
        <div class="card border-0 shadow-sm">
            <div class="card-header bg-white py-3">
                <h5 class="mb-0"><i class="fas fa-id-card me-2 text-primary"></i>Document Preview</h5>
            </div>
            <div class="card-body text-center">
                <?php if (!empty($document['document_image'])): ?>
                    <?php
                    $imgPath = $document['document_image'];
                    if (strpos($imgPath, 'http') !== 0) {
                        $imgPath = base_url('uploads/kyc/' . $imgPath);
                    }
                    ?>
                    <img src="<?= esc($imgPath) ?>" alt="KYC Document" class="img-fluid rounded border" style="max-height:500px;">
                <?php else: ?>
                    <div class="text-muted py-5">
                        <i class="fas fa-image fa-4x mb-3 d-block"></i>
                        <h5>No document image available</h5>
                    </div>
                <?php endif; ?>
            </div>
        </div>

        <?php if (!empty($document['remarks'])): ?>
        <div class="card border-0 shadow-sm mt-4">
            <div class="card-header bg-white py-3">
                <h5 class="mb-0"><i class="fas fa-comment me-2 text-primary"></i>Remarks</h5>
            </div>
            <div class="card-body">
                <p class="mb-0"><?= nl2br(esc($document['remarks'])) ?></p>
            </div>
        </div>
        <?php endif; ?>

        <?php if ($document['status'] === 'pending'): ?>
        <div class="card border-0 shadow-sm mt-4">
            <div class="card-header bg-white py-3">
                <h5 class="mb-0"><i class="fas fa-gavel me-2 text-primary"></i>Actions</h5>
            </div>
            <div class="card-body">
                <div class="d-flex gap-2">
                    <button class="btn btn-success btn-lg flex-fill" onclick="approveDocument(<?= $document['id'] ?>)">
                        <i class="fas fa-check me-1"></i>Approve
                    </button>
                    <button class="btn btn-danger btn-lg flex-fill" onclick="showRejectModal(<?= $document['id'] ?>)">
                        <i class="fas fa-times me-1"></i>Reject
                    </button>
                </div>
            </div>
        </div>
        <?php endif; ?>
    </div>
</div>


<!-- Reject Modal -->
<div class="modal fade" id="rejectModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header bg-danger text-white">
                <h5 class="modal-title"><i class="fas fa-exclamation-triangle me-2"></i>Reject Document</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>
            <form id="rejectForm" method="POST">
                <?= csrf_field() ?>
                <div class="modal-body">
                    <label class="form-label">Reason for Rejection <span class="text-danger">*</span></label>
                    <textarea class="form-control" name="remarks" rows="4" required placeholder="Enter rejection reason..."></textarea>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-danger"><i class="fas fa-times me-1"></i>Reject</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
function approveDocument(id) {
    if (confirm('Are you sure you want to approve this document?')) {
        window.location.href = '<?= base_url('admin/kyc/approve/') ?>' + id;
    }
}

function showRejectModal(id) {
    document.getElementById('rejectForm').action = '<?= base_url('admin/kyc/reject/') ?>' + id;
    new bootstrap.Modal(document.getElementById('rejectModal')).show();
}
</script>

<?= $this->endSection() ?>

