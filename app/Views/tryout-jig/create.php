<?= $this->extend('layout/template') ?>
<?= $this->section('content') ?>
<!-- CSS Select2 -->
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
<style>
        /* Menyembunyikan tombol by Kamera untuk perangkat desktop */
        .camera-only {
            display: none;
        }

        /* Menampilkan tombol by Kamera untuk perangkat mobile */
        @media (max-width: 768px) {
            .camera-only {
                display: inline-block;
            }
        }
        option[value="other"] {
    font-weight: bold;
}

        /* Menyamakan tinggi input manual dengan select */
#jig_no_manual {
    height: 38px; 
}

/* Memberikan konsistensi spacing */
.input-group {
    width: 100%;
}

/* Supaya Select2 menyesuaikan dengan form lain */
.select2-container .select2-selection--single {
    height: 41px !important;
    padding: 6px 12px;
}

/* Mengatur dropdown Select2 agar tidak terlalu besar */
.select2-container {
    width: 100% !important;
}
    </style>
<div class="pd-ltr-20 xs-pd-20-10">
    <div class="min-height-200px">
        <!-- Breadcrumb -->
        <div class="page-header">
            <div class="row">
                <div class="col-md-6 col-sm-12">
                    <div class="title">
                        <h4>Tambah Try Out Report Dies</h4>
                    </div>
                    <nav aria-label="breadcrumb" role="navigation">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item">
                                <a href="<?= site_url('dashboard'); ?>">Home</a>
                            </li>
                            <li class="breadcrumb-item">
                                <a href="<?= site_url('tryout-jig'); ?>">Tryout Jig</a>
                            </li>
                            <li class="breadcrumb-item active" aria-current="page">Form Tambah Tryout Jig</li>
                        </ol>
                    </nav>
                </div>
            </div>
        </div>

        <!-- Form -->
        <div class="pd-20 card-box mb-30">
            <form action="<?= site_url('tryout-jig/store'); ?>" method="post" enctype="multipart/form-data">
                <?= csrf_field(); ?>

                <!-- Judul Section -->
                <h4 class="mt-4 mb-3"><strong>MACHINE PARAMETER</strong></h4>

                <div class="card shadow-sm p-3 mb-3">
                    <div class="row">
                    <div class="col-md-3">
    <label class="font-weight-bold">Jig No</label>
    <div class="input-group">
        <select id="project_id" name="project_id" class="custom-select2 form-control" required onchange="toggleJigNoManual(this)">
            <option value="">-- Pilih Jig No --</option>
            <option value="other">🔹 ~~ KETIK LAINNYA ~~ 🔹</option>
            <?php foreach ($projects as $project): ?>
                <option value="<?= esc($project['id']); ?>">
                    <?= esc($project['part_no']) . ' - ' . esc($project['process']); ?>
                </option>
            <?php endforeach; ?>
        </select>
    </div>
    <input type="text" name="jig_no_manual" id="jig_no_manual" class="form-control mt-2" placeholder="Masukkan Jig No" style="display: none;">
</div>



                        <!-- Customer -->
                        <div class="col-md-3"> 
                            <label class="font-weight-bold">Customer</label>
                            <select name="cust" id="cust" class="form-control" required>
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
                        
                        <!-- Project -->
                        <!-- Project -->
                        <div class="col-md-3">
                            <label class="font-weight-bold">Project</label>
                            <select name="projek" id="projek" class="form-control" required>
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
                                <option value="SU2ID">SU2ID</option>
                                <option value="SU2ID-FL">SU2ID-FL</option>
                                <option value="YL0">YL0</option>
                                <option value="2MD">2MD</option>
                            </select>
                        </div>
                        <div class="col-md-3">
                            <label class="font-weight-bold">Upload Gambar</label>

                            <!-- Tombol Upload -->
                            <div class="dropdown">
                                <button class="btn btn-info btn-block dropdown-toggle" type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                    Pilih Gambar
                                </button>
                                <div class="dropdown-menu w-100">
                                    <a class="dropdown-item text-center" href="#" onclick="openCamera()">📸 Ambil Kamera</a>
                                    <a class="dropdown-item text-center" href="#" onclick="openFilePicker()">📂 Pilih File</a>
                                </div>
                            </div>

                            <!-- Input file (hanya 1, agar sesuai dengan controller) -->
                            <input type="file" name="image" id="image" class="d-none" accept="image/*">

                            <!-- Preview gambar -->
                            <img id="preview" class="mt-2 d-none" style="max-width: 100%; height: auto; border-radius: 10px;">
                        </div>
                        <div class="col-md-4 mt-2"><label class="font-weight-bold">PART NAME</label><input type="text" name="part_name" id="part_name" class="form-control" ></div>

                         <!-- Event -->
                        <div class="col-md-4 mt-2">
                            <label class="font-weight-bold">Event</label>
                            <select name="event" id="event" class="form-control">
                                <option value="">Pilih Event</option>
                                <option value="REGULAR CHECK">REGULAR CHECK</option>
                                <option value="IMPROVEMENT">IMPROVEMENT</option>
                                <option value="NEW PROJECT">NEW PROJECT</option>
                                <option value="TROUBLESHOOTING">TROUBLESHOOTING</option>
                                <option value="ECI">ECI</option>
                                <option value="OTHERS">OTHERS</option>
                            </select>
                        </div>

                        <!-- Tanggal -->
                        <div class="col-md-4 mt-2">
                            <label class="font-weight-bold">Tanggal</label>
                            <input type="date" name="date" id="date" class="form-control" required>
                        </div>

                        <!-- Upload Gambar -->
                        
                    </div>
                </div>

                <!-- DETAIL PART CLUSTERING -->
                <h4 class="mt-4 mb-3"><strong>DETAIL PART CLUSTERING</strong></h4>
                <div class="card shadow-sm p-3 mb-4">
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th>Part Levelling</th>
                                <th>Part Specification</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody id="detailTable">
                            <!-- Data akan ditambahkan secara dinamis -->
                        </tbody>
                    </table>
                    <button type="button" class="btn btn-secondary" id="addDetail">Tambah Detail</button>
                </div>

                <!-- DETAIL SETTINGS -->
                <h4 class="mt-4 mb-3"><strong>DETAIL SETTINGS</strong></h4>
                <div class="card shadow-sm p-3 mb-4">
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th colspan="3" class="category-title">ADD MECHINE PARAMETER, SPOT WELD, CO WELD </th>
                            </tr>
                        </thead>
                        <tbody id="detailSettingsTable">
                            <!-- Data akan ditambahkan secara dinamis -->
                        </tbody>
                    </table>
                    <button type="button" class="btn btn-secondary mt-3" id="addDetailSetting">Tambah Detail</button>
                </div>

                <h5 class="mt-4 mb-3"><strong>EQUIPMENT INFORMATION</strong></h5>

                <div class="card shadow-sm p-3 mb-4">
                    <div class="row">
                        <div class="col-md-4"><label class="font-weight-bold">MACHINE USAGE</label><input type="text" name="m_usage" id="m_usage" class="form-control" ></div>
                        <div class="col-md-4"><label class="font-weight-bold">MACHINE SPEC</label><input type="text" name="m_spec" id="m_spec" class="form-control" ></div>
                        <div class="col-md-4"><label class="font-weight-bold">GUN / HOLDER TYPE</label><input type="text" name="holder" id="holder" class="form-control" ></div>
                    </div>
                </div>

                <h5 class="mt-4 mb-3"><strong>WELDING CONDITION RESULT</strong></h5>

                <div class="card shadow-sm p-3 mb-4">
                    <div class="row">
                        <div class="col-md-4"><label class="font-weight-bold">VISUAL CHECK</label><input type="text" name="r_visual" id="r_visual" class="form-control" ></div>
                        <div class="col-md-4"><label class="font-weight-bold">TORQUE / PEEL CHECK</label><input type="text" name="r_torque" id="r_torque" class="form-control" ></div>
                        <div class="col-md-4"><label class="font-weight-bold">CUTTING CHECK</label><input type="text" name="r_cut" id="r_cut" class="form-control" ></div>
                    </div>
                </div>

                <h5 class="mt-4 mb-3"><strong>WELDING CONDITION STANDARD</strong></h5>

                <div class="card shadow-sm p-3 mb-4">
                    <div class="row">
                        <div class="col-md-3"><label class="font-weight-bold">VISUAL CHECK</label><input type="text" name="s_visual" id="s_visual" class="form-control" ></div>
                        <div class="col-md-3"><label class="font-weight-bold">TORQUE / PEEL CHECK</label><input type="text" name="s_torque" id="s_torque" class="form-control" ></div>
                        <div class="col-md-3"><label class="font-weight-bold">CUTTING CHECK</label><input type="text" name="s_cut" id="s_cut" class="form-control" ></div>
                        <div class="col-md-3">
                            <label class="font-weight-bold">JUDGEMENT</label>
                            <select name="judge" id="judge" class="form-control">
                                <option value="">-- Pilih OK/NG --</option>
                                <option value="OK">OK</option>
                                <option value="NG">NG</option>
                            </select>
                        </div>
                    </div>
                </div>
                <h5 class="mt-4 mb-3"><strong>PRODUCTION CAPABILITY</strong></h5>

                <div class="card shadow-sm p-3 mb-4">
                    <div class="row">
                        <div class="col-md-3 d-flex align-items-center justify-content-center">
                            <h5 class="font-weight-bold text-center">Σ MAN POWER</h5>
                        </div>
                        <div class="col-md-3"><label class="font-weight-bold">TAKT TIME TARGET</label><input type="text" name="t_target" id="t_target" class="form-control" ></div>
                        <div class="col-md-3"><label class="font-weight-bold">TAKT TIME ACT</label><input type="text" name="a_target" id="a_target" class="form-control" ></div>
                        <div class="col-md-3">
                            <label class="font-weight-bold">SHIFT/DAY</label>
                            <select name="shift" id="shift" class="form-control">
                                <option value="">Pilih Shift</option>
                                <option value="1 SHIFT">1 SHIFT</option>
                                <option value="2 SHIFT">2 SHIFT</option>
                            </select>
                        </div>
                        <div class="col-md-3 mt-3"><label class="font-weight-bold">CYCLE TIME TARGET</label><input type="text" name="t_cycle" id="t_cycle" class="form-control" ></div>
                        <div class="col-md-3 mt-3"><label class="font-weight-bold">CYCLE TIME ACT</label><input type="text" name="a_cycle" id="a_cycle" class="form-control" ></div>
                        <div class="col-md-3 mt-1">
                            <label class="font-weight-bold small">
                                MAX. CAPACITY / MONTH With O/T
                            </label>
                            <input type="text" name="whit" id="whit" class="form-control">
                        </div>
                        <div class="col-md-3 mt-1">
                            <label class="font-weight-bold small">
                                MAX. CAPACITY / MONTH Without O/T
                            </label>
                            <input type="text" name="whitout" id="whitout" class="form-control">
                        </div>  
                        <div class="col-md-3 mt-3">
                            <label class="font-weight-bold">WORKING H/SHIFT</label>
                            <div class="input-group">
                                <select name="work_h" id="work_h" class="form-control">
                                    <option value="">Pilih Jam</option>
                                    <?php for ($i = 1; $i <= 24; $i++): ?>
                                        <option value="<?= $i ?>"><?= $i ?></option>
                                    <?php endfor; ?>
                                </select>
                                <span class="input-group-text">Jam</span>
                            </div>
                        </div>

                        <div class="col-md-3 mt-3">
                            <label class="font-weight-bold">WORKING D/MONTH</label>
                            <div class="input-group">
                                <select name="work_d" id="work_d" class="form-control">
                                    <option value="">Pilih Hari</option>
                                    <?php for ($i = 1; $i <= 31; $i++): ?>
                                        <option value="<?= $i ?>"><?= $i ?></option>
                                    <?php endfor; ?>
                                </select>
                                <span class="input-group-text">Hari</span>
                            </div>
                        </div>
                        <div class="col-md-2 mt-3"><label class="font-weight-bold">UPH TARGET</label><input type="text" name="t_uph" id="t_uph" class="form-control" ></div>
                        <div class="col-md-2 mt-3"><label class="font-weight-bold">UPH ACTUAL</label><input type="text" name="a_uph" id="a_uph" class="form-control" ></div>
                        <div class="col-md-2 mt-3">
                            <label class="font-weight-bold">JUDGEMENT</label>
                            <select name="judgement" id="judge" class="form-control">
                                <option value="">-- Pilih OK/NG --</option>
                                <option value="OK">OK</option>
                                <option value="NG">NG</option>
                            </select>
                        </div>                       
                    </div>
                </div>
                <h4 class="mt-4 mb-3"><strong>DETAIL TRYOUT</strong></h4>
<div class="card shadow-sm p-3 mb-4">
    <table class="table table-bordered">
        <thead>
            <tr>
                <th>Problem</th>
                <th>Measure</th>
                <th>PIC</th>
                <th>Target</th>
                <th>Progress (%)</th>
                <th>Remarks</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody id="tryoutDetailTable">
            <!-- Data akan ditambahkan secara dinamis -->
        </tbody>
    </table>
    <button type="button" class="btn btn-secondary" id="addTryoutDetail">Tambah Detail</button>
</div>


<h4 class="mt-4 mb-3"><strong>MEMBER TRIAL</strong></h4>
<div class="card shadow-sm p-3 mb-4">
    <div class="row">
        <?php
        $roles = ['tooling', 'quality', 'produksi', 'ps', 'rnd'];
        foreach ($roles as $index => $role): ?>
            <div class="col-md-<?= ($index < 2) ? '6' : '4' ?> mt-3">
                <label class="font-weight-bold"><?= ucfirst($role) ?></label>
                <select name="<?= $role ?>" class="form-control member-trial">
                    <option value="">Pilih <?= ucfirst($role) ?></option>
                    <option value="other" style="font-weight: bold;">~~ KETIK LAINYA ~~</option>
                    <?php foreach ($users as $user): ?>
                        <option value="<?= $user['nama'] ?>"><?= $user['nama'] ?></option>
                    <?php endforeach; ?>
                </select>
                <input type="text" name="<?= $role ?>_manual" class="form-control mt-2 d-none other-input" placeholder="Masukkan <?= ucfirst($role) ?> manual">
            </div>
            <?php if ($index == 1): ?>  
                </div><div class="row"> <!-- Tutup baris pertama & mulai baris kedua -->
            <?php endif; ?>
        <?php endforeach; ?>
    </div>
</div>

            <button type="button" class="btn btn-secondary" onclick="window.history.back();">
                <i class="fas fa-arrow-left"></i> Kembali
            </button>

            <button type="submit" class="btn btn-primary">
                <i class="fas fa-save"></i> Simpan
            </button>

            </form>
        </div>
    </div>
</div>

<script>
document.addEventListener("DOMContentLoaded", function() {
    document.querySelectorAll('.member-trial').forEach(function(select) {
        select.addEventListener('change', function() {
            let inputField = this.nextElementSibling;
            if (this.value === 'other') {
                inputField.classList.remove('d-none');
                inputField.required = true;
            } else {
                inputField.classList.add('d-none');
                inputField.required = false;
            }
        });
    });
});
</script>
<script>
document.getElementById('addDetail').addEventListener('click', function() {
    let table = document.getElementById('detailTable');
    let row = table.insertRow();
    row.innerHTML = `
        <td><input type="text" name="part_levelling[]" class="form-control" ></td>
        <td><input type="text" name="part_specification[]" class="form-control" ></td>
<td>
    <button type="button" class="btn btn-danger removeDetail">
        <i class="fas fa-trash"></i>
    </button>
</td>
    `;
    row.querySelector('.removeDetail').addEventListener('click', function() {
        row.remove();
    });
});
</script>
<script>
        document.getElementById("addTryoutDetail").addEventListener("click", function () {
    let table = document.getElementById("tryoutDetailTable");
    let rowCount = table.rows.length;
    let row = table.insertRow(rowCount);

    row.innerHTML = `
        <td>
            <div class="mb-2">
                <!-- Tombol Kamera -->
                <label class="btn btn-sm btn-primary camera-only" onclick="openCameraForDetail(${rowCount})">
                    by Kamera 📸
                </label>
                
                <!-- Tombol File -->
                <label class="btn btn-sm btn-secondary" onclick="openFilePickerForDetail(${rowCount})">
                    by File 📂
                </label>
            </div>
            <input type="file" name="problem_image[${rowCount}]" id="problem_image_${rowCount}" accept="image/*" class="d-none" onchange="previewImage(event, ${rowCount})">
            <img id="preview_${rowCount}" src="" class="img-thumbnail" style="max-width: 100px; display: none;">
            <input type="text" name="problem[${rowCount}]" class="form-control mt-2" placeholder="Masukkan problem">
        </td>
        <td><input type="text" name="measure[${rowCount}]" class="form-control" placeholder="Masukkan measure"></td>
        <td>
            <input type="text" name="pic[${rowCount}]" class="form-control pic-input" placeholder="Masukkan PIC" maxlength="11">
        </td>
        <td><input type="date" name="target[${rowCount}]" class="form-control"></td>
        <td><input type="number" name="progress[${rowCount}]" class="form-control" placeholder="Masukkan progress (%)" min="0" max="100"></td>
        <td><input type="text" name="remarks[${rowCount}]" class="form-control" placeholder="Masukkan remarks"></td>
        <td>
            <button type="button" class="btn btn-danger btn-sm" onclick="removeRow(this)">
                <i class="fas fa-trash"></i>
            </button>
        </td>
    `;

    // Menambahkan event listener ke input PIC agar hanya bisa menerima huruf
    let picInput = row.querySelector(".pic-input");
    picInput.addEventListener("input", function () {
        this.value = this.value.replace(/[^a-zA-Z\s]/g, '');
    });
});

function openCameraForDetail(index) {
    let input = document.getElementById(`problem_image_${index}`);
    input.setAttribute("capture", "camera");
    input.click();
}

function openFilePickerForDetail(index) {
    let input = document.getElementById(`problem_image_${index}`);
    input.removeAttribute("capture");
    input.click();
}

function previewImage(event, index) {
    let reader = new FileReader();
    reader.onload = function () {
        let preview = document.getElementById("preview_" + index);
        preview.src = reader.result;
        preview.style.display = "block";
    };
    if (event.target.files[0]) {
        console.log("File dipilih:", event.target.files[0]);
        reader.readAsDataURL(event.target.files[0]);
    }
}

function removeRow(button) {
    let row = button.parentNode.parentNode;
    row.parentNode.removeChild(row);
}
    </script>

<!-- JavaScript Select2 -->
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
<script>
        document.getElementById('addDetailSetting').addEventListener('click', function () {
    let table = document.getElementById('detailSettingsTable');

    // Ambil semua nilai Part Levelling dari Detail Part Clustering
    let partLevellingOptions = Array.from(document.querySelectorAll('input[name="part_levelling[]"]'))
        .map(input => input.value)
        .filter(value => value.trim() !== ""); // Hanya ambil yang tidak kosong

    // Baris 1: Kategori 1 - Welding Parameter Setting
    let row1 = document.createElement('tr');
    row1.innerHTML = `
        <td colspan="3">
            <h6 class="text-center"><strong>WELDING PARAMETER SETTING</strong></h6>
        </td>
    `;
    let row1Fields = document.createElement('tr');
    row1Fields.innerHTML = `
        <td>
            <div class="form-group">
                <label>Point</label>
                <input type="number" step="0.1" name="point[]" class="form-control" required placeholder="Masukkan Point">
            </div>
        </td>
        <td>
            <div class="form-group">
                <label>Class</label>
                <select name="class[]" class="form-control" required>
                    <option value="">Pilih Class</option>
                    <option value="S">S</option>
                    <option value="G">G</option>
                    <option value="A">A</option>
                    <option value="R">R</option>
                </select>
            </div>
        </td>
        <td>
            <div class="form-group">
                <label>Combination</label>
                <select name="combination[]" class="form-control combination-select" multiple>
                    ${partLevellingOptions.map(option => `<option value="${option}">${option}</option>`).join('')}
                </select>
                <input type="hidden" name="combination_result[]" class="combination-result">
            </div>
        </td>
    `;

    // Baris 2: Kategori 2 - Spot Weld
    let row2 = document.createElement('tr');
    row2.innerHTML = `
        <td colspan="3">
            <h6 class="text-center"><strong>SPOT WELD</strong></h6>
        </td>
    `;
    let row2Fields = document.createElement('tr');
    row2Fields.innerHTML = `
        <td>
            <div class="form-group">
                <label>Sched Chanl (cyc)</label>
                <input type="number" step="0.1" name="sched_chanl[]" class="form-control" placeholder="Masukkan Sched Chanl">
            </div>
            <div class="form-group">
                <label>Squeeze (cyc)</label>
                <input type="number" step="0.1" name="squeeze[]" class="form-control" placeholder="Masukkan Squeeze">
            </div>
            <div class="form-group">
                <label>Up Slope (cyc)</label>
                <input type="number" step="0.1" name="up_slope[]" class="form-control" placeholder="Masukkan Up Slope">
            </div>
            <div class="form-group">
                <label>Hold</label>
                <input type="number" step="0.1" name="[]" class="form-control" placeholder="Masukkan Weld Time 2">
            </div>
        </td>
        <td>
            <div class="form-group">
                <label>Weld Curr 1 (ka)</label>
                <input type="number" step="0.1" name="weld_curr_1[]" class="form-control" placeholder="Masukkan Weld Curr 1">
            </div>
            <div class="form-group">
                <label>Weld Time 1 (cyc)</label>
                <input type="number" step="0.1" name="weld_time_1[]" class="form-control" placeholder="Masukkan Weld Time 1">
            </div>
            <div class="form-group">
                <label>Weld Curr 2 (ka)</label>
                <input type="number" step="0.1" name="weld_curr_2[]" class="form-control" placeholder="Masukkan Weld Curr 2">
            </div>
            <div class="form-group">
                <label>Press (ka)</label>
                <input type="number" step="0.1" name="press[]" class="form-control" placeholder="Masukkan Weld Curr 3">
            </div>
        </td>
        <td>
            <div class="form-group">
                <label>Weld Time 2 (cyc)</label>
                <input type="number" step="0.1" name="weld_time_2[]" class="form-control" placeholder="Masukkan Weld Time 2">
            </div>
            <div class="form-group">
                <label>Weld Curr 3 (ka)</label>
                <input type="number" step="0.1" name="weld_curr_3[]" class="form-control" placeholder="Masukkan Weld Curr 3">
            </div>
            <div class="form-group">
                <label>Weld Time 3 (cyc)</label>
                <input type="number" step="0.1" name="weld_time_3[]" class="form-control" placeholder="Masukkan Weld Time 3">
            </div>
            <div class="form-group">
                <label>Turm Ratio (cyc)</label>
                <input type="number" step="0.1" name="turn_ratio[]" class="form-control" placeholder="Masukkan Weld Time 3">
            </div>
        </td>        
    `;

    // Baris 3: Kategori 3 - CO Weld
    let row3 = document.createElement('tr');
    row3.innerHTML = `
        <td colspan="3">
            <h5 class="text-center">CO WELD</strong></h5>
        </td>
    `;
    let row3Fields = document.createElement('tr');
    row3Fields.innerHTML = `
        <td>
            <div class="form-group">
                <label>Amper (a)</label>
                <input type="number" step="0.1" name="amper[]" class="form-control" placeholder="Masukkan Amper">
            </div>
            <div class="form-group">
                <label>Hold</label>
                <input type="number" step="0.1" name="hold[]" class="form-control" placeholder="Masukkan Hold">
            </div>
        </td>
        <td>
            <div class="form-group">
                <label>Volt (v)</label>
                <input type="number" step="0.1" name="volt[]" class="form-control" placeholder="Masukkan Volt">
            </div>
        </td>
        <td>
            <div class="form-group">
                <label>Speed (mm/s)</label>
                <input type="number" step="0.1" name="speed[]" class="form-control" placeholder="Masukkan Speed">
            </div>
            <button type="button" class="btn btn-danger btn-sm removeDetail">Hapus</button>
        </td>
    `;

    table.appendChild(row1);
    table.appendChild(row1Fields);
    table.appendChild(row2);
    table.appendChild(row2Fields);
    table.appendChild(row3);
    table.appendChild(row3Fields);

    // Inisialisasi Select2 pada elemen combination-select
    $(row1Fields).find('.combination-select').select2({
        placeholder: "Pilih kombinasi",
        allowClear: true
    });

    // Event listener untuk kombinasi nilai
    $(row1Fields).find('.combination-select').on('change', function () {
        let selectedValues = $(this).val();
        let combinationResult = selectedValues.join(' x '); // Gabungkan nilai dengan format "x"
        $(row1Fields).find('.combination-result').val(combinationResult);
    });

    // Event listener untuk tombol hapus
    $(row3Fields).find('.removeDetail').on('click', function () {
        row1.remove();
        row1Fields.remove();
        row2.remove();
        row2Fields.remove();
        row3.remove();
        row3Fields.remove();
    });
});
    </script>
    <script>
function openCamera() {
    document.getElementById("image").setAttribute("capture", "camera");
    document.getElementById("image").click();
}

function openFilePicker() {
    document.getElementById("image").removeAttribute("capture");
    document.getElementById("image").click();
}

// Event listener untuk menampilkan preview gambar
document.getElementById("image").addEventListener("change", function(event) {
    let file = event.target.files[0];
    if (file) {
        let reader = new FileReader();
        reader.onload = function(e) {
            let preview = document.getElementById("preview");
            preview.src = e.target.result;
            preview.classList.remove("d-none");
        };
        reader.readAsDataURL(file);
    }
});
</script>
<script>
function toggleJigNoManual(select) {
    var manualInput = document.getElementById('jig_no_manual');
    if (select.value === 'other') {
        manualInput.style.display = 'block';
        manualInput.setAttribute('required', 'required');
    } else {
        manualInput.style.display = 'none';
        manualInput.removeAttribute('required');
        manualInput.value = ''; // Reset nilai jika dropdown digunakan kembali
    }
}
</script>
<script>
document.addEventListener("DOMContentLoaded", function() {
    const targetInput = document.getElementById("t_uph");
    const actualInput = document.getElementById("a_uph");

    function updateTextColor() {
        const targetValue = parseFloat(targetInput.value) || 0;
        const actualValue = parseFloat(actualInput.value) || 0;

        if (actualValue < targetValue) {
            actualInput.style.color = "red"; // Warna merah jika lebih kecil
        } else {
            actualInput.style.color = "black"; // Warna default jika lebih besar atau sama
        }
    }

    targetInput.addEventListener("input", updateTextColor);
    actualInput.addEventListener("input", updateTextColor);
});
</script>
<script>
    $(document).ready(function() {
        $('.custom-select2').select2({
            placeholder: "Pilih Jig No",
            allowClear: true
        });

        // Fungsi untuk menangani opsi "Ketik Lainnya"
        $('#project_id').change(function() {
            if ($(this).val() === 'other') {
                $('#jig_no_manual').show().attr('required', true);
            } else {
                $('#jig_no_manual').hide().attr('required', false);
            }
        });
    });
    
</script>
</script>
<?= $this->endSection() ?>
