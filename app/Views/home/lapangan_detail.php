<?= $this->extend('layouts/main') ?>

<?= $this->section('content') ?>
<div class="container py-4">
    <nav aria-label="breadcrumb" class="mb-3 small">
        <ol class="breadcrumb mb-0">
            <li class="breadcrumb-item"><a href="<?= base_url() ?>" class="text-decoration-none" style="color: var(--sr-primary);">Beranda</a></li>
            <li class="breadcrumb-item"><a href="<?= base_url('lapangan') ?>" class="text-decoration-none" style="color: var(--sr-primary);">Lapangan</a></li>
            <li class="breadcrumb-item active" aria-current="page"><?= esc($lapangan['nama_lapangan']) ?></li>
        </ol>
    </nav>

    <div class="row g-4">
        <div class="col-lg-7">
            <div class="sr-card overflow-hidden mb-4">
                <img src="<?= base_url('assets/images/lapangan/' . esc($lapangan['gambar'] ?? 'default-court.jpg')) ?>" class="img-fluid w-100" alt="<?= esc($lapangan['nama_lapangan']) ?>" style="height: 340px; object-fit: cover;">
            </div>
            
            <div class="sr-card p-4">
                <h4 class="h5 fw-bold mb-2">Spesifikasi Lapangan</h4>
                <p class="small text-muted mb-4">
                    <?= esc($lapangan['deskripsi'] ?: 'Lapangan futsal profesional dengan standar kompetisi resmi, dilengkapi penerangan lampu sorot merata, jaring pengaman sekeliling arena, serta sirkulasi udara baik.') ?>
                </p>

                <h5 class="h6 fw-semibold mb-2">Fasilitas Termasuk:</h5>
                <div class="row g-2 text-muted small">
                    <div class="col-sm-6"><i class="bi bi-check text-success fs-5 me-1 align-middle"></i> Ruang ganti dan toilet bersih</div>
                    <div class="col-sm-6"><i class="bi bi-check text-success fs-5 me-1 align-middle"></i> Rompi latihan disediakan</div>
                    <div class="col-sm-6"><i class="bi bi-check text-success fs-5 me-1 align-middle"></i> Papan skor digital</div>
                    <div class="col-sm-6"><i class="bi bi-check text-success fs-5 me-1 align-middle"></i> Area parkir kendaraan luas</div>
                    <div class="col-sm-6"><i class="bi bi-check text-success fs-5 me-1 align-middle"></i> Musholla dan kantin</div>
                    <div class="col-sm-6"><i class="bi bi-check text-success fs-5 me-1 align-middle"></i> Koneksi Wi-Fi gratis</div>
                </div>
            </div>
        </div>

        <div class="col-lg-5">
            <div class="sr-card p-4 sticky-top" style="top: 80px;">
                <div class="d-flex justify-content-between align-items-center mb-2">
                    <span class="badge badge-status-neutral"><?= esc($lapangan['jenis_lantai']) ?></span>
                    <?php if ($lapangan['status'] === 'Tersedia'): ?>
                        <span class="badge badge-status-confirmed">Tersedia</span>
                    <?php else: ?>
                        <span class="badge badge-status-canceled">Tidak Aktif</span>
                    <?php endif; ?>
                </div>

                <h2 class="h4 fw-bold text-dark mb-1"><?= esc($lapangan['nama_lapangan']) ?></h2>
                <div class="sr-court-price fs-4 mb-3">
                    Rp<?= number_format($lapangan['harga_per_jam'], 0, ',', '.') ?> <small class="text-muted fs-6">/ jam</small>
                </div>

                <hr class="my-3" style="border-color: var(--sr-border);">

                <div class="d-grid gap-2">
                    <?php if ($lapangan['status'] === 'Tersedia'): ?>
                        <a href="<?= base_url('customer/booking?lapangan_id=' . $lapangan['id']) ?>" class="btn btn-primary py-2">
                            <i class="bi bi-calendar-plus me-1"></i> Pesan Lapangan Ini
                        </a>
                    <?php else: ?>
                        <button class="btn btn-secondary py-2" disabled>Lapangan Sedang Tidak Aktif</button>
                    <?php endif; ?>
                    <a href="<?= base_url('lapangan') ?>" class="btn btn-outline-secondary btn-sm">
                        Kembali ke Daftar Lapangan
                    </a>
                </div>

                <div class="mt-3 p-2 bg-light rounded text-muted small border">
                    <i class="bi bi-shield-check text-success me-1"></i> Jadwal dilindungi deteksi bentrok otomatis.
                </div>
            </div>
        </div>
    </div>
</div>
<?= $this->endSection() ?>
