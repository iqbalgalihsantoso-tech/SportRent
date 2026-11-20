<?= $this->extend('layouts/main') ?>

<?= $this->section('content') ?>
<div class="container py-4">
    <div class="row justify-content-center">
        <div class="col-lg-8">
            <div class="sr-card p-4">
                <div class="mb-4 pb-2 border-bottom">
                    <span class="badge badge-status-neutral mb-1">Informasi Mahasiswa UTS</span>
                    <h1 class="h4 fw-bold mb-1">Tentang Aplikasi SportRent</h1>
                    <p class="small text-muted mb-0"><?= esc($appDesc) ?></p>
                </div>

                <div class="sr-card-subtle p-3 mb-4">
                    <h2 class="h6 fw-bold text-dark mb-3">Identitas Pengembang Mahasiswa</h2>
                    <div class="table-responsive">
                        <table class="table table-borderless table-sm mb-0">
                            <tr>
                                <td class="text-muted" style="width: 180px;">Nama Mahasiswa:</td>
                                <td class="fw-semibold text-dark"><?= esc($creatorName) ?></td>
                            </tr>
                            <tr>
                                <td class="text-muted">NPM:</td>
                                <td class="fw-semibold text-dark font-monospace"><?= esc($npm) ?></td>
                            </tr>
                            <tr>
                                <td class="text-muted">Kelas:</td>
                                <td class="text-dark"><?= esc($kelas) ?></td>
                            </tr>
                            <tr>
                                <td class="text-muted">Program Studi:</td>
                                <td class="text-dark"><?= esc($prodi) ?></td>
                            </tr>
                            <tr>
                                <td class="text-muted">Perguruan Tinggi:</td>
                                <td class="text-dark"><?= esc($kampus) ?></td>
                            </tr>
                            <tr>
                                <td class="text-muted">Tahun Akademik:</td>
                                <td class="text-dark"><?= esc($tahun) ?></td>
                            </tr>
                        </table>
                    </div>
                </div>

                <h3 class="h6 fw-bold mb-2">Tujuan & Fungsi Sistem</h3>
                <p class="small text-muted mb-3">
                    SportRent dirancang sebagai solusi manajemen booking lapangan futsal yang menjembatani kebutuhan calon penyewa dan pengelola arena. Sistem menjamin transparansi ketersediaan jadwal bermain secara langsung melalui pencegahan overlap jam sewa otomatis, kalkulasi biaya terstandar, dan verifikasi pembayaran rapi.
                </p>

                <h3 class="h6 fw-bold mb-2">Arsitektur & Teknologi</h3>
                <div class="row g-2 mb-4 small">
                    <div class="col-sm-6">
                        <div class="p-2 border rounded bg-white">
                            <strong class="text-dark">Backend:</strong> PHP 8.1 & CodeIgniter 4 MVC
                        </div>
                    </div>
                    <div class="col-sm-6">
                        <div class="p-2 border rounded bg-white">
                            <strong class="text-dark">Database:</strong> MySQL 8.0 Relasional (InnoDB)
                        </div>
                    </div>
                    <div class="col-sm-6">
                        <div class="p-2 border rounded bg-white">
                            <strong class="text-dark">Frontend:</strong> HTML5, CSS3, Bootstrap 5.3
                        </div>
                    </div>
                    <div class="col-sm-6">
                        <div class="p-2 border rounded bg-white">
                            <strong class="text-dark">Local Server:</strong> Laragon Local Dev
                        </div>
                    </div>
                </div>

                <div class="pt-2 border-top text-end">
                    <a href="<?= base_url() ?>" class="btn btn-outline-secondary btn-sm">
                        <i class="bi bi-arrow-left me-1"></i> Kembali ke Beranda
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>
<?= $this->endSection() ?>
