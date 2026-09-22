<?= $this->extend('admin/layouts/main') ?>

<?= $this->section('content') ?>

<div class="page-header mb-4">
    <div class="row align-items-center">
        <div class="col-md-6">
            <h2 class="page-title mb-0"><i class="fas fa-edit me-2"></i>Edit Menu</h2>
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
        <form action="<?= base_url('admin/menus/update/' . $menu['id']) ?>" method="POST">
            <?= csrf_field() ?>
            <div class="row g-3 mb-4">
                <div class="col-md-4">
                    <label class="form-label">Menu Date <span class="text-danger">*</span></label>
                    <input type="date" class="form-control" name="menu_date" value="<?= esc($menu['menu_date']) ?>" required>
                </div>
                <div class="col-md-4">
                    <label class="form-label">Day <span class="text-danger">*</span></label>
                    <select class="form-select" name="day" required>
                        <?php foreach (['monday','tuesday','wednesday','thursday','friday','saturday','sunday'] as $d): ?>
                            <option value="<?= $d ?>" <?= $menu['day'] === $d ? 'selected' : '' ?>><?= ucfirst($d) ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <div class="col-md-4">
                    <label class="form-label">Status</label>
                    <select class="form-select" name="status">
                        <option value="active" <?= $menu['status'] === 'active' ? 'selected' : '' ?>>Active</option>
                        <option value="inactive" <?= $menu['status'] === 'inactive' ? 'selected' : '' ?>>Inactive</option>
                    </select>
                </div>
            </div>

            <h5 class="mb-3"><i class="fas fa-list me-2"></i>Menu Items</h5>
            <div id="menuItems">
                <?php if (!empty($menu['items'])): ?>
                    <?php foreach ($menu['items'] as $item): ?>
                        <div class="row g-2 mb-2 menu-item-row">
                            <div class="col-md-3">
                                <select class="form-select" name="meal_type[]" required>
                                    <option value="">Meal Type</option>
                                    <?php foreach (['breakfast','lunch','evening','dinner'] as $mt): ?>
                                        <option value="<?= $mt ?>" <?= $item['meal_type'] === $mt ? 'selected' : '' ?>><?= ucfirst($mt) ?></option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                            <div class="col-md-4">
                                <input type="text" class="form-control" name="food_name[]" value="<?= esc($item['food_name']) ?>" required>
                            </div>
                            <div class="col-md-4">
                                <input type="text" class="form-control" name="description[]" value="<?= esc($item['description'] ?? '') ?>">
                            </div>
                            <div class="col-md-1">
                                <button type="button" class="btn btn-outline-danger btn-sm remove-row"><i class="fas fa-times"></i></button>
                            </div>
                        </div>
                    <?php endforeach; ?>
                <?php endif; ?>
            </div>

            <button type="button" class="btn btn-outline-primary btn-sm mb-4" id="addRow">
                <i class="fas fa-plus me-1"></i>Add Item
            </button>

            <hr>
            <div class="text-end">
                <a href="<?= base_url('admin/menus') ?>" class="btn btn-secondary me-2">Cancel</a>
                <button type="submit" class="btn btn-primary"><i class="fas fa-save me-1"></i>Update Menu</button>
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
