<!-- File: app/Views/roles/edit.php -->
<?= $this->extend('layout/template') ?>
<?= $this->section('content') ?>

<div class="pd-ltr-20 xs-pd-20-10">
  <div class="min-height-200px">
    <div class="page-header">
      <div class="row">
        <div class="col-md-6 col-sm-12">
          <div class="title">
            <h4>Edit Role</h4>
          </div>
          <nav aria-label="breadcrumb" role="navigation">
            <ol class="breadcrumb">
              <li class="breadcrumb-item"><a href="<?= site_url('actual-activity/personal'); ?>">Home</a></li>
              <li class="breadcrumb-item"><a href="<?= site_url('role'); ?>">Roles</a></li>
              <li class="breadcrumb-item active" aria-current="page">Form Edit Role</li>
            </ol>
          </nav>
        </div>
      </div>
    </div>

    <div class="card-box p-4">
      <form action="<?= site_url('role/update/'.$role['id']); ?>" method="post">
      <?= csrf_field(); ?>
        <div class="form-group row">
          <label class="col-sm-3 col-form-label">Role Name <span style="color: red;">*</span></label>
          <div class="col-sm-9">
            <input type="text" name="role_name" class="form-control" placeholder="Masukkan nama role" value="<?= esc($role['role_name']); ?>" required>
          </div>
        </div>

        <?php
          $groupedFitur = [];

          foreach ($fitur_list as $fitur) {
              $words = explode(' ', $fitur['Nama']);
              $groupKey = isset($words[1]) ? $words[1] : 'Lainnya';
              $groupedFitur[$groupKey][] = $fitur;
          }
          ?>

          <p>Pilih Fitur<span style="color: red;">*</span></p>
          <div class="row">
            <?php foreach ($groupedFitur as $groupName => $fiturs) : ?>
              <div class="col-md-12 mb-4">
                <div class="card shadow-sm border-left-primary">
                  <div class="card-header">
                    <strong><?= strtoupper($groupName); ?></strong>
                  </div>
                  <div class="card-body">
                    <div class="row">
                      <?php foreach ($fiturs as $fitur) : ?>
                        <?php
                          $checked = isset($role_features) && in_array($fitur['Id_Fitur'], array_column($role_features, 'fitur_id')) ? 'checked' : '';
                        ?>
                        <div class="col-md-3 col-sm-6 mb-3">
                          <div class="custom-control custom-checkbox">
                            <input type="checkbox" class="custom-control-input" id="fitur_<?= $fitur['Id_Fitur']; ?>" name="fitur[]" value="<?= $fitur['Id_Fitur']; ?>" <?= $checked; ?>>
                            <label class="custom-control-label" for="fitur_<?= $fitur['Id_Fitur']; ?>"><?= $fitur['Nama']; ?></label>
                          </div>
                        </div>
                      <?php endforeach; ?>
                    </div>
                  </div>
                </div>
              </div>
            <?php endforeach; ?>
          </div>


        <div class="form-group row">
          <div class="col-sm-12">
            <button type="submit" class="btn btn-success">Update</button>
            <a href="<?= site_url('role'); ?>" class="btn btn-secondary">Kembali</a>
          </div>
        </div>
      </form>
    </div>
  </div>
</div>

<?= $this->endSection() ?>
