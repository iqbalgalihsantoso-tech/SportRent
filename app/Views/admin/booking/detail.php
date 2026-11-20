<?= $this->extend('layouts/admin') ?>

<?= $this->section('content') ?>
<div class="row justify-content-center">
    <div class="col-lg-9">
        <div class="sr-card p-4 mb-4">
            <div class="d-flex justify-content-between align-items-center mb-3 pb-2 border-bottom">
                <div>
                    <span class="small text-muted">Detail Pemesanan</span>
                    <h1 class="h5 fw-bold mb-0 font-monospace text-dark"><?= esc($booking['kode_booking']) ?></h1>
                </div>
                <div class="d-flex gap-2">
                    <?php if ($booking['status'] !== 'Dibatalkan'): ?>
                        <form action="<?= base_url('admin/booking/batalkan/' . $booking['id']) ?>" method="post" class="d-inline" onsubmit="return confirm('Apakah Anda yakin ingin membatalkan pemesanan ini?')">
                            <?= csrf_field() ?>
                            <button type="submit" class="btn btn-outline-warning btn-sm">
                                <i class="bi bi-x-circle me-1"></i> Batalkan Booking
                            </button>
                        </form>
                    <?php endif; ?>
                    <a href="<?= base_url('admin/booking/edit/' . $booking['id']) ?>" class="btn btn-outline-secondary btn-sm">
                        <i class="bi bi-pencil me-1"></i> Edit
                    </a>
                    <a href="<?= base_url('admin/booking') ?>" class="btn btn-outline-secondary btn-sm">
                        <i class="bi bi-arrow-left me-1"></i> Kembali
                    </a>
                </div>
            </div>

            <div class="row g-3 mb-4">
                <div class="col-md-6">
                    <div class="sr-card-subtle p-3 h-100">
                        <div class="small fw-semibold text-uppercase text-muted mb-2">Informasi Pemesan</div>
                        <div class="fw-semibold text-dark"><?= esc($booking['nama_pelanggan']) ?></div>
                        <div class="small text-muted mb-1"><?= esc($booking['email_pelanggan']) ?></div>
                        <div class="small text-muted"><i class="bi bi-phone me-1"></i><?= esc($booking['no_hp_pelanggan'] ?: '-') ?></div>
                    </div>
                </div>

                <div class="col-md-6">
                    <div class="sr-card-subtle p-3 h-100">
                        <div class="small fw-semibold text-uppercase text-muted mb-2">Jadwal & Lapangan</div>
                        <div class="fw-semibold text-dark"><?= esc($booking['nama_lapangan']) ?></div>
                        <div class="small text-muted mb-1"><?= esc($booking['jenis_lantai']) ?> &bull; Rp<?= number_format($booking['harga_per_jam'], 0, ',', '.') ?>/jam</div>
                        <div class="small fw-medium text-dark">
                            <i class="bi bi-calendar3 me-1"></i><?= date('d F Y', strtotime($booking['tanggal_booking'])) ?> &bull; <?= substr($booking['jam_mulai'], 0, 5) ?> WIB (<?= esc($booking['durasi']) ?> Jam)
                        </div>
                    </div>
                </div>
            </div>

            <!-- Pembayaran -->
            <div class="sr-card p-3 mb-4">
                <div class="d-flex justify-content-between align-items-center mb-3 pb-2 border-bottom">
                    <span class="fw-semibold text-dark">Status & Pembayaran</span>
                    <div>
                        <?php if ($booking['status_pembayaran'] === 'Dibayar'): ?>
                            <span class="badge badge-status-confirmed">Lunas (Dibayar)</span>
                        <?php elseif ($booking['status_pembayaran'] === 'Menunggu Verifikasi'): ?>
                            <span class="badge badge-status-warning">Menunggu Verifikasi</span>
                        <?php else: ?>
                            <span class="badge badge-status-neutral"><?= esc($booking['status_pembayaran'] ?: 'Belum Bayar') ?></span>
                        <?php endif; ?>
                    </div>
                </div>

                <div class="row g-3 small">
                    <div class="col-md-4">
                        <div class="text-muted">Total Tagihan:</div>
                        <div class="fs-5 fw-bold text-dark">Rp<?= number_format($booking['total_harga'], 0, ',', '.') ?></div>
                    </div>
                    <div class="col-md-4">
                        <div class="text-muted">Metode:</div>
                        <div class="fw-medium text-dark"><?= esc($booking['metode_pembayaran'] ?: 'Cash / Transfer') ?></div>
                    </div>
                    <div class="col-md-4">
                        <div class="text-muted">Waktu Bayar:</div>
                        <div class="text-dark"><?= $booking['tanggal_pembayaran'] ? date('d M Y H:i', strtotime($booking['tanggal_pembayaran'])) : '-' ?></div>
                    </div>
                </div>

                <?php if ($booking['payment_id']): ?>
                    <form action="<?= base_url('admin/pembayaran/verifikasi/' . $booking['payment_id']) ?>" method="post" class="mt-3 pt-3 border-top d-flex align-items-center gap-2">
                        <?= csrf_field() ?>
                        <label class="small fw-medium text-muted mb-0">Ubah Status:</label>
                        <select name="status_pembayaran" class="form-select form-select-sm w-auto">
                            <option value="Menunggu Verifikasi" <?= $booking['status_pembayaran'] === 'Menunggu Verifikasi' ? 'selected' : '' ?>>Menunggu Verifikasi</option>
                            <option value="Dibayar" <?= $booking['status_pembayaran'] === 'Dibayar' ? 'selected' : '' ?>>Dibayar (Lunas)</option>
                            <option value="Ditolak" <?= $booking['status_pembayaran'] === 'Ditolak' ? 'selected' : '' ?>>Ditolak</option>
                            <option value="Belum Dibayar" <?= $booking['status_pembayaran'] === 'Belum Dibayar' ? 'selected' : '' ?>>Belum Dibayar</option>
                        </select>
                        <button type="submit" class="btn btn-primary btn-sm">Simpan</button>
                    </form>
                <?php endif; ?>
            </div>

            <?php if (!empty($booking['catatan'])): ?>
                <div class="sr-card-subtle p-3 small text-muted">
                    <strong class="text-dark">Catatan:</strong> <?= esc($booking['catatan']) ?>
                </div>
            <?php endif; ?>
        </div>
    </div>
</div>
<?= $this->endSection() ?>
