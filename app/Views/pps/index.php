<?= $this->extend('layout/template') ?>
<?= $this->section('content') ?>

<div class="pd-ltr-20 xs-pd-20-10">
  <div class="min-height-200px">
    <div class="page-header d-flex justify-content-between align-items-center mb-3">
      <h4>Daftar PPS</h4>
    </div>

    <div class="card-box mb-30">
      <div class="pd-20">
        <h4 class="text-blue h4">Daftar PPS</h4>
        User guide bisa  
        <a href="<?= base_url('uploads/template/UserGuidePPSDCP.pdf'); ?>" download>download di sini</a>
        <li>Sistem akan mengelompokkan data yang tampil bedasarkan Part Number yang pernah dibuat</li>
        <li>Setiap edit data akan menghasilkan dokumen revisi baru</li>
      </div>

      <?php if (has_permission(38)): ?>
        <a href="<?= site_url('pps/create') ?>" class="btn btn-primary btn-sm ml-3 mb-3">
          Tambah
        </a>
      <?php endif; ?>

      <?php if (session()->getFlashdata('success')): ?>
        <div class="alert alert-success alert-dismissible fade show" role="alert">
          <?= session()->getFlashdata('success') ?>
          <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
      <?php endif; ?>

      <div class="table-responsive">
        <table id="pps-table" class="data-table table stripe hover nowrap">
          <thead>
            <tr>
              <th>No</th>
              <th>Part No</th>
              <th>Part Name</th>
              <th>Model</th>
              <th>Aksi</th>
            </tr>
          </thead>
          <tbody>
            <?php $no = 1; foreach ($groupedPps as $partNo => $items): ?>
              <?php 
                usort($items, fn($a, $b) => $b['id'] <=> $a['id']);
                $latest = $items[0];
              ?>
              <tr class="main-row" data-items='<?= json_encode($items) ?>'>
                <td><?= $no++ ?></td>
                <td><?= esc($partNo) ?></td>
                <td><?= esc($latest['part_name']) ?></td>
                <td><?= esc($latest['model']) ?></td>
                <td>
                  <a href="<?= base_url('pps/edit/' . $latest['id']) ?>" class="btn btn-sm btn-warning">Edit</a>
                  <a href="<?= base_url('pps/editNew/' . $latest['id']) ?>" class="btn btn-sm btn-secondary">Simpan sebagai Part Baru</a>
                  <a href="<?= base_url('pps/generate/' . $latest['id']) ?>" class="btn btn-sm btn-success">Excel</a>
                  <a href="<?= base_url('pps/list-process-dies/' . $latest['id']) ?>" class="btn btn-sm btn-primary">DCP</a>
                  <a href="<?= site_url('pps/logAktivitas?part_no=' . urlencode($partNo)); ?>" class="btn btn-sm btn-info">Log Aktivitas</a>



                  <?php if ($latest['status'] == 0): ?>
                    <a href="<?= base_url('pps/rollback/' . $latest['id']) ?>" class="btn btn-sm btn-light btn-rollback">Rollback</a>
                  <?php endif; ?>
                </td>
              </tr>
            <?php endforeach; ?>
          </tbody>
        </table>
      </div>
    </div>
  </div>
</div>

<script>
const BASE_URL = "<?= base_url() ?>";

$(document).ready(function () {
});

$(document).on('click', '.btn-rollback', function (e) {
  e.preventDefault();
  var url = $(this).attr('href');

  Swal.fire({
    title: 'Yakin rollback data ini?',
    text: "Data akan dikembalikan seperti semula.",
    icon: 'question',
    showCancelButton: true,
    confirmButtonColor: '#28a745',
    cancelButtonColor: '#3085d6',
    confirmButtonText: 'Ya, Rollback!',
    cancelButtonText: 'Batal'
  }).then((result) => {
    if (result.isConfirmed) {
      window.location.href = url;
    }
  });
});
</script>

<?= $this->endSection() ?>
