<?= $this->extend('layout/template') ?>
<?= $this->section('content') ?>

<div class="pd-ltr-20 xs-pd-20-10">
  <div class="min-height-200px">
    <div class="page-header d-flex justify-content-between align-items-center mb-3">
      <h4>Daftar Izin</h4>
      <?php if (has_permission(32)): ?>
            <a href="<?= site_url('izin/create'); ?>" class="btn btn-primary">Tambah Izin</a>
      <?php endif; ?>
    </div>
    <div class="card-box mb-30">
      <div class="pd-20">
        <h4 class="text-blue h4">Daftar Izin</h4>
        <p class="mb-0">Izin akan digunakan untuk update Status Pengisian agar tidak dianggap belum mengumpulkan LKH</p>
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
              <th>Tanggal Izin</th>
              <th>Keterangan</th>
              <?php if (has_permission(30)): ?>
              <th>Aksi</th>
              <?php endif; ?>
            </tr>
          </thead>
          <tbody>
            <?php if (!empty($izins)): ?>
                <?php $i = 1; ?>
              <?php foreach ($izins as $izin): ?>
                <tr>
                  <td><?= $i++; ?></td>
                  <td><?= date('d M Y', strtotime($izin['dates'])); ?></td>
                  <?php
                  switch ($izin['status']) {
                      case 3:
                          $statusText = "Ganti Hari";
                          break;
                      case 4:
                          $statusText = "Ijin";
                          break;
                      case 5:
                          $statusText = "Sakit";
                          break;
                      case 6:
                          $statusText = "Cuti";
                          break;
                      default:
                          $statusText = "Unknown";
                          break;
                  }
                  ?>
                  <td><?= esc($statusText); ?></td>
                  <?php if (has_permission(33)): ?>
                  <td>
                    <a href="#" class="btn btn-sm btn-danger" onclick="swalDelete('<?= site_url('izin/delete/' . $izin['id']); ?>')">Delete</a>
                  </td>
                  <?php endif; ?>
                </tr>
              <?php endforeach; ?>
            <?php else: ?>
              <tr>
                <td colspan="4" class="text-center">Tidak Ada Izin Tercatat</td>
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
