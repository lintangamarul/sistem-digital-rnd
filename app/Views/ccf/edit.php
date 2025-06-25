<?= $this->extend('layout/template') ?>
<style>
    .inline-inputs input {
        display: inline-block;
        width: 60px;
        margin-right: 4px;
        vertical-align: middle;
    }
    .suggestions-dropdown {
        border: 1px solid #ccc;
        max-height: 250px;
        /* max-width: 20px; */
        overflow-y: auto;
        background: white;
        position: absolute;
        z-index: 999;
        width: 100%;
        display: none;
    }

    .suggestion-item {
        padding: 5px 10px;
        cursor: pointer;
    }

    .suggestion-item:hover {
        background-color: #f0f0f0;
    }

    .step-wizard {
        margin-bottom: 20px;
    }
    .step-wizard .nav-tabs {
        border-bottom: 2px solid #e9ecef;
    }
    .step-wizard .nav-tabs .nav-link {
        color: #6c757d;
        border: none;
        border-radius: 0;
        padding: 10px 20px;
        font-weight: 500;
    }
    .step-wizard .nav-tabs .nav-link.active {
        color: #1b00ff;
        border-bottom: 3px solid #1b00ff;
    }
    .card-step {
        border: none;
        border-radius: 8px;
        box-shadow: 0 2px 10px rgba(0,0,0,0.1);
        margin-bottom: 20px;
        padding: 20px;
        background-color: #fff;
    }
    .btn-step {
        min-width: 120px;
    }
    .segment h4 {
        border-bottom: 2px solid rgb(0, 0, 0);
        padding-bottom: 5px;
        margin-bottom: 15px;
    
    }
input.form-control.has-default-value:not([readonly]) {
    background-color: #e8f4ff !important;
    border-left: 3px solid #4dabf7 !important;
}

input.form-control.no-default-value:not([readonly]) {
    background-color: #fff3e6 !important;
    border-left: 3px solid #fd7e14 !important;
}


    input[readonly] {
        background-color: #e9ecef; 
    }

    input.has-default-value:focus, input.no-default-value:focus {
        background-color: #ffffff; 
        border-color: #80bdff;
        box-shadow: 0 0 0 0.2rem rgba(0, 123, 255, 0.25);
    }
</style>
<?= $this->section('content') ?>

        <div class="page-header">
            <div class="row">
                <div class="col-md-6 col-sm-12">
                    <div class="title">
                        <h4>Edit CCF</h4>
                    </div>
                    <nav aria-label="breadcrumb" role="navigation">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item">
                                <a href="<?= site_url('actual-activity/personal'); ?>">Home</a>
                            </li>
                            <li class="breadcrumb-item"><a href="<?= site_url('ccf'); ?>">CCF</a></li>
                            <li class="breadcrumb-item active" aria-current="page">
                                Form Edit CCF
                            </li>
                        </ol>
                    </nav>
                </div>
            </div>
        </div>

        <div class="pd-ltr-20 xs-pd-20-10">
            <div class="min-height-200px">
                <div class="card card-step ">
                    <h2 class="mt-3 text-center mb-3">CCF Data Form </h2>
                    
                    <ul class="nav nav-tabs step-wizard justify-content-center" id="stepWizard" role="tablist">
                        <li class="nav-item">
                            <a class="nav-link active" id="overview-tab" data-toggle="tab" href="#step1" role="tab">Overview</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" id="design-tab" data-toggle="tab" href="#step2" role="tab">Design & Program</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" id="mainmat-tab" data-toggle="tab" href="#step4" role="tab">Main Material</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" id="stdpart-tab" data-toggle="tab" href="#step5" role="tab">Standard Part</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" id="manufactur-tab" data-toggle="tab" href="#step6" role="tab">Manufacturing</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" id="finishing-tab" data-toggle="tab" href="#step7" role="tab">Finishing</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" id="hardening-tab" data-toggle="tab" href="#step8" role="tab">Hardening</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" id="trial-tab" data-toggle="tab" href="#step9" role="tab">Die Spot & Try</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" id="toolcost-tab" data-toggle="tab" href="#step10" role="tab">Tool Cost</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" id="aksesoris-tab" data-toggle="tab" href="#step11" role="tab">Aksesoris</a>
                        </li>
                    </ul>
                    <?php if (session()->getFlashdata('success')): ?>
                        <div class="alert alert-success"><?= session()->getFlashdata('success'); ?></div>
                    <?php endif; ?>
                    <?php if (session()->getFlashdata('error')): ?>
                        <div class="alert alert-danger"><?= session()->getFlashdata('error'); ?></div>
                    <?php endif; ?>

                    <form action="<?= site_url('ccf/update/' . $ccf['id']); ?>" method="post" enctype="multipart/form-data" id="dcpForm" class="mr-3 ml-3 mt-3 mb-3" novalidate>
             
                        <div class="tab-content" id="stepWizardContent">
                            <div class="mb-2">
                                <small><strong>Keterangan Warna:</strong></small>
                                <div class="d-flex align-items-center gap-3 mt-1">
                                    <div>
                                        <div style="width: 20px; height: 20px; background-color: #e8f4ff; border-left: 3px solid #4dabf7; display: inline-block; vertical-align: middle; margin-right: 5px;"></div>
                                        <small>Input biru = Sudah terisi (perlu pengecekan)</small>
                                    </div>
                                    <div>
                                        <div class="ml-3"style="width: 20px; height: 20px; background-color: #fff3e6; border-left: 3px solid #fd7e14; display: inline-block; vertical-align: middle; margin-right: 5px;"></div>
                                        <small>Input oranye = Masih kosong (harus diisi)</small>
                                    </div>
                                </div>
                            </div>

                            <!-- Step 1: Overview -->
                            <div class="tab-pane fade show active" id="step1" role="tabpanel">
                                <div class="segment">
                                    <h4>Segment Overview</h4>
                                    <div class="row">
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label>Part No</label>
                                               
                                                <input type="text" id="part_no" class="form-control" name="part_no" value="<?= $ccf['part_no'] ?>" readonly>
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label>CF Process</label>
                                                <select class="custom-select2 form-control" name="cf_process" id="cf_process">
                                                    <option value="">-- Pilih CF Process --</option>
                                                    <option value="CF Single" <?= ($ccf['cf_process'] == 'CF Single') ? 'selected' : '' ?>>CF Single</option>
                                                    <option value="CF Assy" <?= ($ccf['cf_process'] == 'CF Assy') ? 'selected' : '' ?>>CF Assy</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label>CF Dimension (L × W × H)</label>
                                                <div class="d-flex gap-1">
                                                    <?php 
                                                        $dimensions = explode('x', $ccf['cf_dimension']);
                                                        $cf_length = $dimensions[0] ?? '';
                                                        $cf_width = $dimensions[1] ?? '';
                                                        $cf_height = $dimensions[2] ?? '';
                                                    ?>
                                                    <input type="number" step="any" class="form-control" name="cf_length" value="<?= $cf_length ?>">
                                                    <input type="number" step="any" class="form-control" name="cf_width" value="<?= $cf_width ?>">
                                                    <input type="number" step="any" class="form-control" name="cf_height" value="<?= $cf_height ?>">
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label>Part Name</label>
                                                <input type="text" class="form-control" name="part_name" id="part_name" value="<?= $ccf['part_name'] ?>" readonly>
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label>Customer</label>
                                                <input type="text" class="form-control" name="cust" id="cust" value="<?= $ccf['customer'] ?>" readonly>
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label>Model</label>
                                                <input type="text" class="form-control" name="model" id="model" value="<?= $ccf['model'] ?>" readonly>
                                            </div>
                                        </div>
                                       
                                    </div>

                                    <div class="row">
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label>Weight</label>
                                                <input type="text" class="form-control" name="cf_weight" value="<?= $ccf['weight'] ?>">
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label>Class</label>
                                                <select class="custom-select2 form-control text-uppercase" name="class" id="classSelect" onchange="updateUkuranPart()">
                                                    <option value="">-- PILIH CLASS --</option>
                                                    <?php 
                                                    $classes = [
                                                        'A SIMPLE', 'A SULIT', 
                                                        'B SIMPLE', 'B SULIT',
                                                        'C SIMPLE', 'C SULIT',
                                                        'D SIMPLE', 'D SULIT'
                                                    ];
                                                    foreach($classes as $class): ?>
                                                    <option value="<?= $class ?>" <?= ($class == $ccf['class']) ? 'selected' : '' ?>><?= $class ?></option>
                                                    <?php endforeach; ?>
                                                </select>
                                            </div>
                                        </div>
                                        <!-- <div class="col-md-4">
                                            <div class="form-group">
                                                <label>Ukuran Part</label>
                                                <input type="text" class="form-control" name="ukuran_part" id="ukuranPart" value="<?= $ccf['ukuran_part'] ?>" readonly>
                                            </div>
                                        </div> -->
                                    </div>

                                    <div class="row">
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label>Sketch (Upload Gambar)</label>
                                                <input type="file" class="form-control-file" name="sketch" id="sketchInput" accept=".png,.jpg,.jpeg">
                                                <?php if($ccf['sketch']): ?>
                                                    <div class="mt-2">
                                                        <img src="<?= base_url('uploads/ccf/' . $ccf['sketch']) ?>" alt="Current Sketch" style="max-width: 200px;" class="img-thumbnail">
                                                        <input type="hidden" name="existing_sketch" value="<?= $ccf['sketch'] ?>">
                                                    </div>
                                                <?php endif; ?>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="text-right">
                                        <button type="button" class="btn btn-step btn-primary next-step">Next</button>
                                    </div>
                                </div>
                            </div>

                            <!-- Step 2: Design & Program -->
                            <div class="tab-pane fade" id="step2" role="tabpanel">
                                <div class="segment">
                                    <h4>Segment Design & Program</h4>
                                    <div class="table-responsive">
                                        <table class="table table-bordered table-input" id="designProgramTable">
                                            <thead class="text-center">
                                                <tr>
                                                    <th>No</th>
                                                    <th>Process</th>
                                                    <th>Man Power</th>
                                                    <th>Working Time (hrs)</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <tr>
                                                    <td class="row-number">1</td>
                                                    <td>
                                                        <input type="text" class="form-control" value="Designing" readonly>
                                                    </td>
                                                    <td><input type="number" name="design_man_power" class="form-control" value="<?= $designProgram['design_man_power'] ?? '' ?>"></td>
                                                    <td><input type="number" name="design_working_time" class="form-control" value="<?= $designProgram['design_working_time'] ?? '' ?>"></td>
                                                </tr>
                                                <tr>
                                                    <td class="row-number">2</td>
                                                    <td>
                                                        <input type="text" class="form-control" value="Programming" readonly>
                                                    </td>
                                                    <td><input type="number" name="prog_man_power" class="form-control" value="<?= $designProgram['prog_man_power'] ?? 1 ?>"></td>
                                                    <td><input type="number" name="prog_working_time" class="form-control" value="<?= $designProgram['prog_working_time'] ?? '' ?>"></td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                    <div class="d-flex justify-content-between mt-3">
                                        <button type="button" class="btn btn-step btn-secondary prev-step">Previous</button>
                                        <button type="button" class="btn btn-step btn-primary next-step">Next</button>
                                    </div>
                                </div>
                            </div>

                            <!-- Step 4: Main Material -->
                            <div class="tab-pane fade" id="step4" role="tabpanel">
                                <div class="segment">
                                    <h4>Segment Main Material</h4>
                                    <div class="table-responsive">
                                        <table class="table table-bordered table-input" id="mainMaterialTable">
                                            <thead class="text-center">
                                                <tr>
                                                    <th>No</th>
                                                    <th>Part List</th>
                                                    <th>Material / Spec</th>
                                                    <th>Size / Type</th>
                                                    <th>Qty (PCS)</th>
                                                    <th>Weight (KG)</th>
                                                    <th>Aksi</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php 
                                                    // Kelompokkan berdasarkan kategori
                                                    $groupedMaterials = [];
                                                    foreach ($mainMaterials as $row) {
                                                        $category = $row['mm_category'] ?: 'LAINNYA';
                                                        $groupedMaterials[$category][] = $row;
                                                    }

                                                    $no = 1;
                                                    foreach ($groupedMaterials as $category => $materials):
                                                ?>
                                                    <!-- Baris kategori -->
                                                    <tr style="background-color: #f5f5f5;">
                                                        <td class="text-center font-weight-bold"><?= $no++ ?></td>
                                                        <td colspan="6"><strong><?= strtoupper($category) ?></strong></td>
                                                    </tr>

                                                    <!-- Baris data -->
                                                    <?php foreach ($materials as $material): ?>
                                                        <tr>
                                                            <td></td>
                                                            <td style="position: relative;">
                                                                <input type="text" name="mm_part_list[]" class="form-control" value="<?= esc($material['mm_part_list']) ?>">
                                                            </td>
                                                            <td style="position: relative;">
                                                                <input type="text" name="mm_material_spec[]" class="form-control" value="<?= esc($material['mm_material_spec']) ?>">
                                                            </td>
                                                            <td>
                                                                <div class="d-flex gap-1">
                                                                    <input type="text" name="mm_size_type_l[]" class="form-control form-control-sm" value="<?= esc($material['mm_size_type_l']) ?>">
                                                                    <input type="text" name="mm_size_type_w[]" class="form-control form-control-sm" value="<?= esc($material['mm_size_type_w']) ?>">
                                                                    <input type="text" name="mm_size_type_h[]" class="form-control form-control-sm" value="<?= esc($material['mm_size_type_h']) ?>">
                                                                </div>
                                                            </td>
                                                            <td><input type="number" name="mm_qty[]" class="form-control" value="<?= esc($material['mm_qty']) ?>"></td>
                                                            <td><input type="number" name="mm_weight[]" class="form-control" value="<?= esc($material['mm_weight']) ?>"></td>
                                                            <td><button type="button" class="btn btn-danger btn-sm removeRow">Hapus</button></td>
                                                        </tr>
                                                    <?php endforeach; ?>
                                                <?php endforeach; ?>
                                            </tbody>
                                        </table>
                                    </div>
                                    <button type="button" id="addMainMaterial" class="btn btn-primary btn-sm mb-3">Tambah Baris</button>
                                    <div class="d-flex justify-content-between">
                                        <button type="button" class="btn btn-step btn-secondary prev-step">Previous</button>
                                        <button type="button" class="btn btn-step btn-primary next-step">Next</button>
                                    </div>
                                </div>
                            </div>
                            <!-- Step 5: Standard Part -->
                            <div class="tab-pane fade" id="step5" role="tabpanel">
                                <div class="segment">
                                    <h4>Segment Standard Part</h4>
                                    <div class="table-responsive">
                                      <table class="table table-bordered table-input" id="standardPartTable">
                                        <thead class="text-center">
                                            <tr>
                                                <th>No</th>
                                                <th>Part List</th>
                                                <th>Material / Spec</th>
                                                <th>Size / Type</th>
                                                <th>Qty (PCS)</th>
                                                <th>Aksi</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php if (!empty($standardParts)): ?>
                                                <?php 
                                                    // Kelompokkan berdasarkan sp_category
                                                    $groupedParts = [];
                                                    foreach ($standardParts as $part) {
                                                        $groupedParts[$part['sp_category']][] = $part;
                                                    }

                                                    $no = 1;
                                                    foreach ($groupedParts as $category => $items):
                                                ?>
                                                    <!-- Baris kategori -->
                                                    <tr style="background-color: #f5f5f5;">
                                                        <td class="text-center font-weight-bold"><?= $no++ ?></td>
                                                        <td colspan="5"><strong><?= strtoupper($category) ?></strong></td>
                                                    </tr>

                                                    <!-- Baris item -->
                                                    <?php foreach ($items as $item): ?>
                                                        <tr>
                                                            <td></td>
                                                            <td style="position: relative;">
                                                                <input type="text" name="sp_part_list[]" class="form-control" value="<?= esc($item['sp_part_list']) ?>">
                                                            </td>
                                                            <td style="position: relative;">
                                                                <input type="text" name="sp_material_spec[]" class="form-control" value="<?= esc($item['sp_material_spec']) ?>">
                                                            </td>
                                                            <td>
                                                                <input type="text" name="sp_size_type[]" class="form-control" value="<?= esc($item['sp_size_type']) ?>">
                                                            </td>
                                                            <td>
                                                                <input type="number" name="sp_qty[]" class="form-control" value="<?= esc($item['sp_qty']) ?>">
                                                            </td>
                                                            <td>
                                                                <button type="button" class="btn btn-danger btn-sm removeRow">Hapus</button>
                                                            </td>
                                                        </tr>
                                                    <?php endforeach; ?>
                                                <?php endforeach; ?>
                                            <?php else: ?>
                                                <tr><td colspan="6" class="text-center">Data tidak tersedia</td></tr>
                                            <?php endif; ?>
                                        </tbody>
                                    </table>

                                    </div>
                                    <button type="button" id="addStandardPart" class="btn btn-primary btn-sm mb-3">Tambah Baris</button>
                                    <div class="d-flex justify-content-between">
                                        <button type="button" class="btn btn-step btn-secondary prev-step">Previous</button>
                                        <button type="button" class="btn btn-step btn-primary next-step">Next</button>
                                    </div>
                                </div>
                            </div>

                            <!-- Step 6: Machining -->
                            <div class="tab-pane fade" id="step6" role="tabpanel">
                                <div class="segment">
                                    <h4>Segment Manufacturing</h4>
                                    <div class="table-responsive">
                                        <table class="table table-bordered table-input" id="machiningTable1">
                                            <thead class="text-center">
                                                <tr>
                                                    <th>No</th>
                                                    <th>Process</th>
                                                    <th>Man Power</th>
                                                    <th>Working Time (H)</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php foreach ($machinings as $index => $machining): ?>
                                                <tr>
                                                    <td class="row-number"><?= $index + 1 ?></td>
                                                    <td>
                                                        <input type="text" name="machining_process[]" class="form-control" value="<?= esc($machining['machining_process']) ?>" readonly>
                                                    </td>
                                                    <td><input type="number" name="machining_man_power[]" class="form-control" value="<?= esc($machining['machining_man_power']) ?>"></td>
                                                    <td><input type="number" name="machining_working_time[]" class="form-control" value="<?= esc($machining['machining_working_time']) ?>"></td>
                                                </tr>
                                                <?php endforeach; ?>
                                            </tbody>
                                        </table>
                                        <table class="table table-bordered table-input" id="machiningTable2">
                                            <thead class="text-center">
                                                <tr>
                                                    <th>No</th>
                                                    <th>Process</th>
                                                    <th>Kind of Machine</th>
                                                    <th>Lead Time</th>
                                                    <!-- <th>Satuan (H)</th> -->
                                                    <!-- <th>Price / H</th>
                                                    <th>Cost</th> -->
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php foreach ($machinings2 as $index => $mach): ?>
                                                    <tr>
                                                        <td class="row-number"><?= $index + 1 ?></td>
                                                        <td>
                                                            <input type="text" name="machining_proc[]" class="form-control" value="<?= esc($mach['machining_proc']) ?>" readonly>
                                                        </td>
                                                        <td>
                                                            <input type="text" name="machining_kom[]" class="form-control" value="<?= esc($mach['machining_kom']) ?>" readonly>
                                                        </td>
                                                        <td>
                                                            <input type="number" step="0.01" name="machining_lead_time[]" class="form-control" value="<?= esc($mach['machining_lead_time']) ?>">
                                                        </td>
                                                    </tr>
                                                <?php endforeach; ?>
                                            </tbody>


                                        </table>
                                    </div>
                                    <div class="d-flex justify-content-between">
                                        <button type="button" class="btn btn-step btn-secondary prev-step">Previous</button>
                                        <button type="button" class="btn btn-step btn-primary next-step">Next</button>
                                    </div>
                                </div>
                            </div>

                            <!-- Step 7: Finishing -->
                            <div class="tab-pane fade" id="step7" role="tabpanel">
                                <div class="segment">
                                    <h4>Segment Finishing</h4>
                                    <div class="table-responsive">
                                        <table class="table table-bordered table-input" id="finishingTable1">
                                            <thead class="text-center">
                                                <tr>
                                                    <th>No</th>
                                                    <th>Part List</th>
                                                    <th>Material / Spec</th>
                                                    <th>Size / Type</th>
                                                    <th>Qty</th>
                                                    <th>Aksi</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php foreach ($finishings as $index => $finishing): ?>
                                                <tr>
                                                    <td class="row-number"><?= $index + 1 ?></td>
                                                    <td><input type="text" name="finishing_part_list[]" class="form-control" value="<?= esc($finishing['finishing_part_list']) ?>"></td>
                                                    <td><input type="text" name="finishing_material_spec[]" class="form-control" value="<?= esc($finishing['finishing_material_spec']) ?>"></td>
                                                    <td><input type="text" name="finishing_size_type[]" class="form-control" value="<?= esc($finishing['finishing_size_type']) ?>"></td>
                                                    <td><input type="number" name="finishing_qty[]" class="form-control" value="<?= esc($finishing['finishing_qty']) ?>"></td>
                                                    <td><button type="button" class="btn btn-danger btn-sm removeRow">Hapus</button></td>
                                                </tr>
                                                <?php endforeach; ?>
                                            </tbody>
                                        </table>
                                        <!-- Finishing Table 2 -->
                                        <table class="table table-bordered table-input" id="finishingTable2">
                                            <thead class="text-center"> 
                                                <tr>
                                                    <th>No</th>
                                                    <th>Process</th>
                                                    <th>Kind of Machine</th>
                                                    <th>Lead Time</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php foreach ($finishings2 as $index => $fin2): ?>
                                                <tr>
                                                    <td class="row-number"><?= $index + 1 ?></td>
                                                    <td><input type="text" name="finishing_process[]" class="form-control" value="<?= esc($fin2['finishing_process']) ?>"></td>
                                                    <td><input type="text" name="finishing_kom[]" class="form-control" value="<?= esc($fin2['finishing_kom']) ?>"></td>
                                                    <td><input type="number" name="finishing_lead_time[]" class="form-control" value="<?= esc($fin2['finishing_lead_time']) ?>"></td>
                                                </tr>
                                                <?php endforeach; ?>
                                            </tbody>
                                        </table>
                                        <button type="button" id="addRowFinishing" class="btn btn-primary btn-sm mb-3">Tambah Baris</button>
                                  


                                        <!-- Finishing Table 3 -->
                                        <table class="table table-bordered table-input" id="finishingTable3">
                                            <thead>
                                                <tr>
                                                    <th>No</th>
                                                    <th>Process</th>
                                                    <th>Man Power</th>
                                                    <th>Working Time (Hrs)</th>
                                                    <th>Aksi</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php foreach ($finishings3 as $index => $fin3): ?>
                                                <tr>
                                                    <td class="row-number"><?= $index + 1 ?></td>
                                                    <td><input type="text" name="finishing_process[]" class="form-control" value="<?= esc($fin3['finishing_process']) ?>"></td>
                                                    <td><input type="number" name="finishing_mp[]" class="form-control" value="<?= esc($fin3['finishing_mp']) ?>"></td>
                                                    <td><input type="number" step="0.01" name="finishing_working_time[]" class="form-control" value="<?= esc($fin3['finishing_working_time']) ?>"></td>
                                                    <td><button type="button" class="btn btn-danger btn-sm removeRow">Hapus</button></td>
                                                </tr>
                                                <?php endforeach; ?>
                                            </tbody>
                                        </table>

                                    </div>
                                    <div class="d-flex justify-content-between">
                                        <button type="button" class="btn btn-step btn-secondary prev-step">Previous</button>
                                        <button type="button" class="btn btn-step btn-primary next-step">Next</button>
                                    </div>
                                </div>
                            </div>

                            <!-- Step 8: Heat Treatment -->
                            <div class="tab-pane fade" id="step8" role="tabpanel">
                                <div class="segment">
                                    <h4>Segment Hardening</h4>
                                    <div class="table-responsive">
                                        <table class="table table-bordered table-input" id="harderningTable">
                                            <thead class="text-center">
                                                <tr>
                                                    <th>No</th>
                                                    <th>Process</th>
                                                    <th>Kind of Machine</th>
                                                    <th>Weight (KG)</th>
                                                    <th>Aksi</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php foreach ($heatTreatments as $index => $heat): ?>
                                                <tr>
                                                    <td class="row-number"><?= $index + 1 ?></td>
                                                    <td><input type="text" name="heat_process[]" class="form-control" value="<?= esc($heat['heat_process']) ?>" ></td>
                                                    <td><input type="text" name="heat_machine[]" class="form-control" value="<?= esc($heat['heat_machine']) ?>"></td>
                                                    <td><input type="number" name="heat_weight[]" class="form-control" value="<?= esc($heat['heat_weight']) ?>"></td>
                                                    <td><button type="button" class="btn btn-danger btn-sm removeRow">Hapus</button></td>
                                                </tr>
                                                <?php endforeach; ?>
                                            </tbody>
                                        </table>
                                    </div>
                                    <button type="button" id="addRowHarderning" class="btn btn-primary btn-sm mt-2">Tambah Baris</button>
                                    <div class="d-flex justify-content-between mt-3">
                                        <button type="button" class="btn btn-step btn-secondary prev-step">Previous</button>
                                        <button type="button" class="btn btn-step btn-primary next-step">Next</button>
                                    </div>
                                </div>
                            </div>

                            <!-- Step 9: Die Spot & Try -->
                            <div class="tab-pane fade" id="step9" role="tabpanel">
                                <div class="segment">
                                    <h4>Segment Trial Process</h4>
                                    <div class="table-responsive">
                                        <table class="table table-bordered table-input" id="dieSpotTable1">
                                            <thead class="text-center">
                                                <tr>
                                                    <th>A</th>
                                                    <th>Part List</th>
                                                    <th>Material / Spec</th>
                                                    <th>Qty (PCS)</th>
                                                    <th>Weight (KG)</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php foreach ($dieSpot1 as $index => $die): ?>
                                                <tr>
                                                    <td class="row-number"><?= $index + 1 ?></td>
                                                    <td><input type="text" name="die_spot_part_list[]" class="form-control" value="<?= esc($die['die_spot_part_list']) ?>" ></td>
                                                    <td><input type="text" name="die_spot_material[]" class="form-control" value="<?= esc($die['die_spot_material']) ?>"></td>
                                                    <td><input type="number" name="die_spot_qty[]" class="form-control" value="<?= esc($die['die_spot_qty']) ?>"></td>
                                                    <td><input type="number" name="die_spot_weight[]" class="form-control" value="<?= esc($die['die_spot_weight']) ?>"></td>
                                                </tr>
                                                <?php endforeach; ?>
                                            </tbody>
                                        </table>
                                        
                                    </div>
                                    <!-- Tabel B -->
                                    <div class="table-responsive mt-4">
                                        <table class="table table-bordered table-input" id="dieSpotTable2">
                                            <thead class="text-center">
                                                <tr>
                                                    <th>B</th>
                                                    <th>Process</th>
                                                    <th>Kind of Machine</th>
                                                    <th>Lead Time</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php foreach($dieSpot2 as $index => $row): ?>
                                                <tr>
                                                    <td class="row-number"><?= $index + 1 ?></td>
                                                    <td>
                                                        <input type="text" class="form-control" name="die_spot_process2[]" value="<?= esc($row['die_spot_process']) ?>">
                                                    </td>
                                                    <td>
                                                        <input type="text" class="form-control" name="die_spot_kom[]" value="<?= esc($row['die_spot_kom']) ?>">
                                                    </td>
                                                    <td>
                                                        <input type="number" name="die_spot_lead_time[]" class="form-control" value="<?= esc($row['die_spot_lead_time']) ?>">
                                                    </td>
                                                </tr>
                                                <?php endforeach; ?>
                                            </tbody>
                                        </table>
                                    </div>
                                    <!-- Tabel C -->
                                    <div class="table-responsive mt-4">
                                        <table class="table table-bordered table-input" id="dieSpotTable3">
                                            <thead class="text-center">
                                                <tr>
                                                    <th>C</th>
                                                    <th>Process</th>
                                                    <th>Man Power</th>
                                                    <th>Working Time (H)</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php foreach ($dieSpot3 as $index => $row): ?>
                                                <tr>
                                                    <td class="row-number"><?= $index + 1 ?></td>
                                                    <td>
                                                        <input type="text" name="die_spot_process3[]" class="form-control" value="<?= esc($row['die_spot_process']) ?>">
                                                    </td>
                                                    <td>
                                                        <input type="number" name="die_spot_mp[]" class="form-control" value="<?= esc($row['die_spot_mp']) ?>">
                                                    </td>
                                                    <td>
                                                        <input type="number" name="die_spot_working_time[]" class="form-control" value="<?= esc($row['die_spot_working_time']) ?>">
                                                    </td>
                                                </tr>
                                                <?php endforeach; ?>
                                            </tbody>
                                        </table>
                                    </div>

                                    <div class="d-flex justify-content-between">
                                        <button type="button" class="btn btn-step btn-secondary prev-step">Previous</button>
                                        <button type="button" class="btn btn-step btn-primary next-step">Next</button>
                                    </div>
                                </div>
                            </div>

                            <!-- Step 10: Tool Cost -->
                            <div class="tab-pane fade" id="step10" role="tabpanel">
                                <div class="segment">
                                    <h4>Segment Tool Cost</h4>
                                    <div class="table-responsive">
                                        <table class="table table-bordered table-input" id="toolCostTable">
                                            <thead class="text-center">
                                                <tr>
                                                    <th>No</th>
                                                    <th>Process</th>
                                                    <th>Kinds of Tool</th>
                                                    <th>Spec</th>
                                                    <th>Qty (PCS)</th>
                                                    <th>Aksi</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php foreach ($toolCosts as $index => $tool): ?>
                                                <tr>
                                                    <td class="row-number"><?= $index + 1 ?></td>
                                                    <td><input type="text" name="tool_cost_process[]" class="form-control" value="<?= esc($tool['tool_cost_process']) ?>"></td>
                                                    <td><input type="text" name="tool_cost_tool[]" class="form-control" value="<?= esc($tool['tool_cost_tool']) ?>"></td>
                                                    <td><input type="text" name="tool_cost_spec[]" class="form-control" value="<?= esc($tool['tool_cost_spec']) ?>"></td>
                                                    <td><input type="number" name="tool_cost_qty[]" class="form-control" value="<?= esc($tool['tool_cost_qty']) ?>"></td>
                                                    <td><button type="button" class="btn btn-danger btn-sm removeRow">Hapus</button></td>
                                                </tr>
                                                <?php endforeach; ?>
                                            </tbody>
                                        </table>
                                    </div>
                                    <button type="button" id="addToolCost" class="btn btn-primary btn-sm mb-3">Tambah Baris</button>
                                    <div class="d-flex justify-content-between">
                                        <button type="button" class="btn btn-step btn-secondary prev-step">Previous</button>
                                        <button type="button" class="btn btn-step btn-primary next-step">Next</button>
                                    </div>
                                </div>
                            </div>

                            <!-- Step 11: Aksesoris -->
                            <div class="tab-pane fade" id="step11" role="tabpanel">
                                <div class="segment">
                                    <h4>Segment Aksesoris</h4>
                                    <div class="table-responsive">
                                        <table class="table table-bordered table-input" id="aksesorisTable">
                                            <thead class="text-center">
                                                <tr>
                                                    <th>No</th>
                                                    <th>Part List</th>
                                                    <th>Specification</th>
                                                    <th>Qty (PCS)</th>
                                                    <th>Aksi</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php foreach ($aksesoris as $index => $akses): ?>
                                                <tr>
                                                    <td class="row-number"><?= $index + 1 ?></td>
                                                    <td><input type="text" name="aksesoris_part_list[]" class="form-control" value="<?= esc($akses['aksesoris_part_list']) ?>"></td>
                                                    <td><input type="text" name="aksesoris_spec[]" class="form-control" value="<?= esc($akses['aksesoris_spec']) ?>"></td>
                                                    <td><input type="number" name="aksesoris_qty[]" class="form-control" value="<?= esc($akses['aksesoris_qty']) ?>"></td>
                                                    <td><button type="button" class="btn btn-danger btn-sm removeRow">Hapus</button></td>
                                                </tr>
                                                <?php endforeach; ?>
                                            </tbody>
                                        </table>
                                    </div>
                                    <button type="button" id="addAksesoris" class="btn btn-primary btn-sm mb-3">Tambah Baris</button>
                                    <div class="d-flex justify-content-between">
                                        <button type="button" class="btn btn-step btn-secondary prev-step">Previous</button>
                                        <button type="submit" class="btn btn-step btn-success">Update Data CCF</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
        <script>
document.addEventListener("DOMContentLoaded", function () {
    const inputs = document.querySelectorAll('input[type="text"], input[type="number"]');

    function updateInputStyle(input) {
        if (input.readOnly) return;

        if (input.value.trim() !== "") {
            input.style.backgroundColor = '#e8f4ff'; // biru muda
            input.style.borderLeft = '3px solid #4dabf7';
        } else {
            input.style.backgroundColor = '#fff3e6'; // oranye muda
            input.style.borderLeft = '3px solid #fd7e14';
        }
    }

    inputs.forEach(input => {
        updateInputStyle(input);

        input.addEventListener("input", function () {
            updateInputStyle(this);
        });
    });
});
</script>


        <script>
            $(document).ready(function() {
                $('#part_no_select').select2();
                $('#part_no_select').on('change', function() {
                    let opt = $(this).find('option:selected');
                    $('#cust').val(opt.data('customer'));
                    $('#model').val(opt.data('model'));
                    $('#part_no').val(opt.data('part_no'));
                    $('#part_name').val(opt.data('part_name'));
                });

                function updateRowNumbers(tableId) {
                    $("#" + tableId + " tbody tr").each(function(index){
                        $(this).find(".row-number").text(index + 1);
                    });
                }

                $(document).on('click', '.removeRow', function(){
                    var $table = $(this).closest('table');
                    $(this).closest('tr').remove();
                    updateRowNumbers($table.attr('id'));
                });

                // Tambah baris untuk semua tabel
                $('#addMainMaterial').click(function(){
                    var row = `<tr>
                        <td class="row-number"></td>
                        <td><input type="text" name="mm_part_list[]" class="form-control"></td>
                        <td><input type="text" name="mm_material_spec[]" class="form-control"></td>
                        <td>
                            <div class="d-flex gap-1">
                                <input type="number" name="mm_size_type_l[]" class="form-control form-control-sm">
                                <input type="number" name="mm_size_type_w[]" class="form-control form-control-sm">
                                <input type="number" name="mm_size_type_h[]" class="form-control form-control-sm">
                            </div>
                        </td>
                        <td><input type="number" name="mm_qty[]" class="form-control"></td>
                        <td><input type="number" name="mm_weight[]" class="form-control"></td>
                        <td><button type="button" class="btn btn-danger btn-sm removeRow">Hapus</button></td>
                    </tr>`;
                    $('#mainMaterialTable tbody').append(row);
                    updateRowNumbers('mainMaterialTable');
                });

                $('#addStandardPart').click(function(){
                    var row = `<tr>
                        <td class="row-number"></td>
                        <td><input type="text" name="sp_part_list[]" class="form-control"></td>
                        <td><input type="text" name="sp_material_spec[]" class="form-control"></td>
                        <td><input type="text" name="sp_size_type[]" class="form-control"></td>
                        <td><input type="number" name="sp_qty[]" class="form-control"></td>
                        <td><button type="button" class="btn btn-danger btn-sm removeRow">Hapus</button></td>
                    </tr>`;
                    $('#standardPartTable tbody').append(row);
                    updateRowNumbers('standardPartTable');
                });

                $('#addRowFinishing').click(function(){
                    var row = `<tr>
                        <td class="row-number"></td>
                        <td><input type="text" name="finishing_part_list[]" class="form-control"></td>
                        <td><input type="text" name="finishing_material_spec[]" class="form-control"></td>
                        <td><input type="text" name="finishing_size_type[]" class="form-control"></td>
                        <td><input type="number" name="finishing_qty[]" class="form-control"></td>
                        <td><button type="button" class="btn btn-danger btn-sm removeRow">Hapus</button></td>
                    </tr>`;
                    $('#finishingTable1 tbody').append(row);
                    updateRowNumbers('finishingTable1');
                });

                $('#addRowHarderning').click(function(){
                    var row = `<tr>
                        <td class="row-number"></td>
                        <td><input type="text" name="heat_process[]" class="form-control" value="Harderning" readonly></td>
                        <td><input type="text" name="heat_machine[]" class="form-control"></td>
                        <td><input type="number" name="heat_weight[]" class="form-control"></td>
                        <td><button type="button" class="btn btn-danger btn-sm removeRow">Hapus</button></td>
                    </tr>`;
                    $('#harderningTable tbody').append(row);
                    updateRowNumbers('harderningTable');
                });

                $('#addToolCost').click(function(){
                    var row = `<tr>
                        <td class="row-number"></td>
                        <td><input type="text" name="tool_cost_process[]" class="form-control"></td>
                        <td><input type="text" name="tool_cost_tool[]" class="form-control"></td>
                        <td><input type="text" name="tool_cost_spec[]" class="form-control"></td>
                        <td><input type="number" name="tool_cost_qty[]" class="form-control"></td>
                        <td><button type="button" class="btn btn-danger btn-sm removeRow">Hapus</button></td>
                    </tr>`;
                    $('#toolCostTable tbody').append(row);
                    updateRowNumbers('toolCostTable');
                });

                $('#addAksesoris').click(function(){
                    var row = `<tr>
                        <td class="row-number"></td>
                        <td><input type="text" name="aksesoris_part_list[]" class="form-control"></td>
                        <td><input type="text" name="aksesoris_spec[]" class="form-control"></td>
                        <td><input type="number" name="aksesoris_qty[]" class="form-control"></td>
                        <td><button type="button" class="btn btn-danger btn-sm removeRow">Hapus</button></td>
                    </tr>`;
                    $('#aksesorisTable tbody').append(row);
                    updateRowNumbers('aksesorisTable');
                });

                // Navigasi Step
                $('.next-step').click(function(){
                    var $activeTab = $('#stepWizard .nav-link.active');
                    var $nextTab = $activeTab.parent().next('li').find('.nav-link');
                    if($nextTab.length) $nextTab.trigger('click');
                });

                $('.prev-step').click(function(){
                    var $activeTab = $('#stepWizard .nav-link.active');
                    var $prevTab = $activeTab.parent().prev('li').find('.nav-link');
                    if($prevTab.length) $prevTab.trigger('click');
                });
            });

            function updateUkuranPart() {
                const cls = document.getElementById('classSelect').value;
                if (!cls) return;

                fetch('/ccf/lead-time/' + encodeURIComponent(cls))
                    .then(r => r.json())
                    .then(data => {
                        document.querySelector("input[name='design_working_time']").value = data.designing ?? '';
                        document.querySelectorAll("input[name='finishing_lead_time[]']").forEach(i=> i.value = data.finishing ?? '');
                        document.querySelectorAll("input[name='finishing_working_time[]']").forEach(i=> i.value = data.finishing ?? '');
                    });
            }

            
            function updateUkuranPart() {
                const cls = document.getElementById('classSelect').value;
                if (!cls) return;
                const baseUrl = "<?= base_url() ?>";
                fetch(baseUrl + '/ccf/lead-time/' + encodeURIComponent(cls))
                    .then(r => r.json())
                    .then(data => {
                        // Designing
                        document.querySelector("input[name='design_working_time']").value = data.designing?.hour ?? '';
                        // document.querySelector("input[name='design_cost_time']").value = data.designing?.cost ?? '';
                        // document.querySelector("input[name='ukuran_part']").value = data.designing?.hour ?? ''; // opsional

                        // Programming
                        document.querySelector("input[name='prog_working_time']").value = data.programming?.hour ?? '';
                        // document.querySelector("input[name='prog_cost_time']").value = data.programming?.cost ?? '';

                        // Finishing Table2 & Table3
                        document.querySelectorAll("input[name='finishing_lead_time[]']").forEach(i => i.value = data.finishing ?? '');
                        document.querySelectorAll("input[name='finishing_working_time[]']").forEach(i => i.value = data.finishing ?? '');

                        // Hitung total cost
                        // calculateTotalCost();
                    });
            }
  


            
        </script>
<script>
    function getUkuranPart() {
        return parseFloat($('#ukuranPart').val()) || 0;
    }

    function calculateQtyByPart(partListVal) {
        const ukuranPart = getUkuranPart();
     
        switch (partListVal.toLowerCase()) {

            case 'frame':
                const jigLength = parseFloat($('#jig_length').val()) || 0;
                const jigWidth = parseFloat($('#jig_width').val()) || 0;
                const jigHeight = parseFloat($('#jig_height').val()) || 0;
                return Math.round(((jigLength * 4) + (jigWidth * 6) + (jigHeight * 4)) / 6000);
            case 'ikel/feet':
                console.log(partListVal);
                console.log(ukuranPart);
                return Math.round(ukuranPart + 2);

            case 'datum surface (lower)':
                return Math.round(ukuranPart * 4 * 3);

            case 'datum pin':
                return Math.round((ukuranPart * 2) / 3);

            default:
                return null;
        }
    }

    function updateQtyBasedOnPartList() {
        let datumSurfaceLowerQty = null;
        let ikelFeetQty = null;

        $('input.mm-part-list').each(function(index) {
            const partListVal = $(this).val().trim().toLowerCase();
            const qtyInput = $('input[name="mm_qty[]"]').eq(index);
         
            const calculatedQty = calculateQtyByPart(partListVal);

            if (partListVal === 'ikel/feet') {
                ikelFeetQty = calculatedQty;
                qtyInput.val(calculatedQty);
            }

            else if (partListVal === 'datum surface (lower)') {
                datumSurfaceLowerQty = calculatedQty;
                qtyInput.val(calculatedQty);
            }

            else if (partListVal === 'datum pin') {
                qtyInput.val(calculatedQty);
            }

            else if (partListVal === 'frame') {
                qtyInput.val(calculatedQty);
            }

            else if (partListVal === 'reinforce' || partListVal === 'locator body' || partListVal === 'clamp') {
                if (ikelFeetQty !== null) {
                    qtyInput.val(ikelFeetQty);
                }
            }

            else if (partListVal === 'bracket locator (upper)') {
                if (datumSurfaceLowerQty !== null) {
                    qtyInput.val(datumSurfaceLowerQty);
                }
            }
        });
    }

    // Trigger saat input Jig berubah
    $('#jig_length, #jig_width, #jig_height').on('input', function () {
        updateQtyBasedOnPartList();
    });

    // Trigger saat jumlah part berubah
    $('#ukuranPart').on('input', function () {
        updateQtyBasedOnPartList();
    });

    // Trigger saat part list berubah
    $(document).on('input', 'input.mm-part-list', function () {
        updateQtyBasedOnPartList();
    });
</script>
<script>
function updateStandardPartQty() {
    const spRows = $('#standardPartTable tbody tr');
    const mmRows = $('#mainMaterialTable tbody tr');

    // Ambil data dari mainMaterialTable
    let mmQtyByPartList = {};
    mmRows.each(function () {
        const partList = $(this).find('input[name="mm_part_list[]"]').val().trim();
        const qty = parseInt($(this).find('input[name="mm_qty[]"]').val()) || 0;
        mmQtyByPartList[partList] = qty;
    });

    // Ambil data awal sp_qty berdasarkan sp_size_type
    let spQtyMap = {};
    spRows.each(function () {
        const sizeType = $(this).find('input[name="sp_size_type[]"]').val().trim();
        const qty = parseInt($(this).find('input[name="sp_qty[]"]').val()) || 0;
        spQtyMap[sizeType] = qty;
    });

    // Hitung nilai baru untuk sp_qty sesuai rumus
    const newQtyMap = {};

    // CB6-30 = (Datum Surface (lower) + Bracket Locator (upper)) * 2
    newQtyMap['CB6-30'] = ((mmQtyByPartList['Datum Surface (lower)'] || 0) + (mmQtyByPartList['Bracket Locator (upper)'] || 0)) * 2;

    // MSTP8-30 = Locator Body * 5
    newQtyMap['MSTP8-30'] = (mmQtyByPartList['Locator Body'] || 0) * 5;

    // MSTP6-30 = CB6-30
    newQtyMap['MSTP6-30'] = newQtyMap['CB6-30'] || 0;

    // CB8-30 = MSTP6-30 * 5
    // newQtyMap['CB8-30'] = (newQtyMap['MSTP6-30'] || 0) * 5;

    // CVTAB16 = (STG-M-32-50-T0H-D * 2) + CAC4-A-50-100-T0H-Y1
    newQtyMap['CVTAB16'] = (spQtyMap['STG-M-32-50-T0H-D'] || 0) * 2 + (spQtyMap['CAC4-A-50-100-T0H-Y1'] || 0);

    newQtyMap['SC3W8-8'] = (spQtyMap['CAC4-A-50-100-T0H-Y1'] || 0) * 2;
    newQtyMap['SC3W6-8'] = (spQtyMap['STG-M-32-50-T0H-D'] || 0) * 2;
    newQtyMap['SW-T0H'] = newQtyMap['SC3W8-8'] + newQtyMap['SC3W6-8'];
    // Terapkan nilai baru ke field
    spRows.each(function () {
        const $row = $(this);
        const sizeType = $row.find('input[name="sp_size_type[]"]').val().trim();

        if (newQtyMap.hasOwnProperty(sizeType)) {
            $row.find('input[name="sp_qty[]"]').val(newQtyMap[sizeType]);
        }
    });
}

// Trigger otomatis saat terjadi input
$(document).on('input', 'input[name="sp_size_type[]"], input[name="sp_qty[]"], input[name="mm_qty[]"], input[name="mm_part_list[]"]', function () {
    updateStandardPartQty();
});


    // Tambahkan delay agar update terjadi setelah input benar-benar berubah
    let debounceTimer;
    $(document).on('input', 'input[name="sp_size_type[]"], input[name="sp_qty[]"]', function () {
        clearTimeout(debounceTimer);
        debounceTimer = setTimeout(updateStandardPartQty, 200);
    });
</script>
<script>
function updateCalculatedQtys() {
    const standardPartRows = $('#standardPartTable tbody tr');
    const mainMaterialRows = $('#mainMaterialTable tbody tr');

    let spQtyMap = {}; // Menyimpan qty berdasarkan sp_size_type
    let mmQtyMap = {}; // Menyimpan qty berdasarkan mm_part_list

    // Ambil semua sp_qty berdasarkan sp_size_type
    standardPartRows.each(function () {
        const sizeType = $(this).find('input[name="sp_size_type[]"]').val().trim();
        const qty = parseInt($(this).find('input[name="sp_qty[]"]').val()) || 0;

        if (sizeType !== '') {
            spQtyMap[sizeType] = qty;
        }
    });

    // Ambil semua mm_qty berdasarkan mm_part_list
    mainMaterialRows.each(function () {
        const partList = $(this).find('input[name="mm_part_list[]"]').val().trim().toLowerCase();
        const qty = parseInt($(this).find('input[name="mm_qty[]"]').val()) || 0;

        if (partList !== '') {
            mmQtyMap[partList] = (mmQtyMap[partList] || 0) + qty;
        }
    });

    // Hitung dan update nilai sp_qty berdasarkan rumus
    standardPartRows.each(function () {
        const $row = $(this);
        const sizeType = $row.find('input[name="sp_size_type[]"]').val().trim();

        let newQty = null;

        if (sizeType === 'CB6-30') {
            const dsLowerQty = mmQtyMap['datum surface (lower)'] || 0;
            const blUpperQty = mmQtyMap['bracket locator (upper)'] || 0;
            newQty = (dsLowerQty + blUpperQty) * 2;

        } else if (sizeType === 'MSTP6-30') {
            const locatorBodyQty = mmQtyMap['locator body'] || 0;
            newQty = spQtyMap['CB6-30'] ;

        } else if (sizeType === 'CB8-30') {
            const mstpQty = spQtyMap['MSTP8-30'] || 0;
            newQty = mstpQty * 2;

        } else if (sizeType === 'CVTAB16') {
            const stgQty = spQtyMap['STG-M-32-50-T0H-D'] || 0;
            const cacQty = spQtyMap['CAC4-A-50-100-T0H-Y1'] || 0;
            newQty = (stgQty * 2) + cacQty;
        }

        if (newQty !== null) {
            $row.find('input[name="sp_qty[]"]').val(newQty);
        }
    });
}

// Jalankan saat ada perubahan input
$(document).on('input', 'input[name="sp_size_type[]"], input[name="sp_qty[]"], input[name="mm_part_list[]"], input[name="mm_qty[]"]', function () {
    updateCalculatedQtys();
});

// Jalankan saat dokumen siap (untuk data yang sudah ada)
$(document).ready(function () {
    updateCalculatedQtys();
});
</script>
<?= $this->endSection() ?>