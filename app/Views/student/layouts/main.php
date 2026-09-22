<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $title ?? 'Student Dashboard' ?> - Girls Hostel Mess</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css">
    <style>
        .sidebar {
            min-height: 100vh;
            background: linear-gradient(180deg, #667eea 0%, #764ba2 100%);
            color: white;
        }
        .sidebar .nav-link {
            color: rgba(255,255,255,0.8);
            padding: 12px 20px;
            border-radius: 8px;
            margin-bottom: 5px;
            transition: all 0.3s;
        }
        .sidebar .nav-link:hover, .sidebar .nav-link.active {
            background: rgba(255,255,255,0.15);
            color: white;
        }
        .stat-card {
            border-radius: 15px;
            border: none;
            box-shadow: 0 2px 10px rgba(0,0,0,0.08);
        }
        .gradient-purple {
            background: linear-gradient(135deg, #667eea 0%, #7642ba 100%);
            color: white;
        }
    </style>
</head>
<body>
    <div class="container-fluid">
        <div class="row">
            <!-- Sidebar -->
            <div class="col-md-2 sidebar p-0">
                <div class="p-4">
                    <h4 class="mb-0"><i class="bi bi-house-heart-fill me-2"></i>Hostel Mess</h4>
                    <p class="small mb-4">Student Portal</p>

                    <nav class="nav flex-column">
                        <a class="nav-link <?= ($title ?? '') === 'Student Dashboard' ? 'active' : '' ?>" href="<?= base_url('student/dashboard') ?>">
                            <i class="bi bi-speedometer2 me-2"></i>Dashboard
                        </a>
                        <a class="nav-link <?= ($title ?? '') === 'My Profile' ? 'active' : '' ?>" href="<?= base_url('student/profile') ?>">
                            <i class="bi bi-person me-2"></i>My Profile
                        </a>
                        <a class="nav-link <?= ($title ?? '') === 'Weekly Menu' ? 'active' : '' ?>" href="<?= base_url('student/menu') ?>">
                            <i class="bi bi-book me-2"></i>Weekly Menu
                        </a>
                        <a class="nav-link <?= ($title ?? '') === 'Extra Meal' ? 'active' : '' ?>" href="<?= base_url('student/extra-meals') ?>">
                            <i class="bi bi-plus-circle me-2"></i>Extra Meal
                        </a>
                        <a class="nav-link <?= ($title ?? '') === 'Payments' ? 'active' : '' ?>" href="<?= base_url('student/payments') ?>">
                            <i class="bi bi-wallet2 me-2"></i>Payments
                        </a>
                        <hr class="bg-white">
                        <a class="nav-link" href="<?= base_url('logout') ?>">
                            <i class="bi bi-box-arrow-right me-2"></i>Logout
                        </a>
                    </nav>
                </div>
            </div>

            <!-- Main Content -->
            <div class="col-md-10 p-4">
                <!-- Header -->
                <div class="d-flex justify-content-between align-items-center mb-4">
                    <div>
                        <h2><?= $title ?? 'Dashboard' ?></h2>
                    </div>
                    <div>
                        <span class="badge bg-success fs-6"><?= date('d M Y') ?></span>
                    </div>
                </div>

                <!-- Flash Messages -->
                <?php if (session()->getFlashdata('success')): ?>
                    <div class="alert alert-success alert-dismissible fade show">
                        <i class="bi bi-check-circle me-2"></i><?= session()->getFlashdata('success') ?>
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    </div>
                <?php endif; ?>

                <?php if (session()->getFlashdata('error')): ?>
                    <div class="alert alert-danger alert-dismissible fade show">
                        <i class="bi bi-exclamation-circle me-2"></i><?= session()->getFlashdata('error') ?>
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    </div>
                <?php endif; ?>

                <!-- Page Content -->
                <?= $this->renderSection('content') ?>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>