<?= $this->extend('layout/template') ?>

<?= $this->section('content') ?>
<link rel="stylesheet" type="text/css" href="<?= base_url('assets/vendors/styles/icon-font.min.css') ?>">
<link rel="stylesheet" type="text/css" href="<?= base_url('assets/plugins/datatables/css/dataTables.bootstrap4.min.css') ?>">
<link rel="stylesheet" type="text/css" href="<?= base_url('assets/plugins/datatables/css/responsive.bootstrap4.min.css') ?>">
<div class="pd-ltr-20 xs-pd-20-10">
    <div class="min-height-200px">
        <div class="page-header d-flex justify-content-between align-items-center mb-3">
            <h4>Master Data Lead Time</h4>
            <a href="<?= site_url('leadtime/create') ?>" class="btn btn-primary">Tambah Data</a>
        </div>
        <div class="card-box mb-30">
            <div class="pd-20">
                <h4 class="text-blue h4">Daftar Lead Time</h4>
                <p class="mb-0"></p>
            </div>
            <div class="pb-20">      
                <table class="data-table table stripe hover nowrap">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Category</th>
                            <th>Process</th>
                            <th>Class</th>
                            <th>Hour</th>
                            <th>Week</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if(!empty($leadtimes)) : ?>
                            <?php foreach ($leadtimes as $row) : ?>
                                <tr>
                                    <td><?= $row['id'] ?></td>
                                    <td><?= $row['category'] ?></td>
                                    <td><?= $row['process'] ?></td>
                                    <td><?= $row['class'] ?></td>
                                    <td><?= $row['hour'] ?></td>
                                    <td><?= $row['week'] ?></td>
                                    <td>
                                        <a href="<?= site_url('leadtime/edit/' . $row['id']) ?>" class="btn btn-sm btn-warning">Edit</a>
                                        <form id="form-<?= $row['id'] ?>" action="<?= site_url('leadtime/delete/' . $row['id']) ?>" method="post" style="display:inline;">
                                            <?= csrf_field() ?>
                                            <button type="button" class="btn btn-sm btn-danger" onclick="confirmDelete(<?= $row['id'] ?>)">Hapus</button>
                                        </form>
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
  function confirmDelete(id) {
    Swal.fire({
      title: 'Yakin ingin menghapus?',
      text: "Data tidak bisa dikembalikan!",
      icon: 'warning',
      showCancelButton: true,
      confirmButtonColor: '#d33',
      cancelButtonColor: '#6c757d',
      confirmButtonText: 'Ya, hapus!',
      cancelButtonText: 'Batal'
    }).then((result) => {
      if (result.isConfirmed) {
        document.getElementById('form-' + id).submit();
      }
    })
  }
</script>
<?= $this->endSection() ?>
