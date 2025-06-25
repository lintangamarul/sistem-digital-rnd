<?= $this->extend('layout/template') ?>

<?= $this->section('content') ?>
<link rel="stylesheet" type="text/css" href="<?= base_url('assets/vendors/styles/icon-font.min.css') ?>">
<link rel="stylesheet" type="text/css" href="<?= base_url('assets/plugins/datatables/css/dataTables.bootstrap4.min.css') ?>">
<link rel="stylesheet" type="text/css" href="<?= base_url('assets/plugins/datatables/css/responsive.bootstrap4.min.css') ?>">

<div class="pd-ltr-20 xs-pd-20-10">
  <div class="min-height-200px">

    <!-- Page Header -->
    <div class="page-header">
      <div class="row">
        <div class="col-md-6 col-sm-12">
          <div class="title">
            <h4>Data JCP Master Leadtime</h4>
          </div>
          <nav aria-label="breadcrumb" role="navigation">
            <ol class="breadcrumb">
              <li class="breadcrumb-item"><a href="<?= site_url('home') ?>">Home</a></li>
              <li class="breadcrumb-item active" aria-current="page">JCP Master Leadtime</li>
            </ol>
          </nav>
        </div>
        <div class="col-md-6 col-sm-12 text-right">
          <a href="<?= site_url('jcp-master-leadtime/create') ?>" class="btn btn-primary">Tambah Data</a>
        </div>
      </div>
    </div>
    <!-- End Page Header -->

    <!-- Table Card -->
    <div class="card-box mb-30">
      <div class="pd-20">
        <h4 class="text-blue h4">Daftar Leadtime</h4>
      </div>
      <div class="pb-20">
        <table class="data-table table stripe hover nowrap">
          <thead>
            <tr>
              <th>No</th>
              <th>Parts</th>
              <th>Class</th>
              <th>Measuring Hour</th>
              <th>Laser</th>
              <th>Big</th>
              <th>Small</th>
              <th>Total Day</th>
              <th>Status</th>
              <th>Aksi</th>
            </tr>
          </thead>
          <tbody>
            <?php $no = 1; foreach ($leadtimes as $row): ?>
              <tr>
                <td><?= $no++ ?></td>
                <td><?= esc($row['parts']) ?></td>
                <td><?= esc($row['class']) ?></td>
                <td><?= esc($row['measuring_hour']) ?></td>
                <td><?= esc($row['hour_machine_laser_cutting']) ?></td>
                <td><?= esc($row['hour_machine_big']) ?></td>
                <td><?= esc($row['hour_machine_small']) ?></td>
                <td><?= esc($row['total_day']) ?></td>
                <td>
                  <?php if ($row['status'] == '1'): ?>
                    <span class="badge badge-success">Aktif</span>
                  <?php else: ?>
                    <span class="badge badge-secondary">Tidak Aktif</span>
                  <?php endif ?>
                </td>
                <td>
                  <a href="<?= site_url('jcp-master-leadtime/edit/' . $row['id']) ?>" class="btn btn-sm btn-warning">Edit</a>
                  <a href="<?= site_url('jcp-master-leadtime/delete/' . $row['id']) ?>" class="btn btn-sm btn-danger" onclick="return confirm('Hapus data?')">Delete</a>
                </td>
              </tr>
            <?php endforeach ?>
          </tbody>
        </table>
      </div>
    </div>

  </div>
</div>


<?= $this->endSection() ?>
