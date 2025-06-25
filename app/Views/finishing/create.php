<?= $this->extend('layout/template') ?>

<?= $this->section('content') ?>
<div class="pd-ltr-20 xs-pd-20-10">
  <div class="min-height-200px">
    <!-- Page Header -->
    <div class="page-header">
      <div class="row">
        <div class="col-md-6 col-sm-12">
          <div class="title">
            <h4>Tambah Data Finishing</h4>
          </div>
          <nav aria-label="breadcrumb" role="navigation">
            <ol class="breadcrumb">
              <li class="breadcrumb-item"><a href="<?= site_url('home'); ?>">Home</a></li>
              <li class="breadcrumb-item"><a href="<?= site_url('finishing'); ?>">Finishing</a></li>
              <li class="breadcrumb-item active" aria-current="page">Tambah Data</li>
            </ol>
          </nav>
        </div>
      </div>
    </div>
    <!-- End Page Header -->

    <div class="pd-20 card-box mb-30">
      <form action="<?= site_url('finishing/store') ?>" method="post">
        <?= csrf_field() ?>
        <div class="form-group row">
          <div class="col-md-6">
            <label>Part List <span style="color: red">*</span></label>
            <input type="text" name="part_list" class=  "form-control" required>
          </div>
          <div class="col-md-6">
            <label>Material <span style="color: red">*</span></label>
            <input type="text" name="material" class="form-control" >
          </div>
        </div>
        <div class="form-group row">
          <div class="col-md-6">
            <label>Diameter</label>
            <input type="text" name="diameter" class="form-control" >
          </div>
          <div class="col-md-6">
            <label>Class <span style="color: red">*</span></label>
            <input type="text" name="class" class="form-control" required>
          </div>
        </div>
        <div class="form-group row">
          <div class="col-md-6">
            <label>Qty</label>
            <input type="number" name="qty" class="form-control" >
          </div>
          <div class="col-md-6">
            <label>Remarks</label>
            <input type="text" name="remarks" class="form-control">
          </div>
        </div>
        <div class="form-group row">
          <div class="col-md-6">
            <label>Process <span style="color: red">*</span></label>
            <input type="text" name="process" class="form-control" required>
          </div>
          <!-- <div class="col-md-6">
            <label>Status <span style="color: red">*</span></label>
            <select name="status" class="form-control" required>
              <option value="1">Aktif</option>
              <option value="0">Tidak Aktif</option>
            </select>
          </div> -->
        </div>
        <div class="form-group row">
          <div class="col-md-12 text-right">
            <button type="submit" class="btn btn-success">Simpan</button>
            <a href="<?= site_url('finishing'); ?>" class="btn btn-secondary">Kembali</a>
          </div>
        </div>
      </form>
    </div>
  </div>
</div>
<?= $this->endSection() ?>
