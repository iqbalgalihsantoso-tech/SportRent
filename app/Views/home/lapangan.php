<?= $this->extend('layouts/main') ?>

<?= $this->section('content') ?>
<div class="py-4 bg-white border-bottom mb-4">
    <div class="container">
        <h1 class="h4 fw-bold mb-1">Daftar Lapangan Futsal</h1>
        <p class="small text-muted mb-0">Lihat spesifikasi teknis lantai, fasilitas arena, dan tarif sewa per jam.</p>
    </div>
</div>

<div class="container mb-5">
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
                                <?= esc($lap['deskripsi'] ?: 'Lapangan representatif dengan standar kompetisi dan fasilitas lengkap.') ?>
                            </p>
                            <div class="pt-2 border-top d-flex justify-content-between align-items-center">
                                <div class="sr-court-price">
                                    Rp<?= number_format($lap['harga_per_jam'], 0, ',', '.') ?> <small>/ jam</small>
                                </div>
                                <div class="d-flex gap-1">
                                    <a href="<?= base_url('lapangan/detail/' . $lap['id']) ?>" class="btn btn-outline-secondary btn-sm">Detail</a>
                                    <?php if ($lap['status'] === 'Tersedia'): ?>
                                        <a href="<?= base_url('customer/booking?lapangan_id=' . $lap['id']) ?>" class="btn btn-primary btn-sm">Booking</a>
                                    <?php else: ?>
                                        <button class="btn btn-secondary btn-sm" disabled>Tutup</button>
                                    <?php endif; ?>
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
<?= $this->endSection() ?>
