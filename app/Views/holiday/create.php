<?= $this->extend('layout/template') ?>
<?= $this->section('content') ?>

<div class="pd-ltr-20 xs-pd-20-10">
  <div class="min-height-200px">
    <!-- Page Header -->
    <div class="page-header ">
      <div class="row">
        <div class="col-md-6 col-sm-12">
          <div class="title">
            <h4>Add Holiday</h4>
          </div>
          <nav aria-label="breadcrumb" role="navigation">
            <ol class="breadcrumb">
              <li class="breadcrumb-item">
                <a href="<?= site_url('dashboard'); ?>">Home</a>
              </li>
              <li class="breadcrumb-item">
                <a href="<?= site_url('holiday'); ?>">Holiday</a>
              </li>
              <li class="breadcrumb-item active" aria-current="page">
                Form Tambah Holiday
              </li>
            </ol>
          </nav>
        </div>
      </div>
    </div>

    <!-- Card Box Form -->
    <div class="card-box p-4">
      <?php if(session()->getFlashdata('error')): ?>
        <div class="alert alert-danger"><?= session()->getFlashdata('error'); ?></div>
      <?php endif; ?>
      <?php if(session()->getFlashdata('success')): ?>
        <div class="alert alert-success"><?= session()->getFlashdata('success'); ?></div>
      <?php endif; ?>

      <form action="<?= site_url('holiday/store'); ?>" method="post">
        <?= csrf_field(); ?>
        
        <div class="form-group row">
          <label for="holiday_date" class="col-sm-3 col-form-label">
            Tanggal Libur <span style="color: red;">*</span>
          </label>
          <div class="col-sm-9">
            <input type="date" name="holiday_date" id="holiday_date" class="form-control" required>
          </div>
        </div>
        
        <div class="form-group row">
          <label for="description" class="col-sm-3 col-form-label">
            Deskripsi
          </label>
          <div class="col-sm-9">
            <input type="text" name="description" id="description" class="form-control" placeholder="Optional description">
          </div>
        </div>
        
        <div class="form-group row">
          <div class="col-sm-9 offset-sm-3">
            <button type="submit" class="btn btn-success">Add Holiday</button>
            <a href="<?= site_url('holiday'); ?>" class="btn btn-secondary">Back</a>
          </div>
        </div>
      </form>
    </div>
  </div>
</div>

<?= $this->endSection() ?>
