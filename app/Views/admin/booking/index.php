<?= $this->extend('layouts/admin') ?>

<?= $this->section('content') ?>
<div class="d-flex flex-column flex-md-row justify-content-between align-items-md-center gap-2 mb-4 pb-2 border-bottom">
    <div>
        <h1 class="h4 fw-bold mb-1">Data Booking Lapangan</h1>
        <p class="small text-muted mb-0">Kelola reservasi jadwal futsal, status pemesanan, dan detail pembayaran pelanggan.</p>
    </div>
    <div>
        <a href="<?= base_url('admin/booking/tambah') ?>" class="btn btn-primary btn-sm">
            <i class="bi bi-plus-lg me-1"></i> Tambah Booking
        </a>
    </div>
</div>

<!-- Filter Sederhana -->
<form action="<?= base_url('admin/booking') ?>" method="get" class="sr-card p-3 mb-4">
    <div class="row g-2 align-items-end">
        <div class="col-md-4">
            <label class="form-label">Pencarian</label>
            <input type="text" name="search" class="form-control form-control-sm" placeholder="Kode, nama penyewa, atau lapangan..." value="<?= esc($filter['search'] ?? '') ?>">
        </div>
        <div class="col-md-3">
            <label class="form-label">Tanggal Main</label>
            <input type="date" name="tanggal" class="form-control form-control-sm" value="<?= esc($filter['tanggal'] ?? '') ?>">
        </div>
        <div class="col-md-3">
            <label class="form-label">Status Booking</label>
            <select name="status" class="form-select form-select-sm">
                <option value="">Semua Status</option>
                <option value="Pending" <?= ($filter['status'] ?? '') === 'Pending' ? 'selected' : '' ?>>Pending</option>
                <option value="Dikonfirmasi" <?= ($filter['status'] ?? '') === 'Dikonfirmasi' ? 'selected' : '' ?>>Dikonfirmasi</option>
                <option value="Selesai" <?= ($filter['status'] ?? '') === 'Selesai' ? 'selected' : '' ?>>Selesai</option>
                <option value="Dibatalkan" <?= ($filter['status'] ?? '') === 'Dibatalkan' ? 'selected' : '' ?>>Dibatalkan</option>
            </select>
        </div>
        <div class="col-md-2 d-flex gap-1">
            <button type="submit" class="btn btn-outline-secondary btn-sm flex-grow-1">Filter</button>
            <a href="<?= base_url('admin/booking') ?>" class="btn btn-link btn-sm text-muted text-decoration-none">Reset</a>
        </div>
    </div>
</form>

<div class="sr-card">
    <div class="table-responsive">
        <table class="table align-middle">
            <thead>
                <tr>
                    <th>Kode</th>
                    <th>Penyewa</th>
                    <th>Lapangan</th>
                    <th>Jadwal Main</th>
                    <th>Durasi</th>
                    <th>Total</th>
                    <th>Status</th>
                    <th>Bayar</th>
                    <th class="text-end" style="width: 140px;">Aksi</th>
                </tr>
            </thead>
            <tbody>
                <?php if (!empty($bookings)): ?>
                    <?php foreach ($bookings as $b): ?>
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
                                    <a href="<?= base_url('admin/booking/detail/' . $b['id']) ?>" class="btn btn-outline-secondary btn-sm" title="Detail">
                                        <i class="bi bi-eye"></i>
                                    </a>
                                    <a href="<?= base_url('admin/booking/edit/' . $b['id']) ?>" class="btn btn-outline-secondary btn-sm" title="Edit">
                                        <i class="bi bi-pencil"></i>
                                    </a>
                                    <?php if ($b['status'] !== 'Dibatalkan'): ?>
                                        <form action="<?= base_url('admin/booking/batalkan/' . $b['id']) ?>" method="post" class="d-inline" onsubmit="return confirm('Batalkan booking <?= esc($b['kode_booking']) ?>?')">
                                            <?= csrf_field() ?>
                                            <button type="submit" class="btn btn-outline-warning btn-sm" title="Batalkan Booking">
                                                <i class="bi bi-x-circle"></i>
                                            </button>
                                        </form>
                                    <?php endif; ?>
                                    <form action="<?= base_url('admin/booking/hapus/' . $b['id']) ?>" method="post" class="d-inline" onsubmit="return confirm('Hapus data booking ini secara permanen?')">
                                        <?= csrf_field() ?>
                                        <button type="submit" class="btn btn-outline-danger btn-sm" title="Hapus">
                                            <i class="bi bi-trash"></i>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="9" class="text-center py-4 text-muted small">Data booking tidak ditemukan.</td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>
<?= $this->endSection() ?>
