<?= $this->extend('layout/template') ?>

<?= $this->section('content') ?>
<div class="pd-ltr-20 xs-pd-20-10">
    <div class="min-height-200px">
        <div class="page-header">
            <div class="row">
                <div class="col-md-6 col-sm-12">
                    <div class="title">
                        <h4>Tambah Pengguna</h4>
                    </div>
                    <nav aria-label="breadcrumb" role="navigation">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item">
                                <a href="<?= site_url('actual-activity/personal'); ?>">Home</a>
                            </li>
                            <li class="breadcrumb-item active" aria-current="page">
                                Form Tambah Pengguna
                            </li>
                        </ol>
                    </nav>
                </div>
            </div>
        </div>
    <?php if(session()->has('error')): ?>
        <div class="alert alert-danger">
    <?= session('error') ?>
</div>
<?php endif; ?>

        <div class="pd-20 card-box mb-30">
            <form action="<?= site_url('user/store'); ?>" method="post" enctype="multipart/form-data">
            <?= csrf_field(); ?>
                <div class="form-group row">
                    <div class="col-md-6">
                        <label class="col-form-label">Nama <span style="color: red">*</span></label>
                        <input type="text" name="nama" class="form-control" required>
                    </div>
                    <div class="col-md-6">
                        <label class="col-form-label">Nickame <span style="color: red">*</span></label>
                        <input type="text" name="nickname" class="form-control" required>
                    </div>
                </div>

                <div class="form-group row">
                <div class="col-md-6">
                        <label class="col-form-label">NIK <span style="color: red">*</span></label>
                        <input type="text" name="nik" class="form-control" required>
                    </div>
                    <div class="col-md-6">
                        <label class="col-form-label">Password <span style="color: red">*</span></label>
                        <input type="password" name="password" class="form-control" required>
                    </div>
                    <!-- <div class="col-md-6">
                        <label class="col-form-label">Email</label>
                        <input type="email" name="email" class="form-control">
                    </div> -->
                </div>

                <div class="form-group row">
                    <div class="col-md-6">
                        <label class="col-form-label">Departemen</label>
                        <input type="text" name="department" class="form-control">
                    </div>
                    <div class="col-md-6">
                    <label class="col-form-label">Role <span style="color: red;">*</span></label>
                  
                        <select name="role_id" class="custom-select2 form-control" style="width: 100%; height: 38px;" required>
                            <option value="">-- Pilih Role --</option>
                            <?php foreach ($roles as $role) : ?>
                                <?php if (session('role_id') == 5 || $role['id'] != 5) : ?>
                                    <option value="<?= $role['id']; ?>"><?= $role['role_name']; ?></option>
                                <?php endif; ?>
                            <?php endforeach; ?>
                        </select>
                            
                    </div>
                </div>
                <div class="form-group row">
                    <div class="col-md-6">
                        <label class="col-form-label">Foto Profil</label>
                        <input type="file" name="foto" class="form-control">
                    </div>
                    <div class="col-md-6">
                    <label>Group</label>
                        <input type="text" name="group" class="form-control">
                    </div>
                </div>
                <div class="form-group row">
                    <div class="col-md-12">
                        <button type="submit" class="btn btn-success">Simpan</button>
                        <a href="<?= site_url('user'); ?>" class="btn btn-secondary">Kembali</a>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
<?= $this->endSection() ?>
