<?= $this->extend('layout/template') ?>

<?= $this->section('content') ?>
<style>
.dcp-slider-wrapper {
  position: relative;
  display: flex;
  align-items: center;
  width: 100%;
}

.dcp-slider-container {
  display: flex;
  overflow-x: auto;
  gap: 10px;
  scroll-snap-type: x mandatory;
  padding: 10px 40px;
  width: 100%;
  scroll-behavior: smooth;
}

.dcp-slider-container img {
  flex: 0 0 auto;
  width: 100px;
  border-radius: 10px;
  cursor: pointer;
  scroll-snap-align: start;
  transition: transform 0.2s;
}

.slider-btn {
  position: absolute;
  top: 50%;
  transform: translateY(-50%);
  background: rgba(255, 255, 255, 0.9);
  border: none;
  border-radius: 50%;
  padding: 10px;
  box-shadow: 0 2px 6px rgba(0,0,0,0.2);
  cursor: pointer;
  transition: background 0.3s, transform 0.2s;
  z-index: 10;
}

.slider-btn.left {
  left: 5px;
}

.slider-btn.right {
  right: 5px;
}

.slider-btn:hover {
  background: #f0f0f0;
  transform: translateY(-50%) scale(1.1);
}


</style>

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
            <h4>Edit Data PPS</h4>
          </div>
          <nav aria-label="breadcrumb" role="navigation">
            <ol class="breadcrumb">
              <li class="breadcrumb-item"><a href="<?= site_url('dashboard'); ?>">Home</a></li>
              <li class="breadcrumb-item"><a href="<?= site_url('pps'); ?>">PPS</a></li>
              <li class="breadcrumb-item active" aria-current="page">Edit Data PPS</li>
            </ol>
          </nav>
        </div>
      </div>
    </div>
  
    <!-- Card Box Form Edit -->
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
      
      <!-- Form Edit -->
      <form action="<?= site_url('pps/update') ?>" method="post" enctype="multipart/form-data" novalidate>
        <input type="hidden" name="id" value="<?= esc($pps['id']) ?>">
        
        <!-- Step 1: Data Utama -->
        <div class="step active" data-step="1">
          <div class="card p-3 mb-3">
            <h5>Data Utama</h5>
            <li>Part yang muncul bedasarkan data dari Master project, Tambahkan data di Master Project Dahulu apabila tidak ditemukan Part No yang sesuai</li>
            <li>Data Part Name, Cust, Model akan terisi bedasarkan part no yag dipilih</li>
            <div class="row">
              <!-- Baris: Part No dan Part Name -->
             <!-- Ganti input Part No dengan Select -->
              <div class="col-md-6 mb-3">
                <label>Part No</label>
                <select id="part_no_select" name="part_no_select" class="custom-select2 form-control" style="width: 100%; height: 38px;"> 
                  <option value="">-- Pilih Model - Part No --</option> 
                  <?php foreach ($projects as $project): ?> 
                    <option  
                      value="<?= $project['id'] ?>" 
                      data-model="<?= $project['model'] ?>" 
                      data-part_no="<?= $project['part_no'] ?>" 
                      data-part_name="<?= $project['part_name'] ?>" 
                      data-customer="<?= $project['customer'] ?>"
                      <?= $pps['part_no'] === $project['part_no'] ? 'selected' : '' ?>
                    > 
                      <?= $project['model'] ?> - <?= $project['part_no'] ?> 
                    </option> 
                  <?php endforeach; ?> 
                </select>
                <input type="hidden" id="part_no" name="part_no" value="<?= esc($pps['part_no']) ?>">
              </div>

              <div class="col-md-6 mb-3">
                <label>Part Name</label>
                <input type="text" id="part_name" name="part_name" class="form-control" value="<?= esc($pps['part_name']) ?>" readonly>
              </div>

            </div>
            <div class="row">
              <!-- Baris: Customer, Model, Receive -->
              <div class="col-md-4 mb-3">
                <label>Customer</label>
                <input type="text" id="cust" name="cust" class="form-control" value="<?= esc($pps['cust']) ?>" required readonly>
              </div>
                            <div class="col-md-4 mb-3">
                <label>Model</label>
                <input type="text" id="model" name="model" class="form-control" value="<?= esc($pps['model']) ?>" required readonly>
              </div>
              <div class="col-md-4 mb-3">
                <label>Receive</label>
                <input type="date" name="receive" class="form-control" value="<?= esc($pps['receive']) ?>">
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
            <li>Untuk Tambah List Material, Silahkan akses Master DCP PPS -> Material</li>
            <div class="row">
              <!-- Baris: Material & Thickness -->
              <div class="col-md-4 mb-3">
                <label>Jenis Material</label>
                <select name="material" id="materialDropdown" class="form-control custom-select2 mb-2" style="width: 100%; height: 38px;">
                    <option value="">-- Pilih Material --</option>
                    <?php foreach ($materialData as $material): ?>
                        <option value="<?= esc($material['name_material']) ?>" <?= $pps['material'] === $material['name_material'] ? 'selected' : '' ?>>
                            <?= esc($material['name_material']) ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>
            <input type="hidden" id="material" name="material" class="form-control" placeholder="Jenis material"  readonly>
                    

              <div class="col-md-6 mb-3">
                <label>Thickness</label>
                <input type="text" name="tonasi" id="tonasi" class="form-control" value="<?= esc($pps['tonasi']) ?>">
              </div>

            </div>
            <div class="row">
              <!-- Baris: Length, Width, BOQ -->
              <div class="col-md-4 mb-3">
                <label>Length</label>
                <input type="number" name="length" id="length" class="form-control" value="<?= esc($pps['length']) ?>">
              </div>
              <div class="col-md-4 mb-3">
                <label>Width</label>
                <input type="number" name="width" id="width" class="form-control" value="<?= esc($pps['width']) ?>">
              </div>
              <div class="col-md-4 mb-3">
                <label>BOQ</label>
                <input type="number" name="boq" id="boq" class="form-control" value="<?= esc($pps['boq']) ?>">
              </div>
            </div>
            <div class="row">
              <!-- Baris: Blank, Panel, Scrap -->
              <div class="col-md-4 mb-3">
                <label>Blank</label>
                <input type="number" name="blank" id="blank" class="form-control" value="<?= esc($pps['blank']) ?>" readonly>
              </div>
              <div class="col-md-4 mb-3">
                <label>Panel</label>
                <input type="number" name="panel" id="panel" class="form-control" value="<?= esc($pps['panel']) ?>">
              </div>
              <div class="col-md-4 mb-3">
                <label>Scrap</label>
                <input type="number" name="scrap" id="scrap" class="form-control" value="<?= esc($pps['scrap']) ?>" readonly>
                <span id="scrapError" style="color: red;"></span>
              </div>
            </div>
          </div>
          <div class="nav-buttons text-right">
            <button type="button" class="btn btn-secondary prev-step" data-prev="1">Sebelumnya</button>
            <button type="button" class="btn btn-primary next-step" data-next="3">Selanjutnya</button>
          </div>
        </div>
        <!-- End Step 2 -->

        <?php 
          // Opsi untuk dropdown OP dan opsi proses
          $ops = ["OP10", "OP20", "OP30", "OP40", "OP50", "OP60", "OP70", "OP80"];
          $prosesOptions = [
            "BLANK",
            "BEND",
            "DRAW",
            "FLANGE",
            "FORM",
            "MARKING",
            "PIE",
            "REST",
            "SEP",
            "TRIM",
        ];
        ?>

        <!-- Step 3: Konfigurasi Dies -->
        <div class="step" data-step="3" style="display: block;">
          
         <!-- Tombol untuk membuka modal -->
          <div class="text-left mb-2">
              <button type="button" class="btn btn-info btn-sm" data-toggle="modal" data-target="#diesHintModal">
                  <i class="fa fa-lightbulb-o" aria-hidden="true"></i> Petunjuk
              </button>
          </div>

          <!-- Modal Dies Configuration -->
          <div class="modal fade" id="diesHintModal" tabindex="-1" role="dialog" aria-labelledby="diesHintModalLabel" aria-hidden="true">
              <div class="modal-dialog modal-lg" role="document">
                  <div class="modal-content">
                      <!-- Header Modal -->
                      <div class="modal-header">
                          <h5 class="modal-title" id="diesHintModalLabel">Logika Sistem Dies Configuration</h5>
                          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                              <span aria-hidden="true">&times;</span>
                          </button>
                      </div>
                      <!-- Body Modal -->
                      <div class="modal-body">
                          <h6><strong>1. Dies Configuration</strong></h6>
                          <img src="<?= base_url('assets/images/DiesConfiguration.png') ?>" alt="Dies Configuration" class="img-fluid mb-3">
                          <p>Dies Configuration digunakan untuk mengisi PRESS M/C SPEC dan PROCESS DETAIL																																																					
                          yang akan ditempelkan pada bagian Excel seperti gamabr diatas</p>

                          <hr>

                          <h6><strong>2. Konversi Tensile Material</strong></h6>
                          <p>Tensile material dikonversi berdasarkan nilai material yang digunakan:</p>
                          <pre>
                            if (tensile_material === 270) {
                                konversi = 30;
                            } else if (tensile_material === 440) {
                              konversi = 45;
                            } else if (material === 590) {
                              konversi = 60;
                            } else {
                              konversi = 100; 
                            }
                          </pre>

                          <hr>

                          <h6><strong>3. Perhitungan Main Pressure</strong></h6>
                          <p>Rumus perhitungan tekanan utama (Main Pressure):</p>
                          <ul>
                              <li>BL/TR: <code>(Luas * thickness * 0.8 * konversi * 1.2 * 1) / 1000</code></li>
                              <li>DR/DO: <code>(Luas * thickness * 0.8 * konversi * 1.2 * 2.5) / 1000</code></li>
                          </ul>

                          <hr>

                          <h6><strong>4. Spesifikasi Mesin</strong></h6>
                          <!-- <p>Spesifikasi mesin dapat dilihat pada gambar berikut:</p>
                          <img src="<?= base_url('assets/images/specMesin.png') ?>" alt="Spesifikasi Mesin" class="img-fluid mb-3"> -->
                          <p>Untuk melihat data lengkap, kunjungi: <a href="<?= base_url('master-pps') ?>"  target="_blank" >Master Data PPS</a></p>

                          <hr>

                          <h6><strong>5. Data Tonase, Cushion dan Die Height</strong></h6>

                          <p>Untuk melihat master data Tonase, Cushion dan Die Height tiap mesin, kunjungi:<a href="<?= base_url('master-pps') ?>"  target="_blank" >Master Data PPS</a></p>

                       

                          <hr>

                          <h6><strong>6. Perhitungan Die Weight</strong></h6>
                          <img src="<?= base_url('assets/images/konversiDieWeight.png') ?>" alt="Konversi Die Weight" class="img-fluid mb-3">
                          <p>Rumus perhitungan berat Die:</p>
                          <pre>(dieLength * dieWidth * dieHeight * factor * 7.85) / 1000000</pre>

                          <p>Untuk melihat master data Die Sizing Process, kunjungi: <a href="<?= base_url('master-pps') ?>"  target="_blank" >Master Data PPS</a></p>
                          <ul>
                              <li>Big Dies :Apabila memilih machine A, D, E, F, G</li>
                              <li>Medium Dies :Apabila memilih machine B, H, C</li>
                              <li>Small Dies :Apabila memilih machine 300 T (MP), SP</li>
                          </ul>
                          <h6><strong>7. Perhitungan Die Weight</strong></h6>

                            <p>Kelas dihitung sistem dengan kriteria:</p>
                            <ul>
                                <li><strong>Kelas A:</strong> berat lebih dari 6971 kg</li>
                                <li><strong>Kelas B:</strong> antara 3915 sampai 6971 kg</li>
                                <li><strong>Kelas C:</strong> antara 1962 sampai 3914 kg</li>
                                <li><strong>Kelas D:</strong> antara 849 sampai 1961 kg</li>
                                <li><strong>Kelas E:</strong> antara 398 sampai 848 kg</li>
                                <li><strong>Kelas F:</strong> antara 1 sampai 397 kg</li>
                            </ul>
                          </div>
                  </div>
              </div>
          </div>
          <div class="card p-3 mb-3">
            <h5>Konfigurasi Dies</h5>
            <div class="col-md-3 mb-3">
              <label>CF</label>
              <input type="text" name="cf" class="form-control" value="<?= esc($pps['cf']) ?>">
            </div>
            <!-- Tabel Basic -->
            <h6 class="mb-3">Tabel Basic</h6>
            <!-- Button Add Row -->
            <div class="d-flex justify-content-center mb-3">
              <button type="button" id="addRow" class="btn btn-success mb-2">Add Row</button>
            </div>
           
            <div class="table-responsive mb-3">
              <table class="table table-bordered" id="tableBasic">
                <thead>
                          <tr>
                              <th width="8%">OP x OP Gang</th>
                           
                              <th width="15%">Nama Proses</th>
                              <th width="15%">Proses Gang</th>
                              <th width="6%">Qty</th>
                              <th width="15%">Estimasi Ukuran Part (p x l) (mm)</th>
                         
                              <th width="8%">Keliling</th>
                              <th width="8%">Main Pressure</th>
                              <th class="hidden-column" id="machineColumn" width="12%">Machine</th>
                              <!-- <th class="hidden-column" id="capacityColumn" width="8%">Capacity</th>
                              <th class="hidden-column" id="cushionColumn" width="8%">Cushion</th> -->
                              <th width="8%">Aksi</th>
                          </tr>
                      </thead>
                <tbody>
                  <?php if (!empty($dies)): ?>
                    <?php foreach ($dies as $index => $die): ?>
                      <tr data-index="<?= $index ?>">
                        <!-- OP: dropdown -->
                        <td>
                          <select name="dies[<?= $index ?>][process]" class="form-control basic-process mb-1" >
                            <?php foreach ($ops as $op): ?>
                              <option value="<?= $op ?>" <?= ($die['process'] == $op) ? 'selected' : '' ?>><?= $op ?></option>
                            <?php endforeach; ?>
                          </select>
                          <select name="dies[<?= $index ?>][process_join]" class="form-control ">
                            <option value="" selected>Pilih</option>
                            <?php foreach ($ops as $op): ?>
                              <option value="<?= $op ?>" <?= ($die['process_join'] == $op) ? 'selected' : '' ?>><?= $op ?></option>
                            <?php endforeach; ?>
                          </select>
                        </td>
                     
                        <!-- Proses: dropdown -->
                        <td>
                          <div class="input-proses">
                            <?php for ($i = 1; $i <= 3; $i++): ?>
                              <div class="proses-wrapper d-flex align-items-center mb-2" style="gap: 8px; width: 100%;">
                                <input
                                  type="checkbox"
                                  class="proses-checkbox"
                                  data-select-name="dies[<?= $index ?>][proses_input<?= $i ?>]"
                                  style="transform: scale(1.3); margin-right: 2px;"
                                  onchange="updateProsesHidden(this.closest('.input-proses')); togglePieInputsEditable(this.closest('tr')); updateAllRows()"
                                >
                                <label style="font-size: 14px; margin: 0;">CAM</label>
                                <select
                                  name="dies[<?= $index ?>][proses_input<?= $i ?>]"
                                  class="form-control"
                                  style="width: 100%; height: 38px; font-size: 14px;"
                                  onchange="updateProsesHidden(this.closest('.input-proses')), updateDieConstructionRow(<?= $index ?>), updateDCProcessDropdown(<?= $index ?>), togglePieInputsEditable(this.closest('tr')), updateAllRows(), calculateMainPressure(this)"
                                >
                                  <option value="">Pilih</option>
                                  <?php foreach ($prosesOptions as $p): ?>
                                    <option
                                      value="<?= $p ?>"
                                      <?= (isset($die["proses_input{$i}"]) && $die["proses_input{$i}"] === $p) ? 'selected' : '' ?>
                                    >
                                      <?= $p ?>
                                    </option>
                                  <?php endforeach; ?>
                                </select>
                              </div>
                            <?php endfor; ?>

                            <input
                              type="text"
                              readonly
                              class="form-control"
                              name="dies[<?= $index ?>][proses]"
                              value="<?= esc($die['proses']) ?>"
                              oninput="updateDCProcessDropdown(<?= $index ?>), calculateDieWeight2(this)"
                            >
                          </div>
                        </td>


                        <!-- Proses Gang: dropdown -->
                        <td>
                          <div class="input-proses-gang">
                            <?php for ($j = 1; $j <= 3; $j++): ?>
                              <div 
                                class="proses-wrapper d-flex align-items-center mb-2" 
                                style="gap: 8px; width: 100%;"
                              >
                                <input
                                  type="checkbox"
                                  class="proses-gang-checkbox"
                                  data-select-name="dies[<?= $index ?>][proses_gang_input<?= $j ?>]"
                                  style="transform: scale(1.3); margin-right: 2px;"
                                  onchange=" togglePieInputsEditable(this.closest('tr')), updateProsesGangHidden(this.closest('.input-proses-gang')), updateAllRows()"
                                  <?= (isset($die['proses_gang_input' . $j]) && $die['proses_gang_input' . $j] === 'CAM') ? 'checked' : '' ?>
                                >
                                <label style="font-size: 14px; margin: 0;">CAM</label>
                                <select
                                  name="dies[<?= $index ?>][proses_gang_input<?= $j ?>]"
                                  class="form-control"
                                  style="width: 100%; height: 38px; font-size: 14px;"
                                  onchange="updateProsesGangHidden(this.closest('.input-proses-gang')), updateDCProcessDropdown(<?= $index ?>), updateAllRows(), calculateMainPressure(this)"
                                >
                                  <option value="">Pilih</option>
                                  <?php foreach ($prosesOptions as $p): ?>
                                    <option
                                      value="<?= $p ?>"
                                      <?= (isset($die['proses_gang_input' . $j]) && $die['proses_gang_input' . $j] === $p) ? 'selected' : '' ?>
                                    >
                                      <?= $p ?>
                                    </option>
                                  <?php endforeach; ?>
                                </select>
                              </div>
                            <?php endfor; ?>

                            <input
                              type="text"
                              readonly
                              class="form-control"
                              name="dies[<?= $index ?>][proses_gang]"
                              value="<?= esc($die['proses_gang'] ?? '') ?>"
                              oninput="updateDCProcessDropdown(<?= $index ?>)"
                            >
                          </div>
                        </td>
                        <td>
                          <input type="text" name="dies[<?= $index ?>][qty_dies]" class="form-control" value="<?= esc($die['qty']) ?>">
                        </td>
                        <td>
                          <div style="width:100%;">
                            <!-- Panjang & Lebar -->
                            <div style="display: flex; margin-bottom: 5px; width: 100%; align-items: center; gap: 6px;">
                            <input
                              type="checkbox"
                              class="proses-checkbox cbPanjangLebar"
                              name="dies[<?= $index ?>][cbPanjangLebar]"
                              value="1"
                              title="Pakai Panjang + Lebar"
                              style="transform: scale(1.3);"
                              <?= (!empty($die['cbPanjangLebar']) && $die['cbPanjangLebar'] == '1') ? 'checked' : '' ?>
                                onchange="toggleManualReadonly(this.closest('tr'))"
                              >

                              <label style="font-size: 12px; margin: 0px; min-width: 25px;"></label>
                              <input
                                type="number"
                                name="dies[<?= $index ?>][panjang]"
                                placeholder="p"
                                class="form-control"
                                style="width: 40%; margin-right: 2%;"
                                value="<?= esc($die['panjang']) ?>"
                                oninput="calculateKeliling(this)"
                              >
                              <input
                                type="number"
                                name="dies[<?= $index ?>][lebar]"
                                placeholder="l"
                                class="form-control"
                                style="width: 40%;"
                                value="<?= esc($die['lebar']) ?>"
                                oninput="calculateKeliling(this)"
                              >
                            </div>

                            <!-- Panjang Proses -->
                            <div style="margin-bottom: 5px; width: 100%; display: flex; align-items: center; gap: 6px;">
                              <input
                                type="checkbox"
                                class="proses-checkbox cbPanjangProses"
                                name="dies[<?= $index ?>][cbPanjangProses]"
                                value="1"
                                style="transform: scale(1.3); margin-right: 2px;"
                                <?= (!empty($die['cbPanjangProses']) && $die['cbPanjangProses'] == '1') ? 'checked' : '' ?>
                                  onchange="toggleManualReadonly(this.closest('tr'))"
                              >

                              <label style="font-size: 12px; margin: 0px; min-width: 25px;"></label>

                              <input
                                type="number"
                                name="dies[<?= $index ?>][panjangProses]"
                                placeholder="Panjang Proses"
                                class="form-control"
                                style="width: 100%;"
                                oninput="calculateKeliling(this)"
                              >
                            </div>

                            <!-- Diameter & Jumlah Pie -->
                            <div style="display: flex; width: 100%; align-items: center; gap: 6px;">
                              <input
                                type="checkbox"
                                class="proses-checkbox cbPie"
                                name="dies[<?= $index ?>][cbPie]"
                                value="1"
                                style="transform: scale(1.3); margin-right: 2px;"
                                <?= (!empty($die['cbPie']) && $die['cbPie'] == '1') ? 'checked' : '' ?>
                                       onchange="toggleManualReadonly(this.closest('tr'))"
                              >

                              <label style="font-size: 12px; margin: 0px; min-width: 25px;"></label>
                              <input
                                type="number"
                                name="dies[<?= $index ?>][diameter]"
                                placeholder="d pie"
                                class="form-control"
                                style="width: 40%; margin-right: 2%;"
                                value="<?= esc($die['diameterPie']) ?>"
                                oninput="calculateKeliling(this)"
                         
                              >
                              <input
                                type="number"
                                name="dies[<?= $index ?>][jumlahPie]"
                                placeholder="jml pie"
                                class="form-control"
                                style="width: 40%;"
                                value="<?= esc($die['jumlahPie']) ?>"
                                oninput="calculateKeliling(this)"
                              >
                            </div>
                          </div>
                        </td>
                        <td>
                          <input type="number" name="dies[<?= $index ?>][length_mp]" class="form-control" value="<?= esc($die['length_mp']) ?>" oninput="calculateMainPressure(this)" readonly>
                        </td>
                        <td>
                          <input type="number" name="dies[<?= $index ?>][main_pressure]" class="form-control" value="<?= esc($die['main_pressure']) ?>" readonly>
                        </td>
                        <!-- Machine -->
                        <td>
                        <div style="width:100%;">
                          <!-- Mesin (full width) -->
                          <div style="margin-bottom:5px; width:100%;">
                            <select
                              name="dies[<?= $index ?>][machine]"
                              class="form-control basic-machine"
                              style="width:100%; height:38px; font-size:14px;"
                              onchange="onMachineChange(this); updateDieConstructionRow(this.closest('tr').getAttribute('data-index')); updateDCProcessDropdown(<?= $index ?>); calculateDieWeight2(this); calculateTotalMP();"
                            >
                              <?php foreach ($machineOptions as $option): ?>
                                <option
                                  value="<?= esc($option) ?>"
                                  <?= ($die['machine'] === $option) ? 'selected' : '' ?>
                                >
                                  <?= esc($option) ?>
                                </option>
                              <?php endforeach; ?>
                            </select>
                          </div>

                          <!-- Capacity & Cushion (side by side) -->
                          <div style="display:flex; width:100%;">
                            <input
                              type="text"
                              name="dies[<?= $index ?>][capacity]"
                              class="form-control"
                              style="width:48%; margin-right:4%;"
                              value="<?= esc($die['capacity']) ?>"
                              readonly
                            >
                            <input
                              type="text"
                              name="dies[<?= $index ?>][cushion]"
                              class="form-control"
                              style="width:48%;"
                              value="<?= esc($die['cushion']) ?>"
                              readonly
                            >
                          </div>
                        </div>
                      </td>

                        <td>
                          <button type="button" class="btn btn-danger deleteRow">Hapus</button>
                        </td>
                      </tr>
                    <?php endforeach; ?>
                  <?php else: ?>
                    <tr data-index="0">
                      <td>
                        <select name="dies[0][process]" class="form-control basic-process mb-1">
                          <?php foreach ($ops as $op): ?>
                            <option value="<?= $op ?>"><?= $op ?></option>
                          <?php endforeach; ?>
                        </select>
                        <select name="dies[0][process_join]" class="form-control">
                          <?php foreach ($ops as $op): ?>
                            <option value="<?= $op ?>"><?= $op ?></option>
                          <?php endforeach; ?>
                        </select>
                      </td>
                      <td>
                        <div class="input-proses">
                          <!-- Dropdown 1 + Checkbox CAM -->
                          <div class="proses-wrapper d-flex align-items-center mb-2" style="gap: 8px; width: 100%;">
                            <input
                              type="checkbox"
                              class="proses-checkbox"
                              data-select-name="dies[0][proses_input1]"
                              style="transform: scale(1.3); margin-right: 2px;"
                              onchange="updateProsesHidden(this.closest('.input-proses')), updateDCProcessDropdown(0), calculateMainPressure(this)"
                            >
                            <label style="font-size: 14px; margin: 0;">CAM</label>
                            <select
                              name="dies[0][proses_input1]"
                              class="form-control"
                              style="width: 100%; height: 38px; font-size: 14px;"
                              onchange="updateProsesHidden(this.closest('.input-proses')), updateDCProcessDropdown(0), calculateMainPressure(this)"
                            >
                              <option value="">Pilih</option>
                              <?php foreach ($prosesOptions as $p): ?>
                                <option value="<?= $p ?>"><?= $p ?></option>
                              <?php endforeach; ?>
                            </select>
                          </div>

                          <!-- Dropdown 2 + Checkbox CAM -->
                          <div class="proses-wrapper d-flex align-items-center mb-2" style="gap: 8px; width: 100%;">
                            <input
                              type="checkbox"
                              class="proses-checkbox"
                              data-select-name="dies[0][proses_input2]"
                              style="transform: scale(1.3); margin-right: 2px;"
                              onchange="updateProsesHidden(this.closest('.input-proses')), updateDCProcessDropdown(0)"
                            >
                            <label style="font-size: 14px; margin: 0;">CAM</label>
                            <select
                              name="dies[0][proses_input2]"
                              class="form-control"
                              style="width: 100%; height: 38px; font-size: 14px;"
                              onchange="updateProsesHidden(this.closest('.input-proses')), updateDCProcessDropdown(0), calculateMainPressure(this)"
                            >
                              <option value="">Pilih</option>
                              <?php foreach ($prosesOptions as $p): ?>
                                <option value="<?= $p ?>"><?= $p ?></option>
                              <?php endforeach; ?>
                            </select>
                          </div>

                          <!-- Dropdown 3 + Checkbox CAM -->
                          <div class="proses-wrapper d-flex align-items-center mb-2" style="gap: 8px; width: 100%;">
                            <input
                              type="checkbox"
                              class="proses-checkbox"
                              data-select-name="dies[0][proses_input3]"
                              style="transform: scale(1.3); margin-right: 2px;"
                              onchange="updateProsesHidden(this.closest('.input-proses')), updateDCProcessDropdown(0)"
                            >
                            <label style="font-size: 14px; margin: 0;">CAM</label>
                            <select
                              name="dies[0][proses_input3]"
                              class="form-control"
                              style="width: 100%; height: 38px; font-size: 14px;"
                              onchange="updateProsesHidden(this.closest('.input-proses')), updateDCProcessDropdown(0)"
                            >
                              <option value="">Pilih</option>
                              <?php foreach ($prosesOptions as $p): ?>
                                <option value="<?= $p ?>"><?= $p ?></option>
                              <?php endforeach; ?>
                            </select>
                          </div>

                          <input
                            type="text"
                            name="dies[0][proses]"
                            class="form-control"
                            readonly
                            oninput="updateDCProcessDropdown(0), calculateDieWeight2(this)"
                          >
                        </div>
                      </td>

                      <td>
                        <div class="input-proses-gang">
                          <!-- Dropdown 1 + Checkbox CAM -->
                          <div class="proses-wrapper d-flex align-items-center mb-2" style="gap: 8px; width: 100%;">
                            <input
                              type="checkbox"
                              class="proses-gang-checkbox"
                              data-select-name="dies[0][proses_gang_input1]"
                              style="transform: scale(1.3); margin-right: 2px;"
                              onchange="updateProsesGangHidden(this.closest('.input-proses-gang')), updateDCProcessDropdown(0)"
                            >
                            <label style="font-size: 14px; margin: 0;">CAM</label>
                            <select
                              name="dies[0][proses_gang_input1]"
                              class="form-control"
                              style="width: 100%; height: 38px; font-size: 14px;"
                              onchange="updateProsesGangHidden(this.closest('.input-proses-gang')), updateDCProcessDropdown(0)"
                            >
                              <option value="">Pilih</option>
                              <?php foreach ($prosesOptions as $p): ?>
                                <option value="<?= $p ?>"><?= $p ?></option>
                              <?php endforeach; ?>
                            </select>
                          </div>

                          <!-- Dropdown 2 + Checkbox CAM -->
                          <div class="proses-wrapper d-flex align-items-center mb-2" style="gap: 8px; width: 100%;">
                            <input
                              type="checkbox"
                              class="proses-gang-checkbox"
                              data-select-name="dies[0][proses_gang_input2]"
                              style="transform: scale(1.3); margin-right: 2px;"
                              onchange="updateProsesGangHidden(this.closest('.input-proses-gang')), updateDCProcessDropdown(0),calculateMainPressure(this)"
                            >
                            <label style="font-size: 14px; margin: 0;">CAM</label>
                            <select
                              name="dies[0][proses_gang_input2]"
                              class="form-control"
                              style="width: 100%; height: 38px; font-size: 14px;"
                              onchange="updateProsesGangHidden(this.closest('.input-proses-gang')), updateDCProcessDropdown(0), calculateMainPressure(this)"
                            >
                              <option value="">Pilih</option>
                              <?php foreach ($prosesOptions as $p): ?>
                                <option value="<?= $p ?>"><?= $p ?></option>
                              <?php endforeach; ?>
                            </select>
                          </div>

                          <!-- Dropdown 3 + Checkbox CAM -->
                          <div class="proses-wrapper d-flex align-items-center mb-2" style="gap: 8px; width: 100%;">
                            <input
                              type="checkbox"
                              class="proses-gang-checkbox"
                              data-select-name="dies[0][proses_gang_input3]"
                              style="transform: scale(1.3); margin-right: 2px;"
                              onchange="updateProsesGangHidden(this.closest('.input-proses-gang')), updateDCProcessDropdown(0)"
                            >
                            <label style="font-size: 14px; margin: 0;">CAM</label>
                            <select
                              name="dies[0][proses_gang_input3]"
                              class="form-control"
                              style="width: 100%; height: 38px; font-size: 14px;"
                              onchange="updateProsesGangHidden(this.closest('.input-proses-gang')), updateDCProcessDropdown(0)"
                            >
                              <option value="">Pilih</option>
                              <?php foreach ($prosesOptions as $p): ?>
                                <option value="<?= $p ?>"><?= $p ?></option>
                              <?php endforeach; ?>
                            </select>
                          </div>

                          <input
                            type="text"
                            name="dies[0][proses_gang]"
                            class="form-control"
                            readonly
                            oninput="updateDCProcessDropdown(0)"
                          >
                        </div>
                      </td>

                      <td>
                        <input type="text" name="dies[0][qty_dies]" class="form-control" >
                      </td>
                      <td>
                        <div style="width: 100%;">
                          <!-- Baris Panjang & Lebar -->
                          <div style="display: flex; margin-bottom: 5px; width: 100%; align-items: center; gap: 6px;">
                          <input
                              type="checkbox"
                              class="proses-checkbox cbPanjangLebar"
                              name="dies[0][cbPanjangLebar]"
                              value="1"
                              title="Pakai Panjang + Lebar"
                              style="transform: scale(1.3);"
                              <?= (!empty($die['cbPanjangLebar']) && $die['cbPanjangLebar'] == '1') ? 'checked' : '' ?>
                                onchange="toggleManualReadonly(this.closest('tr'))"
                            >
                            <label style="font-size: 12px; margin: 0px; min-width: 25px;"></label>
                            <input
                              type="number"
                              name="dies[0][panjang]"
                              placeholder="p"
                              class="form-control"
                              style="width: 40%; margin-right: 2%;"
                              oninput="calculateKeliling(this)"
                            >
                            <input
                              type="number"
                              name="dies[0][lebar]"
                              placeholder="l"
                              class="form-control"
                              style="width: 40%;"
                              oninput="calculateKeliling(this)"
                            >
                          </div>

                          <!-- Baris Panjang Proses -->
                          <div style="margin-bottom: 5px; width: 100%; display: flex; align-items: center; gap: 6px;">
                          <input
                                type="checkbox"
                                class="proses-checkbox cbPanjangProses"
                                name="dies[0][cbPanjangProses]"
                                value="1"
                                style="transform: scale(1.3); margin-right: 2px;"
                            
                                  onchange="toggleManualReadonly(this.closest('tr'))"
                              >
                            <label style="font-size: 12px; margin: 0px; min-width: 25px;"></label>
                            <input
                              type="number"
                              name="dies[0][panjangProses]"
                              placeholder="Panjang Proses"
                              class="form-control"
                              style="width: 100%;"
                            >
                          </div>

                          <!-- Baris Diameter & Jumlah Pie -->
                          <div style="display: flex; width: 100%; align-items: center; gap: 6px;">
                           <input
                                type="checkbox"
                                class="proses-checkbox cbPie"
                                name="dies[0][cbPie]"
                                value="1"
                                style="transform: scale(1.3); margin-right: 2px;"
                           
                                       onchange="toggleManualReadonly(this.closest('tr'))"
                              >
                            <label style="font-size: 12px; margin: 0px; min-width: 25px;"></label>
                            <input
                              type="number"
                              name="dies[0][diameter]"
                              placeholder="d pie"
                              class="form-control"
                              readonly
                              style="width: 40%; margin-right: 2%;"
                            >
                            <input
                              type="number"
                              name="dies[0][jumlahPie]"
                              placeholder="jml pie"
                              class="form-control"
                              readonly
                              style="width: 40%;"
                            >
                          </div>
                        </div>
                      </td>

                      
                      <td>
                      <input type="number" name="dies[0][length_mp]" class="form-control" oninput="calculateMainPressure(this)" readonly>
                      </td>
                      <td>
                        <input type="text" name="dies[0][main_pressure]" class="form-control" readonly>
                      </td>
                      <td>
                        <div style="width:100%;">
                          <!-- Mesin (full width) -->
                          <div style="margin-bottom:5px; width:100%;">
                            <select
                              name="dies[0][machine]"
                              class="form-control basic-machine"
                              style="width:100%; height:38px; font-size:14px;"
                              onchange="onMachineChange(this); updateDieConstructionRow(this.closest('tr').getAttribute('data-index')); updateDCProcessDropdown(0); calculateDieWeight2(this); calculateTotalMP();"
                            >
                              <?php foreach ($machineOptions as $option): ?>
                                <option value="<?= esc($option) ?>"><?= esc($option) ?></option>
                              <?php endforeach; ?>
                            </select>
                          </div>

                          <!-- Capacity & Cushion (side by side) -->
                          <div style="display:flex; width:100%;">
                            <input
                              type="text"
                              name="dies[0][capacity]"
                              class="form-control"
                              readonly
                              style="width:48%; margin-right:4%;"
                            >
                            <input
                              type="text"
                              name="dies[0][cushion]"
                              class="form-control"
                              readonly
                              style="width:48%;"
                            >
                          </div>
                        </div>
                      </td>

                      <td>
                        <button type="button" class="btn btn-danger deleteRow">Hapus</button>
                      </td>
                    </tr>
                  <?php endif; ?>
                </tbody>
              </table>
            </div>
            <div class="d-flex justify-content-center mb-3">
              <button type="button" class="btn btn-secondary ms-2" onclick="showMachineMatchModal()">List Match Machine</button>
            </div>
            <div class="card p-3 mb-3">
              <h6 class="mb-3">Die Sizing Standar</h6>
              <li>Tabel berikut diisi otomatis oleh sistem namun ilahkan lakukan perubahan data apabila kolom yang terisi tidak sesuai dengan kebutuhan</li>
              <li>Apabila ingin melihat bagaimana sistem melakukan pengisian data, Klik Petunjuk di atas halaman</li>
              <div class="table-responsive">
                <table class="table table-bordered" id="tableDie">
                  <thead>
                    <tr>
                      <th style="width: 9%">Process</th>
                      <th style="width: 30%">Standar Die Design</th>
                      <th style="width: 20%">Die Size (LxWxH)</th>
                      <!-- <th>Die Size (W)</th>
                      <th>Die Size (H)</th> -->
                      <th style="width: 16%">Casting/Plate</th>
                      <th style="width: 16%">Die Weight</th>
                      <th style="width: 14%">Die Class</th>
                    </tr>
                  </thead>
                  <tbody>
                    <?php if (!empty($dies)): ?>
                      <?php foreach ($dies as $index => $die): ?>
                        <tr data-index="<?= $index ?>">
                          <!-- Process mengikuti Basic -->
                          <td>
                            <input type="text" name="dies[<?= $index ?>][process]" class="form-control die-process" readonly value="<?= esc($die['process']) ?>">
                          </td>
                          <td>
                            <select name="dies[<?= $index ?>][dc_process]" class="form-control" onchange="onStandardChange(this)">
                              <option value="BIG DIE|SINGLE|DRAW" <?= ($die['dc_process'] == "BIG DIE|SINGLE|DRAW") ? 'selected' : '' ?>>BIG DIE, SINGLE, DRAW</option>
                              <option value="BIG DIE|SINGLE|DEEP DRAW" <?= ($die['dc_process'] == "BIG DIE|SINGLE|DEEP DRAW") ? 'selected' : '' ?>>BIG DIE, SINGLE, DEEP DRAW</option>
                              <option value="BIG DIE|SINGLE|TRIM" <?= ($die['dc_process'] == "BIG DIE|SINGLE|TRIM") ? 'selected' : '' ?>>BIG DIE, SINGLE, TRIM</option>
                              <option value="BIG DIE|SINGLE|FLANGE" <?= ($die['dc_process'] == "BIG DIE|SINGLE|FLANGE") ? 'selected' : '' ?>>BIG DIE, SINGLE, FLANGE</option>
                              <option value="BIG DIE|SINGLE|CAM FLANGE" <?= ($die['dc_process'] == "BIG DIE|SINGLE|CAM FLANGE") ? 'selected' : '' ?>>BIG DIE, SINGLE, CAM FLANGE</option>
                              <option value="MEDIUM DIE|SINGLE|DRAW" <?= ($die['dc_process'] == "MEDIUM DIE|SINGLE|DRAW") ? 'selected' : '' ?>>MEDIUM DIE, SINGLE, DRAW</option>
                              <option value="MEDIUM DIE|SINGLE|TRIM" <?= ($die['dc_process'] == "MEDIUM DIE|SINGLE|TRIM") ? 'selected' : '' ?>>MEDIUM DIE, SINGLE, TRIM</option>
                              <option value="MEDIUM DIE|SINGLE|FLANGE" <?= ($die['dc_process'] == "MEDIUM DIE|SINGLE|FLANGE") ? 'selected' : '' ?>>MEDIUM DIE, SINGLE, FLANGE</option>
                              <option value="MEDIUM DIE|SINGLE|CAM PIE" <?= ($die['dc_process'] == "MEDIUM DIE|SINGLE|CAM PIE") ? 'selected' : '' ?>>MEDIUM DIE, SINGLE, CAM PIE</option>
                              <option value="MEDIUM DIE|GANG|DRAW" <?= ($die['dc_process'] == "MEDIUM DIE|GANG|DRAW") ? 'selected' : '' ?>>MEDIUM DIE, GANG, DRAW</option>
                              <option value="MEDIUM DIE|GANG|TRIM" <?= ($die['dc_process'] == "MEDIUM DIE|GANG|TRIM") ? 'selected' : '' ?>>MEDIUM DIE, GANG, TRIM</option>
                              <option value="MEDIUM DIE|GANG|FLANGE-CAM PIE" <?= ($die['dc_process'] == "MEDIUM DIE|GANG|FLANGE-CAM PIE") ? 'selected' : '' ?>>MEDIUM DIE, GANG, FLANGE-CAM PIE</option>
                              <option value="SMALL DIE|SINGLE|BLANK" <?= ($die['dc_process'] == "SMALL DIE|SINGLE|BLANK") ? 'selected' : '' ?>>SMALL DIE, SINGLE, BLANK</option>
                              <option value="SMALL DIE|SINGLE|FORMING" <?= ($die['dc_process'] == "SMALL DIE|SINGLE|FORMING") ? 'selected' : '' ?>>SMALL DIE, SINGLE, FORMING</option>
                              <option value="SMALL DIE|SINGLE|CAM PIE" <?= ($die['dc_process'] == "SMALL DIE|SINGLE|CAM PIE") ? 'selected' : '' ?>>SMALL DIE, SINGLE, CAM PIE</option>
                              <option value="SMALL DIE|GANG|FORM-FLANGE" <?= ($die['dc_process'] == "SMALL DIE|GANG|FORM-FLANGE") ? 'selected' : '' ?>>SMALL DIE, GANG, FORM-FLANGE</option>
                              <option value="SMALL DIE|GANG|BEND 1, BEND 2" <?= ($die['dc_process'] == "SMALL DIE|GANG|BEND 1, BEND 2") ? 'selected' : '' ?>>SMALL DIE, GANG, BEND 1, BEND 2</option>
                              <option value="SMALL DIE|GANG|FORMING, PIE" <?= ($die['dc_process'] == "SMALL DIE|GANG|FORMING, PIE") ? 'selected' : '' ?>>SMALL DIE, GANG, FORMING, PIE</option>
                              <option value="SMALL DIE|PROGRESSIVE|BLANK-PIE" <?= ($die['dc_process'] == "SMALL DIE|PROGRESSIVE|BLANK-PIE") ? 'selected' : '' ?>>SMALL DIE, PROGRESSIVE, BLANK-PIE</option>
                            </select>
                          </td>

                          <td >
                              <input type="text" name="dies[<?= $index ?>][die_length]" class="form-control d-inline-block" style="margin-left: 5px; margin-right: 5px; width: 30%;" value="<?= esc($die['die_length']) ?>" readonly>
                              <input type="text" name="dies[<?= $index ?>][die_width]" class="form-control d-inline-block" style="margin-right: 5px; width: 30%;" value="<?= esc($die['die_width']) ?>" readonly>
                              <input type="text" name="dies[<?= $index ?>][die_height]" class="form-control d-inline-block" style="margin-right: 5px; width: 30%;" value="<?= esc($die['die_height']) ?>" readonly>
                      
                          </td>

                         
                          <td>
                              <select name="dies[<?= $index ?>][casting_plate]" class="form-control" onchange="calculateDieWeight(this),  updateDieConstructionRow(this.closest('tr').getAttribute('data-index'))">
                                  <option value="casting" <?= ($die['casting_plate'] == "casting") ? 'selected' : '' ?>>Casting</option>
                                  <option value="plate" <?= ($die['casting_plate'] == "plate") ? 'selected' : '' ?>>Plate</option>
                              </select>
                          </td>
                          <td>
                            <input type="text" name="dies[<?= $index ?>][die_weight]" class="form-control" value="<?= esc($die['die_weight']) ?>" readonly>
                          </td>
                          <td>
                            <select name="dies[<?= $index ?>][die_class]" class="form-control" >
                              <option value="">Pilih</option>
                              <?php foreach (range('A', 'F') as $letter): ?>
                                <option value="<?= $letter ?>" <?= ($letter == $die['class']) ? 'selected' : '' ?>><?= $letter ?></option>
                              <?php endforeach; ?>
                            </select>
                          </td>



                          </td>
                        </tr>
                      <?php endforeach; ?>
                      <?php else: ?>
                        <?php $index = 0; ?> <!-- Definisikan index terlebih dahulu -->
                        <tr data-index="<?= $index ?>">
                          <td>
                            <input type="text" name="dies[<?= $index ?>][process]" class="form-control die-process" readonly>
                          </td>
                          <td>
                            <select name="dies[<?= $index ?>][dc_process]" class="form-control">
                              <option value="BIG DIE|SINGLE|DRAW">BIG DIE, SINGLE, DRAW</option>
                              <option value="BIG DIE|SINGLE|DEEP DRAW">BIG DIE, SINGLE, DEEP DRAW</option>
                              <option value="BIG DIE|SINGLE|TRIM">BIG DIE, SINGLE, TRIM</option>
                              <option value="BIG DIE|SINGLE|FLANGE">BIG DIE, SINGLE, FLANGE</option>
                              <option value="BIG DIE|SINGLE|CAM FLANGE">BIG DIE, SINGLE, CAM FLANGE</option>
                              <option value="MEDIUM DIE|SINGLE|DRAW">MEDIUM DIE, SINGLE, DRAW</option>
                              <option value="MEDIUM DIE|SINGLE|TRIM">MEDIUM DIE, SINGLE, TRIM</option>
                              <option value="MEDIUM DIE|SINGLE|FLANGE">MEDIUM DIE, SINGLE, FLANGE</option>
                              <option value="MEDIUM DIE|SINGLE|CAM PIE">MEDIUM DIE, SINGLE, CAM PIE</option>
                              <option value="MEDIUM DIE|GANG|DRAW">MEDIUM DIE, GANG, DRAW</option>
                              <option value="MEDIUM DIE|GANG|TRIM">MEDIUM DIE, GANG, TRIM</option>
                              <option value="MEDIUM DIE|GANG|FLANGE-CAM PIE">MEDIUM DIE, GANG, FLANGE-CAM PIE</option>
                              <option value="SMALL DIE|SINGLE|BLANK">SMALL DIE, SINGLE, BLANK</option>
                              <option value="SMALL DIE|SINGLE|FORMING">SMALL DIE, SINGLE, FORMING</option>
                              <option value="SMALL DIE|SINGLE|CAM PIE">SMALL DIE, SINGLE, CAM PIE</option>
                              <option value="SMALL DIE|GANG|FORM-FLANGE">SMALL DIE, GANG, FORM-FLANGE</option>
                              <option value="SMALL DIE|GANG|BEND 1, BEND 2">SMALL DIE, GANG, BEND 1, BEND 2</option>
                              <option value="SMALL DIE|GANG|FORMING, PIE">SMALL DIE, GANG, FORMING, PIE</option>
                              <option value="SMALL DIE|PROGRESSIVE|BLANK-PIE">SMALL DIE, PROGRESSIVE, BLANK-PIE</option>
                            </select>
                          </td>
                          <td >
                              <input type="text" name="dies[<?= $index ?>][die_length]" class="form-control d-inline-block" style="margin-left: 5px; margin-right: 5px; width: 30%;" readonly>
                              <input type="text" name="dies[<?= $index ?>][die_width]" class="form-control d-inline-block" style="margin-right: 5px; width: 30%;" readonly>
                              <input type="text" name="dies[<?= $index ?>][die_height]" class="form-control d-inline-block" style="margin-right: 5px; width: 30%;" readonly>
                          
                          </td>

                         
                          <td>
                            <select name="dies[<?= $index ?>][casting_plate]" class="form-control" onchange="calculateDieWeight(this), updateDieConstructionRow(this.closest('tr').getAttribute('data-index'))">
                              <option value="casting">Casting</option>
                              <option value="plate">Plate</option>
                            </select>
                          </td>
                          <td>
                            <input type="text" name="dies[<?= $index ?>][die_weight]" class="form-control">
                          </td>

                          <td>
                            <select name="dies[<?= $index ?>][die_class]" class="form-control">
                              <option value="">Pilih</option>
                              <option value="A">A</option>
                              <option value="B">B</option>
                              <option value="C">C</option>
                              <option value="D">D</option>
                              <option value="E">E</option>
                              <option value="F">F</option>
                            </select>
                          </td>

                        </tr>
                      <?php endif; ?>

                  </tbody>
                </table>
              </div>
            </div>

            <div class="modal fade" id="machineMatchModal" tabindex="-1">
              <div class="modal-dialog modal-xl">
                <div class="modal-content">
                  <div class="modal-header">
                    <h5 class="modal-title">Machine Match List</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                  </div>
                  <div class="modal-body">
                    <ul class="nav nav-tabs" id="pressureTabs" role="tablist">
                      <!-- Diisi oleh JS -->
                    </ul>
                    <div class="tab-content mt-3" id="pressureTabContent">
                      <!-- Diisi oleh JS -->
                    </div>
                  </div>
                </div>
              </div>
            </div>
            <!-- Tabel Press M/C Spec -->
            <div class="card p-3 mb-3">
              <h5>Press M/C Spec</h5>
              <li>Apabila Ada kesalahan/master data yang kurang sesuai bisa dilakukan perubaan di Menu Master Data DCP PPS -> PPS -> MC Spec</li>
              <div class="table-responsive">
                <table class="table table-bordered" id="tablePress">
                  <thead>
                    <tr>
                      <th>Machine</th>
                      <th>Bolster Area L</th>
                      <th>Bolster Area W</th>
                      <th>Slide Area L</th>
                      <th>Slide Area W</th>
                      <th>Slide Stroke</th>
                      <th>Die Height</th>
                      <th>Cushion Pad L</th>
                      <th>Cushion Pad W</th>
                      <th>Cushion Stroke</th>
                    </tr>
                  </thead>
                  <tbody>
                    <?php if (!empty($dies)): ?>
                      <?php foreach ($dies as $index => $die): ?>
                        <tr data-index="<?= $index ?>">
                          <!-- Machine: readonly, mengikuti dropdown basic -->
                          <td>
                            <input type="text" name="dies[<?= $index ?>][machine]" class="form-control press-machine"  value="<?= esc($die['machine']) ?>" readonly >
                          </td>
                          <td>
                            <input type="text" name="dies[<?= $index ?>][bolster_length]" class="form-control" value="<?= esc($die['bolster_length']) ?>" readonly>
                          </td>
                          <td>
                            <input type="text" name="dies[<?= $index ?>][bolster_width]" class="form-control" value="<?= esc($die['bolster_width']) ?>" readonly>
                          </td>
                          <td>
                            <input type="text" name="dies[<?= $index ?>][slide_area_length]" class="form-control" value="<?= esc($die['slide_area_length']) ?>" readonly>
                          </td>
                          <td>
                            <input type="text" name="dies[<?= $index ?>][slide_area_width]" class="form-control" value="<?= esc($die['slide_area_width']) ?>" readonly>
                          </td>
                          <td>
                            <input type="text" name="dies[<?= $index ?>][slide_stroke]" class="form-control" value="<?= esc($die['slide_stroke']) ?>" readonly>
                          </td>
                          <td>
                            <input type="text" name="dies[<?= $index ?>][die_height_max]" class="form-control" value="<?= esc($die['die_height_max']) ?>" readonly>
                          </td>
                          <td>
                            <input type="text" name="dies[<?= $index ?>][cushion_pad_length]" class="form-control" value="<?= esc($die['cushion_pad_length']) ?>" readonly>
                          </td>
                          
                          <td>
                            <input type="text" name="dies[<?= $index ?>][cushion_pad_width]" class="form-control" value="<?= esc($die['cushion_pad_width']) ?>" readonly>
                          </td>
                          <td>
                            <input type="text" name="dies[<?= $index ?>][cushion_stroke]" class="form-control" value="<?= esc($die['cushion_stroke']) ?>" readonly>
                          </td>
                        </tr>
                      <?php endforeach; ?>
                    <?php else: ?>
                      <tr data-index="0">
                        <td>
                          <input type="text" name="dies[0][machine]" class="form-control press-machine" readonly>
                        </td>
                        <td>
                          <input type="text" name="dies[0][bolster_length]" class="form-control" readonly>
                        </td>
                        <td>
                          <input type="text" name="dies[0][bolster_width]" class="form-control" readonly>
                        </td>
                        <td>
                          <input type="text" name="dies[0][slide_area_length]" class="form-control" readonly>
                        </td>
                        <td>
                          <input type="text" name="dies[0][slide_area_width]" class="form-control" readonly>
                        </td>
                        <td>
                          <input type="text" name="dies[0][slide_stroke]" class="form-control" readonly>
                        </td>
                        <td>
                          <input type="text" name="dies[0][die_height_max]" class="form-control" readonly>
                        </td>
                        <td>
                          <input type="text" name="dies[0][cushion_pad_length]" class="form-control" readonly>
                        </td>
                        <td>
                          <input type="text" name="dies[0][cushion_pad_width]" class="form-control" readonly>
                        </td>
                        <td>
                          <input type="text" name="dies[0][cushion_stroke]" class="form-control" readonly>
                        </td>
                      </tr>
                    <?php endif; ?>
                  </tbody>
                </table>
              </div>
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
          <div class="text-left mb-2">
              <button type="button" class="btn btn-info btn-sm" data-toggle="modal" data-target="#dieConstructionHintModal">
                  <i class="fa fa-lightbulb-o" aria-hidden="true"></i> Petunjuk
              </button>
          </div>

          <div class="modal fade" id="dieConstructionHintModal" tabindex="-1" role="dialog" aria-labelledby="dieConstructionHintModalLabel" aria-hidden="true">
              <div class="modal-dialog modal-lg" role="document">
                  <div class="modal-content">
                     
                      <div class="modal-header">
                          <h5 class="modal-title" id="dieConstructionHintModalLabel">Logika Sistem untuk Die Construction</h5>
                          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                              <span aria-hidden="true">&times;</span>
                          </button>
                      </div>
                      <div class="modal-body">
                          <h6><b>1. Penjelasan Die Construction</b></h6>
                          <img src="<?= base_url('assets/images/DiesConfiguration.png') ?>" alt="Dies Construction" class="img-fluid mb-3">
                          <p>Dies Configuration digunakan untuk mengisi <b>PRESS M/C SPEC</b> dan <b>PROCESS DETAIL</b> yang akan ditempelkan pada bagian Excel seperti pada gambar di atas.</p>

                          <hr>

                          <h6><b>2. Pemilihan Material pada Die Construction</b></h6>
                          <ul>
                              <li>Bagian <b>Upper & Lower Die</b> menggunakan material <b>SS41</b> jika <b>Die Plate</b>, sedangkan <b>Die Casting</b> menggunakan <b>FC300</b>.</li>
                              <li>Bagian <b>Pad</b> menggunakan material <b>S45C</b> untuk <b>Die Plate</b>, dan <b>FCD55</b> untuk <b>Die Casting</b>.</li>
                              <li>Bagian <b>Pad Lifter</b> menggunakan <b>Coil Spring</b> jika prosesnya melibatkan <b>FL, DR, BE, RE, atau FO</b>, sedangkan proses lainnya menggunakan <b>Gas Spring</b>.</li>
                              <li>Bagian <b>Sliding</b> selalu menggunakan <b>Wear Plate</b>.</li>
                              <li>Bagian <b>Guide</b> menggunakan <b>Guide Post</b> jika <b>Die Plate</b> dan proses melibatkan <b>BL, CUT, atau TR</b>. Selain itu, maka menggunakan <b>GUIDE HEEL</b>.</li>
                          </ul>

                          <hr>

                          <h6><b>3. Pemilihan Insert dan Heat Treatment</b></h6>
                          <ul>
                              <li>Jika material lebih dari <b>440 MPa</b> dan tonase lebih dari <b>1 ton</b>, maka insert menggunakan <b>SKD11</b>.</li>
                              <li>Proses seperti <b>FL, DR, BE, RE, dan FO</b> menggunakan insert <b>SXACE</b>, sementara <b>PI</b> menggunakan <b>S45C</b>.</li>
                              <li>Proses seperti <b>BL, TR, SEP, dan CUT</b> menggunakan <b>SKD11</b>.</li>
                              <li>Insert <b>SXACE</b> mendapatkan perlakuan <b>FULL HARD + COATING</b>, sementara lainnya menggunakan <b>FLAME HARDENING</b>.</li>
                          </ul>

                          <hr>

                          <h6><b>4. Output Tabel Configuration</b></h6>
                          <p>Output yang ditampilkan pada tabel configuration hanya sebagai <b>rekomendasi</b> dan dapat disesuaikan dengan kondisi yang dibutuhkan.</p>

                          <hr>

                          <h6><b>5. Upload Gambar</b></h6>
                          <p>Fitur upload gambar bersifat <b>opsional</b> dan tidak wajib diisi melalui program jika lebih mudah dilakukan melalui Excel.</p>
                      </div>
                  </div>
              </div>
          </div>
          <div class="card p-3 mb-3">
            <h5>Die Construction</h5>
            <div class="table-responsive">
              <table class="table table-bordered" id="tableDieConstruction">
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
                  <?php
                    $upperLowerOptions = ['FC300', 'FCD55', 'S45C', 'SS41', 'TGC600'];
                    $padOptions = ['FCD55','FC300', 'S45C', 'SKD11', 'HMD5', 'SXACE'];
                    $padLifterOptions = ['Coil Spring', 'Cushion', 'Gas Spring'];
                    $slidingOptions = ['Stripper Bolt', 'Wear Plate'];
                    $guideOptions = ['Guide Heel', 'Guide Post'];
                    $insertOptions = ['HMD5', 'S45C', 'SKD11', 'SLDM', 'SX105V', 'SXACE'];
                    $heatTreatmentOptions = ['FLAMEHARD', 'FULLHARD', 'FULLHARD + COATING', 'HARD CHROME'];
                  ?>

                  <?php if (!empty($dies)): ?>
                    <?php foreach ($dies as $index => $die): ?>
                      <tr data-index="<?= $index ?>">
                        <td>
                          <input type="text" name="dies[<?= $index ?>][proses]" class="form-control" readonly value="<?= esc($die['proses']) ?>">
                        </td>
                        <td>
                          <input type="text" name="dies[<?= $index ?>][machine]" class="form-control" readonly value="<?= esc($die['machine']) ?>">
                        </td>

                        <!-- Dropdowns with "Pilih" option -->
                        <td>
                          <select name="dies[<?= $index ?>][upper]" class="form-control">
                            <option value="null" <?= $die['upper'] === null ? 'selected' : '' ?>>Pilih</option>
                            <?php foreach ($upperLowerOptions as $opt): ?>
                              <option value="<?= $opt ?>" <?= $die['upper'] === $opt ? 'selected' : '' ?>><?= $opt ?></option>
                            <?php endforeach; ?>
                          </select>
                        </td>
                        <td>
                          <select name="dies[<?= $index ?>][lower]" class="form-control">
                            <option value="null" <?= $die['lower'] === null ? 'selected' : '' ?>>Pilih</option>
                            <?php foreach ($upperLowerOptions as $opt): ?>
                              <option value="<?= $opt ?>" <?= $die['lower'] === $opt ? 'selected' : '' ?>><?= $opt ?></option>
                            <?php endforeach; ?>
                          </select>
                        </td>
                        <td>
                          <select name="dies[<?= $index ?>][pad]" class="form-control">
                            <option value="null" <?= $die['pad'] === null ? 'selected' : '' ?>>Pilih</option>
                            <?php foreach ($padOptions as $opt): ?>
                              <option value="<?= $opt ?>" <?= $die['pad'] === $opt ? 'selected' : '' ?>><?= $opt ?></option>
                            <?php endforeach; ?>
                          </select>
                        </td>
                        <td>
                          <select name="dies[<?= $index ?>][pad_lifter]" class="form-control">
                            <option value="null" <?= $die['pad_lifter'] === null ? 'selected' : '' ?>>Pilih</option>
                            <?php foreach ($padLifterOptions as $opt): ?>
                              <option value="<?= $opt ?>" <?= $die['pad_lifter'] === $opt ? 'selected' : '' ?>><?= $opt ?></option>
                            <?php endforeach; ?>
                          </select>
                        </td>
                        <td>
                          <select name="dies[<?= $index ?>][sliding]" class="form-control">
                            <option value="null" <?= $die['sliding'] === null ? 'selected' : '' ?>>Pilih</option>
                            <?php foreach ($slidingOptions as $opt): ?>
                              <option value="<?= $opt ?>" <?= $die['sliding'] === $opt ? 'selected' : '' ?>><?= $opt ?></option>
                            <?php endforeach; ?>
                          </select>
                        </td>
                        <td>
                          <select name="dies[<?= $index ?>][guide]" class="form-control">
                            <option value="null" <?= $die['guide'] === null ? 'selected' : '' ?>>Pilih</option>
                            <?php foreach ($guideOptions as $opt): ?>
                              <option value="<?= $opt ?>" <?= $die['guide'] === $opt ? 'selected' : '' ?>><?= $opt ?></option>
                            <?php endforeach; ?>
                          </select>
                        </td>
                        <td>
                          <select name="dies[<?= $index ?>][insert]" class="form-control">
                            <option value="null" <?= $die['insert'] === null ? 'selected' : '' ?>>Pilih</option>
                            <?php foreach ($insertOptions as $opt): ?>
                              <option value="<?= $opt ?>" <?= $die['insert'] === $opt ? 'selected' : '' ?>><?= $opt ?></option>
                            <?php endforeach; ?>
                          </select>
                        </td>
                        <td>
                          <select name="dies[<?= $index ?>][heat_treatment]" class="form-control">
                            <option value="null" <?= $die['heat_treatment'] === null ? 'selected' : '' ?>>Pilih</option>
                            <?php foreach ($heatTreatmentOptions as $opt): ?>
                              <option value="<?= $opt ?>" <?= $die['heat_treatment'] === $opt ? 'selected' : '' ?>><?= $opt ?></option>
                            <?php endforeach; ?>
                          </select>
                        </td>
                      </tr>
                    <?php endforeach; ?>
                  <?php else: ?>
                    <!-- Jika kosong, buat baris default dengan opsi "Pilih" -->
                    <tr data-index="0">
                      <td><input type="text" name="dies[0][proses]" class="form-control" readonly></td>
                      <td><input type="text" name="dies[0][machine]" class="form-control" readonly></td>
                      <td><select name="dies[0][upper]" class="form-control"><option value="null">Pilih</option><?php foreach ($upperLowerOptions as $opt): ?><option value="<?= $opt ?>"><?= $opt ?></option><?php endforeach; ?></select></td>
                      <td><select name="dies[0][lower]" class="form-control"><option value="null">Pilih</option><?php foreach ($upperLowerOptions as $opt): ?><option value="<?= $opt ?>"><?= $opt ?></option><?php endforeach; ?></select></td>
                      <td><select name="dies[0][pad]" class="form-control"><option value="null">Pilih</option><?php foreach ($padOptions as $opt): ?><option value="<?= $opt ?>"><?= $opt ?></option><?php endforeach; ?></select></td>
                      <td><select name="dies[0][pad_lifter]" class="form-control"><option value="null">Pilih</option><?php foreach ($padLifterOptions as $opt): ?><option value="<?= $opt ?>"><?= $opt ?></option><?php endforeach; ?></select></td>
                      <td><select name="dies[0][sliding]" class="form-control"><option value="null">Pilih</option><?php foreach ($slidingOptions as $opt): ?><option value="<?= $opt ?>"><?= $opt ?></option><?php endforeach; ?></select></td>
                      <td><select name="dies[0][guide]" class="form-control"><option value="null">Pilih</option><?php foreach ($guideOptions as $opt): ?><option value="<?= $opt ?>"><?= $opt ?></option><?php endforeach; ?></select></td>
                      <td><select name="dies[0][insert]" class="form-control"><option value="null">Pilih</option><?php foreach ($insertOptions as $opt): ?><option value="<?= $opt ?>"><?= $opt ?></option><?php endforeach; ?></select></td>
                      <td><select name="dies[0][heat_treatment]" class="form-control"><option value="null">Pilih</option><?php foreach ($heatTreatmentOptions as $opt): ?><option value="<?= $opt ?>"><?= $opt ?></option><?php endforeach; ?></select></td>
                    </tr>
                  <?php endif; ?>
                </tbody>


              </table>
            </div>
            <table class="table table-bordered" id="tableImages">
              <thead>
                <tr>
                  <th>Process</th>
                  <th>C-Layout Image</th>
                  <th>Die Construction Image</th>
                </tr>
              </thead>
              <tbody>
                <?php if (!empty($dies)): ?>
                  <?php foreach ($dies as $index => $die): ?>
                    <tr data-index="<?= $index ?>">
                      <td>
                        <input type="text" name="dies[<?= $index ?>][process]" class="form-control img-process" readonly value="<?= esc($die['process']) ?>">
                      </td>
                      <td>
                        <input type="file" accept=".jpg, .jpeg, .png" name="dies[<?= $index ?>][clayout_img]" class="form-control" onchange="previewImage(event, 'clayout_preview_<?= $index ?>')">
                        <input type="hidden" name="dies[<?= $index ?>][old_clayout_img]" value="<?= $die['clayout_img'] ?? '' ?>">
                        <input type="hidden" name="dies[<?= $index ?>][selected_clayout_img]" id="selected_clayout_<?= $index ?>">
                        <br>
                        <img id="clayout_preview_<?= $index ?>" src="<?= !empty($die['clayout_img']) ? base_url('uploads/pps/' . $die['clayout_img']) : '#' ?>" width="150" alt="C-Layout" style="<?= !empty($die['clayout_img']) ? '' : 'display:none;' ?>">
                      </td>
                      <td>
                        <input type="file" accept=".jpg, .jpeg, .png" name="dies[<?= $index ?>][die_construction_img]" class="form-control" onchange="previewImage(event, 'die_construction_preview_<?= $index ?>')">
                        <input type="hidden" name="dies[<?= $index ?>][old_die_construction_img]" value="<?= esc($die['die_construction_img'] ?? '') ?>">
                        <input type="hidden" name="dies[<?= $index ?>][selected_die_construction_img]" id="selected_die_construction_<?= $index ?>">

                        <br>
                        <img id="die_construction_preview_<?= $index ?>" src="<?= !empty($die['die_construction_img']) ? base_url('uploads/pps/' . $die['die_construction_img']) : '#' ?>" width="150" alt="Preview" style="<?= !empty($die['die_construction_img']) ? '' : 'display:none;' ?>">

                        <!-- SLIDER WRAPPER -->
                        <div class="dcp-slider-wrapper mt-2">
                          <!-- <button type="button" class="slider-btn left" onclick="scrollSlider('left', <?= $index ?>)">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" stroke="#333" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                              <polyline points="15 18 9 12 15 6"></polyline>
                            </svg>
                          </button> -->

                          <div id="dieconsList_<?= $index ?>" class="dcp-slider-container"></div>

                          <!-- <button type="button" class="slider-btn right" onclick="scrollSlider('right', <?= $index ?>)">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" stroke="#333" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                              <polyline points="9 18 15 12 9 6"></polyline>
                            </svg>
                          </button> -->
                        </div>
                      </td>

                    </tr>
                  <?php endforeach; ?>
                <?php else: ?>
                  <tr data-index="0">
                    <td>
                      <input type="text" name="dies[0][process]" class="form-control img-process" readonly>
                    </td>
                    <td>
                      <input type="file" accept=".jpg, .jpeg, .png" name="dies[0][clayout_img]" class="form-control" onchange="previewImage(event, 'clayout_preview_0')">
                      <input type="hidden" name="dies[0][old_clayout_img]" value="">
                      <input type="hidden" name="dies[0][selected_clayout_img]" id="selected_clayout_0">
                      <br>
                      <img id="clayout_preview_0" src="#" width="150" alt="Preview" style="display:none;">
                    </td>
                    <td>
                      <input type="file" accept=".jpg, .jpeg, .png" name="dies[0][die_construction_img]" class="form-control" onchange="previewImage(event, 'die_construction_preview_0')">
                      <input type="hidden" name="dies[0][old_die_construction_img]" value="">
                      <input type="hidden" name="dies[0][selected_die_construction_img]" id="selected_die_construction_0">
                      <br>
                      <img id="die_construction_preview_0" src="#" width="150" alt="Preview" style="display:none;">
                      <!-- Carousel Wrapper -->
                        <div class="dcp-slider-wrapper mt-2">
                          <!-- Tombol kiri -->
                          <button type="button" class="slider-btn left" onclick="scrollSlider2('left', <?= $index ?>)">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" stroke="#333" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-chevron-left">
                              <polyline points="15 18 9 12 15 6"></polyline>
                            </svg>
                          </button>

                          <!-- Container gambar -->
                          <div id="dieconsList_<?= $index ?>" class="dcp-slider-container">
                            <!-- Gambar dimuat lewat JS -->
                          </div>

                          <!-- Tombol kanan -->
                          <button type="button" class="slider-btn right" onclick="scrollSlider2('right', <?= $index ?>)">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" stroke="#333" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-chevron-right">
                              <polyline points="9 18 15 12 9 6"></polyline>
                            </svg>
                          </button>
                        </div>
                    <script>loadPpsImageList(<?= $index ?>, 'diecons');</script>

                    </td>
                  </tr>
                <?php endif; ?>
              </tbody>
            </table>

          </div>
          <script>
            function previewImage(event, previewId) {
              var input = event.target;
              var reader = new FileReader();
              reader.onload = function(){
                var imgElement = document.getElementById(previewId);
                imgElement.src = reader.result;
                imgElement.style.display = "block";
              }
              if(input.files && input.files[0]){
                reader.readAsDataURL(input.files[0]);
              }
            }
          </script>
        
          <div class="nav-buttons text-right">
            <button type="button" class="btn btn-secondary prev-step" data-prev="3">Sebelumnya</button>
            <button type="button" class="btn btn-primary next-step" data-next="5">Selanjutnya</button>
          </div>
        </div>

      
        
        <!-- Step 5: Gambar & Informasi Tambahan -->
        <div class="step" data-step="5" style="display: none;">
          <div class="card p-3 mb-3">
            <div class="text-left mb-2">
              <button type="button" class="btn btn-info btn-sm" data-toggle="modal" data-target="#additionalInfoHintModal">
                  <i class="fa fa-lightbulb-o" aria-hidden="true"></i> Petunjuk
              </button>
            </div>

            <!-- Modal Additional Information -->
            <div class="modal fade" id="additionalInfoHintModal" tabindex="-1" role="dialog" aria-labelledby="additionalInfoHintModalLabel" aria-hidden="true">
                <div class="modal-dialog modal-lg" role="document">
                    <div class="modal-content">
                        <!-- Header Modal -->
                        <div class="modal-header">
                            <h5 class="modal-title" id="additionalInfoHintModalLabel">Panduan Additional Information</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <!-- Body Modal -->
                        <div class="modal-body">
                            <h6><strong>1. Penjelasan Additional Information</strong></h6>
                            <img src="<?= base_url('assets/images/DiesCons.png') ?>" alt="Dies Construction" class="img-fluid mb-3">
                            <p>Dies Configuration digunakan untuk mengisi **PROCESS LAYOUT** dan **PROCESS DETAIL** yang akan ditempelkan pada bagian Excel seperti pada gambar di atas.</p>

                            <hr>

                            <h6><strong>2. Perhitungan Total MP</strong></h6>
                            <ul>
                                <li><strong>Jika Mesin Big Press</strong>: Setiap mesin **x 2 orang**, kecuali **Line E**.</li>
                                <li><strong>Jika Mesin 300T & SP</strong>: Setiap mesin **x 1 orang**.</li>
                                <li><strong>Untuk Line E</strong>: **4 mesin** hanya memerlukan **3 orang**.</li>
                            </ul>
                            <hr>
                            <h6><strong>3. Upload Gambar</strong></h6>
                            <p>Upload gambar bersifat **opsional** dan tidak wajib diisi melalui program.</p>
                        </div>
                    </div>
                </div>
            </div>
            <div class="card p-3 mb-3">
                <h5>Additional Information</h5>
                <div class="form-group row">
                  <div class="col-md-4 mb-3">
                    <label for="total_mp" class="col-form-label">Total MP</label>
                    <input type="text" id="total_mp" name="total_mp" class="form-control" value="<?= esc($pps['total_mp']) ?>">
                  </div>
                  <div class="col-md-4 mb-3">
                    <label for="doc_level" class="col-form-label">Doc Level</label>
                    <input type="text" id="doc_level" name="doc_level" class="form-control" value="<?= esc($pps['doc_level']) ?>">
                    <div id="docsuggestions" class="suggestions-dropdown" style="display: none;"></div>
                  </div>
                  <div class="col-md-4 mb-3">
                    <label for="total_stroke" class="col-form-label">Total Stroke</label>
                    <input type="text" id="total_stroke" name="total_stroke" class="form-control" value="<?= esc($pps['total_stroke']) ?>">
                  </div>
                </div>
            </div>
            <div class="card p-3 mb-3">
              <h5>Gambar & Informasi Tambahan</h5>
              <div class="row">
                <div class="col-md-12 mb-3">
                  <label>Blank Layout</label>
                  <input type="file" name="blank_layout" class="form-control" accept=".jpg, .jpeg, .png">
                  <?php if(!empty($pps['blank_layout'])): ?>
                    <img src="<?= base_url('uploads/pps/' . $pps['blank_layout']) ?>" width="150" alt="Blank Layout">
                    <!-- Add hidden input to preserve the filename -->
                    <input type="hidden" name="old_blank_layout" value="<?= $pps['blank_layout'] ?>">
                  <?php endif; ?>
                </div>
                
              </div>
                <div class="card p-3 mb-3">
                  <div class="row">
                    <div class="col-md-12 mb-3">
                      <label>Gambar Proses Layout <span class="text-danger">*</span></label>
                        <li>Silahkan pilih gambar atau upload gambar apabila tidak ada di dalam list gambar</li>
                        <li>Apabila ingin menambahkan list gambar untuk disimpan ke sistem silahkan hubungi admin</li>
                        <li>List Gambar yang tampil dinamis bedasarkan OP Maksimum yang dipilih</li>
                      <!-- Upload baru -->
                      <input type="file" name="process_layout_img" class="form-control mb-2" accept=".png,.jpg,.jpeg" id="processUpload">

                      <!-- Preview yang dipilih dari list atau hasil upload -->
                      <img id="processPreview" style="max-width: 120px; display: <?= !empty($pps['process_layout']) ? 'block' : 'none' ?>; margin-top: 5px;"
                        src="<?= !empty($pps['process_layout']) ? base_url('uploads/pps/' . $pps['process_layout']) : '' ?>" />

                      <!-- Jika ada data lama, simpan di hidden input -->
                      <?php if (!empty($pps['process_layout'])): ?>
                        <input type="hidden" name="old_process_layout" value="<?= $pps['process_layout'] ?>">
                      <?php endif; ?>

                      <!-- Hidden input jika pilih dari list -->
                      <input type="hidden" name="process_layout_selected" id="processSelected">
                      <input type="hidden" name="old_process_layout" value="<?= $pps['process_layout'] ?>">
             
                      <!-- List gambar dari folder -->
                     <!-- Wrapper carousel -->
                      <div class="dcp-slider-wrapper mt-2">
                        <!-- Tombol kiri -->
                        <button type="button" class="slider-btn left" onclick="scrollSlider('left')">
                          <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" stroke="#333" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-chevron-left">
                            <polyline points="15 18 9 12 15 6"></polyline>
                          </svg>
                        </button>

                        <!-- Container gambar -->
                        <div id="processList" class="dcp-slider-container">
                          <!-- Gambar dimuat lewat JS -->
                        </div>

                        <!-- Tombol kanan -->
                        <button type="button" class="slider-btn right" onclick="scrollSlider('right')">
                          <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" stroke="#333" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-chevron-right">
                            <polyline points="9 18 15 12 9 6"></polyline>
                          </svg>
                        </button>
                      </div>

                    </div>
                  </div>
                </div>

              <div class="row">
                <div class="col-md-6 mb-3">
                  <label>Created At</label>
                  <p class="form-control-plaintext"><?= isset($pps['created_at']) ? date('d-m-Y H:i', strtotime($pps['created_at'])) : '-' ?></p>
                </div>
              </div>
            </div>
            <div class="nav-buttons text-right">
              <button type="button" class="btn btn-secondary prev-step" data-prev="4">Sebelumnya</button>
                <!-- Tombol Update Biasa -->
    <!-- <button type="submit" name="action" value="update" class="btn btn-success">Update Data</button> -->

              <!-- Tombol Save As New -->
              <button type="submit" name="action" value="save_as_new" class="btn btn-primary">Update</button>

            </div>
        </div>
        <!-- End Step 5 -->
      </form>
      <div id="errorMessage" style="color: red;"></div>
    </div>
  </div>
</div>

<script>
  var csrfName = "<?= csrf_token() ?>";
  var csrfHash = "<?= csrf_hash() ?>";
</script>
<script>
  
  function loadPpsImages2(containerId, hiddenInputId, previewId, selectedValue = '') {
  const container = document.getElementById(containerId); // ⬅️ fix penting
  if (!container) {
    console.error('Container not found:', containerId);
    return;
  }

  const selects = document.querySelectorAll('select[name^="dies"][name$="[process]"], select[name^="dies"][name$="[process_join]"]');
  let maxOp = 0;

  selects.forEach(sel => {
    if (sel.value) {
      const match = sel.value.match(/OP(\d+)/i);
      if (match) {
        const opVal = parseInt(match[1], 10);
        if (opVal > maxOp) maxOp = opVal;
      }
    }
  });

  fetch(`<?= base_url('Pps/listPpsImages3') ?>?maxOp=${maxOp}`)
    .then(res => res.json())
    .then(images => {
      container.innerHTML = ''; // bersihkan container dulu
      images.forEach(imgPath => {
        const img = document.createElement('img');
        img.src = imgPath;
        img.style.width = '100px';
        img.style.cursor = 'pointer';
        img.style.border = '2px solid transparent';

        if (imgPath.includes(selectedValue)) {
          img.style.border = '2px solid green';
        }

        img.addEventListener('click', () => {
          document.getElementById(hiddenInputId).value = imgPath;
          const preview = document.getElementById(previewId);
          preview.src = imgPath;
          preview.style.display = 'block';

          // Reset border
          container.querySelectorAll('img').forEach(i => {
            i.style.border = '2px solid transparent';
          });
          img.style.border = '2px solid green';
        });

        container.appendChild(img);
      });
    });
}

// function loadPpsImages2(containerId, hiddenInputId, previewId, selectedValue = '') {
//   console.log("abcsd")
//   // Ambil semua select dari tabel dies
//   const selects = document.querySelectorAll('select[name^="dies"][name$="[process]"], select[name^="dies"][name$="[process_join]"]');
//   let maxOp = 0;

//   selects.forEach(sel => {
//     if (sel.value) {
//       const match = sel.value.match(/OP(\d+)/i);
//       if (match) {
//         const opVal = parseInt(match[1], 10);
//         if (opVal > maxOp) maxOp = opVal;
//       }
//     }
//   });

//   // Ambil container DOM dari ID string
//   const container = document.getElementById(containerId);
//   container.innerHTML = '';

//   // Fetch gambar dari controller dengan maxOp
//   fetch(`<?= base_url('Pps/listPpsImages3') ?>?maxOp=${maxOp}`)
//     .then(res => res.json())
//     .then(images => {
//       images.forEach(imgPath => {
//         const img = document.createElement('img');
//         img.src = imgPath;
//         img.style.width = '100px';
//         img.style.cursor = 'pointer';
//         img.style.border = '2px solid transparent';

//         if (imgPath.includes(selectedValue)) {
//           img.style.border = '2px solid green';
//         }

//         img.addEventListener('click', () => {
//           document.getElementById(hiddenInputId).value = imgPath;
//           const preview = document.getElementById(previewId);
//           preview.src = imgPath;
//           preview.style.display = 'block';

//           // Reset border untuk semua gambar
//           container.querySelectorAll('img').forEach(i => {
//             i.style.border = '2px solid transparent';
//           });
//           img.style.border = '2px solid green';
//         });

//         container.appendChild(img);
//       });
//     })
//     .catch(err => console.error('Error loadPpsImages2:', err));
// }
document.querySelectorAll('select[name^="dies"][name$="[process]"], select[name^="dies"][name$="[process_join]"]')
  .forEach(select => {
    select.addEventListener('change', loadPpsImagesByChange);
  });
  function loadPpsImagesByChange() {
  const processList = document.getElementById('processList');
  const processSelected = document.getElementById('processSelected');
  const processPreview = document.getElementById('processPreview');

  // Ambil nilai yang sudah disimpan sebelumnya (kalau ada)
  const selectedValue = processSelected.value || '';

  loadPpsImages2('processList', 'processSelected', 'processPreview', selectedValue);
}

document.addEventListener('DOMContentLoaded', () => {
  const processList = document.getElementById('processList');
  const processSelected = document.getElementById('processSelected');
  const processPreview = document.getElementById('processPreview');

  // loadPpsImages2(processList, 'processSelected', 'processPreview', '<?= $pps['process_layout'] ?? '' ?>');
  loadPpsImages2('processList', 'processSelected', 'processPreview', '<?= $pps['process_layout'] ?? '' ?>');
  document.getElementById('processUpload').addEventListener('change', (e) => {
    processSelected.value = '';
    processPreview.src = URL.createObjectURL(e.target.files[0]);
    processPreview.style.display = 'block';
  });
});
document.addEventListener('DOMContentLoaded', function () {
  document.body.addEventListener('click', function (e) {
    if (e.target.tagName === 'IMG' && e.target.closest('[id^="dieconsList_"]')) {
      const img = e.target;
      const listDiv = img.closest('[id^="dieconsList_"]');
      const index = listDiv.id.split('_')[1];

      const selectedInput = document.getElementById('selected_die_construction_' + index);
      const previewImage = document.getElementById('die_construction_preview_' + index);

      if (selectedInput && previewImage) {
        const selectedSrc = img.getAttribute('src'); // <-- langsung ambil full URL

        selectedInput.value = selectedSrc; // <-- masukkan full URL
        previewImage.src = selectedSrc;
        previewImage.style.display = 'block';

        // Reset border semua gambar di dalam container
        listDiv.querySelectorAll('img').forEach(i => i.style.border = '2px solid transparent');
        img.style.border = '2px solid green';
      }
    }
  });
});


</script>

<script>
  $(document).ready(function(){
    var rowCount = <?= !empty($dies) ? count($dies) : 1 ?>;
    
    // Tambah row
    $('#addRow').click(function(){
        if (rowCount >= 8) {
            alert('Maksimal 8 baris saja');
            return; // keluar, jangan tambah baris
        }
        var newRow = generateRow(rowCount);
        $('#tableBasic tbody').append(newRow.basic);
        $('#tablePress tbody').append(newRow.press);
        $('#tableDie tbody').append(newRow.die);
        $('#tableDieConstruction tbody').append(newRow.dieConstruction);
        $('#tableImages tbody').append(newRow.images);
        rowCount++;
        bindBasicDimensionListeners();

        // Optional: disable tombol kalau sudah mencapai 8
        if (rowCount >= 8) {
            $('#addRow').prop('disabled', true);
        }
    });

    
    // Hapus row berdasarkan data-index
    $('#tableBasic').on('click', '.deleteRow', function(){
      var $row = $(this).closest('tr');
      var index = $row.data('index');
      $('tr[data-index="' + index + '"]').remove();
    });
    
    // Sinkronisasi nilai dari Basic ke tabel lainnya
    $('#tableBasic').on('change', '.basic-process', function(){
      var val = $(this).val();
      var index = $(this).closest('tr').data('index');
      $('tr[data-index="'+ index +'"] .die-process, tr[data-index="'+ index +'"] .dc-proses, tr[data-index="'+ index +'"] .img-process').val(val);
    });
    $('#tableBasic').on('change', '.basic-machine', function(){
      var val = $(this).val();
      var index = $(this).closest('tr').data('index');
      $('tr[data-index="'+ index +'"] .press-machine').val(val);
      $('tr[data-index="'+ index +'"] .dc-machine').val(val);
    });
    
    // Fungsi generate row baru secara dinamis
    function generateRow(index) {
      // Tabel Basic
      var processNumber = (index + 1) * 10;
      var processValue = 'OP' + processNumber;

      var basic = '<tr data-index="'+ index +'">' +
                    '<td>' +
                      '<select name="dies['+ index +'][process]" class="form-control basic-process mb-1">' +
                        '<option value="'+ processValue +'" selected>'+ processValue +'</option>' +
                      '</select>' +
                      '<select name="dies['+ index +'][process_join]" class="form-control">' +
                        '<option value="" selected>Pilih</option>' +
                        '<?php foreach ($ops as $op): ?>' +
                          '<option value="<?= $op ?>"><?= $op ?></option>' +
                        '<?php endforeach; ?>' +
                      '</select>' +
                    '</td>' +
                    
                    '<td>' +
                      '<div class="input-proses">' +
                        // Proses Input 1
                        '<div class="proses-wrapper d-flex align-items-center mb-2" style="gap: 8px; width: 100%;">' +
                          '<input type="checkbox" class="proses-checkbox" data-select-name="dies['+ index +'][proses_input1]" ' +
                                'style="transform: scale(1.3); margin-right: 2px;" ' +
                                'onchange="updateProsesHidden(this.closest(\'div.input-proses\')); updateDCProcessDropdown('+ index +')">' +
                          '<label style="font-size:14px; margin:0;">CAM</label>' +
                          '<select name="dies['+ index +'][proses_input1]" class="form-control" ' +
                            'style="width:100%; height:38px; font-size:14px;" ' +
                            'onchange="updateProsesHidden(this.closest(\'div.input-proses\')); updateDCProcessDropdown('+ index +'); calculateMainPressure(this)"' +
                            '>' +
                              '<option value="">Pilih</option>' +
                              '<?php foreach ($prosesOptions as $p): ?>' +
                                '<option value="<?= $p ?>"><?= $p ?></option>' +
                              '<?php endforeach; ?>' +
                          '</select>'
                        '</div>' +

                        // Proses Input 2
                        '<div class="proses-wrapper d-flex align-items-center mb-2" style="gap: 8px; width: 100%;">' +
                          '<input type="checkbox" class="proses-checkbox" data-select-name="dies['+ index +'][proses_input2]" ' +
                                'style="transform: scale(1.3); margin-right: 2px;" ' +
                                'onchange="updateProsesHidden(this.closest(\'div.input-proses\')); updateDCProcessDropdown('+ index +')">' +
                          '<label style="font-size:14px; margin:0;">CAM</label>' +
                          '<select name="dies['+ index +'][proses_input2]" class="form-control" ' +
                                  'style="width:100%; height:38px; font-size:14px;" ' +
                                  'onchange="updateProsesHidden(this.closest(\'div.input-proses\')); updateDCProcessDropdown('+ index +'); calculateMainPressure(this)">' +
                            '<option value="">Pilih</option>' +
                            '<?php foreach ($prosesOptions as $p): ?>' +
                              '<option value="<?= $p ?>"><?= $p ?></option>' +
                            '<?php endforeach; ?>' +
                          '</select>' +
                        '</div>' +
                        // Proses Input 3
                        '<div class="proses-wrapper d-flex align-items-center mb-2" style="gap: 8px; width: 100%;">' +
                          '<input type="checkbox" class="proses-checkbox" data-select-name="dies['+ index +'][proses_input3]" ' +
                                'style="transform: scale(1.3); margin-right: 2px;" ' +
                                'onchange="updateProsesHidden(this.closest(\'div.input-proses\')); updateDCProcessDropdown('+ index +')">' +
                          '<label style="font-size:14px; margin:0;">CAM</label>' +
                          '<select name="dies['+ index +'][proses_input3]" class="form-control" ' +
                                  'style="width:100%; height:38px; font-size:14px;" ' +
                                  'onchange="updateProsesHidden(this.closest(\'div.input-proses\')); updateDCProcessDropdown('+ index +')">' +
                            '<option value="">Pilih</option>' +
                            '<?php foreach ($prosesOptions as $p): ?>' +
                              '<option value="<?= $p ?>"><?= $p ?></option>' +
                            '<?php endforeach; ?>' +
                          '</select>' +
                        '</div>' +
                        
                        '<input type="text" name="dies['+ index +'][proses]" class="form-control" readonly>' +
                      '</div>' +
                    '</td>' +

                    '<td>' +
                      '<div class="input-proses-gang">' +
                        // Proses Gang 1
                        '<div class="proses-wrapper d-flex align-items-center mb-2" style="gap: 8px; width: 100%;">' +
                          '<input type="checkbox" class="proses-gang-checkbox" data-select-name="dies['+ index +'][proses_gang_input1]" ' +
                                'style="transform: scale(1.3); margin-right: 2px;" ' +
                                'onchange="updateProsesGangHidden(this.closest(\'div.input-proses-gang\')); updateDCProcessDropdown('+ index +')">' +
                          '<label style="font-size:14px; margin:0;">CAM</label>' +
                          '<select name="dies['+ index +'][proses_gang_input1]" class="form-control" ' +
                                  'style="width:100%; height:38px; font-size:14px;" ' +
                                  'onchange="updateProsesGangHidden(this.closest(\'div.input-proses-gang\')); updateDCProcessDropdown('+ index +'); calculateMainPressure(this)">' +
                            '<option value="">Pilih</option>' +
                            '<?php foreach ($prosesOptions as $p): ?>' +
                              '<option value="<?= $p ?>"><?= $p ?></option>' +
                            '<?php endforeach; ?>' +
                          '</select>' +
                        '</div>' +

                        // Proses Gang 2
                        '<div class="proses-wrapper d-flex align-items-center mb-2" style="gap: 8px; width: 100%;">' +
                          '<input type="checkbox" class="proses-gang-checkbox" data-select-name="dies['+ index +'][proses_gang_input2]" ' +
                                'style="transform: scale(1.3); margin-right: 2px;" ' +
                                'onchange="updateProsesGangHidden(this.closest(\'div.input-proses-gang\')); updateDCProcessDropdown('+ index +')">' +
                          '<label style="font-size:14px; margin:0;">CAM</label>' +
                          '<select name="dies['+ index +'][proses_gang_input2]" class="form-control" ' +
                                  'style="width:100%; height:38px; font-size:14px;" ' +
                                  'onchange="updateProsesGangHidden(this.closest(\'div.input-proses-gang\')); updateDCProcessDropdown('+ index +')">' +
                            '<option value="">Pilih</option>' +
                            '<?php foreach ($prosesOptions as $p): ?>' +
                              '<option value="<?= $p ?>"><?= $p ?></option>' +
                            '<?php endforeach; ?>' +
                          '</select>' +
                        '</div>' +

                        // Proses Gang 3
                        '<div class="proses-wrapper d-flex align-items-center mb-2" style="gap: 8px; width: 100%;">' +
                          '<input type="checkbox" class="proses-gang-checkbox" data-select-name="dies['+ index +'][proses_gang_input3]" ' +
                                'style="transform: scale(1.3); margin-right: 2px;" ' +
                                'onchange="updateProsesGangHidden(this.closest(\'div.input-proses-gang\')); updateDCProcessDropdown('+ index +')">' +
                          '<label style="font-size:14px; margin:0;">CAM</label>' +
                          '<select name="dies['+ index +'][proses_gang_input3]" class="form-control" ' +
                                  'style="width:100%; height:38px; font-size:14px;" ' +
                                  'onchange="updateProsesGangHidden(this.closest(\'div.input-proses-gang\')); updateDCProcessDropdown('+ index +')">' +
                            '<option value="">Pilih</option>' +
                            '<?php foreach ($prosesOptions as $p): ?>' +
                              '<option value="<?= $p ?>"><?= $p ?></option>' +
                            '<?php endforeach; ?>' +
                          '</select>' +
                        '</div>' +

                        '<input type="text" name="dies['+ index +'][proses_gang]" class="form-control" readonly>' +
                      '</div>' +
                    '</td>' +
                    
                    '<td><input type="text" name="dies['+ index +'][qty_dies]" class="form-control" value="1"></td>' +
                    '<td>' +
                      '<div style="width:100%;">' +
                        // Panjang & Lebar
                        '<div style="display: flex; margin-bottom: 5px; width: 100%; align-items: center; gap: 6px;">' +
                          ' <input type="checkbox" class="proses-checkbox cbPanjangLebar"name="dies['+ index +'][cbPanjangLebar]" value="1"  title="Pakai Panjang + Lebar" style="transform: scale(1.3);" onchange="toggleManualReadonly(this.closest('tr'))" >' +
                          '<label style="font-size: 12px; margin: 0px; min-width: 25px;"></label>' +
                          '<input type="number" name="dies['+ index +'][panjang]" placeholder="p" class="form-control" style="width: 40%; margin-right: 2%;" oninput="calculateKeliling(this)">' +
                          '<input type="number" name="dies['+ index +'][lebar]" placeholder="l" class="form-control" style="width: 40%;" oninput="calculateKeliling(this)">' +
                        '</div>' +

                        // Panjang Proses
                        '<div style="margin-bottom: 5px; width: 100%; display: flex; align-items: center; gap: 6px;">' +
                          '<inputtype="checkbox"class="proses-checkbox cbPanjangProses"  name="dies['+ index +'][cbPanjangProses]"  value="1"   style="transform: scale(1.3); margin-right: 2px;"  onchange="toggleManualReadonly(this.closest('tr'))"  >' +
                          '<label style="font-size: 12px; margin: 0px; min-width: 25px;"></label>' +
                          '<input type="number" name="dies['+ index +'][panjangProses]" placeholder="Panjang Proses" class="form-control" style="width: 100%;" oninput="calculateKeliling(this)">' +
                        '</div>' +

                        // Diameter & Jumlah Pie
                        '<div style="display: flex; width: 100%; align-items: center; gap: 6px;">' +
                          ' <input type="checkbox" class="proses-checkbox cbPie"  name="dies['+ index +'][cbPie]" value="1" onchange="toggleManualReadonly(this.closest('tr'))"  >' +
                          '<label style="font-size: 12px; margin: 0px; min-width: 25px;"></label>' +
                          '<input type="number" name="dies['+ index +'][diameter]" placeholder="d pie" class="form-control" style="width: 40%; margin-right: 2%;" readonly oninput="calculateKeliling(this)">' +
                          '<input type="number" name="dies['+ index +'][jumlahPie]" placeholder="jml pie" class="form-control" style="width: 40%;" readonly oninput="calculateKeliling(this)">' +
                        '</div>' +
                      '</div>' +
                    '</td>' +

                            
                    '<td><input type="number" name="dies['+ index +'][length_mp]" class="form-control" oninput="calculateMainPressure(this)" readonly></td>' +
                    '<td><input type="text" name="dies['+ index +'][main_pressure]" class="form-control" readonly></td>' +
                    
                    '<td>' +
                      '<div style="width:100%;">' +
                        // Baris Mesin (full width)
                        '<div style="margin-bottom:5px; width:100%;">' +
                          '<select name="dies['+ index +'][machine]" class="form-control basic-machine" ' +
                                  'onchange="calculateTotalMP(); onMachineChange(this); updateDCProcessDropdown('+ index +'); updateDieConstructionRow(this.closest(\'tr\').getAttribute(\'data-index\')); calculateDieWeight2(this)">' +
                            '<?php foreach ($machineOptions as $option): ?>' +
                              '<option value="<?= esc($option) ?>"><?= esc($option) ?></option>' +
                            '<?php endforeach; ?>' +
                          '</select>' +
                        '</div>' +
                        
                        // Baris Capacity & Cushion (inline)
                        '<div style="display:flex; width:100%;">' +
                          '<input type="text" name="dies['+ index +'][capacity]" class="form-control" readonly ' +
                                'style="width:48%; margin-right:4%;">' +
                          '<input type="text" name="dies['+ index +'][cushion]" class="form-control" readonly ' +
                                'style="width:48%;">' +
                        '</div>' +
                      '</div>' +
                    '</td>' +

                    '<td><button type="button" class="btn btn-danger deleteRow">Hapus</button></td>' +
                  '</tr>';
      // Tabel Press M/C Spec (machine readonly)
      var press = '<tr data-index="'+ index +'">'+
                    '<td><input type="text" name="dies['+ index +'][machine]" class="form-control press-machine" readonly></td>'+
                    '<td><input type="text" name="dies['+ index +'][bolster_length]" class="form-control" readonly></td>'+
                    '<td><input type="text" name="dies['+ index +'][bolster_width]" class="form-control" readonly></td>'+
                    '<td><input type="text" name="dies['+ index +'][slide_area_length]" class="form-control" readonly></td>'+
                    '<td><input type="text" name="dies['+ index +'][slide_area_width]" class="form-control" readonly></td>'+
                    '<td><input type="text" name="dies['+ index +'][slide_stroke]" class="form-control" readonly></td>'+
                    '<td><input type="text" name="dies['+ index +'][die_height_max]" class="form-control" readonly></td>'+
                    '<td><input type="text" name="dies['+ index +'][cushion_pad_length]" class="form-control" readonly></td>'+
                    '<td><input type="text" name="dies['+ index +'][cushion_pad_width]" class="form-control" readonly></td>'+
                    '<td><input type="text" name="dies['+ index +'][cushion_stroke]" class="form-control" readonly></td>'+
                  '</tr>';
      // Tabel Die (process mengikuti basic)
      var die = '<tr data-index="'+ index +'">'+
                  '<td><input type="text" name="dies['+ index +'][process]" class="form-control die-process" value="'+ processValue +'" readonly></td>'+
                  '<td>'+
                    '<select name="dies['+ index +'][dc_process]" class="form-control">'+
                      '<option value="BIG DIE|SINGLE|DRAW">BIG DIE, SINGLE, DRAW</option>'+
                      '<option value="BIG DIE|SINGLE|DEEP DRAW">BIG DIE, SINGLE, DEEP DRAW</option>'+
                      '<option value="BIG DIE|SINGLE|TRIM">BIG DIE, SINGLE, TRIM</option>'+
                      '<option value="BIG DIE|SINGLE|FLANGE">BIG DIE, SINGLE, FLANGE</option>'+
                      '<option value="BIG DIE|SINGLE|CAM FLANGE">BIG DIE, SINGLE, CAM FLANGE</option>'+
                      '<option value="MEDIUM DIE|SINGLE|DRAW">MEDIUM DIE, SINGLE, DRAW</option>'+
                      '<option value="MEDIUM DIE|SINGLE|TRIM">MEDIUM DIE, SINGLE, TRIM</option>'+
                      '<option value="MEDIUM DIE|SINGLE|FLANGE">MEDIUM DIE, SINGLE, FLANGE</option>'+
                      '<option value="MEDIUM DIE|SINGLE|CAM PIE">MEDIUM DIE, SINGLE, CAM PIE</option>'+
                      '<option value="MEDIUM DIE|GANG|DRAW">MEDIUM DIE, GANG, DRAW</option>'+
                      '<option value="MEDIUM DIE|GANG|TRIM">MEDIUM DIE, GANG, TRIM</option>'+
                      '<option value="MEDIUM DIE|GANG|FLANGE-CAM PIE">MEDIUM DIE, GANG, FLANGE-CAM PIE</option>'+
                      '<option value="SMALL DIE|SINGLE|BLANK">SMALL DIE, SINGLE, BLANK</option>'+
                      '<option value="SMALL DIE|SINGLE|FORMING">SMALL DIE, SINGLE, FORMING</option>'+
                      '<option value="SMALL DIE|SINGLE|CAM PIE">SMALL DIE, SINGLE, CAM PIE</option>'+
                      '<option value="SMALL DIE|GANG|FORM-FLANGE">SMALL DIE, GANG, FORM-FLANGE</option>'+
                      '<option value="SMALL DIE|GANG|BEND 1, BEND 2">SMALL DIE, GANG, BEND 1, BEND 2</option>'+
                      '<option value="SMALL DIE|GANG|FORMING, PIE">SMALL DIE, GANG, FORMING, PIE</option>'+
                      '<option value="SMALL DIE|PROGRESSIVE|BLANK-PIE">SMALL DIE, PROGRESSIVE, BLANK-PIE</option>'+
                    '</select>'+
                  '</td>'+
                  '<td>' +
                      '<input type="text" name="dies[' + index + '][die_length]" class="form-control d-inline-block" style="margin-right: 5px; width: 30%;" readonly>' +
                      '<input type="text" name="dies[' + index + '][die_width]" class="form-control d-inline-block" style="margin-right: 5px; width: 30%;" readonly>' +
                      '<input type="text" name="dies[' + index + '][die_height]" class="form-control d-inline-block" style="margin-right: 5px; width: 30%;" readonly>' +
                
                  '</td>' +

                  '<td>'+
                    '<select name="dies['+ index +'][casting_plate]" class="form-control" onchange="calculateDieWeight(this); updateDieConstructionRow(this.closest(\'tr\').getAttribute(\'data-index\'))">'+
                      '<option value="casting">Casting</option>'+
                      '<option value="plate">Plate</option>'+
                    '</select>'+
                  '</td>'+
                  '<td><input type="text" name="dies['+ index +'][die_weight]" class="form-control" readonly></td>'+
                  '<td>'+
                      '<select name="dies['+ index +'][die_class]" class="form-control">'+
                        '<option value="">Pilih</option>'+
                        '<option value="A">A</option>'+
                        '<option value="B">B</option>'+
                        '<option value="C">C</option>'+
                        '<option value="D">D</option>'+
                        '<option value="E">E</option>'+
                        '<option value="F">F</option>'+
                      '</select>'+
                    '</td>'+

                '</tr>';
      // Tabel Die Construction (process & machine mengikuti basic)
    
      var dieConstruction = '<tr data-index="'+ index +'">'+
        '<td><input type="text" name="dies['+ index +'][proses]" class="form-control dc-proses" readonly></td>'+
        '<td><input type="text" name="dies['+ index +'][machine]" class="form-control dc-machine" readonly></td>'+

        '<td><select name="dies['+ index +'][upper]" class="form-control">'+
            '<option value="">Pilih</option>'+
            '<option value="FC300">FC300</option>'+
            '<option value="FCD55">FCD55</option>'+
            '<option value="S45C">S45C</option>'+
            '<option value="SS41">SS41</option>'+
            '<option value="TGC600">TGC600</option>'+
        '</select></td>'+

        '<td><select name="dies['+ index +'][lower]" class="form-control">'+
            '<option value="">Pilih</option>'+
            '<option value="FC300">FC300</option>'+
            '<option value="FCD55">FCD55</option>'+
            '<option value="S45C">S45C</option>'+
            '<option value="SS41">SS41</option>'+
            '<option value="TGC600">TGC600</option>'+
        '</select></td>'+

        '<td><select name="dies['+ index +'][pad]" class="form-control">'+
            '<option value="">Pilih</option>'+
            '<option value="FC300">FC300</option>'+
            '<option value="FCD55">FCD55</option>'+
            '<option value="S45C">S45C</option>'+
            '<option value="SKD11">SKD11</option>'+
            '<option value="HMD5">HMD5</option>'+
            '<option value="SXACE">SXACE</option>'+
        '</select></td>'+

        '<td><select name="dies['+ index +'][pad_lifter]" class="form-control">'+
            '<option value="">Pilih</option>'+
            '<option value="Coil Spring">Coil Spring</option>'+
            '<option value="Cushion">Cushion</option>'+
            '<option value="Gas Spring">Gas Spring</option>'+
        '</select></td>'+

        '<td><select name="dies['+ index +'][sliding]" class="form-control">'+
            '<option value="Stripper Bolt">Stripper Bolt</option>'+
            '<option value="Wear Plate">Wear Plate</option>'+
        '</select></td>'+

        '<td><select name="dies['+ index +'][guide]" class="form-control">'+
          '<option value="">Pilih</option>'+
            '<option value="Guide Heel">Guide Heel</option>'+
            '<option value="Guide Post">Guide Post</option>'+
        '</select></td>'+

        '<td><select name="dies['+ index +'][insert]" class="form-control">'+
            '<option value="">Pilih</option>'+
            '<option value="HMD5">HMD5</option>'+
            '<option value="S45C">S45C</option>'+
            '<option value="SKD11">SKD11</option>'+
            '<option value="SLDM">SLDM</option>'+
            '<option value="SX105V">SX105V</option>'+
            '<option value="SXACE">SXACE</option>'+
        '</select></td>'+

        '<td><select name="dies['+ index +'][heat_treatment]" class="form-control">'+
          '<option value="">Pilih</option>'+
            '<option value="FLAMEHARD">FLAMEHARD</option>'+
            '<option value="FULLHARD">FULLHARD</option>'+
            '<option value="FULLHARD + COATING">FULLHARD + COATING</option>'+
            '<option value="HARD CHROME">HARD CHROME</option>'+
        '</select></td>'+

        '</tr>';
      var images = '<tr data-index="'+ index +'">'+
                      '<td><input type="text" name="dies['+ index +'][process]" class="form-control img-process" readonly></td>'+
                      '<td><input type="file" accept=".jpg, .jpeg, .png" name="dies['+ index +'][clayout_img]" class="form-control" onchange="previewImage(event, \'clayout_preview_'+ index +'\')">'+
                      ' <input type="hidden" name="dies[0][old_clayout_img]" value="">' +
                        '<br><img id="clayout_preview_'+ index +'" src="#" width="150" alt="Preview" style="display:none;">'+
                      '</td>'+
                      '<td><input type="file" accept=".jpg, .jpeg, .png" name="dies['+ index +'][die_construction_img]" class="form-control" onchange="previewImage(event, \'die_construction_preview_'+ index +'\')">'+
                      ' <input type="hidden" name="dies[0][old_die_construction_img]" value="">'  
                        '<br><img id="die_construction_preview_'+ index +'" src="#" width="150" alt="Preview" style="display:none;">'+
                      '</td>'+
                    '</tr>';
      return {
        basic: basic,
        press: press,
        die: die,
        dieConstruction: dieConstruction,
        images: images
      };
    }
  });
</script>

<script>
  document.addEventListener('DOMContentLoaded', function() {
    const steps = document.querySelectorAll('.step');
    const stepProgress = document.querySelectorAll('.step-progress li');
    let currentStep = 1;

    function showStep(stepNumber) {
      steps.forEach(step => {
     
        step.style.display = 'none';
        step.classList.remove('active');
      });
    
      const activeStep = document.querySelector(`.step[data-step="${stepNumber}"]`);
      if (activeStep) {
        activeStep.style.display = 'block';
        activeStep.classList.add('active');
      }
      
      stepProgress.forEach((item, index) => {
        if (index < stepNumber) {
          item.classList.add('active');
        } else {
          item.classList.remove('active');
        }
      });
    }
    document.querySelectorAll('.next-step').forEach(button => {
      button.addEventListener('click', function() {
        const nextStep = parseInt(this.dataset.next);
        if (validateStep(currentStep)) {
          currentStep = nextStep;
          showStep(currentStep);
        }
      });
    });

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

    showStep(currentStep);
  });
</script>
<script>
function showMachineMatchModal() {
    const mainPressureInputs = document.querySelectorAll('input[name^="dies"][name$="[main_pressure]"]');
    const dieLengthInputs = document.querySelectorAll('input[name^="dies"][name$="[die_length]"]');
    const dieWidthInputs = document.querySelectorAll('input[name^="dies"][name$="[die_width]"]');
    const processInputs = document.querySelectorAll('select[name^="dies"][name$="[process]"]');

    let mainPressures = [];
    let dieLengths = [];
    let dieWidths = [];
    let processNames = [];
    let rowIndices = [];

    mainPressureInputs.forEach((input, index) => {
        const val = parseFloat(input.value);
        const length = parseFloat(dieLengthInputs[index]?.value);
        const width = parseFloat(dieWidthInputs[index]?.value);
        const process = processInputs[index]?.value || `OP${index+1}`;

        if (!isNaN(val) && !isNaN(length) && !isNaN(width)) {
            mainPressures.push(val);
            dieLengths.push(length);
            dieWidths.push(width);
            processNames.push(process);
            rowIndices.push(index);
        }
    });

    if (mainPressures.length === 0) {
        alert('Please fill in all Main Pressure, Die Length, and Die Width values.');
        return;
    }

    const modal = new bootstrap.Modal(document.getElementById('machineMatchModal'));
    const modalBody = document.querySelector('#machineMatchModal .modal-body');
    modalBody.innerHTML = '<div class="text-center py-4"><div class="spinner-border" role="status"><span class="visually-hidden">Loading...</span></div><p class="mt-2">Loading machine match data...</p></div>';
    modal.show();

    fetch('/machine-match/checkMatch', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.content || ''
        },
        body: JSON.stringify({
            main_pressures: mainPressures,
            die_lengths: dieLengths,
            die_widths: dieWidths,
            process_names: processNames
        })
    })
    .then(res => {
        if (!res.ok) throw new Error('Network response was not ok');
        return res.json();
    })
    .then(data => {
        let tabHeaderHtml = '';
        let tabContentHtml = '';

        data.forEach((row, index) => {
            const tabId = `pressure-tab-${index}`;
            const activeClass = index === 0 ? 'active' : '';
            const showClass = index === 0 ? 'show active' : '';
            const rowIndex = rowIndices[index];

            let tableRows = '';
            row.matches.forEach(match => {
                const highlightStyle = match.highlight ? ' style="background-color: #e6ffe6;"' : '';
                tableRows += `
                    <tr${highlightStyle}>
                        <td>${match.machine}</td>
                        <td>${match.capacity}</td>
                        <td>${match.cushion}</td>
                        <td>${match.bolster_length} x ${match.bolster_width}</td>
                        <td>${match.slide_area_length} x ${match.slide_area_width}</td>
                        <td>${match.match ? '✅ Match' : `❌ ${match.reason}`}</td>

                      
                    </tr>
                `;
            });

            tabHeaderHtml += `
                <li class="nav-item" role="presentation">
                    <button class="nav-link ${activeClass}" id="${tabId}-tab" data-bs-toggle="tab" data-bs-target="#${tabId}" type="button" role="tab" aria-controls="${tabId}" aria-selected="${index === 0}">
                        ${processNames[index] || `Row ${index + 1}`}
                    </button>
                </li>
            `;

            tabContentHtml += `
                <div class="tab-pane fade ${showClass}" id="${tabId}" role="tabpanel" aria-labelledby="${tabId}-tab">
                    <div class="alert alert-info">
                        <strong>Process:</strong> ${processNames[index]}<br>
                        <strong>Main Pressure:</strong> ${row.main_pressure || '-'} ton<br>
                        <strong>Die Size:</strong> ${row.die_length || '-'} x ${row.die_width || '-'} mm
                    </div>
                    <div class="table-responsive">
                        <table class="table table-bordered table-hover mt-2">
                            <thead class="table-light">
                                <tr>
                                    <th>Machine</th>
                                    <th>Capacity</th>
                                    <th>Cushion</th>
                                    <th>Bolster Area</th>
                                    <th>Slide Area</th>
                                    <th>Status</th>
                              
                                </tr>
                            </thead>
                            <tbody>${tableRows}</tbody>
                        </table>
                    </div>
                </div>
            `;
        });

        modalBody.innerHTML = `
            <ul class="nav nav-tabs" id="pressureTabs" role="tablist">
                ${tabHeaderHtml}
            </ul>
            <div class="tab-content mt-3" id="pressureTabContent">
                ${tabContentHtml}
            </div>
        `;
    })
    .catch(err => {
        console.error('Error:', err);
        modalBody.innerHTML = `
            <div class="alert alert-danger">
                <h5>Error Loading Machine Matches</h5>
                <p>${err.message}</p>
                <button class="btn btn-sm btn-secondary" onclick="showMachineMatchModal()">Try Again</button>
            </div>
        `;
    });
}


  // document.addEventListener('DOMContentLoaded', function() {
  // let partNoInput = document.getElementById("part_no");
  //   let cfInput = document.getElementById("cf");

  //   partNoInput.addEventListener("input", function () {
  //       if (partNoInput.value.includes("/") ||partNoInput.value.includes(",") ) {
  //           cfInput.value = "1/1";
  //       } else {
  //           cfInput.value = "1";
  //       }
  //   });
  // });
  document.addEventListener('DOMContentLoaded', function () {
      // Untuk proses (biasa)
      document.querySelectorAll('.input-proses').forEach(function (container) {
          var inputProses = container.querySelector('input[name$="[proses]"]');
          if (inputProses) {
              setProsesFields(container, inputProses.value, 'proses-checkbox');
          }
      });

      // Untuk proses gang
      document.querySelectorAll('.input-proses-gang').forEach(function (container) {
          var inputProsesGang = container.querySelector('input[name$="[proses_gang]"]');
          if (inputProsesGang) {
              setProsesFields(container, inputProsesGang.value, 'proses-gang-checkbox');
          }
      });
  });

  function setProsesFields(container, valueStr, checkboxClass) {
    if (!container || typeof valueStr !== 'string') return;

    var parts = valueStr.split('-').map(item => item.trim());
    var selects = container.querySelectorAll('select');
    var checkboxes = container.querySelectorAll('.' + checkboxClass);

    // Reset dropdowns & checkboxes sebelum di-set ulang
    selects.forEach(select => select.value = "");
    checkboxes.forEach(checkbox => checkbox.checked = false);

    let camIndexes = []; // Untuk menyimpan indeks di mana 'CAM' ditemukan
    let processValues = [];

    parts.forEach((part, index) => {
        // Pisah lagi bagian untuk cek apakah mengandung angka
        // Contoh: "BEND 1" → ["BEND", "1"]
        let subParts = part.split(' ').map(p => p.trim());

        // Filter subParts yang bukan angka
        let filteredParts = subParts.filter(p => isNaN(p) || p === '');

        // Ambil bagian tanpa angka, gabungkan kembali
        let valueWithoutNumber = filteredParts.join(' ');

        if (part.toUpperCase().includes("CAM")) {
            camIndexes.push(index);
            // Hapus "CAM" dan trim sisanya untuk dropdown (jangan hapus angka di sini karena sudah di-skip)
            processValues.push(valueWithoutNumber.replace(/CAM/gi, '').trim());
        } else {
            // Jika ada angka, hanya ambil bagian tanpa angka untuk dropdown
            processValues.push(valueWithoutNumber);
        }
    });

    // Set dropdown sesuai urutan
    processValues.forEach((value, index) => {
        if (selects[index]) {
            selects[index].value = value.toUpperCase(); // Set dropdown sesuai urutan
        }
    });

    // Set checkbox CAM sesuai urutan yang ditemukan
    camIndexes.forEach((camIndex) => {
        if (checkboxes[camIndex]) {
            checkboxes[camIndex].checked = true;
        }
    });

}

  const partNoInput = document.getElementById('part_no');
  const cfInput = document.getElementById('cf');

  partNoInput.addEventListener('input', function() {
    const value = partNoInput.value;

    if (value.includes(',') || value.includes('/')) {
      cfInput.value = '1/1';
    } else {
      cfInput.value = '1';
    }
  });
</script>
<script>
function updateProsesGangHidden(containerGang) {
  if (!containerGang) return;
  
  var selects = containerGang.querySelectorAll('select');
  var cb = containerGang.querySelector('input.proses-gang-checkbox');
  var hidden = containerGang.querySelector('input[name*="[proses_gang]"]');

  var gabungan = "";
  if (selects.length >= 3) {
    gabungan = selects[0].value;
    
    if (selects[1].value != null && selects[1].value !== '') {
      gabungan += '-' + selects[1].value;
    }
    if (selects[2].value != null && selects[2].value !== '') {
      gabungan += '-' + selects[2].value;
    }
  }
  
  if (cb && cb.checked) {
    gabungan = "CAM" + (gabungan ? " " + gabungan : "");
  }
  
  if (hidden) {
    hidden.value = gabungan;
  }
}

function updateProsesHidden(containerProses) {
    if (!containerProses) return;

    var selects = containerProses.querySelectorAll('select');
    var checkboxes = containerProses.querySelectorAll('.proses-checkbox');
    var hidden = containerProses.querySelector('input[name*="[proses]"]');

    var gabungan = [];

    selects.forEach((select, index) => {
        if (select.value) {
            var value = select.value;
            if (checkboxes[index] && checkboxes[index].checked) {
                value = "CAM " + value;
            }
            gabungan.push(value);
        }
    });

    hidden.value = gabungan.join('-');
    console.log("Updated proses value:", hidden.value);
}


function updateDCProcessDropdown(rowIndex) {
  console.log("dcprosesdropdown");
  var $row = $('tr[data-index="' + rowIndex + '"]');
  var machine = $row.find('select[name="dies['+ rowIndex +'][machine]"]').val() || "";
  var proses = $row.find('select[name^="dies['+ rowIndex +'][proses_input"]').map(function() {
    return $(this).val();
  }).get().join(" ");
  var process = $row.find('select[name="dies['+ rowIndex +'][process_join]"]').val() || "";
  var processJoin = $row.find('select[name="dies['+ rowIndex +'][proses_gang_input1]"]').val() || "";
   console.log("dcprosesdropdown" + machine + "proses"+ processJoin);
  var machineUpper = machine.toUpperCase();
  var category = "";
  if (/[ADEFG]/.test(machineUpper)) {
    category = "BIG DIE";
  } else if (/[BHC]/.test(machineUpper)) {
    category = "MEDIUM DIE";
  } else {
    category = "SMALL DIE";
  }

  var jenisProses = "";
  if (!processJoin || processJoin.trim() === "" || processJoin.trim() === "-") {
    jenisProses = "SINGLE";
  } else {
    jenisProses = "GANG";
  }

  var prosesValue = "";
  if (category === "BIG DIE") {
   
   jenisProses = "SINGLE";
   if (/DRAW|FORM|FLANGE|BEND|REST/.test(proses)) {
     prosesValue = "DRAW";
   } else if(/CAM-FLANGE/.test(proses)){
     prosesValue = "CAM FLANGE";
   }else if(/FLANGE/.test(proses)){
     prosesValue = "FLANGE";
   }
   else {
     prosesValue = "TRIM";
   }
 } else if (category === "MEDIUM DIE") {
   if (jenisProses === "SINGLE") {
     if (/DRAW|FORM|BEND|REST/.test(proses)) {
       prosesValue = "DRAW";
     } else if (proses.includes("CAM") && proses.includes("PIE")) {
       prosesValue = "CAM PIE";
     } else if (proses.includes("FLANGE") ) {
       prosesValue = "FLANGE";
     } else {
       prosesValue = "TRIM";
     }
   } else { 
     if (/DRAW|FLANGE|FORM|BEND|REST/.test(proses)) {
       prosesValue = "DRAW";
     } else if (proses.includes("CAM") && proses.includes("PIE")) {
       if (processJoin.includes("FLANGE")) {
         prosesValue = "FLANGE-CAM PIE";
       } else {
         prosesValue = "DRAW";
       }
     } else if (proses.includes("FLANGE")) {
       if (processJoin.includes("CAM") && processJoin.includes("PIE")) {
         prosesValue = "FLANGE-CAM PIE";
       } else {
         prosesValue = "DRAW";
       }
     } else {
       prosesValue = "TRIM";
     }
   }
 } else if (category === "SMALL DIE") {
   if (jenisProses === "SINGLE") {
     if (proses.includes("CAM") && proses.includes("PIE")) {
       prosesValue = "CAM PIE";
     }else if (/DRAW|FLANGE|FORM|BEND|PIERCE|REST/.test(proses)) {
       prosesValue = "FORMING";
     } else {
       prosesValue = "BLANK";
     }
   } else if (jenisProses === "GANG") {
     if (proses.includes("BEND") || processJoin.includes("BEND")) {
       prosesValue = "BEND 1, BEND 2";
     } else if (
       (proses.includes("FORM") || processJoin.includes("FORM")) &&
       (proses.includes("PIE") || processJoin.includes("PIE"))
     ) {
       prosesValue = "FORMING, PIE";
     } else if (
       (proses.includes("BLANK") || processJoin.includes("BLANK")) &&
       (proses.includes("PIE") || processJoin.includes("PIE"))
     ) {
       prosesValue = "BLANK-PIE";
     } else if (
       (
             /TRIM|PIE|BLANK|SEP/.test(proses) ||
             /TRIM|PIE|BLANK|SEP/.test(processJoin)
         )
     ) {
       prosesValue = "BLANK-PIE";
     } else {
       prosesValue = "FORM-FLANGE";
     }
   }
 }

  var dcProcessValue = category + "|" + jenisProses + "|" + prosesValue;
  console.log("dcprosesdropdown" +dcProcessValue);

  var $dcProcessDropdown = $row.find('select[name="dies['+ rowIndex +'][dc_process]"]');
  if ($dcProcessDropdown.find('option[value="'+ dcProcessValue +'"]').length > 0) {
    $dcProcessDropdown.val(dcProcessValue);
  }
  var $dieSelect = $('#tableDie tbody').find('tr[data-index="'+ rowIndex +'"] select[name="dies['+ rowIndex +'][dc_process]"]');
  
  if ($dieSelect.length) {
    onStandardChange($dieSelect[0]).then(() => {
        calculateDieWeight($dieSelect[0]);
    }).catch((error) => {
        console.error("Gagal melakukan onStandardChange:", error);
    });
}

}

function updateDieConstructionRow(rowIndex) {
  var basicRow = document.querySelector('#tableBasic tbody tr[data-index="'+ rowIndex +'"]');
  var dieRow = document.querySelector('#tableDie tbody tr[data-index="'+ rowIndex +'"]');
  if (!basicRow) return;
  const prosesInput = basicRow.querySelector('input[name^="dies"][name$="[proses]"]');
  if (/\d/.test(prosesInput.value)) {
      prosesInput.value = '';
  }

  const casting_plate = dieRow.querySelector('[name^="dies"][name$="[casting_plate]"]').value;
  const machine = basicRow.querySelector('[name^="dies"][name$="[machine]"]').value;
  var angka = document.getElementById('material').value;
  var material = parseFloat(angka.replace(/\D/g, '')) || 0;
  var tonasi = parseFloat(document.getElementById('tonasi').value) || 0;

  var upperValue = (casting_plate.includes("plate")) ? "SS41" : "FC300";
  var lowerValue = upperValue;
  var padValue = (casting_plate.includes("plate")) ? "S45C" : "FCD55";

  var insertVal;
  if (material > 440 || tonasi > 1) {
    insertVal = "SKD11";
  } else if (
    proses.toUpperCase().includes("FL") ||
    proses.toUpperCase().includes("DR") ||
    proses.toUpperCase().includes("BE") ||
    proses.toUpperCase().includes("RE") ||
    proses.toUpperCase().includes("FO")
  ) {
    insertVal = "SXACE";
  } else if (proses.toUpperCase().includes("PI")) {
    insertVal = "S45C";
  } else if (
    proses.toUpperCase().includes("BL") ||
    proses.toUpperCase().includes("TR") ||
    proses.toUpperCase().includes("SEP") ||
    proses.toUpperCase().includes("CUT")
  ) {
    insertVal = "SKD11";
  } else {
    insertVal = "";
  }
  var heat_treatment = (insertVal === "SXACE") ? "FULLHARD + COATING" : "FLAMEHARD";
  var padLifterValue = (
    proses.toUpperCase().includes("FL") ||
    proses.toUpperCase().includes("DR") ||
    proses.toUpperCase().includes("BE") ||
    proses.toUpperCase().includes("RE") ||
    proses.toUpperCase().includes("FO")
  ) ? "Coil Spring" : "Gas Spring";
  var slidingValue = "Wear Plate";
  var guideValue = (casting_plate.includes("pplate") ||
                    proses.toUpperCase().includes("BL") ||
                    proses.toUpperCase().includes("CUT") ||
                    proses.toUpperCase().includes("SEP") ||
                    proses.toUpperCase().includes("PIE") ||
                    proses.toUpperCase().includes("TR"))
                    ? "Guide Post" : "GUIDE HEEL";

  var dieConsRow = document.querySelector('#tableDieConstruction tbody tr[data-index="'+ rowIndex +'"]');
  if (!dieConsRow) return;

  // Mengupdate dropdown dengan nilai yang sesuai
  var selectUpper = dieConsRow.querySelector('select[name^="dies"][name$="[upper]"]');
  if (selectUpper) selectUpper.value = upperValue;

  var selectLower = dieConsRow.querySelector('select[name^="dies"][name$="[lower]"]');
  if (selectLower) selectLower.value = lowerValue;

  var selectPad = dieConsRow.querySelector('select[name^="dies"][name$="[pad]"]');
  if (selectPad) selectPad.value = padValue;

  var selectPadLifter = dieConsRow.querySelector('select[name^="dies"][name$="[pad_lifter]"]');
  if (selectPadLifter) selectPadLifter.value = padLifterValue;

  var selectSliding = dieConsRow.querySelector('select[name^="dies"][name$="[sliding]"]');
  if (selectSliding) selectSliding.value = slidingValue;

  var selectGuide = dieConsRow.querySelector('select[name^="dies"][name$="[guide]"]');
  if (selectGuide) selectGuide.value = guideValue;

  var selectInsert = dieConsRow.querySelector('select[name^="dies"][name$="[insert]"]');
  if (selectInsert) selectInsert.value = insertVal;

  var selectHeat = dieConsRow.querySelector('select[name^="dies"][name$="[heat_treatment]"]');
  if (selectHeat) selectHeat.value = heat_treatment;

  // Mengupdate input 'proses' dan 'machine' dengan nilai dari basic row
  var inputProcess = dieConsRow.querySelector('input[name^="dies"][name$="[proses]"]');
  if (inputProcess) inputProcess.value = proses;

  var inputMachine = dieConsRow.querySelector('input[name^="dies"][name$="[machine]"]');
  if (inputMachine) inputMachine.value = machine;
}


// Add event listeners to trigger table update
  // document.addEventListener('DOMContentLoaded', function() {
  //   // Initial generation
  //    updateDieConstructionRow(rowIndex);

  //   // Add listeners to material and tonasi inputs
  //   document.getElementById('material').addEventListener('input', generateDieConstructionTable);
  //   document.getElementById('tonasi').addEventListener('input', generateDieConstructionTable);

  //   // Add listeners to all relevant inputs in tableBasic
  //   const tableBasic = document.getElementById('tableBasic');
  //   tableBasic.addEventListener('change', function(e) {
  //     if (e.target.matches('select, input')) {
  //        updateDieConstructionRow(rowIndex);
  //     }
  //   });
  // });
  function onStandardChange(selectElem) {
    console.log("onstandar");
    return new Promise((resolve, reject) => {
      var selectedStandard = selectElem.value;

      // Ambil table Die dan table Basic
      var dieTableBody = document.getElementById('tableDie').querySelector('tbody');
      var dieRows = Array.from(dieTableBody.querySelectorAll('tr'));
      var rowIndex = dieRows.findIndex(row => row.contains(selectElem));

      // Ambil baris dari tableBasic berdasarkan index
      var basicTable = document.getElementById('tableBasic');
      var basicRows = Array.from(basicTable.querySelectorAll('tbody tr'));
      var basicRow = basicRows[rowIndex];

      var formData = new FormData();
      formData.append('standard', selectedStandard);
      formData.append(csrfName, csrfHash);

      fetch("<?= site_url('pps/fetchStandard') ?>", {
        method: "POST",
        body: formData,
        headers: { "X-Requested-With": "XMLHttpRequest" }
      })
      .then(response => response.json())
      .then(data => {
        if (data.csrfHash) {
          csrfHash = data.csrfHash;
        }

        if (data.error) {
          alert(data.error);
          reject(data.error);
        } else if (data.success) {
          // Data dari server
          var dieLengthValue = parseFloat(data.data['die_length']) || 0;
          var dieWidthValue = parseFloat(data.data['die_width']) || 0;

          // Ambil input panjang & lebar dari basicRow
          var panjangInput = basicRow.querySelector('input[name^="dies"][name*="[panjang]"]');
          var lebarInput = basicRow.querySelector('input[name^="dies"][name*="[lebar]"]');

          var panjang = parseFloat(panjangInput?.value) || 0;
          var lebar = parseFloat(lebarInput?.value) || 0;

          // Hitung hasil akhir
          var finalDieLength = dieLengthValue + panjang;
          var finalDieWidth = dieWidthValue + lebar;

          // Masukkan ke input die_length dan die_width
          var dieRow = dieRows[rowIndex];
          var dieLengthInput = dieRow.querySelector('input[name^="dies"][name*="[die_length]"]');
          var dieWidthInput = dieRow.querySelector('input[name^="dies"][name*="[die_width]"]');

          if (dieLengthInput) dieLengthInput.value = finalDieLength;
          if (dieWidthInput) dieWidthInput.value = finalDieWidth;

          resolve();
        }
      })
      .catch(error => {
        alert("Terjadi kesalahan: " + error);
        console.error(error);
        reject(error);
      });
    });
  }
// cari semua row di tabel Basic
document.querySelectorAll('#tableBasic tbody tr').forEach(row => {
  // cari kedua input panjang & lebar di row ini
  const panjangInput = row.querySelector('input[name*="[panjang]"]');
  const lebarInput  = row.querySelector('input[name*="[lebar]"]');
  // cari select standard/ dieSelect di row ini
  const dieSelect   = row.querySelector('select[name*="[standard]"]');

  // fungsi helper yang akan dipanggil di event input
  function onDieDimensionChange() {
    calculateKeliling(this);
    if (dieSelect) {
      onStandardChange(dieSelect)
        .then(() => calculateDieWeight(dieSelect))
        .catch(err => console.error(err));
    }
  }

  if (panjangInput) panjangInput.addEventListener('input', onDieDimensionChange);
  if (lebarInput)  lebarInput.addEventListener('input', onDieDimensionChange);
});


</script>

<script>
  document.addEventListener('DOMContentLoaded', function () {
  let length = document.getElementById('length');
  let width = document.getElementById('width');
  let tonasi = document.getElementById('tonasi');
  let boq = document.getElementById('boq');
  let blank = document.getElementById('blank');
  let panel = document.getElementById('panel');
  let scrap = document.getElementById('scrap');

  function calculateBlank() {
    let l = parseFloat(length.value) || 0;
    let w = parseFloat(width.value) || 0;
    let t = parseFloat(tonasi.value) || 0;
    let b = parseFloat(boq.value) || 1;

    let tes = (l * w * t * 7.85 / 1000000).toFixed(3);
    let result = ((l * w * t * 7.85 / 1000000) / b).toFixed(3);
    
    blank.value = result;
    
    calculateScrap();
  }

    
  function calculateScrap() {
      let blankVal = parseFloat(blank.value) || 0;
      let panelVal = parseFloat(panel.value) || 0;
      let scrapVal = blankVal - panelVal;
      scrap.value = scrapVal.toFixed(3);
    }
    [length, width, tonasi, boq].forEach(input => {
      input.addEventListener('input', calculateBlank);
    });
    panel.addEventListener('input', calculateScrap);
  });

  function calculateDieWeight(element) {
    console.log("calculateDieWeight");
    var currentRow = element.closest('tr');
    var index = currentRow.getAttribute('data-index');
    var tableId = currentRow.closest('table').id;
    // Jika elemen dipanggil dari tableBasic, kita perlu mencari baris yang sesuai di tableDie
    if (tableId === "tableBasic") {
        currentRow = document.querySelector('#tableDie tr[data-index="' + index + '"]');
        if (!currentRow) {
            console.error("Baris di tableDie dengan data-index " + index + " tidak ditemukan.");
            return;
        }
    }
    
    var dieLengthElem = currentRow.querySelector('input[name$="[die_length]"]');
    var dieWidthElem  = currentRow.querySelector('input[name$="[die_width]"]');
    var dieHeightElem = currentRow.querySelector('input[name$="[die_height]"]');
    var castplateElem = currentRow.querySelector('select[name$="[casting_plate]"]');
    
    var prosesElem = document.querySelector('#tableBasic tr[data-index="' + index + '"] input[name$="[proses]"]');
    
    if (!dieLengthElem || !dieWidthElem || !dieHeightElem || !prosesElem || !castplateElem) {
        console.error("Beberapa elemen tidak ditemukan untuk baris index " + index);
        return;
    }
    
    var dieLength = parseFloat(dieLengthElem.value) || 0;
    var dieWidth  = parseFloat(dieWidthElem.value)  || 0;
    var dieHeight = parseFloat(dieHeightElem.value) || 0;
    
    var prosesValue   = prosesElem.value.toLowerCase();
    var castplateValue = castplateElem.value.toLowerCase();
    
    var factor = 1;
   
    if (castplateValue === "casting") {
        if (prosesValue.includes("bend")) { factor = 0.44; }
        else if (prosesValue.includes("form")|| prosesValue.includes("rest")) { factor = 0.43; }
        else if (prosesValue.includes("blank")) { factor = 0.40; }
        else if (prosesValue.includes("fl")) { factor = 0.40; }
        else if (prosesValue.includes("pie")) { factor = 0.39; }
        else if (prosesValue.includes("trim")|| prosesValue.includes("sep")) { factor = 0.38; }
        else if (prosesValue.includes("draw")) { factor = 0.37; }
        else{
          factor = 0.50; 
        }
    } else if (castplateValue === "plate") {
        if (prosesValue.includes("blank")) { factor = 0.52; }
        else if (prosesValue.includes("trim")|| prosesValue.includes("sep")) { factor = 0.52; }
        else if (prosesValue.includes("bend")) { factor = 0.50; }
        else if (prosesValue.includes("form")|| prosesValue.includes("rest")) { factor = 0.50; }
        else if (prosesValue.includes("pie")) { factor = 0.46; }
        else if (prosesValue.includes("fl")) { factor = 0.46; }
        else if (prosesValue.includes("draw")) { factor = 0.45; }
        else{
          factor = 0.50; 
        }
    }
    var dieWeight = (dieLength * dieWidth * dieHeight * factor * 7.85) / 1000000;
    // console.log("=== Perhitungan Die Weight ===");
    // console.log("dieLength:", dieLength);
    // console.log("dieWidth:", dieWidth);
    // console.log("dieHeight:", dieHeight);
    // console.log("factor:", factor);
    // console.log("7.85 (density)");
    // console.log("Hasil dieWeight:", dieWeight.toFixed(2));
    var dieWeightElem = currentRow.querySelector('input[name$="[die_weight]"]');
    var dieClassElem = currentRow.querySelector('select[name$="[die_class]"]');
    if (dieWeightElem) {
        dieWeightElem.value = dieWeight.toFixed(2);
        
      var dieClass = null;
        if (dieWeight > 6971) {
            dieClass = "A";
        } else if (dieWeight > 3914 && dieWeight <= 6971) {
            dieClass = "B";
        } else if (dieWeight > 1961 && dieWeight <= 3914) {
            dieClass = "C";
        } else if (dieWeight > 848 && dieWeight <= 1961) {
            dieClass = "D";
        } else if (dieWeight > 397 && dieWeight <= 848) {
            dieClass = "E";
        } else if (dieWeight > 0 && dieWeight <= 397) {
            dieClass = "F";
        }
        dieClassElem.value = dieClass;
    } else {
        console.error("Elemen input untuk die_weight tidak ditemukan di baris index " + index);
    }
  }


  // document.addEventListener("DOMContentLoaded", function () {
  //     document.querySelectorAll('#tableDie input, #tableDie select').forEach(function (input) {
  //         input.addEventListener("input", function () {

  //             calculateDieWeight(this);
  //         });
  //     });
  // });
  document.addEventListener("DOMContentLoaded", function () {
    document.querySelectorAll('#tableDie input, #tableDie select').forEach(function (input) {
        input.addEventListener("input", function () {

          if (this.matches('select[name^="dies"][name$="[dc_process]"]')) {
            // Jalankan onStandardChange (Promise)
            onStandardChange(this).then(() => {
              // Setelah selesai ambil data, baru hitung
              calculateDieWeight(this);
            }).catch((error) => {
              console.error("Gagal ambil standard:", error);
            });

          } else {
            // Kalau bukan select dc_process, langsung hitung
            calculateDieWeight(this);
          }

        });
      });

});

function onMachineChange(elem) {
    var machine = $(elem).val();
    var $basicRow = $(elem).closest('tr');
    var index = $basicRow.data('index');

    $('tr[data-index="'+ index +'"] .press-machine').val(machine);

    $.ajax({
      url: "<?= base_url('pps/fetchMachineByMachine') ?>",
      type: "POST",
      dataType: "json",
      data: { machine: machine },
      success: function(response) {
          if (response.success) {
            var basicData = response.data;
            var machineData = response.machine_data;
            var dh_dies = response.dh_dies;
             
            // Update input values in the basic row
            $basicRow.find('input[name*="[capacity]"]').val(basicData.capacity);
            $basicRow.find('input[name*="[cushion]"]').val(basicData.cushion);
            
            // Update press row data
            var $pressRow = $('#tablePress tbody').find('tr[data-index="'+ index +'"]');
            $pressRow.find('input[name*="[machine]"]').val(machineData.machine);
            $pressRow.find('input[name*="[bolster_length]"]').val(machineData.bolster_length);
            $pressRow.find('input[name*="[bolster_width]"]').val(machineData.bolster_width);
            $pressRow.find('input[name*="[slide_area_length]"]').val(machineData.slide_area_length);
            $pressRow.find('input[name*="[slide_area_width]"]').val(machineData.slide_area_width);
            $pressRow.find('input[name*="[slide_stroke]"]').val(machineData.slide_stroke);
            $pressRow.find('input[name*="[die_height_max]"]').val(machineData.die_height);
            $pressRow.find('input[name*="[cushion_pad_length]"]').val(machineData.cushion_pad_length);
            $pressRow.find('input[name*="[cushion_pad_width]"]').val(machineData.cushion_pad_width);
            $pressRow.find('input[name*="[cushion_stroke]"]').val(machineData.cushion_stroke);
           
            // Update die height data
            var $sizingRow = $('#tableDie tbody').find('tr[data-index="'+ index +'"]');
            $sizingRow.find('input[name*="[die_height]"]').val(dh_dies.dh_dies);
            
            // Update dropdown and calculate weight
            updateDCProcessDropdown(index);

            // Call the function to calculate die weight
            calculateDieWeight2(elem); // Pass the current element to the function
          } else {
            console.error(response.error);
          }
      },
      error: function(xhr, status, error) {
        console.log("Error fetching machine data: " + error);
      }
    });
}

  // function calculateKeliling(element) {
  //     var row = element.closest('tr');
  //     if (!row) return;

  //     var panjangInput = row.querySelector('input[name*="[panjang]"]');
  //     var lebarInput = row.querySelector('input[name*="[lebar]"]'); 

  //     if (!panjangInput || !lebarInput) return;

  //     var panjangValue = parseFloat(panjangInput.value) || 0;
  //     var lebarValue   = parseFloat(lebarInput.value)   || 0;

  //     var luas = panjangValue * lebarValue;

  //     var lengthMpInput = row.querySelector('input[name*="[length_mp]"]');
  //     if (lengthMpInput) {  
  //         lengthMpInput.value = luas;
  //         calculateMainPressure(row);
  //     }
  // }
  function calculateKeliling(element) {
    var row = element.closest('tr');
    var index = row.getAttribute('data-index');

    var panjang = parseFloat(row.querySelector(`input[name="dies[${index}][panjang]"]`)?.value) || 0;
    var lebar = parseFloat(row.querySelector(`input[name="dies[${index}][lebar]"]`)?.value) || 0;
    var panjangProses = parseFloat(row.querySelector(`input[name="dies[${index}][panjangProses]"]`)?.value) || 0;
    var diameter = parseFloat(row.querySelector(`input[name="dies[${index}][diameter]"]`)?.value) || 0;
    var jumlahPie = parseFloat(row.querySelector(`input[name="dies[${index}][jumlahPie]"]`)?.value) || 0;

    var checkboxPL = row.querySelector('.cbPanjangLebar');
    var checkboxProses = row.querySelector('.cbPanjangProses');
    var checkboxPie = row.querySelector('.cbPie');

    var keliling = 0;

    if (checkboxPL && checkboxPL.checked) {
        keliling += (panjang * 2) + (lebar * 2);
    }

    if (checkboxProses && checkboxProses.checked) {
        keliling += panjangProses;
    }

    if (checkboxPie && checkboxPie.checked) {
        keliling += 3.14 * diameter * jumlahPie;
    }

    var lengthMpInput = row.querySelector(`input[name="dies[${index}][length_mp]"]`);
    if (lengthMpInput) {
        lengthMpInput.value = keliling.toFixed(2);

        if (typeof calculateMainPressure === 'function') {
            calculateMainPressure(lengthMpInput);
        }
    }
}


  function calculateMainPressure(element) {

    var row = element.closest('tr');

    var lengthMpInput = row.querySelector('input[name*="[length_mp]"]');
    var length_mp = parseFloat((lengthMpInput && lengthMpInput.value) ? lengthMpInput.value : 0) || 0;

    var materialElem = document.getElementById('material');
    var materialText = (materialElem && materialElem.value) ? materialElem.value : "";
    var materialMatch = materialText.match(/\d+/); 
    var material = materialMatch ? parseInt(materialMatch[0]) : 0;

    var tensile_material;
    if (material === 270) {
      tensile_material = 30;
    } else if (material === 440) {
      tensile_material = 45;
    } else if (material === 590) {
      tensile_material = 60;
    } else {
      tensile_material = 100;
    }

    var tonasiElem = document.querySelector('[name="tonasi"]');
    var thickness = (tonasiElem && tonasiElem.value) ? parseFloat(tonasiElem.value) : 0;

    var prosesSelect = row.querySelector('input[name*="[proses]"]');
    var proses = prosesSelect ? prosesSelect.value : '';

    var specialProcesses = ["BLANK", "PIE", "TRIM", "SEP"];
    var multiplier = specialProcesses.some(sp => proses.includes(sp)) ? 1 : 2.5;

    var mainPressure = (length_mp * thickness * 0.8 * tensile_material * 1.2 * multiplier) / 1000;
     console.log("Length MP:", length_mp, "Thickness:", thickness, "Tensile Material:", tensile_material, "Multiplier:", multiplier);

    var mainPressureInput = row.querySelector('input[name*="[main_pressure]"]');
    if (mainPressureInput) {
      mainPressureInput.value = mainPressure.toFixed(2);
    }
  }

  var custSuggestions = ["MMKI", "ADM", "TMMIN", "GMR", "HMMI", "HPM"];

  $(document).ready(function(){
      $('#cust').on('input', function(){
          var inputVal = $(this).val().toLowerCase();
          var suggestionBox = $('#cust-suggestions');
          suggestionBox.empty();
          
          var matches = custSuggestions.filter(function(item){
              return item.toLowerCase().indexOf(inputVal) !== -1;
          });
          
          if(matches.length > 0 && inputVal.length > 0){
              matches.forEach(function(match){
                  suggestionBox.append('<div class="suggestion-item">' + match + '</div>');
              });
              suggestionBox.show();
          } else {
              suggestionBox.hide();
          }
      });

      $('#cust-suggestions').on('click', '.suggestion-item', function(){
          $('#cust').val($(this).text());
          $('#cust-suggestions').hide();
      });

      $(document).on('click', function(event){
          if(!$(event.target).closest('#cust, #cust-suggestions').length){
              $('#cust-suggestions').hide();
          }
      });
  });
</script>
<script>
    var DocSuggestions = ["RFQ"];

    $(document).ready(function(){
        $('#doc_level').on('input', function(){
            var inputVal = $(this).val().toLowerCase();
            var suggestionBox = $('#docsuggestions');
            suggestionBox.empty();
            
            var matches = DocSuggestions.filter(function(item){
                return item.toLowerCase().indexOf(inputVal) !== -1;
            });
            
            if(matches.length > 0 && inputVal.length > 0){
                matches.forEach(function(match){
                    suggestionBox.append('<div class="suggestion-item">' + match + '</div>');
                });
                suggestionBox.show();
            } else {
                suggestionBox.hide();
            }
        });

       $('#docsuggestions').on('click', '.suggestion-item', function(){
            $('#doc_level').val($(this).text());
            $('#docsuggestions').hide();
        });

        $(document).on('click', function(event){
            if(!$(event.target).closest('#cust, #cust-suggestions').length){
                $('#cust-suggestions').hide();
            }
        });
    });
</script>
<script>
    var custSuggestions = ["MMKI", "ADM", "TMMIN", "GMR", "HMMI"];

    $(document).ready(function(){
        $('#cust').on('input', function(){
            var inputVal = $(this).val().toLowerCase();
            var suggestionBox = $('#cust-suggestions');
            suggestionBox.empty();
            
            var matches = custSuggestions.filter(function(item){
                return item.toLowerCase().indexOf(inputVal) !== -1;
            });
            
            if(matches.length > 0 && inputVal.length > 0){
                matches.forEach(function(match){
                    suggestionBox.append('<div class="suggestion-item">' + match + '</div>');
                });
                suggestionBox.show();
            } else {
                suggestionBox.hide();
            }
        });

        $('#cust-suggestions').on('click', '.suggestion-item', function(){
            $('#cust').val($(this).text());
            $('#cust-suggestions').hide();
        });

        $(document).on('click', function(event){
            if(!$(event.target).closest('#cust, #cust-suggestions').length){
                $('#cust-suggestions').hide();
            }
        });
    });
</script>
<script>
document.addEventListener('DOMContentLoaded', function () {
  let length = document.getElementById('length');
  let width = document.getElementById('width');
  let tonasi = document.getElementById('tonasi');
  let boq = document.getElementById('boq');
  let blank = document.getElementById('blank');
  let panel = document.getElementById('panel');
  let scrap = document.getElementById('scrap');

  function calculateBlank() {
    let l = parseFloat(length.value) || 0;
    let w = parseFloat(width.value) || 0;
    let t = parseFloat(tonasi.value) || 0;
    let b = parseFloat(boq.value) || 1;

    let tes = (l * w * t * 7.85 / 1000000).toFixed(3);
    let result = ((l * w * t * 7.85 / 1000000) / b).toFixed(3);
    
    blank.value = result;
    
    calculateScrap();
}

  
function calculateScrap() {
  let blankVal = parseFloat(blank.value) || 0;
  let panelVal = parseFloat(panel.value) || 0;
  let scrapVal = blankVal - panelVal;
  scrap.value = scrapVal.toFixed(3);
  
  let scrapError = document.getElementById('scrapError');
  if (scrapVal < 0) {
    scrapError.textContent = "Warning: Nilai Scrap negatif!";
  } else {
    scrapError.textContent = "";
  }
}

  [length, width, tonasi, boq].forEach(input => {
    input.addEventListener('input', calculateBlank);
  });
  panel.addEventListener('input', calculateScrap);
});
function calculateTotalMP() {
    // Ambil semua select dengan name yang mengandung [machine]
    var machineSelects = document.querySelectorAll('select[name^="dies"][name$="[machine]"]');
    var totalMP = 0;

    machineSelects.forEach(function(select) {
        var machineVal = select.value.toUpperCase();

        if (machineVal.includes("E")) {
            totalMP = 3; // Langsung 3, tidak ditambah
            
        } else if (machineVal.includes("SP")) {
            totalMP += 1;
        } else {
            totalMP += 2;
        }
    });

    document.getElementById('total_mp').value = totalMP;
}
function attachProcessChangeListener(row) {
    const index = row.getAttribute('data-index');

    const prosesInputFields = row.querySelectorAll(
      'select[name^="dies[' + index + '][proses_input"]'
    );
    const prosesGangInputFields = row.querySelectorAll(
      'select[name^="dies[' + index + '][proses_gang_input"]'
    );

    // Listener untuk proses_input
    prosesInputFields.forEach(select => {
      select.addEventListener('change', () => {
        const prosesValue = row.querySelector('input[name="dies[' + index + '][proses]"]').value;
        loadPpsImageList(index, prosesValue);
      });
    });

    // Listener untuk proses_gang_input
    prosesGangInputFields.forEach(select => {
      select.addEventListener('change', () => {
        const prosesGangValue = row.querySelector('input[name="dies[' + index + '][proses_gang]"]').value;
        loadPpsImageList(index, prosesGangValue);
      });
    });
  }

  // Jalankan untuk semua baris awal saat halaman dimuat
  document.addEventListener('DOMContentLoaded', () => {
    const rows = document.querySelectorAll('#tableBasic tbody tr');
    rows.forEach(row => {
      attachProcessChangeListener(row);
    });
  });

function loadPpsImageList(index, process) {
  fetch("<?= base_url('Pps/listDieConsImg') ?>?process=" + encodeURIComponent(process))
    .then(res => res.json())
    .then(images => {
      const container = document.getElementById(`dieconsList_${index}`);
      const previewId = `die_construction_preview_${index}`;
      const hiddenInputId = `selected_die_construction_${index}`;

      container.innerHTML = '';
      images.forEach(imgPath => {
        const img = document.createElement('img');
        img.src = imgPath;
        img.addEventListener('click', () => {
          document.getElementById(previewId).src = imgPath;
          document.getElementById(previewId).style.display = 'block';
          document.getElementById(hiddenInputId).value = imgPath;

          container.querySelectorAll('img').forEach(i => i.style.border = '2px solid transparent');
          img.style.border = '2px solid green';
        });
        container.appendChild(img);
      });
    });
}
function scrollSlider(direction, index) {
  const container = document.getElementById(`processList_${index}`);
  const scrollAmount = 150;
  if (direction === 'left') {
    container.scrollBy({ left: -scrollAmount, behavior: 'smooth' });
  } else {
    container.scrollBy({ left: scrollAmount, behavior: 'smooth' });
  }
  
}

function scrollSlider2(direction, index) {
  const container = document.getElementById(`dieconsList_${index}`);
  const scrollAmount = 150;
  if (!container) return;

  container.scrollBy({
    left: direction === 'left' ? -scrollAmount : scrollAmount,
    behavior: 'smooth'
  });
}

document.addEventListener('DOMContentLoaded', () => {
    <?php if (!empty($dies)): ?>
      <?php foreach ($dies as $index => $die): ?>
        loadPpsImageList(<?= $index ?>, "<?= str_replace(' ', '-', $die['proses']) ?>");
      <?php endforeach; ?>
    <?php else: ?>
      loadPpsImageList(0, '');
    <?php endif; ?>
  });

  function scrollSlider(direction) {
    const container = document.getElementById('processList');
    const scrollAmount = 150;

    if (direction === 'left') {
      container.scrollLeft -= scrollAmount;
    } else if (direction === 'right') {
      container.scrollLeft += scrollAmount;
    }
  }
  function calculateDieWeight2(element) {
    console.log("die2");

    // Ambil index baris dari atribut data-index
    var index = element.closest("tr").getAttribute("data-index");

    // Cari baris di #tableDie yang sesuai
    var dieTableRow = document.querySelector('#tableDie tbody tr[data-index="' + index + '"]');

    if (!dieTableRow) {
        console.error("Baris tidak ditemukan di #tableDie untuk index:", index);
        return;
    }

    // Ambil input dari tabel #tableDie
    var dieLength = parseFloat(dieTableRow.querySelector('input[name="dies[' + index + '][die_length]"]')?.value) || 0;
    var dieWidth = parseFloat(dieTableRow.querySelector('input[name="dies[' + index + '][die_width]"]')?.value) || 0;
    var dieHeight = parseFloat(dieTableRow.querySelector('input[name="dies[' + index + '][die_height]"]')?.value) || 0;

    var dieProsesStandardDieElem = dieTableRow.querySelector('select[name="dies[' + index + '][dc_process]"]');
    var castplateElem = dieTableRow.querySelector('select[name="dies[' + index + '][casting_plate]"]');

    if (!castplateElem) {
        console.error("Elemen casting_plate tidak ditemukan di #tableDie.");
        return;
    }

    // Ambil nilai proses dari #tableBasic berdasarkan index
    var basicTableRow = document.querySelector('#tableBasic tbody tr[data-index="' + index + '"]');
    if (!basicTableRow) {
        console.error("Baris tidak ditemukan di #tableBasic untuk index:", index);
        return;
    }

    var prosesElem = basicTableRow.querySelector('input[name="dies[' + index + '][proses]"]');
    var prosesValue = prosesElem ? prosesElem.value.toLowerCase() : "";

    var castplateValue = castplateElem.value.toLowerCase();
    var factor = 1;

    // Proses penghitungan berat die
    if (castplateValue === "casting") {
        if (prosesValue.includes("bend")) factor = 0.44;
        else if (prosesValue.includes("form") || prosesValue.includes("rest")) factor = 0.43;
        else if (prosesValue.includes("blank")) factor = 0.40;
        else if (prosesValue.includes("flange")) factor = 0.40;
        else if (prosesValue.includes("pie")) factor = 0.39;
        else if (prosesValue.includes("trim") || prosesValue.includes("sep")) factor = 0.38;
        else if (prosesValue.includes("draw")) factor = 0.37;
    } else if (castplateValue.includes("plate")) {
        if (prosesValue.includes("blank") || prosesValue.includes("trim") || prosesValue.includes("sep")) factor = 0.52;
        else if (prosesValue.includes("bend") || prosesValue.includes("form") || prosesValue.includes("rest")) factor = 0.50;
        else if (prosesValue.includes("pie") || prosesValue.includes("fl")) factor = 0.46;
        else if (prosesValue.includes("draw")) factor = 0.45;
    }

    var dieWeight = (dieLength * dieWidth * dieHeight * factor * 7.85) / 1000000;
    var dieWeightElem = dieTableRow.querySelector('input[name="dies[' + index + '][die_weight]"]');
    var dieClassElem = dieTableRow.querySelector('select[name="dies[' + index + '][die_class]"]');
    if (dieWeightElem) {
        dieWeightElem.value = dieWeight.toFixed(2);
        // console.log("Berat die dihitung:", dieWeightElem.value);


        var dieClass = null;
        if (dieWeight > 6971) {
            dieClass = "A";
        } else if (dieWeight > 3914 && dieWeight <= 6971) {
            dieClass = "B";
        } else if (dieWeight > 1961 && dieWeight <= 3914) {
            dieClass = "C";
        } else if (dieWeight > 848 && dieWeight <= 1961) {
            dieClass = "D";
        } else if (dieWeight > 397 && dieWeight <= 848) {
            dieClass = "E";
        } else if (dieWeight > 0 && dieWeight <= 397) {
            dieClass = "F";
        }
        dieClassElem.value = dieClass;

    } else {
        console.error("Input untuk die_weight tidak ditemukan.");
    }
  }
</script>
<script>
  // Saat user pilih gambar dari list
  function selectProcessLayout(imgUrl) {
    document.getElementById('processSelected').value = imgUrl;
    document.getElementById('processPreview').src = imgUrl;

    // Kosongkan input file jika sebelumnya upload
    document.getElementById('processUpload').value = '';
  }

  // Saat user upload gambar, kosongkan pilihan dari list
  document.getElementById('processUpload').addEventListener('change', function () {
    document.getElementById('processSelected').value = '';
    if (this.files[0]) {
      document.getElementById('processPreview').src = URL.createObjectURL(this.files[0]);
    }
  });
</script>
<script>
  document.addEventListener('DOMContentLoaded', function() {
    const partNoSelect = document.getElementById('part_no_select');
    partNoSelect.addEventListener('change', function() {
      const selectedOption = partNoSelect.options[partNoSelect.selectedIndex];
      if (selectedOption.value) {
        document.getElementById('model').value = selectedOption.getAttribute('data-model');
        document.getElementById('part_no').value = selectedOption.getAttribute('data-part_no');
        document.getElementById('part_name').value = selectedOption.getAttribute('data-part_name');
        document.getElementById('cust').value = selectedOption.getAttribute('data-customer');
      } else {
        document.getElementById('model').value = '';
        document.getElementById('part_no').value = '';
        document.getElementById('part_name').value = '';
        document.getElementById('cust').value = '';
      }
    });

    // Support untuk Select2
    if (window.jQuery && $.fn.select2) {
      $('#part_no_select').on('select2:select', function(e) {
        const selectedOption = $(this).find('option:selected');
        $('#model').val(selectedOption.data('model'));
        $('#part_no').val(selectedOption.data('part_no'));
        $('#part_name').val(selectedOption.data('part_name'));
        $('#cust').val(selectedOption.data('customer'));
      });
    }
  });
</script>
<script>
  $(document).ready(function() {
    // Inisialisasi Select2 jika digunakan
    $('.custom-select2').select2();

    // Saat dropdown material dipilih
    $('#materialDropdown').on('change', function() {
      const selectedMaterial = $(this).val();
      $('#material').val(selectedMaterial);
    });

    // Trigger saat halaman dimuat (jika ada nilai default)
    $('#material').val($('#materialDropdown').val());
  });
  
</script>
<script>
// 1) Hook perubahan pada dropdown “Die Standard” di tableDie
document
  .querySelector('#tableDie tbody')
  .addEventListener('change', function(e){
    // cek kalau yang berubah adalah select dc_process
    if (!e.target.matches('select[name*="[dc_process]"]')) return;
    const dieSelect = e.target;
    onStandardChange(dieSelect)
      .then(() => hitungDieWeight(dieSelect))
      .catch(err => console.error(err));
  });

// 2) Hook input panjang/lebar di tableBasic
function bindBasicDimensionListeners() {
  document.querySelectorAll('#tableBasic tbody tr').forEach(row => {
    const panjangInput = row.querySelector('input[name*="[panjang]"]');
    const lebarInput  = row.querySelector('input[name*="[lebar]"]');

    function onDieDimensionChange() {
      calculateKeliling(this);
      // setelah hitung luas, trigger onStandardChange & hitungDieWeight
      // cari dieSelect di baris DIE yang sama (sama index)
      const idx = row.getAttribute('data-index');
      const dieRow = document.querySelector(`#tableDie tbody tr[data-index="${idx}"]`);
      if (dieRow) {
        const dieSelect = dieRow.querySelector('select[name*="[dc_process]"]');
        if (dieSelect) {
          onStandardChange(dieSelect)
            .then(() => hitungDieWeight(dieSelect))
            .catch(err => console.error(err));
        }
      }
    }

    if (panjangInput) panjangInput.addEventListener('input', onDieDimensionChange);
    if (lebarInput)  lebarInput.addEventListener('input', onDieDimensionChange);
  });
}
function togglePieInputsEditable(row) {
  // Logic lama
  const prosesInputs = Array.from(row.querySelectorAll('input[name^="dies["][name$="[proses]"]'));
  const prosesGangInputs = Array.from(row.querySelectorAll('input[name^="dies["][name$="[proses_gang]"]'));
  const allProcesses = [
    ...prosesInputs.map(input => input.value.toUpperCase()),
    ...prosesGangInputs.map(input => input.value.toUpperCase())
  ].filter(Boolean);
  const inputDiameter = row.querySelector('input[name^="dies["][name$="[diameter]"]');
  const inputJumlahPie = row.querySelector('input[name^="dies["][name$="[jumlahPie]"]');
  const inputPanjangProses = row.querySelector('input[name^="dies["][name$="[panjangProses]"]');

  const hasPie = allProcesses.some(process => process.includes("PIE"));
  const hasBendTrimSepRest = allProcesses.some(process => /BEND|TRIM|SEP|REST/.test(process));

  inputDiameter.readOnly = true;
  inputJumlahPie.readOnly = true;
  inputPanjangProses.readOnly = true;

  if (hasPie && hasBendTrimSepRest) {
    inputDiameter.readOnly = false;
    inputJumlahPie.readOnly = false;
    inputPanjangProses.readOnly = false;
  } else if (hasPie) {
    inputDiameter.readOnly = false;
    inputJumlahPie.readOnly = false;
  } else if (hasBendTrimSepRest) {
    inputPanjangProses.readOnly = false;
  }

  // Tambahan toggle manual via checkbox
  // toggleManualReadonly(row);
}

function updateAllRows() {
    var allRows = document.getElementById('tableBasic').querySelectorAll('tr');

    // Hitung semua kemunculan proses (dari proses_input dan proses_gang_input) di semua baris
    var totalValueCounts = {};
    allRows.forEach((tableRow) => {
        // Proses di input-proses (select + checkbox)
        const prosesContainer = tableRow.querySelector('.input-proses');
        if (prosesContainer) {
            const selects = prosesContainer.querySelectorAll('select');

            selects.forEach((select, i) => {
                if (select.value) {
                    let val = select.value.trim().toUpperCase();
                  
                    totalValueCounts[val] = (totalValueCounts[val] || 0) + 1;
                }
            });
        }

        // Proses di input-proses-gang (select + checkbox)
        const gangContainer = tableRow.querySelector('.input-proses-gang');
        if (gangContainer) {
            const selects = gangContainer.querySelectorAll('select');

            selects.forEach((select, i) => {
                if (select.value) {
                    let val = select.value.trim().toUpperCase();
                 
                    totalValueCounts[val] = (totalValueCounts[val] || 0) + 1;
                }
            });
        }
    });

    // Beri nomor urut berdasarkan kemunculan saat ini, simpan di currentOccurrenceCount
    var currentOccurrenceCount = {};

    allRows.forEach((row, rowIndex) => {
        updateRowProsesNumbering(row, currentOccurrenceCount);
        updateRowGangNumbering(row, currentOccurrenceCount);
    });
}

function updateRowProsesNumbering(row, occurrenceCounter) {
    const container = row.querySelector('.input-proses');
    if (!container) return;

    const selects = container.querySelectorAll('select');
    const checkboxes = container.querySelectorAll('.proses-checkbox');
    const hiddenInput = container.querySelector('input[name$="[proses]"]');

    let prosesArr = [];

    selects.forEach((select, i) => {
        let val = select.value.trim().toUpperCase();

        if (val === "") return; // skip jika kosong

        // Untuk angka 1 atau 2, langsung dimasukkan tanpa nomor
        if (val === "1" || val === "2") {
            prosesArr.push(val);
        } else {
            // Hitung nomor berdasarkan nilai dropdown saja tanpa mempedulikan checkbox
            occurrenceCounter[val] = (occurrenceCounter[val] || 0) + 1;
            let nomor = occurrenceCounter[val];

            // Beri prefix CAM jika checkbox dicentang
            let isCam = checkboxes[i] && checkboxes[i].checked;

            let fullVal = (isCam ? "CAM " : "") + val + " " + nomor;

            prosesArr.push(fullVal.trim());
        }
    });

    hiddenInput.value = prosesArr.join("-");
}


function updateRowGangNumbering(row, occurrenceCounter) {
    const container = row.querySelector('.input-proses-gang');
    if (!container) return;

    const selects = container.querySelectorAll('select');
    const checkboxes = container.querySelectorAll('.proses-gang-checkbox');
    const hiddenInput = container.querySelector('input[name$="[proses_gang]"]');

    let prosesArr = [];

    selects.forEach((select, i) => {
        let val = select.value.trim().toUpperCase();

        if (val === "") return;

        if (val === "1" || val === "2") {
            prosesArr.push(val);
        } else {
            occurrenceCounter[val] = (occurrenceCounter[val] || 0) + 1;
            let nomor = occurrenceCounter[val];

            let isCam = checkboxes[i] && checkboxes[i].checked;

            let fullVal = (isCam ? "CAM " : "") + val + " " + nomor;

            prosesArr.push(fullVal.trim());
        }
    });

    hiddenInput.value = prosesArr.join("-");
}



// panggil sekali saat halaman ready
bindBasicDimensionListeners();
function toggleManualReadonly(row) {
  const panjangProsesCb = row.querySelector('.cbPanjangProses');
  const panjangProsesInput = row.querySelector('input[name^="dies["][name$="[panjangProses]"]');

  const pieCb = row.querySelector('.cbPie');
  const diameterInput = row.querySelector('input[name^="dies["][name$="[diameter]"]');
  const jumlahPieInput = row.querySelector('input[name^="dies["][name$="[jumlahPie]"]');

  // Panjang proses
  if (panjangProsesCb && panjangProsesInput) {
    if (panjangProsesCb.checked) {
      panjangProsesInput.readOnly = false;
    } else {
      panjangProsesInput.readOnly = true;
      panjangProsesInput.value = '';
    }
  }

  // Pie
  if (pieCb && diameterInput && jumlahPieInput) {
    if (pieCb.checked) {
      diameterInput.readOnly = false;
      jumlahPieInput.readOnly = false;
    } else {
      diameterInput.readOnly = true;
      jumlahPieInput.readOnly = true;
      diameterInput.value = '';
      jumlahPieInput.value = '';
    }
  }

  // Panggil keliling
  calculateKeliling(row);
}

window.addEventListener('DOMContentLoaded', function () {
  document.querySelectorAll('tr[data-index]').forEach(function (row) {
    toggleManualReadonly(row);
  });
});

// jika kamu menambahkan baris baru secara dinamis di #tableBasic,
// panggil kembali bindBasicDimensionListeners() setelah row ditambahkan.
</script>


<?= $this->endSection() ?>
