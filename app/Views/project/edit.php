<?= $this->extend('layout/template') ?>
<?= $this->section('content') ?>

<?php
if(isset($project['process'])){
    if(strpos($project['process'], ',') !== false){
        $parts = explode(',', $project['process']);
        $process1 = trim($parts[0]);
        $process2 = trim($parts[1]);
    } else {
        $process1 = $project['process'];
        $process2 = "";
    }
} else {
    $process1 = "";
    $process2 = "";
}
?>

<div class="pd-ltr-20 xs-pd-20-10">
    <div class="min-height-200px">
        <div class="page-header">
            <div class="row">
                <div class="col-md-6 col-sm-12">
                    <div class="title">
                        <h4>Edit Project</h4>
                    </div>
                    <nav aria-label="breadcrumb" role="navigation">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item">
                                <a href="<?= site_url('actual-activity/personal'); ?>">Home</a>
                            </li>
                            <li class="breadcrumb-item">
                                <a href="<?= site_url('project'); ?>">Project</a>
                            </li>
                            <li class="breadcrumb-item active" aria-current="page">
                                Form Edit Project
                            </li>
                        </ol>
                    </nav>
                </div>
            </div>
        </div>
        <div class="pd-20 card-box mb-30">
            <form action="<?= site_url('project/update/'.$project['id']); ?>" method="post">
            <?= csrf_field(); ?>
                <div class="form-group row">
                    <div class="col-md-12">
                        <label class="col-form-label">Jenis <span style="color: red">*</span></label><br>
                        <?php if ($project['jenis'] == 'Others'): ?>
                            <input type="radio" name="jenis" value="Others" id="others" checked readonly>
                            <label for="others">Others</label>
                        <?php elseif ($project['jenis'] == 'Tooling Project'): ?>
                            <input type="radio" name="jenis" value="Tooling Project" id="tooling" checked readonly>
                            <label for="tooling">Tooling Project</label>
                        <?php endif; ?>
                        <input type="hidden" name="jenis" value="<?= esc($project['jenis']); ?>">
                    </div>
                </div>
                <div id="othersFieldsEdit" style="display:<?= ($project['jenis'] == 'Others') ? 'block' : 'none' ?>;">
                    <div class="form-group row">
                        <div class="col-md-12">
                            <label class="col-form-label">Another Project <span style="color: red">*</span></label>
                            <input type="text" name="another_project" class="form-control" value="<?= $project['another_project']; ?>">
                        </div>
                    </div>
                </div>
                <div id="toolingFieldsEdit" style="display:<?= ($project['jenis'] == 'Tooling Project') ? 'block' : 'none' ?>;">
                    <div class="form-group row">
                        <div class="col-md-6">
                            <label class="col-form-label">Jenis <span style="color: red">*</span></label><br>
                            <input type="radio" name="jenis_tooling" value="Dies" id="dies" <?= ($project['jenis_tooling'] == 'Dies' ? 'checked' : ''); ?> onclick="updateProcessLabel()">
                            <label for="dies">Dies</label>
                            <input type="radio" name="jenis_tooling" value="Jig" id="jig" <?= ($project['jenis_tooling'] == 'Jig' ? 'checked' : ''); ?> onclick="updateProcessLabel()">
                            <label for="jig">Jig</label>
                        </div>
                        <div class="col-md-6">
                            <label class="col-form-label">Tingkatan <span style="color: red">*</span></label><br>
                            <input type="radio" name="tingkatan" value="Production" id="production" <?= ($project['status'] == 1 ? 'checked' : ''); ?>>
                            <label for="production">Production</label>
                            <input type="radio" name="tingkatan" value="RFQ" id="rfq" <?= ($project['status'] == 2 ? 'checked' : ''); ?>>
                            <label for="rfq">RFQ</label>
                        </div>

                    </div>
                    <div class="form-group row">
                        <div class="col-md-4">
                            <label class="col-form-label">Model <span style="color: red">*</span></label>
                            <input type="text" name="model" class="form-control" value="<?= $project['model']; ?>">
                        </div>
                        <div class="col-md-4">
                            <label class="col-form-label">Part No <span style="color: red">*</span></label>
                            <input type="text" name="part_no" class="form-control" value="<?= $project['part_no']; ?>">
                        </div>   
                        <div class="col-md-4">
                            <label class="col-form-label">Part Name<span style="color: red">*</span></label>
                            <input type="text" name="part_name" class="form-control" value="<?= $project['part_name']; ?>">
                        </div>
                    </div>
                     <div class="form-group row">
                        <div class="col-md-4">
                            <label class="col-form-label">customer <span style="color: red">*</span></label>
                            <input type="text" name="customer" class="form-control" value="<?= $project['customer']; ?>">
                        </div>
                     
                    
                    </div>
                    <div class="form-group row">
                        <div class="col-md-6">
                            <label class="col-form-label" id="process-label">OP <span style="color: red">*</span></label>
                            <div class="input-group">
                                <select name="process" class="custom-select2 form-control mr-1" style="width: 50%; height: 38px;">
                                    <option value="">Pilih</option>
                                    <?php for ($i = 10; $i <= 80; $i += 10): ?>
                                        <option value="OP<?= $i; ?>" <?= ($process1 == "OP".$i ? "selected" : ""); ?>>OP<?= $i; ?></option>
                                    <?php endfor; ?>
                                </select>
                                <select name="process2" class="custom-select2 form-control" style="width: 50%; height: 38px;">
                                    <option value="">Pilih Join (Optional)</option>
                                    <?php for ($i = 10; $i <= 80; $i += 10): ?>
                                        <option value="OP<?= $i; ?>" <?= ($process2 == "OP".$i ? "selected" : ""); ?>>OP<?= $i; ?></option>
                                    <?php endfor; ?>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <label class="col-form-label">Nama Proses<span style="color: red">*</span></label>
                            <input type="text" name="proses" class="form-control" value="<?= $project['proses']; ?>">
                        </div>
                    </div>
                </div>
                <div class="form-group row">
                    <div class="col-md-12">
                        <button type="submit" class="btn btn-success">Update</button>
                        <a href="<?= site_url('project'); ?>" class="btn btn-secondary">Kembali</a>
                    </div>
                </div>
            </form>
            <script>
            function toggleFieldsEdit() {
                var jenis = document.querySelector('input[name="jenis"]:checked').value;
                document.getElementById('toolingFieldsEdit').style.display = (jenis === 'Tooling Project') ? 'block' : 'none';
                document.getElementById('othersFieldsEdit').style.display = (jenis === 'Others') ? 'block' : 'none';
            }
            </script>
        </div>
    </div>
</div>
<?= $this->endSection() ?>