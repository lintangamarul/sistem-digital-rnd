<?= $this->extend('layout/template') ?>
<?= $this->section('content') ?>

<!-- Pastikan Bootstrap JS sudah di-include, bisa menggunakan CDN di layout utama jika belum -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"></script>

<div class="pd-ltr-20 xs-pd-20-10">
  <div class="min-height-200px">
    <!-- Header -->
    <div class="page-header d-flex justify-content-between align-items-center mb-3">
      <h4>Master Data - MC Spec</h4>
      <?php if (has_permission('insert_mc_spec')): ?>
          <a href="<?= site_url('master-pps/create-mc-spec'); ?>" class="btn btn-primary">Tambah Data</a>
      <?php endif; ?>
    </div>

    <div class="card-box mb-30">
      <div class="pd-20">
        <h4 class="text-blue h4">Daftar Data MC Spec</h4>
        <p class="mb-0">Data spesifikasi mesin.</p>
      </div>

      <!-- Nav Tabs -->
      <ul class="nav nav-tabs" id="specMesinTab" role="tablist">
        <li class="nav-item" role="presentation">
          <a class="nav-link active" id="table-tab" data-bs-toggle="tab" href="#table" role="tab" aria-controls="table" aria-selected="true">Tabel Data</a>
        </li>
        <li class="nav-item" role="presentation">
          <a class="nav-link" id="pdf-tab" data-bs-toggle="tab" href="#pdf" role="tab" aria-controls="pdf" aria-selected="false">PDF</a>
        </li>
      </ul>

      <!-- Konten Tab -->
      <div class="table-responsive mt-3">
        <div class="tab-content" id="specMesinTabContent">
          <!-- Tab Tabel Data -->
          <div class="tab-pane fade show active" id="table" role="tabpanel" aria-labelledby="table-tab">
            <table class="data-table table stripe hover nowrap">
                <thead>
                    <tr>
                    <th>Machine</th>
                    <th>Die Cushion</th>
                    <th>Capacity</th>
                    <th>Die Size Height</th>
                    <th>Bolster Length</th>
                    <th>Bolster Weight</th>
                    <th>Slide Area Length</th>
                    <th>Slide Area Weight</th>
                    <th>Die Height</th>
                    <th>Cushion Pad Length</th>
                    <th>Cushion Pad Weight</th>
                    <th>Cushion Stroke</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (!empty($specs) && is_array($specs)): ?>
                    <?php foreach ($specs as $spec): ?>
                        <tr>
                        <td><?= esc($spec['machine']) ?></td>
                        <td><?= esc($spec['master_cushion']) ?></td>
                        <td><?= esc($spec['master_capacity']) ?></td>
                        <td><?= esc($spec['master_dh_dies']) ?></td>
                        <td><?= esc($spec['bolster_length']) ?></td>
                        <td><?= esc($spec['bolster_width']) ?></td>
                        <td><?= esc($spec['slide_area_length']) ?></td>
                        <td><?= esc($spec['slide_area_width']) ?></td>
                        <td><?= esc($spec['die_height']) ?></td>
                        <td><?= esc($spec['cushion_pad_length']) ?></td>
                        <td><?= esc($spec['cushion_pad_width']) ?></td>
                        <td><?= esc($spec['cushion_stroke']) ?></td>
                        </tr>
                    <?php endforeach; ?>
                    <?php else: ?>
                    <tr>
                        <td colspan="12" class="text-center">No data found.</td>
                    </tr>
                    <?php endif; ?>
                </tbody>
            </table>

          </div>
          
          <!-- Tab PDF -->
          <div class="tab-pane fade" id="pdf" role="tabpanel" aria-labelledby="pdf-tab">
            <div class="mt-3">
              <iframe src="<?= base_url('assets/file/spec_mesin.pdf') ?>" 
                      width="100%" 
                      height="1000" 
                      style="border: none;">
              </iframe>
            </div>
          </div>
        </div>
      </div>
      <!-- End Konten Tab -->
    </div>
  </div>
</div>

<?= $this->endSection() ?>
