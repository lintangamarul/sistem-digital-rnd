<?= $this->extend('layout/template') ?>
<?= $this->section('content') ?>

<div class="pd-ltr-20 xs-pd-20-10">
  <div class="min-height-200px">
    <!-- Header -->
    <div class="page-header d-flex justify-content-between align-items-center mb-3">
      <h4>Daftar PPS</h4>
    </div>

    <div class="card-box mb-30">
      <div class="pd-20">
        <h4 class="text-blue h4">Daftar DCP</h4>
        <p class="mb-0">DCP</p>
      </div>
      
      <!-- Table Responsive -->
      <div class="table-responsive">
        <table class="data-table table stripe hover nowrap">
          <thead>
            <tr>
              <th>No</th>
              <th>Cust</th>
              <th>Model</th>
              <th>Part No</th>
              <th>Part Name</th>
              <th>Aksi</th>
            </tr>
          </thead>
          <tbody>
            <?php if (empty($pps)): ?>
              <tr>
                <td colspan="6" class="text-center">Tidak ada data.</td>
              </tr>
            <?php else: ?>
              <?php foreach ($pps as $index => $row): ?>
                <tr>
                  <td><?= $index + 1 ?></td>
                  <td><?= esc($row['cust']) ?></td>
                  <td><?= esc($row['model']) ?></td>
                  <td><?= esc($row['part_no']) ?></td>
                  <td><?= esc($row['part_name']) ?></td>
                  <td>
                    <a href="<?= site_url('pps/detail/' . $row['id']) ?>" class="btn btn-primary btn-sm">
                      Detail
                    </a>
                    <a href="<?= site_url('pps/edit/' . $row['id']) ?>" class="btn btn-warning btn-sm">
                      Detail
                    </a>
                    
                  </td>
                </tr>
              <?php endforeach; ?>
            <?php endif; ?>
          </tbody>
        </table>
      </div>
    </div>
  </div>
</div>

<?= $this->endSection() ?>
