<?= $this->extend('layout/template') ?>
<?= $this->section('content') ?>

<div class="pd-ltr-20 xs-pd-20-10">
  <div class="min-height-200px">
    <!-- Page Header -->
    <div class="page-header">
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
        
        <!-- Dropdown User -->
        <div class="form-group row">
          <label for="user_id" class="col-sm-3 col-form-label">
            User <span style="color: red;">*</span>
          </label>
          <div class="col-sm-9">
            <select name="user_id_display" id="user_id" class="custom-select2 form-control" style="width: 100%; height: 38px;" disabled>
            <option value="">Pilih User</option>
            <?php foreach($users as $user): ?>
                <option value="<?= $user['id'] ?>" <?= ($user['id'] == $activity['user_id']) ? 'selected' : '' ?>>
                <?= $user['nama'] . ' - ' . $user['nik'] ?>
                </option>
            <?php endforeach; ?>
            </select>
            <input type="hidden" name="user_id" value="<?= $activity['user_id'] ?>">
        </div>

        </div>
      
        <!-- Dropdown Status Kehadiran -->
        <div class="form-group row">
          <label class="col-sm-3 col-form-label">
            Status Kehadiran <span style="color: red;">*</span>
          </label>
          <div class="col-sm-9">
            <select name="kehadiran" id="kehadiran" class="custom-select2 form-control" style="width: 100%; height: 38px;" required onchange="toggleStatusDropdown();">
              <option value="">-- Pilih Status --</option>
              <option value="1" <?= ($activity['kehadiran'] == 1) ? 'selected' : '' ?>>Hadir</option>
              <option value="3" <?= ($activity['kehadiran'] == 3) ? 'selected' : '' ?>>Ganti Hari</option>
              <option value="4" <?= ($activity['kehadiran'] == 4) ? 'selected' : '' ?>>Ijin</option>
              <option value="5" <?= ($activity['kehadiran'] == 5) ? 'selected' : '' ?>>Sakit</option>
              <option value="6" <?= ($activity['kehadiran'] == 6) ? 'selected' : '' ?>>Cuti</option>
              <option value="7" <?= ($activity['kehadiran'] == 7) ? 'selected' : '' ?>>Shift Malam</option>
            </select>
          </div>
        </div>
        
        <!-- Dropdown Keterangan -->
        <div class="form-group row d-none" id="status-group">
          <label for="status" class="col-sm-3 col-form-label">
            Posisi <span style="color: red;">*</span>
          </label>
          <div class="col-sm-9">
          <select name="status" id="status" class="custom-select2 form-control" style="width: 100%; height: 38px;">
              <option value="">Pilih Status</option>
  
              <option value="BSU" <?= ($activity['keterangan'] == "BSU") ? 'selected' : '' ?>>BSU</option>
              <option value="Calibration Room" <?= ($activity['keterangan'] == "Calibration Room") ? 'selected' : '' ?>>Calibration Room</option>
              <option value="Genba" <?= ($activity['keterangan'] == "Genba") ? 'selected' : '' ?>>Genba</option>
              <option value="Dojo Center" <?= ($activity['keterangan'] == "Dojo Center") ? 'selected' : '' ?>>Dojo Center</option>
              <option value="Office R&D" <?= ($activity['keterangan'] == "Office R&D") ? 'selected' : '' ?>>Office R&D</option>
              <option value="Office Produksi" <?= ($activity['keterangan'] == "Office Produksi") ? 'selected' : '' ?>>Office Produksi</option>
              <option value="PolyModel Room" <?= ($activity['keterangan'] == "PolyModel Room") ? 'selected' : '' ?>>PolyModel Room</option>
              <option value="Warehouse" <?= ($activity['keterangan'] == "Warehouse") ? 'selected' : '' ?>>Warehouse</option>
              <option value="Line A" <?= ($activity['keterangan'] == "Line A") ? 'selected' : '' ?>>Line A</option>
              <option value="Line B" <?= ($activity['keterangan'] == "Line B") ? 'selected' : '' ?>>Line B</option>
              <option value="Line C" <?= ($activity['keterangan'] == "Line C") ? 'selected' : '' ?>>Line C</option>
              <option value="Line D" <?= ($activity['keterangan'] == "Line D") ? 'selected' : '' ?>>Line D</option>
              <option value="Line E" <?= ($activity['keterangan'] == "Line E") ? 'selected' : '' ?>>Line E</option>
              <option value="Line F" <?= ($activity['keterangan'] == "Line F") ? 'selected' : '' ?>>Line F</option>
              <option value="Line G" <?= ($activity['keterangan'] == "Line G") ? 'selected' : '' ?>>Line G</option>
              <option value="Line H" <?= ($activity['keterangan'] == "Line H") ? 'selected' : '' ?>>Line H</option>
              <option value="Line SP" <?= ($activity['keterangan'] == "Line SP") ? 'selected' : '' ?>>Line SP</option>
              <option value="WSS ADM" <?= ($activity['keterangan'] == "WSS ADM") ? 'selected' : '' ?>>WSS ADM</option>
              <option value="WSS HMMI" <?= ($activity['keterangan'] == "WSS HMMI") ? 'selected' : '' ?>>WSS HMMI</option>
              <option value="WSS MKM/MMKI" <?= ($activity['keterangan'] == "WSS MKM/MMKI") ? 'selected' : '' ?>>WSS MKM/MMKI</option>
              <option value="WSS & S/A HMMI" <?= ($activity['keterangan'] == "WSS & S/A HMMI") ? 'selected' : '' ?>>WSS & S/A HMMI</option>
              <option value="CO2 ROBOT ADM" <?= ($activity['keterangan'] == "CO2 ROBOT ADM") ? 'selected' : '' ?>>CO2 ROBOT ADM</option>
              <option value="S/A MANUAL ADM" <?= ($activity['keterangan'] == "S/A MANUAL ADM") ? 'selected' : '' ?>>S/A MANUAL ADM</option>
              <option value="S/A ROBOT ADM" <?= ($activity['keterangan'] == "S/A ROBOT ADM") ? 'selected' : '' ?>>S/A ROBOT ADM</option>
              <option value="Asakai Room" <?= ($activity['keterangan'] == "Asakai Room") ? 'selected' : '' ?>>Asakai Room</option>
              <option value="Meeting Room 1" <?= ($activity['keterangan'] == "Meeting Room 1") ? 'selected' : '' ?>>Meeting Room 1</option>
              <option value="Meeting Room 2" <?= ($activity['keterangan'] == "Meeting Room 2") ? 'selected' : '' ?>>Meeting Room 2</option>
              <option value="Meeting Room 3" <?= ($activity['keterangan'] == "Meeting Room 3") ? 'selected' : '' ?>>Meeting Room 3</option>
              <option value="Meeting Room 4" <?= ($activity['keterangan'] == "Meeting Room 4") ? 'selected' : '' ?>>Meeting Room 4</option>
              <option value="Meeting Room 5" <?= ($activity['keterangan'] == "Meeting Room 5") ? 'selected' : '' ?>>Meeting Room 5</option>
              <option value="Meeting Room 6" <?= ($activity['keterangan'] == "Meeting Room 6") ? 'selected' : '' ?>>Meeting Room 6</option>
              <option value="Meeting Room 7" <?= ($activity['keterangan'] == "Meeting Room 7") ? 'selected' : '' ?>>Meeting Room 7</option>
              <option value="Meeting Room 8" <?= ($activity['keterangan'] == "Meeting Room 8") ? 'selected' : '' ?>>Meeting Room 8</option>
              <option value="Meeting Room 9" <?= ($activity['keterangan'] == "Meeting Room 9") ? 'selected' : '' ?>>Meeting Room 9</option>
              <option value="Meeting Room 10" <?= ($activity['keterangan'] == "Meeting Room 10") ? 'selected' : '' ?>>Meeting Room 10</option>
              <option value="Meeting Room 11" <?= ($activity['keterangan'] == "Meeting Room 11") ? 'selected' : '' ?>>Meeting Room 11</option>
              <option value="Meeting Room VIP" <?= ($activity['keterangan'] == "Meeting Room VIP") ? 'selected' : '' ?>>Meeting Room VIP</option>
            </select>
          </div>
        </div>

        <!-- Tombol Action -->
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

<script>
function toggleStatusDropdown() {
  var kehadiran = document.getElementById('kehadiran').value;
  var statusGroup = document.getElementById('status-group');
  var statusSelect = document.getElementById('status');

  if (kehadiran === "1") {
    statusGroup.classList.remove('d-none');
  } else {
    statusGroup.classList.add('d-none');
    statusSelect.value = "";
  }
}

document.addEventListener("DOMContentLoaded", function() {
  toggleStatusDropdown();
});
</script>

<?= $this->endSection() ?>
