<?= $this->extend('admin/layouts/main') ?>

<?= $this->section('content') ?>

<div class="page-header mb-4">
    <div class="row align-items-center">
        <div class="col-md-6">
            <h2 class="page-title mb-0"><i class="fas fa-utensils me-2"></i>Meal Menus</h2>
            <p class="text-muted mb-0">Manage weekly meal menus</p>
        </div>
        <div class="col-md-6 text-md-end">
            <a href="<?= base_url('admin/menus/add') ?>" class="btn btn-primary">
                <i class="fas fa-plus me-1"></i>Add New Menu
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

<?php if (!empty($menus)): ?>
    <div id="menusContainer">
    <?php foreach ($menus as $menu): ?>
    <div class="card border-0 shadow-sm mb-4 menu-card">
        <div class="card-header bg-white py-3">
            <div class="row align-items-center">
                <div class="col-md-6">
                    <h5 class="mb-0">
                        <i class="fas fa-calendar-day me-2 text-primary"></i>
                        <?= date('d M Y (l)', strtotime($menu['menu_date'])) ?>
                    </h5>
                </div>
                <div class="col-md-6 text-md-end">
                    <?php if ($menu['status'] === 'active'): ?>
                        <span class="badge bg-success me-2">Active</span>
                    <?php else: ?>
                        <span class="badge bg-secondary me-2">Inactive</span>
                    <?php endif; ?>
                    <a href="<?= base_url('admin/menus/edit/' . $menu['id']) ?>" class="btn btn-outline-primary btn-sm">
                        <i class="fas fa-edit me-1"></i>Edit
                    </a>
                    <button class="btn btn-outline-danger btn-sm" onclick="confirmDelete(<?= $menu['id'] ?>, '<?= date('d M Y', strtotime($menu['menu_date'])) ?>')">
                        <i class="fas fa-trash"></i>
                    </button>
                </div>
            </div>
        </div>
        <div class="card-body">
            <?php if (!empty($menu['items'])): ?>
                <?php
                $grouped = [];
                foreach ($menu['items'] as $item) {
                    $grouped[$item['meal_type']][] = $item;
                }
                ?>
                <div class="row">
                    <?php foreach (['breakfast', 'lunch', 'evening', 'dinner'] as $mealType): ?>
                        <?php if (!empty($grouped[$mealType])): ?>
                        <div class="col-lg-3 col-md-6 mb-3">
                            <div class="meal-card p-3 rounded h-100
                                <?php if ($mealType === 'breakfast'): ?>bg-warning bg-opacity-10
                                <?php elseif ($mealType === 'lunch'): ?>bg-success bg-opacity-10
                                <?php elseif ($mealType === 'evening'): ?>bg-info bg-opacity-10
                                <?php else: ?>bg-purple bg-opacity-10<?php endif; ?>">
                                <h6 class="text-uppercase fw-bold mb-2
                                    <?php if ($mealType === 'breakfast'): ?>text-warning
                                    <?php elseif ($mealType === 'lunch'): ?>text-success
                                    <?php elseif ($mealType === 'evening'): ?>text-info
                                    <?php else: ?>text-purple<?php endif; ?>">
                                    <?= ucfirst($mealType) ?>
                                </h6>
                                <ul class="list-unstyled mb-0">
                                    <?php foreach ($grouped[$mealType] as $item): ?>
                                    <li class="mb-1">
                                        <i class="fas fa-check-circle text-success me-1" style="font-size:10px;"></i>
                                        <?= esc($item['food_name']) ?>
                                        <?php if (!empty($item['description'])): ?>
                                            <br><small class="text-muted ms-3"><?= esc($item['description']) ?></small>
                                        <?php endif; ?>
                                    </li>
                                    <?php endforeach; ?>
                                </ul>
                            </div>
                        </div>
                        <?php endif; ?>
                    <?php endforeach; ?>
                </div>
            <?php else: ?>
                <p class="text-muted text-center mb-0">No menu items added yet.</p>
            <?php endif; ?>
        </div>
    </div>
    <?php endforeach; ?>
    </div>
    <nav aria-label="Menus pagination" id="menusPagination" class="mt-3"></nav>
<?php else: ?>
    <div class="card border-0 shadow-sm">
        <div class="card-body text-center py-5 text-muted">
            <i class="fas fa-utensils fa-3x mb-3 d-block"></i>
            <h5>No menus found</h5>
            <p>Start by creating your first menu</p>
            <a href="<?= base_url('admin/menus/add') ?>" class="btn btn-primary mt-2">
                <i class="fas fa-plus me-1"></i>Add Menu
            </a>
        </div>
    </div>
<?php endif; ?>


<!-- Delete Modal -->
<div class="modal fade" id="deleteModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header bg-danger text-white">
                <h5 class="modal-title"><i class="fas fa-exclamation-triangle me-2"></i>Confirm Delete</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <p>Are you sure you want to delete the menu for <strong id="menuDate"></strong>?</p>
                <p class="text-danger mb-0"><i class="fas fa-info-circle me-1"></i>This cannot be undone.</p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                <a href="#" id="deleteConfirmBtn" class="btn btn-danger"><i class="fas fa-trash me-1"></i>Delete</a>
            </div>
        </div>
    </div>
</div>

<style>
.meal-card { border: 1px solid rgba(0,0,0,.075); }
.text-purple { color: #6f42c1 !important; }
.bg-purple { background-color: #c6b5e3 !important; }
</style>

<script>
function confirmDelete(id, date) {
    document.getElementById('menuDate').textContent = date;
    document.getElementById('deleteConfirmBtn').href = '<?= base_url('admin/menus/delete/') ?>' + id;
    new bootstrap.Modal(document.getElementById('deleteModal')).show();
}

document.addEventListener('DOMContentLoaded', function() {
    var cards = document.querySelectorAll('#menusContainer .menu-card');
    var perPage = 5;
    var currentPage = 1;
    var totalPages = Math.ceil(cards.length / perPage);

    function showPage(page) {
        currentPage = page;
        var start = (page - 1) * perPage;
        var end = start + perPage;
        cards.forEach(function(card, i) {
            card.style.display = (i >= start && i < end) ? '' : 'none';
        });
        renderPagination();
    }

    function renderPagination() {
        if (totalPages <= 1) { document.getElementById('menusPagination').innerHTML = ''; return; }
        var html = '<ul class="pagination justify-content-center mb-0">';
        html += '<li class="page-item ' + (currentPage === 1 ? 'disabled' : '') + '"><a class="page-link" href="#" onclick="goToMenuPage(' + (currentPage - 1) + ');return false;"><i class="fas fa-angle-left"></i></a></li>';
        for (var i = 1; i <= totalPages; i++) {
            html += '<li class="page-item ' + (i === currentPage ? 'active' : '') + '"><a class="page-link" href="#" onclick="goToMenuPage(' + i + ');return false;">' + i + '</a></li>';
        }
        html += '<li class="page-item ' + (currentPage === totalPages ? 'disabled' : '') + '"><a class="page-link" href="#" onclick="goToMenuPage(' + (currentPage + 1) + ');return false;"><i class="fas fa-angle-right"></i></a></li>';
        html += '</ul>';
        document.getElementById('menusPagination').innerHTML = html;
    }

    window.goToMenuPage = function(page) {
        if (page < 1 || page > totalPages) return;
        showPage(page);
    };

    if (cards.length > 0) showPage(1);
});
</script>

<?= $this->endSection() ?>

