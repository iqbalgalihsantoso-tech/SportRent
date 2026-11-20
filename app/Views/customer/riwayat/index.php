<?= $this->extend('layouts/main') ?>

<?= $this->section('content') ?>
<div class="container py-4">
    <div class="d-flex flex-column flex-sm-row justify-content-between align-items-sm-center gap-2 mb-4 pb-2 border-bottom">
        <div>
            <h1 class="h4 fw-bold mb-1">Riwayat Pemesanan Saya</h1>
            <p class="small text-muted mb-0">Daftar pemesanan lapangan futsal dan status pembayaran Anda.</p>
        </div>
        <div>
            <a href="<?= base_url('customer/booking') ?>" class="btn btn-primary btn-sm">
                <i class="bi bi-plus-lg me-1"></i> Pesan Baru
            </a>
        </div>
    </div>

    <div class="sr-card">
        <div class="table-responsive">
            <table class="table align-middle">
                <thead>
                    <tr>
                        <th>Kode Booking</th>
                        <th>Lapangan</th>
                        <th>Tanggal Main</th>
                        <th>Jam</th>
                        <th>Durasi</th>
                        <th>Total Biaya</th>
                        <th>Status Booking</th>
                        <th>Pembayaran</th>
                        <th class="text-end">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (!empty($bookings)): ?>
                        <?php foreach ($bookings as $b): ?>
                            <tr>
                                <td><span class="font-monospace small fw-semibold text-dark"><?= esc($b['kode_booking']) ?></span></td>
                                <td class="fw-medium"><?= esc($b['nama_lapangan']) ?></td>
                                <td><?= date('d M Y', strtotime($b['tanggal_booking'])) ?></td>
                                <td><span class="badge badge-status-neutral"><?= substr($b['jam_mulai'], 0, 5) ?> WIB</span></td>
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
                                    <div class="d-inline-flex gap-1">
                                        <a href="<?= base_url('customer/riwayat/detail/' . $b['id']) ?>" class="btn btn-outline-secondary btn-sm" title="Lihat Detail">
                                            Detail
                                        </a>
                                        <?php if (!in_array($b['status'], ['Selesai', 'Dibatalkan'])): ?>
                                            <form action="<?= base_url('customer/riwayat/batalkan/' . $b['id']) ?>" method="post" class="d-inline" onsubmit="return confirm('Apakah Anda yakin ingin membatalkan booking <?= esc($b['kode_booking']) ?>?')">
                                                <?= csrf_field() ?>
                                                <button type="submit" class="btn btn-outline-danger btn-sm" title="Batalkan Booking">
                                                    <i class="bi bi-x-circle"></i> Batalkan
                                                </button>
                                            </form>
                                        <?php endif; ?>
                                    </div>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="9" class="text-center py-5 text-muted small">
                                Anda belum memiliki riwayat pemesanan lapangan.
                            </td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>
<?= $this->endSection() ?>
