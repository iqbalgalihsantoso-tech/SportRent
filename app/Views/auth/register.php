<?= $this->extend('layouts/main') ?>

<?= $this->section('content') ?>
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-md-6 col-lg-5">
            <div class="sr-card p-4">
                <div class="mb-4">
                    <h1 class="h4 fw-bold mb-1">Pendaftaran Akun Baru</h1>
                    <p class="small text-muted mb-0">Buat akun pelanggan untuk mulai memesan lapangan futsal</p>
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

                <form action="<?= base_url('register') ?>" method="post">
                    <?= csrf_field() ?>

                    <div class="mb-3">
                        <label for="nama" class="form-label">Nama Lengkap</label>
                        <input type="text" class="form-control" id="nama" name="nama" value="<?= old('nama') ?>" placeholder="Nama lengkap" required>
                    </div>

                    <div class="mb-3">
                        <label for="email" class="form-label">Alamat Email</label>
                        <input type="email" class="form-control" id="email" name="email" value="<?= old('email') ?>" placeholder="nama@email.com" required>
                    </div>

                    <div class="mb-3">
                        <label for="no_hp" class="form-label">Nomor WhatsApp / HP</label>
                        <input type="tel" class="form-control" id="no_hp" name="no_hp" value="<?= old('no_hp') ?>" placeholder="08xxxxxxxxxx" required>
                    </div>

                    <div class="row g-2 mb-4">
                        <div class="col-md-6">
                            <label for="password" class="form-label">Kata Sandi</label>
                            <input type="password" class="form-control" id="password" name="password" placeholder="Min. 6 karakter" required>
                        </div>
                        <div class="col-md-6">
                            <label for="password_confirm" class="form-label">Konfirmasi Sandi</label>
                            <input type="password" class="form-control" id="password_confirm" name="password_confirm" placeholder="Ulangi kata sandi" required>
                        </div>
                    </div>

                    <button type="submit" class="btn btn-primary w-100 py-2 mb-3">
                        Daftar Sebagai Pelanggan
                    </button>
                </form>

                <div class="text-center small text-muted">
                    Sudah memiliki akun? <a href="<?= base_url('login') ?>" class="fw-medium text-decoration-none" style="color: var(--sr-primary);">Masuk ke akun</a>
                </div>
            </div>
        </div>
    </div>
</div>
<?= $this->endSection() ?>
