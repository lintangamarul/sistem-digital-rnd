<?= $this->extend('layout/template') ?>
<?= $this->section('content') ?>

<div class="pd-ltr-20 xs-pd-20-10">
    <div class="min-height-200px">
        <div class="page-header">
            <div class="row">
                <div class="col-md-6 col-sm-12">
                    <div class="title">
                        <h4><?= isset($spec) ? 'Edit M/C Spec' : 'Tambah M/C Spec' ?></h4>
                    </div>
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="<?= site_url('actual-activity/personal'); ?>">Home</a></li>
                            <li class="breadcrumb-item"><a href="<?= site_url('master-pps'); ?>">Data M/C Spec</a></li>
                            <li class="breadcrumb-item active" aria-current="page">
                                <?= isset($spec) ? 'Edit' : 'Tambah' ?> M/C Spec
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

            <form action="<?= isset($spec) ? '/mc-spec/update/'.$spec['id'] : '/mc-spec/store' ?>" method="post">
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label>Machine</label>
                        <input type="text" name="machine" class="form-control" value="<?= $spec['machine'] ?? '' ?>" required>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label>Capacity</label>
                        <input type="text" name="capacity" class="form-control" value="<?= $spec['capacity'] ?? '' ?>">
                    </div>
                    <div class="col-md-6 mb-3">
                        <label>Bolster Length</label>
                        <input type="text" name="bolster_length" class="form-control" value="<?= $spec['bolster_length'] ?? '' ?>">
                    </div>
                    <div class="col-md-6 mb-3">
                        <label>Bolster Width</label>
                        <input type="text" name="bolster_width" class="form-control" value="<?= $spec['bolster_width'] ?? '' ?>">
                    </div>
                    <div class="col-md-6 mb-3">
                        <label>Slide Area Length</label>
                        <input type="text" name="slide_area_length" class="form-control" value="<?= $spec['slide_area_length'] ?? '' ?>">
                    </div>
                    <div class="col-md-6 mb-3">
                        <label>Slide Area Width</label>
                        <input type="text" name="slide_area_width" class="form-control" value="<?= $spec['slide_area_width'] ?? '' ?>">
                    </div>
                    <div class="col-md-6 mb-3">
                        <label>Die Height</label>
                        <input type="text" name="die_height" class="form-control" value="<?= $spec['die_height'] ?? '' ?>">
                    </div>
                    <div class="col-md-6 mb-3">
                        <label>Cushion Pad Length</label>
                        <input type="text" name="cushion_pad_length" class="form-control" value="<?= $spec['cushion_pad_length'] ?? '' ?>">
                    </div>
                    <div class="col-md-6 mb-3">
                        <label>Cushion Pad Width</label>
                        <input type="text" name="cushion_pad_width" class="form-control" value="<?= $spec['cushion_pad_width'] ?? '' ?>">
                    </div>
                    <div class="col-md-6 mb-3">
                        <label>Cushion Stroke</label>
                        <input type="text" name="cushion_stroke" class="form-control" value="<?= $spec['cushion_stroke'] ?? '' ?>">
                    </div>
                    <div class="col-md-6 mb-3">
                        <label>Die Cushion</label>
                        <input type="text" name="cushion" class="form-control" value="<?= $spec['cushion'] ?? '' ?>">
                    </div>
                </div>

                <div class="text-right">
                    <button type="submit" class="btn btn-primary">Simpan</button>
                    <a href="<?= site_url('master-pps/'); ?>" class="btn btn-secondary">Kembali</a>
                </div>
            </form>
        </div>
    </div>
</div>

<?= $this->endSection() ?>
