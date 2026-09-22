<?= $this->extend('admin/layouts/main') ?>

<?= $this->section('content') ?>

<div class="page-header mb-4">
    <div class="row align-items-center">
        <div class="col-md-6">
            <h2 class="page-title mb-0"><i class="fas fa-plus-circle me-2"></i>Add New Menu</h2>
        </div>
        <div class="col-md-6 text-md-end">
            <a href="<?= base_url('admin/menus') ?>" class="btn btn-outline-secondary">
                <i class="fas fa-arrow-left me-1"></i>Back to Menus
            </a>
        </div>
    </div>
</div>

<?php if (session()->getFlashdata('error')): ?>
    <div class="alert alert-danger alert-dismissible fade show">
        <i class="fas fa-exclamation-circle me-2"></i><?= session()->getFlashdata('error') ?>
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
<?php endif; ?>

<div class="card border-0 shadow-sm">
    <div class="card-body">
        <form action="<?= base_url('admin/menus/store') ?>" method="POST">
            <?= csrf_field() ?>
            <div class="row g-3 mb-4">
                <div class="col-md-4">
                    <label class="form-label">Menu Date <span class="text-danger">*</span></label>
                    <input type="date" class="form-control" name="menu_date" id="menuDate" required>
                </div>
                <div class="col-md-4">
                    <label class="form-label">Day <span class="text-danger">*</span></label>
                    <select class="form-select" id="day" name="day" required>
                        <option value="">Select Day</option>
                        <option value="monday">Monday</option>
                        <option value="tuesday">Tuesday</option>
                        <option value="wednesday">Wednesday</option>
                        <option value="thursday">Thursday</option>
                        <option value="friday">Friday</option>
                        <option value="saturday">Saturday</option>
                        <option value="sunday">Sunday</option>
                    </select>
                </div>
                <div class="col-md-4">
                    <label class="form-label">Status</label>
                    <select class="form-select" name="status">
                        <option value="active">Active</option>
                        <option value="inactive">Inactive</option>
                    </select>
                </div>
            </div>

            <h5 class="mb-3"><i class="fas fa-list me-2"></i>Menu Items</h5>
            <div id="menuItems">
                <div class="row g-2 mb-2 menu-item-row">
                    <div class="col-md-3">
                        <select class="form-select" name="meal_type[]" required>
                            <option value="">Meal Type</option>
                            <option value="breakfast">Breakfast</option>
                            <option value="lunch">Lunch</option>
                            <option value="evening">Evening</option>
                            <option value="dinner">Dinner</option>
                        </select>
                    </div>
                    <div class="col-md-4">
                        <input type="text" class="form-control" name="food_name[]" placeholder="Food name" required>
                    </div>
                    <div class="col-md-4">
                        <input type="text" class="form-control" name="description[]" placeholder="Description (optional)">
                    </div>
                    <div class="col-md-1">
                        <button type="button" class="btn btn-outline-danger btn-sm remove-row"><i class="fas fa-times"></i></button>
                    </div>
                </div>
            </div>

            <button type="button" class="btn btn-outline-primary btn-sm mb-4" id="addRow">
                <i class="fas fa-plus me-1"></i>Add Item
            </button>

            <hr>
            <div class="text-end">
                <a href="<?= base_url('admin/menus') ?>" class="btn btn-secondary me-2">Cancel</a>
                <button type="submit" class="btn btn-primary"><i class="fas fa-save me-1"></i>Save Menu</button>
            </div>
        </form>
    </div>
</div>

<script>
document.getElementById('addRow').addEventListener('click', function() {
    var html = '<div class="row g-2 mb-2 menu-item-row">';
    html += '<div class="col-md-3"><select class="form-select" name="meal_type[]" required><option value="">Meal Type</option><option value="breakfast">Breakfast</option><option value="lunch">Lunch</option><option value="evening">Evening</option><option value="dinner">Dinner</option></select></div>';
    html += '<div class="col-md-4"><input type="text" class="form-control" name="food_name[]" placeholder="Food name" required></div>';
    html += '<div class="col-md-4"><input type="text" class="form-control" name="description[]" placeholder="Description (optional)"></div>';
    html += '<div class="col-md-1"><button type="button" class="btn btn-outline-danger btn-sm remove-row"><i class="fas fa-times"></i></button></div>';
    html += '</div>';
    document.getElementById('menuItems').insertAdjacentHTML('beforeend', html);
});

document.getElementById('menuItems').addEventListener('click', function(e) {
    if (e.target.closest('.remove-row')) {
        e.target.closest('.menu-item-row').remove();
    }
});
</script>

<?= $this->endSection() ?>
