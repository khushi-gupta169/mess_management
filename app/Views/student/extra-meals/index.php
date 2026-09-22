<?= $this->extend('student/layouts/main') ?>
<?= $this->section('content') ?>
<div class="row">
    <div class="col-lg-5 mb-4">
        <div class="card stat-card">
            <div class="card-header bg-white py-3"><h5 class="mb-0"><i class="bi bi-plus-circle me-2 text-primary"></i>Request Extra Meal</h5></div>
            <div class="card-body">
                <form action="<?= base_url('student/extra-meals/request') ?>" method="POST">
                    <div class="mb-3">
                        <label for="meal_date" class="form-label">Meal Date <span class="text-danger">*</span></label>
                        <input type="date" class="form-control" id="meal_date" name="meal_date" value="<?= date('Y-m-d') ?>" min="<?= date('Y-m-d') ?>" required>
                    </div>
                    <div class="mb-3">
                        <label for="meal_type" class="form-label">Meal Type <span class="text-danger">*</span></label>
                        <select class="form-select" id="meal_type" name="meal_type" required>
                            <option value="">Select Meal Type</option>
                            <option value="breakfast">Breakfast</option>
                            <option value="lunch">Lunch</option>
                            <option value="evening">Evening Snacks</option>
                            <option value="dinner">Dinner</option>
                        </select>
                    </div>
                    <div class="row mb-3">
                        <div class="col-6">
                            <label for="quantity" class="form-label">Quantity <span class="text-danger">*</span></label>
                            <input type="number" class="form-control" id="quantity" name="quantity" value="1" min="1" max="10" required>
                        </div>
                        <div class="col-6">
                            <label for="price" class="form-label">Price (₹) <span class="text-danger">*</span></label>
                            <input type="number" class="form-control" id="price" name="price" step="0.01" min="1" placeholder="0.00" required>
                        </div>
                    </div>
                    <div class="mb-3">
                        <label for="reason" class="form-label">Reason <span class="text-danger">*</span></label>
                        <textarea class="form-control" id="reason" name="reason" rows="3" placeholder="Why do you need an extra meal?" required></textarea>
                    </div>
                    <button type="submit" class="btn btn-primary w-100"><i class="bi bi-send me-1"></i>Submit Request</button>
                </form>
            </div>
        </div>
    </div>
    <div class="col-lg-7 mb-4">
        <div class="card stat-card">
            <div class="card-header bg-white py-3"><h5 class="mb-0"><i class="bi bi-list-check me-2 text-primary"></i>My Requests</h5></div>
            <div class="card-body">
                <?php if (!empty($extraMeals)): ?>
                <div class="table-responsive">
                    <table class="table table-hover align-middle">
                        <thead class="table-light"><tr><th>Date</th><th>Meal</th><th>Qty</th><th>Price</th><th>Status</th><th>Reason</th></tr></thead>
                        <tbody>
                        <?php foreach ($extraMeals as $meal): ?>
                        <tr>
                            <td><?= date('d M Y', strtotime($meal['meal_date'])) ?></td>
                            <td><span class="badge <?php if($meal['meal_type']==='breakfast'):?>bg-warning text-dark<?php elseif($meal['meal_type']==='lunch'):?>bg-success<?php elseif($meal['meal_type']==='evening'):?>bg-info<?php else:?>bg-dark<?php endif;?>"><?= ucfirst($meal['meal_type']) ?></span></td>
                            <td><?= esc($meal['quantity']) ?></td>
                            <td>₹<?= number_format($meal['price'], 2) ?></td>
                            <td>
                                <?php if ($meal['status']==='pending'): ?><span class="badge bg-warning text-dark"><i class="bi bi-clock me-1"></i>Pending</span>
                                <?php elseif ($meal['status']==='approved'):?><span class="badge bg-success"><i class="bi bi-check-circle me-1"></i>Approved</span>
                                <?php else:?><span class="badge bg-danger"><i class="bi bi-x-circle me-1"></i>Rejected</span><?php endif;?>
                            </td>
                            <td><small class="text-muted"><?= esc($meal['reason'] ?? '-') ?></small></td>
                        </tr>
                        <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
                <?php else: ?>
                <div class="text-center py-5"><i class="bi bi-inbox text-muted" style="font-size:3rem;"></i><h5 class="mt-3 text-muted">No requests yet</h5></div>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>
<?= $this->endSection() ?>