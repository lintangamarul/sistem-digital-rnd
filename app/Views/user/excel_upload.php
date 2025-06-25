<?= $this->extend('layout/template') ?>

<?= $this->section('content') ?>
<div class="pd-ltr-20 xs-pd-20-10">
    <div class="min-height-200px">
        <!-- Page Header -->
        <div class="page-header">
            <div class="row">
                <div class="col-md-6 col-sm-12">
                    <div class="title">
                        <h4>Upload File Excel</h4>
                    </div>
                    <nav aria-label="breadcrumb" role="navigation">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item">
                                <a href="<?= site_url('home'); ?>">Home</a>
                            </li>
                            <li class="breadcrumb-item active" aria-current="page">
                                Form Upload File Excel
                            </li>
                        </ol>
                    </nav>
                </div>
            </div>
        </div>
        <!-- End Page Header -->

        <!-- Card Box -->
        <div class="pd-20 card-box mb-30">
            <?php if(session()->has('error')): ?>
                <div class="alert alert-danger">
                    <?= session('error') ?>
                </div>
            <?php endif; ?>

            <form action="<?= base_url('/upload-excel') ?>" method="post" enctype="multipart/form-data">
                <?= csrf_field(); ?>
                <div class="form-group">
                    <label for="excel_file" class="col-form-label">
                        Pilih file Excel (.xls atau .xlsx):
                    </label>
                    <input type="file" name="excel_file" id="excel_file" class="form-control" required>
                </div>
                <div class="form-group mt-3">
                    <button type="submit" class="btn btn-primary">Upload dan Unduh File</button>
                </div>
            </form>
        </div>
        <!-- End Card Box -->
    </div>
</div>
<?= $this->endSection() ?>
