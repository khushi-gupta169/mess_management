<?= $this->extend('admin/layouts/main') ?>

<?= $this->section('content') ?>

<!-- Page Header -->
<div class="page-header mb-4">
    <div class="row align-items-center">
        <div class="col-md-6">
            <h2 class="page-title mb-0"><i class="fas fa-calendar-alt me-2"></i>Holiday Management</h2>
            <p class="text-muted mb-0">Manage mess holidays and meal closures</p>
        </div>
        <div class="col-md-6 text-md-end">
            <a href="<?= base_url('admin/holidays/add') ?>" class="btn btn-primary">
                <i class="fas fa-plus me-1"></i>Add Holiday
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

<div class="card border-0 shadow-sm">
    <div class="card-header bg-white border-0 py-3">
        <div class="row align-items-center">
            <div class="col-md-6">
                <h5 class="mb-0">
                    <i class="fas fa-calendar-alt me-2 text-primary"></i>All Holidays
                </h5>
            </div>
            <div class="col-md-6 text-end">
                <span class="badge bg-primary-subtle text-primary fs-6">
                    <i class="fas fa-calendar me-1"></i><?= count($holidays) ?> Total
                </span>
            </div>
        </div>
    </div>
    <div class="card-body">
        <?php if (!empty($holidays)): ?>
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0" id="holidaysTable">
                    <thead class="table-light">
                        <tr>
                            <th>#</th>
                            <th>Date</th>
                            <th>Day</th>
                            <th>Title</th>
                            <th>Description</th>
                            <th>Meal Status</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($holidays as $index => $holiday): ?>
                            <tr>
                                <td><?= $index + 1 ?></td>
                                <td>
                                    <i class="fas fa-calendar-day me-1 text-primary"></i>
                                    <?= date('d M, Y', strtotime($holiday['holiday_date'])) ?>
                                </td>
                                <td><?= date('l', strtotime($holiday['holiday_date'])) ?></td>
                                <td><strong><?= esc($holiday['title']) ?></strong></td>
                                <td><?= esc($holiday['description'] ?? '-') ?></td>
                                <td>
                                    <?php if ($holiday['meal_status'] === 'closed'): ?>
                                        <span class="badge bg-danger">
                                            <i class="fas fa-times-circle me-1"></i>Closed
                                        </span>
                                    <?php else: ?>
                                        <span class="badge bg-success">
                                            <i class="fas fa-check-circle me-1"></i>Open
                                        </span>
                                    <?php endif; ?>
                                </td>
                                <td>
                                    <a href="<?= base_url('admin/holidays/edit/' . $holiday['id']) ?>" class="btn btn-outline-primary btn-sm me-1">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    <button class="btn btn-outline-danger btn-sm" onclick="confirmDelete(<?= $holiday['id'] ?>, '<?= esc($holiday['title']) ?>')">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        <?php else: ?>
            <div class="text-center py-5 text-muted">
                <i class="fas fa-calendar-alt fa-3x mb-3 d-block"></i>
                <h5>No holidays found</h5>
                <p>Start by adding your first holiday</p>
                <a href="<?= base_url('admin/holidays/add') ?>" class="btn btn-primary mt-2">
                    <i class="fas fa-plus me-1"></i>Add Holiday
                </a>
            </div>
        <?php endif; ?>
    </div>
</div>

<!-- Delete Modal -->
<div class="modal fade" id="deleteModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header bg-danger text-white">
                <h5 class="modal-title"><i class="fas fa-exclamation-triangle me-2"></i>Confirm Delete</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <p>Are you sure you want to delete the holiday "<strong id="holidayTitle"></strong>"?</p>
                <p class="text-danger mb-0"><i class="fas fa-info-circle me-1"></i>This cannot be undone.</p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                <a href="#" id="deleteConfirmBtn" class="btn btn-danger"><i class="fas fa-trash me-1"></i>Delete</a>
            </div>
        </div>
    </div>
</div>

<script>
function confirmDelete(id, title) {
    document.getElementById('holidayTitle').textContent = title;
    document.getElementById('deleteConfirmBtn').href = '<?= base_url('admin/holidays/delete/') ?>' + id;
    new bootstrap.Modal(document.getElementById('deleteModal')).show();
}

document.addEventListener('DOMContentLoaded', function() {
    if (!$.fn.DataTable.isDataTable('#holidaysTable')) {
        $('#holidaysTable').DataTable({
            pageLength: 10,
            lengthMenu: [5, 10, 25, 50, 100],
            order: [[1, 'desc']],
            language: {
                search: '<i class="fas fa-search me-1"></i>',
                searchPlaceholder: 'Search holidays...',
                lengthMenu: 'Show _MENU_ entries',
                info: 'Showing _START_ to _END_ of _TOTAL_ holidays',
                emptyTable: 'No holidays found',
                paginate: { first: '<i class="fas fa-angle-double-left"></i>', last: '<i class="fas fa-angle-double-right"></i>', next: '<i class="fas fa-angle-right"></i>', previous: '<i class="fas fa-angle-left"></i>' }
            },
            dom: '<"row mb-3"<"col-md-6"l><"col-md-6"f>>rtip'
        });
    }
});
</script>

<?= $this->endSection() ?>