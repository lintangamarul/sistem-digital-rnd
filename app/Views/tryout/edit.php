<?= $this->extend('layout/template') ?>
<?= $this->section('content') ?>

<div class="pd-ltr-20 xs-pd-20-10">
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

    <!-- Form Edit Tryout -->
    <form action="<?= site_url('tryout/update/' . $tryout['id']) ?>" method="post" enctype="multipart/form-data">
        <?= csrf_field() ?>

        <!-- DATA UTAMA -->
        <div class="card mb-3">
            <div class="card-header">
                <strong>Data Utama Tryout</strong>
            </div>
            <div class="card-body">
    <!-- Baris untuk Project dan Activity -->
    <div class="form-row">
        <div class="form-group col-md-6">
        <label for="project_id">Project</label>
        <?php 
            // Cari project yang sesuai dengan tryout
            $selectedProject = null;
            foreach ($projects as $project) {
                if ($project['status'] == 1 && $project['part_no'] != '-' && $project['jenis'] == 'Tooling Project' && $project['id'] == $tryout['project_id']) {
                    $selectedProject = $project;
                    break;
                }
            }
        ?>
        <?php if ($selectedProject): ?>
            <!-- Tampilkan nilai sebagai input readonly -->
            <input type="text" class="form-control" value="<?= esc($selectedProject['part_no'] . ' - ' . $selectedProject['process']); ?>" disabled>
            <!-- Simpan nilai project_id dalam hidden field agar tetap terkirim ke server -->
            <input type="hidden" name="project_id" value="<?= esc($selectedProject['id']); ?>">
        <?php else: ?>
            <p>Data project tidak ditemukan</p>
        <?php endif; ?>
    </div>

        <div class="form-group col-md-6">
            <label for="activity">Activity</label>
            <input type="text" name="activity" id="activity" class="form-control" value="<?= esc($tryout['activity']) ?>" readonly>
        </div>
    </div>


                <!-- M/C LINE, SLIDE / DH, ADAPTOR, CUSH. PRESS, CUSH. H., MAIN PRESS, SPM, GSPH, BOOLSTER -->
                <?php 
                    // Hapus satuan pada nilai-nilai yang disimpan, sehingga hanya angka yang tampil di input form
                    $slide_dh   = preg_replace('/\s*mm$/', '', $tryout['slide_dh']);
                    $adaptor    = preg_replace('/\s*mm$/', '', $tryout['adaptor']);
                    // Untuk cush_press, cek satuan yang ada (kg/cm², ton, atau MPa)
                    $cush_press = preg_replace('/\s*(kg\/cm²|ton|MPa)$/', '', $tryout['cush_press']);
                    $cush_h     = preg_replace('/\s*mm$/', '', $tryout['cush_h']);
                    $main_press = preg_replace('/\s*N$/', '', $tryout['main_press']);
                    $spm        = preg_replace('/\s*det$/', '', $tryout['spm']);
                    $gsph       = preg_replace('/\s*pcs\/jam$/', '', $tryout['gsph']);
                ?>
                <!-- Baris 1: M/C LINE, SLIDE / DH, ADAPTOR -->
                <div class="form-row">
                    <div class="form-group col-md-4">
                        <label>M/C LINE</label>
                        <input type="text" name="mc_line" class="form-control" value="<?= esc($tryout['mc_line']); ?>">
                    </div>
                    <div class="form-group col-md-4">
                        <label>SLIDE / DH</label>
                        <input type="text" name="slide_dh" class="form-control" value="<?= esc($slide_dh); ?>">
                    </div>
                    <div class="form-group col-md-4">
                        <label>ADAPTOR</label>
                        <input type="text" name="adaptor" class="form-control" value="<?= esc($adaptor); ?>">
                    </div>
                </div>

                <!-- Baris 2: CUSH. PRESS, CUSH. H., MAIN PRESS -->
                <div class="form-row">
                    <div class="form-group col-md-4">
                        <label>CUSH. PRESS</label>
                        <div class="input-group">
                            <input type="text" name="cush_press" class="form-control" value="<?= esc($cush_press); ?>">
                            <div class="input-group-append">
                                <select name="cush_press_unit" class="custom-select">
                                    <option value="kg/cm²" <?= (strpos($tryout['cush_press'], 'kg/cm²') !== false) ? 'selected' : ''; ?>>kg/cm²</option>
                                    <option value="ton" <?= (strpos($tryout['cush_press'], 'ton') !== false) ? 'selected' : ''; ?>>ton</option>
                                    <option value="MPa" <?= (strpos($tryout['cush_press'], 'MPa') !== false) ? 'selected' : ''; ?>>MPa</option>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="form-group col-md-4">
                        <label>CUSH. H.</label>
                        <input type="text" name="cush_h" class="form-control" value="<?= esc($cush_h); ?>">
                    </div>
                    <div class="form-group col-md-4">
                        <label>MAIN PRESS</label>
                        <input type="text" name="main_press" class="form-control" value="<?= esc($main_press); ?>">
                    </div>
                </div>

                <!-- Baris 3: SPM, GSPH, BOOLSTER -->
                <div class="form-row">
                    <div class="form-group col-md-4">
                        <label>SPM</label>
                        <input type="text" name="spm" class="form-control" value="<?= esc($spm); ?>">
                    </div>
                    <div class="form-group col-md-4">
                        <label>GSPH</label>
                        <input type="text" name="gsph" class="form-control" value="<?= esc($gsph); ?>">
                    </div>
                    <div class="form-group col-md-4">
                        <label>BOOLSTER</label>
                        <input type="text" name="boolster" class="form-control" value="<?= esc($tryout['boolster']); ?>">
                    </div>
                </div>

                <div class="form-row">
                    <div class="form-group col-md-4">
                        <label>Tanggal Tryout</label>
                        <input type="date" name="dates" class="form-control" value="<?= esc($tryout['dates']) ?>">
                    </div>
                    <div class="form-group col-md-4">
                        <label>Jam</label>
                        <input type="time" name="trial_time" class="form-control" value="<?= esc($tryout['trial_time']) ?>">
                    </div>
                    <div class="form-group col-md-4">
                        <label>Maker</label>
                        <select name="trial_maker" id="trial_maker_select" class="custom-select">
                            <option value="MAJ TBN" <?= ($tryout['trial_maker'] == 'MAJ TBN') ? 'selected' : '' ?>>MAJ TBN</option>
                            <option value="MAJ MGL" <?= ($tryout['trial_maker'] == 'MAJ MGL') ? 'selected' : '' ?>>MAJ MGL</option>
                            <option value="OTHERS" <?= ($tryout['trial_maker'] == 'OTHERS') ? 'selected' : '' ?>>OTHERS (Manual)</option>
                        </select>
                    </div>
                </div>

                <!-- Upload Gambar -->
<div class="form-row">
    <!-- Image Part Trial -->
    <div class="form-group col-md-6">
        <label>Image Part Trial</label>
        <?php if (!empty($tryout['part_trial_image'])): ?>
            <div>
                <img id="previewPartTrial" src="<?= base_url('uploads/part_trial/' . $tryout['part_trial_image']) ?>" 
                     alt="Part Trial" class="img-thumbnail" style="max-width: 150px;">
            </div>
        <?php endif; ?>
        <div class="form-check">
            <input class="form-check-input" type="radio" name="part_trial_image_source" id="part_trial_file" value="file" checked>
            <label class="form-check-label" for="part_trial_file">
                Pilih Gambar dari File
            </label>
        </div>
        <div class="form-check">
            <input class="form-check-input" type="radio" name="part_trial_image_source" id="part_trial_camera" value="camera">
            <label class="form-check-label" for="part_trial_camera">
                Ambil Gambar dari Kamera
            </label>
        </div>
        <input type="file" name="part_trial_image" id="part_trial_image" class="form-control-file"
               onchange="previewImage(event, 'previewPartTrial')">
        <input type="hidden" name="existing_part_trial_image" value="<?= esc($tryout['part_trial_image']) ?>">
    </div>

    <!-- Image Material -->
    <div class="form-group col-md-6">
        <label>Image Material</label>
        <?php if (!empty($tryout['material_image'])): ?>
            <div>
                <img id="previewMaterial" src="<?= base_url('uploads/material/' . $tryout['material_image']) ?>" 
                     alt="Material" class="img-thumbnail" style="max-width: 150px;">
            </div>
        <?php endif; ?>
        <div class="form-check">
            <input class="form-check-input" type="radio" name="material_image_source" id="material_file" value="file" checked>
            <label class="form-check-label" for="material_file">
                Pilih Gambar dari File
            </label>
        </div>
        <div class="form-check">
            <input class="form-check-input" type="radio" name="material_image_source" id="material_camera" value="camera">
            <label class="form-check-label" for="material_camera">
                Ambil Gambar dari Kamera
            </label>
        </div>
        <input type="file" name="material_image" id="material_image" class="form-control-file"
               onchange="previewImage(event, 'previewMaterial')">
        <input type="hidden" name="existing_material_image" value="<?= esc($tryout['material_image']) ?>">
    </div>
</div>

                <!-- Data Lain (Panel OK, Material, dll) -->
                <div class="form-row">
                    <div class="form-group col-md-4">
                        <label>Panel OK</label>
                        <input type="text" name="panel_ok" class="form-control" value="<?= esc($tryout['panel_ok'] ?? '') ?>">
                    </div>
                    <div class="form-group col-md-4">
                        <label>Material</label>
                        <input type="text" name="material" class="form-control" value="<?= esc($tryout['material'] ?? '') ?>">
                    </div>
                    <div class="form-group col-md-4">
                        <label>Customer</label>
                        <select name="cust" class="form-control">
                            <option value="">Pilih Customer</option>
                            <option value="ADM" <?= (isset($tryout['cust']) && $tryout['cust'] === "ADM") ? 'selected' : ''; ?>>ADM</option>
                            <option value="TMMIN" <?= (isset($tryout['cust']) && $tryout['cust'] === "TMMIN") ? 'selected' : ''; ?>>TMMIN</option>
                            <option value="MKM" <?= (isset($tryout['cust']) && $tryout['cust'] === "MKM") ? 'selected' : ''; ?>>MKM</option>
                            <option value="MMKI" <?= (isset($tryout['cust']) && $tryout['cust'] === "MMKI") ? 'selected' : ''; ?>>MMKI</option>
                            <option value="HMMI" <?= (isset($tryout['cust']) && $tryout['cust'] === "HMMI") ? 'selected' : ''; ?>>HMMI</option>
                            <option value="SUZUKI" <?= (isset($tryout['cust']) && $tryout['cust'] === "SUZUKI") ? 'selected' : ''; ?>>SUZUKI</option>
                            <option value="GMR" <?= (isset($tryout['cust']) && $tryout['cust'] === "GMR") ? 'selected' : ''; ?>>GMR</option>
                            <option value="HPM" <?= (isset($tryout['cust']) && $tryout['cust'] === "HPM") ? 'selected' : ''; ?>>HPM</option>
                        </select>
                    </div>
                </div>
                <div class="form-row">
                    <div class="form-group col-md-4">
                        <label>Step</label>
                        <select name="step" class="form-control" required>
                            <option value="">Pilih Step</option>
                            <?php for ($i = 1; $i <= 10; $i++): ?>
                                <option value="T<?= $i; ?>" <?= (isset($tryout['step']) && $tryout['step'] === "T$i") ? 'selected' : ''; ?>>
                                    T<?= $i; ?>
                                </option>
                            <?php endfor; ?>
                        </select>
                    </div>
                    <div class="form-group col-md-4">
                        <label> Event</label>
                        <input type="text" name="event" class="form-control" value="<?= esc($tryout['event'] ?? '') ?>">
                    </div>
                    <div class="form-group col-md-4">
                        <label>Projek</label>
                        <select name="projek" class="form-control">
                            <option value="">Pilih Projek</option>
                            <?php 
                                $projekList = ["D14N", "D26A", "D30D", "D40", "D40D", "D40L", "D55L", "D72A", "D74A", "D03B", "SL", "KS", "SU2ID", "SU2ID-FL", "YL0", "2MD", "KS-FL"];
                                foreach ($projekList as $projek) :
                            ?>
                                <option value="<?= $projek; ?>" <?= (isset($tryout['projek']) && $tryout['projek'] === $projek) ? 'selected' : ''; ?>>
                                    <?= $projek; ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                </div>

                <!-- KUANTITAS PART -->
                <div class="form-row">
                    <div class="form-group col-md-4">
                        <label>Target</label>
                        <input type="number" name="part_target" class="form-control" value="<?= esc($tryout['part_target']) ?>">
                    </div>
                    <div class="form-group col-md-4">
                        <label>Act</label>
                        <input type="number" name="part_act" class="form-control" value="<?= esc($tryout['part_act']) ?>">
                    </div>
                    <div class="form-group col-md-4">
                        <label>Judge</label>
                        <select name="part_judge" class="custom-select form-control">
                            <option value="">Pilih Judge</option>
                            <option value="OKE" <?= ($tryout['part_judge'] == 'OKE') ? 'selected' : '' ?>>OKE</option>
                            <option value="NG" <?= ($tryout['part_judge'] == 'NG') ? 'selected' : '' ?>>NG</option>
                        </select>
                    </div>
                </div>
                <div class="form-row">
                    <div class="form-group col-md-4">
                        <label>FAT RESULT 🔼</label>
                        <select name="part_up" class="custom-select form-control">
                            <option value="">Result UP</option>
                            <option value="5%" <?= ($tryout['part_up'] == '5%') ? 'selected' : '' ?>>5%</option>
                            <option value="10%" <?= ($tryout['part_up'] == '10%') ? 'selected' : '' ?>>10%</option>
                            <option value="15%" <?= ($tryout['part_up'] == '15%') ? 'selected' : '' ?>>15%</option>
                            <option value="20%" <?= ($tryout['part_up'] == '20%') ? 'selected' : '' ?>>20%</option>
                        </select>
                    </div>
                    <div class="form-group col-md-4">
                        <label>STD ⭘</label>
                        <input type="text" name="part_std" class="form-control" value="<?= esc($tryout['part_std']) ?>">
                    </div>
                    <div class="form-group col-md-4">
                        <label>FAT RESULT 🔽</label>
                        <select name="part_down" class="custom-select form-control">
                            <option value="">Result DOWN</option>
                            <option value="5%" <?= ($tryout['part_down'] == '5%') ? 'selected' : '' ?>>5%</option>
                            <option value="10%" <?= ($tryout['part_down'] == '10%') ? 'selected' : '' ?>>10%</option>
                            <option value="15%" <?= ($tryout['part_down'] == '15%') ? 'selected' : '' ?>>15%</option>
                            <option value="20%" <?= ($tryout['part_down'] == '20%') ? 'selected' : '' ?>>20%</option>
                        </select>
                    </div>
                </div>
                <div class="form-row">
                    <div class="form-group col-md-4">
                        <label>Material Pakai</label>
                        <input type="number" name="material_pakai" class="form-control" value="<?= esc($tryout['material_pakai']) ?>">
                    </div>
                    <div class="form-group col-md-4">
                        <label>Material Sisa</label>
                        <input type="number" name="material_sisa" class="form-control" value="<?= esc($tryout['material_sisa']) ?>">
                    </div>
                    <div class="form-group col-md-4">
                        <label>Panel OKE</label>
                        <input type="number" name="panel_ok" class="form-control" value="<?= esc($tryout['panel_ok']) ?>">
                    </div>
                    </div>
                </div>

                <!-- KONFIRMASI TRYOUT -->
                <div class="form-row">
    <!-- Konfirmasi Produksi -->
    <div class="form-group col-md-6">
        <label class="font-weight-bold">Konfirmasi Produksi</label>
        <select name="konfirmasi_produksi" class="form-control produksi_dropdown">
            <option value="">-- Pilih --</option>
            <option value="manual" <?= (!is_numeric($tryout['konfirmasi_produksi'])) ? 'selected' : '' ?>>
                Ketik Lainnya
            </option>
            <?php foreach ($users as $user): ?>
                <option value="<?= $user->id; ?>" <?= ($tryout['konfirmasi_produksi'] == $user->id) ? 'selected' : ''; ?>>
                    <?= $user->nama; ?>
                </option>
            <?php endforeach; ?>
        </select>
        <input type="text" name="konfirmasi_produksi_manual" class="form-control mt-2 produksi_manual" 
               placeholder="Masukkan manual"
               style="display: <?= (!is_numeric($tryout['konfirmasi_produksi'])) ? 'block' : 'none'; ?>;"
               value="<?= (!is_numeric($tryout['konfirmasi_produksi'])) ? esc($tryout['konfirmasi_produksi']) : ''; ?>">
    </div>

    <!-- Konfirmasi QC -->
    <div class="form-group col-md-6">
        <label class="font-weight-bold">Konfirmasi QC</label>
        <select name="konfirmasi_qc" class="form-control qc_dropdown">
            <option value="">-- Pilih --</option>
            <option value="manual" <?= (!is_numeric($tryout['konfirmasi_qc'])) ? 'selected' : '' ?>>
                Ketik Lainnya
            </option>
            <?php foreach ($users as $user): ?>
                <option value="<?= $user->id; ?>" <?= ($tryout['konfirmasi_qc'] == $user->id) ? 'selected' : ''; ?>>
                    <?= $user->nama; ?>
                </option>
            <?php endforeach; ?>
        </select>
        <input type="text" name="konfirmasi_qc_manual" class="form-control mt-2 qc_manual" 
               placeholder="Masukkan manual"
               style="display: <?= (!is_numeric($tryout['konfirmasi_qc'])) ? 'block' : 'none'; ?>;"
               value="<?= (!is_numeric($tryout['konfirmasi_qc'])) ? esc($tryout['konfirmasi_qc']) : ''; ?>">
    </div>
</div>

<div class="form-row mt-3">
    <!-- Konfirmasi Tooling -->
    <div class="form-group col-md-6">
        <label class="font-weight-bold">Konfirmasi Tooling</label>
        <select name="konfirmasi_tooling" class="form-control tooling_dropdown">
            <option value="">-- Pilih --</option>
            <option value="manual" <?= (!is_numeric($tryout['konfirmasi_tooling'])) ? 'selected' : '' ?>>
                Ketik Lainnya
            </option>
            <?php foreach ($users as $user): ?>
                <option value="<?= $user->id; ?>" <?= ($tryout['konfirmasi_tooling'] == $user->id) ? 'selected' : ''; ?>>
                    <?= $user->nama; ?>
                </option>
            <?php endforeach; ?>
        </select>
        <input type="text" name="konfirmasi_tooling_manual" class="form-control mt-2 tooling_manual" 
               placeholder="Masukkan manual"
               style="display: <?= (!is_numeric($tryout['konfirmasi_tooling'])) ? 'block' : 'none'; ?>;"
               value="<?= (!is_numeric($tryout['konfirmasi_tooling'])) ? esc($tryout['konfirmasi_tooling']) : ''; ?>">
    </div>

    <!-- Konfirmasi R&D -->
    <div class="form-group col-md-6">
        <label class="font-weight-bold">Konfirmasi R&D</label>
        <select name="konfirmasi_rd" class="form-control rd_dropdown">
            <option value="">-- Pilih --</option>
            <option value="manual" <?= (!is_numeric($tryout['konfirmasi_rd'])) ? 'selected' : '' ?>>
                Ketik Lainnya
            </option>
            <?php foreach ($users as $user): ?>
                <option value="<?= $user->id; ?>" <?= ($tryout['konfirmasi_rd'] == $user->id) ? 'selected' : ''; ?>>
                    <?= $user->nama; ?>
                </option>
            <?php endforeach; ?>
        </select>
        <input type="text" name="konfirmasi_rd_manual" class="form-control mt-2 rd_manual" 
               placeholder="Masukkan manual"
               style="display: <?= (!is_numeric($tryout['konfirmasi_rd'])) ? 'block' : 'none'; ?>;"
               value="<?= (!is_numeric($tryout['konfirmasi_rd'])) ? esc($tryout['konfirmasi_rd']) : ''; ?>">
    </div>
</div>



            </div>
        </div>

        <!-- Detail Tryout (Problem & Counter Measure) -->
        <div class="card mb-3">
        <div class="card-header">
        <strong>Detail Tryout (Problem & Counter Measure)</strong>
    </div>
    <div class="card-body">
        <!-- Tampilkan detail tryout lama -->
        <?php if (!empty($detail_tryouts)): ?>
            <?php foreach ($detail_tryouts as $index => $detail): ?>
                <div class="detail-row border p-2 mb-2" data-index="<?= $index ?>">
                    <h6>Detail <?= $index + 1 ?></h6>
                    <div class="form-row">
                        <div class="form-group col-md-4">
                            <label>Problem Text</label>
                            <textarea name="problem_text_<?= $index ?>" class="form-control" required><?= esc($detail['problem_text']) ?></textarea>
                        </div>
                        <div class="form-group col-md-4">
                            <label>Counter Measure</label>
                            <textarea name="counter_measure_<?= $index ?>" class="form-control"><?= esc($detail['counter_measure']) ?></textarea>
                        </div>
                        <div class="form-group col-md-4">
                            <label>PIC</label>
                            <select name="pic_<?= $index ?>" class="custom-select form-control pic-dropdown">
                                <option value="">-- Pilih --</option>
                                <option value="manual" <?= (trim($detail['pic']) != '' && !is_numeric($detail['pic'])) ? 'selected' : '' ?>>Ketik Lainnya</option>
                                <?php foreach ($users as $user): ?>
                                    <option value="<?= $user->id; ?>" <?= (is_numeric($detail['pic']) && $detail['pic'] == $user->id) ? 'selected' : '' ?>>
                                        <?= $user->nama; ?>
                                    </option>
                                <?php endforeach; ?>
                            </select>
                            <input type="text" name="pic_manual_<?= $index ?>" class="form-control mt-2 pic-manual" placeholder="Masukkan manual" style="display: <?= (!is_numeric($detail['pic']) && trim($detail['pic']) !== '') ? 'block' : 'none'; ?>;" value="<?= (!is_numeric($detail['pic'])) ? esc($detail['pic']) : ''; ?>">
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="form-group col-md-3">
                            <label>Target</label>
                            <input type="text" name="target_<?= $index ?>" class="form-control" value="<?= esc($detail['target']) ?>">
                        </div>
                        <div class="form-group col-md-3">
                            <label>Progress (%)</label>
                            <input type="number" name="progress_<?= $index ?>" class="form-control" min="0" max="100" value="<?= esc($detail['progress']) ?>">
                        </div>
                        <div class="form-group col-md-3">
                            <label>Problem Image</label>
                            <?php if (!empty($detail['problem_image'])): ?>
                                <div>
                                    <img id="previewProblem_<?= $index ?>" src="<?= base_url('uploads/problems/' . $detail['problem_image']) ?>" 
                                        alt="Problem" class="img-thumbnail" style="max-width:100px;">
                                </div>
                            <?php endif; ?>

                            <div class="form-check mt-2">
                                <input class="form-check-input problem-file" type="radio" name="problem_image_source_<?= $index ?>" id="problem_file_<?= $index ?>" value="file" checked>
                                <label class="form-check-label" for="problem_file_<?= $index ?>">Pilih Gambar dari File</label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input problem-camera" type="radio" name="problem_image_source_<?= $index ?>" id="problem_camera_<?= $index ?>" value="camera">
                                <label class="form-check-label" for="problem_camera_<?= $index ?>">Ambil Gambar dari Kamera</label>
                            </div>

                            <input type="file" name="problem_image_<?= $index ?>" id="problem_image_<?= $index ?>" class="form-control-file mt-2"
                                accept="image/*" onchange="previewImage(event, 'previewProblem_<?= $index ?>')">
                            <input type="hidden" name="existing_problem_image_<?= $index ?>" value="<?= esc($detail['problem_image']) ?>">
                        </div>

                        <div class="form-group col-md-3 d-flex align-items-end">
                            <button type="button" class="btn btn-danger btn-sm remove-existing-detail">Hapus</button>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        <?php else: ?>
            <p>Tidak ada detail tryout. Anda dapat menambahkan detail baru.</p>
        <?php endif; ?>

        <!-- Container untuk detail baru -->
        <div id="newDetails"></div>
        <button type="button" id="addDetail" class="btn btn-secondary">Tambah Detail Baru</button>
        
        <!-- Hidden input untuk debugging -->
        <input type="hidden" id="debugInfo" name="debug_info">
    </div>
</div>
<div class="text-center mb-3">
    <button type="submit" class="btn btn-primary">Perbarui Data</button>
    <a href="<?= site_url('tryout'); ?>" class="btn btn-secondary">Kembali</a>
</div>
    </form>
</div>

<script>
// Contoh skrip untuk menampilkan/hide input manual untuk konfirmasi dan detail tryout
$(document).ready(function () {
    $('.produksi_dropdown, .qc_dropdown, .tooling_dropdown, .rd_dropdown').change(function () {
        let inputManual = $(this).closest('.col-md-6').find('input[type="text"]');
        if ($(this).val() === 'manual') {
            inputManual.show().focus();
        } else {
            inputManual.hide().val('');
        }
    });
});
                                         
function previewImage(event, previewId) {
    const reader = new FileReader();
    reader.onload = function(){
        const output = document.getElementById(previewId);
        output.src = reader.result;
        output.style.display = 'block';
    };
    reader.readAsDataURL(event.target.files[0]);
} 

// Inisialisasi counter untuk detail baru - PERBAIKAN: Gunakan nilai yang lebih tinggi
let detailCount = <?= count($detail_tryouts) ?>; // Mulai dari jumlah detail yang sudah ada
let nextNewDetailIndex = detailCount; // Index untuk detail baru

document.addEventListener('DOMContentLoaded', function() {
    // Handle camera/file selection untuk part trial dan material images
    const partTrialFile = document.getElementById('part_trial_file');
    const partTrialCamera = document.getElementById('part_trial_camera');
    const partTrialImage = document.getElementById('part_trial_image');

    const materialFile = document.getElementById('material_file');
    const materialCamera = document.getElementById('material_camera');
    const materialImage = document.getElementById('material_image');

    if (partTrialFile && partTrialCamera && partTrialImage) {
        partTrialFile.addEventListener('change', function() {
            if (partTrialFile.checked) {
                partTrialImage.removeAttribute('capture');
            }
        });

        partTrialCamera.addEventListener('change', function() {
            if (partTrialCamera.checked) {
                partTrialImage.setAttribute('capture', 'camera');
            }
        });
    }

    if (materialFile && materialCamera && materialImage) {
        materialFile.addEventListener('change', function() {
            if (materialFile.checked) {
                materialImage.removeAttribute('capture');
            }
        });

        materialCamera.addEventListener('change', function() {
            if (materialCamera.checked) {
                materialImage.setAttribute('capture', 'camera');
            }
        });
    }

    // Fungsi untuk toggle input manual pada dropdown PIC yang sudah ada
    document.querySelectorAll('.pic-dropdown').forEach(function(dropdown) {
        dropdown.addEventListener('change', function () {
            let nameAttr = this.getAttribute('name');
            // Ambil index dari name, misalnya "pic_0"
            let index = nameAttr.split('_')[1];
            let manualInput = document.querySelector(`input[name="pic_manual_${index}"]`);
            if (manualInput) {
                if (this.value === "manual") {
                    manualInput.style.display = "block";
                    manualInput.focus();
                } else {
                    manualInput.style.display = "none";
                    manualInput.value = "";
                }
            }
        });
    });

    // Fungsi untuk menambahkan detail baru - PERBAIKAN UTAMA
    const addDetailBtn = document.getElementById('addDetail');
    if (addDetailBtn) {
        addDetailBtn.addEventListener('click', function() {
            let index = nextNewDetailIndex; // Gunakan index yang unik
            let html = `
                <div class="detail-row border p-2 mb-2" data-new-detail="true">
                    <h6>Detail Baru ${index + 1}</h6>
                    <div class="form-row">
                        <div class="form-group col-md-4">
                            <label>Problem Text</label>
                            <textarea name="problem_text_${index}" class="form-control" required></textarea>
                        </div>
                        <div class="form-group col-md-4">
                            <label>Counter Measure</label>
                            <textarea name="counter_measure_${index}" class="form-control"></textarea>
                        </div>
                        <div class="form-group col-md-4">
                            <label>PIC</label>
                            <select name="pic_${index}" class="custom-select form-control pic-dropdown-new">
                                <option value="">-- Pilih --</option>
                                <option value="manual">Ketik Lainnya</option>
                                <?php foreach ($users as $user): ?>
                                    <option value="<?= $user->id; ?>"><?= $user->nama; ?></option>
                                <?php endforeach; ?>
                            </select>
                            <input type="text" name="pic_manual_${index}" class="form-control mt-2 pic-manual-new" placeholder="Masukkan manual" style="display: none;">
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="form-group col-md-3">
                            <label>Target</label>
                            <input type="text" name="target_${index}" class="form-control">
                        </div>
                        <div class="form-group col-md-3">
                            <label>Progress (%)</label>
                            <input type="number" name="progress_${index}" class="form-control" min="0" max="100" value="0">
                        </div>
                        <div class="form-group col-md-3">
                            <label>Problem Image</label>
                            <div class="form-check">
                                <input class="form-check-input problem-file-new" type="radio" name="problem_image_source_${index}" id="problem_file_${index}" value="file" checked>
                                <label class="form-check-label" for="problem_file_${index}">Pilih Gambar dari File</label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input problem-camera-new" type="radio" name="problem_image_source_${index}" id="problem_camera_${index}" value="camera">
                                <label class="form-check-label" for="problem_camera_${index}">Ambil Gambar dari Kamera</label>
                            </div>
                            <input type="file" name="problem_image_${index}" id="problem_image_${index}" class="form-control-file"
                                   accept="image/*" onchange="previewImage(event, 'previewProblem_${index}')">
                            <img id="previewProblem_${index}" class="img-thumbnail mt-2" style="max-width:100px; display:none;">
                        </div>
                        <div class="form-group col-md-3 d-flex align-items-end">
                            <button type="button" class="btn btn-danger btn-sm remove-new-detail">Hapus</button>
                        </div>
                    </div>
                </div>
            `;

            document.getElementById('newDetails').insertAdjacentHTML('beforeend', html);
            nextNewDetailIndex++; // Increment counter setelah menambah detail
            
            console.log('Detail baru ditambahkan dengan index:', index); // Untuk debugging
        });
    }

    // Event delegation untuk menangani penghapusan detail baru
    const newDetailsContainer = document.getElementById('newDetails');
    if (newDetailsContainer) {
        newDetailsContainer.addEventListener('click', function(event) {
            if (event.target.classList.contains('remove-new-detail')) {
                if (confirm('Hapus detail baru ini?')) {
                    event.target.closest('.detail-row').remove();
                }
            }
        });
    }

    // Menangani penghapusan detail lama
    document.querySelectorAll('.remove-existing-detail').forEach(function(button) {
        button.addEventListener('click', function() {
            if (confirm("Hapus detail ini?")) {
                let parent = this.closest('.detail-row');
                // Hide the detail instead of removing it
                parent.style.display = 'none';
                // Add a hidden input to mark it for deletion (if needed)
                parent.insertAdjacentHTML('beforeend', '<input type="hidden" name="delete_detail_flag" value="1">');
            }
        });
    });

    // Event delegation untuk dropdown PIC baru (memunculkan input manual jika "Ketik Lainnya" dipilih)
    document.addEventListener('change', function(event) {
        if (event.target.classList.contains('pic-dropdown-new')) {
            let nameAttr = event.target.getAttribute('name');
            let index = nameAttr.split('_')[1];
            let manualInput = document.querySelector(`input[name="pic_manual_${index}"]`);
            if (manualInput) {
                if (event.target.value === 'manual') {
                    manualInput.style.display = 'block';
                    manualInput.focus();
                } else {
                    manualInput.style.display = 'none';
                    manualInput.value = '';
                }
            }
        }
    });

    // Event delegation untuk radio button camera/file pada detail baru
    document.addEventListener('change', function(event) {
        if (event.target.classList.contains('problem-file-new') || event.target.classList.contains('problem-camera-new')) {
            let nameAttr = event.target.getAttribute('name');
            let index = nameAttr.split('_')[3]; // problem_image_source_0 -> ambil index 0
            let fileInput = document.getElementById(`problem_image_${index}`);
            
            if (fileInput) {
                if (event.target.classList.contains('problem-camera-new') && event.target.checked) {
                    fileInput.setAttribute('capture', 'camera');
                } else if (event.target.classList.contains('problem-file-new') && event.target.checked) {
                    fileInput.removeAttribute('capture');
                }
            }
        }
    });

    // PERBAIKAN: Tambahkan event listener untuk form submit untuk debugging
    const form = document.querySelector('form');
    if (form) {
        form.addEventListener('submit', function(event) {
            console.log('Form akan disubmit');
            
            // Debug: tampilkan semua data yang akan dikirim
            const formData = new FormData(form);
            for (let [key, value] of formData.entries()) {
                if (key.includes('problem_') || key.includes('pic_') || key.includes('counter_') || key.includes('target_') || key.includes('progress_')) {
                    console.log(key + ': ' + value);
                }
            }
        });
    }
});
</script>

<?= $this->endSection() ?>