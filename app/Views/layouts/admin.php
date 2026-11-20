<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= esc($title ?? 'Panel Admin - SportRent') ?></title>
    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Bootstrap Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <!-- Custom CSS -->
    <link rel="stylesheet" href="<?= base_url('assets/css/style.css') ?>">
</head>
<body>
    <div class="sr-admin-wrapper">
        <!-- Sidebar Bersih & Terstruktur -->
        <aside class="sr-admin-sidebar" id="adminSidebar">
            <div class="sr-admin-sidebar-header">
                <a href="<?= base_url('admin/dashboard') ?>" class="text-decoration-none d-flex align-items-center gap-2">
                    <span class="brand-badge"><i class="bi bi-shield-lock"></i></span>
                    <span class="fw-bold text-dark fs-6">SportRent <span class="badge badge-status-neutral ms-1" style="font-size: 0.65rem;">ADMIN</span></span>
                </a>
                <button type="button" class="btn btn-sm btn-link text-muted d-lg-none p-0" id="sidebarCloseBtn">
                    <i class="bi bi-x-lg"></i>
                </button>
            </div>

            <div class="p-3 border-bottom">
                <div class="d-flex align-items-center gap-2">
                    <div class="rounded-circle d-flex align-items-center justify-content-center" style="width: 34px; height: 34px; background: var(--sr-primary-light); color: var(--sr-primary-dark); font-weight: 600; font-size: 0.85rem;">
                        <?= strtoupper(substr(session()->get('nama') ?? 'A', 0, 1)) ?>
                    </div>
                    <div class="overflow-hidden">
                        <div class="small fw-semibold text-dark text-truncate" style="max-width: 160px;"><?= esc(session()->get('nama')) ?></div>
                        <div class="text-muted" style="font-size: 0.75rem;"><?= esc(session()->get('email')) ?></div>
                    </div>
                </div>
            </div>

            <nav class="sr-admin-nav-group">
                <div class="sr-admin-nav-label">Menu Utama</div>
                
                <a class="sr-admin-nav-link <?= uri_string() === 'admin/dashboard' ? 'active' : '' ?>" href="<?= base_url('admin/dashboard') ?>">
                    <i class="bi bi-grid"></i>
                    <span>Dashboard</span>
                </a>

                <a class="sr-admin-nav-link <?= strpos(uri_string(), 'admin/booking') === 0 ? 'active' : '' ?>" href="<?= base_url('admin/booking') ?>">
                    <i class="bi bi-calendar2-check"></i>
                    <span>Data Booking</span>
                </a>

                <a class="sr-admin-nav-link <?= strpos(uri_string(), 'admin/lapangan') === 0 ? 'active' : '' ?>" href="<?= base_url('admin/lapangan') ?>">
                    <i class="bi bi-bounding-box"></i>
                    <span>Data Lapangan</span>
                </a>

                <a class="sr-admin-nav-link <?= strpos(uri_string(), 'admin/pembayaran') === 0 ? 'active' : '' ?>" href="<?= base_url('admin/pembayaran') ?>">
                    <i class="bi bi-credit-card"></i>
                    <span>Pembayaran</span>
                </a>

                <a class="sr-admin-nav-link <?= strpos(uri_string(), 'admin/pelanggan') === 0 ? 'active' : '' ?>" href="<?= base_url('admin/pelanggan') ?>">
                    <i class="bi bi-people"></i>
                    <span>Pelanggan</span>
                </a>

                <a class="sr-admin-nav-link <?= strpos(uri_string(), 'admin/laporan') === 0 ? 'active' : '' ?>" href="<?= base_url('admin/laporan') ?>">
                    <i class="bi bi-file-earmark-text"></i>
                    <span>Laporan</span>
                </a>

                <div class="sr-admin-nav-label mt-3">Lainnya</div>

                <a class="sr-admin-nav-link <?= uri_string() === 'tentang' ? 'active' : '' ?>" href="<?= base_url('tentang') ?>">
                    <i class="bi bi-info-circle"></i>
                    <span>Tentang Pengembang</span>
                </a>

                <a class="sr-admin-nav-link" href="<?= base_url() ?>" target="_blank">
                    <i class="bi bi-box-arrow-up-right"></i>
                    <span>Lihat Website</span>
                </a>
            </nav>

            <div class="p-3 border-top mt-auto">
                <a href="<?= base_url('logout') ?>" class="btn btn-outline-danger btn-sm w-100 d-flex align-items-center justify-content-center gap-2" onclick="return confirm('Apakah Anda yakin ingin logout?')">
                    <i class="bi bi-box-arrow-left"></i> Keluar
                </a>
            </div>
        </aside>

        <!-- Admin Content Area -->
        <div class="sr-admin-content">
            <!-- Topbar -->
            <header class="sr-admin-topbar">
                <div class="d-flex align-items-center gap-2">
                    <button class="btn btn-sm btn-outline-secondary d-lg-none" id="sidebarToggle" type="button" aria-label="Toggle Sidebar">
                        <i class="bi bi-list fs-5"></i>
                    </button>
                    <span class="fw-semibold text-dark"><?= esc($title ?? 'Panel Admin') ?></span>
                </div>
                <div class="d-flex align-items-center gap-3">
                    <span class="small text-muted d-none d-sm-inline"><i class="bi bi-calendar3 me-1"></i><?= date('d M Y') ?></span>
                    <a href="<?= base_url('logout') ?>" class="btn btn-sm btn-link text-muted text-decoration-none p-0" onclick="return confirm('Keluar dari sesi admin?')" title="Logout">
                        <i class="bi bi-power fs-5"></i>
                    </a>
                </div>
            </header>

            <!-- Main Content Container -->
            <div class="sr-admin-main">
                <?php if (session()->getFlashdata('success')): ?>
                    <div class="alert alert-success alert-dismissible fade show mb-3" role="alert">
                        <i class="bi bi-check-circle me-1"></i> <?= session()->getFlashdata('success') ?>
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    </div>
                <?php endif; ?>

                <?php if (session()->getFlashdata('error')): ?>
                    <div class="alert alert-danger alert-dismissible fade show mb-3" role="alert">
                        <i class="bi bi-exclamation-circle me-1"></i> <?= session()->getFlashdata('error') ?>
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    </div>
                <?php endif; ?>

                <?php if (session()->getFlashdata('warning')): ?>
                    <div class="alert alert-warning alert-dismissible fade show mb-3" role="alert">
                        <i class="bi bi-info-circle me-1"></i> <?= session()->getFlashdata('warning') ?>
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    </div>
                <?php endif; ?>

                <?= $this->renderSection('content') ?>
            </div>

            <!-- Footer Admin -->
            <footer class="border-top py-2 px-4 bg-white small text-muted text-center">
                SportRent Futsal Management System &bull; UTS Pemrograman Web &bull; Iqbal Galih Santoso (24311147)
            </footer>
        </div>
    </div>

    <!-- Bootstrap 5 JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        const sidebar = document.getElementById('adminSidebar');
        document.getElementById('sidebarToggle')?.addEventListener('click', () => {
            sidebar?.classList.toggle('show');
        });
        document.getElementById('sidebarCloseBtn')?.addEventListener('click', () => {
            sidebar?.classList.remove('show');
        });
    </script>
    <?= $this->renderSection('scripts') ?>
</body>
</html>
