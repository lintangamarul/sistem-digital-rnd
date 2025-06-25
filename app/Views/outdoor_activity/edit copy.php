<?= $this->extend('layout/template') ?>
<?= $this->section('content') ?>

<div class="pd-ltr-20 xs-pd-20-10">
  <div class="min-height-200px">
    <!-- Page Header -->
    <div class="page-header ">
      <div class="row">
        <div class="col-md-6 col-sm-12">
          <div class="title">
            <h4>Edit Outdoor Activity</h4>
          </div>
          <nav aria-label="breadcrumb" role="navigation">
            <ol class="breadcrumb">
              <li class="breadcrumb-item">
                <a href="<?= site_url('dashboard'); ?>">Home</a>
              </li>
              <li class="breadcrumb-item">
                <a href="<?= site_url('outdoor-activity'); ?>">Outdoor Activity</a>
              </li>
              <li class="breadcrumb-item active" aria-current="page">
                Edit Outdoor Activity
              </li>
            </ol>
          </nav>
        </div>
      </div>
    </div>

    <!-- Card Box Form -->
    <div class="card-box p-4">
      <form action="<?= site_url('outdoor-activity/update/'.$activity['id']); ?>" method="post">
        <?= csrf_field(); ?>
        
        <div class="form-group row">
          <label for="user_id" class="col-sm-3 col-form-label">
            User <span style="color: red;">*</span>
          </label>
          <div class="col-sm-9">
            <select name="user_id" id="user_id" class="custom-select2 form-control" style="width: 100%; height: 38px;" required>
              <option value="">Pilih User</option>
              <?php foreach($users as $user): ?>
                <option value="<?= $user['id'] ?>" <?= ($user['id'] == $activity['user_id']) ? 'selected' : '' ?>>
                  <?= $user['nama'] . ' - ' . $user['nik'] ?>
                </option>
              <?php endforeach; ?>
            </select>
          </div>
        </div>
        
        <div class="form-group row">
          <label class="col-sm-3 col-form-label">Status</label>
          <div class="col-sm-9">
            <div class="form-check form-check-inline">
              <input type="checkbox" class="form-check-input" name="kehadiran" id="kehadiran" value="1" <?= $activity['kehadiran'] ? 'checked' : '' ?>>
              <label class="form-check-label" for="kehadiran">Kehadiran</label>
            </div>
            <div class="form-check form-check-inline">
              <input type="checkbox" class="form-check-input" name="cuti" id="cuti" value="1" <?= $activity['cuti'] ? 'checked' : '' ?>>
              <label class="form-check-label" for="cuti">Cuti</label>
            </div>
            <div class="form-check form-check-inline">
              <input type="checkbox" class="form-check-input" name="genba" id="genba" value="1" <?= $activity['genba'] ? 'checked' : '' ?>>
              <label class="form-check-label" for="genba">Genba</label>
            </div>
            <div class="form-check form-check-inline">
              <input type="checkbox" class="form-check-input" name="night_shift" id="night_shift" value="1" <?= $activity['night_shift'] ? 'checked' : '' ?>>
              <label class="form-check-label" for="night_shift">Night Shift</label>
            </div>
          </div>
        </div>
        
        <div class="form-group row">
          <div class="col-sm-9 offset-sm-3">
            <button type="submit" class="btn btn-success">Update</button>
            <a href="<?= site_url('outdoor-activity'); ?>" class="btn btn-secondary">Kembali</a>
          </div>
        </div>
      </form>
    </div>
  </div>
</div>

<?= $this->endSection() ?>
