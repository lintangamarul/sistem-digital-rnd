<?= $this->extend('layout/template') ?>
<?= $this->section('content') ?>

<div class="pd-ltr-20 xs-pd-20-10">
    <div class="min-height-200px">
        <div class="page-header">
            <div class="row">
                <div class="col-md-6 col-sm-12">
                    <div class="title">
                        <h4>Tambah Perizinan</h4>
                    </div>
                    <nav aria-label="breadcrumb" role="navigation">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item">
                                <a href="<?= site_url('actual-activity/personal'); ?>">Home</a>
                            </li>
                            <li class="breadcrumb-item">
                            <?php if (has_permission(36)):?>
                                <a href="<?= site_url('history'); ?>">Status Pengisian Daily Report</a>
                                <?php endif;?>
                            </li>
                            <li class="breadcrumb-item active" aria-current="page">
                                Form Perizinan
                            </li>
                        </ol>
                    </nav>
                </div>
            </div>
        </div>
        <div class="card-box p-4">
            <?php if(session()->getFlashdata('error')): ?>
                <div class="alert alert-danger"><?= session()->getFlashdata('error'); ?></div>
            <?php endif; ?>
            <?php if(session()->getFlashdata('success')): ?>
                <div class="alert alert-success"><?= session()->getFlashdata('success'); ?></div>
            <?php endif; ?>

            <form action="<?= site_url('history/store'); ?>" method="post">
            <?= csrf_field(); ?>
                <div class="form-group row">
                    <label class="col-sm-3 col-form-label">User (NIK - Nama) <span style="color: red;">*</span></label>
                    <div class="col-sm-9">
                        <select name="user_id" class="custom-select2 form-control" style="width: 100%; height: 38px;" required>
                            <option value="">-- Pilih User --</option>
                            <?php foreach ($users as $user): ?>
                                <option value="<?= $user['id']; ?>">
                                    <?= esc($user['nik']) . ' - ' . esc($user['nama']); ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                </div>

                <div class="form-group row">
                    <label class="col-sm-3 col-form-label">Tanggal <span style="color: red;">*</span></label>
                    <div class="col-sm-9">
                        <input type="date" name="dates" class="form-control" required>
                    </div>
                </div>

                <div class="form-group row">
                    <label class="col-sm-3 col-form-label">Status Perizinan <span style="color: red;">*</span></label>
                    <div class="col-sm-9">
                        <select name="status" class="custom-select2 form-control" style="width: 100%; height: 38px;" required>
                            <option value="">-- Pilih Status --</option>
                            <option value="3">Ganti Hari</option>
                            <option value="4">Ijin</option>
                            <option value="5">Sakit</option>
                            <option value="6">Cuti</option>
                        </select>
                    </div>
                </div>
                <div class="form-group row">
                    <div class="col-sm-9 offset-sm-3">
                        <button type="submit" class="btn btn-success">Simpan</button>
                        <a href="<?= site_url('history'); ?>" class="btn btn-secondary">Kembali</a>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>

<?= $this->endSection() ?>
