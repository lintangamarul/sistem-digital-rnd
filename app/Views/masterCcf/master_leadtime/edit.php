<?= $this->extend('layout/template') ?>

<?= $this->section('content') ?>
<link rel="stylesheet" type="text/css" href="<?= base_url('assets/vendors/styles/icon-font.min.css') ?>">
<link rel="stylesheet" type="text/css" href="<?= base_url('assets/plugins/datatables/css/dataTables.bootstrap4.min.css') ?>">
<link rel="stylesheet" type="text/css" href="<?= base_url('assets/plugins/datatables/css/responsive.bootstrap4.min.css') ?>">

<div class="pd-ltr-20 xs-pd-20-10">
  <div class="min-height-200px">
    <!-- Page Header -->
    <div class="page-header">
      <div class="row">
        <div class="col-md-6 col-sm-12">
          <div class="title">
            <h4>Edit CCF Lead Time </h4>
          </div>
          <nav aria-label="breadcrumb" role="navigation">
            <ol class="breadcrumb">
              <li class="breadcrumb-item">
                <a href="<?= site_url('dashboard'); ?>">Home</a>
              </li>
              <li class="breadcrumb-item">
                <a href="<?= route_to('ccf-master-leadtime.index'); ?>">Master CCF</a>
              </li>
              <li class="breadcrumb-item active" aria-current="page">Edit Lead Time</li>
            </ol>
          </nav>
        </div>
      </div>
    </div>
    <!-- End Page Header -->

    <div class="pd-20 card-box mb-30">
      <form action="<?= route_to('ccf-master-leadtime.update', $record['id']) ?>" method="post">
        <?= csrf_field() ?>
        <div class="form-group row">
          <div class="col-md-6">
            <label>Category <span class="text-danger">*</span></label>
            <input type="text"
                   name="category"
                   class="form-control"
                   value="<?= esc($record['category']) ?>"
                   required>
          </div>
          <div class="col-md-6">
              <label>Class <span class="text-danger">*</span></label>
              <select class="custom-select2 form-control" name="class" required>
                  <option value="">-- PILIH CLASS --</option>
                  <option value="A SIMPLE" <?= $record['class'] === 'A SIMPLE' ? 'selected' : '' ?>>A SIMPLE</option>
                  <option value="A SULIT" <?= $record['class'] === 'A SULIT' ? 'selected' : '' ?>>A SULIT</option>
                  <option value="B SIMPLE" <?= $record['class'] === 'B SIMPLE' ? 'selected' : '' ?>>B SIMPLE</option>
                  <option value="B SULIT" <?= $record['class'] === 'B SULIT' ? 'selected' : '' ?>>B SULIT</option>
                  <option value="C SIMPLE" <?= $record['class'] === 'C SIMPLE' ? 'selected' : '' ?>>C SIMPLE</option>
                  <option value="C SULIT" <?= $record['class'] === 'C SULIT' ? 'selected' : '' ?>>C SULIT</option>
                  <option value="D SIMPLE" <?= $record['class'] === 'D SIMPLE' ? 'selected' : '' ?>>D SIMPLE</option>
                  <option value="D SULIT" <?= $record['class'] === 'D SULIT' ? 'selected' : '' ?>>D SULIT</option>
              </select>
          </div>
        </div>
        <div class="form-group row">
          <div class="col-md-6">
            <label>Hour <span class="text-danger">*</span></label>
            <input type="number"
                   name="hour"
                   class="form-control"
                   value="<?= esc($record['hour']) ?>"
                   required>
          </div>
          <div class="col-md-6">
            <label>Week <span class="text-danger">*</span></label>
            <input type="number"
                   name="week"
                   class="form-control"
                   value="<?= esc($record['week']) ?>"
                   required>
          </div>
        </div>
        <div class="form-group row">
        
          <div class="col-md-12 text-right align-self-end">
            <button type="submit" class="btn btn-success">Update</button>
            <a href="<?= route_to('ccf-master-leadtime.index'); ?>" class="btn btn-secondary">Kembali</a>
          </div>
        </div>
      </form>
    </div>
  </div>
</div>
<?= $this->endSection() ?>
