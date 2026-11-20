<?= $this->extend('layouts/main') ?>

<?= $this->section('content') ?>
<div class="container py-4">
    <div class="row justify-content-center">
        <div class="col-lg-8">
            <div class="sr-card p-4 mb-4">
                <div class="d-flex justify-content-between align-items-center mb-3 pb-2 border-bottom">
                    <div>
                        <span class="small text-muted">Tiket Pemesanan</span>
                        <h1 class="h5 fw-bold mb-0 font-monospace text-dark"><?= esc($booking['kode_booking']) ?></h1>
                    </div>
                    <a href="<?= base_url('customer/riwayat') ?>" class="btn btn-outline-secondary btn-sm">
                        <i class="bi bi-arrow-left me-1"></i> Riwayat
                    </a>
                </div>

                <!-- Status Banner Sederhana -->
                <div class="p-3 mb-4 rounded border <?= $booking['status'] === 'Dikonfirmasi' ? 'bg-light text-dark' : 'bg-light text-dark' ?>">
                    <div class="d-flex flex-column flex-sm-row justify-content-between align-items-sm-center gap-2">
                        <div>
                            <div class="fw-semibold small">
                                Status Booking: 
                                <?php if ($booking['status'] === 'Dikonfirmasi'): ?>
                                    <span class="badge badge-status-confirmed ms-1">Dikonfirmasi</span>
                                <?php elseif ($booking['status'] === 'Pending'): ?>
                                    <span class="badge badge-status-warning ms-1">Pending</span>
                                <?php elseif ($booking['status'] === 'Selesai'): ?>
                                    <span class="badge badge-status-neutral ms-1">Selesai</span>
                                <?php else: ?>
                                    <span class="badge badge-status-canceled ms-1">Dibatalkan</span>
                                <?php endif; ?>
                            </div>
                            <div class="small text-muted mt-1">
                                <?= $booking['status'] === 'Dikonfirmasi' ? 'Jadwal Anda sudah aktif dan terkonfirmasi oleh pengelola arena.' : ($booking['status'] === 'Pending' ? 'Menunggu verifikasi pembayaran oleh pengelola lapangan.' : 'Pemesanan telah selesai atau dibatalkan.') ?>
                            </div>
                        </div>
                        <?php if (!in_array($booking['status'], ['Selesai', 'Dibatalkan'])): ?>
                            <form action="<?= base_url('customer/riwayat/batalkan/' . $booking['id']) ?>" method="post" onsubmit="return confirm('Apakah Anda yakin ingin membatalkan jadwal booking ini?')">
                                <?= csrf_field() ?>
                                <button type="submit" class="btn btn-outline-danger btn-sm">
                                    <i class="bi bi-x-circle me-1"></i> Batalkan Booking
                                </button>
                            </form>
                        <?php endif; ?>
                    </div>
                </div>

                <div class="row g-3 mb-4">
                    <div class="col-md-6">
                        <div class="sr-card-subtle p-3 h-100">
                            <div class="small fw-semibold text-uppercase text-muted mb-2">Rincian Lapangan</div>
                            <div class="fw-semibold text-dark"><?= esc($booking['nama_lapangan']) ?></div>
                            <div class="small text-muted mb-1"><?= esc($booking['jenis_lantai']) ?></div>
                            <div class="small text-muted">Tarif: Rp<?= number_format($booking['harga_per_jam'], 0, ',', '.') ?> / jam</div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="sr-card-subtle p-3 h-100">
                            <div class="small fw-semibold text-uppercase text-muted mb-2">Jadwal Pertandingan</div>
                            <div class="fw-semibold text-dark"><?= date('l, d F Y', strtotime($booking['tanggal_booking'])) ?></div>
                            <div class="small text-muted mt-1">
                                Pukul <strong><?= substr($booking['jam_mulai'], 0, 5) ?> WIB</strong> (Durasi: <?= esc($booking['durasi']) ?> Jam)
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Bagian Pembayaran -->
                <div class="sr-card p-3 mb-4">
                    <h2 class="h6 fw-bold mb-3 pb-2 border-bottom">Informasi Pembayaran</h2>
                    
                    <div class="d-flex justify-content-between align-items-center mb-2">
                        <span class="small text-muted">Total Tagihan:</span>
                        <span class="fs-5 fw-bold text-dark">Rp<?= number_format($booking['total_harga'], 0, ',', '.') ?></span>
                    </div>

                    <div class="d-flex justify-content-between align-items-center mb-2">
                        <span class="small text-muted">Metode:</span>
                        <span class="small fw-medium text-dark"><?= esc($booking['metode_pembayaran']) ?></span>
                    </div>

                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <span class="small text-muted">Status:</span>
                        <div>
                            <?php if ($booking['status_pembayaran'] === 'Dibayar'): ?>
                                <span class="badge badge-status-confirmed">Lunas (Terverifikasi)</span>
                            <?php elseif ($booking['status_pembayaran'] === 'Menunggu Verifikasi'): ?>
                                <span class="badge badge-status-warning">Menunggu Verifikasi</span>
                            <?php else: ?>
                                <span class="badge badge-status-neutral"><?= esc($booking['status_pembayaran'] ?: 'Belum Bayar') ?></span>
                            <?php endif; ?>
                        </div>
                    </div>

                    <div class="p-2 bg-light rounded border small text-muted">
                        <div class="fw-medium text-dark mb-1">Nomor Rekening Tujuan:</div>
                        <div>BCA: <code>1234-567-890</code> a.n SportRent</div>
                        <div>Mandiri: <code>9876-543-210</code> a.n SportRent</div>
                    </div>
                </div>

                <?php if (!empty($booking['catatan'])): ?>
                    <div class="sr-card-subtle p-3 small text-muted">
                        <strong class="text-dark">Catatan:</strong> <?= esc($booking['catatan']) ?>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>
<?= $this->endSection() ?>
