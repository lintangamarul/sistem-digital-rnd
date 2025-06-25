<?= $this->extend('layout/template') ?>
<?= $this->section('content') ?>

<div class="pd-ltr-20 xs-pd-20-10">
    <div class="min-height-200px">
        <div class="page-header">
            <div class="row">
                <div class="col-md-6 col-sm-12">
                    <div class="title">
                        <h4>Tambah Data Tool Cost</h4>
                    </div>
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="<?= site_url('/') ?>">Home</a></li>
                            <li class="breadcrumb-item"><a href="<?= site_url('ccf-master-tool-cost') ?>">Tool Cost</a></li>
                            <li class="breadcrumb-item active" aria-current="page">Tambah</li>
                        </ol>
                    </nav>
                </div>
            </div>
        </div>

        <div class="card-box p-4">
            <form action="<?= site_url('ccf-master-tool-cost/store') ?>" method="post">
                <?= csrf_field() ?>

                <div class="row">
                    <div class="col-md-6">

                    <div class="form-group">
                            <label>Jenis <span class="text-danger">*</span></label>
                            <select name="jenis" class="form-control" id="jenisSelect" required>
                                <option value="">-- Pilih Jenis --</option>
                                <option value="CCF">CCF</option>
                                <option value="JCP">JCP</option>
                            </select>
                        </div>

                        <div class="form-group" id="classGroup">
                            <label>Class <span class="text-danger">*</span></label>
                            <select name="class" class="form-control" id="classSelect" required>
                                <option value="">-- PILIH CLASS --</option>
                                <option value="A">A</option>
                                <option value="B">B</option>
                                <option value="C">C</option>
                                <option value="D">D</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label>Process <span class="text-danger">*</span></label>
                            <input type="text" name="tool_cost_process" class="form-control" required placeholder="FACING/DRILLING/DLL">
                        </div>
                    </div>
                    <div class="col-md-6">
                         <div class="form-group">
                            <label>Tool <span class="text-danger">*</span></label>
                            <input type="text" name="tool_cost_tool" class="form-control" required placeholder="Mata Bor/End Mill/dll">
                        </div>
                        <div class="form-group">
                            <label>Spec</label>
                            <input type="text" name="tool_cost_spec" class="form-control" placeholder="spesifikasi">
                        </div>
                        <div class="form-group">
                            <label>Qty</label>
                            <input type="number" name="tool_cost_qty" class="form-control">
                        </div>
                    </div>
                </div>

                <div class="form-group text-right mt-3">
                    <button type="submit" class="btn btn-success">Simpan</button>
                    <a href="<?= site_url('ccf-master-tool-cost') ?>" class="btn btn-secondary">Batal</a>
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

    function toggleClassVisibility() {
        if (jenisSelect.value === 'CCF') {
            classGroup.style.display = 'none';
            classSelect.value = ''; 
            classSelect.removeAttribute('required');
        } else {
            classGroup.style.display = 'block';
            classSelect.setAttribute('required', true);
        }
    }

    toggleClassVisibility(); 
    jenisSelect.addEventListener('change', toggleClassVisibility);
});
</script>

<?= $this->endSection() ?>
