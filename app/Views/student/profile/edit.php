<?= $this->extend('student/layouts/main') ?>
<?= $this->section('content') ?>
<div class="row justify-content-center">
    <div class="col-lg-8">
        <div class="card stat-card">
            <div class="card-header bg-white py-3"><h5 class="mb-0"><i class="bi bi-pencil-square me-2 text-primary"></i>Edit Profile</h5></div>
            <div class="card-body">
                <form action="<?= base_url('student/profile/update') ?>" method="POST">
                    <h6 class="text-primary mb-3"><i class="bi bi-person me-2"></i>Personal Information</h6>
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label for="name" class="form-label">Full Name <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" id="name" name="name" value="<?= esc($student['name'] ?? '') ?>" required>
                        </div>
                        <div class="col-md-6">
                            <label for="email" class="form-label">Email <span class="text-danger">*</span></label>
                            <input type="email" class="form-control" id="email" name="email" value="<?= esc($student['email'] ?? '') ?>" required>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label for="mobile" class="form-label">Mobile</label>
                            <input type="text" class="form-control" id="mobile" name="mobile" value="<?= esc($student['mobile'] ?? '') ?>">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Student ID</label>
                            <input type="text" class="form-control" value="<?= esc($student['student_id'] ?? '') ?>" disabled>
                        </div>
                    </div>
                    <div class="mb-3">
                        <label for="address" class="form-label">Address</label>
                        <textarea class="form-control" id="address" name="address" rows="2"><?= esc($student['address'] ?? '') ?></textarea>
                    </div>
                    <hr>
                    <h6 class="text-muted mb-3"><i class="bi bi-info-circle me-2"></i>Academic Info (Contact admin to update)</h6>
                    <div class="row mb-3">
                        <div class="col-md-6"><label class="form-label">Father's Name</label><input type="text" class="form-control" value="<?= esc($student['father_name'] ?? '') ?>" disabled></div>
                        <div class="col-md-6"><label class="form-label">Mother's Name</label><input type="text" class="form-control" value="<?= esc($student['mother_name'] ?? '') ?>" disabled></div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-md-6"><label class="form-label">Course</label><input type="text" class="form-control" value="<?= esc($student['course'] ?? '') ?>" disabled></div>
                        <div class="col-md-6"><label class="form-label">Branch</label><input type="text" class="form-control" value="<?= esc($student['branch'] ?? '') ?>" disabled></div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-md-4"><label class="form-label">Year</label><input type="text" class="form-control" value="<?= esc($student['year'] ?? '') ?>" disabled></div>
                        <div class="col-md-4"><label class="form-label">Semester</label><input type="text" class="form-control" value="<?= esc($student['semester'] ?? '') ?>" disabled></div>
                        <div class="col-md-4"><label class="form-label">College</label><input type="text" class="form-control" value="<?= esc($student['college'] ?? '') ?>" disabled></div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-md-6"><label class="form-label">Hostel</label><input type="text" class="form-control" value="<?= esc($student['hostel_name'] ?? '') ?>" disabled></div>
                        <div class="col-md-6"><label class="form-label">Room</label><input type="text" class="form-control" value="<?= esc($student['room_number'] ?? '') ?>" disabled></div>
                    </div>
                    <div class="d-flex justify-content-between mt-4">
                        <a href="<?= base_url('student/profile') ?>" class="btn btn-outline-secondary"><i class="bi bi-arrow-left me-1"></i>Cancel</a>
                        <button type="submit" class="btn btn-primary"><i class="bi bi-check-lg me-1"></i>Update Profile</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<?= $this->endSection() ?>