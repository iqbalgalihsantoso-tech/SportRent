<?= $this->extend('layouts/main') ?>

<?= $this->section('content') ?>
<!-- Hero Section Natural & Fungsional -->
<section class="sr-hero">
    <div class="container">
        <div class="row align-items-center g-4">
            <div class="col-lg-6">
                <span class="badge badge-status-confirmed mb-2">Platform Penyewaan Futsal</span>
                <h1 class="sr-hero-title">Temukan Lapangan Futsal, Atur Jadwal, dan Mulai Bermain.</h1>
                <p class="sr-hero-lead">
                    Cek ketersediaan lapangan secara transparan tanpa khawatir bentrok jadwal. Lakukan booking langsung dari perangkat Anda dan nikmati fasilitas olahraga terbaik.
                </p>
                <div class="d-flex flex-wrap gap-2">
                    <a href="<?= base_url('customer/booking') ?>" class="btn btn-primary px-3 py-2">
                        <i class="bi bi-calendar-plus me-1"></i> Cari & Booking Lapangan
                    </a>
                    <a href="<?= base_url('lapangan') ?>" class="btn btn-outline-secondary px-3 py-2">
                        Lihat Semua Lapangan
                    </a>
                </div>

                <!-- Statistik Sederhana & Nyata -->
                <div class="row g-3 mt-3 pt-3 border-top">
                    <div class="col-4">
                        <div class="fw-bold fs-5 text-dark"><?= esc($stats['total_lapangan']) ?></div>
                        <div class="small text-muted">Lapangan Futsal</div>
                    </div>
                    <div class="col-4">
                        <div class="fw-bold fs-5 text-dark"><?= esc($stats['total_booking']) ?></div>
                        <div class="small text-muted">Total Booking</div>
                    </div>
                    <div class="col-4">
                        <div class="fw-bold fs-5 text-dark"><?= esc($stats['total_pelanggan']) ?></div>
                        <div class="small text-muted">Member Terdaftar</div>
                    </div>
                </div>
            </div>
            <div class="col-lg-6">
                <div class="sr-hero-image-wrap">
                    <img src="<?= base_url('assets/images/lapangan/lapangan-sintetis.jpg') ?>" alt="Lapangan Futsal SportRent">
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Daftar Lapangan Unggulan -->
<section class="py-5">
    <div class="container">
        <div class="d-flex justify-content-between align-items-end mb-4">
            <div>
                <h2 class="h4 fw-bold mb-1">Daftar Lapangan Tersedia</h2>
                <p class="small text-muted mb-0">Pilih lapangan futsal dengan lantai rumput sintetis, vinyl, atau modular interlock.</p>
            </div>
            <a href="<?= base_url('lapangan') ?>" class="small text-success text-decoration-none fw-medium">
                Lihat Semua <i class="bi bi-arrow-right"></i>
            </a>
        </div>

        <div class="row g-4">
            <?php if (!empty($lapangan)): ?>
                <?php foreach ($lapangan as $lap): ?>
                    <div class="col-lg-4 col-md-6">
                        <div class="sr-court-card">
                            <img src="<?= base_url('assets/images/lapangan/' . esc($lap['gambar'] ?? 'default-court.jpg')) ?>" class="sr-court-img" alt="<?= esc($lap['nama_lapangan']) ?>">
                            <div class="sr-court-body">
                                <div class="d-flex justify-content-between align-items-center mb-2">
                                    <span class="badge badge-status-neutral"><?= esc($lap['jenis_lantai']) ?></span>
                                    <?php if ($lap['status'] === 'Tersedia'): ?>
                                        <span class="badge badge-status-confirmed">Tersedia</span>
                                    <?php else: ?>
                                        <span class="badge badge-status-canceled">Tidak Aktif</span>
                                    <?php endif; ?>
                                </div>
                                <h3 class="sr-court-title"><?= esc($lap['nama_lapangan']) ?></h3>
                                <p class="small text-muted mb-3 flex-grow-1">
                                    <?= esc($lap['deskripsi'] ?: 'Fasilitas pencahayaan terang, standar kompetisi, dan jaring pembatas rapi.') ?>
                                </p>
                                <div class="pt-2 border-top d-flex justify-content-between align-items-center">
                                    <div class="sr-court-price">
                                        Rp<?= number_format($lap['harga_per_jam'], 0, ',', '.') ?> <small>/ jam</small>
                                    </div>
                                    <div class="d-flex gap-1">
                                        <a href="<?= base_url('lapangan/detail/' . $lap['id']) ?>" class="btn btn-outline-secondary btn-sm">Detail</a>
                                        <a href="<?= base_url('customer/booking?lapangan_id=' . $lap['id']) ?>" class="btn btn-primary btn-sm">Pesan</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            <?php else: ?>
                <div class="col-12">
                    <div class="sr-card p-4 text-center text-muted small">
                        Belum ada data lapangan tersedia saat ini.
                    </div>
                </div>
            <?php endif; ?>
        </div>
    </div>
</section>

<!-- Cara Kerja / Alur Booking Sederhana -->
<section class="py-5 bg-white border-top border-bottom">
    <div class="container">
        <div class="mb-4 text-center" style="max-width: 580px; margin: 0 auto;">
            <h2 class="h4 fw-bold mb-1">Cara Melakukan Pemesanan</h2>
            <p class="small text-muted">Proses booking mudah hanya dalam 3 langkah tanpa perlu antre di lokasi.</p>
        </div>

        <div class="row g-3">
            <div class="col-md-4">
                <div class="sr-card p-3 h-100">
                    <div class="d-flex align-items-center gap-2 mb-2">
                        <span class="fw-bold text-success fs-5">01</span>
                        <h6 class="mb-0 fw-semibold">Pilih Lapangan & Jadwal</h6>
                    </div>
                    <p class="small text-muted mb-0">Tentukan lapangan futsal, tanggal bermain, dan jam mulai sesuai jadwal luang tim Anda.</p>
                </div>
            </div>
            <div class="col-md-4">
                <div class="sr-card p-3 h-100">
                    <div class="d-flex align-items-center gap-2 mb-2">
                        <span class="fw-bold text-success fs-5">02</span>
                        <h6 class="mb-0 fw-semibold">Konfirmasi & Pembayaran</h6>
                    </div>
                    <p class="small text-muted mb-0">Total biaya dihitung otomatis tanpa biaya tersembunyi. Selesaikan pembayaran transfer atau bayar kasir.</p>
                </div>
            </div>
            <div class="col-md-4">
                <div class="sr-card p-3 h-100">
                    <div class="d-flex align-items-center gap-2 mb-2">
                        <span class="fw-bold text-success fs-5">03</span>
                        <h6 class="mb-0 fw-semibold">Datang & Main</h6>
                    </div>
                    <p class="small text-muted mb-0">Tunjukkan kode tiket pemesanan ke petugas saat tiba di arena dan mulai bermain dengan nyaman.</p>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Kontak & Lokasi -->
<section class="py-5">
    <div class="container">
        <div class="sr-card p-4">
            <div class="row align-items-center g-3">
                <div class="col-md-8">
                    <h3 class="h5 fw-bold mb-1">Punya Pertanyaan atau Butuh Bantuan Reservasi?</h3>
                    <p class="small text-muted mb-0">Hubungi pengelola lapangan SportRent setiap hari operasional pukul 08.00 - 24.00 WIB.</p>
                </div>
                <div class="col-md-4 text-md-end">
                    <a href="https://wa.me/6281234567890" target="_blank" class="btn btn-outline-success">
                        <i class="bi bi-whatsapp me-1"></i> WhatsApp Pengelola
                    </a>
                </div>
            </div>
        </div>
    </div>
</section>
<?= $this->endSection() ?>
