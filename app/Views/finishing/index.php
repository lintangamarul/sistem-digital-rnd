<?= $this->extend('layout/template') ?>

<?= $this->section('content') ?>
<!-- Include stylesheet untuk DataTables jika belum ada di template -->
<link rel="stylesheet" type="text/css" href="<?= base_url('assets/vendors/styles/icon-font.min.css') ?>">
<link rel="stylesheet" type="text/css" href="<?= base_url('assets/plugins/datatables/css/dataTables.bootstrap4.min.css') ?>">
<link rel="stylesheet" type="text/css" href="<?= base_url('assets/plugins/datatables/css/responsive.bootstrap4.min.css') ?>">

<div class="pd-ltr-20 xs-pd-20-10">
  <div class="min-height-200px">
    <!-- Page Header -->
    <div class="page-header d-flex justify-content-between align-items-center mb-3">
      <div class="col-md-6 col-sm-12">
        <div class="title">
          <h4>Daftar Finishing</h4>
        </div>
        <nav aria-label="breadcrumb" role="navigation">
          <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="<?= site_url('home'); ?>">Home</a></li>
            <li class="breadcrumb-item active" aria-current="page">Finishing</li>
          </ol>
        </nav>
      </div>
      <div class="col-md-6 col-sm-12 text-right">
        <a href="<?= site_url('finishing/create') ?>" class="btn btn-primary">Tambah Data</a>
      </div>
    </div>
    <!-- End Page Header -->

    <div class="card-box mb-30">
      <?php if(session()->has('success')): ?>
        <div class="alert alert-success" role="alert"><?= session('success') ?></div>
      <?php endif; ?>

      <div class="pd-20">
        <h4 class="text-blue h4">Data Finishing</h4>
      </div>
      <div class="pb-20">
        <table class="data-table table stripe hover nowrap">
          <thead>
            <tr>
              <th>No</th>
              <th>Part List</th>
              <th>Material</th>
              <th>Diameter</th>
              <th>Class</th>
              <th>Qty</th>
              <th>Remarks</th>
              <th>Process</th>
              <th>Aksi</th>
            </tr>
          </thead>
          <tbody>
            <?php if(!empty($finishing)) : ?>
              <?php $no = 1; foreach ($finishing as $row) : ?>
                <tr>
                  <td><?= $no++ ?></td>
                  <td><?= $row['part_list'] ?></td>
                  <td><?= $row['material'] ?></td>
                  <td><?= $row['diameter'] ?></td>
                  <td><?= $row['class'] ?></td>
                  <td><?= $row['qty'] ?></td>
                  <td><?= $row['remarks'] ?></td>
                  <td><?= $row['process'] ?></td>
                  <td>
                    <a href="<?= site_url('finishing/edit/' . $row['id']) ?>" class="btn btn-sm btn-warning">Edit</a>

                    <form id="form-<?= $row['id'] ?>" action="<?= site_url('finishing/delete/' . $row['id']) ?>" method="post" style="display:inline;">
                      <?= csrf_field() ?>
                      <button type="button" class="btn btn-sm btn-danger" onclick="confirmDelete(<?= $row['id'] ?>)">Hapus</button>
                    </form>
                  </td>

                </tr>
              <?php endforeach; ?>
            <?php else: ?>
              <tr>
                <td colspan="9" class="text-center">Data tidak ditemukan</td>
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
