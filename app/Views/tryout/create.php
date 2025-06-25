<?= $this->extend('layout/template') ?>
<?= $this->section('content') ?>

<div class="pd-ltr-20 xs-pd-20-10">
    <div class="min-height-200px">
        <div class="page-header">
            <div class="row">
                <div class="col-md-6 col-sm-12">
                    <div class="title">
                        <h4>Tambah Try Out Report Dies</h4>
                    </div>
                    <nav aria-label="breadcrumb" role="navigation">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="<?= site_url('dashboard'); ?>">Home</a></li>
                            <li class="breadcrumb-item"><a href="<?= site_url('tryout'); ?>">Tryout</a></li>
                            <li class="breadcrumb-item active" aria-current="page">Form Tambah Tryout</li>
                        </ol>
                    </nav>
                </div>
            </div>
        </div>

        <div class="pd-20 card-box mb-30">
    <form action="<?= site_url('tryout/store'); ?>" method="post" enctype="multipart/form-data">
        <?= csrf_field(); ?>

        <h4 class="mt-4 mb-3"><strong>MACHINE PARAMETER</strong></h4>

<div class="card shadow-sm p-3 mb-4">
    <div class="row">
        <!-- Project Field (Moved to First Position) -->
        <div class="col-md-6">
            <label class="font-weight-bold">Projek <span class="text-danger">*</span></label>
            <div class="input-group">
                <select name="projek" class="form-control" required>
                    <option value="">Pilih Projek</option>
                    <option value="D14N">D14N</option>
                    <option value="D26A">D26A</option>
                    <option value="D30D">D30D</option>
                    <option value="D40">D40</option>
                    <option value="D40D">D40D</option>
                    <option value="D40L">D40L</option>
                    <option value="D55L">D55L</option>
                    <option value="D72A">D72A</option>
                    <option value="D74A">D74A</option>
                    <option value="D03B">D03B</option>
                    <option value="SL">SL</option>
                    <option value="KS">KS</option>
                    <option value="KS-FL">KS-FL</option>
                    <option value="SU2ID">SU2ID</option>
                    <option value="SU2ID-FL">SU2ID-FL</option>
                    <option value="YL0">YL0</option>
                    <option value="2MD">2MD</option>
                </select>
            </div>
        </div>

        <!-- Part No (Moved to Second Position) -->
        <div class="col-md-6">
            <label class="font-weight-bold">Part No <span class="text-danger">*</span></label>
            <select id="project_id" name="project_id" class="custom-select2 form-control" required>
                <option value="">Pilih Part No</option>
                <?php foreach ($projects as $project): ?>
                    <?php if ($project['status'] == 1 && $project['part_no'] != '-' && $project['jenis'] == 'Tooling Project'): ?>
                        <option value="<?= $project['id']; ?>" data-process="<?= $project['process']; ?>">
                            <?= $project['part_no'] . ' - ' . $project['process']; ?>
                        </option>
                    <?php endif; ?>
                <?php endforeach; ?>
            </select>
        </div>
    </div>

    <div class="row mt-3">
        <!-- Material -->
        <div class="col-md-6">
            <label class="font-weight-bold">MATERIAL</label>
            <input type="text" name="material" class="form-control">
        </div>
        
        <!-- M/C LINE -->
        <div class="col-md-6">
    <label class="font-weight-bold">M/C LINE</label>
    <select name="mc_line" class="form-control">
        <option value="">-- Pilih M/C LINE --</option>
        <option value="A1">A1</option><option value="A2">A2</option><option value="A3">A3</option><option value="A4">A4</option>
        <option value="B1">B1</option><option value="B2">B2</option><option value="B3">B3</option><option value="B4">B4</option>
        <option value="C1">C1</option><option value="C2">C2</option><option value="C3">C3</option><option value="C4">C4</option>
        <option value="D1">D1</option><option value="D2">D2</option><option value="D3">D3</option><option value="D4">D4</option>
        <option value="E1">E1</option><option value="E2">E2</option><option value="E3">E3</option><option value="E4">E4</option>
        <option value="F1">F1</option><option value="F2">F2</option><option value="F3">F3</option><option value="F4">F4</option>
        <option value="G1">G1</option><option value="G2">G2</option><option value="G3">G3</option><option value="G4">G4</option>
        <option value="H1">H1</option><option value="H2">H2</option><option value="H3">H3</option><option value="H4">H4</option><option value="H1">80 T E1</option>
        <option value="150 T C1">150 T C1</option><option value="150 T C2">150 T C2</option><option value="150 T C3">150 T C3</option><option value="150 T C4">150 T C4</option><option value="110 T D1">110 T D1</option><option value="110 T D2">110 T D2</option><option value="110 T D3">110 T D3</option><option value="110 T D4">110 T D4</option>
        <option value="150 T A1">150 T A1</option><option value="150 T A2">150 T A2</option><option value="150 T A3">150 T A3</option><option value="150 T A4">150 T A4</option><option value="150 T B1">150 T B1</option><option value="150 T B2">150 T B2</option><option value="150 T B3">150 T B3</option><option value="150 T B4">150 T B4</option>
        <option value="300 T (I)">300 T (I)</option><option value="300 T (II)">300 T (II)</option>
    </select>
</div>

    </div>

    <!-- Baris Parameter Mesin -->
    <div class="row mt-3">
        <div class="col-md-6">
            <label class="font-weight-bold">SLIDE / DH</label>
            <div class="input-group">
                <input type="number" step="any" name="slide_dh" class="form-control">
                <div class="input-group-append"><span class="input-group-text">mm</span></div>
            </div>
        </div>
        <div class="col-md-6">
            <label class="font-weight-bold">ADAPTOR</label>
            <div class="input-group">
                <input type="number" step="any" name="adaptor" class="form-control">
                <div class="input-group-append"><span class="input-group-text">mm</span></div>
            </div>
        </div>
    </div>

    <div class="row mt-3">
        <div class="col-md-6">
            <label class="font-weight-bold">CUSH. PRESS</label>
            <div class="input-group">
                <input type="number" step="any" name="cush_press" class="form-control">
                <div class="input-group-append">
                    <select name="cush_press_unit" class="custom-select">
                        <option value="kg/cm²">kg/cm²</option>
                        <option value="ton">ton</option>
                        <option value="MPa">MPa</option>
                    </select>
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <label class="font-weight-bold">CUSH. HEIGHT</label>
            <div class="input-group">
                <input type="number" step="any" name="cush_h" class="form-control">
                <div class="input-group-append"><span class="input-group-text">mm</span></div>
            </div>
        </div>
    </div>

    <div class="row mt-3">
        <div class="col-md-6">
            <label class="font-weight-bold">MAIN PRESS</label>
            <div class="input-group">
                <input type="number" step="any" name="main_press" class="form-control">
                <div class="input-group-append"><span class="input-group-text">N</span></div>
            </div>
        </div>
        <div class="col-md-6">
            <label class="font-weight-bold">SPM</label>
            <div class="input-group">
                <input type="number" step="any" id="spm" name="spm" class="form-control" oninput="updateSTD()">
                <div class="input-group-append"><span class="input-group-text">stroke</span></div>
            </div>
        </div>
    </div>

    <div class="row mt-3">
        <div class="col-md-6">
            <label class="font-weight-bold">GSPH</label>
            <div class="input-group">
                <input type="number" step="any" name="gsph" class="form-control">
                <div class="input-group-append"><span class="input-group-text">stroke/jam</span></div>
            </div>
        </div>
        <div class="col-md-6">
            <label class="font-weight-bold">BOOLSTER</label>
            <select name="boolster" class="form-control">
                <option value="">Pilih BOOLSTER</option>
                <option value="RH">RH</option>
                <option value="LH">LH</option>
                <option value="FR">FR</option>
                <option value="RR">RR</option>
            </select>
        </div>
    </div>

    <div class="row mt-3">
        <div class="col-md-6">
            <label class="font-weight-bold">Step</label>
            <select name="step" class="form-control" >
                <option value="">Pilih Step</option>
                <?php for ($i = 1; $i <= 10; $i++): ?>
                    <option value="T<?= $i ?>">T<?= $i ?></option>
                <?php endfor; ?>
            </select>
        </div>
        <div class="col-md-6">
            <label class="font-weight-bold">Event</label>
            <input type="text" name="event" class="form-control" >
        </div>
    </div>
    
    <div class="row mt-3">
    <div class="col-md-6">
        <label class="font-weight-bold">Pilih Activity <span class="text-danger">*</span></label>
        <select name="activity" class="form-control" required>
            <option value="Tryout Report Dies">Tryout Report Dies</option>
            <option value="Tryout Report Jig">Tryout Report Jig</option>
            <option value="Tryout Report Maintenance">Tryout Report Maintenance</option>
        </select>
    </div>
        <div class="col-md-6">
            <label class="font-weight-bold">Costumer<span class="text-danger">*</span></label>
            <div class="input-group">
                <select name="cust" class="form-control" required>
                    <option value="">Pilih Customer</option>
                    <option value="ADM">ADM</option>
                    <option value="TMMIN">TMMIN</option>
                    <option value="MKM">MKM</option>
                    <option value="MMKI">MMKI</option>
                    <option value="HMMI">HMMI</option>
                    <option value="SUZUKI">SUZUKI</option>
                    <option value="GMR">GMR</option>
                    <option value="HPM">HPM</option>
                </select>
            </div>
        </div>
    </div>
</div>

        <!-- Judul: ADD IMAGE -->
        <h4 class="mt-4 mb-3"><strong>ADD IMAGE</strong></h4>

<div class="card shadow-sm p-3 mb-4">
  <div class="row">
    <!-- Image Part Trial -->
    <div class="col-md-6 text-center">
      <label class="font-weight-bold">Image Part Trial</label>
      <div class="border p-2 rounded bg-light mb-2">
        <img id="previewPartTrial" src="#" alt="Preview Image Part Trial" class="img-fluid img-thumbnail mb-2" style="display: none; max-width: 100%; height: 200px;">
        <!-- Opsi untuk memilih sumber gambar -->
        <div class="mb-2">
          <input type="radio" name="part_trial_source" id="part_trial_camera" value="camera">
          <label for="part_trial_camera">Kamera</label>
          <input type="radio" name="part_trial_source" id="part_trial_file" value="file" checked>
          <label for="part_trial_file">Pilih File</label>
        </div>
        <!-- Input file untuk kamera -->
        <input type="file" name="part_trial_image_camera" id="part_trial_image_camera" class="form-control-file" accept="image/*" capture="environment" style="display: none;" onchange="previewImage(event, 'previewPartTrial')">
        <!-- Input file untuk memilih file dari direktori -->
        <input type="file" name="part_trial_image" id="part_trial_image" class="form-control-file" accept="image/*" style="display: block;" onchange="previewImage(event, 'previewPartTrial')">
      </div>
    </div>
    
    <!-- Image Material -->
    <div class="col-md-6 text-center">
      <label class="font-weight-bold">Image Material</label>
      <div class="border p-2 rounded bg-light mb-2">
        <img id="previewMaterial" src="#" alt="Preview Image Material" class="img-fluid img-thumbnail mb-2" style="display: none; max-width: 100%; height: 200px;">
        <!-- Opsi untuk memilih sumber gambar -->
        <div class="mb-2">
          <input type="radio" name="material_source" id="material_camera" value="camera">
          <label for="material_camera">Kamera</label>
          <input type="radio" name="material_source" id="material_file" value="file" checked>
          <label for="material_file">Pilih File</label>
        </div>
        <!-- Input file untuk kamera -->
        <input type="file" name="material_image_camera" id="material_image_camera" class="form-control-file" accept="image/*" capture="environment" style="display: none;" onchange="previewImage(event, 'previewMaterial')">
        <!-- Input file untuk memilih file dari direktori -->
        <input type="file" name="material_image" id="material_image" class="form-control-file" accept="image/*" style="display: block;" onchange="previewImage(event, 'previewMaterial')">
      </div>
    </div>
  </div>
</div>

        <!-- Sub Bab: KUANTITAS MATERIAL -->
        <h4 class="mt-4 mb-3"><strong>KUANTITAS MATERIAL</strong></h4>
        <div class="card shadow-sm p-3 mb-4">
            <div class="row">
                <div class="col-md-4">
                    <label class="font-weight-bold">Pakai</label>
                    <div class="input-group">
                        <input type="number" step="any" name="material_pakai" class="form-control">
                        <div class="input-group-append"><span class="input-group-text">pcs</span></div>
                    </div>
                </div>
                <div class="col-md-4">
                    <label class="font-weight-bold">Sisa</label>
                    <div class="input-group">
                        <input type="number" step="any" name="material_sisa" class="form-control">
                        <div class="input-group-append"><span class="input-group-text">pcs</span></div>
                    </div>
                </div>
                <div class="col-md-4">
                <label class="font-weight-bold">Panel OKE</label>
                    <div class="input-group">
                        <input type="number" step="any" name="panel_ok" class="form-control">
                        <div class="input-group-append"><span class="input-group-text">pcs</span></div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Sub Bab: KUANTITAS PART -->
        <h4 class="mt-4 mb-3"><strong>KUANTITAS PART</strong></h4>
<div class="card shadow-sm p-3 mb-4">
    <div class="row">
        <div class="col-md-4">
            <label class="font-weight-bold">Target</label>
            <div class="input-group">
                <input type="number" step="any" name="part_target" class="form-control">
                <div class="input-group-append"><span class="input-group-text">pcs</span></div>
            </div>
        </div>
        <div class="col-md-4">
            <label class="font-weight-bold">Act</label>
            <div class="input-group">
                <input type="number" step="any" name="part_act" class="form-control">
                <div class="input-group-append"><span class="input-group-text">pcs</span></div>
            </div>
        </div>
        <div class="col-md-4">
            <label class="font-weight-bold">Judge <span class="text-danger">*</span></label> 
            <select name="part_judge" class="custom-select form-control" required>
                <option value="">Pilih Judge</option>
                <option value="OKE">OKE</option>
                <option value="NG">NG</option>
            </select>
        </div>

    </div>

    <div class="row mt-3">
    <!-- Result UP -->
    <div class="col-md-4">
        <label class="font-weight-bold">FAT RESULT 🔼</label>
        <div class="input-group">
            <select id="part_up" name="part_up" class="custom-select form-control" onchange="calculateResult('up')">
                <option value="">Result UP</option>
                <option value="0">0%</option>
                <option value="5">5%</option>
                <option value="10">10%</option>
                <option value="15">15%</option>
                <option value="20">20%</option>
                <option value="25">25%</option>
                <option value="30">30%</option>
            </select>
            <div class="input-group-append">
                <span class="input-group-text" id="result_up_pcs">0 pcs</span>
            </div>
        </div>
    </div>

    <!-- STD -->
    <div class="col-md-4">
        <label class="font-weight-bold">STD ⭘</label>
        <input type="text" id="std" name="part_std" class="form-control" readonly value="56">
    </div>

    <!-- Result DOWN -->
    <div class="col-md-4">
        <label class="font-weight-bold">FAT RESULT 🔽</label>
        <div class="input-group">
            <select id="part_down" name="part_down" class="custom-select form-control" onchange="calculateResult('down')">
                <option value="">Result DOWN</option>
                <option value="0">0%</option>
                <option value="5">5%</option>
                <option value="10">10%</option>
                <option value="15">15%</option>
                <option value="20">20%</option>
                <option value="25">25%</option>
                <option value="30">30%</option>
            </select>
            <div class="input-group-append">
                <span class="input-group-text" id="result_down_pcs">0 pcs</span>
            </div>
        </div>
    </div>
</div>
</div>


        <!-- Sub Bab: TRIAL TIME -->
        <h4 class="mt-4 mb-3"><strong>TRIAL TIME</strong></h4>
        <div class="card shadow-sm p-3 mb-4">
            <div class="row">
                <div class="col-md-4">
                    <label class="font-weight-bold">Tanggal Tryout <span class="text-danger">*</span></label>
                    <input type="date" name="dates" class="form-control" value="<?= date('Y-m-d'); ?>" required>
                </div>
                <div class="col-md-4">
                    <label class="font-weight-bold">Jam</label>
                    <input type="time" name="trial_time" class="form-control">
                </div>
                <div class="col-md-4">
                    <label class="font-weight-bold">Maker</label>
                    <select id="trial_maker_select" class="custom-select form-control" name="trial_maker">
                        <option value="">Pilih Maker</option>    
                        <option value="MAJ TBN">MAJ TBN</option>
                        <option value="MAJ MGL">MAJ MGL</option>
                        <option value="OTHERS">OUTHOUSE (ISI MANUAL)</option>
                    </select>
                    <input type="text" id="trial_maker_manual" name="trial_maker_manual" class="form-control mt-2" placeholder="Masukkan nama OUTHOUSE" style="display: none;">
                </div>
            </div>
        </div>

       
<h4 class="mt-4 mb-3"><strong>KONFIRMASI TRYOUT</strong></h4>
<div class="card shadow-sm p-3 mb-4">
    <div class="row">
        <!-- PRODUKSI -->
        <div class="col-md-6">
            <label class="font-weight-bold">Konfirmasi Produksi</label>
            <select name="konfirmasi_produksi" class="form-control custom-select2 produksi_dropdown">
                <option value="">-- Pilih --</option>
                <option value="manual">Ketik Lainnya</option>
                <?php foreach ($users as $user) : ?>
                    <option value="<?= $user->id; ?>">
                        <?= $user->nama?>
                    </option>
                <?php endforeach; ?>
            </select>
            <input type="text" name="konfirmasi_produksi_manual" class="form-control mt-2 produksi_manual" placeholder="Masukkan manual" style="display: none;">
        </div>

        <!-- QC -->
        <div class="col-md-6">
            <label class="font-weight-bold">Konfirmasi QC</label>
            <select name="konfirmasi_qc" class="form-control custom-select2 qc_dropdown">
                <option value="">-- Pilih --</option>
                <option value="manual">Ketik Lainnya</option>
                <?php foreach ($users as $user) : ?>
                    <option value="<?= $user->id; ?>">
                         <?= $user->nama?>
                    </option>
                <?php endforeach; ?>
            </select>
            <input type="text" name="konfirmasi_qc_manual" class="form-control mt-2 qc_manual" placeholder="Masukkan manual" style="display: none;">
        </div>
    </div>

    <div class="row mt-3">
        <!-- TOOLING -->
        <div class="col-md-6">
            <label class="font-weight-bold">Konfirmasi Tooling</label>
            <select name="konfirmasi_tooling" class="form-control custom-select2 tooling_dropdown">
                <option value="">-- Pilih --</option>
                <option value="manual">Ketik Lainnya</option>
                <?php foreach ($users as $user) : ?>
                    <option value="<?= $user->id; ?>">
                          <?= $user->nama?>
                    </option>
                <?php endforeach; ?>
            </select>
            <input type="text" name="konfirmasi_tooling_manual" class="form-control mt-2 tooling_manual" placeholder="Masukkan manual" style="display: none;">
        </div>

        <!-- R&D -->
        <div class="col-md-6">
            <label class="font-weight-bold">Konfirmasi R&D</label>
            <select name="konfirmasi_rd" class="form-control custom-select2 rd_dropdown">
                <option value="">-- Pilih --</option>
                <option value="manual">Ketik Lainnya</option>
                <?php foreach ($users as $user) : ?>
                    <option value="<?= $user->id; ?>">
                       <?= $user->nama?>
                    </option>
                <?php endforeach; ?>
            </select>
            <input type="text" name="konfirmasi_rd_manual" class="form-control mt-2 rd_manual" placeholder="Masukkan manual" style="display: none;">
        </div>
    </div>
</div>
<h4 class="mt-4 mb-3"><strong>ADD TRYOUT REPORT DIES</strong></h4>
<div class="card shadow-sm p-3 mb-4">
    <div class="row">
        <!-- Problem -->
        <div class="col-md-4">
            <label class="font-weight-bold">Problem (Gambar + Keterangan) <span class="text-danger">*</span></label>
            <div class="form-group">
                <label for="problem_source">Pilih Sumber Gambar:</label>
                <select id="problem_source" class="form-control mb-2">
                    <option value="file">Pilih File</option>
                    <option value="camera">Ambil Gambar dari Kamera</option>
                </select>
            </div>
            <div id="file_input" class="form-group">
                <input type="file" id="problem_image" class="form-control mb-2">
                <small class="text-muted">Gambar opsional</small>
            </div>
            <div id="camera_input" class="form-group" style="display: none;">
                <video id="camera_preview" width="100%" autoplay></video>
                <button type="button" id="capture_btn" class="btn btn-primary mt-2">Ambil Gambar</button>
                <canvas id="camera_canvas" style="display: none;"></canvas>
                <small class="text-muted">Gambar opsional</small>
            </div>
            <textarea id="problem_text" class="form-control" placeholder="Masukkan keterangan"></textarea>
            <small class="text-danger">Kolom keterangan wajib diisi</small>
        </div>

        <!-- Counter Measure -->
        <div class="col-md-4">
            <label class="font-weight-bold">Counter Measure</label>
            <textarea id="counter_measure" class="form-control" placeholder="Masukkan poin-poin tindakan"></textarea>
            <small class="text-muted">Opsional</small>
        </div>

        <!-- PIC -->
        <div class="col-md-4">
            <label class="font-weight-bold">PIC</label>
            <select id="pic_dropdown" name="pic_dropdown" class="form-control custom-select2">
                <option value="">-- Pilih --</option>
                <option value="manual">Ketik Lainnya</option>
                <?php foreach ($users as $user) : ?>
                    <option value="<?= $user->nama . ' - ' . $user->department; ?>">
                        <?= $user->nama . ' - ' . $user->department; ?>
                    </option>
                <?php endforeach; ?>
            </select>
            <input type="text" id="pic_manual" name="pic_manual" class="form-control mt-2" placeholder="Masukkan manual" style="display: none;">
            <small class="text-muted">Opsional</small>
        </div>

        <!-- Target -->
        <div class="col-md-6 mt-3">
            <label class="font-weight-bold">Target</label>
            <input type="date" id="target" class="form-control">
            <small class="text-muted">Opsional</small>
        </div>

        <!-- Progress -->
        <div class="col-md-6 mt-3">
            <label class="font-weight-bold">Progress (%)</label>
            <input type="number" step="any" id="progress" class="form-control" placeholder="Masukkan progress dalam %">
            <small class="text-muted">Opsional</small>
        </div>

        <div class="col-md-12 mt-3">
            <button type="button" class="btn btn-primary" id="add_problem">Tambah</button>
        </div>
    </div>
</div>

<!-- Table for Added Problems -->
<table class="table table-bordered mt-3">
    <thead>
        <tr>
            <th>Problem</th>
            <th>Counter Measure</th>
            <th>PIC</th>
            <th>Target</th>
            <th>Progress</th>
            <th>Aksi</th>
        </tr>
    </thead>
    <tbody id="problem_list"></tbody>
</table>

<!-- Hidden input for storing data -->
<input type="hidden" name="detail_tryout_data" id="detail_tryout_data">
<input type="hidden" name="problem_count" id="problem_count" value="0">

<!-- Tombol Simpan -->
<div class="form-group row">
    <div class="col-md-12 text-center">
        <button type="submit" class="btn btn-success px-4"><i class="fas fa-save"></i> Simpan</button>
        <a href="<?= site_url('tryout'); ?>" class="btn btn-secondary px-4"><i class="fas fa-arrow-left"></i> Kembali</a>
    </div>
</div>


    </form>
</div>

    </div>
</div>

<script>
document.getElementById('project_id').addEventListener('change', function() {
    let selectedOption = this.options[this.selectedIndex];
    document.getElementById('process').value = selectedOption.getAttribute('data-process');
});
</script>
<script>
function previewImage(event, previewId) {
    const input = event.target;
    const reader = new FileReader();

    reader.onload = function() {
        const img = document.getElementById(previewId);
        img.src = reader.result;
        img.style.display = 'block'; // Tampilkan gambar setelah dipilih
    };

    if (input.files && input.files[0]) {
        reader.readAsDataURL(input.files[0]); // Baca file sebagai URL
    }
}
</script>
<script>
    document.getElementById('trial_maker_select').addEventListener('change', function() {
        var manualInput = document.getElementById('trial_maker_manual');
        if (this.value === 'OTHERS') {
            manualInput.style.display = 'block';
            manualInput.required = true;
        } else {
            manualInput.style.display = 'none';
            manualInput.value = '';
            manualInput.required = false;
        }
    });
</script>
<script>
    // Script untuk menampilkan input manual jika "Ketik Lainnya" dipilih
    document.addEventListener("DOMContentLoaded", function () {
        const dropdowns = ["produksi", "qc", "tooling", "rd"];
        
        dropdowns.forEach(type => {
            const select = document.querySelector(`.${type}_dropdown`);
            const manualInput = document.querySelector(`.${type}_manual`);

            select.addEventListener("change", function () {
                if (this.value === "manual") {
                    manualInput.style.display = "block";
                    manualInput.setAttribute("name", `konfirmasi_${type}`); // Set agar dikirim ke server
                } else {
                    manualInput.style.display = "none";
                    manualInput.removeAttribute("name"); // Hapus jika tidak digunakan
                }
            });
        });
    });
</script>
<script>
$(document).ready(function() {
    // Fungsi untuk menangani perubahan pada dropdown
    function handleDropdownChange(dropdownClass, manualClass) {
        $('.' + dropdownClass).on('change', function() {
            if ($(this).val() === 'manual') {
                $('.' + manualClass).show();
            } else {
                $('.' + manualClass).hide();
            }
        });
    }

    // Terapkan fungsi pada setiap pasangan dropdown dan input manual
    handleDropdownChange('produksi_dropdown', 'produksi_manual');
    handleDropdownChange('qc_dropdown', 'qc_manual');
    handleDropdownChange('tooling_dropdown', 'tooling_manual');
    handleDropdownChange('rd_dropdown', 'rd_manual');

    // Inisialisasi untuk mengecek nilai awal dropdown
    $('.produksi_dropdown, .qc_dropdown, .tooling_dropdown, .rd_dropdown').each(function() {
        if ($(this).val() === 'manual') {
            var className = $(this).attr('class').split(' ')[0];
            var manualClass = className.replace('_dropdown', '_manual');
            $('.' + manualClass).show();
        }
    });
});
document.addEventListener("DOMContentLoaded", function () {
    let problemData = [];
    
    // Mengatur kamera jika diperlukan
    const problemSource = document.getElementById("problem_source");
    const fileInput = document.getElementById("file_input");
    const cameraInput = document.getElementById("camera_input");
    
    problemSource.addEventListener("change", function() {
        if (this.value === "camera") {
            fileInput.style.display = "none";
            cameraInput.style.display = "block";
            setupCamera();
        } else {
            fileInput.style.display = "block";
            cameraInput.style.display = "none";
            stopCamera();
        }
    });
    
    // Fungsi untuk mengatur kamera
    let stream = null;
    function setupCamera() {
        const video = document.getElementById("camera_preview");
        const captureBtn = document.getElementById("capture_btn");
        const canvas = document.getElementById("camera_canvas");
        
        navigator.mediaDevices.getUserMedia({ video: true })
            .then(function(mediaStream) {
                stream = mediaStream;
                video.srcObject = mediaStream;
                video.play();
            })
            .catch(function(err) {
                console.error("Error accessing camera:", err);
                alert("Tidak dapat mengakses kamera. Silakan periksa izin kamera.");
                problemSource.value = "file";
                fileInput.style.display = "block";
                cameraInput.style.display = "none";
            });
            
        captureBtn.addEventListener("click", function() {
            const context = canvas.getContext("2d");
            canvas.width = video.videoWidth;
            canvas.height = video.videoHeight;
            context.drawImage(video, 0, 0, canvas.width, canvas.height);
            
            // Konversi ke file
            canvas.toBlob(function(blob) {
                const capturedImage = new File([blob], "camera_capture.jpg", { type: "image/jpeg" });
                const dataTransfer = new DataTransfer();
                dataTransfer.items.add(capturedImage);
                
                // Simpan ke dalam hidden input untuk dikirim bersama form
                const hiddenInput = document.createElement("input");
                hiddenInput.type = "hidden";
                hiddenInput.name = "problem_image_camera";
                hiddenInput.id = "problem_image_camera";
                hiddenInput.files = dataTransfer.files;
                
                // Hapus input sebelumnya jika ada
                const existingInput = document.getElementById("problem_image_camera");
                if (existingInput) existingInput.remove();
                
                document.querySelector("form").appendChild(hiddenInput);
                alert("Gambar berhasil diambil!");
            }, "image/jpeg");
        });
    }
    
    function stopCamera() {
        if (stream) {
            stream.getTracks().forEach(track => track.stop());
        }
    }

    // Tampilkan input manual jika "Ketik Lainnya" dipilih
    document.getElementById("pic_dropdown").addEventListener("change", function () {
        if (this.value === "manual") {
            document.getElementById("pic_manual").style.display = "block";
            document.getElementById("pic_manual").focus();
        } else {
            document.getElementById("pic_manual").style.display = "none";
        }
    });

    // Tambah data ke tabel
    document.getElementById("add_problem").addEventListener("click", function () {
        let problemText = document.getElementById("problem_text").value;
        let counterMeasure = document.getElementById("counter_measure").value;
        let picDropdown = document.getElementById("pic_dropdown").value;
        let picManual = document.getElementById("pic_manual").value;
        let target = document.getElementById("target").value;
        let progress = document.getElementById("progress").value;

        let pic = picDropdown === "manual" ? picManual : picDropdown;

        // Validasi hanya untuk problem text
        if (!problemText.trim()) {
            alert("Kolom Problem Keterangan wajib diisi!");
            return;
        }

        // Cek sumber gambar problem
        let problemImageFile = null;
        if (problemSource.value === "file") {
            const problemImageInput = document.getElementById("problem_image");
            if (problemImageInput.files.length > 0) {
                problemImageFile = problemImageInput.files[0];
            }
        } else if (problemSource.value === "camera") {
            const cameraInput = document.getElementById("problem_image_camera");
            if (cameraInput && cameraInput.files.length > 0) {
                problemImageFile = cameraInput.files[0];
            }
        }

        // Tambahkan data ke dalam array
        problemData.push({
            problemImageFile,
            problemText,
            counterMeasure: counterMeasure || "-",
            pic: pic || "-",
            target: target || "-",
            progress: progress || "0"
        });

        // Buat tampilan baris tabel
        let newRow = `<tr>
                        <td>${problemText}</td>
                        <td>${counterMeasure || "-"}</td>
                        <td>${pic || "-"}</td>
                        <td>${target || "-"}</td>
                        <td>${progress || "0"}%</td>
                        <td><button type="button" class="btn btn-danger btn-sm remove_problem">Hapus</button></td>
                      </tr>`;

        // Tambahkan informasi gambar jika ada
        if (problemImageFile) {
            newRow = `<tr>
                        <td>${problemImageFile.name}<br>${problemText}</td>
                        <td>${counterMeasure || "-"}</td>
                        <td>${pic || "-"}</td>
                        <td>${target || "-"}</td>
                        <td>${progress || "0"}%</td>
                        <td><button type="button" class="btn btn-danger btn-sm remove_problem">Hapus</button></td>
                      </tr>`;
        }

        document.getElementById("problem_list").insertAdjacentHTML("beforeend", newRow);

        // Kosongkan input
        document.getElementById("problem_text").value = "";
        if (document.getElementById("problem_image")) {
            document.getElementById("problem_image").value = "";
        }
        document.getElementById("counter_measure").value = "";
        document.getElementById("pic_dropdown").value = "";
        document.getElementById("pic_manual").value = "";
        document.getElementById("pic_manual").style.display = "none";
        document.getElementById("target").value = "";
        document.getElementById("progress").value = "";

        // Update hidden input dengan data
        updateHiddenInput();
    });

    // Hapus baris dari tabel
    document.getElementById("problem_list").addEventListener("click", function (event) {
        if (event.target.classList.contains("remove_problem")) {
            let index = Array.from(event.target.closest("tr").parentNode.children).indexOf(event.target.closest("tr"));
            problemData.splice(index, 1);
            event.target.closest("tr").remove();
            updateHiddenInput();
        }
    });

    function updateHiddenInput() {
        // Simpan data sebagai JSON string (tanpa file karena akan dikirim secara terpisah)
        const dataForSaving = problemData.map((item, index) => {
            // Hapus file dari objek yang akan disimpan ke JSON
            const { problemImageFile, ...rest } = item;
            return {
                ...rest,
                hasImage: !!problemImageFile,
                imageIndex: index
            };
        });
        document.getElementById("detail_tryout_data").value = JSON.stringify(dataForSaving);
    }

    // Submit data ke backend
    document.querySelector("form").addEventListener("submit", function (e) {
        e.preventDefault();

        // Buat FormData untuk mengirim data
        let formData = new FormData(this);
        
        // Hapus data detail tryout lama jika ada
        if (formData.has("detail_tryout_data")) {
            formData.delete("detail_tryout_data");
        }
        
        // Tambahkan detail tryout data sebagai JSON string
        formData.append("detail_tryout_data", document.getElementById("detail_tryout_data").value);
        
        // Tambahkan file gambar problem jika ada
        problemData.forEach((problem, index) => {
            if (problem.problemImageFile) {
                formData.append(`problem_image_${index}`, problem.problemImageFile);
            }
            formData.append(`problem_text_${index}`, problem.problemText);
            formData.append(`counter_measure_${index}`, problem.counterMeasure);
            formData.append(`pic_${index}`, problem.pic);
            formData.append(`target_${index}`, problem.target);
            formData.append(`progress_${index}`, problem.progress);
        });

        // Tambahkan jumlah problem untuk memudahkan looping di server
        formData.append("problem_count", problemData.length);

        // Kirim data ke server menggunakan fetch API
        fetch(this.action, {
            method: "POST",
            body: formData,
            headers: {
                // Tidak perlu menentukan Content-Type untuk FormData
                // Fetch akan otomatis menambahkan multipart/form-data
                'X-Requested-With': 'XMLHttpRequest'
            }
        })
        .then(response => {
            if (!response.ok) {
                throw new Error('Network response was not ok');
            }
            return response.json();
        })
        .then(data => {
            if (data.success) {
                // Tampilkan notifikasi sukses
                alert("Data berhasil disimpan!");
                // Redirect ke halaman tryout
                window.location.href = "/tryout";
            } else {
                alert("Terjadi kesalahan: " + (data.message || "Unknown error"));
            }
        })
        .catch(error => {
            console.error('Error:', error);
            alert("Terjadi kesalahan dalam komunikasi dengan server. Silakan coba lagi.");
        });
    });
});
</script>
<script>
function previewImage(event, previewId) {
  var output = document.getElementById(previewId);
  output.src = URL.createObjectURL(event.target.files[0]);
  output.style.display = 'block';
}

// Untuk Image Part Trial
document.getElementById("part_trial_camera").addEventListener("change", function() {
  if (this.checked) {
    document.getElementById("part_trial_image_camera").style.display = "block";
    document.getElementById("part_trial_image").style.display = "none";
  }
});
document.getElementById("part_trial_file").addEventListener("change", function() {
  if (this.checked) {
    document.getElementById("part_trial_image").style.display = "block";
    document.getElementById("part_trial_image_camera").style.display = "none";
  }
});

// Untuk Image Material
document.getElementById("material_camera").addEventListener("change", function() {
  if (this.checked) {
    document.getElementById("material_image_camera").style.display = "block";
    document.getElementById("material_image").style.display = "none";
  }
});
document.getElementById("material_file").addEventListener("change", function() {
  if (this.checked) {
    document.getElementById("material_image").style.display = "block";
    document.getElementById("material_image_camera").style.display = "none";
  }
});
</script>
<script>
document.addEventListener('DOMContentLoaded', function() {
    const problemSource = document.getElementById('problem_source');
    const fileInput = document.getElementById('file_input');
    const cameraInput = document.getElementById('camera_input');
    const cameraPreview = document.getElementById('camera_preview');
    const captureBtn = document.getElementById('capture_btn');
    const cameraCanvas = document.getElementById('camera_canvas');
    const problemImage = document.getElementById('problem_image');
    let stream;

    problemSource.addEventListener('change', function() {
        if (this.value === 'file') {
            fileInput.style.display = 'block';
            cameraInput.style.display = 'none';
            if (stream) {
                stream.getTracks().forEach(track => track.stop());
            }
        } else if (this.value === 'camera') {
            fileInput.style.display = 'none';
            cameraInput.style.display = 'block';
            startCamera();
        }
    });

    function startCamera() {
        navigator.mediaDevices.getUserMedia({ video: true })
            .then(function(s) {
                stream = s;
                cameraPreview.srcObject = stream;
            })
            .catch(function(err) {
                console.error("Error accessing the camera: ", err);
            });
    }

    captureBtn.addEventListener('click', function() {
        const context = cameraCanvas.getContext('2d');
        cameraCanvas.width = cameraPreview.videoWidth;
        cameraCanvas.height = cameraPreview.videoHeight;
        context.drawImage(cameraPreview, 0, 0, cameraCanvas.width, cameraCanvas.height);
        cameraCanvas.toBlob(function(blob) {
            const file = new File([blob], 'capture.png', { type: 'image/png' });
            const dataTransfer = new DataTransfer();
            dataTransfer.items.add(file);
            problemImage.files = dataTransfer.files;
        }, 'image/png');
    });

    document.getElementById('add_problem').addEventListener('click', function() {
        const problemText = document.getElementById('problem_text').value;
        const counterMeasure = document.getElementById('counter_measure').value;
        const picDropdown = document.getElementById('pic_dropdown');
        const picManual = document.getElementById('pic_manual');
        const target = document.getElementById('target').value;
        const progress = document.getElementById('progress').value;

        const selectedPIC = picDropdown.value === 'manual' ? picManual.value : picDropdown.value;

        const problemImageFile = problemImage.files[0];
        const formData = new FormData();
        formData.append('problem_image', problemImageFile);
        formData.append('problem_text', problemText);
        formData.append('counter_measure', counterMeasure);
        formData.append('pic', selectedPIC);
        formData.append('target', target);
        formData.append('progress', progress);

        fetch('/tryout/store', {
            method: 'POST',
            body: formData
        })
        .then(response => {
            // Pastikan response berbentuk JSON sebelum diproses
            if (!response.ok) {
                throw new Error(`Server error: ${response.status}`);
            }
            return response.json();
        })
        .then(data => {
            console.log('Response dari server:', data); // Debugging
            if (data.success) {
                alert('Data berhasil disimpan!');
            } else {
                alert('Gagal menyimpan data! ' + (data.message || 'Unknown error'));
            }
        })
        .catch(error => {
            console.error('Fetch error:', error);
            alert('Terjadi kesalahan dalam komunikasi dengan server.');
        });
    });
});

</script>
<script>
    function updateSTD() {
        let spmValue = document.getElementById("spm").value;
        let stdField = document.getElementById("std");

        // Jika SPM memiliki nilai, isi STD dan buat readonly
        if (spmValue !== "") {
            stdField.value = spmValue;
            stdField.setAttribute("readonly", true);
        } else {
            stdField.value = ""; // Kosongkan jika tidak ada nilai
            stdField.removeAttribute("readonly");
        }
    }
    function calculateResult(type) {
        let stdValue = parseFloat(document.getElementById("std").value) || 0;
        let percentage = parseFloat(document.getElementById("part_" + type).value) || 0;
        let resultPcs = Math.round((percentage / 100) * stdValue); // Hitung pcs berdasarkan persentase

        document.getElementById("result_" + type + "_pcs").textContent = resultPcs + " pcs";
    }
</script>
<?= $this->endSection() ?>
