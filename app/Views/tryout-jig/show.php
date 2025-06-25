<?= $this->extend('layout/template') ?>
<?= $this->section('content') ?>

<div class="pd-ltr-20 xs-pd-20-10">
    <div class="min-height-200px">
        <!-- Breadcrumb -->
        <div class="page-header">
            <div class="row">
                <div class="col-md-6 col-sm-12">
                    <div class="title">
                        <h4>Detail Try Out Report Dies</h4>
                    </div>
                    <nav aria-label="breadcrumb" role="navigation">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item">
                                <a href="<?= site_url('dashboard'); ?>">Home</a>
                            </li>
                            <li class="breadcrumb-item">
                                <a href="<?= site_url('tryout-jig'); ?>">Tryout Jig</a>
                            </li>
                            <li class="breadcrumb-item active" aria-current="page">Detail Tryout Jig</li>
                        </ol>
                    </nav>
                </div>
            </div>
        </div>

        <!-- Detail -->
        <div class="pd-20 card-box mb-30">
            <h4 class="mt-4 mb-3"><strong>MACHINE PARAMETER</strong></h4>

            <div class="card shadow-sm p-3 mb-4">
                <div class="row">
                    <div class="col-md-4">
                        <label class="font-weight-bold">Jig No</label>
                        <p><?= esc($tryout['part_no']); ?></p>
                    </div>
                    <div class="col-md-4">
                        <label class="font-weight-bold">Customer</label>
                        <p><?= esc($tryout['cust']); ?></p>
                    </div>
                    <div class="col-md-4">
                        <label class="font-weight-bold">Project</label>
                        <p><?= esc($tryout['projek']); ?></p>
                    </div>
                    <div class="col-md-4 mt-3">
                        <label class="font-weight-bold">Event</label>
                        <p><?= esc($tryout['event']); ?></p>
                    </div>
                    <div class="col-md-4 mt-3">
                        <label class="font-weight-bold">Tanggal</label>
                        <p><?= esc($tryout['date']); ?></p>
                    </div>
                    <div class="col-md-4 mt-3">
                        <label class="font-weight-bold">Gambar</label>
                        <?php if (!empty($tryout['image'])): ?>
                            <br>
                            <img src="<?= base_url('uploads/tryout-jig/' . $tryout['image']); ?>" class="img-fluid" style="max-width: 200px;">
                        <?php else: ?>
                            <p>Tidak ada gambar</p>
                        <?php endif; ?>
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
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (!empty($details)): ?>
                            <?php foreach ($details as $detail): ?>
                                <tr>
                                    <td><?= esc($detail['part_levelling']); ?></td>
                                    <td><?= esc($detail['part_specification']); ?></td>
                                </tr>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <tr>
                                <td colspan="2" class="text-center">Tidak ada data detail</td>
                            </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
            <!-- DETAIL SETTINGS -->
<h4 class="mt-4 mb-3"><strong>DETAIL SETTINGS</strong></h4>
<div class="card shadow-sm p-3 mb-4">
    <div class="table-responsive">
        <table class="table table-bordered">
        <thead>
                <tr>
                    <th colspan="6" class="text-center" style="font-size: 1.2rem; font-weight: bold; text-decoration: underline;">WELDING PARAMETER SETTING</th>
                    <th colspan="6" class="text-center" style="font-size: 1.2rem; font-weight: bold; text-decoration: underline;">SPOT WELD</th>
                    <th colspan="5" class="text-center" style="font-size: 1.2rem; font-weight: bold; text-decoration: underline;">CO WELD</th>
                </tr>
                <tr>
                    <th>Point</th>
                    <th>Class</th>
                    <th>Combination</th>
                    <th>Sched Chanl</th>
                    <th>Squeeze</th>
                    <th>Up Slope</th>
                    <th>Weld Curr 1</th>
                    <th>Weld Time 1</th>
                    <th>Weld Curr 2</th>
                    <th>Weld Time 2</th>
                    <th>Weld Curr 3</th>
                    <th>Weld Time 3</th>
                    <th>Press</th>
                    <th>Turn Ratio</th>
                    <th>Hold</th>
                    <th>Amper</th>
                    <th>Volt</th>
                    <th>Speed</th>
                </tr>
            </thead>
            <tbody>
                <?php if (!empty($detail_settings)): ?>
                    <?php foreach ($detail_settings as $setting): ?>
                        <tr>
                            <td><?= esc($setting['point']); ?></td>
                            <td><?= esc($setting['class']); ?></td>
                            <td><?= esc($setting['combination']); ?></td>
                            <td><?= esc($setting['sched_chanl']); ?></td>
                            <td><?= esc($setting['squeeze']); ?></td>
                            <td><?= esc($setting['up_slope']); ?></td>
                            <td><?= esc($setting['w_c1']); ?></td>
                            <td><?= esc($setting['w_t1']); ?></td>
                            <td><?= esc($setting['w_c2']); ?></td>
                            <td><?= esc($setting['w_t2']); ?></td>
                            <td><?= esc($setting['w_c3']); ?></td>
                            <td><?= esc($setting['w_t3']); ?></td>
                            <td><?= esc($setting['press']); ?></td>
                            <td><?= esc($setting['ratio']); ?></td>
                            <td><?= esc($setting['hold']); ?></td>
                            <td><?= esc($setting['amper']); ?></td>
                            <td><?= esc($setting['volt']); ?></td>
                            <td><?= esc($setting['speed']); ?></td>
                        </tr>
                    <?php endforeach; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="17" class="text-center">Tidak ada data detail settings</td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>

            <h5 class="mt-4 mb-3"><strong>EQUIPMENT INFORMATION</strong></h5>
            <div class="card shadow-sm p-3 mb-4">
                <div class="row">
                    <div class="col-md-4">
                        <label class="font-weight-bold">MACHINE USAGE</label>
                        <p><?= esc($tryout['m_usage']); ?></p>
                    </div>
                    <div class="col-md-4">
                        <label class="font-weight-bold">MACHINE SPEC</label>
                        <p><?= esc($tryout['m_spec']); ?></p>
                    </div>
                    <div class="col-md-4">
                        <label class="font-weight-bold">GUN / HOLDER TYPE</label>
                        <p><?= esc($tryout['holder']); ?></p>
                    </div>
                </div>
            </div>

            <h5 class="mt-4 mb-3"><strong>WELDING CONDITION RESULT</strong></h5>
            <div class="card shadow-sm p-3 mb-4">
                <div class="row">
                    <div class="col-md-4">
                        <label class="font-weight-bold">VISUAL CHECK</label>
                        <p><?= esc($tryout['r_visual']); ?></p>
                    </div>
                    <div class="col-md-4">
                        <label class="font-weight-bold">TORQUE / PEEL CHECK</label>
                        <p><?= esc($tryout['r_torque']); ?></p>
                    </div>
                    <div class="col-md-4">
                        <label class="font-weight-bold">CUTTING CHECK</label>
                        <p><?= esc($tryout['r_cut']); ?></p>
                    </div>
                </div>
            </div>

            <h5 class="mt-4 mb-3"><strong>WELDING CONDITION STANDARD</strong></h5>
            <div class="card shadow-sm p-3 mb-4">
                <div class="row">
                    <div class="col-md-3">
                        <label class="font-weight-bold">VISUAL CHECK</label>
                        <p><?= esc($tryout['s_visual']); ?></p>
                    </div>
                    <div class="col-md-3">
                        <label class="font-weight-bold">TORQUE / PEEL CHECK</label>
                        <p><?= esc($tryout['s_torque']); ?></p>
                    </div>
                    <div class="col-md-3">
                        <label class="font-weight-bold">CUTTING CHECK</label>
                        <p><?= esc($tryout['s_cut']); ?></p>
                    </div>
                    <div class="col-md-3">
                        <label class="font-weight-bold">JUDGEMENT</label>
                        <p><?= esc($tryout['judge']); ?></p>
                    </div>
                </div>
            </div>
            <h5 class="mt-4 mb-3"><strong>PRODUCTION CAPABILITY</strong></h5>
            <div class="card shadow-sm p-3 mb-4">
                <div class="row">
                    <div class="col-md-3 d-flex align-items-center justify-content-center">
                            <h5 class="font-weight-bold text-center">Σ MAN POWER</h5>
                        </div>
                    <div class="col-md-3">
                        <label class="font-weight-bold">TAKT TIME TARGET</label>
                        <p><?= esc($tryout['t_target']); ?></p>
                    </div>
                    <div class="col-md-3">
                        <label class="font-weight-bold">TORQUE / PEEL CHECK</label>
                        <p><?= esc($tryout['a_target']); ?></p>
                    </div>
                    <div class="col-md-3">
                        <label class="font-weight-bold">SHIFT/DAY</label>
                        <p><?= esc($tryout['shift']); ?></p>
                    </div>
                    <div class="col-md-3 mt-3">
                        <label class="font-weight-bold">CYCLE TIME TARGET</label>
                        <p><?= esc($tryout['t_cycle']); ?></p>
                    </div>
                    <div class="col-md-3 mt-3">
                        <label class="font-weight-bold">CYCLE TIME ACTUAL</label>
                        <p><?= esc($tryout['a_cycle']); ?></p>
                    </div>
                    <div class="col-md-3 mt-1">
                        <label class="font-weight-bold small">MAX. CAPACITY / MONTH With O/T</label>
                        <p><?= esc($tryout['whit']); ?></p>
                    </div>
                    <div class="col-md-3 mt-1">
                        <label class="font-weight-bold small">MAX. CAPACITY / MONTH Without O/T</label>
                        <p><?= esc($tryout['whitout']); ?></p>
                    </div>
                    <div class="col-md-3 mt-3">
                        <label class="font-weight-bold">WORKING H/SHIFT</label>
                        <p><?= esc($tryout['work_h']); ?></p>
                    </div>
                    <div class="col-md-3 mt-3">
                        <label class="font-weight-bold">WORKING D/MONTH</label>
                        <p><?= esc($tryout['work_d']); ?></p>
                    </div>
                    <div class="col-md-2 mt-3">
                        <label class="font-weight-bold">UPH TARGET</label>
                        <p><?= esc($tryout['t_uph']); ?></p>
                    </div>
                    <div class="col-md-2 mt-3">
                        <label class="font-weight-bold">UPH ACTUAL</label>
                        <p><?= esc($tryout['a_uph']); ?></p>
                    </div>
                    <div class="col-md-2 mt-3">
                        <label class="font-weight-bold">JUDGEMENT</label>
                        <p><?= esc($tryout['judgement']); ?></p>
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
                <th>Progress</th>
                <th>Remarks</th>
            </tr>
        </thead>
        <tbody>
            <?php if (!empty($detail_tryout)) : ?>
                <?php foreach ($detail_tryout as $detail) : ?>
                    <tr>
                        <td>
                            <?php if (!empty($detail['problem_image'])) : ?>
                                <img src="<?= base_url('uploads/tryout-details/' . $detail['problem_image']) ?>" class="img-thumbnail" style="max-width: 100px;">
                                <?php endif; ?>
                            <p><?= esc($detail['problem']) ?></p>
                        </td>
                        <td><?= esc($detail['measure']) ?></td>
                        <td><?= esc($detail['pic']) ?></td>
                        <td><?= esc($detail['target']) ?></td>
                        <td><?= esc($detail['progress']) ?></td>
                        <td><?= esc($detail['remarks']) ?></td>
                    </tr>
                <?php endforeach; ?>
            <?php else : ?>
                <tr>
                    <td colspan="5" class="text-center">Tidak ada data tryout</td>
                </tr>
            <?php endif; ?>
        </tbody>
    </table>
    
</div>
<h5 class="mt-4 mb-3"><strong>MEMBER TRIAL</strong></h5>
<div class="card shadow-sm p-3 mb-4">
    <div class="row">
        <div class="col-md-2">
            <label class="font-weight-bold">TOOLING</label>
            <p><?= esc($tryout['tooling']); ?></p>
        </div>
        <div class="col-md-2">
            <label class="font-weight-bold">QUALITY</label>
            <p><?= esc($tryout['quality']); ?></p>
        </div>
        <div class="col-md-2">
            <label class="font-weight-bold">PRODUKSI</label>
            <p><?= esc($tryout['produksi']); ?></p>
        </div>
        <div class="col-md-2">
            <label class="font-weight-bold">PS</label>
            <p><?= esc($tryout['ps']); ?></p>
        </div>
        <div class="col-md-2">
            <label class="font-weight-bold">R&D</label>
            <p><?= esc($tryout['rnd']); ?></p>
        </div>
    </div>
</div>
            <a href="<?= site_url('tryout-jig'); ?>" class="btn btn-secondary">
                <i class="fas fa-arrow-left"></i> Kembali
            </a>
        </div>
    </div>
</div>

<?= $this->endSection() ?>
