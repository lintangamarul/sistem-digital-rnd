<?= $this->extend('layout/print_template') ?>
<?= $this->section('content') ?>

<div class="print-header" style="display: flex; justify-content: space-between; align-items: center; padding: 10px 0;">
  <!-- Sisi Kiri: Logo dan Judul -->
  <div style="flex: 1; text-align: left;">
  <img src="<?= base_url('assets/images/logomekar.png'); ?>" alt="Logo" style="width: 200px; height: auto;">
  <h2>Detail Try Out Report Dies</h2>
  </div>

  <!-- Sisi Kanan: Informasi Dokumen -->
  <div style="flex: 2; display: flex; justify-content: space-between;">
    <div style="flex: 1; text-align: right;">
      <p><strong>No Dokumen:</strong> FR/MAJ-PR-02/16/01</p>
      <p><strong>Tgl. Dikeluarkan:</strong> January 02, 2012</p>
      <p><strong>Revisi:</strong> 01</p>
    </div>
    <div style="flex: 1; text-align: right;">
           <p><strong>Tgl. Revisi:</strong> 13 January 2020</p>
      <p><strong>Halaman:</strong> 1/3</p>
    </div>
  </div>
</div>
<hr>


<!-- MACHINE PARAMETER -->
<div class="card">
  <h4><strong>MACHINE PARAMETER</strong></h4>
  <!-- Baris 1 -->
  <div class="row" style="margin-top: 5px;">
    <div class="col-md-2">
      <label class="font-weight-bold">Part No</label>
      <p><?= esc($project['part_no']); ?></p>
    </div>
    <div class="col-md-2">
      <label class="font-weight-bold">Process</label>
      <p><?= esc($project['process']); ?></p>
    </div>
    <div class="col-md-2">
      <label class="font-weight-bold">Process</label>
      <p><?= esc($project['proses']); ?></p>
    </div>
    <div class="col-md-2">
      <label class="font-weight-bold">M/C LINE</label>
      <p><?= esc($tryout['mc_line']); ?></p>
    </div>
    
    <div class="col-md-2">
      <label class="font-weight-bold">ADAPTOR</label>
      <p><?= esc($tryout['adaptor']); ?> mm</p>
    </div>
  </div>
  <!-- Baris 2 -->
  <div class="row" style="margin-top: 5px;">
    <div class="col-md-2">
      <label class="font-weight-bold">CUSH. PRESS</label>
      <p><?= esc($tryout['cush_press']); ?></p>
    </div>
    <div class="col-md-2">
      <label class="font-weight-bold">CUSH. H.</label>
      <p><?= esc($tryout['cush_h']); ?> mm</p>
    </div>
    <div class="col-md-2">
      <label class="font-weight-bold">MAIN PRESS</label>
      <p><?= esc($tryout['main_press']); ?> N</p>
    </div>
    <div class="col-md-2">
      <label class="font-weight-bold">SLIDE / DH</label>
      <p><?= esc($tryout['slide_dh']); ?> mm</p>
    </div>
    
    <div class="col-md-2">
      <label class="font-weight-bold">GSPH</label>
      <p><?= esc($tryout['gsph']); ?> pcs/jam</p>
    </div>
  </div>
  <!-- Baris 3 -->
  <div class="row" style="margin-top: 5px;">
    <div class="col-md-2">
      <label class="font-weight-bold">BOOLSTER</label>
      <p><?= esc($tryout['boolster']); ?></p>
    </div>
    <div class="col-md-2">
      <label class="font-weight-bold">Projek</label>
      <p><?= esc($tryout['projek']); ?></p>
    </div>
    <div class="col-md-2">
      <label class="font-weight-bold">SPM</label>
      <p><?= esc($tryout['spm']); ?> det</p>
    </div>
    <div class="col-md-2">
      <label class="font-weight-bold">Step</label>
      <p><?= esc($tryout['step']); ?></p>
    </div>
    <div class="col-md-2">
      <label class="font-weight-bold">Event</label>
      <p><?= esc($tryout['event']); ?></p>
    </div>
    <!-- Kolom kelima kosong karena tidak ada data tambahan -->
    <div class="col-md-2"></div>
  </div>
</div>


<div class="row">
  <!-- Kolom IMAGE RESULT -->
  <div class="col-md-6">
    <div class="card">
      <h4><strong>IMAGE RESULT</strong></h4>
      <div class="row">
        <div class="col-md-6 text-center">
          <div style="padding: 5px;">
            <p class="font-weight-bold">Image Part Trial</p>
            <?php if ($tryout['part_trial_image']): ?>
              <img src="<?= base_url('uploads/part_trial/' . $tryout['part_trial_image']); ?>" 
              alt="Part Trial Image" 
     class="img-fluid img-thumbnail print-img" 
     style="max-height: 100px; width: auto; object-fit: contain;">
            <?php else: ?>
              <p class="text-muted">No image available</p>
            <?php endif; ?>
          </div>
        </div>
        <div class="col-md-6 text-center">
          <div style="padding: 5px;">
            <p class="font-weight-bold">Image Material</p>
            <?php if ($tryout['material_image']): ?>
              <img src="<?= base_url('uploads/material/' . $tryout['material_image']); ?>" 
              alt="Part Trial Image" 
     class="img-fluid img-thumbnail print-img" 
     style="max-height: 100px; width: auto; object-fit: contain;">
            <?php else: ?>
              <p class="text-muted">No image available</p>
            <?php endif; ?>
          </div>
        </div>
      </div>
    </div>
  </div>
  
  <!-- Kolom KUANTITAS PART dan KUANTITAS MATERIAL -->
  <div class="col-md-6">
    <div class="card">
      <h4><strong>KUANTITAS PART</strong></h4>
      <div class="row">
        <div class="col-md-4">
          <label class="font-weight-bold">Target</label>
          <p><?= esc($tryout['part_target']); ?> pcs</p>
        </div>
        <div class="col-md-4">
          <label class="font-weight-bold">Act</label>
          <p><?= esc($tryout['part_act']); ?> pcs</p>
        </div>
        <div class="col-md-4">
          <label class="font-weight-bold">Judge</label>
          <p><?= esc($tryout['part_judge']); ?></p>
        </div>
      </div>
      <div class="row" style="margin-top: 5px;">
        <div class="col-md-4">
          <label class="font-weight-bold">FAT RESULT 🔼</label>
          <p><?= esc($tryout['part_up']); ?></p>
        </div>
        <div class="col-md-4">
          <label class="font-weight-bold">STD ⭘</label>
          <p><?= esc($tryout['part_std']); ?></p>
        </div>
        <div class="col-md-4">
          <label class="font-weight-bold">FAT RESULT 🔽</label>
          <p><?= esc($tryout['part_down']); ?></p>
        </div>
      </div>
    </div>

    <div class="card mt-2">
      <h4><strong>KUANTITAS MATERIAL</strong></h4>
      <div class="row">
        <div class="col-md-6">
          <label class="font-weight-bold">Pakai</label>
          <p><?= esc($tryout['material_pakai']); ?> pcs</p>
        </div>
        <div class="col-md-6">
          <label class="font-weight-bold">Sisa</label>
          <p><?= esc($tryout['material_sisa']); ?> pcs</p>
        </div>
      </div>
    </div>
  </div>
</div>


<!-- TRIAL TIME -->
<div class="card">
  <h4><strong>TRIAL TIME</strong></h4>
  <div class="row">
    <div class="col-md-4">
      <label class="font-weight-bold">Tanggal Tryout</label>
      <p><?= date('d-m-Y', strtotime($tryout['dates'])); ?></p>
    </div>
    <div class="col-md-4">
      <label class="font-weight-bold">Jam</label>
      <p><?= esc($tryout['trial_time']); ?></p>
    </div>
    <div class="col-md-4">
      <label class="font-weight-bold">Maker</label>
      <p>
        <?= ($tryout['trial_maker'] == 'OTHERS') 
              ? esc($tryout['trial_maker_manual']) 
              : esc($tryout['trial_maker']); ?>
      </p>
    </div>
  </div>
</div>

<!-- KONFIRMASI TRYOUT -->
<div class="card">
  <h4><strong>KONFIRMASI TRYOUT</strong></h4>
  <div class="row">
    <div class="col-md-6">
      <label class="font-weight-bold">Konfirmasi Produksi</label>
      <p>
        <?= is_array($konfirmasi_produksi) 
              ? $konfirmasi_produksi['nama'] . (!empty($konfirmasi_produksi['department']) ? ' - ' . $konfirmasi_produksi['department'] : '')
              : esc($konfirmasi_produksi); ?>
      </p>
    </div>
    <div class="col-md-6">
      <label class="font-weight-bold">Konfirmasi QC</label>
      <p>
        <?= is_array($konfirmasi_qc) 
              ? $konfirmasi_qc['nama'] . (!empty($konfirmasi_qc['department']) ? ' - ' . $konfirmasi_qc['department'] : '')
              : esc($konfirmasi_qc); ?>
      </p>
    </div>
  </div>
  <div class="row" style="margin-top: 5px;">
    <div class="col-md-6">
      <label class="font-weight-bold">Konfirmasi Tooling</label>
      <p>
        <?= is_array($konfirmasi_tooling) 
              ? $konfirmasi_tooling['nama'] . (!empty($konfirmasi_tooling['department']) ? ' - ' . $konfirmasi_tooling['department'] : '')
              : esc($konfirmasi_tooling); ?>
      </p>
    </div>
    <div class="col-md-6">
      <label class="font-weight-bold">Konfirmasi R&D</label>
      <p>
        <?= is_array($konfirmasi_rd) 
              ? $konfirmasi_rd['nama'] . (!empty($konfirmasi_rd['department']) ? ' - ' . $konfirmasi_rd['department'] : '')
              : esc($konfirmasi_rd); ?>
      </p>
    </div>
  </div>
</div>

<!-- PROBLEM & COUNTER MEASURE -->
<div class="card">
  <h4><strong>PROBLEM & COUNTER MEASURE</strong></h4>
  <?php if (!empty($detail_tryouts)): ?>
    <table>
      <thead>
        <tr>
          <th>Problem</th>
          <th>Counter Measure</th>
          <th>PIC</th>
          <th>Target</th>
          <th>Progress</th>
        </tr>
      </thead>
      <tbody>
        <?php foreach ($detail_tryouts as $detail): ?>
        <tr>
          <td>
            <?php if (!empty($detail['problem_image'])): ?>
              <img src="<?= base_url('uploads/problems/' . $detail['problem_image']); ?>" 
                   alt="Problem Image" 
                   class="img-thumbnail" 
                   style="max-width: 80px; margin-bottom: 2px;">
              <br>
            <?php endif; ?>
            <?= !empty($detail['problem_text']) ? esc($detail['problem_text']) : 'No problem description.'; ?>
          </td>
          <td><?= !empty($detail['counter_measure']) ? esc($detail['counter_measure']) : '-'; ?></td>
          <td><?= !empty($detail['pic']) ? esc($detail['pic']) : 'No PIC assigned'; ?></td>
          <td><?= !empty($detail['target']) ? esc($detail['target']) : '-'; ?></td>
          <td><?= !empty($detail['progress']) ? esc($detail['progress']) . '%' : '0%'; ?></td>
        </tr>
        <?php endforeach; ?>
      </tbody>
    </table>
  <?php else: ?>
    <p>No problems reported.</p>
  <?php endif; ?>
</div>

<!-- Tombol Save PDF -->
<div id="downloadPDFButton" class="text-center no-print" style="margin-top: 10px;">
  <button onclick="downloadPDF();" style="padding: 5px 10px; font-size: 12px;">
    <i class="fas fa-download"></i> Save PDF
  </button>
</div>

<!-- Sertakan html2pdf.js dari CDN -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/html2pdf.js/0.9.2/html2pdf.bundle.min.js"></script>
<script>
  function downloadPDF() {
    // Sembunyikan tombol 'Save PDF' saat konversi
    document.getElementById('downloadPDFButton').style.display = 'none';

    // Pilih elemen yang ingin dijadikan PDF
    const element = document.querySelector('.container');
    
    // Set opsi pdf
    const opt = {
      margin:       0.5,
      filename:     'Tryout_Report_Dies.pdf',
      image:        { type: 'jpeg', quality: 0.98 },
      html2canvas:  { scale: 2 },
      jsPDF:        { 
        unit: 'in', 
        format: [8.27, 13],  // Ukuran F4 dalam inch (210mm x 330mm)
        orientation: 'portrait' 
      }
    };

    // Proses konversi ke PDF
    html2pdf().set(opt).from(element).save().then(function() {
      // Tampilkan tombol kembali setelah PDF selesai di-download
      document.getElementById('downloadPDFButton').style.display = 'block';
    });
  }
</script>


<?= $this->endSection() ?>
