<?= $this->extend('layouts/admin') ?>

<?= $this->section('content') ?>
<!-- Header Halaman Dashboard -->
<div class="d-flex flex-column flex-md-row justify-content-between align-items-md-center gap-2 mb-4 pb-2 border-bottom">
    <div>
        <h1 class="h4 fw-bold mb-1">Ringkasan Operasional</h1>
        <p class="small text-muted mb-0">Pantau data lapangan, transaksi booking aktif, dan antrean pembayaran.</p>
    </div>
    <div class="d-flex gap-2">
        <a href="<?= base_url('admin/booking/tambah') ?>" class="btn btn-primary btn-sm">
            <i class="bi bi-plus-lg me-1"></i> Tambah Booking
        </a>
        <a href="<?= base_url('admin/lapangan/tambah') ?>" class="btn btn-outline-secondary btn-sm">
            <i class="bi bi-plus-lg me-1"></i> Tambah Lapangan
        </a>
    </div>
</div>

<!-- 4 Statistik Sederhana & Fungsional (Tanpa Warna Mencolok) -->
<div class="row g-3 mb-4">
    <div class="col-sm-6 col-xl-3">
        <div class="sr-stat">
            <div class="sr-stat-label">Total Booking</div>
            <div class="sr-stat-value"><?= esc($totalBooking) ?></div>
            <div class="sr-stat-desc">Seluruh transaksi terdata</div>
        </div>
    </div>
    <div class="col-sm-6 col-xl-3">
        <div class="sr-stat">
            <div class="sr-stat-label">Booking Pending</div>
            <div class="sr-stat-value" style="color: var(--sr-warning);"><?= esc($bookingPending) ?></div>
            <div class="sr-stat-desc">Menunggu konfirmasi</div>
        </div>
    </div>
    <div class="col-sm-6 col-xl-3">
        <div class="sr-stat">
            <div class="sr-stat-label">Total Pelanggan</div>
            <div class="sr-stat-value"><?= esc($totalPelanggan) ?></div>
            <div class="sr-stat-desc">Member terdaftar</div>
        </div>
    </div>
    <div class="col-sm-6 col-xl-3">
        <div class="sr-stat">
            <div class="sr-stat-label">Total Lapangan</div>
            <div class="sr-stat-value"><?= esc($totalLapangan) ?></div>
            <div class="sr-stat-desc">Fasilitas arena</div>
        </div>
    </div>
</div>

<!-- 2 Kolom: Jadwal Hari Ini & Antrean Pembayaran -->
<div class="row g-4 mb-4">
    <!-- Jadwal Main Hari Ini -->
    <div class="col-lg-6">
        <div class="sr-card h-100">
            <div class="p-3 border-bottom d-flex justify-content-between align-items-center">
                <div>
                    <h2 class="h6 fw-bold mb-0">Jadwal Pertandingan Hari Ini</h2>
                    <span class="small text-muted"><?= date('d F Y') ?></span>
                </div>
                <span class="badge badge-status-neutral"><?= count($todayBookings) ?> Jadwal</span>
            </div>
            <div class="table-responsive">
                <table class="table align-middle">
                    <thead>
                        <tr>
                            <th>Waktu</th>
                            <th>Lapangan</th>
                            <th>Penyewa</th>
                            <th>Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (!empty($todayBookings)): ?>
                            <?php foreach ($todayBookings as $tb): ?>
                                <tr>
                                    <td class="fw-semibold text-dark font-monospace"><?= substr($tb['jam_mulai'], 0, 5) ?> WIB</td>
                                    <td><?= esc($tb['nama_lapangan']) ?></td>
                                    <td>
                                        <div class="fw-medium"><?= esc($tb['nama_pelanggan']) ?></div>
                                        <div class="small text-muted"><?= esc($tb['no_hp_pelanggan'] ?: '-') ?></div>
                                    </td>
                                    <td>
                                        <?php if ($tb['status'] === 'Dikonfirmasi'): ?>
                                            <span class="badge badge-status-confirmed">Dikonfirmasi</span>
                                        <?php elseif ($tb['status'] === 'Pending'): ?>
                                            <span class="badge badge-status-warning">Pending</span>
                                        <?php else: ?>
                                            <span class="badge badge-status-neutral"><?= esc($tb['status']) ?></span>
                                        <?php endif; ?>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <tr>
                                <td colspan="4" class="text-center py-4 text-muted small">
                                    Tidak ada jadwal pertandingan untuk hari ini.
                                </td>
                            </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- Antrean Verifikasi Pembayaran -->
    <div class="col-lg-6">
        <div class="sr-card h-100">
            <div class="p-3 border-bottom d-flex justify-content-between align-items-center">
                <div>
                    <h2 class="h6 fw-bold mb-0">Antrean Verifikasi Pembayaran</h2>
                    <span class="small text-muted">Perlu dikonfirmasi oleh admin</span>
                </div>
                <a href="<?= base_url('admin/pembayaran') ?>" class="small text-decoration-none text-muted">Lihat Semua</a>
            </div>
            <div class="table-responsive">
                <table class="table align-middle">
                    <thead>
                        <tr>
                            <th>Kode Booking</th>
                            <th>Pelanggan</th>
                            <th>Nominal</th>
                            <th class="text-end">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (!empty($pendingPayments)): ?>
                            <?php foreach ($pendingPayments as $pay): ?>
                                <tr>
                                    <td>
                                        <span class="font-monospace small fw-semibold"><?= esc($pay['kode_booking']) ?></span>
                                        <div class="small text-muted"><?= esc($pay['metode_pembayaran']) ?></div>
                                    </td>
                                    <td><?= esc($pay['nama_pelanggan']) ?></td>
                                    <td class="fw-semibold">Rp<?= number_format($pay['jumlah_pembayaran'], 0, ',', '.') ?></td>
                                    <td class="text-end">
                                        <form action="<?= base_url('admin/pembayaran/verifikasi/' . $pay['id']) ?>" method="post" class="d-inline">
                                            <?= csrf_field() ?>
                                            <input type="hidden" name="status_pembayaran" value="Dibayar">
                                            <button type="submit" class="btn btn-outline-success btn-sm">
                                                Setujui
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <tr>
                                <td colspan="4" class="text-center py-4 text-muted small">
                                    Tidak ada antrean pembayaran yang pending.
                                </td>
                            </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<!-- Tabel Booking Terbaru -->
<div class="sr-card">
    <div class="p-3 border-bottom d-flex justify-content-between align-items-center">
        <div>
            <h2 class="h6 fw-bold mb-0">Pemesanan Lapangan Terbaru</h2>
            <span class="small text-muted">Daftar booking yang baru masuk</span>
        </div>
        <a href="<?= base_url('admin/booking') ?>" class="small text-decoration-none" style="color: var(--sr-primary);">
            Buka Kelola Booking <i class="bi bi-arrow-right"></i>
        </a>
    </div>

    <div class="table-responsive">
        <table class="table align-middle">
            <thead>
                <tr>
                    <th>Kode Booking</th>
                    <th>Nama Pelanggan</th>
                    <th>Lapangan</th>
                    <th>Tanggal & Waktu</th>
                    <th>Durasi</th>
                    <th>Total Biaya</th>
                    <th>Status</th>
                    <th class="text-end">Aksi</th>
                </tr>
            </thead>
            <tbody>
                <?php if (!empty($recentBookings)): ?>
                    <?php foreach ($recentBookings as $b): ?>
                        <tr>
                            <td><span class="font-monospace small fw-semibold text-dark"><?= esc($b['kode_booking']) ?></span></td>
                            <td>
                                <div class="fw-medium"><?= esc($b['nama_pelanggan']) ?></div>
                                <div class="small text-muted"><?= esc($b['no_hp_pelanggan'] ?: '-') ?></div>
                            </td>
                            <td><?= esc($b['nama_lapangan']) ?></td>
                            <td>
                                <div><?= date('d M Y', strtotime($b['tanggal_booking'])) ?></div>
                                <div class="small text-muted"><?= substr($b['jam_mulai'], 0, 5) ?> WIB</div>
                            </td>
                            <td><?= esc($b['durasi']) ?> Jam</td>
                            <td class="fw-semibold">Rp<?= number_format($b['total_harga'], 0, ',', '.') ?></td>
                            <td>
                                <?php if ($b['status'] === 'Dikonfirmasi'): ?>
                                    <span class="badge badge-status-confirmed">Dikonfirmasi</span>
                                <?php elseif ($b['status'] === 'Pending'): ?>
                                    <span class="badge badge-status-warning">Pending</span>
                                <?php elseif ($b['status'] === 'Selesai'): ?>
                                    <span class="badge badge-status-neutral">Selesai</span>
                                <?php else: ?>
                                    <span class="badge badge-status-canceled">Dibatalkan</span>
                                <?php endif; ?>
                            </td>
                            <td class="text-end">
                                <a href="<?= base_url('admin/booking/detail/' . $b['id']) ?>" class="btn btn-outline-secondary btn-sm">
                                    Detail
                                </a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="8" class="text-center py-4 text-muted small">
                            Belum ada riwayat transaksi booking.
                        </td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>
<?= $this->endSection() ?>
