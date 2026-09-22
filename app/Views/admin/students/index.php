<?= $this->extend('admin/layouts/main') ?>

<?= $this->section('content') ?>

<!-- Page Header -->
<div class="page-header mb-4">
    <div class="row align-items-center">
        <div class="col-md-6">
            <h2 class="page-title mb-0">
                <i class="fas fa-user-graduate me-2"></i>Students Management
            </h2>
            <p class="text-muted mb-0">Manage all student records</p>
        </div>
        <div class="col-md-6 text-md-end">
            <a href="<?= base_url('admin/students/add') ?>" class="btn btn-primary">
                <i class="fas fa-plus me-1"></i>Add New Student
            </a>
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

<!-- Students Table Card -->
<div class="card border-0 shadow-sm">
    <div class="card-header bg-white border-0 py-3">
        <div class="row align-items-center">
            <div class="col-md-6">
                <h5 class="mb-0">
                    <i class="fas fa-list me-2 text-primary"></i>All Students
                </h5>
            </div>
            <div class="col-md-6">
                <div class="input-group">
                    <span class="input-group-text bg-light border-end-0">
                        <i class="fas fa-search text-muted"></i>
                    </span>
                    <input type="text" id="searchInput" class="form-control border-start-0" placeholder="Search students...">
                </div>
            </div>
        </div>
    </div>
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-hover mb-0" id="studentsTable">
                <thead class="bg-light">
                    <tr>
                        <th class="px-4 py-3">#</th>
                        <th class="py-3">Student ID</th>
                        <th class="py-3">Name</th>
                        <th class="py-3">Email</th>
                        <th class="py-3">Mobile</th>
                        <th class="py-3">Course</th>
                        <th class="py-3">Year</th>
                        <th class="py-3">Hostel</th>
                        <th class="py-3">Room</th>
                        <th class="py-3">Status</th>
                        <th class="py-3 text-center">Actions</th>
                    </tr>
                </thead>
                <tbody>


                    <?php if (!empty($students)): ?>
                        <?php foreach ($students as $index => $student): ?>
                            <tr>
                                <td class="px-4 py-3"><?= $index + 1 ?></td>
                                <td class="py-3">
                                    <strong class="text-primary"><?= esc($student['student_id']) ?></strong>
                                </td>
                                <td class="py-3">
                                    <div class="d-flex align-items-center">
                                        <div class="avatar-circle bg-primary text-white me-2">
                                            <?= strtoupper(substr($student['name'], 0, 1)) ?>
                                        </div>
                                        <span><?= esc($student['name']) ?></span>
                                    </div>
                                </td>
                                <td class="py-3"><?= esc($student['email']) ?></td>
                                <td class="py-3"><?= esc($student['mobile']) ?></td>
                                <td class="py-3"><?= esc($student['course']) ?></td>
                                <td class="py-3">
                                    <span class="badge bg-info">Year <?= esc($student['year']) ?></span>
                                </td>
                                <td class="py-3"><?= esc($student['hostel_name']) ?></td>
                                <td class="py-3">
                                    <span class="badge bg-secondary"><?= esc($student['room_number']) ?></span>
                                </td>
                                <td class="py-3">
                                    <?php if ($student['status'] === 'active'): ?>
                                        <span class="badge bg-success">Active</span>
                                    <?php elseif ($student['status'] === 'inactive'): ?>
                                        <span class="badge bg-warning">Inactive</span>
                                    <?php else: ?>
                                        <span class="badge bg-danger">Suspended</span>
                                    <?php endif; ?>
                                </td>
                                <td class="py-3 text-center">
                                    <div class="btn-group btn-group-sm" role="group">
                                        <a href="<?= base_url('admin/students/edit/' . $student['id']) ?>" 
                                           class="btn btn-outline-primary" 
                                           title="Edit">
                                            <i class="fas fa-edit"></i>
                                        </a>
                                        <button type="button" 
                                                class="btn btn-outline-danger" 
                                                onclick="confirmDelete(<?= $student['id'] ?>, '<?= esc($student['name']) ?>')"
                                                title="Delete">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </div>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="11" class="text-center py-5 text-muted">
                                <i class="fas fa-users fa-3x mb-3 d-block"></i>
                                <h5>No students found</h5>
                                <p>Start by adding your first student</p>
                                <a href="<?= base_url('admin/students/add') ?>" class="btn btn-primary mt-2">
                                    <i class="fas fa-plus me-1"></i>Add Student
                                </a>
                            </td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>


<!-- Delete Modal -->
<div class="modal fade" id="deleteModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header bg-danger text-white">
                <h5 class="modal-title">
                    <i class="fas fa-exclamation-triangle me-2"></i>Confirm Delete
                </h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <p>Are you sure you want to delete student <strong id="studentName"></strong>?</p>
                <p class="text-danger mb-0">
                    <i class="fas fa-info-circle me-1"></i>This action cannot be undone.
                </p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                <a href="#" id="deleteConfirmBtn" class="btn btn-danger">
                    <i class="fas fa-trash me-1"></i>Delete
                </a>
            </div>
        </div>
    </div>
</div>

<style>
.avatar-circle {
    width: 35px;
    height: 35px;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    font-weight: bold;
    font-size: 14px;
}
</style>

<script>
function confirmDelete(id, name) {
    document.getElementById('studentName').textContent = name;
    document.getElementById('deleteConfirmBtn').href = '<?= base_url('admin/students/delete/') ?>' + id;
    var deleteModal = new bootstrap.Modal(document.getElementById('deleteModal'));
    deleteModal.show();
}

document.getElementById('searchInput').addEventListener('keyup', function() {
    let searchValue = this.value.toLowerCase();
    let tableRows = document.querySelectorAll('#studentsTable tbody tr');
    
    tableRows.forEach(function(row) {
        let text = row.textContent.toLowerCase();
        row.style.display = text.includes(searchValue) ? '' : 'none';
    });
});
</script>

<?= $this->endSection() ?>

</div>
