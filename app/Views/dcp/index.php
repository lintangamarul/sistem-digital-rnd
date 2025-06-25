<?= $this->extend('layout/template') ?>
<?= $this->section('content') ?>

<div class="pd-ltr-20 xs-pd-20-10">
  <div class="min-height-200px">
    <!-- Header -->
    <div class="page-header d-flex justify-content-between align-items-center mb-3">
      <h4>List Data DCP</h4>
      <?php if (has_permission(32)): ?>
        <a href="<?= site_url('dcp/create'); ?>" class="btn btn-primary">Tambah DCP</a>
      <?php endif; ?>
    </div>
    <div class="card-box mb-30">
      <div class="pd-20">
        <h4 class="text-blue h4">List Data DCP</h4>
        <p class="mb-0">Data DCP digunakan untuk mengelola informasi terkait die process, dimensi, dan dokumen sketch.</p>
        <!-- <a href="<?= site_url('dcp/create') ?>" class="btn btn-success">Tambah DCP</a> -->
      </div>
      
      <div class="pb-20">
        <?php if (session()->getFlashdata('success')): ?>
          <div class="alert alert-success"><?= session()->getFlashdata('success'); ?></div>
        <?php endif; ?>
        <?php if (session()->getFlashdata('error')): ?>
          <div class="alert alert-danger"><?= session()->getFlashdata('error'); ?></div>
        <?php endif; ?>

        <!-- Tabel List Data DCP -->
        <table class="data-table table stripe hover nowrap">
          <thead>
            <tr>
              <th>No</th>
              <th>Process</th>
              <th>Die Dimension</th>
              <th>Die Weight</th>
              <th>Class</th>
              <!-- <th>Sketch</th> -->
              <th>Aksi</th>
            </tr>
          </thead>
          <tbody>
            <?php if(!empty($dcpList)) : ?>
              <?php foreach($dcpList as $i => $row) : ?>
                <tr>
                  <td><?= $i + 1 ?></td>
                  <td>
                    <?php 
                      $dieProcess = $row['process'];
                      if(!empty($row['process_join'])) {
                        $dieProcess .= ', ' . $row['process_join'];
                      }
                      if(!empty($row['proses'])) {
                        $dieProcess .= ' - ' . $row['proses'];
                      }
                      echo esc($dieProcess);
                    ?>
                  </td>
                  <td>
                    <?php 
                      $dieDimension = $row['die_length'] . ' x ' . $row['die_width'] . ' x ' . $row['die_height'];
                      echo esc($dieDimension);
                    ?>
                  </td>
                  <td><?= esc($row['die_weight']) ?></td>
                  <td><?= esc($row['class']) ?></td>
                  <!-- <td>
                    <?php if(!empty($row['sketch'])): ?>
                      <a href="<?= base_url('uploads/sketch/' . $row['sketch']) ?>" target="_blank">Lihat Sketch</a>
                    <?php else: ?>
                      -
                    <?php endif; ?>
                  </td> -->
                  <td>
                  <?php if (has_permission(43)): ?>
                    <a href="<?= site_url('dcp/edit/' . $row['id']) ?>" class="btn btn-sm btn-primary">Edit</a>
                    <?php endif; ?>
                    <?php if (has_permission(44)): ?>
                    <a href="<?= site_url('dcp/delete/' . $row['id']) ?>" class="btn btn-sm btn-danger" onclick="return confirm('Yakin ingin menghapus data ini?')">Hapus</a>
                    <?php endif; ?>
                  </td>
                </tr>
              <?php endforeach; ?>
            <?php else: ?>
              <tr>
                <td colspan="7" class="text-center">Belum ada data DCP</td>
              </tr>
            <?php endif; ?>
          </tbody>
        </table>

        <!-- Tombol untuk menambah data baru -->
       
      </div>
    </div>
  </div>
</div>

<?= $this->endSection() ?>
