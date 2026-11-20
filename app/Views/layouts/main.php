<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= esc($title ?? 'SportRent - Booking Lapangan Futsal') ?></title>
    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Bootstrap Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <!-- Custom CSS -->
    <link rel="stylesheet" href="<?= base_url('assets/css/style.css') ?>">
</head>
<body>
    <!-- Navbar Sederhana & Bersih -->
    <nav class="navbar navbar-expand-lg sr-navbar sticky-top">
        <div class="container">
            <a class="navbar-brand" href="<?= base_url() ?>">
                <span class="brand-badge"><i class="bi bi-trophy"></i></span>
                <span>Sport<span style="color: var(--sr-primary);">Rent</span></span>
            </a>
            <button class="navbar-toggler border-0 p-1" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-label="Toggle navigation">
                <i class="bi bi-list fs-4"></i>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav me-auto mb-2 mb-lg-0 ms-lg-3">
                    <li class="nav-item">
                        <a class="nav-link <?= (uri_string() == '' || uri_string() == '/') ? 'active' : '' ?>" href="<?= base_url() ?>">Beranda</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link <?= strpos(uri_string(), 'lapangan') === 0 ? 'active' : '' ?>" href="<?= base_url('lapangan') ?>">Lapangan</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link <?= strpos(uri_string(), 'tentang') === 0 ? 'active' : '' ?>" href="<?= base_url('tentang') ?>">Tentang</a>
                    </li>
                </ul>

                <div class="d-flex align-items-center gap-2 pt-2 pt-lg-0">
                    <?php if (session()->get('logged_in')): ?>
                        <?php if (session()->get('role') === 'admin'): ?>
                            <a href="<?= base_url('admin/dashboard') ?>" class="btn btn-outline-secondary btn-sm">
                                <i class="bi bi-speedometer2 me-1"></i> Dashboard Admin
                            </a>
                        <?php else: ?>
                            <a href="<?= base_url('customer/dashboard') ?>" class="btn btn-outline-secondary btn-sm">
                                <i class="bi bi-person me-1"></i> Area Member
                            </a>
                            <a href="<?= base_url('customer/booking') ?>" class="btn btn-primary btn-sm">
                                <i class="bi bi-calendar-plus me-1"></i> Booking Lapangan
                            </a>
                        <?php endif; ?>
                        <a href="<?= base_url('logout') ?>" class="btn btn-outline-danger btn-sm" onclick="return confirm('Apakah Anda yakin ingin keluar?')" title="Logout">
                            <i class="bi bi-box-arrow-right"></i>
                        </a>
                    <?php else: ?>
                        <a href="<?= base_url('login') ?>" class="btn btn-outline-secondary btn-sm">Masuk</a>
                        <a href="<?= base_url('register') ?>" class="btn btn-primary btn-sm">Daftar Akun</a>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </nav>

    <!-- Main Content -->
    <main class="flex-grow-1">
        <?php if (session()->getFlashdata('success')): ?>
            <div class="container pt-3">
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    <i class="bi bi-check-circle me-1"></i> <?= session()->getFlashdata('success') ?>
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            </div>
        <?php endif; ?>

        <?php if (session()->getFlashdata('error')): ?>
            <div class="container pt-3">
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    <i class="bi bi-exclamation-circle me-1"></i> <?= session()->getFlashdata('error') ?>
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            </div>
        <?php endif; ?>

        <?php if (session()->getFlashdata('warning')): ?>
            <div class="container pt-3">
                <div class="alert alert-warning alert-dismissible fade show" role="alert">
                    <i class="bi bi-info-circle me-1"></i> <?= session()->getFlashdata('warning') ?>
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            </div>
        <?php endif; ?>

        <?= $this->renderSection('content') ?>
    </main>

    <!-- Footer Sederhana & Fungsional -->
    <footer class="sr-footer">
        <div class="container">
            <div class="row g-4 mb-4">
                <div class="col-lg-5 col-md-6">
                    <div class="d-flex align-items-center gap-2 mb-2">
                        <span class="brand-badge"><i class="bi bi-trophy"></i></span>
                        <span class="fw-bold text-dark">SportRent</span>
                    </div>
                    <p class="small mb-3" style="max-width: 380px;">
                        Platform online untuk mempermudah pemesanan lapangan futsal dengan pengecekan jadwal real-time, harga transparan, dan pengelolaan mandiri.
                    </p>
                    <div class="small text-muted">
                        <i class="bi bi-geo-alt me-1"></i> Jl. ZA. Pagar Alam No.93, Bandar Lampung
                    </div>
                </div>
                <div class="col-lg-3 col-md-3 col-6">
                    <h6>Navigasi</h6>
                    <ul class="list-unstyled small d-flex flex-column gap-1 mb-0">
                        <li><a href="<?= base_url() ?>">Beranda</a></li>
                        <li><a href="<?= base_url('lapangan') ?>">Daftar Lapangan</a></li>
                        <li><a href="<?= base_url('tentang') ?>">Tentang Aplikasi</a></li>
                        <li><a href="<?= base_url('login') ?>">Masuk / Daftar</a></li>
                    </ul>
                </div>
                <div class="col-lg-4 col-md-3 col-6">
                    <h6>Informasi Pengembang</h6>
                    <p class="small mb-1 text-dark fw-medium">Iqbal Galih Santoso</p>
                    <p class="small mb-1 text-muted">NPM: 24311147 &bull; Kelas SI24B</p>
                    <p class="small text-muted mb-0">Universitas Teknokrat Indonesia</p>
                </div>
            </div>
            <div class="pt-3 border-top d-flex flex-column flex-md-row justify-content-between align-items-center gap-2 small text-muted">
                <span>&copy; <?= date('Y') ?> SportRent. Futsal Court Booking Management System.</span>
                <span>UTS Pemrograman Web</span>
            </div>
        </div>
    </footer>

    <!-- Bootstrap 5 JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <?= $this->renderSection('scripts') ?>
</body>
</html>
