<?= $this->extend('layouts/admin') ?>

<?= $this->section('content') ?>
<div class="row justify-content-center">
    <div class="col-lg-8">
        <div class="sr-card p-4">
            <div class="d-flex justify-content-between align-items-center mb-3 pb-2 border-bottom">
                <div>
                    <h1 class="h5 fw-bold mb-0">Tambah Booking Manual</h1>
                    <span class="small text-muted">Input pemesanan langsung dari kasir arena</span>
                </div>
                <a href="<?= base_url('admin/booking') ?>" class="btn btn-outline-secondary btn-sm">
                    <i class="bi bi-arrow-left me-1"></i> Kembali
                </a>
            </div>

            <?php if (session()->getFlashdata('errors')): ?>
                <div class="alert alert-danger small p-2 mb-3">
                    <ul class="mb-0 ps-3">
                        <?php foreach (session()->getFlashdata('errors') as $err): ?>
                            <li><?= esc($err) ?></li>
                        <?php endforeach; ?>
                    </ul>
                </div>
            <?php endif; ?>

            <form action="<?= base_url('admin/booking/simpan') ?>" method="post">
                <?= csrf_field() ?>

                <div class="mb-3">
                    <label for="user_id" class="form-label">Pelanggan Terdaftar <span class="text-danger">*</span></label>
                    <select class="form-select" id="user_id" name="user_id" required>
                        <option value="">Pilih Customer</option>
                        <?php foreach ($customers as $c): ?>
                            <option value="<?= $c['id'] ?>" <?= old('user_id') == $c['id'] ? 'selected' : '' ?>>
                                <?= esc($c['nama']) ?> (<?= esc($c['email']) ?> - <?= esc($c['no_hp'] ?: '-') ?>)
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>

                <div class="mb-3">
                    <label for="lapangan_id" class="form-label">Lapangan Futsal <span class="text-danger">*</span></label>
                    <select class="form-select" id="lapangan_id" name="lapangan_id" required>
                        <option value="">Pilih Lapangan</option>
                        <?php foreach ($lapangan as $lap): ?>
                            <option value="<?= $lap['id'] ?>" data-harga="<?= $lap['harga_per_jam'] ?>" <?= old('lapangan_id') == $lap['id'] ? 'selected' : '' ?>>
                                <?= esc($lap['nama_lapangan']) ?> (<?= esc($lap['jenis_lantai']) ?>) - Rp<?= number_format($lap['harga_per_jam'], 0, ',', '.') ?>/jam
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>

                <div class="row g-3 mb-3">
                    <div class="col-md-4">
                        <label for="tanggal_booking" class="form-label">Tanggal Main <span class="text-danger">*</span></label>
                        <input type="date" class="form-control" id="tanggal_booking" name="tanggal_booking" min="<?= date('Y-m-d') ?>" value="<?= old('tanggal_booking', date('Y-m-d')) ?>" required>
                    </div>
                    <div class="col-md-4">
                        <label for="jam_mulai" class="form-label">Jam Mulai <span class="text-danger">*</span></label>
                        <select class="form-select" id="jam_mulai" name="jam_mulai" required>
                            <?php for ($i = 8; $i <= 23; $i++): $val = sprintf('%02d:00:00', $i); ?>
                                <option value="<?= $val ?>" <?= old('jam_mulai') === $val ? 'selected' : '' ?>><?= sprintf('%02d:00', $i) ?> WIB</option>
                            <?php endfor; ?>
                        </select>
                    </div>
                    <div class="col-md-4">
                        <label for="durasi" class="form-label">Durasi (Jam) <span class="text-danger">*</span></label>
                        <input type="number" class="form-control" id="durasi" name="durasi" min="1" max="8" value="<?= old('durasi', 1) ?>" required>
                    </div>
                </div>

                <div class="p-2 bg-light rounded border mb-3 d-flex justify-content-between align-items-center">
                    <div>
                        <div class="small text-muted">Perhitungan Biaya:</div>
                        <div class="small fw-semibold text-dark" id="calcPreview">-</div>
                    </div>
                    <div class="fs-5 fw-bold text-dark" id="totalPreview">Rp0</div>
                </div>

                <div class="mb-3">
                    <label for="status" class="form-label">Status Booking <span class="text-danger">*</span></label>
                    <select class="form-select" id="status" name="status" required>
                        <option value="Pending" <?= old('status') === 'Pending' ? 'selected' : '' ?>>Pending (Menunggu Bayar)</option>
                        <option value="Dikonfirmasi" <?= old('status') === 'Dikonfirmasi' ? 'selected' : '' ?>>Dikonfirmasi (Bayar Kasir)</option>
                        <option value="Selesai" <?= old('status') === 'Selesai' ? 'selected' : '' ?>>Selesai</option>
                    </select>
                </div>

                <div class="mb-4">
                    <label for="catatan" class="form-label">Catatan Tambahan (Opsional)</label>
                    <textarea class="form-control" id="catatan" name="catatan" rows="2" placeholder="Nama tim atau permintaan khusus"><?= old('catatan') ?></textarea>
                </div>

                <div class="d-flex justify-content-end gap-2 pt-2 border-top">
                    <a href="<?= base_url('admin/booking') ?>" class="btn btn-outline-secondary">Batal</a>
                    <button type="submit" class="btn btn-primary">
                        <i class="bi bi-check-lg me-1"></i> Buat Pemesanan
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
<?= $this->endSection() ?>

<?= $this->section('scripts') ?>
<script>
    function updateTotal() {
        const select = document.getElementById('lapangan_id');
        const durasi = parseInt(document.getElementById('durasi').value) || 1;
        const selectedOption = select.options[select.selectedIndex];
        const harga = parseInt(selectedOption?.getAttribute('data-harga')) || 0;
        const total = harga * durasi;

        document.getElementById('calcPreview').innerText = `${durasi} jam x Rp${harga.toLocaleString('id-ID')}`;
        document.getElementById('totalPreview').innerText = `Rp${total.toLocaleString('id-ID')}`;
    }

    document.getElementById('lapangan_id').addEventListener('change', updateTotal);
    document.getElementById('durasi').addEventListener('input', updateTotal);
    window.addEventListener('DOMContentLoaded', updateTotal);
</script>
<?= $this->endSection() ?>
