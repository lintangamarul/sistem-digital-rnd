<?= $this->extend('layout/template') ?>

<?= $this->section('content') ?>
<div class="pd-ltr-20 xs-pd-20-10">
    <div class="min-height-200px">
        <div class="page-header">
            <div class="row">
                <div class="col-md-6 col-sm-12">
                    <div class="title">
                        <h4>Tambah Material</h4>
                    </div>
                    <nav aria-label="breadcrumb" role="navigation">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item">
                                <a href="<?= site_url('material'); ?>">Home</a>
                            </li>
                            <li class="breadcrumb-item active" aria-current="page">
                                Form Tambah Material
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
            <form action="<?= site_url('material/store'); ?>" method="post">
                <?= csrf_field(); ?>
                <div class="form-group row">
                    <div class="col-md-12">
                        <label class="col-form-label">Material <span style="color: red">*</span></label>
                        <input type="text" name="name_material" class="form-control" required>
                    </div>
                </div>
                
                <div class="form-group row">
                    <div class="col-md-12">
                        <button type="submit" class="btn btn-success">Simpan</button>
                        <a href="<?= site_url('material'); ?>" class="btn btn-secondary">Kembali</a>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
<?= $this->endSection() ?>
