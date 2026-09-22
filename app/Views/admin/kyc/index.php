<?= $this->extend('admin/layouts/main') ?>

<?= $this->section('content') ?>

<!-- Page Header -->
<div class="page-header mb-4">
    <div class="row align-items-center">
        <div class="col-md-6">
            <h2 class="page-title mb-0">
                <i class="fas fa-id-card me-2"></i>KYC Documents Management
            </h2>
            <p class="text-muted mb-0">Review and verify student KYC documents</p>
        </div>
        <div class="col-md-6 text-md-end">
            <div class="btn-group" role="group">
                <button type="button" class="btn btn-outline-primary" onclick="filterDocuments('all')">
                    <i class="fas fa-list me-1"></i>All
                </button>
                <button type="button" class="btn btn-outline-warning" onclick="filterDocuments('pending')">
                    <i class="fas fa-clock me-1"></i>Pending
                </button>
                <button type="button" class="btn btn-outline-success" onclick="filterDocuments('approved')">
                    <i class="fas fa-check me-1"></i>Approved
                </button>
                <button type="button" class="btn btn-outline-danger" onclick="filterDocuments('rejected')">
                    <i class="fas fa-times me-1"></i>Rejected
                </button>
            </div>
        </div>
    </div>
</div>

<!-- Alert Messages -->
<?php if (session()->getFlashdata('success')): ?>
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        <i class="fas fa-check-circle me-2"></i><?= session()->getFlashdata('success') ?>
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
<?php endif; ?>

<?php if (session()->getFlashdata('error')): ?>
    <div class="alert alert-danger alert-dismissible fade show" role="alert">
        <i class="fas fa-exclamation-circle me-2"></i><?= session()->getFlashdata('error') ?>
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
<?php endif; ?>

<!-- KYC Documents Table Card -->
<div class="card border-0 shadow-sm">
    <div class="card-header bg-white border-0 py-3">
        <div class="row align-items-center">
            <div class="col-md-6">
                <h5 class="mb-0">
                    <i class="fas fa-folder-open me-2 text-primary"></i>All Documents
                </h5>
            </div>
            <div class="col-md-6">
                <div class="input-group">
                    <span class="input-group-text bg-light border-end-0">
                        <i class="fas fa-search text-muted"></i>
                    </span>
                    <input type="text" id="searchInput" class="form-control border-start-0" placeholder="Search documents...">
                </div>
            </div>
        </div>
    </div>
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-hover mb-0" id="kycTable">
                <thead class="bg-light">
                    <tr>
                        <th class="px-4 py-3">#</th>
                        <th class="py-3">Student ID</th>
                        <th class="py-3">Student Name</th>
                        <th class="py-3">Document Type</th>
                        <th class="py-3">Document Number</th>
                        <th class="py-3">Submitted Date</th>
                        <th class="py-3">Status</th>
                        <th class="py-3 text-center">Actions</th>
                    </tr>
                </thead>
                <tbody>

                    <?php if (!empty($documents)): ?>
                        <?php foreach ($documents as $index => $doc): ?>
                            <tr data-status="<?= esc($doc['verification_status']) ?>">
                                <td class="px-4 py-3"><?= $index + 1 ?></td>
                                <td class="py-3">
                                    <strong class="text-primary"><?= esc($doc['student_id']) ?></strong>
                                </td>
                                <td class="py-3">
                                    <div class="d-flex align-items-center">
                                        <div class="avatar-circle bg-info text-white me-2">
                                            <?= strtoupper(substr($doc['student_name'], 0, 1)) ?>
                                        </div>
                                        <div>
                                            <div><?= esc($doc['student_name']) ?></div>
                                            <small class="text-muted"><?= esc($doc['email']) ?></small>
                                        </div>
                                    </div>
                                </td>
                                <td class="py-3">
                                    <span class="badge bg-secondary">
                                        <?= strtoupper(esc($doc['document_type'])) ?>
                                    </span>
                                </td>
                                <td class="py-3"><?= esc($doc['document_number']) ?></td>
                                <td class="py-3">
                                    <small><?= date('d M Y', strtotime($doc['created_at'])) ?></small>
                                </td>
                                <td class="py-3">
                                    <?php if ($doc['verification_status'] === 'pending'): ?>
                                        <span class="badge bg-warning">Pending</span>
                                    <?php elseif ($doc['verification_status'] === 'approved'): ?>
                                        <span class="badge bg-success">Approved</span>
                                    <?php else: ?>
                                        <span class="badge bg-danger">Rejected</span>
                                    <?php endif; ?>
                                </td>
                                <td class="py-3 text-center">
                                    <div class="btn-group btn-group-sm" role="group">
                                        <a href="<?= base_url('admin/kyc/view/' . $doc['id']) ?>" 
                                           class="btn btn-outline-info" 
                                           title="View Details">
                                            <i class="fas fa-eye"></i>
                                        </a>
                                        <?php if ($doc['verification_status'] === 'pending'): ?>
                                            <button type="button" 
                                                    class="btn btn-outline-success" 
                                                    onclick="approveDocument(<?= $doc['id'] ?>)"
                                                    title="Approve">
                                                <i class="fas fa-check"></i>
                                            </button>
                                            <button type="button" 
                                                    class="btn btn-outline-danger" 
                                                    onclick="showRejectModal(<?= $doc['id'] ?>, '<?= esc($doc['student_name']) ?>')"
                                                    title="Reject">
                                                <i class="fas fa-times"></i>
                                            </button>
                                        <?php endif; ?>
                                    </div>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="8" class="text-center py-5 text-muted">
                                <i class="fas fa-folder-open fa-3x mb-3 d-block"></i>
                                <h5>No KYC documents found</h5>
                                <p>Documents will appear here once students submit them</p>
                            </td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>


<!-- Reject Modal -->
<div class="modal fade" id="rejectModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header bg-danger text-white">
                <h5 class="modal-title">
                    <i class="fas fa-times-circle me-2"></i>Reject Document
                </h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>
            <form id="rejectForm" method="POST">
                <?= csrf_field() ?>
                <div class="modal-body">
                    <p>Are you sure you want to reject the document of <strong id="studentNameReject"></strong>?</p>
                    <div class="mb-3">
                        <label for="reason" class="form-label">Rejection Reason <span class="text-danger">*</span></label>
                        <textarea class="form-control" id="reason" name="reason" rows="3" required 
                                  placeholder="Please provide a reason for rejection..."></textarea>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-danger">
                        <i class="fas fa-times me-1"></i>Reject Document
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<style>
.avatar-circle {
    width: 40px;
    height: 40px;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    font-weight: bold;
    font-size: 16px;
}
</style>

<script>
function approveDocument(id) {
    if (confirm('Are you sure you want to approve this document?')) {
        window.location.href = '<?= base_url('admin/kyc/approve/') ?>' + id;
    }
}

function showRejectModal(id, studentName) {
    document.getElementById('studentNameReject').textContent = studentName;
    document.getElementById('rejectForm').action = '<?= base_url('admin/kyc/reject/') ?>' + id;
    var rejectModal = new bootstrap.Modal(document.getElementById('rejectModal'));
    rejectModal.show();
}

function filterDocuments(status) {
    let tableRows = document.querySelectorAll('#kycTable tbody tr');
    
    tableRows.forEach(function(row) {
        if (status === 'all' || row.dataset.status === status) {
            row.style.display = '';
        } else {
            row.style.display = 'none';
        }
    });
}

document.getElementById('searchInput').addEventListener('keyup', function() {
    let searchValue = this.value.toLowerCase();
    let tableRows = document.querySelectorAll('#kycTable tbody tr');
    
    tableRows.forEach(function(row) {
        let text = row.textContent.toLowerCase();
        row.style.display = text.includes(searchValue) ? '' : 'none';
    });
});
</script>

<?= $this->endSection() ?>

</div>

