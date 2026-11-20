<?= $this->extend('layouts/admin') ?>

<?= $this->section('content') ?>
<div class="d-flex flex-column flex-md-row justify-content-between align-items-md-center gap-2 mb-4 pb-2 border-bottom">
    <div>
        <h1 class="h4 fw-bold mb-1">Data Pelanggan</h1>
        <p class="small text-muted mb-0">Informasi akun pengguna terdaftar beserta riwayat pemesanan lapangan futsal.</p>
    </div>
</div>

<div class="sr-card">
    <div class="table-responsive">
        <table class="table align-middle">
            <thead>
                <tr>
                    <th style="width: 50px;">No</th>
                    <th>Nama Pelanggan</th>
                    <th>Email</th>
                    <th>No. WhatsApp / HP</th>
                    <th>Total Booking</th>
                    <th>Terdaftar Sejak</th>
                    <th class="text-end">Status</th>
                </tr>
            </thead>
            <tbody>
                <?php if (!empty($pelanggan)): ?>
                    <?php $no = 1; foreach ($pelanggan as $p): ?>
                        <tr>
                            <td><?= $no++ ?></td>
                            <td class="fw-semibold text-dark"><?= esc($p['nama']) ?></td>
                            <td class="text-muted"><?= esc($p['email']) ?></td>
                            <td class="text-muted"><?= esc($p['no_hp'] ?: '-') ?></td>
                            <td>
                                <span class="badge badge-status-neutral font-monospace">
                                    <?= esc($p['total_booking']) ?> Booking
                                </span>
                            </td>
                            <td class="small text-muted"><?= date('d F Y', strtotime($p['created_at'])) ?></td>
                            <td class="text-end">
                                <span class="badge badge-status-confirmed">Aktif</span>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="7" class="text-center py-4 text-muted small">Belum ada pelanggan terdaftar.</td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>
<?= $this->endSection() ?>
