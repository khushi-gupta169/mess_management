<?= $this->extend('student/layouts/main') ?>
<?= $this->section('content') ?>
<div class="row">
    <div class="col-lg-4 mb-4">
        <div class="card stat-card">
            <div class="card-body text-center py-5">
                <div class="mb-3"><i class="bi bi-person-circle text-primary" style="font-size:5rem;"></i></div>
                <h4 class="mb-1"><?= esc($student['name']) ?></h4>
                <p class="text-muted mb-3"><?= esc($student['email']) ?></p>
                <?php if (!empty($student['student_id'])): ?>
                    <span class="badge bg-primary fs-6"><?= esc($student['student_id']) ?></span>
                <?php endif; ?>
                <?php if (!empty($student['status'])): ?>
                    <span class="badge bg-<?= $student['status']==='active'?'success':'secondary' ?> fs-6 ms-1"><?= ucfirst(esc($student['status'])) ?></span>
                <?php endif; ?>
            </div>
            <div class="card-footer bg-white text-center">
                <a href="<?= base_url('student/profile/edit') ?>" class="btn btn-primary"><i class="bi bi-pencil-square me-1"></i>Edit Profile</a>
            </div>
        </div>
    </div>
    <div class="col-lg-8 mb-4">
        <div class="card stat-card">
            <div class="card-header bg-white py-3"><h5 class="mb-0"><i class="bi bi-person-lines-fill me-2 text-primary"></i>Personal Information</h5></div>
            <div class="card-body">
                <div class="row mb-3">
                    <div class="col-md-6"><label class="text-muted small">Full Name</label><p class="fw-semibold mb-0"><?= esc($student['name'] ?? '-') ?></p></div>
                    <div class="col-md-6"><label class="text-muted small">Email</label><p class="fw-semibold mb-0"><?= esc($student['email'] ?? '-') ?></p></div>
                </div>
                <div class="row mb-3">
                    <div class="col-md-6"><label class="text-muted small">Student ID</label><p class="fw-semibold mb-0"><?= esc($student['student_id'] ?? '-') ?></p></div>
                    <div class="col-md-6"><label class="text-muted small">Enrollment No.</label><p class="fw-semibold mb-0"><?= esc($student['enrollment_number'] ?? '-') ?></p></div>
                </div>
                <div class="row mb-3">
                    <div class="col-md-6"><label class="text-muted small">Mobile</label><p class="fw-semibold mb-0"><?= esc($student['mobile'] ?? '-') ?></p></div>
                    <div class="col-md-6"><label class="text-muted small">Date of Birth</label><p class="fw-semibold mb-0"><?= !empty($student['date_of_birth']) ? date('d M Y', strtotime($student['date_of_birth'])) : '-' ?></p></div>
                </div>
                <div class="row mb-3">
                    <div class="col-md-6"><label class="text-muted small">Gender</label><p class="fw-semibold mb-0"><?= esc($student['gender'] ?? '-') ?></p></div>
                    <div class="col-md-6"><label class="text-muted small">Admission Date</label><p class="fw-semibold mb-0"><?= !empty($student['admission_date']) ? date('d M Y', strtotime($student['admission_date'])) : '-' ?></p></div>
                </div>
            </div>
        </div>
        <div class="card stat-card mt-4">
            <div class="card-header bg-white py-3"><h5 class="mb-0"><i class="bi bi-building me-2 text-primary"></i>Academic & Hostel Info</h5></div>
            <div class="card-body">
                <div class="row mb-3">
                    <div class="col-md-6"><label class="text-muted small">Father's Name</label><p class="fw-semibold mb-0"><?= esc($student['father_name'] ?? '-') ?></p></div>
                    <div class="col-md-6"><label class="text-muted small">Mother's Name</label><p class="fw-semibold mb-0"><?= esc($student['mother_name'] ?? '-') ?></p></div>
                </div>
                <div class="row mb-3">
                    <div class="col-md-6"><label class="text-muted small">Course</label><p class="fw-semibold mb-0"><?= esc($student['course'] ?? '-') ?></p></div>
                    <div class="col-md-6"><label class="text-muted small">Branch</label><p class="fw-semibold mb-0"><?= esc($student['branch'] ?? '-') ?></p></div>
                </div>
                <div class="row mb-3">
                    <div class="col-md-4"><label class="text-muted small">Year</label><p class="fw-semibold mb-0"><?= esc($student['year'] ?? '-') ?></p></div>
                    <div class="col-md-4"><label class="text-muted small">Semester</label><p class="fw-semibold mb-0"><?= esc($student['semester'] ?? '-') ?></p></div>
                    <div class="col-md-4"><label class="text-muted small">College</label><p class="fw-semibold mb-0"><?= esc($student['college'] ?? '-') ?></p></div>
                </div>
                <div class="row mb-3">
                    <div class="col-md-6"><label class="text-muted small">Hostel Name</label><p class="fw-semibold mb-0"><?= esc($student['hostel_name'] ?? '-') ?></p></div>
                    <div class="col-md-6"><label class="text-muted small">Room Number</label><p class="fw-semibold mb-0"><?= esc($student['room_number'] ?? '-') ?></p></div>
                </div>
                <div class="row"><div class="col-12"><label class="text-muted small">Address</label><p class="fw-semibold mb-0"><?= esc($student['address'] ?? '-') ?></p></div></div>
            </div>
        </div>
    </div>
</div>
<?= $this->endSection() ?>