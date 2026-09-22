<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $title ?? 'Admin Dashboard' ?> - Girls Hostel Mess Management</title>

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    <!-- Custom CSS -->
    <link rel="stylesheet" href="<?= base_url('assets/css/admin.css') ?>">

    <!-- DataTables CSS -->
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/dataTables.bootstrap5.min.css">

    <!-- Chart.js -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

    <!-- Custom JS (cache-bust on deploy) -->
    <script src="<?= base_url('assets/js/admin.js') ?>?v=<?= filemtime(ROOTPATH . 'public/assets/js/admin.js') ?>" defer></script>
</head>
<body>
    <div class="wrapper">
        <!-- Sidebar -->
        <aside class="sidebar">
            <div class="sidebar-header">
                <h3 class="text-primary">Hostel Mess</h3>
                <p class="text-muted">Admin Panel</p>
            </div>

            <div class="sidebar-menu">
                <ul>
                    <li class="menu-item active">
                        <a href="<?= base_url('admin/dashboard') ?>">
                            <i class="fas fa-tachometer-alt"></i>
                            <span>Dashboard</span>
                        </a>
                    </li>
                    <li class="menu-item">
                        <a href="<?= base_url('admin/students') ?>">
                            <i class="fas fa-user-graduate"></i>
                            <span>Students</span>
                        </a>
                    </li>
                    <li class="menu-item">
                        <a href="<?= base_url('admin/kyc') ?>">
                            <i class="fas fa-id-card"></i>
                            <span>KYC Documents</span>
                        </a>
                    </li>
                    <li class="menu-item">
                        <a href="<?= base_url('admin/menus') ?>">
                            <i class="fas fa-utensils"></i>
                            <span>Meal Menus</span>
                        </a>
                    </li>
                    <li class="menu-item">
                        <a href="<?= base_url('admin/holidays') ?>">
                            <i class="fas fa-calendar-alt"></i>
                            <span>Holidays</span>
                        </a>
                    </li>
                    <li class="menu-item">
                        <a href="<?= base_url('admin/extra-meals') ?>">
                            <i class="fas fa-hamburger"></i>
                            <span>Extra Meals</span>
                        </a>
                    </li>
                    <li class="menu-item">
                        <a href="<?= base_url('admin/payments') ?>">
                            <i class="fas fa-rupee-sign"></i>
                            <span>Payments</span>
                        </a>
                    </li>
                    <li class="menu-item">
                        <a href="<?= base_url('admin/reports') ?>">
                            <i class="fas fa-chart-line"></i>
                            <span>Reports</span>
                        </a>
                    </li>
                </ul>
            </div>
        </aside>

        <!-- Main Content -->
        <div class="main-content">
            <!-- Top Navbar -->
            <nav class="navbar navbar-expand-lg navbar-light bg-white shadow-sm">
                <div class="container-fluid">
                    <button class="btn btn-primary d-lg-none" type="button" id="sidebarToggle">
                        <i class="fas fa-bars"></i>
                    </button>

                    <div class="collapse navbar-collapse" id="navbarSupportedContent">
                        <ul class="navbar-nav ms-auto mb-2 mb-lg-0">
                            <li class="nav-item dropdown">
                                <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                                    <i class="fas fa-bell"></i>
                                    <span class="badge bg-danger">3</span>
                                </a>
                                <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdown">
                                    <li><a class="dropdown-item" href="#">New leave request</a></li>
                                    <li><a class="dropdown-item" href="#">Payment due</a></li>
                                    <li><a class="dropdown-item" href="#">New complaint</a></li>
                                </ul>
                            </li>

                            <li class="nav-item dropdown">
                                <a class="nav-link dropdown-toggle" href="#" id="userDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                                    <i class="fas fa-user-circle me-1"></i>
                                    <span><?= session()->get('name') ?? 'Admin' ?></span>
                                </a>
                                <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="userDropdown">
                                    <li><a class="dropdown-item" href="<?= base_url('admin/profile') ?>">Profile</a></li>
                                    <li><a class="dropdown-item" href="<?= base_url('admin/settings') ?>">Settings</a></li>
                                    <li><hr class="dropdown-divider"></li>
                                    <li><a class="dropdown-item" href="<?= base_url('logout') ?>">Logout</a></li>
                                </ul>
                            </li>
                        </ul>
                    </div>
                </div>
            </nav>

            <!-- Page Content -->
            <div class="container-fluid py-4">
                <?= $this->renderSection('content') ?>
            </div>

            <!-- Footer -->
            <footer class="footer">
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-md-6 text-md-start text-center">
                            <p class="mb-0">&copy; <?= date('Y') ?> Girls Hostel Mess Management. All rights reserved.</p>
                        </div>
                        <div class="col-md-6 text-md-end text-center">
                            <p class="mb-0">Version 1.0.0</p>
                        </div>
                    </div>
                </div>
            </footer>
        </div>
    </div>

    <!-- Bootstrap JS Bundle with Popper -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

    <!-- jQuery (must load before DataTables) -->
    <script src="https://code.jquery.com/jquery-3.7.0.min.js"></script>

    <!-- DataTables JS -->
    <script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.6/js/dataTables.bootstrap5.min.js"></script>
</body>
</html>