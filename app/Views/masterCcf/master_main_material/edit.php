<?= $this->extend('layout/template') ?>
<?= $this->section('content') ?>

<div class="pd-ltr-20 xs-pd-20-10">
    <div class="min-height-200px">
        <div class="page-header">
            <div class="row">
                <div class="col-md-6 col-sm-12">
                    <div class="title">
                        <h4>Edit Data Main Material</h4>
                    </div>
                    <nav aria-label="breadcrumb" role="navigation">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="<?= site_url('/') ?>">Home</a></li>
                            <li class="breadcrumb-item"><a href="<?= site_url('ccf-master-main-material') ?>">Main Material</a></li>
                            <li class="breadcrumb-item active" aria-current="page">Edit #<?= $item['id'] ?></li>
                        </ol>
                    </nav>
                </div>
            </div>
        </div>

        <div class="card-box p-4">
            <form action="<?= site_url('ccf-master-main-material/update/' . $item['id']) ?>" method="post">
                <?= csrf_field() ?>
                <div class="row mb-3">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>Jenis <span class="text-danger">*</span></label>
                            <select name="jenis" id="jenisSelect" class="form-control" required onchange="toggleClassField()">
                                <option value="" disabled <?= $item['jenis']=='' ? 'selected' : '' ?>>Pilih Jenis</option>
                                <option value="JCP" <?= $item['jenis']=='JCP' ? 'selected' : '' ?>>JCP</option>
                                <option value="CCF" <?= $item['jenis']=='CCF' ? 'selected' : '' ?>>CCF</option>
                            </select>
                        </div>
                    </div>

                    <div class="col-md-6" id="classGroup">
                        <div class="form-group">
                            <label>Class <span class="text-danger">*</span></label>
                            <select name="class" id="classInput" class="form-control">
                                <option value="">-- PILIH CLASS --</option>
                                <option value="A" <?= $item['class'] == 'A' ? 'selected' : '' ?>>A</option>
                                <option value="B" <?= $item['class'] == 'B' ? 'selected' : '' ?>>B</option>
                                <option value="C" <?= $item['class'] == 'C' ? 'selected' : '' ?>>C</option>
                                <option value="D" <?= $item['class'] == 'D' ? 'selected' : '' ?>>D</option>
                            </select>
                        </div>
                    </div>

                </div>
                <div class="row mb-3">
                    <div class="col-md-4">
                        <div class="form-group">
                            <label>Category <span class="text-danger">*</span></label>
                            <input type="text" name="mm_category" class="form-control" placeholder="Contoh: BODY/FRAME" required value="<?= esc($item['mm_category']) ?>">
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label>Part List <span class="text-danger">*</span></label>
                            <input type="text" name="mm_part_list" class="form-control" required value="<?= esc($item['mm_part_list']) ?>">
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label>Material Spec <span class="text-danger">*</span></label>
                            <input type="text" name="mm_material_spec" class="form-control" required value="<?= esc($item['mm_material_spec']) ?>">
                        </div>
                    </div>
                </div>

                <div class="row mb-3">
                    <div class="col-md-4">
                        <div class="form-group">
                            <label>Size L (mm)</label>
                            <input type="number" name="mm_size_type_l" class="form-control" placeholder="L" value="<?= esc($item['mm_size_type_l']) ?>">
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label>Size W (mm)</label>
                            <input type="number" name="mm_size_type_w" class="form-control" placeholder="W" value="<?= esc($item['mm_size_type_w']) ?>">
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label>Size H (mm)</label>
                            <input type="number" name="mm_size_type_h" class="form-control" placeholder="H" value="<?= esc($item['mm_size_type_h']) ?>">
                        </div>
                    </div>
                </div>

                <div class="row mb-3">
                    <div class="col-md-4">
                        <div class="form-group">
                            <label>Qty</label>
                            <input type="number" name="mm_qty" class="form-control" placeholder="Qty" value="<?= esc($item['mm_qty']) ?>">
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label>Weight</label>
                            <input type="number" name="mm_weight" class="form-control" placeholder="Weight" value="<?= esc($item['mm_weight']) ?>" step="any">
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label>Cost</label>
                            <input type="number" name="mm_cost" class="form-control" placeholder="Cost" value="<?= esc($item['mm_cost']) ?>">
                        </div>
                    </div>
                </div>

                <div class="form-group text-right mt-3">
                    <button type="submit" class="btn btn-success">Update</button>
                    <a href="<?= site_url('ccf-master-main-material') ?>" class="btn btn-secondary">Batal</a>
                </div>
            </form>
        </div>
    </div>
</div>
<script>
function toggleClassField() {
    const jenis = document.getElementById('jenisSelect').value;
    const classGroup = document.getElementById('classGroup');
    const classInput = document.getElementById('classInput');

    if (jenis === 'CCF') {
        classGroup.style.display = 'none';
        classInput.removeAttribute('required');
        classInput.value = ''; 
        
    } else {
        classGroup.style.display = 'block';
        classInput.setAttribute('required', 'required');
    }
}

window.addEventListener('DOMContentLoaded', toggleClassField);
</script>
<?= $this->endSection() ?>
