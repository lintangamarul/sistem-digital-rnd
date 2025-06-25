<?= $this->extend('layout/template') ?>
<?= $this->section('content') ?>
<div class="pd-ltr-20 xs-pd-20-10">
  <div class="min-height-200px">
    <div class="page-header">
      <div class="row">
        <div class="col-md-6 col-sm-12">
          <div class="title">
            <h4>Tambah Project</h4>
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
                Form Tambah Project
              </li>
            </ol>
          </nav>
        </div>
      </div>
    </div>
    <div class="pd-20 card-box mb-30">
      <form action="<?= site_url('project/store'); ?>" method="post">
        <?= csrf_field(); ?>
        <div class="form-group row">
          <div class="col-md-12">
            <label class="col-form-label">Jenis <span style="color: red">*</span></label><br>
            <input type="radio" name="jenis" value="Others" id="others" checked onclick="toggleFields()"> 
            <label for="others">Others</label>
            <input type="radio" name="jenis" value="Tooling Project" id="tooling" onclick="toggleFields()"> 
            <label for="tooling">Tooling Project</label>
          </div>
        </div>
        <div id="othersFields">
          <div class="form-group row">
            <div class="col-md-12">
              <label class="col-form-label">Nama Project <span style="color: red">*</span></label>
              <input type="text" name="another_project" class="form-control">
            </div>
          </div>
        </div>
        <div id="toolingFields" style="display:none;">
          <div class="form-group row">
            <div class="col-md-6">
              <label class="col-form-label">Jenis <span style="color: red">*</span></label><br>
              <input type="radio" name="jenis_tooling" value="Dies" id="dies" checked> 
              <label for="dies">Dies</label>
              <input type="radio" name="jenis_tooling" value="Jig" id="jig"> 
              <label for="jig">Jig</label>
            </div>
            <div class="col-md-6">
              <label class="col-form-label">Tingkatan <span style="color: red">*</span></label><br>
              <input type="radio" name="tingkatan" value="Production" id="production" checked> 
              <label for="production">Production</label>
              <input type="radio" name="tingkatan" value="RFQ" id="rfq"> 
              <label for="rfq">RFQ</label>
            </div>
          </div>
          <div class="form-group row">
            <div class="col-md-4">
              <label class="col-form-label">Model <span style="color: red">*</span></label>
              <input type="text" name="model" class="form-control">
            </div>
            <div class="col-md-4">
              <label class="col-form-label">Part No <span style="color: red">*</span></label>
              <input type="text" name="part_no" class="form-control">
            </div>
            <div class="col-md-4">
              <label class="col-form-label">Part name <span style="color: red">*</span></label>
              <input type="text" name="part_name" class="form-control">
            </div>
          </div>
           <div class="form-group row">
            <div class="col-md-4">
              <label class="col-form-label">Customer <span style="color: red">*</span></label>
              <input type="text" name="customer" class="form-control">
            </div>
</div>
          <div class="form-group row">
            <div class="col-md-6">
              <label class="col-form-label" id="process-label">OP</label>
              <div class="input-group">
                <select name="process" class="custom-select2 form-control mr-1" style="width: 50%; height: 38px;">
                  <option value="">Pilih</option>
                  <?php for ($i = 10; $i <= 80; $i += 10): ?>
                    <option value="OP<?= $i; ?>">OP<?= $i; ?></option>
                  <?php endfor; ?>
                </select>
                <select name="process2" class="custom-select2 form-control" style="width: 50%; height: 38px;">
                  <option value="">Pilih Join (Optional)</option>
                  <?php for ($i = 10; $i <= 80; $i += 10): ?>
                    <option value="OP<?= $i; ?>">OP<?= $i; ?></option>
                  <?php endfor; ?>
                </select>
              </div>
            </div>
            <div class="col-md-6">
              <label class="col-form-label">Nama Proses </label>
              <input type="text" name="proses" class="form-control">
            </div>
          </div>
        </div>
        <input type="hidden" name="status" value="1">
        <div class="form-group row">
          <div class="col-md-12">
            <button type="submit" class="btn btn-success">Simpan</button>
            <a href="<?= site_url('project'); ?>" class="btn btn-secondary">Kembali</a>
          </div>
        </div>
      </form>
    </div>
  </div>
</div>
<script>
function toggleFields() {
    var jenis = document.querySelector('input[name="jenis"]:checked').value;
    document.getElementById('toolingFields').style.display = (jenis === 'Tooling Project') ? 'block' : 'none';
    document.getElementById('othersFields').style.display = (jenis === 'Others') ? 'block' : 'none';
}

</script>
<script>
function toggleFields() {
    var jenis = document.querySelector('input[name="jenis"]:checked').value;
    document.getElementById('toolingFields').style.display = (jenis === 'Tooling Project') ? 'block' : 'none';
    document.getElementById('othersFields').style.display = (jenis === 'Others') ? 'block' : 'none';
    toggleProcessFields(); // tambahkan agar update sesuai pilihan saat jenis berubah
}

function toggleProcessFields() {
    var rfqChecked = document.getElementById('rfq').checked;
    var processLabel = document.getElementById('process-label').parentElement.parentElement;
    if (rfqChecked) {
        processLabel.style.display = 'none';
    } else {
        processLabel.style.display = 'flex';
    }
}

document.addEventListener('DOMContentLoaded', function () {
    document.getElementById('rfq').addEventListener('change', toggleProcessFields);
    document.getElementById('production').addEventListener('change', toggleProcessFields);
});
</script>

<?= $this->endSection() ?>
