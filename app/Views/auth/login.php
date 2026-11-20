<?= $this->extend('layouts/main') ?>

<?= $this->section('content') ?>
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-md-5 col-lg-4">
            <div class="sr-card p-4">
                <div class="mb-4">
                    <h1 class="h4 fw-bold mb-1">Masuk ke Akun</h1>
                    <p class="small text-muted mb-0">Gunakan email dan kata sandi Anda</p>
                </div>

                <form action="<?= base_url('login') ?>" method="post">
                    <?= csrf_field() ?>

                    <div class="mb-3">
                        <label for="email" class="form-label">Email</label>
                        <input type="email" class="form-control" id="email" name="email" value="<?= old('email') ?>" placeholder="nama@email.com" required autofocus>
                    </div>

                    <div class="mb-3">
                        <label for="password" class="form-label">Kata Sandi</label>
                        <input type="password" class="form-control" id="password" name="password" placeholder="••••••••" required>
                    </div>

                    <button type="submit" class="btn btn-primary w-100 py-2 mb-3">
                        Masuk
                    </button>
                </form>

                <div class="text-center small text-muted">
                    Belum punya akun? <a href="<?= base_url('register') ?>" class="fw-medium text-decoration-none" style="color: var(--sr-primary);">Daftar di sini</a>
                </div>

                <hr class="my-3" style="border-color: var(--sr-border);">

                <div class="p-2 bg-light rounded border small text-muted">
                    <div class="fw-semibold text-dark mb-1">Akun Demo UTS:</div>
                    <div><strong>Admin:</strong> admin@sportrent.test (Pass: <code>Admin123!</code>)</div>
                    <div><strong>Customer:</strong> customer@sportrent.test (Pass: <code>Customer123!</code>)</div>
                </div>
            </div>
        </div>
    </div>
</div>
<?= $this->endSection() ?>
