<?= $this->extend('layout/template') ?>
<?= $this->section('content') ?>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"></script>

<div class="pd-ltr-20 xs-pd-20-10">
  <div class="min-height-200px">
    <!-- Header -->
    <div class="page-header d-flex justify-content-between align-items-center mb-3">
      <h4>Data Standard Die Design</h4>
    </div>

    <div class="card-box mb-30">
      <div class="pd-20">
        <h4 class="text-blue h4">Data Standard Die Design</h4>
        <p class="mb-0">Menampilkan die_length, die_width, dan die_height berdasarkan kriteria.</p>
      </div>
      <a href="<?= site_url('pps/create') ?>" class="btn btn-primary btn-sm ml-3 mb-3">
        Tambah
      </a>
      <ul class="nav nav-tabs" id="dieDesignTab" role="tablist">
        <li class="nav-item" role="presentation">
          <a class="nav-link active" id="table-tab" data-bs-toggle="tab" href="#table" role="tab" aria-controls="table" aria-selected="true">Tabel Data</a>
        </li>
        <li class="nav-item" role="presentation">
          <a class="nav-link" id="pdf-tab" data-bs-toggle="tab" href="#pdf" role="tab" aria-controls="pdf" aria-selected="false">PDF</a>
        </li>
      </ul>
      
      <div class="table-responsive mt-3">
        <div class="tab-content" id="dieDesignTabContent">
          <div class="tab-pane fade show active" id="table" role="tabpanel" aria-labelledby="table-tab">
            <table class="data-table table stripe hover nowrap">
              <thead>
                <tr>
                  <th>Category</th>
                  <th>Jenis</th>
                  <th>Proses</th>
                  <th>Die Length</th>
                  <th>Die Width</th>
                </tr>
              </thead>
              <tbody>
                <?php if (!empty($design) && is_array($design)): ?>
                  <?php foreach ($design as $row): ?>
                    <tr>
                      <td><?= esc($row['category']) ?></td>
                      <td><?= esc($row['jenis_proses']) ?></td>
                      <td><?= esc($row['proses']) ?></td>
                      <td><?= esc($row['die_length']) ?></td>
                      <td><?= esc($row['die_width']) ?></td>
                    </tr>
                  <?php endforeach; ?>
                <?php else: ?>
                  <tr>
                    <td colspan="5" class="text-center">No data found.</td>
                  </tr>
                <?php endif; ?>
              </tbody>
            </table>
          </div>
          
          <div class="tab-pane fade" id="pdf" role="tabpanel" aria-labelledby="pdf-tab">
            <div class="mt-3">
              <iframe src="<?= base_url('assets/file/standar_die_design.pdf') ?>" 
                      width="100%" 
                      height="1000" 
                      style="border: none;">
              </iframe>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>

<?= $this->endSection() ?>
