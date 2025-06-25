<?= $this->extend('layout/template') ?>
<?= $this->section('content') ?>

<!-- Include Bootstrap JS dari CDN -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"></script>

<div class="pd-ltr-20 xs-pd-20-10">
  <div class="min-height-200px">
    
    <!-- Header Gabungan -->
    <div class="page-header d-flex justify-content-between align-items-center mb-3">
      <h4>Data PPS - MC Spec & Standard Die Design</h4>
    </div>
    
    <div class="card-box mb-30">
      <div class="pd-20">
        <h4 class="text-blue h4">Master Data PPS</h4>
        <p class="mb-0">Menampilkan data spesifikasi mesin (MC Spec) dan Standard Die Design.</p>
      </div>
      
      <!-- Nav Tabs (4 Tab) -->
      <ul class="nav nav-tabs" id="combinedTab" role="tablist">
        <li class="nav-item" role="presentation">
          <a class="nav-link active" id="die-design-table-tab" data-bs-toggle="tab" href="#die-design-table" role="tab" aria-controls="die-design-table" aria-selected="true">
            Die Design - Tabel Data
          </a>
        </li>
        <li class="nav-item" role="presentation">
          <a class="nav-link" id="die-design-pdf-tab" data-bs-toggle="tab" href="#die-design-pdf" role="tab" aria-controls="die-design-pdf" aria-selected="false">
            Die Design - PDF
          </a>
        </li>
        <li class="nav-item" role="presentation">
          <a class="nav-link" id="mc-spec-table-tab" data-bs-toggle="tab" href="#mc-spec-table" role="tab" aria-controls="mc-spec-table" aria-selected="false">
            MC Spec - Tabel Data
          </a>
        </li>
        <li class="nav-item" role="presentation">
          <a class="nav-link" id="mc-spec-pdf-tab" data-bs-toggle="tab" href="#mc-spec-pdf" role="tab" aria-controls="mc-spec-pdf" aria-selected="false">
            MC Spec - PDF
          </a>
        </li>
      </ul>

      <!-- Tab Content -->
      <div class="table-responsive mt-3">
         <div class="tab-content" id="combinedTabContent">
           <!-- Die Design - Tabel Data -->
           <div class="tab-pane fade show active" id="die-design-table" role="tabpanel" aria-labelledby="die-design-table-tab">
                <table class="data-table table stripe hover nowrap">
                  <colgroup>
                    <col style="width:20%;">
                    <col style="width:20%;">
                    <col style="width:20%;">
                    <col style="width:20%;">
                    <col style="width:20%;">
                  </colgroup>
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
           
           <!-- Die Design - PDF -->
           <div class="tab-pane fade" id="die-design-pdf" role="tabpanel" aria-labelledby="die-design-pdf-tab">
             <div class="mt-3">
               <iframe src="<?= base_url('assets/file/standar_die_design.pdf') ?>"
                       width="100%"
                       height="1000"
                       style="border: none;">
               </iframe>
             </div>
           </div>

           <!-- MC Spec - Tabel Data -->
           <div class="tab-pane fade show" id="mc-spec-table" role="tabpanel" aria-labelledby="mc-spec-table-tab">
           <a href="/mc-spec/create" class="btn btn-success mb-3 ml-2">Tambah Data</a> 
           <table class="data-table table stripe hover nowrap">
                <thead>
                  <tr>
                    <th>Machine</th>
                    <th>Die Cushion</th>
                    <th>Capacity</th>
                    <th>Die Size Height</th>
                    <th>Bolster Length</th>
                    <th>Bolster Width</th>
                    <th>Slide Area Length</th>
                    <th>Slide Area Width</th>
                    <th>Die Height</th>
                    <th>Cushion Pad Length</th>
                    <th>Cushion Pad Width</th>
                    <th>Cushion Stroke</th>
                    <th>Aksi</th>
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
                          <td>
                            <a href="/mc-spec/edit/<?= $spec['id'] ?>" class="btn btn-warning btn-sm">Edit</a>
                            <button onclick="confirmDelete(<?= $spec['id'] ?>)" class="btn btn-danger btn-sm">Hapus</button>

                          </td>
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
           
           <!-- MC Spec - PDF -->
           <div class="tab-pane fade" id="mc-spec-pdf" role="tabpanel" aria-labelledby="mc-spec-pdf-tab">
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
    </div>
  </div>
</div>
<script>
function confirmDelete(id) {
  Swal.fire({
    title: 'Yakin?',
    text: "Data yang dihapus tidak bisa dikembalikan!",
    icon: 'warning',
    showCancelButton: true,
    confirmButtonColor: '#d33',
    cancelButtonColor: '#3085d6',
    confirmButtonText: 'Ya, hapus!',
    cancelButtonText: 'Batal'
  }).then((result) => {
    if (result.isConfirmed) {
      window.location.href = "/mc-spec/delete/" + id;
    }
  });
}
</script>

<?= $this->endSection() ?>
