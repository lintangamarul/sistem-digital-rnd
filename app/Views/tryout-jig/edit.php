<?= $this->extend('layout/template') ?>
<?= $this->section('content') ?>

<div class="pd-ltr-20 xs-pd-20-10">
    <div class="min-height-200px">
        <!-- Breadcrumb -->
        <div class="page-header">
            <div class="row">
                <div class="col-md-6 col-sm-12">
                    <div class="title">
                        <h4>Edit Try Out Report Dies</h4>
                    </div>
                    <nav aria-label="breadcrumb" role="navigation">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item">
                                <a href="<?= site_url('dashboard'); ?>">Home</a>
                            </li>
                            <li class="breadcrumb-item">
                                <a href="<?= site_url('tryout-jig'); ?>">Tryout Jig</a>
                            </li>
                            <li class="breadcrumb-item active" aria-current="page">Form Edit Tryout Jig</li>
                        </ol>
                    </nav>
                </div>
            </div>
        </div>

        <!-- Form -->
        <div class="pd-20 card-box mb-30">
            <form action="<?= site_url('tryout-jig/update/' . $tryout_jig['id']); ?>" method="post" enctype="multipart/form-data">
                <?= csrf_field(); ?>

                <!-- Judul Section -->
                <h4 class="mt-4 mb-3"><strong>MACHINE PARAMETER</strong></h4>

                <div class="card shadow-sm p-3 mb-3">
                    <div class="row">
                    <div class="col-md-3">
    <label class="font-weight-bold">Jig No</label>
    <select name="project_id" id="project_id" class="form-control" required onchange="toggleJigNoManual(this)">
        <option value="">-- Pilih Jig No --</option>
        <option value="other" style="font-weight: bold;" <?= (!is_numeric($tryout_jig['project_id'])) ? 'selected' : '' ?>>~~ KETIK LAINNYA ~~</option>
        <?php foreach ($projects as $project): ?>
            <option value="<?= esc($project['id']); ?>" <?= ($project['id'] == $tryout_jig['project_id']) ? 'selected' : '' ?>>
                <?= esc($project['part_no']) . ' - ' . esc($project['process']); ?>
            </option>
        <?php endforeach; ?>
    </select>
    <input type="text" name="jig_no_manual" id="jig_no_manual" class="form-control mt-2"
        placeholder="Masukkan Jig No"
        value="<?= (!is_numeric($tryout_jig['project_id'])) ? esc($tryout_jig['project_id']) : '' ?>"
        style="<?= (!is_numeric($tryout_jig['project_id'])) ? 'display: block;' : 'display: none;' ?>">
</div>
                        <!-- Customer -->
                        <div class="col-md-3"> 
                            <label class="font-weight-bold">Customer</label>
                            <select name="cust" id="cust" class="form-control" required>
                                <option value="">Pilih Customer</option>
                                <option value="ADM" <?= ($tryout_jig['cust'] == 'ADM') ? 'selected' : '' ?>>ADM</option>
                                <option value="TMMIN" <?= ($tryout_jig['cust'] == 'TMMIN') ? 'selected' : '' ?>>TMMIN</option>
                                <option value="MKM" <?= ($tryout_jig['cust'] == 'MKM') ? 'selected' : '' ?>>MKM</option>
                                <option value="MMKI" <?= ($tryout_jig['cust'] == 'MMKI') ? 'selected' : '' ?>>MMKI</option>
                                <option value="HMMI" <?= ($tryout_jig['cust'] == 'HMMI') ? 'selected' : '' ?>>HMMI</option>
                                <option value="SUZUKI" <?= ($tryout_jig['cust'] == 'SUZUKI') ? 'selected' : '' ?>>SUZUKI</option>
                                <option value="GMR" <?= ($tryout_jig['cust'] == 'GMR') ? 'selected' : '' ?>>GMR</option>
                                <option value="HPM" <?= ($tryout_jig['cust'] == 'HPM') ? 'selected' : '' ?>>HPM</option>
                            </select>
                        </div>
                        
                        <!-- Project -->
                        <div class="col-md-3">
                            <label class="font-weight-bold">Project</label>
                            <select name="projek" id="projek" class="form-control" required>
                                <option value="">Pilih Projek</option>
                                <option value="D14N" <?= ($tryout_jig['projek'] == 'D14N') ? 'selected' : '' ?>>D14N</option>
                                <option value="D26A" <?= ($tryout_jig['projek'] == 'D26A') ? 'selected' : '' ?>>D26A</option>
                                <option value="D30D" <?= ($tryout_jig['projek'] == 'D30D') ? 'selected' : '' ?>>D30D</option>
                                <option value="D40" <?= ($tryout_jig['projek'] == 'D40') ? 'selected' : '' ?>>D40</option>
                                <option value="D40D" <?= ($tryout_jig['projek'] == 'D40D') ? 'selected' : '' ?>>D40D</option>
                                <option value="D40L" <?= ($tryout_jig['projek'] == 'D40L') ? 'selected' : '' ?>>D40L</option>
                                <option value="D55L" <?= ($tryout_jig['projek'] == 'D55L') ? 'selected' : '' ?>>D55L</option>
                                <option value="D72A" <?= ($tryout_jig['projek'] == 'D72A') ? 'selected' : '' ?>>D72A</option>
                                <option value="D74A" <?= ($tryout_jig['projek'] == 'D74A') ? 'selected' : '' ?>>D74A</option>
                                <option value="D03B" <?= ($tryout_jig['projek'] == 'D03B') ? 'selected' : '' ?>>D03B</option>
                                <option value="SL" <?= ($tryout_jig['projek'] == 'SL') ? 'selected' : '' ?>>SL</option>
                                <option value="KS" <?= ($tryout_jig['projek'] == 'KS') ? 'selected' : '' ?>>KS</option>
                                <option value="SU2ID" <?= ($tryout_jig['projek'] == 'SU2ID') ? 'selected' : '' ?>>SU2ID</option>
                                <option value="SU2ID-FL" <?= ($tryout_jig['projek'] == 'SU2ID-FL') ? 'selected' : '' ?>>SU2ID-FL</option>
                                <option value="YL0" <?= ($tryout_jig['projek'] == 'YL0') ? 'selected' : '' ?>>YL0</option>
                                <option value="2MD" <?= ($tryout_jig['projek'] == '2MD') ? 'selected' : '' ?>>2MD</option>
                            </select>
                        </div>
                        <div class="col-md-3 ">
                            <label class="font-weight-bold">Upload Gambar</label>
                            <input type="file" name="image" id="image" class="form-control-file" accept="image/*">
                            <?php if ($tryout_jig['image']): ?>
                                <img src="<?= base_url('uploads/tryout-jig/' . $tryout_jig['image']) ?>" alt="Current Image" class="img-thumbnail mt-2" style="max-width: 100px;">
                            <?php endif; ?>
                        </div>
                        <div class="col-md-4 mt-3"><label class="font-weight-bold">PART NAME</label><input type="text" name="part_name" id="part_name" class="form-control" value="<?= esc($tryout_jig['part_name']) ?>"></div>

                        <!-- Event -->
                        <div class="col-md-4 mt-3">
                            <label class="font-weight-bold">Event</label>
                            <select name="event" id="event" class="form-control">
                                <option value="">Pilih Event</option>
                                <option value="REGULAR CHECK" <?= ($tryout_jig['event'] == 'REGULAR CHECK') ? 'selected' : '' ?>>REGULAR CHECK</option>
                                <option value="IMPROVEMENT" <?= ($tryout_jig['event'] == 'IMPROVEMENT') ? 'selected' : '' ?>>IMPROVEMENT</option>
                                <option value="NEW PROJECT" <?= ($tryout_jig['event'] == 'NEW PROJECT') ? 'selected' : '' ?>>NEW PROJECT</option>
                                <option value="TROUBLESHOOTING" <?= ($tryout_jig['event'] == 'TROUBLESHOOTING') ? 'selected' : '' ?>>TROUBLESHOOTING</option>
                                <option value="ECI" <?= ($tryout_jig['event'] == 'ECI') ? 'selected' : '' ?>>ECI</option>
                            </select>
                        </div>

                        <!-- Tanggal -->
                        <div class="col-md-4 mt-3">
                            <label class="font-weight-bold">Tanggal</label>
                            <input type="date" name="date" id="date" class="form-control" value="<?= esc($tryout_jig['date']) ?>" required>
                        </div>
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
                            <?php foreach ($detail_clusters as $detail): ?>
                                <tr>
                                    <td><input type="text" name="part_levelling[]" class="form-control" value="<?= esc($detail['part_levelling']) ?>"></td>
                                    <td><input type="text" name="part_specification[]" class="form-control" value="<?= esc($detail['part_specification']) ?>"></td>
                                    <td><button type="button" class="btn btn-danger removeDetail">Hapus</button></td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                    <button type="button" class="btn btn-secondary" id="addDetail">Tambah Detail</button>
                </div>

                <!-- EQUIPMENT INFORMATION -->
                <h5 class="mt-4 mb-3"><strong>EQUIPMENT INFORMATION</strong></h5>
                <div class="card shadow-sm p-3 mb-4">
                    <div class="row">
                        <div class="col-md-4"><label class="font-weight-bold">MACHINE USAGE</label><input type="text" name="m_usage" id="m_usage" class="form-control" value="<?= esc($tryout_jig['m_usage']) ?>"></div>
                        <div class="col-md-4"><label class="font-weight-bold">MACHINE SPEC</label><input type="text" name="m_spec" id="m_spec" class="form-control" value="<?= esc($tryout_jig['m_spec']) ?>"></div>
                        <div class="col-md-4"><label class="font-weight-bold">GUN / HOLDER TYPE</label><input type="text" name="holder" id="holder" class="form-control" value="<?= esc($tryout_jig['holder']) ?>"></div>
                    </div>
                </div>

                <!-- WELDING CONDITION RESULT -->
                <h5 class="mt-4 mb-3"><strong>WELDING CONDITION RESULT</strong></h5>
                <div class="card shadow-sm p-3 mb-4">
                    <div class="row">
                        <div class="col-md-4"><label class="font-weight-bold">VISUAL CHECK</label><input type="text" name="r_visual" id="r_visual" class="form-control" value="<?= esc($tryout_jig['r_visual']) ?>"></div>
                        <div class="col-md-4"><label class="font-weight-bold">TORQUE / PEEL CHECK</label><input type="text" name="r_torque" id="r_torque" class="form-control" value="<?= esc($tryout_jig['r_torque']) ?>"></div>
                        <div class="col-md-4"><label class="font-weight-bold">CUTTING CHECK</label><input type="text" name="r_cut" id="r_cut" class="form-control" value="<?= esc($tryout_jig['r_cut']) ?>"></div>
                    </div>
                </div>

                <!-- WELDING CONDITION STANDARD -->
                <h5 class="mt-4 mb-3"><strong>WELDING CONDITION STANDARD</strong></h5>
                <div class="card shadow-sm p-3 mb-4">
                    <div class="row">
                        <div class="col-md-3"><label class="font-weight-bold">VISUAL CHECK</label><input type="text" name="s_visual" id="s_visual" class="form-control" value="<?= esc($tryout_jig['s_visual']) ?>"></div>
                        <div class="col-md-3"><label class="font-weight-bold">TORQUE / PEEL CHECK</label><input type="text" name="s_torque" id="s_torque" class="form-control" value="<?= esc($tryout_jig['s_torque']) ?>"></div>
                        <div class="col-md-3"><label class="font-weight-bold">CUTTING CHECK</label><input type="text" name="s_cut" id="s_cut" class="form-control" value="<?= esc($tryout_jig['s_cut']) ?>"></div>
                        <div class="col-md-3">
                            <label class="font-weight-bold">JUDGEMENT</label>
                            <select name="judge" id="judge" class="form-control">
                                <option value="">-- Pilih OK/NG --</option>
                                <option value="OK" <?= ($tryout_jig['judge'] == 'OK') ? 'selected' : '' ?>>OK</option>
                                <option value="NG" <?= ($tryout_jig['judge'] == 'NG') ? 'selected' : '' ?>>NG</option>
                            </select>
                        </div>
                    </div>
                </div>

                <!-- PRODUCTION CAPABILITY -->
                <h5 class="mt-4 mb-3"><strong>PRODUCTION CAPABILITY</strong></h5>
                <div class="card shadow-sm p-3 mb-4">
                    <div class="row">
                        <div class="col-md-3 d-flex align-items-center justify-content-center">
                            <h5 class="font-weight-bold text-center">Σ MAN POWER</h5>
                        </div>
                        <div class="col-md-3"><label class="font-weight-bold">TAKT TIME TARGET</label><input type="text" name="t_target" id="t_target" class="form-control" value="<?= esc($tryout_jig['t_target']) ?>"></div>
                        <div class="col-md-3"><label class="font-weight-bold">TAKT TIME ACT</label><input type="text" name="a_target" id="a_target" class="form-control" value="<?= esc($tryout_jig['a_target']) ?>"></div>
                        <div class="col-md-3">
                            <label class="font-weight-bold">SHIFT/DAY</label>
                            <select name="shift" id="shift" class="form-control">
                                <option value="">Pilih Shift</option>
                                <option value="1 SHIFT" <?= ($tryout_jig['shift'] == '1 SHIFT') ? 'selected' : '' ?>>1 SHIFT</option>
                                <option value="2 SHIFT" <?= ($tryout_jig['shift'] == '2 SHIFT') ? 'selected' : '' ?>>2 SHIFT</option>
                            </select>
                        </div>
                        <div class="col-md-3 mt-3"><label class="font-weight-bold">CYCLE TIME TARGET</label><input type="text" name="t_cycle" id="t_cycle" class="form-control" value="<?= esc($tryout_jig['t_cycle']) ?>"></div>
                        <div class="col-md-3 mt-3"><label class="font-weight-bold">CYCLE TIME ACT</label><input type="text" name="a_cycle" id="a_cycle" class="form-control" value="<?= esc($tryout_jig['a_cycle']) ?>"></div>
                        <div class="col-md-3 mt-1">
                            <label class="font-weight-bold small">
                                MAX. CAPACITY / MONTH With O/T
                            </label>
                            <input type="text" name="whit" id="whit" class="form-control" value="<?= esc($tryout_jig['whit']) ?>">
                        </div>
                        <div class="col-md-3 mt-1">
                            <label class="font-weight-bold small">
                                MAX. CAPACITY / MONTH Without O/T
                            </label>
                            <input type="text" name="whitout" id="whitout" class="form-control" value="<?= esc($tryout_jig['whitout']) ?>">
                        </div>  
                        <div class="col-md-3 mt-3">
                            <label class="font-weight-bold">WORKING H/SHIFT</label>
                            <div class="input-group">
                                <select name="work_h" id="work_h" class="form-control">
                                    <option value="">Pilih Jam</option>
                                    <?php for ($i = 1; $i <= 24; $i++): ?>
                                        <option value="<?= $i ?>" <?= ($tryout_jig['work_h'] == $i . ' Jam') ? 'selected' : '' ?>><?= $i ?></option>
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
                                        <option value="<?= $i ?>" <?= ($tryout_jig['work_d'] == $i . ' Hari') ? 'selected' : '' ?>><?= $i ?></option>
                                    <?php endfor; ?>
                                </select>
                                <span class="input-group-text">Hari</span>
                            </div>
                        </div>
                        <div class="col-md-2 mt-3"><label class="font-weight-bold">UPH TARGET</label><input type="text" name="t_uph" id="t_uph" class="form-control" value="<?= esc($tryout_jig['t_uph']) ?>"></div>
                        <div class="col-md-2 mt-3"><label class="font-weight-bold">UPH ACTUAL</label><input type="text" name="a_uph" id="a_uph" class="form-control" value="<?= esc($tryout_jig['a_uph']) ?>"></div>
                        <div class="col-md-2 mt-3">
                            <label class="font-weight-bold">JUDGEMENT</label>
                            <select name="judgement" id="judge" class="form-control">
                                <option value="">-- Pilih OK/NG --</option>
                                <option value="OK" <?= ($tryout_jig['judgement'] == 'OK') ? 'selected' : '' ?>>OK</option>
                                <option value="NG" <?= ($tryout_jig['judgement'] == 'NG') ? 'selected' : '' ?>>NG</option>
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
            <?php foreach ($detail_tryouts as $index => $detail): ?>
                <tr>
                    <td>
                        <input type="file" name="problem_image[]" class="form-control mb-2" onchange="previewImage(event, <?= $index ?>)">
                        <input type="hidden" name="old_problem_image[]" value="<?= esc($detail['problem_image']) ?>"> <!-- Simpan gambar lama -->
                        <img id="preview_<?= $index ?>" src="<?= !empty($detail['problem_image']) ? base_url('uploads/tryout-details/' . $detail['problem_image']) : '' ?>" 
                            class="img-thumbnail" style="max-width: 100px; <?= empty($detail['problem_image']) ? 'display: none;' : '' ?>">
                        <input type="text" name="problem[]" class="form-control mt-2" value="<?= esc($detail['problem']) ?>">
                    </td>
                    <td><input type="text" name="measure[]" class="form-control" value="<?= esc($detail['measure']) ?>"></td>
                    <td>
                        <input type="text" name="pic[]" class="form-control pic-input" value="<?= esc($detail['pic']) ?>" placeholder="Masukkan PIC" maxlength="11">
                    </td>
                    <td><input type="date" name="target[]" class="form-control" value="<?= esc($detail['target']) ?>"></td>
                    <td><input type="number" name="progress[]" class="form-control" value="<?= (int) filter_var($detail['progress'], FILTER_SANITIZE_NUMBER_INT) ?>" min="0" max="100"></td>
                    <td><input type="text" name="remarks[]" class="form-control" value="<?= esc($detail['remarks']) ?>"></td>
                    <td><button type="button" class="btn btn-danger btn-sm" onclick="removeRow(this)">Hapus</button></td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
    <button type="button" class="btn btn-secondary" id="addTryoutDetail">Tambah Detail</button>
</div>

                <!-- DETAIL SETTINGS -->
                <h4 class="mt-4 mb-3"><strong>DETAIL SETTINGS</strong></h4>
                <div class="card shadow-sm p-3 mb-4">
                    <table class="table table-bordered">
                    <thead>
            <tr>
                <th colspan="7" class="text-center" style="font-size: 1.2rem; font-weight: bold; text-decoration: underline;">WELDING PARAMETER SETTING</th>
            </tr>
            <tr>
                <th>Point</th>
                <th>Class</th>
                <th>Combination</th>
                <th>Sched Chanl</th>
                <th>Squeeze</th>
                <th>Up Slope</th>
                <th>Hold</th> <!-- Tambahan kolom Hold -->
            </tr>
            <tr>
                <th colspan="6" class="text-center" style="font-size: 1.2rem; font-weight: bold; text-decoration: underline;">SPOT WELD</th>
            </tr>
            <tr>
                <th>Weld Curr 1</th>
                <th>Weld Time 1</th>
                <th>Weld Curr 2</th>
                <th>Weld Time 2</th>
                <th>Weld Curr 3</th>
                <th>Weld Time 3</th>
            </tr>
            <tr>
                <th colspan="6" class="text-center" style="font-size: 1.2rem; font-weight: bold; text-decoration: underline;">CO WELD</th>
            </tr>
            <tr>
                <th>Press</th>
                <th>Turn Ratio</th>
                <th>Amper</th>
                <th>Volt</th>
                <th>Speed</th>
                <th>Aksi</th>
            </tr>
        </thead>
                        <tbody id="detailSettingsTable">
                            <?php foreach ($detail_settings as $detail): ?>
                                <tr>
                                    <td><input type="number" step="0.1" name="point[]" class="form-control" value="<?= esc($detail['point']) ?>"></td>
                                    <td>
                                        <select name="class[]" class="form-control">
                                            <option value="S" <?= ($detail['class'] == 'S') ? 'selected' : '' ?>>S</option>
                                            <option value="G" <?= ($detail['class'] == 'G') ? 'selected' : '' ?>>G</option>
                                            <option value="A" <?= ($detail['class'] == 'A') ? 'selected' : '' ?>>A</option>
                                            <option value="R" <?= ($detail['class'] == 'R') ? 'selected' : '' ?>>R</option>
                                        </select>
                                    </td>
                                    <td>
                                        <select name="combination[]" class="form-control combination-select" multiple>
                                            <?php foreach ($partLevellingOptions as $option): ?>
                                                <option value="<?= $option ?>" <?= (in_array($option, explode(' x ', $detail['combination']))) ? 'selected' : '' ?>><?= $option ?></option>
                                            <?php endforeach; ?>
                                        </select>
                                        <input type="hidden" name="combination_result[]" class="combination-result" value="<?= esc($detail['combination']) ?>">
                                    </td>
                                    <td><input type="number" step="0.1" name="sched_chanl[]" class="form-control" value="<?= esc(str_replace(' cyc', '', $detail['sched_chanl'])) ?>"></td>
                                    <td><input type="number" step="0.1" name="squeeze[]" class="form-control" value="<?= esc(str_replace(' cyc', '', $detail['squeeze'])) ?>"></td>
                                    <td><input type="number" step="0.1" name="up_slope[]" class="form-control" value="<?= esc(str_replace(' cyc', '', $detail['up_slope'])) ?>"></td>
                                    <td><input type="number" step="0.1" name="hold[]" class="form-control" value="<?= esc(isset($detail['hold']) ? str_replace(' cyc', '', $detail['hold']) : '') ?>"></td>
                                </tr>
                                <tr>
                                    <td><input type="number" step="0.1" name="weld_curr_1[]" class="form-control" value="<?= esc(str_replace(' ka', '', $detail['w_c1'])) ?>"></td>
                                    <td><input type="number" step="0.1" name="weld_time_1[]" class="form-control" value="<?= esc(str_replace(' cyc', '', $detail['w_t1'])) ?>"></td>
                                    <td><input type="number" step="0.1" name="weld_curr_2[]" class="form-control" value="<?= esc(str_replace(' ka', '', $detail['w_c2'])) ?>"></td>
                                    <td><input type="number" step="0.1" name="weld_time_2[]" class="form-control" value="<?= esc(str_replace(' cyc', '', $detail['w_t2'])) ?>"></td>
                                    <td><input type="number" step="0.1" name="weld_curr_3[]" class="form-control" value="<?= esc(str_replace(' ka', '', $detail['w_c3'])) ?>"></td>
                                    <td><input type="number" step="0.1" name="weld_time_3[]" class="form-control" value="<?= esc(str_replace(' cyc', '', $detail['w_t3'])) ?>"></td>
                                </tr>
                                <tr>
                                    <td><input type="text" name="press[]" class="form-control" value="<?= esc(str_replace(' kn', '', $detail['press'])) ?>"></td>
                                    <td><input type="number" step="0.1" name="turn_ratio[]" class="form-control" value="<?= esc($detail['ratio']) ?>"></td>
                                    <td><input type="number" step="0.1" name="amper[]" class="form-control" value="<?= esc(str_replace(' a', '', $detail['amper'])) ?>"></td>
                                    <td><input type="number" step="0.1" name="volt[]" class="form-control" value="<?= esc(str_replace(' v', '', $detail['volt'])) ?>"></td>
                                    <td><input type="number" step="0.1" name="speed[]" class="form-control" value="<?= esc(str_replace(' mm/s', '', $detail['speed'])) ?>"></td>
                                    <td><button type="button" class="btn btn-danger btn-sm removeDetail">Hapus</button></td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                    <button type="button" class="btn btn-secondary mt-3" id="addDetailSetting">Tambah Detail</button>
                </div>
                <h4 class="mt-4 mb-3"><strong>EDIT MEMBER TRIAL</strong></h4>
<div class="card shadow-sm p-3 mb-4">
        <div class="row">
            <?php
            $roles = ['tooling', 'quality', 'produksi', 'ps', 'rnd'];
            foreach ($roles as $index => $role):
                // Cek apakah ada data lama yang tersimpan
                $selectedValue = $tryout_jig[$role] ?? '';
                $isManualInput = !in_array($selectedValue, array_column($users, 'nama')) && !empty($selectedValue);
            ?>
                <div class="col-md-<?= ($index < 2) ? '6' : '4' ?> mt-3">
                    <label class="font-weight-bold"><?= ucfirst($role) ?></label>
                    <select name="<?= $role ?>" class="form-control member-trial">
                        <option value="">Pilih <?= ucfirst($role) ?></option>
                        <option value="other" style="font-weight: bold;" <?= $isManualInput ? 'selected' : '' ?>>~~ KETIK LAINNYA ~~</option>
                        <?php foreach ($users as $user): ?>
                            <option value="<?= $user['nama'] ?>" <?= ($selectedValue == $user['nama']) ? 'selected' : '' ?>><?= $user['nama'] ?></option>
                        <?php endforeach; ?>
                    </select>
                    <input type="text" name="<?= $role ?>_manual" class="form-control mt-2 <?= $isManualInput ? '' : 'd-none' ?> other-input" placeholder="Masukkan <?= ucfirst($role) ?> manual" value="<?= $isManualInput ? $selectedValue : '' ?>">
                </div>
                <?php if ($index == 1): ?>  
                    </div><div class="row"> <!-- Tutup baris pertama & mulai baris kedua -->
                <?php endif; ?>
            <?php endforeach; ?>
        </div>

       
</div>
                <!-- Tombol Simpan -->
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
document.getElementById('addDetail').addEventListener('click', function() {
    let table = document.getElementById('detailTable');
    let row = table.insertRow();
    row.innerHTML = `
        <td><input type="text" name="part_levelling[]" class="form-control"></td>
        <td><input type="text" name="part_specification[]" class="form-control"></td>
        <td><button type="button" class="btn btn-danger removeDetail">Hapus</button></td>
    `;
    row.querySelector('.removeDetail').addEventListener('click', function() {
        row.remove();
    });
});

document.getElementById("addTryoutDetail").addEventListener("click", function () {
    let table = document.getElementById("tryoutDetailTable");
    let rowCount = table.rows.length;

    let picOptions = `<?php foreach ($users as $user) : ?> 
                        <option value="<?= $user['nama'] ?>"><?= $user['nama'] ?></option> 
                      <?php endforeach; ?>`;

    let row = table.insertRow(rowCount);
    row.innerHTML = `
        <td>
            <input type="file" name="problem_image[]" class="form-control mb-2" onchange="previewImage(event, ${rowCount})">
            <img id="preview_${rowCount}" src="" class="img-thumbnail" style="max-width: 100px; display: none;">
            <input type="text" name="problem[]" class="form-control mt-2" placeholder="Masukkan problem">
        </td>
        <td><input type="text" name="measure[]" class="form-control" placeholder="Masukkan measure"></td>
        <td>
            <select name="pic[]" class="form-control">
                ${picOptions}
            </select>
        </td>
        <td><input type="date" name="target[]" class="form-control"></td>
        <td><input type="number" name="progress[]" class="form-control" placeholder="Masukkan progress (%)" min="0" max="100"></td>
        <td><input type="text" name="remarks[]" class="form-control" placeholder="Masukkan remarks"></td>
        <td><button type="button" class="btn btn-danger btn-sm" onclick="removeRow(this)">Hapus</button></td>
    `;
});

function previewImage(event, index) {
    let reader = new FileReader();
    reader.onload = function () {
        let preview = document.getElementById("preview_" + index);
        preview.src = reader.result;
        preview.style.display = "block";
    };
    reader.readAsDataURL(event.target.files[0]);
}

function removeRow(button) {
    let row = button.parentNode.parentNode;
    row.parentNode.removeChild(row);
}


document.getElementById('addDetailSetting').addEventListener('click', function () {
    let table = document.getElementById('detailSettingsTable');

    // Ambil semua nilai Part Levelling dari Detail Part Clustering
    let partLevellingOptions = Array.from(document.querySelectorAll('input[name="part_levelling[]"]'))
        .map(input => input.value)
        .filter(value => value.trim() !== ""); // Hanya ambil yang tidak kosong

    let row1 = document.createElement('tr');
    row1.innerHTML = `
        <td><input type="number" step="0.1" name="point[]" class="form-control" required></td>
        <td>
            <select name="class[]" class="form-control" required>
                <option value="">Pilih Class</option>
                <option value="S">S</option>
                <option value="G">G</option>
                <option value="A">A</option>
                <option value="R">R</option>
            </select>
        </td>
        <td>
            <select name="combination[]" class="form-control combination-select" multiple>
                ${partLevellingOptions.map(option => `<option value="${option}">${option}</option>`).join('')}
            </select>
            <input type="hidden" name="combination_result[]" class="combination-result">
        </td>
        <td><input type="number" step="0.1" name="sched_chanl[]" class="form-control"></td>
        <td><input type="number" step="0.1" name="squeeze[]" class="form-control"></td>
        <td><input type="number" step="0.1" name="up_slope[]" class="form-control"></td>
                <td><input type="number" step="0.1" name="hold[]" class="form-control"></td>

    `;

    let row2 = document.createElement('tr');
    row2.innerHTML = `
        <td><input type="number" step="0.1" name="weld_curr_1[]" class="form-control"></td>
        <td><input type="number" step="0.1" name="weld_time_1[]" class="form-control"></td>
        <td><input type="number" step="0.1" name="weld_curr_2[]" class="form-control"></td>
        <td><input type="number" step="0.1" name="weld_time_2[]" class="form-control"></td>
        <td><input type="number" step="0.1" name="weld_curr_3[]" class="form-control"></td>
        <td><input type="number" step="0.1" name="weld_time_3[]" class="form-control"></td>
    `;

    let row3 = document.createElement('tr');
    row3.innerHTML = `
        <td><input type="text" name="press[]" class="form-control"></td>
        <td><input type="number" step="0.1" name="turn_ratio[]" class="form-control"></td>
        <td><input type="number" step="0.1" name="amper[]" class="form-control"></td>
        <td><input type="number" step="0.1" name="volt[]" class="form-control"></td>
        <td><input type="number" step="0.1" name="speed[]" class="form-control"></td>
        <td><button type="button" class="btn btn-danger btn-sm removeDetail">Hapus</button></td>
    `;

    table.appendChild(row1);
    table.appendChild(row2);
    table.appendChild(row3);

    // Event listener untuk kombinasi nilai
    row1.querySelector('.combination-select').addEventListener('change', function () {
        let selectedValues = Array.from(this.selectedOptions).map(option => option.value);
        let combinationResult = selectedValues.join(' x '); // Gabungkan nilai dengan format "x"
        row1.querySelector('.combination-result').value = combinationResult;
    });

    // Event listener untuk tombol hapus
    row3.querySelector('.removeDetail').addEventListener('click', function () {
        row1.remove();
        row2.remove();
        row3.remove();
    });
});
</script>
<script>
    document.addEventListener("DOMContentLoaded", function () {
        const memberSelects = document.querySelectorAll(".member-trial");

        memberSelects.forEach(select => {
            select.addEventListener("change", function () {
                const manualInput = this.nextElementSibling;
                if (this.value === "other") {
                    manualInput.classList.remove("d-none");
                    manualInput.focus();
                } else {
                    manualInput.classList.add("d-none");
                    manualInput.value = "";
                }
            });
        });
    });
</script>
<?= $this->endSection() ?>