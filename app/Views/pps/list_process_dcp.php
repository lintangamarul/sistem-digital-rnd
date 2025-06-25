<?= $this->extend('layout/template') ?>
<?= $this->section('content') ?>

<div class="pd-ltr-20 xs-pd-20-10">
  <div class="min-height-200px">
    <!-- Header -->
    <div class="page-header d-flex justify-content-between align-items-center mb-3">
      <h4>List Process DCP</h4>
      <span>Part No: <?= esc($pps['part_no']) ?></span>
    </div>

    <!-- Alert Messages -->
    <?php if (session()->getFlashdata('success')): ?>
      <div class="alert alert-success alert-dismissible fade show" role="alert">
        <?= session()->getFlashdata('success') ?>
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
    <?php endif; ?>

    <?php if (session()->getFlashdata('error')): ?>
      <div class="alert alert-danger alert-dismissible fade show" role="alert">
        <?= session()->getFlashdata('error') ?>
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
    <?php endif; ?>

    <!-- Existing DCP with Same Class -->
    <?php if (!empty($existingDcpSameClass)): ?>
    <div class="card-box mb-30">
      <div class="pd-20">
        <h4 class="text-success h4">DCP dari revisi PPS sebelumnya dengan Part NO & Class yg sama ditemukan </h4>
        <p class="mb-0">Anda sepertinya telah melakukan pembuatan DCP di PPS versi sebelumnya. Silahkan tarik DCP yang pernah dibuat apabila class dan proses sama, sehingga anda tidak perlu membuat DCP dari awal</p>
      </div>
      
      <div class="table-responsive">
      <table class="table stripe hover nowrap">
        <thead class="table-success">
          <tr>
            <th>No</th>
            <th>Source Model</th>
            <th>Customer</th>
            <th>Process</th>
            <th>Proses</th>
            <th>Class</th>
            <th>Aksi</th>
          </tr>
        </thead>
        <tbody>
          <?php foreach ($existingDcpSameClass as $i => $dcpItem): ?>
            <tr>
              <td><?= $i + 1 ?></td>
              <td><?= esc($dcpItem['pps_model']) ?></td>
              <td><?= esc($dcpItem['pps_cust']) ?></td>
              <td><?= esc($dcpItem['die_process']) ?></td>
              <td><?= esc($dcpItem['die_proses']) ?></td>
              <td><?= esc($dcpItem['die_class']) ?></td>
              <td>
                <?php 
                $matchingDies = [];
                foreach ($dies as $die) {
                    if ($die['class'] == $dcpItem['die_class'] && 
                        $die['process'] == $dcpItem['die_process']) {
                        
                        $dcpExists = false;
                        foreach ($dcp as $existingDcp) {
                            if ($existingDcp['id_pps_dies'] == $die['id']) {
                                $dcpExists = true;
                                break;
                            }
                        }
                        
                        if (!$dcpExists) {
                            $matchingDies[] = $die;
                        }
                    }
                }
                ?>
                
                <?php if (!empty($matchingDies)): ?>
                  <div class="dropdown">
                    <button class="btn btn-success btn-sm dropdown-toggle" type="button" data-toggle="dropdown">
                      Tarik
                    </button>
                    <div class="dropdown-menu">
                      <?php foreach ($matchingDies as $targetDie): ?>
                        <form method="post" action="<?= site_url('dcp/convert') ?>" class="d-inline">
                          <input type="hidden" name="source_dcp_id" value="<?= $dcpItem['id'] ?>">
                          <input type="hidden" name="target_die_id" value="<?= $targetDie['id'] ?>">
                          <button type="button" class="dropdown-item btn-pull" 
                                  data-process="<?= esc($targetDie['process']) ?>" 
                                  data-proses="<?= esc($targetDie['proses']) ?>">
                            ke <?= esc($targetDie['process']) ?> - <?= esc($targetDie['proses']) ?>
                          </button>
                        </form>
                      <?php endforeach; ?>
                    </div>
                  </div>
                <?php else: ?>
                  <span class="text-muted">No matching target available</span>
                <?php endif; ?>
              </td>
            </tr>
          <?php endforeach; ?>
        </tbody>
      </table>
      </div>
    </div>
    <?php endif; ?>

    <!-- Existing DCP with Different Class -->
    <?php if (!empty($existingDcpDifferentClass)): ?>
      <h5 class="mt-4">Available DCP from Different Class (Same Process)</h5>
<div class="alert alert-info">
  <small>DCP berikut memiliki process yang sama tetapi class berbeda. Konversi mungkin memerlukan penyesuaian.</small>
</div>
<table class="table stripe hover nowrap">
  <thead class="table-warning">
    <tr>
      <th>No</th>
      <th>Source Model</th>
      <th>Customer</th>
      <th>Process</th>
      <th>Proses</th>
      <th>Class</th>
      <th>Aksi</th>
    </tr>
  </thead>
  <tbody>
    <?php foreach ($existingDcpDifferentClass as $i => $dcpItem): ?>
      <tr>
        <td><?= $i + 1 ?></td>
        <td><?= esc($dcpItem['pps_model']) ?></td>
        <td><?= esc($dcpItem['pps_cust']) ?></td>
        <td><?= esc($dcpItem['die_process']) ?></td>
        <td><?= esc($dcpItem['die_proses']) ?></td>
        <td><?= esc($dcpItem['die_class']) ?></td>
        <td>
          <?php 
          $matchingDies = [];
          foreach ($dies as $die) {
              // Untuk different class, hanya cek process yang sama
              if ($die['process'] == $dcpItem['die_process']) {
                  
                  // Check if DCP already exists for this die
                  $dcpExists = false;
                  foreach ($dcp as $existingDcp) {
                      if ($existingDcp['id_pps_dies'] == $die['id']) {
                          $dcpExists = true;
                          break;
                      }
                  }
                  
                  if (!$dcpExists) {
                      $matchingDies[] = $die;
                  }
              }
          }
          ?>
          
          <?php if (!empty($matchingDies)): ?>
            <div class="dropdown">
              <button class="btn btn-warning btn-sm dropdown-toggle" type="button" data-toggle="dropdown">
                Convert (Different Class)
              </button>
              <div class="dropdown-menu">
                <?php foreach ($matchingDies as $targetDie): ?>
                  <form method="post" action="<?= site_url('dcp/convert') ?>" class="d-inline">
                    <input type="hidden" name="source_dcp_id" value="<?= $dcpItem['id'] ?>">
                    <input type="hidden" name="target_die_id" value="<?= $targetDie['id'] ?>">
                    <button type="submit" class="dropdown-item" onclick="return confirm('PERHATIAN: Class berbeda (<?= esc($dcpItem['die_class']) ?> → <?= esc($targetDie['class']) ?>). Yakin ingin mengkonversi DCP ke <?= esc($targetDie['process']) ?> - <?= esc($targetDie['proses']) ?>?')">
                      ke <?= esc($targetDie['process']) ?> - <?= esc($targetDie['proses']) ?> (Class: <?= esc($targetDie['class']) ?>)
                    </button>
                  </form>
                <?php endforeach; ?>
              </div>
            </div>
          <?php else: ?>
            <span class="text-muted">No matching target available</span>
          <?php endif; ?>
        </td>
      </tr>
    <?php endforeach; ?>
  </tbody>
</table>
    <?php endif; ?>

    <!-- Main DCP List -->
    <div class="card-box mb-30">
      <div class="pd-20">
        <h4 class="text-blue h4">List Process DCP</h4>
        <p class="mb-0">Berikut adalah daftar process DCP berdasarkan data PPS Dies</p>
      </div>
        <a href="<?= site_url('dcp-excel/'.$id) ?>" class="btn btn-primary btn-sm ml-3 mb-2">
        Generate Excel
      </a>

      <div class="table-responsive">
        <table class="data-table table stripe hover nowrap">
          <thead>
            <tr>
              <th>No</th>
              <th>Process</th>
              <th>Proses</th>
              <th>Class</th>
              <th>Aksi</th>
            </tr>
          </thead>
          <tbody>
            <?php if (!empty($dies) && is_array($dies)): ?>
              <?php foreach ($dies as $i => $row): ?>
                <?php 
                  $found = null;
                  if (!empty($dcp) && is_array($dcp)) {
                      foreach ($dcp as $d) {
                          if ($d['id_pps_dies'] == $row['id']) {
                              $found = $d;
                              break;
                          }
                      }
                  }
                ?>
                <tr>
                  <td><?= $i + 1 ?></td>
                  <td>
                    <?= esc($row['process']) ?>
                    <?php if (!empty($row['process_join'])): ?>
                        + <?= esc($row['process_join']) ?>
                    <?php endif; ?>
                  </td>
                  <td><?= esc($row['proses']) ?></td>
                  <td><?= esc($row['class'] ?? '-') ?></td>
                  <td>
                    <?php if ($found === null): ?>
                      <a href="<?= site_url('dcp/create/' . $row['id']) ?>" class="btn btn-success btn-sm">Create</a>
                    <?php else: ?>
                      <a href="<?= site_url('dcp/edit/' . $found['id']) ?>" class="btn btn-warning btn-sm">Edit</a>
                    <?php endif; ?>
                  </td>
                </tr>
              <?php endforeach; ?>
            <?php else: ?>
              <tr>
                <td colspan="5" class="text-center">Data tidak ditemukan.</td>
              </tr>
            <?php endif; ?>
          </tbody>
        </table>
      </div>
    </div>
  </div>
</div>
<script>
  $(document).on('click', '.btn-pull', function(e) {
    e.preventDefault();
    const btn = $(this);
    const process = btn.data('process');
    const proses = btn.data('proses');
    Swal.fire({
      title: 'Yakin ingin menarik data ke DCP versi PPS ini?',
      icon: 'question',
      showCancelButton: true,
      confirmButtonText: 'Ya',
      cancelButtonText: 'Batal'
    }).then((result) => {
      if (result.isConfirmed) {
        btn.closest('form').submit();
      }
    });
  });
</script>
<?= $this->endSection() ?>
