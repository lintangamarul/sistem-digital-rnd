<?= $this->extend('layout/template') ?>
<?= $this->section('content') ?>

<div class="pd-ltr-20 xs-pd-20-10">
    <div class="min-height-200px">
        <div class="page-header">
            <div class="row">
                <div class="col-md-6 col-sm-12">
                    <div class="title">
                        <h4>Tambah Data Main Material</h4>
                    </div>
                    <nav aria-label="breadcrumb" role="navigation">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="<?= site_url('/') ?>">Home</a></li>
                            <li class="breadcrumb-item"><a href="<?= site_url('ccf-master-main-material') ?>">Main Material</a></li>
                            <li class="breadcrumb-item active" aria-current="page">Tambah Data</li>
                        </ol>
                    </nav>
                </div>
            </div>
        </div>

        <div class="card-box p-4">
            <form action="<?= site_url('ccf-master-main-material/store') ?>" method="post">
                <?= csrf_field() ?>

                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>Jenis <span class="text-danger">*</span></label>
                            <select name="jenis" class="form-control" id="jenisSelect" required onchange="toggleClassField()">
                                <option value="" disabled selected>Pilih Jenis</option>
                                <option value="JCP">JCP</option>
                                <option value="CCF">CCF</option>
                            </select>
                        </div>
                    </div>

                    <div class="col-md-6" id="classGroup">
                        <div class="form-group">
                            <label>Class <span class="text-danger">*</span></label>
                            <select name="class" id="classInput" class="form-control" required>
                                <option value="">-- PILIH CLASS --</option>
                                <option value="A">A</option>
                                <option value="B">B</option>
                                <option value="C">C</option>
                                <option value="D">D</option>
                            </select>
                        </div>
                    </div>

                </div>


                <div class="row">
                <div class="col-md-4">
                        <div class="form-group">
                            <label>Category <span class="text-danger">*</span></label>
                            <input type="text" name="mm_category" class="form-control" placeholder="Contoh: BODY/FRAME" required>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label>Part List <span class="text-danger">*</span></label>
                            <input type="text" name="mm_part_list" class="form-control" required placeholder="Contoh: Frame/Hook"> 
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label>Material Spec <span class="text-danger">*</span></label>
                            <input type="text" name="mm_material_spec" class="form-control" required placeholder="Contoh: SS41/S45C">
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-4">
                        <div class="form-group">
                            <label>Size L (mm)</label>
                            <input type="number" name="mm_size_type_l" class="form-control" placeholder="L">
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label>Size W (mm)</label>
                            <input type="number" name="mm_size_type_w" class="form-control" placeholder="W">
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label>Size H (mm)</label>
                            <input type="number" name="mm_size_type_h" class="form-control" placeholder="H">
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-4">
                        <div class="form-group">
                            <label>Qty</label>
                            <input type="number" name="mm_qty" class="form-control" placeholder="Qty">
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label>Weight</label>
                            <input type="number" name="mm_weight" class="form-control" placeholder="Weight">
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label>Cost</label>
                            <input type="number" name="mm_cost" class="form-control">
                        </div>
                    </div>
                </div>


                <div class="form-group text-right mt-3">
                    <button type="submit" class="btn btn-success">Simpan</button>
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
</script>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        const jenisSelect = document.querySelector('select[name="jenis"]');
        const classGroup = document.getElementById('classGroup');
        const classInput = document.getElementById('classInput');

        function toggleClassRequirement() {
            if (jenisSelect.value === 'CCF') {
                classGroup.style.display = 'none';
       
                classInput.removeAttribute('required');
            } else {
                classGroup.style.display = 'block';
                classInput.setAttribute('required', true);
            }
        }
        jenisSelect.addEventListener('change', toggleClassRequirement);
        toggleClassRequirement();
    });
</script>

<?= $this->endSection() ?>
