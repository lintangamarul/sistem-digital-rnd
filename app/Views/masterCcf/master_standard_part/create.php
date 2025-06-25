<?= $this->extend('layout/template') ?>
<?= $this->section('content') ?>

<div class="pd-ltr-20 xs-pd-20-10">
    <div class="min-height-200px">
        <div class="page-header">
            <div class="row">
                <div class="col-md-6 col-sm-12">
                    <div class="title">
                        <h4>Tambah Data Standard Part</h4>
                    </div>
                    <nav aria-label="breadcrumb" role="navigation">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="<?= site_url('/') ?>">Home</a></li>
                            <li class="breadcrumb-item"><a href="<?= site_url('ccf-master-standard-part') ?>">Standard Part</a></li>
                            <li class="breadcrumb-item active" aria-current="page">Tambah Data</li>
                        </ol>
                    </nav>
                </div>
            </div>
        </div>
        <div class="card-box p-4">
            <form action="<?= site_url('ccf-master-standard-part/store') ?>" method="post">
                <?= csrf_field() ?>
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>Jenis <span style="color: red;">*</span></label>
                            <select name="jenis" class="form-control" id="jenisSelect" required>
                                <option value="" disabled selected>Pilih Jenis</option>
                                <option value="JCP">JCP</option>
                                <option value="CCF">CCF</option>
                            </select>
                        </div>

                        <div class="form-group" id="classGroup">
                            <label>Class <span style="color: red;">*</span></label>
                            <select name="class" id="classSelect" class="form-control" required>
                                <option value="">-- PILIH CLASS --</option>
                                <option value="A">A</option>
                                <option value="B">B</option>
                                <option value="C">C</option>
                                <option value="D">D</option>
                            </select>
                        </div>

                        <div class="form-group">
                            <label>Category <span style="color: red;">*</span></label>
                            <input name="sp_category" class="form-control" placeholder="Contoh: ELECTRICAL COMPONENT/ACCESSORIES" required>
                        </div>

                        <div class="form-group">
                            <label>Part List</label>
                            <input name="sp_part_list"  placeholder="Part List" class="form-control">
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>Material Spec <span style="color: red;">*</span></label>
                            <input name="sp_material_spec" class="form-control" placeholder="Contoh: MISUMI/CKD" >
                        </div>
                        <div class="form-group">
                            <label>Size Type</label>
                            <input name="sp_size_type"  placeholder="Size Type" class="form-control">
                        </div>
                        <div class="form-group">
                            <label>Qty</label>
                            <input name="sp_qty" type="number"  placeholder="Qty" class="form-control">
                        </div>
                        <div class="form-group">
                            <label>Cost</label>
                            <input name="sp_cost" class="form-control">
                        </div>
                    </div>
                </div>
                <div class="form-group text-right mt-3">
                    <button type="submit" class="btn btn-success">Simpan</button>
                    <a href="<?= site_url('ccf-master-standard-part') ?>" class="btn btn-secondary">Batal</a>
                </div>
            </form>
        </div>
    </div>
</div>



<script>
    document.addEventListener('DOMContentLoaded', function () {
        const jenisSelect = document.getElementById('jenisSelect');
        const classGroup = document.getElementById('classGroup');
        const classSelect = document.getElementById('classSelect');

        function toggleClassField() {
            if (jenisSelect.value === 'CCF') {
                classGroup.style.display = 'none';
                      classSelect.value = '';
                classSelect.removeAttribute('required');
            } else {
                classGroup.style.display = 'block';
                classSelect.setAttribute('required', true);
            }
        }
        toggleClassField();

        jenisSelect.addEventListener('change', toggleClassField);
    });
</script>

<?= $this->endSection() ?>
