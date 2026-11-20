<?= $this->extend('layouts/admin') ?>

<?= $this->section('content') ?>
<div class="d-flex flex-column flex-md-row justify-content-between align-items-md-center gap-2 mb-4 pb-2 border-bottom">
    <div>
        <h1 class="h4 fw-bold mb-1">Verifikasi Pembayaran</h1>
        <p class="small text-muted mb-0">Periksa bukti transfer dan konfirmasi status pembayaran reservasi lapangan.</p>
    </div>
</div>

<div class="sr-card">
    <div class="table-responsive">
        <table class="table align-middle">
            <thead>
                <tr>
                    <th style="width: 50px;">No</th>
                    <th>Kode Booking</th>
                    <th>Pelanggan</th>
                    <th>Lapangan</th>
                    <th>Jumlah Transfer</th>
                    <th>Metode</th>
                    <th>Status</th>
                    <th>Waktu Pembayaran</th>
                    <th class="text-end" style="width: 180px;">Verifikasi Tindakan</th>
                </tr>
            </thead>
            <tbody>
                <?php if (!empty($payments)): ?>
                    <?php $no = 1; foreach ($payments as $p): ?>
                        <tr>
                            <td><?= $no++ ?></td>
                            <td><span class="font-monospace small fw-semibold text-dark"><?= esc($p['kode_booking']) ?></span></td>
                            <td class="fw-medium"><?= esc($p['nama_pelanggan']) ?></td>
                            <td><?= esc($p['nama_lapangan']) ?></td>
                            <td class="fw-semibold">Rp<?= number_format($p['jumlah_pembayaran'], 0, ',', '.') ?></td>
                            <td><span class="badge badge-status-neutral"><?= esc($p['metode_pembayaran']) ?></span></td>
                            <td>
                                <?php if ($p['status_pembayaran'] === 'Dibayar'): ?>
                                    <span class="badge badge-status-confirmed">Dibayar</span>
                                <?php elseif ($p['status_pembayaran'] === 'Menunggu Verifikasi'): ?>
                                    <span class="badge badge-status-warning">Menunggu</span>
                                <?php elseif ($p['status_pembayaran'] === 'Ditolak'): ?>
                                    <span class="badge badge-status-canceled">Ditolak</span>
                                <?php else: ?>
                                    <span class="badge badge-status-neutral">Belum Bayar</span>
                                <?php endif; ?>
                            </td>
                            <td class="small text-muted"><?= $p['tanggal_pembayaran'] ? date('d M Y H:i', strtotime($p['tanggal_pembayaran'])) : '-' ?></td>
                            <td class="text-end">
                                <form action="<?= base_url('admin/pembayaran/verifikasi/' . $p['id']) ?>" method="post" class="d-inline-flex gap-1 justify-content-end">
                                    <?= csrf_field() ?>
                                    <select name="status_pembayaran" class="form-select form-select-sm" style="width: auto; font-size: 0.8125rem;">
                                        <option value="Dibayar" <?= $p['status_pembayaran'] === 'Dibayar' ? 'selected' : '' ?>>Setujui</option>
                                        <option value="Menunggu Verifikasi" <?= $p['status_pembayaran'] === 'Menunggu Verifikasi' ? 'selected' : '' ?>>Pending</option>
                                        <option value="Ditolak" <?= $p['status_pembayaran'] === 'Ditolak' ? 'selected' : '' ?>>Tolak</option>
                                    </select>
                                    <button type="submit" class="btn btn-outline-secondary btn-sm" title="Simpan">
                                        <i class="bi bi-check-lg"></i>
                                    </button>
                                </form>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="9" class="text-center py-4 text-muted small">Belum ada data pembayaran.</td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>
<?= $this->endSection() ?>
