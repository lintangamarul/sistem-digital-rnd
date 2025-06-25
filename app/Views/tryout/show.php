<?= $this->extend('layout/template') ?>
<?= $this->section('content') ?>

<div class="pd-ltr-20 xs-pd-20-10">
    <div class="min-height-200px">
        <div class="page-header">
            <div class="row">
                <div class="col-md-6 col-sm-12">
                <div class="title">
                    <h4>Detail <?= esc($tryout['activity']); ?></h4>
                </div>
                    <nav aria-label="breadcrumb" role="navigation">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="<?= site_url('dashboard'); ?>">Home</a></li>
                            <li class="breadcrumb-item"><a href="<?= site_url('tryout'); ?>">Tryout</a></li>
                            <li class="breadcrumb-item active" aria-current="page">Detail Tryout</li>
                        </ol>
                    </nav>
                </div>
            </div>
        </div>

        <h4 class="mt-4 mb-3"><strong>MACHINE PARAMETER</strong></h4>
<div class="card shadow-sm p-3 mb-4">

  <!-- Baris 1 -->
  <div class="row">
    <div class="col-md-3">
      <label class="font-weight-bold">Part No <span class="text-danger">*</span></label>
      <p><?= esc($project['part_no']); ?></p>
    </div>
    <div class="col-md-3">
      <label class="font-weight-bold">OP</label>
      <p><?= esc($project['process']); ?></p>
    </div>
    <div class="col-md-3">
      <label class="font-weight-bold">M/C LINE</label>
      <p><?= esc($tryout['mc_line']); ?></p>
    </div>
    <div class="col-md-3">
      <label class="font-weight-bold">Process</label>
      <p><?= esc($project['proses']); ?></p>
    </div>
  </div>

  <!-- Baris 2 -->
  <div class="row mt-3">
    <div class="col-md-3">
      <label class="font-weight-bold">SLIDE / DH</label>
      <p><?= esc($tryout['slide_dh']); ?></p>
    </div>
    <div class="col-md-3">
      <label class="font-weight-bold">ADAPTOR</label>
      <p><?= esc($tryout['adaptor']); ?></p>
    </div>
    <div class="col-md-3">
      <label class="font-weight-bold">CUSH. PRESS</label>
      <p><?= esc($tryout['cush_press']); ?></p>
    </div>
    <div class="col-md-3">
      <label class="font-weight-bold">CUSH. H.</label>
      <p><?= esc($tryout['cush_h']); ?></p>
    </div>
  </div>

  <!-- Baris 3 -->
  <div class="row mt-3">
    <div class="col-md-3">
      <label class="font-weight-bold">MAIN PRESS</label>
      <p><?= esc($tryout['main_press']); ?></p>
    </div>
    <div class="col-md-3">
      <label class="font-weight-bold">GSPH</label>
      <p><?= esc($tryout['gsph']); ?></p>
    </div>
    <div class="col-md-3">
      <label class="font-weight-bold">BOOLSTER</label>
      <p><?= esc($tryout['boolster']); ?></p>
    </div>
    <div class="col-md-3">
        <label class="font-weight-bold">Projek</label>
        <p><?= esc($tryout['projek']) . ' / ' . esc($tryout['cust']); ?></p>
    </div>

  </div>

  <!-- Baris 4 -->
  <div class="row mt-3">
    <div class="col-md-3">
      <label class="font-weight-bold">SPM</label>
      <p><?= esc($tryout['spm']); ?></p>
    </div>
    <div class="col-md-3">
      <label class="font-weight-bold">Step</label>
      <p><?= esc($tryout['step']); ?></p>
    </div>
    <div class="col-md-3">
      <label class="font-weight-bold">Event</label>
      <p><?= esc($tryout['event']); ?></p>
    </div>
    <div class="col-md-3">
        <label class="font-weight-bold">Spec Material</label>
        <p><?= esc($tryout['material']); ?></p>
    </div>
  </div>

</div>


            <!-- Judul: ADD IMAGE -->
            <h4 class="mt-4 mb-3"><strong>IMAGE RESULT</strong></h4>
            <div class="card shadow-sm p-3 mb-4">
                <div class="row">
                    <!-- Image Part Trial -->
                    <div class="col-md-6">
                        <div class="card text-center shadow-sm border rounded p-3">
                            <label class="font-weight-bold mb-2">Image Part Trial</label>
                            <?php if ($tryout['part_trial_image']): ?>
                                <img src="<?= base_url('uploads/part_trial/' . $tryout['part_trial_image']); ?>" 
                                    alt="Part Trial Image" 
                                    class="img-fluid rounded shadow-sm border" 
                                    style="max-height: 250px; width: 100%; object-fit: contain;">
                            <?php else: ?>
                                <p class="text-muted">No image available</p>
                            <?php endif; ?>
                        </div>
                    </div>

                    <!-- Image Material -->
                    <div class="col-md-6">
                        <div class="card text-center shadow-sm border rounded p-3">
                            <label class="font-weight-bold mb-2">Image Material</label>
                            <?php if ($tryout['material_image']): ?>
                                <img src="<?= base_url('uploads/material/' . $tryout['material_image']); ?>" 
                                    alt="Material Image" 
                                    class="img-fluid rounded shadow-sm border" 
                                    style="max-height: 250px; width: 100%; object-fit: contain;">
                            <?php else: ?>
                                <p class="text-muted">No image available</p>
                            <?php endif; ?>
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
                        <p><?= $tryout['material_pakai']; ?> pcs</p>
                    </div>
                    <div class="col-md-4">
                        <label class="font-weight-bold">Sisa</label>
                        <p><?= $tryout['material_sisa']; ?> pcs</p>
                    </div>
                    <div class="col-md-4">
                        <label class="font-weight-bold">PANEL OK 🔽</label>
                        <p><?= $tryout['panel_ok']; ?> pcs</p>
                    </div>
                </div>
            </div>
            <!-- KUANTITAS PART -->
            <h4 class="mt-4 mb-3"><strong>KUANTITAS PART</strong></h4>
            <div class="card shadow-sm p-3 mb-4">
                <div class="row">
                    <div class="col-md-4">
                        <label class="font-weight-bold">Target</label>
                        <p><?= $tryout['part_target']; ?> pcs</p>
                    </div>
                    <div class="col-md-4">
                        <label class="font-weight-bold">Act</label>
                        <p><?= $tryout['part_act']; ?> pcs</p>
                    </div>
                    <div class="col-md-4">
                        <label class="font-weight-bold">Judge</label>
                        <p><?= $tryout['part_judge']; ?></p>
                    </div>
                </div>

                <div class="row mt-3">
                    <div class="col-md-4">
                        <label class="font-weight-bold">FAT RESULT 🔼</label>
                        <p><?= $tryout['part_up']; ?></p>
                    </div>
                    <div class="col-md-4">
                        <label class="font-weight-bold">STD ⭘</label>
                        <p><?= $tryout['part_std']; ?></p>
                    </div>
                    <div class="col-md-4">
                        <label class="font-weight-bold">FAT RESULT 🔽</label>
                        <p><?= $tryout['part_down']; ?></p>
                    </div>
                    
                </div>
            </div>

            <!-- TRIAL TIME -->
            <h4 class="mt-4 mb-3"><strong>TRIAL TIME</strong></h4>
            <div class="card shadow-sm p-3 mb-4">
                <div class="row">
                    <div class="col-md-4">
                        <label class="font-weight-bold">Tanggal Tryout</label>
                        <p><?= date('d-m-Y', strtotime($tryout['dates'])); ?></p>
                    </div>
                    <div class="col-md-4">
                        <label class="font-weight-bold">Jam</label>
                        <p><?= $tryout['trial_time']; ?></p>
                    </div>
                    <div class="col-md-4">
                        <label class="font-weight-bold">Maker</label>
                        <p>
                            <?= ($tryout['trial_maker'] == 'OTHERS') ? $tryout['trial_maker_manual'] : $tryout['trial_maker']; ?>
                        </p>
                    </div>
                </div>
            </div>

            <!-- KONFIRMASI TRYOUT -->
            <h4 class="mt-4 mb-3"><strong>KONFIRMASI TRYOUT</strong></h4>
            <div class="card shadow-sm p-3 mb-4">
    <div class="row">
        <!-- PRODUKSI -->
        <div class="col-md-6">
            <label class="font-weight-bold">Konfirmasi Produksi</label>
            <p><?= $konfirmasi_produksi['nama'] . (!empty($konfirmasi_produksi['department']) ? ' - ' . $konfirmasi_produksi['department'] : ''); ?></p>
        </div>

        <!-- QC -->
        <div class="col-md-6">
            <label class="font-weight-bold">Konfirmasi QC</label>
            <p><?= $konfirmasi_qc['nama'] . (!empty($konfirmasi_qc['department']) ? ' - ' . $konfirmasi_qc['department'] : ''); ?></p>
        </div>
    </div>

    <div class="row mt-3">
        <!-- TOOLING -->
        <div class="col-md-6">
            <label class="font-weight-bold">Konfirmasi Tooling</label>
            <p><?= $konfirmasi_tooling['nama'] . (!empty($konfirmasi_tooling['department']) ? ' - ' . $konfirmasi_tooling['department'] : ''); ?></p>
        </div>

        <!-- R&D -->
        <div class="col-md-6">
            <label class="font-weight-bold">Konfirmasi R&D</label>
            <p><?= $konfirmasi_rd['nama'] . (!empty($konfirmasi_rd['department']) ? ' - ' . $konfirmasi_rd['department'] : ''); ?></p>
        </div>
    </div>
</div>



            <!-- Sub Bab: PROBLEM & COUNTER MEASURE -->
            <h4 class="mt-4 mb-3"><strong>PROBLEM & COUNTER MEASURE</strong></h4>
            <div class="card shadow-sm p-3 mb-4">
                <?php if (!empty($detail_tryouts)): ?>
                    <table class="table table-bordered">
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
                                                class="img-fluid img-thumbnail" 
                                                style="max-width: 100px;">
                                            <br>
                                        <?php endif; ?>
                                        <?= !empty($detail['problem_text']) ? $detail['problem_text'] : 'No problem description.'; ?>
                                    </td>
                                    <td><?= !empty($detail['counter_measure']) ? $detail['counter_measure'] : '-'; ?></td>
                                    <td><?= !empty($detail['pic']) ? $detail['pic'] : 'No PIC assigned'; ?></td>
                                    <td><?= !empty($detail['target']) ? $detail['target'] : '-'; ?></td>
                                    <td><?= !empty($detail['progress']) ? $detail['progress'] . '%' : '0%'; ?></td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                <?php else: ?>
                    <p>No problems reported.</p>
                <?php endif; ?>
            </div>


            <!-- Tombol Kembali -->
            <div class="form-group row">
                <div class="col-md-12 text-center">
                    <a href="<?= site_url('tryout'); ?>" class="btn btn-secondary px-4"><i class="fas fa-arrow-left"></i> Kembali</a>
                </div>
            </div>
        </div>
    </div>
</div>

<?= $this->endSection() ?>