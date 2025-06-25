<?= $this->extend('layout/template') ?>
<?= $this->section('content') ?>

<div class="pd-ltr-20 xs-pd-20-10">
  <div class="min-height-200px">
    <!-- Page Header -->
    <!-- <div class="page-header d-flex justify-content-between align-items-center mb-3">
      <h4>Outdoor Activity</h4>
      <a href="<?= site_url('outdoor-activity/create'); ?>" class="btn btn-primary">Tambah Activity</a>
    </div> -->

    <!-- Card Box for the Outdoor Activity Table -->
    <div class="card-box mb-30">
      <div class="pd-20">
        <h4 class="text-blue h4">Daftar Outdoor Activity</h4>
        <p class="mb-0">Data aktivitas outdoor untuk pencatatan kehadiran, cuti, genba, dan night shift.</p>
        
      </div>
      <div class="pb-20">
        <?php if (session()->getFlashdata('success')): ?>
          <div class="alert alert-success"><?= session()->getFlashdata('success'); ?></div>
        <?php endif; ?>
        <?php if (session()->getFlashdata('error')): ?>
          <div class="alert alert-danger"><?= session()->getFlashdata('error'); ?></div>
        <?php endif; ?>

        <table class="data-table table stripe hover nowrap">
          <thead>
            <tr>
              <th>No</th>
              <th>Nama-NIK</th>
              <th>Group</th>
              <th>Kehadiran</th>
              <th>Cuti</th>
              <th>Genba</th>
              <th>Night Shift</th>
              <th>Aksi</th>
            </tr>
          </thead>
          <tbody>
            <?php if (!empty($activities)): ?>
              <?php $i = 1; ?>
              <?php foreach ($activities as $act): ?>
                <tr>
                  <td><?= $i++; ?></td>
                  <td><?= $act['nama'] . ' - ' . $act['nik'] ?></td>
                  <td><?= $act['group'] ?></td>
                  <td>
                    <?php if($act['kehadiran']): ?>
                      <span class="badge badge-success">On</span>
                    <?php else: ?>
                      <span class="badge badge-danger">Off</span>
                    <?php endif; ?>
                  </td>
                  <td>
                    <?php if($act['cuti']): ?>
                      <span class="badge badge-success">On</span>
                    <?php else: ?>
                      <span class="badge badge-danger">Off</span>
                    <?php endif; ?>
                  </td>
                  <td>
                    <?php if($act['genba']): ?>
                      <span class="badge badge-success">On</span>
                    <?php else: ?>
                      <span class="badge badge-danger">Off</span>
                    <?php endif; ?>
                  </td>
                  <td>
                    <?php if($act['night_shift']): ?>
                      <span class="badge badge-success">On</span>
                    <?php else: ?>
                      <span class="badge badge-danger">Off</span>
                    <?php endif; ?>
                  </td>
                  <td>
                    <?php if (!empty($act['activity_id'])): ?>
                        <a href="<?= site_url('outdoor-activity/edit/' . $act['activity_id']); ?>" class="btn btn-sm btn-warning">Edit</a>
                        <a href="#" class="btn btn-sm btn-danger" onclick="swalDelete('<?= site_url('outdoor-activity/delete/' . $act['activity_id']); ?>')">Hapus</a>
                    <?php else: ?>
                        -  On	Ruangan R&D	
                        2	ARI KUSNADI	1	
                    <?php endif; ?>
                </td>

                </tr>
              <?php endforeach; ?>
            <?php else: ?>
              <tr>
                <td colspan="8" class="text-center">Data tidak ditemukan</td>
              </tr>
            <?php endif; ?>
          </tbody>
        </table>
      </div>
    </div>
  </div>
</div>
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
