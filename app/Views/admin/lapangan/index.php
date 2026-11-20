<?= $this->extend('layouts/admin') ?>

<?= $this->section('content') ?>
<div class="d-flex flex-column flex-md-row justify-content-between align-items-md-center gap-2 mb-4 pb-2 border-bottom">
    <div>
        <h1 class="h4 fw-bold mb-1">Data Lapangan Futsal</h1>
        <p class="small text-muted mb-0">Kelola informasi fasilitas, jenis lantai, tarif sewa per jam, dan ketersediaan lapangan.</p>
    </div>
    <div>
        <a href="<?= base_url('admin/lapangan/tambah') ?>" class="btn btn-primary btn-sm">
            <i class="bi bi-plus-lg me-1"></i> Tambah Lapangan
        </a>
    </div>
</div>

<div class="sr-card">
    <div class="table-responsive">
        <table class="table align-middle">
            <thead>
                <tr>
                    <th style="width: 50px;">No</th>
                    <th>Foto</th>
                    <th>Nama Lapangan</th>
                    <th>Jenis Lantai</th>
                    <th>Harga / Jam</th>
                    <th>Deskripsi</th>
                    <th>Status</th>
                    <th class="text-end" style="width: 140px;">Aksi</th>
                </tr>
            </thead>
            <tbody>
                <?php if (!empty($lapangan)): ?>
                    <?php $no = 1; foreach ($lapangan as $lap): ?>
                        <tr>
                            <td><?= $no++ ?></td>
                            <td>
                                <img src="<?= base_url('assets/images/lapangan/' . esc($lap['gambar'] ?? 'default-court.jpg')) ?>" alt="<?= esc($lap['nama_lapangan']) ?>" class="rounded border" style="width: 56px; height: 40px; object-fit: cover;">
                            </td>
                            <td class="fw-semibold text-dark"><?= esc($lap['nama_lapangan']) ?></td>
                            <td><span class="badge badge-status-neutral"><?= esc($lap['jenis_lantai']) ?></span></td>
                            <td class="fw-semibold">Rp<?= number_format($lap['harga_per_jam'], 0, ',', '.') ?></td>
                            <td class="small text-muted" style="max-width: 260px;"><?= esc($lap['deskripsi'] ?: '-') ?></td>
                            <td>
                                <?php if ($lap['status'] === 'Tersedia'): ?>
                                    <span class="badge badge-status-confirmed">Tersedia</span>
                                <?php else: ?>
                                    <span class="badge badge-status-canceled">Tidak Aktif</span>
                                <?php endif; ?>
                            </td>
                            <td class="text-end">
                                <div class="d-inline-flex gap-1">
                                    <a href="<?= base_url('admin/lapangan/edit/' . $lap['id']) ?>" class="btn btn-outline-secondary btn-sm" title="Edit">
                                        <i class="bi bi-pencil"></i>
                                    </a>
                                    <!-- Tombol Hapus Lapangan Langsung dengan Konfirmasi -->
                                    <form action="<?= base_url('admin/lapangan/hapus/' . $lap['id']) ?>" method="post" class="d-inline" onsubmit="return confirm('Apakah Anda yakin ingin menghapus <?= esc($lap['nama_lapangan']) ?>? Jika memiliki riwayat booking, status akan dinonaktifkan atau hapus permanen.')">
                                        <?= csrf_field() ?>
                                        <input type="hidden" name="force_delete" value="1">
                                        <button type="submit" class="btn btn-outline-danger btn-sm" title="Hapus Lapangan">
                                            <i class="bi bi-trash"></i> Hapus
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="8" class="text-center py-4 text-muted small">Belum ada data lapangan.</td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>
<?= $this->endSection() ?>
