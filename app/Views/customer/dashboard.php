<?= $this->extend('layouts/main') ?>

<?= $this->section('content') ?>
<div class="container py-4">
    <!-- Header Ringkas & Bersih -->
    <div class="d-flex flex-column flex-md-row justify-content-between align-items-md-center gap-3 mb-4 pb-3 border-bottom">
        <div>
            <span class="badge badge-status-neutral mb-1">Area Member</span>
            <h1 class="h4 fw-bold mb-0">Halo, <?= esc($user['nama'] ?? session()->get('nama')) ?></h1>
            <p class="small text-muted mb-0"><?= esc($user['email'] ?? session()->get('email')) ?> &bull; <?= esc($user['no_hp'] ?: 'Nomor HP -') ?></p>
        </div>
        <div class="d-flex gap-2">
            <a href="<?= base_url('customer/booking') ?>" class="btn btn-primary btn-sm">
                <i class="bi bi-calendar-plus me-1"></i> Pesan Lapangan
            </a>
            <a href="<?= base_url('customer/riwayat') ?>" class="btn btn-outline-secondary btn-sm">
                Riwayat Pemesanan
            </a>
        </div>
    </div>

    <!-- 3 Metrik Sederhana -->
    <div class="row g-3 mb-4">
        <div class="col-md-4 col-sm-6">
            <div class="sr-stat">
                <div class="sr-stat-label">Total Booking</div>
                <div class="sr-stat-value"><?= esc($myTotalBooking) ?></div>
                <div class="sr-stat-desc">Semua pemesanan Anda</div>
            </div>
        </div>
        <div class="col-md-4 col-sm-6">
            <div class="sr-stat">
                <div class="sr-stat-label">Siap Main (Aktif)</div>
                <div class="sr-stat-value" style="color: var(--sr-primary);"><?= esc($myActiveBooking) ?></div>
                <div class="sr-stat-desc">Jadwal yang telah dikonfirmasi</div>
            </div>
        </div>
        <div class="col-md-4 col-sm-12">
            <div class="sr-stat">
                <div class="sr-stat-label">Menunggu Pembayaran</div>
                <div class="sr-stat-value" style="color: var(--sr-warning);"><?= esc($myPendingBooking) ?></div>
                <div class="sr-stat-desc">Perlu verifikasi pembayaran</div>
            </div>
        </div>
    </div>

    <!-- Jadwal Mendatang & Shortcut Booking -->
    <div class="row g-4 mb-4">
        <!-- Kolom Kiri: Jadwal Mendatang -->
        <div class="col-lg-7">
            <div class="sr-card h-100">
                <div class="p-3 border-bottom d-flex justify-content-between align-items-center">
                    <div>
                        <h2 class="h6 fw-bold mb-0">Jadwal Pertandingan Mendatang</h2>
                        <span class="small text-muted">Jadwal main Anda yang terdaftar</span>
                    </div>
                    <span class="badge badge-status-neutral"><?= count($upcomingBookings) ?> Tiket</span>
                </div>

                <div class="p-3">
                    <?php if (!empty($upcomingBookings)): ?>
                        <div class="d-flex flex-column gap-2">
                            <?php foreach ($upcomingBookings as $ub): ?>
                                <div class="sr-card-subtle p-3 d-flex flex-column flex-sm-row justify-content-between align-items-sm-center gap-2">
                                    <div>
                                        <div class="d-flex align-items-center gap-2 mb-1">
                                            <span class="font-monospace small fw-semibold text-dark"><?= esc($ub['kode_booking']) ?></span>
                                            <?php if ($ub['status'] === 'Dikonfirmasi'): ?>
                                                <span class="badge badge-status-confirmed">Siap Main</span>
                                            <?php else: ?>
                                                <span class="badge badge-status-warning">Menunggu</span>
                                            <?php endif; ?>
                                        </div>
                                        <div class="fw-semibold text-dark"><?= esc($ub['nama_lapangan']) ?></div>
                                        <div class="small text-muted">
                                            <i class="bi bi-calendar3 me-1"></i><?= date('l, d F Y', strtotime($ub['tanggal_booking'])) ?>
                                            &bull; <i class="bi bi-clock me-1"></i><?= substr($ub['jam_mulai'], 0, 5) ?> WIB (<?= esc($ub['durasi']) ?> Jam)
                                        </div>
                                    </div>
                                    <div class="text-sm-end">
                                        <div class="fw-semibold text-dark mb-1">Rp<?= number_format($ub['total_harga'], 0, ',', '.') ?></div>
                                        <div class="d-inline-flex gap-1">
                                            <a href="<?= base_url('customer/riwayat/detail/' . $ub['id']) ?>" class="btn btn-outline-secondary btn-sm">
                                                Detail
                                            </a>
                                            <?php if (!in_array($ub['status'], ['Selesai', 'Dibatalkan'])): ?>
                                                <form action="<?= base_url('customer/riwayat/batalkan/' . $ub['id']) ?>" method="post" class="d-inline" onsubmit="return confirm('Batalkan jadwal booking ini?')">
                                                    <?= csrf_field() ?>
                                                    <button type="submit" class="btn btn-outline-danger btn-sm" title="Batalkan">
                                                        <i class="bi bi-x-circle"></i>
                                                    </button>
                                                </form>
                                            <?php endif; ?>
                                        </div>
                                    </div>
                                </div>
                            <?php endforeach; ?>
                        </div>
                    <?php else: ?>
                        <div class="text-center py-4 text-muted small">
                            Belum ada jadwal pertandingan aktif.
                            <div class="mt-2">
                                <a href="<?= base_url('customer/booking') ?>" class="btn btn-primary btn-sm">Pesan Lapangan Sekarang</a>
                            </div>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>

        <!-- Kolom Kanan: Pilihan Lapangan Cepat -->
        <div class="col-lg-5">
            <div class="sr-card h-100">
                <div class="p-3 border-bottom d-flex justify-content-between align-items-center">
                    <h2 class="h6 fw-bold mb-0">Pilihan Lapangan</h2>
                    <a href="<?= base_url('lapangan') ?>" class="small text-decoration-none" style="color: var(--sr-primary);">Lihat Semua</a>
                </div>

                <div class="p-3 d-flex flex-column gap-2">
                    <?php foreach ($availableLapangans as $lap): ?>
                        <div class="sr-card-subtle p-2 d-flex justify-content-between align-items-center">
                            <div>
                                <div class="fw-semibold text-dark small"><?= esc($lap['nama_lapangan']) ?></div>
                                <div class="small text-muted"><?= esc($lap['jenis_lantai']) ?> &bull; Rp<?= number_format($lap['harga_per_jam'], 0, ',', '.') ?>/jam</div>
                            </div>
                            <a href="<?= base_url('customer/booking?lapangan_id=' . $lap['id']) ?>" class="btn btn-outline-primary btn-sm">
                                Pesan
                            </a>
                        </div>
                    <?php endforeach; ?>
                </div>
            </div>
        </div>
    </div>

    <!-- Tabel Riwayat Singkat -->
    <div class="sr-card">
        <div class="p-3 border-bottom d-flex justify-content-between align-items-center">
            <div>
                <h2 class="h6 fw-bold mb-0">Riwayat Booking Terakhir</h2>
                <span class="small text-muted">Aktivitas sewa lapangan Anda</span>
            </div>
            <a href="<?= base_url('customer/riwayat') ?>" class="small text-decoration-none text-muted">Lihat Semua</a>
        </div>

        <div class="table-responsive">
            <table class="table align-middle">
                <thead>
                    <tr>
                        <th>Kode Booking</th>
                        <th>Lapangan</th>
                        <th>Tanggal Main</th>
                        <th>Jam</th>
                        <th>Durasi</th>
                        <th>Total</th>
                        <th>Status</th>
                        <th>Pembayaran</th>
                        <th class="text-end">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (!empty($myBookings)): ?>
                        <?php foreach ($myBookings as $b): ?>
                            <tr>
                                <td><span class="font-monospace small fw-semibold text-dark"><?= esc($b['kode_booking']) ?></span></td>
                                <td><?= esc($b['nama_lapangan']) ?></td>
                                <td><?= date('d M Y', strtotime($b['tanggal_booking'])) ?></td>
                                <td><?= substr($b['jam_mulai'], 0, 5) ?> WIB</td>
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
                                <td>
                                    <?php if ($b['status_pembayaran'] === 'Dibayar'): ?>
                                        <span class="badge badge-status-confirmed">Lunas</span>
                                    <?php elseif ($b['status_pembayaran'] === 'Menunggu Verifikasi'): ?>
                                        <span class="badge badge-status-warning">Verifikasi</span>
                                    <?php else: ?>
                                        <span class="badge badge-status-neutral"><?= esc($b['status_pembayaran'] ?: 'Belum Bayar') ?></span>
                                    <?php endif; ?>
                                </td>
                                <td class="text-end">
                                    <a href="<?= base_url('customer/riwayat/detail/' . $b['id']) ?>" class="btn btn-outline-secondary btn-sm">
                                        Detail
                                    </a>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="9" class="text-center py-4 text-muted small">
                                Belum ada riwayat pemesanan. Ingin mulai bermain? 
                                <a href="<?= base_url('customer/booking') ?>" style="color: var(--sr-primary);">Pesan lapangan di sini</a>.
                            </td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>
<?= $this->endSection() ?>
