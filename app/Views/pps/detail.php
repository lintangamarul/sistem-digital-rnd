<?= $this->extend('layout/template') ?>

<?= $this->section('content') ?>

<style>
    /* Styling Step Wizard */
    .step-wizard {
        margin-bottom: 2rem;
        position: relative;
    }
    
    .step-progress {
        display: flex;
        justify-content: space-between;
        list-style: none;
        padding: 0;
        margin: 0 0 1rem 0;
    }
    
    .step-progress li {
        flex: 1;
        text-align: center;
        position: relative;
    }
    
    .step-progress li:before {
        content: "";
        width: 20px;
        height: 20px;
        background-color: #e9ecef;
        border-radius: 50%;
        display: block;
        margin: 0 auto 0.5rem;
        position: relative;
        z-index: 1;
    }
    
    .step-progress li:after {
        content: "";
        position: absolute;
        width: 100%;
        height: 2px;
        background-color: #e9ecef;
        top: 10px;
        left: -50%;
    }
    
    .step-progress li:first-child:after {
        content: none;
    }
    
    .step-progress li.active:before {
        background-color: #007bff;
        color: white;
    }
    
    .step {
        display: none;
    }
    
    .step.active {
        display: block;
        animation: fadeIn 0.5s;
    }
    
    @keyframes fadeIn {
        from { opacity: 0; }
        to { opacity: 1; }
    }
    
    .form-control-plaintext {
        padding: 0.375rem 0.75rem;
        background-color: #f8f9fa;
        border-radius: 0.25rem;
    }
    
    .nav-buttons {
        margin-top: 1.5rem;
    }
    
    .nav-buttons button {
        min-width: 120px;
    }
</style>

<div class="pd-ltr-20 xs-pd-20-10">
  <div class="min-height-200px">
    <!-- Page Header -->
    <div class="page-header">
      <div class="row">
        <div class="col-md-6 col-sm-12">
          <div class="title">
            <h4>Detail Data PPS</h4>
          </div>
          <nav aria-label="breadcrumb" role="navigation">
            <ol class="breadcrumb">
              <li class="breadcrumb-item"><a href="<?= site_url('dashboard'); ?>">Home</a></li>
              <li class="breadcrumb-item"><a href="<?= site_url('pps'); ?>">PPS</a></li>
              <li class="breadcrumb-item active" aria-current="page">Detail Data PPS</li>
            </ol>
          </nav>
        </div>
      </div>
    </div>
  
    <!-- Card Box Detail -->
    <div class="card-box p-4">
      <?php if (session()->getFlashdata('error')): ?>
        <div class="alert alert-danger"><?= session()->getFlashdata('error'); ?></div>
      <?php endif; ?>
      <?php if (session()->getFlashdata('success')): ?>
        <div class="alert alert-success"><?= session()->getFlashdata('success'); ?></div>
      <?php endif; ?>
      
      <!-- Step Wizard -->
      <div class="step-wizard mb-4">
        <ul class="step-progress list-unstyled d-flex justify-content-between">
          <li class="active">Data Utama</li>
          <li>Detail Material</li>
          <li>Konfigurasi Dies</li>
          <li>Die Construction</li>
          <li>Gambar & Info Tambahan</li>
        </ul>
      </div>
      
      <!-- Form Detail (read-only) -->
      <form>
        <!-- Step 1: Data Utama -->
        <div class="step active" data-step="1">
          <div class="card p-3 mb-3">
            <h5>Data Utama</h5>
            <div class="row">
              <!-- Baris pertama: Customer, Model, Receive -->
              <div class="col-md-4 mb-3">
                <label>Customer</label>
                <p class="form-control-plaintext"><?= esc($pps['cust']) ?></p>
              </div>
              <div class="col-md-4 mb-3">
                <label>Model</label>
                <p class="form-control-plaintext"><?= esc($pps['model']) ?></p>
              </div>
              <div class="col-md-4 mb-3">
                <label>Receive</label>
                <p class="form-control-plaintext"><?= isset($pps['receive']) ? esc($pps['receive']) : '-' ?></p>
              </div>
            </div>
            <div class="row">
              <!-- Baris kedua: Part No dan Part Name -->
              <div class="col-md-6 mb-3">
                <label>Part No</label>
                <p class="form-control-plaintext"><?= esc($pps['part_no']) ?></p>
              </div>
              <div class="col-md-6 mb-3">
                <label>Part Name</label>
                <p class="form-control-plaintext"><?= esc($pps['part_name']) ?></p>
              </div>
            </div>
          </div>
          <div class="nav-buttons text-right">
            <button type="button" class="btn btn-primary next-step" data-next="2">Selanjutnya</button>
          </div>
        </div>
        <!-- End Step 1 -->
        
        <!-- Step 2: Detail Material -->
        <div class="step" data-step="2" style="display: none;">
          <div class="card p-3 mb-3">
            <h5>Detail Material</h5>
            <div class="row">
              <!-- Baris pertama: CF, Material, Tonasi, Length -->
              <div class="col-md-3 mb-3">
                <label>CF</label>
                <p class="form-control-plaintext"><?= isset($pps['cf']) ? esc($pps['cf']) : '-' ?></p>
              </div>
              <div class="col-md-3 mb-3">
                <label>Material</label>
                <p class="form-control-plaintext"><?= esc($pps['material']) ?></p>
              </div>
              <div class="col-md-3 mb-3">
                <label>Tonasi</label>
                <p class="form-control-plaintext"><?= esc($pps['tonasi']) ?></p>
              </div>
              <div class="col-md-3 mb-3">
                <label>Length</label>
                <p class="form-control-plaintext"><?= isset($pps['length']) ? esc($pps['length']) : '-' ?></p>
              </div>
            </div>
            <div class="row">
              <!-- Baris kedua: Width, BOQ, Blank, Panel -->
              <div class="col-md-3 mb-3">
                <label>Width</label>
                <p class="form-control-plaintext"><?= isset($pps['width']) ? esc($pps['width']) : '-' ?></p>
              </div>
              <div class="col-md-3 mb-3">
                <label>BOQ</label>
                <p class="form-control-plaintext"><?= isset($pps['boq']) ? esc($pps['boq']) : '-' ?></p>
              </div>
              <div class="col-md-3 mb-3">
                <label>Blank</label>
                <p class="form-control-plaintext"><?= isset($pps['blank']) ? esc($pps['blank']) : '-' ?></p>
              </div>
              <div class="col-md-3 mb-3">
                <label>Panel</label>
                <p class="form-control-plaintext"><?= isset($pps['panel']) ? esc($pps['panel']) : '-' ?></p>
              </div>
            </div>
            <div class="row">
              <!-- Baris ketiga: Scrap -->
              <div class="col-md-3 mb-3">
                <label>Scrap</label>
                <p class="form-control-plaintext"><?= isset($pps['scrap']) ? esc($pps['scrap']) : '-' ?></p>
              </div>
            </div>
          </div>
          <div class="nav-buttons text-right">
            <button type="button" class="btn btn-secondary prev-step" data-prev="1">Sebelumnya</button>
            <button type="button" class="btn btn-primary next-step" data-next="3">Selanjutnya</button>
          </div>
        </div>
        <!-- End Step 2 -->
        
        <!-- Step 3: Konfigurasi Dies -->
        <div class="step" data-step="3" style="display: none;">
          <div class="card p-3 mb-3">
            <h5>Konfigurasi Dies</h5>
            <!-- Tabel Basic -->
            <h6 class="mb-3">Tabel Basic</h6>
            <div class="table-responsive mb-3">
              <table class="table table-bordered">
                <thead>
                  <tr>
                    <th>Process</th>
                    <th>Process Join</th>
                    <th>Proses</th>
                    <th>Length MP</th>
                    <th>Main Pressure</th>
                    <th>Machine</th>
                    <th>Capacity</th>
                    <th>Cushion</th>
                  </tr>
                </thead>
                <tbody>
                  <?php if (!empty($dies)): ?>
                    <?php foreach ($dies as $die): ?>
                      <tr>
                        <td><?= esc($die['process']) ?></td>
                        <td><?= esc($die['process_join']) ?></td>
                        <td><?= esc($die['proses']) ?></td>
                        <td><?= esc($die['length_mp']) ?></td>
                        <td><?= esc($die['main_pressure']) ?></td>
                        <td><?= esc($die['machine']) ?></td>
                        <td><?= esc($die['capacity']) ?></td>
                        <td><?= esc($die['cushion']) ?></td>
                      </tr>
                    <?php endforeach; ?>
                  <?php else: ?>
                    <tr>
                      <td colspan="8" class="text-center">Data tidak tersedia</td>
                    </tr>
                  <?php endif; ?>
                </tbody>
              </table>
            </div>
            <!-- Tabel Die -->
            <h6 class="mb-3">Tabel Die</h6>
            <div class="table-responsive">
              <table class="table table-bordered">
                <thead>
                  <tr>
                    <th>Process</th>
                    <th>Proses Standard Die</th>
                    <th>Die Length</th>
                    <th>Die Width</th>
                    <th>Die Height</th>
                    <th>Die Weight</th>
                  </tr>
                </thead>
                <tbody>
                  <?php if (!empty($dies)): ?>
                    <?php foreach ($dies as $die): ?>
                      <tr>
                        <td><?= esc($die['process']) ?></td>
                        <td><?= esc($die['proses']) ?></td>
                        <td><?= esc($die['die_length']) ?></td>
                        <td><?= esc($die['die_width']) ?></td>
                        <td><?= esc($die['die_height']) ?></td>
                        <td><?= esc($die['die_weight']) ?></td>
                      </tr>
                    <?php endforeach; ?>
                  <?php else: ?>
                    <tr>
                      <td colspan="6" class="text-center">Data tidak tersedia</td>
                    </tr>
                  <?php endif; ?>
                </tbody>
              </table>
            </div>
          </div>
          <div class="nav-buttons text-right">
            <button type="button" class="btn btn-secondary prev-step" data-prev="2">Sebelumnya</button>
            <button type="button" class="btn btn-primary next-step" data-next="4">Selanjutnya</button>
          </div>
        </div>
        <!-- End Step 3 -->
        
        <!-- Step 4: Die Construction -->
        <div class="step" data-step="4" style="display: none;">
          <div class="card p-3 mb-3">
            <h5>Die Construction</h5>
            <div class="table-responsive">
              <table class="table table-bordered">
                <thead>
                  <tr>
                    <th>Process</th>
                    <th>Machine</th>
                    <th>Upper</th>
                    <th>Lower</th>
                    <th>Pad</th>
                    <th>Pad Lifter</th>
                    <th>Sliding</th>
                    <th>Guide</th>
                    <th>Insert</th>
                    <th>Heat Treatment</th>
                  </tr>
                </thead>
                <tbody>
                  <?php if (!empty($dies)): ?>
                    <?php foreach ($dies as $die): ?>
                      <tr>
                        <td><?= esc($die['process']) ?></td>
                        <td><?= esc($die['machine']) ?></td>
                        <td><?= esc($die['upper']) ?></td>
                        <td><?= esc($die['lower']) ?></td>
                        <td><?= esc($die['pad']) ?></td>
                        <td><?= esc($die['pad_lifter']) ?></td>
                        <td><?= esc($die['sliding']) ?></td>
                        <td><?= esc($die['guide']) ?></td>
                        <td><?= esc($die['insert']) ?></td>
                        <td><?= esc($die['heat_treatment']) ?></td>
                      </tr>
                    <?php endforeach; ?>
                  <?php else: ?>
                    <tr>
                      <td colspan="10" class="text-center">Data tidak tersedia</td>
                    </tr>
                  <?php endif; ?>
                </tbody>
              </table>
            </div>
            <!-- Gambar Pendukung -->
            <div class="row mt-3">
              <div class="col-md-6">
                <label>C-Layout</label>
                <?php if (!empty($dies[0]['clayout_img'])): ?>
                  <img src="<?= base_url('uploads/' . $dies[0]['clayout_img']) ?>" width="150" alt="C-Layout">
                <?php else: ?>
                  <p>Tidak ada gambar</p>
                <?php endif; ?>
              </div>
              <div class="col-md-6">
                <label>Die Construction</label>
                <?php if (!empty($dies[0]['die_construction_img'])): ?>
                  <img src="<?= base_url('uploads/' . $dies[0]['die_construction_img']) ?>" width="150" alt="Die Construction">
                <?php else: ?>
                  <p>Tidak ada gambar</p>
                <?php endif; ?>
              </div>
            </div>
          </div>
          <div class="nav-buttons text-right">
            <button type="button" class="btn btn-secondary prev-step" data-prev="3">Sebelumnya</button>
            <button type="button" class="btn btn-primary next-step" data-next="5">Selanjutnya</button>
          </div>
        </div>
        <!-- End Step 4 -->
        
        <!-- Step 5: Gambar & Informasi Tambahan -->
        <div class="step" data-step="5" style="display: none;">
          <div class="card p-3 mb-3">
            <h5>Gambar & Informasi Tambahan</h5>
            <div class="row">
              <div class="col-md-6 mb-3">
                <label>Blank Layout</label>
                <?php if(!empty($pps['blank_layout'])): ?>
                  <img src="<?= base_url('uploads/' . $pps['blank_layout']) ?>" width="150" alt="Blank Layout">
                <?php else: ?>
                  <p>Tidak ada gambar</p>
                <?php endif; ?>
              </div>
              <div class="col-md-6 mb-3">
                <label>Process Layout</label>
                <?php if(!empty($pps['process_layout'])): ?>
                  <img src="<?= base_url('uploads/' . $pps['process_layout']) ?>" width="150" alt="Process Layout">
                <?php else: ?>
                  <p>Tidak ada gambar</p>
                <?php endif; ?>
              </div>
            </div>
            <div class="row">
              <div class="col-md-6 mb-3">
                <label>Excel File</label>
                <?php if(!empty($pps['excel_file'])): ?>
                  <a href="<?= base_url('uploads/' . $pps['excel_file']) ?>" target="_blank" class="btn btn-sm btn-info">Lihat File</a>
                <?php else: ?>
                  <p>Tidak ada file</p>
                <?php endif; ?>
              </div>
              <div class="col-md-6 mb-3">
                <label>Created At</label>
                <p class="form-control-plaintext"><?= isset($pps['created_at']) ? date('d-m-Y H:i', strtotime($pps['created_at'])) : '-' ?></p>
              </div>
            </div>
          </div>
          <div class="nav-buttons text-right">
            <button type="button" class="btn btn-secondary prev-step" data-prev="4">Sebelumnya</button>
          </div>
        </div>
        <!-- End Step 5 -->
      </form>
      <div id="errorMessage" style="color: red;"></div>
    </div>
  </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
  const steps = document.querySelectorAll('.step');
  const stepProgress = document.querySelectorAll('.step-progress li');
  let currentStep = 1;

  function showStep(stepNumber) {
    steps.forEach(step => {
      // Sembunyikan semua step
    // xyz
      step.style.display = 'none';
      step.classList.remove('active');
    });
    // Tampilkan step yang aktif
    const activeStep = document.querySelector(`.step[data-step="${stepNumber}"]`);
    if (activeStep) {
      activeStep.style.display = 'block';
      activeStep.classList.add('active');
    }
    
    // Update progress wizard
    stepProgress.forEach((item, index) => {
      if (index < stepNumber) {
        item.classList.add('active');
      } else {
        item.classList.remove('active');
      }
    });
  }

  // Pindah ke step berikutnya
  document.querySelectorAll('.next-step').forEach(button => {
    button.addEventListener('click', function() {
      const nextStep = parseInt(this.dataset.next);
      if (validateStep(currentStep)) {
        currentStep = nextStep;
        showStep(currentStep);
      }
    });
  });

  // Pindah ke step sebelumnya
  document.querySelectorAll('.prev-step').forEach(button => {
    button.addEventListener('click', function() {
      const prevStep = parseInt(this.dataset.prev);
      currentStep = prevStep;
      showStep(currentStep);
    });
  });

  function validateStep(stepNumber) {
    const currentStepElement = document.querySelector(`.step[data-step="${stepNumber}"]`);
    const requiredFields = currentStepElement.querySelectorAll('[required]');
    let isValid = true;
    requiredFields.forEach(field => {
      if (!field.value.trim()) {
        isValid = false;
        field.classList.add('is-invalid');
      } else {
        field.classList.remove('is-invalid');
      }
    });
    if (!isValid) {
      alert('Silakan lengkapi semua field yang wajib diisi.');
    }
    return isValid;
  }

  // Tampilkan step awal
  showStep(currentStep);
});
</script>
<?= $this->endSection() ?>
