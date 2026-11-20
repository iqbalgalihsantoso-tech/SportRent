<?= $this->extend('layouts/main') ?>

<?= $this->section('content') ?>
<div class="container py-4">
    <div class="row justify-content-center">
        <div class="col-lg-7">
            <div class="sr-card p-4">
                <div class="mb-3 pb-2 border-bottom">
                    <h1 class="h5 fw-bold mb-1">Formulir Pemesanan Lapangan</h1>
                    <p class="small text-muted mb-0">Tentukan jadwal bermain futsal dan metode pembayaran Anda</p>
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

                <form action="<?= base_url('customer/booking/simpan') ?>" method="post" enctype="multipart/form-data">
                    <?= csrf_field() ?>

                    <div class="mb-3">
                        <label for="lapangan_id" class="form-label">Pilih Lapangan Futsal <span class="text-danger">*</span></label>
                        <select class="form-select" id="lapangan_id" name="lapangan_id" required>
                            <option value="">Pilih Lapangan</option>
                            <?php foreach ($lapangan as $lap): ?>
                                <option value="<?= $lap['id'] ?>" 
                                    data-harga="<?= $lap['harga_per_jam'] ?>"
                                    <?= (old('lapangan_id', $selected_lapangan_id ?? '') == $lap['id']) ? 'selected' : '' ?>>
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
                            <label for="durasi" class="form-label">Durasi Main <span class="text-danger">*</span></label>
                            <div class="input-group">
                                <input type="number" class="form-control" id="durasi" name="durasi" min="1" max="8" value="<?= old('durasi', 1) ?>" required>
                                <span class="input-group-text">Jam</span>
                            </div>
                        </div>
                    </div>

                    <!-- Perhitungan Total Biaya -->
                    <div class="p-3 bg-light rounded border mb-3 d-flex justify-content-between align-items-center">
                        <div>
                            <div class="small text-muted">Estimasi Biaya:</div>
                            <div class="small fw-medium text-dark" id="calcDetail">Pilih lapangan untuk melihat tarif</div>
                        </div>
                        <div class="fs-4 fw-bold text-dark" id="totalDisplay">Rp0</div>
                    </div>

                    <div class="mb-3">
                        <label for="metode_pembayaran" class="form-label">Metode Pembayaran <span class="text-danger">*</span></label>
                        <select class="form-select" id="metode_pembayaran" name="metode_pembayaran" required>
                            <option value="Transfer Bank BCA" <?= old('metode_pembayaran') === 'Transfer Bank BCA' ? 'selected' : '' ?>>Transfer Bank BCA (1234-567-890 a.n SportRent)</option>
                            <option value="Transfer Bank Mandiri" <?= old('metode_pembayaran') === 'Transfer Bank Mandiri' ? 'selected' : '' ?>>Transfer Bank Mandiri (9876-543-210 a.n SportRent)</option>
                            <option value="QRIS" <?= old('metode_pembayaran') === 'QRIS' ? 'selected' : '' ?>>QRIS (Gopay / OVO / Dana / ShopeePay)</option>
                            <option value="Bayar di Kasir (Offline)" <?= old('metode_pembayaran') === 'Bayar di Kasir (Offline)' ? 'selected' : '' ?>>Bayar di Kasir (Tunai saat datang)</option>
                        </select>
                    </div>

                    <div class="mb-3">
                        <label for="bukti_transfer" class="form-label">Unggah Bukti Transfer (Opsional)</label>
                        <input class="form-control" type="file" id="bukti_transfer" name="bukti_transfer" accept="image/*">
                        <span class="small text-muted">Dapat diunggah nanti melalui halaman riwayat.</span>
                    </div>

                    <div class="mb-4">
                        <label for="catatan" class="form-label">Catatan Tambahan (Opsional)</label>
                        <textarea class="form-control" id="catatan" name="catatan" rows="2" placeholder="Nama tim atau permintaan khusus"><?= old('catatan') ?></textarea>
                    </div>

                    <button type="submit" class="btn btn-primary w-100 py-2">
                        Konfirmasi & Buat Pemesanan
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>
<?= $this->endSection() ?>

<?= $this->section('scripts') ?>
<script>
    function calculate() {
        const sel = document.getElementById('lapangan_id');
        const dur = parseInt(document.getElementById('durasi').value) || 1;
        const opt = sel.options[sel.selectedIndex];
        const harga = parseInt(opt?.getAttribute('data-harga')) || 0;
        const total = harga * dur;

        if (harga > 0) {
            document.getElementById('calcDetail').innerText = `${dur} Jam x Rp${harga.toLocaleString('id-ID')} / jam`;
            document.getElementById('totalDisplay').innerText = `Rp${total.toLocaleString('id-ID')}`;
        } else {
            document.getElementById('calcDetail').innerText = 'Pilih lapangan untuk melihat tarif';
            document.getElementById('totalDisplay').innerText = 'Rp0';
        }
    }

    document.getElementById('lapangan_id').addEventListener('change', calculate);
    document.getElementById('durasi').addEventListener('input', calculate);
    window.addEventListener('DOMContentLoaded', calculate);
</script>
<?= $this->endSection() ?>
