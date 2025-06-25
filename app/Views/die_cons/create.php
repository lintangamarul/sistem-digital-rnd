<?= $this->extend('layout/template') ?>
<?= $this->section('content') ?>

<div class="pd-ltr-20 xs-pd-20-10">
    <div class="min-height-200px">
        <div class="page-header">
            <div class="row">
                <div class="col-md-6 col-sm-12">
                    <div class="title">
                        <h4>Tambah Die Construction Image</h4>
                    </div>
                    <nav aria-label="breadcrumb" role="navigation">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item">
                                <a href="<?= site_url('die-cons'); ?>">Die Construction</a>
                            </li>
                            <li class="breadcrumb-item active" aria-current="page">
                                Form Tambah Gambar
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

            <form action="<?= site_url('die-cons'); ?>" method="post" enctype="multipart/form-data">
                <?= csrf_field(); ?>

                <div class="form-group row">
                    <label class="col-sm-3 col-form-label">Proses <span style="color: red;">*</span></label>
                    <div class="col-sm-9">
                        <?php $opts = ["DRAW","FORM","BEND","REST","FLANGE","BLANK","TRIM","SEP","PIE"]; ?>
                        <?php foreach($opts as $o): ?>
                            <label style="margin-right:12px">
                                <input type="checkbox" name="proses[]" value="<?= $o ?>"> <?= $o ?>
                            </label>
                        <?php endforeach ?>
                    </div>
                </div>

                <div class="form-group row">
                    <label class="col-sm-3 col-form-label">Pad Lifter <span style="color: red;">*</span></label>
                    <div class="col-sm-9">
                        <select name="pad_lifter" class="form-control" required>
                            <option value="">-- Pilih Pad Lifter --</option>
                            <option value="Gas-Spring">Gas-Spring</option>
                            <option value="Coil-Spring">Coil-Spring</option>
                            <option value="Gas-Tank">Gas-Tank</option>
                        </select>
                    </div>
                </div>

                <div class="form-group row">
                    <label class="col-sm-3 col-form-label">Casting Plate <span style="color: red;">*</span></label>
                    <div class="col-sm-9">
                        <?php $plates = ["Casting","Plate"]; ?>
                        <?php foreach($plates as $p): ?>
                            <label style="margin-right:12px">
                                <input type="checkbox" name="casting_plate[]" value="<?= $p ?>"> <?= $p ?>
                            </label>
                        <?php endforeach ?>
                    </div>
                </div>

                <div class="form-group row">
                    <label class="col-sm-3 col-form-label">Image (PNG/JPG) <span style="color: red;">*</span></label>
                    <div class="col-sm-9">
                        <input type="file" name="image" class="form-control" accept="image/*" required>
                    </div>
                </div>

                <div class="form-group row">
                    <div class="col-sm-9 offset-sm-3">
                        <button type="submit" class="btn btn-success">Simpan</button>
                        <a href="<?= site_url('die-cons'); ?>" class="btn btn-secondary">Kembali</a>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>

<?= $this->endSection() ?>
