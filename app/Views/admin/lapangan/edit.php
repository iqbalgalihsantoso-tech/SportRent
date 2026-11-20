<?= $this->extend('layouts/admin') ?>

<?= $this->section('content') ?>
<div class="row justify-content-center">
    <div class="col-lg-8">
        <div class="sr-card p-4">
            <div class="d-flex justify-content-between align-items-center mb-3 pb-2 border-bottom">
                <h1 class="h5 fw-bold mb-0">Edit Data Lapangan</h1>
                <a href="<?= base_url('admin/lapangan') ?>" class="btn btn-outline-secondary btn-sm">
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

            <form action="<?= base_url('admin/lapangan/update/' . $lapangan['id']) ?>" method="post" enctype="multipart/form-data">
                <?= csrf_field() ?>

                <div class="mb-3">
                    <label for="nama_lapangan" class="form-label">Nama Lapangan <span class="text-danger">*</span></label>
                    <input type="text" class="form-control" id="nama_lapangan" name="nama_lapangan" value="<?= old('nama_lapangan', $lapangan['nama_lapangan']) ?>" required>
                </div>

                <div class="row g-3 mb-3">
                    <div class="col-md-6">
                        <label for="jenis_lantai" class="form-label">Jenis Lantai <span class="text-danger">*</span></label>
                        <select class="form-select" id="jenis_lantai" name="jenis_lantai" required>
                            <option value="Rumput Sintetis" <?= old('jenis_lantai', $lapangan['jenis_lantai']) === 'Rumput Sintetis' ? 'selected' : '' ?>>Rumput Sintetis</option>
                            <option value="Vinyl" <?= old('jenis_lantai', $lapangan['jenis_lantai']) === 'Vinyl' ? 'selected' : '' ?>>Vinyl</option>
                            <option value="Interlock" <?= old('jenis_lantai', $lapangan['jenis_lantai']) === 'Interlock' ? 'selected' : '' ?>>Interlock</option>
                            <option value="Semen Halus" <?= old('jenis_lantai', $lapangan['jenis_lantai']) === 'Semen Halus' ? 'selected' : '' ?>>Semen Halus</option>
                        </select>
                    </div>
                    <div class="col-md-6">
                        <label for="harga_per_jam" class="form-label">Harga Sewa / Jam (Rp) <span class="text-danger">*</span></label>
                        <div class="input-group">
                            <span class="input-group-text">Rp</span>
                            <input type="number" class="form-control" id="harga_per_jam" name="harga_per_jam" value="<?= old('harga_per_jam', $lapangan['harga_per_jam']) ?>" min="10000" step="5000" required>
                        </div>
                    </div>
                </div>

                <div class="mb-3">
                    <label for="status" class="form-label">Status Lapangan <span class="text-danger">*</span></label>
                    <select class="form-select" id="status" name="status" required>
                        <option value="Tersedia" <?= old('status', $lapangan['status']) === 'Tersedia' ? 'selected' : '' ?>>Tersedia (Bisa Dipesan)</option>
                        <option value="Tidak Aktif" <?= old('status', $lapangan['status']) === 'Tidak Aktif' ? 'selected' : '' ?>>Tidak Aktif (Tutup / Perawatan)</option>
                    </select>
                </div>

                <div class="mb-3">
                    <label for="deskripsi" class="form-label">Deskripsi Fasilitas</label>
                    <textarea class="form-control" id="deskripsi" name="deskripsi" rows="2" maxlength="150"><?= old('deskripsi', $lapangan['deskripsi']) ?></textarea>
                </div>

                <div class="mb-4">
                    <label for="gambar" class="form-label">Ganti Foto Lapangan (Opsional)</label>
                    <div class="d-flex align-items-center gap-3 mb-2">
                        <img src="<?= base_url('assets/images/lapangan/' . esc($lapangan['gambar'] ?? 'default-court.jpg')) ?>" class="rounded border" style="width: 80px; height: 50px; object-fit: cover;">
                        <span class="small text-muted"><?= esc($lapangan['gambar']) ?></span>
                    </div>
                    <input class="form-control" type="file" id="gambar" name="gambar" accept="image/*">
                </div>

                <div class="d-flex justify-content-end gap-2 pt-2 border-top">
                    <a href="<?= base_url('admin/lapangan') ?>" class="btn btn-outline-secondary">Batal</a>
                    <button type="submit" class="btn btn-primary">
                        <i class="bi bi-check-lg me-1"></i> Simpan Perubahan
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
<?= $this->endSection() ?>
