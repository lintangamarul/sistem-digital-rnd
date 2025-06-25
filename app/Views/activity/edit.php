<?= $this->extend('layout/template') ?>
<?= $this->section('content') ?>

<div class="pd-ltr-20 xs-pd-20-10">
    <div class="min-height-200px">
    <div class="page-header">
            <div class="row">
                <div class="col-md-6 col-sm-12">
                    <div class="title">
                        <h4>Edit Aktivitas</h4>
                    </div>
                    <nav aria-label="breadcrumb" role="navigation">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item">
                                <a href="<?= site_url('actual-activity/personal'); ?>">Home</a>
                            </li>
                            <li class="breadcrumb-item">
                                <a href="<?= site_url('activity'); ?>">Aktivitas</a>
                            </li>
                            <li class="breadcrumb-item active" aria-current="page">
                                Form Edit Aktivitas
                            </li>
                        </ol>
                    </nav>
                </div>
            </div>
        </div>

        <div class="card-box p-4">
        <form action="<?= site_url('activity/update/'.$activity['id']); ?>" method="post">
        <?= csrf_field(); ?>
            <!-- <div class="form-group row">
                <label class="col-sm-3 col-form-label">Project <span style="color: red;">*</span></label>
                <div class="col-sm-9">
                    <select name="project_id" class="custom-select2 form-control" style="width: 100%; height: 38px;" required>
                        <option value="">-- Pilih Project --</option>
                        <?php foreach ($projects as $project) : ?>
                            <option value="<?= $project['id']; ?>" <?= ($activity['project_id'] == $project['id']) ? 'selected' : ''; ?>>
                                <?= $project['jenis']; ?><?= !empty($project['another_project']) ? ' - ' . $project['another_project'] : ''; ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>
            </div> -->

            <div class="form-group row">
                <label class="col-sm-3 col-form-label">Nama Aktivitas <span style="color: red;">*</span></label>
                <div class="col-sm-9">
                    <input type="text" name="name" value="<?= $activity['name']; ?>" class="form-control" required>
                </div>
            </div>



            <div class="form-group row">
                <div class="col-sm-9 offset-sm-3">
                    <button type="submit" class="btn btn-success">Update</button>
                    <a href="<?= site_url('activity'); ?>" class="btn btn-secondary">Kembali</a>
                </div>
            </div>
        </form>

        </div>
    </div>
</div>

<?= $this->endSection() ?>
