<?= $this->extend('layout/template') ?>
<style>
.inline-inputs input {
    display: inline-block;
    width: 60px;
    margin-right: 4px;
    vertical-align: middle;
}
</style>

<?= $this->section('content') ?>
<div class="pd-ltr-20 xs-pd-20-10">
    <div class="min-height-200px">
        <div class="page-header">
            <div class="row">
                <div class="col-md-6 col-sm-12">
                    <div class="title">
                        <h4>Tambah CCF</h4>
                    </div>
                    <nav aria-label="breadcrumb" role="navigation">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item">
                                <a href="<?= site_url('actual-activity/personal'); ?>">Home</a>
                            </li>
                            <li class="breadcrumb-item"><a href="<?= site_url('ccf'); ?>">CCF</a></li>
                            <li class="breadcrumb-item active" aria-current="page">
                                Form Tambah CCF
                            </li>
                        </ol>
                    </nav>
                </div>
            </div>
        </div>  
        <style>
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
        </style>
        <style>
        input[type="text"].has-default-value:not([readonly]),
        input[type="number"].has-default-value:not([readonly]) {
            background-color: #e8f4ff; 
            border-left: 3px solid #4dabf7; 
        }


        input[type="text"].no-default-value:not([readonly]),
        input[type="number"].no-default-value:not([readonly]) {
            background-color: #fff3e6; 
            border-left: 3px solid #fd7e14; 
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
        <div class="pd-ltr-20 xs-pd-20-10">
            <div class="min-height-200px">
                <div class="card card-step">
                    <h2 class="mt-3 text-center mb-3">CCF Data Form </h2>
                    
                    <!-- Step Wizard Navigation -->
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
                            <a class="nav-link" id="trial-tab" data-toggle="tab" href="#step9" role="tab">Trial Process</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" id="toolcost-tab" data-toggle="tab" href="#step10" role="tab">Tool Cost</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" id="aksesoris-tab" data-toggle="tab" href="#step11" role="tab">Aksesoris</a>
                        </li>
                    </ul>
                    
                    <form action="<?= site_url('ccf/store'); ?>" method="post" enctype="multipart/form-data" id="dcpForm" novalidate>
                        <div class="tab-content" id="stepWizardContent">
                            <!-- Step 1: Overview -->
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

                            <div class="tab-pane fade show active" id="step1" role="tabpanel">
                                <div class="segment">
                                    <h4>Segment Overview</h4>
                                    <div class="row">
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label>Part No</label>
                                                <select id="part_no_select" name="part_no_select" class="custom-select2 form-control" style="width:100%; height:38px;" required>
                                                    <option value="">-- Pilih Model - Part No --</option>
                                                    <?php foreach($projects as $project): ?>
                                                    <option
                                                        value="<?= $project['id'] ?>"
                                                        data-customer="<?= $project['customer'] ?>"
                                                        data-model="<?= $project['model'] ?>"
                                                        data-part_no="<?= $project['part_no'] ?>"
                                                        data-part_name="<?= $project['part_name'] ?>"
                                                    >
                                                        <?= $project['model'] ?> - <?= $project['part_no'] ?>
                                                    </option>
                                                    <?php endforeach; ?>
                                                </select>
                                                <input type="hidden" id="part_no" name="part_no">
                                            </div>
                                        </div>   
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label>CF Process</label>
                                                <select class="custom-select2 form-control" name="cf_process" id="cf_process">  <!-- ### PERUBAHAN: dari input ke select -->
                                                    <option value="">-- Pilih CF Process --</option>
                                                    <option value="CF Single">CF Single</option>
                                                    <option value="CF Assy">CF Assy</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                        <div class="form-group">
                                            <label>CF Dimension (L × W × H)</label>
                                            <div class="d-flex gap-1">
                                                <input type="number" step="any" class="form-control mr-1" name="cf_length" id="cf_length" placeholder="Length" >
                                                <input type="number" step="any" class="form-control mr-1" name="cf_width" id="cf_width" placeholder="Width">
                                                <input type="number" step="any" class="form-control mr-1" name="cf_height" id="cf_height" placeholder="Height">
                                            </div>
                                        </div>
                                    </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-4">
                                                <div class="form-group">
                                                    <label>Customer</label>
                                                    <input type="text" class="form-control" name="cust" id="cust" readonly>
                                                </div>
                                            </div>
                                            <div class="col-md-4">
                                                <div class="form-group">
                                                    <label>Model</label>
                                                    <input type="text" class="form-control" name="model" id="model" readonly>
                                                </div>
                                            </div>
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label>Part Name</label>
                                                <input type="text" class="form-control" name="part_name" id="part_name" readonly>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-md-4">
                                            <div class="form-group">
                                            <label>Weight</label>
                                            <input type="text" class="form-control" name="cf_weight">
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label>Class</label>
                                                <select class="custom-select2 form-control" name="class" id="classSelect" onchange="updateUkuranPart()">
                                                    <option value="">-- PILIH CLASS --</option>
                                                    <option value="A SIMPLE">A SIMPLE</option>
                                                    <option value="A SULIT">A SULIT</option>
                                                    <option value="B SIMPLE">B SIMPLE</option>
                                                    <option value="B SULIT">B SULIT</option>
                                                    <option value="C SIMPLE">C SIMPLE</option>
                                                    <option value="C SULIT">C SULIT</option>
                                                    <option value="D SIMPLE">D SIMPLE</option>
                                                    <option value="D SULIT">D SULIT</option>
                                                </select>

                                            </div>
                                        </div>

                                        <!-- <div class="col-md-4">
                                            <div class="form-group">
                                                <label>Ukuran Part</label>
                                                <input type="text" class="form-control" name="ukuran_part" id="ukuranPart" readonly>
                                            </div>
                                        </div> -->
                                    </div>

                                    <!-- Sketch upload (tidak berubah) -->
                                    <div class="row">
                                        <div class="col-md-4">
                                            <div class="form-group">
                                            <label>Sketch (Upload Gambar)</label>
                                            <input type="file" class="form-control-file" name="sketch" id="sketchInput" accept=".png,.jpg,.jpeg">
                                            <div class="mt-2">
                                                <img id="sketchPreview" src="#" alt="Preview Sketch" style="display:none; max-width:100%; height:auto;" class="img-thumbnail">
                                            </div>
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
                                            <thead>
                                                <tr>
                                                    <th>No</th>
                                                    <th>Process</th>
                                                    <th>Man Power</th>
                                                    <th>Working Time (hrs)</th>
                                                    <!-- <th>Cost/hour</th> -->
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <!-- Baris 1: Designing -->
                                                <tr>
                                                    <td class="row-number">1</td>
                                                    <td>
                                                        <input type="text" class="form-control" value="Designing" readonly>
                                                    </td>
                                                    <td><input type="number" name="design_man_power" class="form-control calc-mp" data-target="design_mp_time" value="1"></td>
                                                    <td><input type="number" name="design_working_time" class="form-control calc-mp" data-target="design_mp_time"></td>
                                                    <!-- <td><input  type="number" name="design_cost_time" class="form-control"></td>
                                                    <td><input  type="number" name="design_total_cost" class="form-control" readonly></td> -->
                                                </tr>
                                                <!-- Baris 2: Programming -->
                                                <tr>
                                                    <td class="row-number">2</td>
                                                    <td>
                                                        <input type="text" class="form-control" value="Programming" readonly>
                                                    </td>
                                                    <td><input type="number" name="prog_man_power" class="form-control calc-mp" data-target="prog_mp_time" value="1"></td>
                                                    <td><input type="number" name="prog_working_time" class="form-control calc-mp" data-target="prog_mp_time" value="<?php echo isset($cadCamRow['hour']) ? $cadCamRow['hour'] : '8' ?>"></td>
                                                    <!-- <td><input  type="number" name="prog_cost_time" class="form-control" ></td>
                                                    <td><input  type="number" name="prog_total_cost" class="form-control" readonly></td> -->
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                                <div class="d-flex justify-content-between mt-3">
                                    <button type="button" class="btn btn-step btn-secondary prev-step">Previous</button>
                                    <button type="button" class="btn btn-step btn-primary next-step">Next</button>
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
                                                $grouped = [];
                                                foreach ($ccf_master_main_material as $row) {
                                                    $grouped[$row['mm_category']][] = $row;
                                                }
                                                $no = 1;
                                                foreach ($grouped as $category => $items):
                                            ?>
                                                <!-- Tampilkan nama kategori -->
                                                <tr style="background-color: #f2f2f2;">
                                                    <td class="text-center font-weight-bold"><?= $no++ ?></td>
                                                    <td colspan="6"><strong><?= strtoupper($category) ?></strong></td>
                                                </tr>
                                                <?php foreach ($items as $index => $material): ?>
                                                    <tr>
                                                        <td></td>
                                                        <td style="position: relative;">
                                                            <input type="text" name="mm_part_list[]" class="form-control mm-part-list" value="<?= esc($material['mm_part_list']) ?>">
                                                            <div class="suggestions-dropdown partlist-suggestions"></div>
                                                        </td>
                                                        <td style="position: relative;">
                                                            <input type="text" name="mm_material_spec[]" class="form-control mm-material-spec" value="<?= esc($material['mm_material_spec']) ?>">
                                                            <div class="suggestions-dropdown materialspec-suggestions"></div>
                                                        </td>
                                                        <td>
                                                            <div class="d-flex gap-1">
                                                                <input type="text" name="mm_size_type_l[]" class="form-control form-control-sm mm-l mr-1 mb-1" value="<?= esc($material['mm_size_type_l']) ?>" placeholder="L" style="width: 60px;">
                                                                <input type="text" name="mm_size_type_w[]" class="form-control form-control-sm mm-w mr-1 mb-1" value="<?= esc($material['mm_size_type_w']) ?>" placeholder="W" style="width: 60px;">
                                                                <input type="text" name="mm_size_type_h[]" class="form-control form-control-sm mm-h mb-1" value="<?= esc($material['mm_size_type_h']) ?>" placeholder="H" style="width: 60px;">
                                                            </div>
                                                        </td>
                                                        <td><input type="number" name="mm_qty[]" class="form-control" value="<?= esc($material['mm_qty']) ?>"></td>
                                                        <td><input type="number" name="mm_weight[]" class="form-control mm-weight" value="<?= esc($material['mm_weight']) ?>" placeholder="Auto" readonly></td>
                                                        <td><button type="button" class="btn btn-danger btn-sm removeRow">Hapus</button></td>
                                                    </tr>
                                                <?php endforeach; ?>
                                            <?php endforeach; ?>
                                        </tbody>
                                    </table>

                                    <!-- <button type="button" id="addMainMaterial" class="btn btn-primary btn-sm mb-3">Tambah Baris</button> -->
                                        </div>
                                </div>
                                <div class="d-flex justify-content-between">
                                    <button type="button" class="btn btn-step btn-secondary prev-step">Previous</button>
                                    <button type="button" class="btn btn-step btn-primary next-step">Next</button>
                                </div>
                            </div>

                            <!-- Step 5: Standard Part -->
                            <div class="tab-pane fade" id="step5" role="tabpanel">
                                <div class="segment">
                                    <h4>Segment Standard Part</h4>
                                    <div class="table-responsive">
                                       <table class="table table-bordered table-input" id="standardPartTable">
                                            <thead>
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
                                                <?php if (!empty($ccf_master_standard_part)): ?>
                                                    <?php 
                                                        $groupedStd = [];
                                                        foreach ($ccf_master_standard_part as $part) {
                                                            $groupedStd[$part['sp_category']][] = $part;
                                                        }
                                                        $no = 1;
                                                        foreach ($groupedStd as $category => $items):
                                                    ?>
                                                        <!-- Baris kategori -->
                                                        <tr style="background-color: #f2f2f2;">
                                                            <td class="text-center font-weight-bold"><?= $no++ ?></td>
                                                            <td colspan="5"><strong><?= strtoupper($category) ?></strong></td>
                                                        </tr>

                                                        <!-- Baris item -->
                                                        <?php foreach ($items as $item): ?>
                                                            <tr>
                                                                <td></td>
                                                                <td>
                                                                    <input type="text" name="sp_part_list[]" class="form-control" value="<?= esc($item['sp_part_list'] ?? '') ?>">
                                                                </td>
                                                                <td>
                                                                    <input type="text" name="sp_material_spec[]" class="form-control" value="<?= esc($item['sp_material_spec'] ?? '') ?>">
                                                                </td>
                                                                <td>
                                                                    <input type="text" name="sp_size_type[]" class="form-control" value="<?= esc($item['sp_size_type'] ?? '') ?>">
                                                                </td>
                                                                <td>
                                                                    <input type="number" name="sp_qty[]" class="form-control" value="<?= esc($item['sp_qty'] ?? 1) ?>">
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
                                </div>
                                <div class="d-flex justify-content-between">
                                    <button type="button" class="btn btn-step btn-secondary prev-step">Previous</button>
                                    <button type="button" class="btn btn-step btn-primary next-step">Next</button>
                                </div>
                            </div>
                            
                            <!-- Step 6: Manufacturing -->
                            <div class="tab-pane fade" id="step6" role="tabpanel">
                                <div class="segment">
                                    <h4>Segment Manufacturing</h4>
                                    <!-- Tabel 1 -->
                                    <div class="table-responsive">
                                        <table class="table table-bordered table-input" id="machiningTable1">
                                            <thead>
                                                <tr>
                                                    <th>No</th>
                                                    <th>Process</th>
                                                    <th>Man Power</th>
                                                    <th>Working Time (H)</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <tr>
                                                    <td class="row-number">1</td>
                                                    <td>
                                                        <input type="text" name="machining_process[]" class="form-control" value="MEASURING" readonly>
                                                    </td>
                                                    <td><input type="number" name="machining_man_power[]" class="form-control calc-mp" data-target="machining_mp_time1" value="1"></td>
                                                    <td><input type="number" name="machining_working_time[]" class="form-control calc-mp" data-target="machining_mp_time1"></td>
                                                    <!-- <td><input type="number" name="machining_mp_time[]" class="form-control" readonly></td> -->
                                                </tr>
                                                <tr>
                                                    <td class="row-number">2</td>
                                                    <td>
                                                        <input type="text" name="machining_process[]" class="form-control" value=" FABRICATION + WELDING" readonly>
                                                    </td>
                                                    <td><input type="number" name="machining_man_power[]" class="form-control calc-mp" data-target="machining_mp_time2" value="1" ></td>
                                                    <td><input type="number" name="machining_working_time[]" class="form-control calc-mp" data-target="machining_mp_time2"  ></td>
                                                    <!-- <td><input type="number" name="machining_mp_time[]" class="form-control" readonly></td> -->
                                                </tr>
                                                <tr>
                                                    <td class="row-number">3</td>
                                                    <td>
                                                        <input type="text" name="machining_process[]" class="form-control" value=" MACHINING" readonly>
                                                    </td>
                                                    <td><input type="number" name="machining_man_power[]" class="form-control calc-mp" data-target="machining_mp_time3" value="1"></td>
                                                    <td><input type="number" name="machining_working_time[]" class="form-control calc-mp" data-target="machining_mp_time3" ></td>
                                                    <!-- <td><input type="number" name="machining_mp_time[]" class="form-control" readonly></td> -->
                                                </tr>
                                                <tr>
                                                    <td class="row-number">4</td>
                                                    <td>
                                                        <input type="text" name="machining_process[]" class="form-control" value=" ASSEMBLY + TUNNING" readonly>
                                                    </td>
                                                    <td><input type="number" name="machining_man_power[]" class="form-control calc-mp" data-target="machining_mp_time4" value="1"></td>
                                                    <td><input type="number" name="machining_working_time[]" class="form-control calc-mp" data-target="machining_mp_time4" ></td>
                                                    <!-- <td><input type="number" name="machining_mp_time[]" class="form-control" readonly></td> -->
                                                </tr>
                                            </tbody>
                                        </table>
                                        <!-- Tabel 2 -->
                                        <table class="table table-bordered table-input" id="machiningTable2">
                                            <thead>
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
                                                <?php 
                                                $processes = [
                                                    "MACHINING", "MACHINING", "MACHINING", "MACHINING", "WELDING", "MEASURING"
                                                ];
                                                $machines = [
                                                    " CNC HF-3", "TONGTAI CNC", "MILLING MANUAL", "RADIAL DRILLING", "NATIONAL 300 AMPERE",
                                                    "MAKINO CNC", "SURFACE GRINDING", "MILLING NANTONG", "RADIAL DRILLING ZQ 3070",
                                                    "FARO CMM"
                                                ];
                                    $no = 1;
                                                foreach($processes as $index => $proc): 
                                            

                                                
                                                ?>
                                                <tr>
                                                    <td class="row-number"><?= $no++  ?></td>
                                                    <td>
                                                        <input type="text" name="machining_proc[]" class="form-control" value="<?= $proc ?>" readonly>
                                                    </td>
                                                    <td>
                                                        <input type="text" name="machining_kom[]" class="form-control" value="<?= isset($machines[$index]) ? $machines[$index] : '' ?>" readonly>
                                                    </td>
                                                    <td><input type="number" name="machining_lead_time[]" class="form-control"></td>
                                                </tr>
                                        
                                                <?php endforeach; ?>
                                                    
                                            
                                            </tbody>

                                        </table>
                                    </div>
                                    

                                </div>

                                <div class="d-flex justify-content-between">
                                    <button type="button" class="btn btn-step btn-secondary prev-step">Previous</button>
                                    <button type="button" class="btn btn-step btn-primary next-step">Next</button>
                                </div>
                            </div>
                            
                            <!-- Step 7: Finishing -->
                            <div class="tab-pane fade" id="step7" role="tabpanel">
                                <div class="segment">
                                    <h4>Segment Finishing</h4>
                                    <!-- Tabel 1 -->
                                    <div class="table-responsive">
                                        <table class="table table-bordered table-input" id="finishingTable1">
                                            <thead>
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
                                                <?php foreach ($ccf_master_finishing_3 as $i => $item): ?>
                                                    <tr>
                                                        <td class="row-number"><?= $i + 1 ?></td>
                                                        <td style="position: relative;">
                                                            <input type="text" name="finishing_part_list[]" class="form-control" value="<?= esc($item['finishing_part_list']) ?>">
                                                        </td>
                                                        <td style="position: relative;">
                                                            <input type="text" name="finishing_material_spec[]" class="form-control" value="<?= esc($item['finishing_material_spec']) ?>">
                                                        </td>
                                                        <td>
                                                            <input type="text" name="finishing_size_type[]" class="form-control" value="<?= esc($item['finishing_size_type']) ?>">
                                                        </td>
                                                        <td>
                                                            <input type="number" name="finishing_qty[]" class="form-control" value="<?= esc($item['finishing_qty']) ?>">
                                                        </td>
                                                        <td>
                                                            <button type="button" class="btn btn-danger btn-sm removeRow">Hapus</button>
                                                        </td>
                                                    </tr>
                                                <?php endforeach; ?>
                                            </tbody>
                                        </table>
                                    </div>
                                    <!-- <button type="button" id="addRowFinishing" class="btn btn-primary btn-sm mb-3">Tambah Baris</button> -->
                                    <div class="table-responsive">
                                    <!-- Tabel 2 -->
                                    <table class="table table-bordered table-input" id="finishingTable2">
                                        <thead>
                                            <tr>
                                                <th>No</th>
                                                <th>Process</th>
                                                <th>Kind of Machine</th>
                                                <th>Lead Time</th>
                                            
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr>
                                                <td class="row-number">1</td>
                                                <td>
                                                    <input type="text" name="finishing_process2[]" class="form-control" value="Finishing" readonly>
                                                </td>
                                                <td>
                                                    <input type="text" name="finishing_kom[]"  class="form-control" value="Tools Grinder" >
                                                </td>
                                                <td>
                                                <input type="number" name="finishing_lead_time[]" class="form-control">
                                                </td>
                                            </tr>
                                            <tr>
                                                <td class="row-number">2</td>
                                                <td>
                                                    <input type="text" name="finishing_process2[]" class="form-control" value="Painting" readonly>
                                                </td>
                                                <td>
                                                    <input type="text" name="finishing_kom[]"  class="form-control" value="Painting Tools" >
                                                </td>
                                                <td>
                                                <input type="number" name="finishing_lead_time[]" class="form-control" >
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>
                                    </div>
                                    <!-- Tabel 3 -->
                                    <div class="table-responsive">
                                        <table class="table table-bordered table-input" id="finishingTable3">
                                            <thead>
                                                <tr>
                                                    <th>Process</th>
                                                    <th>Man Power</th>
                                                    <th>Working Time (Hrs)</th>
                                                    <!-- <th>Time/MP</th> -->
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <tr>
                                                    <td>
                                                        <input type="text" name="finishing_process3[]" class="form-control" value="Finishing" readonly>
                                                    </td>
                                                    <td><input type="number" name="finishing_mp[]" class="form-control calc-mp" data-target="finishing_mp_time1" value="1"></td>
                                                    <td>
                                                <input type="number" name="finishing_working_time[]" class="form-control calc-mp" data-target="finishing_mp_time1" >
                                            </td>

                                                    <!-- <td><input type="number" name="finishing_mp_time[]" id="finishing_mp_time1" class="form-control" readonly></td> -->
                                                </tr>
                                                <tr>
                                                    <td>
                                                        <input type="text" class="form-control" name="finishing_process3[]" value="Painting" readonly>
                                                    </td>
                                                    <td><input type="number" name="finishing_mp[]" class="form-control calc-mp" data-target="finishing_mp_time2" value="1"></td>
                                                    <td><input type="number" name="finishing_working_time[]" class="form-control calc-mp" data-target="finishing_mp_time2"></td>
                                                    <!-- <td><input type="number" name="finishing_mp_time[]" id="finishing_mp_time2" class="form-control" readonly></td> -->
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>
                            
                                

                                </div>
                                <div class="d-flex justify-content-between">
                                    <button type="button" class="btn btn-step btn-secondary prev-step">Previous</button>
                                    <button type="button" class="btn btn-step btn-primary next-step">Next</button>
                                </div>
                            </div>
                            
                            <!-- Step 8: Heat Treatment -->
                            <div class="tab-pane fade" id="step8" role="tabpanel">
                                <div class="segment">
                                    <h4>Segment Harderning</h4>
                                    <div class="table-responsive">
                                    <table class="table table-bordered table-input" id="harderningTable">
                                        <thead>
                                        <tr>
                                            <th>No</th>
                                            <th>Process</th>
                                            <th>Kind of Machine</th>
                                            <th>Weight (KG)</th>
                                            <th>Aksi</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        <?php 
                                            // Jika ada data awal, loop di sini; kalau tidak, tampilkan satu baris kosong:
                                            $harderningDefaults = ['Harderning']; 
                                            foreach($harderningDefaults as $i => $proc): ?>
                                            <tr>
                                            <td class="row-number"><?= $i+1 ?></td>
                                            <td>
                                                <input type="text" name="heat_process[]" class="form-control" value="<?= esc($proc) ?>" readonly>
                                            </td>
                                            <td>
                                                <input type="text" name="heat_machine[]" class="form-control">
                                            </td>
                                            <td>
                                                <input type="number" name="heat_weight[]" class="form-control">
                                            </td>
                                            <td>
                                                <button type="button" class="btn btn-danger btn-sm removeRow">Hapus</button>
                                            </td>
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

                                <script>
                                // fungsi untuk menomori ulang kolom “No” setelah setiap perubahan
                                function refreshRowNumbers(tableId) {
                                document.querySelectorAll(`#${tableId} tbody tr`).forEach((tr, i) => {
                                    tr.querySelector('.row-number').textContent = i+1;
                                });
                                }

                                // tombol Hapus
                                document.addEventListener('click', function(e){
                                    if (e.target.matches('#harderningTable .removeRow')) {
                                        e.target.closest('tr').remove();
                                        refreshRowNumbers('harderningTable');
                                    }
                                });

                                // tombol Tambah Baris
                                document.getElementById('addRowHarderning').addEventListener('click', function(){
                                const tbody = document.querySelector('#harderningTable tbody');
                                const idx = tbody.querySelectorAll('tr').length;
                                const tr = document.createElement('tr');
                                tr.innerHTML = `
                                    <td class="row-number">${idx+1}</td>
                                    <td><input type="text" name="heat_process[]" class="form-control" value="Harderning" readonly></td>
                                    <td><input type="text" name="heat_machine[]" class="form-control"></td>
                                    <td><input type="number" name="heat_weight[]" class="form-control"></td>
                                    <td><button type="button" class="btn btn-danger btn-sm removeRow">Hapus</button></td>
                                `;
                                tbody.appendChild(tr);
                                });
                                </script>

                            
                            <!-- Step 9: Die Spot & Try -->
                            <div class="tab-pane fade" id="step9" role="tabpanel">
                                <div class="segment">
                                    <h4>Segment Trial Process</h4>
                                    <!-- Tabel 1 -->
                                    <div class="table-responsive">
                                        <table class="table table-bordered table-input" id="dieSpotTable1">
                                            <thead>
                                                <tr>
                                                    <th>A</th>
                                                    <th>Part List</th>
                                                    <th>Material / Spec</th>
                                                    <th>Qty (PCS)</th>
                                                    <th>Weight (KG)</th>
                                                    <th>Aksi</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php 
                                                $dieSpotData = [
                                                    ['WIP SINGLE PART', '', ''],
                                                    ['NUT', '', ''],
                                                    ['BOLT-WELD', '', ''],
                                                    ['Co2 Wire', '', ''],
                                                    ['Cup Tip', '', ''],
                                                    ['Stud Bolt', '', ''],
                                                ];
                                                foreach($dieSpotData as $i => $row): ?>
                                                <tr>
                                                    <td class="row-number"><?= $i+1 ?></td>
                                                    <td>
                                                        <input type="text" class="form-control" name="die_spot_part_list[]" value="<?= $row[0] ?>" readonly>
                                                    </td>
                                                    <td>
                                                        <input type="text" class="form-control" name="die_spot_material[]" value="<?= $row[1] ?>">
                                                    </td>
                                                    <td>
                                                        <input type="number" class="form-control" name="die_spot_qty[]" value="<?= $row[2] ?>">
                                                    </td>
                                                    <td>
                                                        <input type="number" name="die_spot_weight[]" class="form-control">
                                                    </td>
                                                    <td>
                                                        <button type="button" class="btn btn-danger btn-sm removeRow">Hapus</button>
                                                    </td>
                                                </tr>
                                                <?php endforeach; ?>
                                            </tbody>
                                        </table>
                                    </div>
                                    <button type="button" id="addDieSpotRow" class="btn btn-primary btn-sm mb-3">Tambah Baris</button>

                                    <!-- Tabel 2 -->
                                    <?php 
                                        $dieSpotProcess = [
                                            ['WSS NUT', '', ''], // kolom mesin dikosongkan agar default null
                                            ['WSS BOLT WELD', '', ''],
                                            ['Co2 Weld', '', ''],
                                            ['Sub-Assy', '', ''],
                                            ['WSS BOLT WELD', '', ''],
                                            ['Stud Bolt', '', ''],
                                        ];

                                        $machineOptions = [
                                            'Pilih Mesin',
                                        ];
                                        ?>
                                        <div class="table-responsive">
                                            <table class="table table-bordered table-input" id="dieSpotTable2">
                                                <thead>
                                                    <tr>
                                                    <th>B</th>
                                                    <th>Process</th>
                                                    <th>Kind of Machine</th>
                                                    <th>Lead Time</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <?php foreach($dieSpotProcess as $i => $row): 
                                                  ?>
                                                    <tr>
                                                        <td class="row-number">   <?= $i++ +1?></td>
                                                        <td>
                                                        <input type="text" class="form-control" name="die_spot_process2[]" value="<?= esc($row[0]) ?>" >
                                                        </td>
                                                        <td>
                                                        <input type="text" class="form-control" name="die_spot_kom[]"  >
                                                   
                                                        </td>
                                                        <td>
                                                        <input type="number" name="die_spot_lead_time[]" class="form-control" value="<?= esc($row[2]) ?>">
                                                        </td>
                                                    </tr>
                                                 
                                                    <?php endforeach; ?>
                                                </tbody>
                                            </table>
                                        </div>

                                    <!-- Tabel 3 -->
                                    <div class="table-responsive">
                                        <table class="table table-bordered table-input" id="dieSpotTable3">
                                            <thead>
                                                <tr>
                                                    <th>C</th>
                                                    <th>Process</th>
                                                    <th>Man Power</th>
                                                    <th>Working Time (H)</th>
                                                    <!-- <th>Time/MP</th> -->
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php 
                                                $dieSpotProcess2 = ['WSS NUT', 'WSS BOLT WELD', 'Co2 Weld', 'Sub-Assy', 'Stud Bolt'];
                                                foreach($dieSpotProcess2 as $i => $proc):
                                                ?>
                                                <tr>
                                                    <td class="row-number">   <?= $i++ +1?></td>
                                                    <td>
                                                        <input type="text" name="die_spot_process3[]" class="form-control" value="<?= $proc ?>" >
                                                    </td>
                                                    <td><input type="number" name="die_spot_mp[]" class="form-control calc-die-spot" data-target="die_spot_mp_time<?= $i ?>"></td>
                                                    <td>
                                                        <input type="number" name="die_spot_working_time[]" class="form-control calc-die-spot"
                                                            data-target="die_spot_mp_time<?= $i ?>">
                                                    </td>

                                                    <!-- <td><input type="number" name="die_spot_mp_time[]" id="die_spot_mp_time<?= $i ?>" class="form-control" readonly></td> -->
                                                </tr>
                                                <?php endforeach; ?>
                                            </tbody>
                                        </table>
                                    </div>
                                    <!-- <?php if (!empty($finishingRow) && isset($finishingRow['hour'])): ?>
                                        <div class="mb-3">
                                            <label>Nilai Maksimal Finishing Hour + Die Spot & Try:</label>
                                            <span class="fw-bold text-primary"><?= $finishingRow['hour'] ?> jam</span>
                                        </div>
                                    <?php endif; ?> -->
                                    <!-- <script>
                                        document.addEventListener("DOMContentLoaded", function () {
                                            document.querySelectorAll(".calc-die-spot").forEach(input => {
                                                input.addEventListener("input", function () {
                                                    let row = this.closest("tr");
                                                    let mp = row.querySelector("input[name='die_spot_mp[]']").value;
                                                    let time = row.querySelector("input[name='die_spot_working_time[]']").value;
                                                    let targetId = row.querySelector("input[name='die_spot_mp_time[]']").id;

                                                    if (mp && time && mp > 0) {
                                                        document.getElementById(targetId).value = (time / mp).toFixed(2);
                                                    } else {
                                                        document.getElementById(targetId).value = "";
                                                    }
                                                });
                                            });
                                        });
                                    </script> -->
                                </div>
                                <div class="d-flex justify-content-between">
                                    <button type="button" class="btn btn-step btn-secondary prev-step">Previous</button>
                                    <button type="button" class="btn btn-step btn-primary next-step">Next</button>
                                </div>
                            </div>
                            
                            <!-- Step 10: Tool Cost -->
                            <div class="tab-pane fade" id="step10" role="tabpanel">
                                <div class="segment">
                                    <h4>Segment Tool Cost</h4>
                                    <div class="table-responsive">
                                        <table class="table table-bordered table-input" id="toolCostTable">
                                            <thead>
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
                                                <?php if(isset($tool_cost) && is_array($tool_cost) && count($tool_cost) > 0): ?>
                                                    <?php foreach ($tool_cost as $i => $row): ?>
                                                    <tr>
                                                        <td class="row-number"><?= $i + 1 ?></td>
                                                        <td>
                                                            <input type="text" name="tool_cost_process[]" class="form-control" value="<?= esc($row['tool_cost_process'] ?? '') ?>"  >
                                                        </td>
                                                        <td>
                                                            <input type="text" name="tool_cost_tool[]" class="form-control" value="<?= esc($row['tool_cost_tool'] ?? '') ?>"    >
                                                        </td>
                                                        <td>
                                                            <input type="text" name="tool_cost_spec[]" class="form-control" value="<?= esc($row['tool_cost_spec'] ?? '') ?>"    >
                                                        </td>
                                                        <td>
                                                            <input type="number" name="tool_cost_qty[]" class="form-control" value="<?= esc($row['tool_cost_qty'] ?? '') ?>" >
                                                        </td>

                                                        <td>
                                                            <button type="button" class="btn btn-danger btn-sm removeRow">Hapus</button>
                                                        </td>
                                                    </tr>
                                                    <?php endforeach; ?>
                                                <?php else: ?>
                                                    <tr>
                                                        <td class="row-number">1</td>
                                                        <td><input type="text" name="tool_cost_process[]" class="form-control"></td>
                                                        <td><input type="text" name="tool_cost_tool[]" class="form-control"></td>
                                                        <td><input type="text" name="tool_cost_spec[]" class="form-control"></td>
                                                        <td><input type="number" name="tool_cost_qty[]" class="form-control"></td>
                                                        <td><button type="button" class="btn btn-danger btn-sm removeRow">Hapus</button></td>
                                                    </tr>
                                                <?php endif; ?>
                                            </tbody>
                                        </table>
                                    </div>
                                    <button type="button" id="addToolCost" class="btn btn-primary btn-sm mb-3">Tambah Baris</button>
                                </div>
                                <div class="d-flex justify-content-between">
                                    <button type="button" class="btn btn-step btn-secondary prev-step">Previous</button>
                                    <button type="button" class="btn btn-step btn-primary next-step">Next</button>
                                </div>
                            </div>
                            
                            <!-- Step 11: Aksesoris -->
                            <div class="tab-pane fade" id="step11" role="tabpanel">
                                <div class="segment">
                                    <h4>Segment Aksesoris</h4>
                                    <div class="table-responsive">
                                        <table class="table table-bordered table-input" id="aksesorisTable">
                                        <thead>
                                                <tr>
                                                    <th>No</th>
                                                    <th>Part List</th>
                                                    <th>Specification</th>
                                                    <th>Qty (PCS)</th>
                                                    <th>Aksi</th>
                                                </tr>
                                            </thead>
                                            <?php
                                                $parts = [
                                                    " "
                                                
                                                ];

                                                $specs = [
                                                    " "
                                                
                                                ];
                                                ?>

                                                <tbody>
                                                <?php foreach ($parts as $index => $part): ?>
                                                    <tr>
                                                        <td class="row-number"><?= $index + 1 ?></td>
                                                        <td style="position: relative;">
                                                            <input type="text" name="aksesoris_part_list[]" class="form-control aksesoris-part-list" value="<?= $part ?>" autocomplete="off">
                                                            <div class="suggestions-dropdown aksesoris-partlist-suggestions"></div>
                                                        </td>
                                                        <td style="position: relative;">
                                                            <input type="text" name="aksesoris_spec[]" class="form-control aksesoris-spec" value="<?= $specs[$index] ?>" autocomplete="off">
                                                            <div class="suggestions-dropdown aksesoris-spec-suggestions"></div>
                                                        </td>
                                                        <td><input type="number" name="aksesoris_qty[]" class="form-control" ></td>
                                                        <td><button type="button" class="btn btn-danger btn-sm removeRow">Hapus</button></td>
                                                    </tr>
                                                <?php endforeach; ?>
                                                </tbody>

                                        </table>
                                    </div>
                                    <button type="button" id="addAksesoris" class="btn btn-primary btn-sm mb-3">Tambah Baris</button>
                                </div>
                                <div class="d-flex justify-content-between">
                                    <button type="button" class="btn btn-step btn-secondary prev-step">Previous</button>
                                    <!-- Tombol submit hanya ada di step terakhir -->
                                    <button type="submit" class="btn btn-step btn-success">Simpan Data CCF</button>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>

<!-- Load jQuery dan Bootstrap JS -->
<script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
         <!-- ### PERUBAHAN: Script untuk auto-fill customer, model, part_no, part_name -->
<script>
    $(document).ready(function() {
        $('#part_no_select').select2();

        $('#part_no_select').on('change', function() {
            let opt = $(this).find('option:selected');
            let cust     = opt.data('customer') || "";
            let model    = opt.data('model') || "";
            let partNo   = opt.data('part_no') || "";
            let partName = opt.data('part_name') || "";

            $('#cust').val(cust);
            $('#model').val(model);
            $('#part_no').val(partNo);
            $('#part_name').val(partName);
        });
    });
    function updateUkuranPart() {
        const cls = document.getElementById('classSelect').value;
        if (!cls) return;
        const baseUrl = "<?= base_url() ?>";

        fetch(baseUrl + '/ccf/lead-time/' + encodeURIComponent(cls))
            .then(r => r.json())
            .then(data => {
                // Isi nilai untuk designing
                document.querySelector("input[name='design_working_time']").value = data.designing?.hour ?? '';

                // Finishing Table 2 & 3
                document.querySelectorAll("input[name='finishing_lead_time[]']").forEach(i => i.value = data.finishing ?? '');
                document.querySelectorAll("input[name='finishing_working_time[]']").forEach(i => i.value = data.finishing ?? '');

                const processInputs = document.querySelectorAll("input[name='machining_process[]']");
                const timeInputs = document.querySelectorAll("input[name='machining_working_time[]']");

                processInputs.forEach((procInput, index) => {
                    const value = procInput.value.toLowerCase().trim();
                    let time = '';

                    if (value.includes('fabrication') || value.includes('fabrikasi') || value.includes('welding')) {
                        time = data.fabrikasi?.hour ?? '';
                    } else if (value.includes('machining')) {
                        time = data.machining?.hour ?? '';
                    } else if (value.includes('assembly') || value.includes('tuning') || value.includes('tunning')) {
                        time = data.assembly?.hour ?? '';
                    }

                    if (timeInputs[index]) {
                        timeInputs[index].value = time;

                        timeInputs[index].classList.remove('no-default-value');
                        timeInputs[index].classList.add('has-default-value');
                    }
                });
                const procInputs = document.querySelectorAll("input[name='machining_proc[]']");
                const komInputs = document.querySelectorAll("input[name='machining_kom[]']");
                const leadInputs = document.querySelectorAll("input[name='machining_lead_time[]']");

                procInputs.forEach((procInput, i) => {
                    const proc = procInput.value.toLowerCase().trim();
                    const kom = komInputs[i]?.value.toUpperCase().trim();
                    let leadTime = '';

                    if (proc === 'welding' && data.fabrikasi?.hour) {
                        // 50% dari fabrikasi
                        leadTime = Math.round(data.fabrikasi.hour * 0.5);
                    } else if (proc === 'machining' && data.machining?.hour) {
                        // 90% untuk TONGTAI, 10% untuk RADIAL
                        if (kom === 'TONGTAI CNC') {
                            leadTime = Math.round(data.machining.hour * 0.9);
                        } else if (kom === 'RADIAL DRILLING') {
                            leadTime = Math.round(data.machining.hour * 0.1);
                        }
                    }

                    if (leadInputs[i]) {
                        leadInputs[i].value = leadTime;

                        leadInputs[i].classList.remove('no-default-value');
                        leadInputs[i].classList.add('has-default-value');
                    }
                });
                // calculateTotalCost(); // opsional
            });
        }

</script>
<script>
    function calculateTotalCost() {
        const rows = document.querySelectorAll('#designProgramTable tbody tr');
        rows.forEach(row => {
            const mpInput = row.querySelector("input[name$='man_power']");
            const timeInput = row.querySelector("input[name$='working_time']");
            const costInput = row.querySelector("input[name$='cost_time']");
            const totalInput = row.querySelector("input[name$='total_cost']");

            if (mpInput && timeInput && costInput && totalInput) {
                const mp = parseFloat(mpInput.value) || 0;
                const time = parseFloat(timeInput.value) || 0;
                const cost = parseFloat(costInput.value) || 0;
                const total = mp * time * cost;
                totalInput.value = total.toFixed(2);
            }
        });
    }

    // Hitung ulang ketika input berubah
    // document.addEventListener('input', function (e) {
    //     if (e.target.matches('.calc-mp') || e.target.name.endsWith('cost_time')) {
    //         calculateTotalCost();
    //     }
    // });

    // Hitung saat halaman dimuat
    // document.addEventListener('DOMContentLoaded', calculateTotalCost);
</script>


<script>
    document.addEventListener("DOMContentLoaded", function () {
        // Ambil semua input yang berhubungan dengan perhitungan
        const inputs = document.querySelectorAll(".calc-mp");

        // inputs.forEach(input => {
        //     input.addEventListener("input", function () {
        //         // Ambil baris tempat input ini berada
        //         const row = this.closest("tr");

        //         // Ambil nilai Man Power dan Working Time
        //         const manPower = row.querySelector("input[name='machining_man_power[]']").value;
        //         const workingTime = row.querySelector("input[name='machining_working_time[]']").value;

        //         // Ambil elemen hasil (Time/MP)
        //         const timeMP = row.querySelector("input[name='machining_mp_time[]']");

        //         // Hitung hasilnya dan perbarui nilai
        //         if (manPower > 0) {
        //             timeMP.value = (workingTime / manPower).toFixed(2); // Hasil dengan 2 desimal
        //         } else {
        //             timeMP.value = ""; // Kosongkan jika Man Power tidak valid
        //         }
        //     });
        // });
    });
</script>



<script>
    $('.next-step').click(function(){
        var $activeTab = $('#stepWizard .nav-link.active');
        var $nextTab = $activeTab.parent().next('li').find('.nav-link');
        if($nextTab.length){
            $nextTab.trigger('click');
        }
    });
    
    $('.prev-step').click(function(){
        var $activeTab = $('#stepWizard .nav-link.active');
        var $prevTab = $activeTab.parent().prev('li').find('.nav-link');
        if($prevTab.length){
            $prevTab.trigger('click');
        }
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
    $('#addDieSpotRow').click(function() {
        var row = `
            <tr>
                <td class="row-number"></td>
                <td><input type="text" class="form-control" name="die_spot_part_list[]" value=""></td>
                <td><input type="text" class="form-control" name="die_spot_material[]" value=""></td>
                <td><input type="text" class="form-control" name="die_spot_qty[]" value=""></td>
                <td><input type="number" class="form-control" name="die_spot_weight[]" value=""></td>
                <td><button type="button" class="btn btn-danger btn-sm removeRow">Hapus</button></td>
            </tr>`;
        $('#dieSpotTable1 tbody').append(row);
        updateRowNumbers('dieSpotTable1');
    });

    $("#addMainMaterial").click(function(){
    var row = $(`<tr>
        <td class="row-number"></td>
        <td style="position: relative;">
            <input type="text" name="mm_part_list[]" class="form-control mm-part-list">
            <div class="suggestions-dropdown partlist-suggestions"></div>
        </td>
        <td style="position: relative;">
            <input type="text" name="mm_material_spec[]" class="form-control mm-material-spec">
            <div class="suggestions-dropdown materialspec-suggestions"></div>
        </td>
        <td>
            <div class="d-flex gap-1">
                <input type="number" name="mm_size_type_l[]" class="form-control form-control-sm mm-l mr-1" placeholder="L" style="width: 60px;">
                <input type="number" name="mm_size_type_w[]" class="form-control form-control-sm mm-w mr-1" placeholder="W" style="width: 60px;">
                <input type="number" name="mm_size_type_h[]" class="form-control form-control-sm mm-h" placeholder="H" style="width: 60px;">
            </div>
        </td>
        <td><input type="number" name="mm_qty[]" class="form-control"></td>
        <td><input type="number" name="mm_weight[]" class="form-control mm-weight"></td>
        <td><button type="button" class="btn btn-danger btn-sm removeRow">Hapus</button></td>
    </tr>`);
    
    $("#mainMaterialTable tbody").append(row);
    updateRowNumbers("mainMaterialTable");
    applyInputStyle(row); 
});

    $("#addStandardPart").click(function(){
        var row = `<tr>
                        <td class="row-number"></td>
                        <td style="position: relative;">
                            <input type="text" name="sp_part_list[]" class="form-control sp-part-list">
                            <div class="suggestions-dropdown sp-partlist-suggestions"></div>
                            </td>
                            <td style="position: relative;">
                            <input type="text" name="sp_material_spec[]" class="form-control sp-material-spec">
                            <div class="suggestions-dropdown sp-materialspec-suggestions"></div>
                        </td>

                        <td><input type="text" name="sp_size_type[]" class="form-control"></td>
                        <td><input type="number" name="sp_qty[]" class="form-control"></td>
                        <td><button type="button" class="btn btn-danger btn-sm removeRow">Hapus</button></td>
                    </tr>`;
        $("#standardPartTable tbody").append(row);
        updateRowNumbers("standardPartTable");
        applyInputStyle(row);
    });
    

    // Perhitungan otomatis Time/MP
    $(document).on('keyup change', 'input.calc-mp', function(){
        var $row = $(this).closest('tr');
        var target = $(this).data('target');
        var workingTime = parseFloat($row.find("input[name*='working_time']").val()) || 0;
        var manPower = parseFloat($row.find("input[name*='man_power']").val()) || 1;
        var result = workingTime / manPower;
        $row.find("input[name='"+target+"']").val(result);
    });
    $(document).ready(function () {
    // Fungsi untuk menghapus baris tabel
    $(document).on('click', '.removeRow', function () {
        $(this).closest('tr').remove();
        updateRowNumbers();
    });

    $('#addRowFinishing').click(function () {
        let newRow = `<tr>
            <td class="row-number"></td>
            <td><input type="text" name="finishing_part_list[]" finishing_lead_time></td>
            <td><input type="text" name="finishing_material_spec[]" class="form-control"></td>
            <td><input type="text" name="finishing_size_type[]" class="form-control"></td>
            <td><input type="number" name="finishing_qty[]" class="form-control"></td>
            <td><button type="button" class="btn btn-danger btn-sm removeRow">Hapus</button></td>
        </tr>`;
        $('#finishingTable1 tbody').append(newRow);
        updateRowNumbers();
        applyInputStyle(row);
    });

    function updateRowNumbers() {
        $('#finishingTable1 tbody tr').each(function (index) {
            $(this).find('.row-number').text(index + 1);
        });
    }

    updateRowNumbers();
});

</script>


    </div>
</div>
<script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
<script>
    function applyInputStyle($row) {
    $row.find('input[type="text"]:not([readonly]), input[type="number"]:not([readonly])').each(function() {
        if ($(this).val().trim() !== '') {
            $(this).addClass('has-default-value').removeClass('no-default-value');
        } else {
            $(this).addClass('no-default-value').removeClass('has-default-value');
        }

        $(this).off('change.inputStyle').on('change.inputStyle', function() {
            if ($(this).val().trim() !== '') {
                $(this).addClass('has-default-value').removeClass('no-default-value');
            } else {
                $(this).addClass('no-default-value').removeClass('has-default-value');
            }
        });
    });
}

    // Event listener global untuk perhitungan Time/MP
    $(document).on('keyup change', 'input.calc-mp', function(){
        var $row = $(this).closest('tr');
        var target = $(this).data('target');
        var workingTime = parseFloat($row.find("input[name*='working_time']").val()) || 0;
        var manPower = parseFloat($row.find("input[name*='man_power']").val()) || 1;
        var result = workingTime / manPower;
        $row.find("input[name='"+target+"']").val(result);
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


    
    $("#addToolCost").click(function(){
        var row = `<tr>
                        <td class="row-number"></td>
                        <td><input type="text" name="tool_cost_process[]" class="form-control"></td>
                        <td><input type="text" name="tool_cost_tool[]" class="form-control"></td>
                        <td><input type="text" name="tool_cost_spec[]" class="form-control"></td>
                        <td><input type="number" name="tool_cost_qty[]" class="form-control"></td>
                        <td><button type="button" class="btn btn-danger btn-sm removeRow">Hapus</button></td>
                   </tr>`;
        $("#toolCostTable tbody").append(row);
        updateRowNumbers("toolCostTable");
    });
    
    $("#addAksesoris").click(function(){
    var row = `<tr>
        <td class="row-number"></td>
        <td style="position: relative;">
            <input type="text" name="aksesoris_part_list[]" class="form-control aksesoris-part-list" autocomplete="off">
            <div class="suggestions-dropdown aksesoris-partlist-suggestions"></div>
        </td>
        <td style="position: relative;">
            <input type="text" name="aksesoris_spec[]" class="form-control aksesoris-spec" autocomplete="off">
            <div class="suggestions-dropdown aksesoris-spec-suggestions"></div>
        </td>
        <td><input type="number" name="aksesoris_qty[]" class="form-control"></td>
        <td><button type="button" class="btn btn-danger btn-sm removeRow">Hapus</button></td>
    </tr>`;
    
    $("#aksesorisTable tbody").append(row);
    updateRowNumbers("aksesorisTable");
});

</script>
<script>
  
document.addEventListener('DOMContentLoaded', function() {
    var inputs = document.querySelectorAll('input[type="text"]:not([readonly]), input[type="number"]:not([readonly])');
    
    inputs.forEach(function(input) {
        if (input.value && input.value.trim() !== '') {
            input.classList.add('has-default-value');
        } else {
            input.classList.add('no-default-value');
        }
        
        input.addEventListener('change', function() {
            if (this.value && this.value.trim() !== '') {
                this.classList.remove('no-default-value');
                this.classList.add('has-default-value');
            } else {
                this.classList.remove('has-default-value');
                this.classList.add('no-default-value');
            }
        });
    });
});

</script>
<script>
    function hitungBerat($row) {
        let l = parseFloat($row.find('.mm-l').val()) || 0;
        let w = parseFloat($row.find('.mm-w').val()) || 0;
        let h = parseFloat($row.find('.mm-h').val()) || 0;
        let partList = ($row.find('.mm-part-list').val() || '').toLowerCase();
        let material = ($row.find('.mm-material-spec').val() || '').toLowerCase();

        let berat = '-';

        // CASES WITHOUT CALCULATION (set to "-")
        const tanpaBerat = [
            'frame', 'handle', 'body cf', 'bushing',
            'datum round pin', 'datum diamond pin', 'marking pin'
        ];
        if (tanpaBerat.includes(partList)) {
            berat = '-';
        }

        // HOOK CASE
        else if (partList === 'hook') {
            berat = ((l * w * w * 7.85) / 1000000) * 1.1; // +10%
        }

        // BASEPLATE
        else if (partList === 'baseplate') {
            if (material.includes('ss41')) {
                berat = (l * w * h * 0.00000785) + 0.1;
            } else if (material.includes('aluminium') || material.includes('aluminum')) {
                berat = (l * w * h / 1000000) * 2.7;
            }
        }

        // SECTION GAUGE
        else if (partList === 'section gauge') {
            berat = (l * w * h / 1000000) * 2.7;
        }

        // MATERIAL ALUMINIUM
        else if (material.includes('aluminium') || material.includes('aluminum')) {
            berat = (l * w * h / 1000000) * 2.7;
        }

        // DEFAULT CASE
        else {
            berat = (l * w * h * 0.00000785) + 0.1;
        }

        // SET VALUE
        $row.find('.mm-weight').val(
            typeof berat === 'number' ? berat.toFixed(1) : berat
        );
    }
    $('#mainMaterialTable').on('input', '.mm-part-list, .mm-material-spec, .mm-l, .mm-w, .mm-h', function () {
        let $row = $(this).closest('tr');
        hitungBerat($row);
    });

    $(document).ready(function () {
        $('#mainMaterialTable tbody tr').each(function () {
            hitungBerat($(this));
        });
    });
    document.getElementById('sketchInput').addEventListener('change', function(event) {
        const input = event.target;
        const preview = document.getElementById('sketchPreview');
        const file = input.files[0];

        if (file) {
        const reader = new FileReader();
        reader.onload = function(e) {
            preview.src = e.target.result;
            preview.style.display = 'block';
        }
        reader.readAsDataURL(file);
        } else {
        preview.src = '#';
        preview.style.display = 'none';
        }
    });
</script>
<?= $this->endSection() ?>
