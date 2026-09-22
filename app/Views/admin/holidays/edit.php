<?= $this->extend('admin/layouts/main') ?>

<?= $this->section('content') ?>

<div class="page-header mb-4">
    <div class="row align-items-center">
        <div class="col-md-6">
            <h2 class="page-title mb-0"><i class="fas fa-edit me-2"></i>Edit Holiday</h2>
        </div>
        <div class="col-md-6 text-md-end">
            <a href="<?= base_url('admin/holidays') ?>" class="btn btn-outline-secondary">
                <i class="fas fa-arrow-left me-1"></i>Back to Holidays
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
        <form action="<?= base_url('admin/holidays/update/' . $holiday['id']) ?>" method="POST">
            <?= csrf_field() ?>
            <div class="row g-3">
                <div class="col-md-6">
                    <label class="form-label">Holiday Date <span class="text-danger">*</span></label>
                    <input type="date" class="form-control" name="holiday_date" value="<?= esc($holiday['holiday_date']) ?>" required>
                </div>
                <div class="col-md-6">
                    <label class="form-label">Meal Status <span class="text-danger">*</span></label>
                    <select class="form-select" name="meal_status" required>
                        <option value="closed" <?= $holiday['meal_status'] === 'closed' ? 'selected' : '' ?>>Closed - No Mess</option>
                        <option value="open" <?= $holiday['meal_status'] === 'open' ? 'selected' : '' ?>>Open - Mess Available</option>
                    </select>
                </div>
                <div class="col-md-12">
                    <label class="form-label">Title <span class="text-danger">*</span></label>
                    <input type="text" class="form-control" name="title" value="<?= esc($holiday['title']) ?>" required>
                </div>
                <div class="col-md-12">
                    <label class="form-label">Description</label>
                    <textarea class="form-control" name="description" rows="3"><?= esc($holiday['description'] ?? '') ?></textarea>
                </div>
            </div>

            <hr>
            <div class="text-end mt-3">
                <a href="<?= base_url('admin/holidays') ?>" class="btn btn-secondary me-2">Cancel</a>
                <button type="submit" class="btn btn-primary"><i class="fas fa-save me-1"></i>Update Holiday</button>
            </div>
        </form>
    </div>
</div>

<?= $this->endSection() ?>