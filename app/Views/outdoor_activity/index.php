<?= $this->extend('layout/template') ?>
<?= $this->section('content') ?>



<div class="pd-ltr-20 xs-pd-20-10">
  <div class="min-height-200px">
    <div class="card-box mb-30">
      <div class="pd-20">
        <h4 class="text-blue h4">Daftar Outdoor Activity</h4>
        <p class="mb-0">Data aktivitas outdoor untuk pencatatan kehadiran, keterangan, dan lainnya.</p>
        <div class="pd-20">
          <?php
              // Menghitung total record, hadir, dan tidak hadir
              $totalRecords    = 0;
              $hadirCount      = 0;
              $tidakHadirCount = 0;

              foreach ($statusCounts as $sc) {
                  $totalRecords += $sc['total'];
                  if ($sc['kehadiran'] == 1) {
                      $hadirCount += $sc['total'];
                  } elseif (in_array($sc['kehadiran'], [3, 4, 5, 6, 7])) {
                      $tidakHadirCount += $sc['total'];
                  }
              }

              $percentageHadir     = $totalRecords > 0 ? round(($hadirCount / $totalRecords) * 100, 2) : 0;
              $percentageTidakHadir = $totalRecords > 0 ? round(($tidakHadirCount / $totalRecords) * 100, 2) : 0;
          ?>
        </div>
        <ul class="list-inline">
          <?php 
            foreach ($statusMapping as $code => $text):
                $count = 0;
                foreach ($statusCounts as $sc) {
                    if ($sc['kehadiran'] == $code) {
                        $count = $sc['total'];
                        break;
                    }
                }
                
                if ($code == 1) {
                    $badgeClass = 'badge-success';
                } elseif (in_array($code, [3,4,5,6])) {
                    $badgeClass = 'badge-danger';
                } elseif ($code == 7) {
                    $badgeClass = 'badge-warning';
                } else {
                    $badgeClass = 'badge-secondary';
                }
          ?>
          <li class="list-inline-item">
              <span class="badge <?= $badgeClass ?>">
                <?= $text ?>
              </span> : <?= $count ?>
          </li>
          <?php endforeach; ?>
        </ul> 
      </div>
      <div class="pb-20 table-scroll-container">
        <?php if (session()->getFlashdata('success')): ?>
          <div class="alert alert-success"><?= session()->getFlashdata('success'); ?></div>
        <?php endif; ?>
        <?php if (session()->getFlashdata('error')): ?>
          <div class="alert alert-danger"><?= session()->getFlashdata('error'); ?></div>
        <?php endif; ?>
        
        <table class="data-table table stripe hover nowrap ">
          <thead>
            <tr>
              <th style="width:5%;">No</th>
              <th style="width:30%;">Nama</th>
              <th style="width:15%;">Group</th>
              <th style="width:20%;">Kehadiran</th>
              <th style="width:15%;">Posisi Keberadaan</th>
              <th style="width:15%;">Aksi</th>
            </tr>
          </thead>
          <tbody class="auto-scroll-table">
            <?php if (!empty($activities)): ?>
              <?php $i = 1; ?>
              <?php foreach ($activities as $act): ?>
                <tr>
                  <td><?= $i++; ?></td>
                  <td><?= $act['nama'] ?></td>
                  <td><?= $act['group'] ?></td>
                  <td>
                    <?php 
                      $status = $act['kehadiran'];
                      if ($status == 1): ?> 
                        <span class="badge badge-success">On</span> 
                    <?php elseif ($status == 3): ?> 
                        <span class="badge badge-danger">GH</span>
                    <?php elseif ($status == 4): ?>
                        <span class="badge badge-danger">I</span>
                    <?php elseif ($status == 5): ?>
                        <span class="badge badge-danger">S</span>
                    <?php elseif ($status == 6): ?>
                        <span class="badge badge-danger">C</span>
                    <?php elseif ($status == 7): ?>
                        <span class="badge badge-warning">Shift Malam</span>
                    <?php else: ?>
                        -
                    <?php endif; ?>
                  </td>
                  <td>
                    <?= !empty($act['keterangan']) ? $act['keterangan'] : '-' ?>
                  </td>
                  <td class="text-center">
                    <?php if (!empty($act['activity_id'])): ?>
                      <a href="<?= site_url('outdoor-activity/edit/' . $act['activity_id']); ?>" class="btn btn-sm btn-primary">Edit</a>
                    <?php else: ?>
                      -
                    <?php endif; ?>
                  </td>
                </tr>
              <?php endforeach; ?>
            <?php else: ?>
              <tr>
                <td colspan="6" class="text-center">Data tidak ditemukan</td>
              </tr>
            <?php endif; ?>
          </tbody>
        </table>
      </div>
    </div>
  </div>
</div>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>


function swalDelete(url) {
  Swal.fire({
    title: 'Apakah Anda yakin?',
    text: "Data ini akan dihapus!",
    icon: 'warning',
    showCancelButton: true,
    confirmButtonColor: '#3085d6',
    cancelButtonColor: '#d33',
    confirmButtonText: 'Ya, hapus!'
  }).then((result) => {
    if (result.isConfirmed) {
      window.location.href = url;
    }
  });
}
</script>

<?= $this->endSection() ?>
