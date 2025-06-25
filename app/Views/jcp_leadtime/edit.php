<?= $this->extend('layout/template') ?>

<?= $this->section('content') ?>
<link rel="stylesheet" type="text/css" href="<?= base_url('assets/vendors/styles/icon-font.min.css') ?>">
<link rel="stylesheet" type="text/css" href="<?= base_url('assets/plugins/datatables/css/dataTables.bootstrap4.min.css') ?>">
<link rel="stylesheet" type="text/css" href="<?= base_url('assets/plugins/datatables/css/responsive.bootstrap4.min.css') ?>">

<div class="pd-ltr-20 xs-pd-20-10">
  <div class="min-height-200px">
    <div class="page-header">
      <div class="row">
        <div class="col-md-6 col-sm-12">
          <div class="title">
            <h4>Edit JCP Lead Time</h4>
          </div>
          <nav aria-label="breadcrumb" role="navigation">
            <ol class="breadcrumb">
              <li class="breadcrumb-item"><a href="<?= site_url('dashboard'); ?>">Home</a></li>
              <li class="breadcrumb-item"><a href="<?= site_url('jcp-master-leadtime'); ?>">JCP Lead Time</a></li>
              <li class="breadcrumb-item active" aria-current="page">Edit</li>
            </ol>
          </nav>
        </div>
      </div>
    </div>

    <div class="pd-20 card-box mb-30">
      <form action="<?= site_url('jcp-master-leadtime/update/' . $leadtime['id']) ?>" method="post">
        <?= csrf_field() ?>
        <div class="form-group row">
          <div class="col-md-6">
            <label>Parts <span class="text-danger">*</span></label>
            <input type="text" name="parts" class="form-control" value="<?= esc($leadtime['parts']) ?>" required>
          </div>
          <div class="col-md-6">
            <label>Class <span class="text-danger">*</span></label>
            <input type="text" name="class" class="form-control" value="<?= esc($leadtime['class']) ?>" required>
          </div>
        </div>
        <div class="form-group row">
          <div class="col-md-4">
            <label>Measuring Hour</label>
            <input type="number" name="measuring_hour" class="form-control" value="<?= esc($leadtime['measuring_hour']) ?>">
          </div>
          <div class="col-md-4">
            <label>Laser Cutting</label>
            <input type="number" name="hour_machine_laser_cutting" class="form-control" value="<?= esc($leadtime['hour_machine_laser_cutting']) ?>">
          </div>
          <div class="col-md-4">
            <label>Big Machine</label>
            <input type="number" name="hour_machine_big" class="form-control" value="<?= esc($leadtime['hour_machine_big']) ?>">
          </div>
        </div>
        <div class="form-group row">
          <div class="col-md-4">
            <label>Small Machine</label>
            <input type="number" name="hour_machine_small" class="form-control" value="<?= esc($leadtime['hour_machine_small']) ?>">
          </div>
          <div class="col-md-4">
            <label>Total Day</label>
            <input type="number" name="total_day" class="form-control" value="<?= esc($leadtime['total_day']) ?>">
          </div>
          <div class="col-md-4">
            <label>Status</label>
            <select name="status" class="form-control">
              <option value="1" <?= $leadtime['status'] == 1 ? 'selected' : '' ?>>Aktif</option>
              <option value="0" <?= $leadtime['status'] == 0 ? 'selected' : '' ?>>Tidak Aktif</option>
            </select>
          </div>
        </div>
        <div class="text-right">
          <button type="submit" class="btn btn-success">Update</button>
          <a href="<?= site_url('jcp-master-leadtime') ?>" class="btn btn-secondary">Kembali</a>
        </div>
      </form>
    </div>
  </div>
</div>

<?= $this->endSection() ?>
