<?= $this->extend('layout/template') ?>
<?= $this->section('content') ?>

<div class="container mt-5">
    <div class="pd-20 card-box mb-30">
    <h2>Reset Password</h2>
    
    <?php if (session()->getFlashdata('error')): ?>
        <div class="alert alert-danger"><?= session()->getFlashdata('error') ?></div>
    <?php endif; ?>
    
    <?php if (session()->getFlashdata('success')): ?>
        <div class="alert alert-success"><?= session()->getFlashdata('success') ?></div>
    <?php endif; ?>
    
    <form action="<?= site_url('auth/reset/'.$nik); ?>" method="post">
    <?= csrf_field(); ?>
        <div class="form-group">
            <label for="old_password">Password Lama</label>
            <input type="password" name="old_password" id="old_password" class="form-control" required>
        </div>
        <div class="form-group">
            <label for="new_password">Password Baru</label>
            <input type="password" name="new_password" id="new_password" class="form-control" required>
        </div>
        <div class="form-group">
            <label for="confirm_password">Konfirmasi Password Baru</label>
            <input type="password" name="confirm_password" id="confirm_password" class="form-control" required>
        </div>
        <button type="submit" class="btn btn-primary">Reset Password</button>
    </form>
</div></div>

<?= $this->endSection() ?>
