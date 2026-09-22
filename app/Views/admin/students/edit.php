<?= $this->extend('admin/layouts/main') ?>

<?= $this->section('content') ?>

<!-- Page Header -->
<div class="page-header mb-4">
    <div class="row align-items-center">
        <div class="col-md-6">
            <h2 class="page-title mb-0">
                <i class="fas fa-user-edit me-2"></i>Edit Student
            </h2>
            <p class="text-muted mb-0">Update student information</p>
        </div>
        <div class="col-md-6 text-md-end">
            <a href="<?= base_url('admin/students') ?>" class="btn btn-outline-secondary">
                <i class="fas fa-arrow-left me-1"></i>Back to Students
            </a>
        </div>
    </div>
</div>

<!-- Error Messages -->
<?php if (session()->getFlashdata('errors')): ?>
    <div class="alert alert-danger alert-dismissible fade show" role="alert">
        <h6><i class="fas fa-exclamation-circle me-2"></i>Please fix the following errors:</h6>
        <ul class="mb-0">
            <?php foreach (session()->getFlashdata('errors') as $error): ?>
                <li><?= esc($error) ?></li>
            <?php endforeach; ?>
        </ul>
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
<?php endif; ?>

<?php if (session()->getFlashdata('error')): ?>
    <div class="alert alert-danger alert-dismissible fade show" role="alert">
        <i class="fas fa-exclamation-circle me-2"></i><?= session()->getFlashdata('error') ?>
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
<?php endif; ?>

<!-- Student Form -->
<form action="<?= base_url('admin/students/update/' . $student['id']) ?>" method="POST">
    <?= csrf_field() ?>
    
    <div class="row">
        <!-- Personal Information Card -->
        <div class="col-lg-12">
            <div class="card border-0 shadow-sm mb-4">
                <div class="card-header bg-primary text-white py-3">
                    <h5 class="mb-0">
                        <i class="fas fa-user me-2"></i>Personal Information
                    </h5>
                </div>
                <div class="card-body">
                    <div class="row g-3">
                        <div class="col-md-6">
                            <label for="name" class="form-label">Full Name <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" id="name" name="name" 
                                   value="<?= old('name', $student['name']) ?>" required>
                        </div>
                        <div class="col-md-6">
                            <label for="email" class="form-label">Email <span class="text-danger">*</span></label>
                            <input type="email" class="form-control" id="email" name="email" 
                                   value="<?= old('email', $student['email']) ?>" required>
                        </div>
                        <div class="col-md-6">
                            <label for="password" class="form-label">Password</label>
                            <input type="password" class="form-control" id="password" name="password">
                            <small class="text-muted">Leave blank to keep current password</small>
                        </div>
                        <div class="col-md-6">
                            <label for="mobile" class="form-label">Mobile Number <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" id="mobile" name="mobile" 
                                   value="<?= old('mobile', $student['mobile']) ?>" required>
                        </div>


                        <div class="col-md-4">
                            <label for="date_of_birth" class="form-label">Date of Birth <span class="text-danger">*</span></label>
                            <input type="date" class="form-control" id="date_of_birth" name="date_of_birth" 
                                   value="<?= old('date_of_birth', $student['date_of_birth']) ?>" required>
                        </div>
                        <div class="col-md-4">
                            <label for="gender" class="form-label">Gender <span class="text-danger">*</span></label>
                            <select class="form-select" id="gender" name="gender" required>
                                <option value="">Select Gender</option>
                                <option value="Female" <?= old('gender', $student['gender']) === 'Female' ? 'selected' : '' ?>>Female</option>
                                <option value="Other" <?= old('gender', $student['gender']) === 'Other' ? 'selected' : '' ?>>Other</option>
                            </select>
                        </div>
                        <div class="col-md-4">
                            <label for="status" class="form-label">Status <span class="text-danger">*</span></label>
                            <select class="form-select" id="status" name="status" required>
                                <option value="active" <?= old('status', $student['status']) === 'active' ? 'selected' : '' ?>>Active</option>
                                <option value="inactive" <?= old('status', $student['status']) === 'inactive' ? 'selected' : '' ?>>Inactive</option>
                                <option value="suspended" <?= old('status', $student['status']) === 'suspended' ? 'selected' : '' ?>>Suspended</option>
                            </select>
                        </div>
                        <div class="col-md-6">
                            <label for="father_name" class="form-label">Father's Name <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" id="father_name" name="father_name" 
                                   value="<?= old('father_name', $student['father_name']) ?>" required>
                        </div>
                        <div class="col-md-6">
                            <label for="mother_name" class="form-label">Mother's Name <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" id="mother_name" name="mother_name" 
                                   value="<?= old('mother_name', $student['mother_name']) ?>" required>
                        </div>
                        <div class="col-12">
                            <label for="address" class="form-label">Address <span class="text-danger">*</span></label>
                            <textarea class="form-control" id="address" name="address" rows="3" required><?= old('address', $student['address']) ?></textarea>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Academic Information Card -->
        <div class="col-lg-12">
            <div class="card border-0 shadow-sm mb-4">
                <div class="card-header bg-success text-white py-3">
                    <h5 class="mb-0">
                        <i class="fas fa-graduation-cap me-2"></i>Academic Information
                    </h5>
                </div>
                <div class="card-body">
                    <div class="row g-3">
                        <div class="col-md-6">
                            <label for="student_id" class="form-label">Student ID <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" id="student_id" name="student_id" 
                                   value="<?= old('student_id', $student['student_id']) ?>" required>
                        </div>
                        <div class="col-md-6">
                            <label for="enrollment_number" class="form-label">Enrollment Number <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" id="enrollment_number" name="enrollment_number" 
                                   value="<?= old('enrollment_number', $student['enrollment_number']) ?>" required>
                        <div class="col-md-6">
                            <label for="course" class="form-label">Course <span class="text-danger">*</span></label>
                            <select class="form-select" id="course" name="course" required>
                                <option value="">Select Course</option>
                                <option value="B.Tech" <?= old('course', $student['course']) === 'B.Tech' ? 'selected' : '' ?>>B.Tech</option>
                                <option value="M.Tech" <?= old('course', $student['course']) === 'M.Tech' ? 'selected' : '' ?>>M.Tech</option>
                                <option value="BCA" <?= old('course', $student['course']) === 'BCA' ? 'selected' : '' ?>>BCA</option>
                                <option value="MCA" <?= old('course', $student['course']) === 'MCA' ? 'selected' : '' ?>>MCA</option>
                                <option value="BSc" <?= old('course', $student['course']) === 'BSc' ? 'selected' : '' ?>>BSc</option>
                                <option value="MSc" <?= old('course', $student['course']) === 'MSc' ? 'selected' : '' ?>>MSc</option>
                            </select>
                        </div>
                        <div class="col-md-6">
                            <label for="branch" class="form-label">Branch <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" id="branch" name="branch" 
                                   value="<?= old('branch', $student['branch']) ?>" placeholder="e.g., Computer Science" required>
                        </div>
                        <div class="col-md-4">
                            <label for="year" class="form-label">Year <span class="text-danger">*</span></label>
                            <select class="form-select" id="year" name="year" required>
                                <option value="">Select Year</option>
                                <option value="1" <?= old('year', $student['year']) == '1' ? 'selected' : '' ?>>1st Year</option>
                                <option value="2" <?= old('year', $student['year']) == '2' ? 'selected' : '' ?>>2nd Year</option>
                                <option value="3" <?= old('year', $student['year']) == '3' ? 'selected' : '' ?>>3rd Year</option>
                                <option value="4" <?= old('year', $student['year']) == '4' ? 'selected' : '' ?>>4th Year</option>
                            </select>
                        </div>
                        <div class="col-md-4">
                            <label for="semester" class="form-label">Semester <span class="text-danger">*</span></label>
                            <select class="form-select" id="semester" name="semester" required>
                                <option value="">Select Semester</option>
                                <?php for ($i = 1; $i <= 8; $i++): ?>
                                    <option value="<?= $i ?>" <?= old('semester', $student['semester']) == $i ? 'selected' : '' ?>><?= $i ?></option>
                                <?php endfor; ?>
                            </select>
                        </div>
                        <div class="col-md-4">
                            <label for="admission_date" class="form-label">Admission Date <span class="text-danger">*</span></label>
                            <input type="date" class="form-control" id="admission_date" name="admission_date" 
                                   value="<?= old('admission_date', $student['admission_date']) ?>" required>
                        </div>
                        <div class="col-12">
                            <label for="college" class="form-label">College Name <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" id="college" name="college" 
                                   value="<?= old('college', $student['college']) ?>" required>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Hostel Information Card -->
        <div class="col-lg-12">
            <div class="card border-0 shadow-sm mb-4">
                <div class="card-header bg-info text-white py-3">
                    <h5 class="mb-0">
                        <i class="fas fa-building me-2"></i>Hostel Information
                    </h5>
                </div>
                <div class="card-body">
                    <div class="row g-3">
                        <div class="col-md-6">
                            <label for="hostel_name" class="form-label">Hostel Name <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" id="hostel_name" name="hostel_name" 
                                   value="<?= old('hostel_name', $student['hostel_name']) ?>" required>
                        </div>
                        <div class="col-md-6">
                            <label for="room_number" class="form-label">Room Number <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" id="room_number" name="room_number" 
                                   value="<?= old('room_number', $student['room_number']) ?>" required>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

                        </div>


    <!-- Form Actions -->
    <div class="card border-0 shadow-sm">
        <div class="card-body">
            <div class="d-flex justify-content-between align-items-center">
                <a href="<?= base_url('admin/students') ?>" class="btn btn-secondary">
                    <i class="fas fa-times me-1"></i>Cancel
                </a>
                <button type="submit" class="btn btn-primary px-5">
                    <i class="fas fa-save me-1"></i>Update Student
                </button>
            </div>
        </div>
    </div>
</form>

<?= $this->endSection() ?>
