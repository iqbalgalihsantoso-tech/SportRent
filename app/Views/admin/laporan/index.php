<?= $this->extend('layouts/admin') ?>

<?= $this->section('content') ?>
<div class="d-flex flex-column flex-md-row justify-content-between align-items-md-center gap-2 mb-4 pb-2 border-bottom">
    <div>
        <h1 class="h4 fw-bold mb-1">Laporan Pendapatan & Transaksi</h1>
        <p class="small text-muted mb-0">Rekapitulasi riwayat penyewaan lapangan futsal pada rentang periode tertentu.</p>
    </div>
    <div>
        <button onclick="window.print()" class="btn btn-outline-secondary btn-sm">
            <i class="bi bi-printer me-1"></i> Cetak Laporan
        </button>
    </div>
</div>

<!-- Filter Periode -->
<form action="<?= base_url('admin/laporan') ?>" method="get" class="sr-card p-3 mb-4">
    <div class="row g-2 align-items-end">
        <div class="col-md-4">
            <label class="form-label">Tanggal Mulai</label>
            <input type="date" name="start_date" class="form-control form-control-sm" value="<?= esc($startDate) ?>" required>
        </div>
        <div class="col-md-4">
            <label class="form-label">Tanggal Akhir</label>
            <input type="date" name="end_date" class="form-control form-control-sm" value="<?= esc($endDate) ?>" required>
        </div>
        <div class="col-md-4">
            <button type="submit" class="btn btn-primary btn-sm w-100">
                Tampilkan Rekapitulasi
            </button>
        </div>
    </div>
</form>

<!-- 2 Ringkasan Angka Laporan -->
<div class="row g-3 mb-4">
    <div class="col-md-6">
        <div class="sr-stat">
            <div class="sr-stat-label">Total Transaksi</div>
            <div class="sr-stat-value"><?= count($reports) ?></div>
            <div class="sr-stat-desc">Transaksi pada periode dipilih</div>
        </div>
    </div>
    <div class="col-md-6">
        <div class="sr-stat">
            <div class="sr-stat-label">Pendapatan Terverifikasi</div>
            <div class="sr-stat-value" style="color: var(--sr-primary);">Rp<?= number_format($totalOmset, 0, ',', '.') ?></div>
            <div class="sr-stat-desc">Hanya pembayaran yang berstatus Dibayar</div>
        </div>
    </div>
</div>

<div class="sr-card">
    <div class="table-responsive">
        <table class="table align-middle">
            <thead>
                <tr>
                    <th style="width: 50px;">No</th>
                    <th>Kode</th>
                    <th>Pelanggan</th>
                    <th>Lapangan</th>
                    <th>Tanggal Main</th>
                    <th>Jam</th>
                    <th>Durasi</th>
                    <th>Total</th>
                    <th>Booking</th>
                    <th>Pembayaran</th>
                </tr>
            </thead>
            <tbody>
                <?php if (!empty($reports)): ?>
                    <?php $no = 1; foreach ($reports as $r): ?>
                        <tr>
                            <td><?= $no++ ?></td>
                            <td><span class="font-monospace small fw-semibold text-dark"><?= esc($r['kode_booking']) ?></span></td>
                            <td class="fw-medium"><?= esc($r['nama_pelanggan']) ?></td>
                            <td><?= esc($r['nama_lapangan']) ?></td>
                            <td><?= date('d M Y', strtotime($r['tanggal_booking'])) ?></td>
                            <td><?= substr($r['jam_mulai'], 0, 5) ?> WIB</td>
                            <td><?= esc($r['durasi']) ?> Jam</td>
                            <td class="fw-semibold">Rp<?= number_format($r['total_harga'], 0, ',', '.') ?></td>
                            <td><span class="badge badge-status-neutral"><?= esc($r['status']) ?></span></td>
                            <td>
                                <?php if ($r['status_pembayaran'] === 'Dibayar'): ?>
                                    <span class="badge badge-status-confirmed">Lunas</span>
                                <?php else: ?>
                                    <span class="badge badge-status-neutral"><?= esc($r['status_pembayaran'] ?: 'Belum Bayar') ?></span>
                                <?php endif; ?>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="10" class="text-center py-4 text-muted small">Tidak ada data transaksi pada rentang tanggal tersebut.</td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>
<?= $this->endSection() ?>
