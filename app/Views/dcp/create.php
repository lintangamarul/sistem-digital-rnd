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
                        <h4>Tambah DCP</h4>
                    </div>
                    <nav aria-label="breadcrumb" role="navigation">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item">
                                <a href="<?= site_url('actual-activity/personal'); ?>">Home</a>
                            </li>
                            <li class="breadcrumb-item"><a href="<?= site_url('pps'); ?>">PPS</a></li>
                            <li class="breadcrumb-item active" aria-current="page">
                                Form Tambah DCP
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
/* Input fields that have default values but are editable (not readonly) */
input[type="text"].has-default-value:not([readonly]),
input[type="number"].has-default-value:not([readonly]) {
    background-color: #e8f4ff; 
    border-left: 3px solid #4dabf7; 
}

/* Input fields that don't have default values */
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
            <h2 class="mt-3 text-center mb-3">DCP Data Form </h2>
            
            <!-- Step Wizard Navigation -->
            <ul class="nav nav-tabs step-wizard justify-content-center" id="stepWizard" role="tablist">
                <li class="nav-item">
                    <a class="nav-link active" id="overview-tab" data-toggle="tab" href="#step1" role="tab">Overview</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" id="design-tab" data-toggle="tab" href="#step2" role="tab">Design & Program</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" id="poly-tab" data-toggle="tab" href="#step3" role="tab">Poly</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" id="mainmat-tab" data-toggle="tab" href="#step4" role="tab">Main Material</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" id="stdpart-tab" data-toggle="tab" href="#step5" role="tab">Standard Part</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" id="machining-tab" data-toggle="tab" href="#step6" role="tab">Machining</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" id="finishing-tab" data-toggle="tab" href="#step7" role="tab">Finishing</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" id="heattab-tab" data-toggle="tab" href="#step8" role="tab">Heat Treatment</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" id="diespot-tab" data-toggle="tab" href="#step9" role="tab">Die Spot & Try</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" id="toolcost-tab" data-toggle="tab" href="#step10" role="tab">Tool Cost</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" id="aksesoris-tab" data-toggle="tab" href="#step11" role="tab">Aksesoris</a>
                </li>
            </ul>
            
         
            <form action="<?= site_url('dcp/store'); ?>" method="post" enctype="multipart/form-data" id="dcpForm" novalidate>
            <input type="hidden" name="pps" value="<?= isset($pps['id']) ? $pps['id'] : '' ?>">
                <input type="hidden" name="pps_dies" value="<?= isset($ppsDies['id']) ? $ppsDies['id'] : '' ?>">
                <!-- <input type="hidden" name="op_before" value="<?= isset($ppsDies[0]['id']) ? $ppsDiesId[0]['id'] : '' ?>">
                <input type="hidden" name="op_after" value="<?= isset($ppsDiesId[1]['id']) ? $ppsDiesId[1]['id'] : '' ?>"> -->
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
                                        <label>Customer</label>
                                        <input type="text" class="form-control" readonly value="<?= isset($pps['cust']) ? $pps['cust'] : '' ?>" name="cust">
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label>Part No</label>
                                        <input type="text" class="form-control" readonly value="<?= isset($pps['part_no']) ? $pps['part_no'] : '' ?>" name="part_no">
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label>Die Process</label>
                                        <?php 
                                        $dieProcess = '';
                                        if(isset($ppsDies['process'])) $dieProcess .= $ppsDies['process'];
                                        if(!empty($ppsDies['process_join'])) $dieProcess .= ',' . $ppsDies['process_join'];
                                        if(isset($ppsDies['proses'])) $dieProcess .= '-' . $ppsDies['proses'];
                                        ?>
                                        <input type="text" class="form-control" readonly value="<?= $dieProcess ?>" name="die_process">
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label>Die Dimension</label>
                                        <?php 
                                        $dieDimension = '';
                                        if(isset($ppsDies['die_length'])) $dieDimension .= $ppsDies['die_length'];
                                        $dieDimension .= ' x ';
                                        if(isset($ppsDies['die_width'])) $dieDimension .= $ppsDies['die_width'];
                                        $dieDimension .= ' x ';
                                        if(isset($ppsDies['die_height'])) $dieDimension .= $ppsDies['die_height'];
                                        ?>
                                        <input type="text" class="form-control" readonly value="<?= $dieDimension ?>" name="die_dimension">
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label>Weight</label>
                                        <input type="text" class="form-control" readonly value="<?= isset($ppsDies['die_weight']) ? $ppsDies['die_weight'] : '' ?>" name="die_weight">
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label>Class</label>
                                        <input type="text" class="form-control" readonly value="<?= isset($ppsDies['class']) ? $ppsDies['class'] : '' ?>" name="class">
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label>Sketch (Upload Gambar)</label>
                                        <input type="file" class="form-control-file" name="sketch" id="sketchInput" accept=".png, .jpg, .jpeg">
                                        
                                        <!-- Preview gambar akan muncul di sini -->
                                        <div class="mt-2">
                                        <img id="sketchPreview" src="#" alt="Preview Sketch" style="display: none; max-width: 100%; height: auto;" class="img-thumbnail">
                                        </div>
                                    </div>
                                    </div>

                                    <script>
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

                                
                            </div>
                        </div>
                        <div class="text-right">
                            <button type="button" class="btn btn-step btn-primary next-step">Next</button>
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
                                            <!-- <th>Time/MP</th> -->
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
                                            <td><input type="number" name="design_working_time" class="form-control calc-mp" data-target="design_mp_time" value="<?php echo isset($designRow['hour']) ? $designRow['hour'] : '' ?>"></td>
                                            <!-- <td><input  type="number" name="design_mp_time" class="form-control" readonly></td> -->
                                        </tr>
                                        <!-- Baris 2: Programming -->
                                        <tr>
                                            <td class="row-number">2</td>
                                            <td>
                                                <input type="text" class="form-control" value="Programming" readonly>
                                            </td>
                                            <td><input type="number" name="prog_man_power" class="form-control calc-mp" data-target="prog_mp_time" value="1"></td>
                                            <td><input type="number" name="prog_working_time" class="form-control calc-mp" data-target="prog_mp_time" value="<?php echo isset($cadCamRow['hour']) ? $cadCamRow['hour'] : '' ?>"></td>
                                            <!-- <td><input type="number" name="prog_mp_time" class="form-control" readonly></td> -->
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
                    
                    <!-- Step 3: Poly -->
                    <div class="tab-pane fade" id="step3" role="tabpanel">
                        <div class="segment">
                            <h4>Segment Poly</h4>
                            <div class="table-responsive">
                                <table class="table table-bordered table-input">
                                    <thead>
                                        <tr>
                                            <th>No</th>
                                            <th>Partlist</th>
                                            <th>Material / Spec</th>
                                            <th>Size / Type</th>
                                            <th>Qty (PCS)</th>
                                            <th>Weight (KG)</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php 
                                        $defaultPoly = [
                                            [
                                                'poly_partlist' => 'FMC/PATTERN',
                                                'poly_material' => 'STYROFOAM'
                                            ],
                                            [
                                                'poly_partlist' => 'FOAM GLUEM',
                                                'poly_material' => 'EVERLAST'
                                            ]
                                        ];
                                        $dieWeightExploded = ['', '', ''];
                                        if (!empty($ppsDies['die_weight'])) {
                                            $dieWeightExploded = explode('x', $ppsDies['die_weight']);
                                            $dieWeightExploded = array_pad($dieWeightExploded, 3, '');
                                        }
                                        if (!empty($poly) && is_array($poly)) : 
                                            foreach ($poly as $i => $row) : ?>
                                                <tr>
                                                    <td class="row-number"><?= $i + 1 ?></td>
                                                    <td>
                                                        <input type="text" name="poly_partlist[]" class="form-control" value="<?= esc($row['poly_partlist']) ?>" readonly>
                                                </td>
                                                    <td>
                                                        <input type="text" name="poly_material[]" class="form-control" value="<?= esc($row['poly_material']) ?>" readonly>
                                                    </td>
                                                    <td>
                                                        <div class="d-flex gap-1">
                                                            <input type="text" name="poly_size_type_l[]" class="form-control form-control-sm mr-1 mb-1"  style="width: 60px;" value="<?= esc($ppsDies['die_length']) ?>" placeholder="L">
                                                            <input type="text" name="poly_size_type_w[]" class="form-control form-control-sm  mr-1 mb-1" style="width: 60px;" value="<?= esc($ppsDies['die_width']) ?>" placeholder="W">
                                                            <input type="text" name="poly_size_type_h[]" class="form-control form-control-sm mb-1" style="width: 60px;" value="<?= esc($ppsDies['die_height']) ?>" placeholder="H">
                                                        </div>
                                                    </td>

                                                    <td>
                                                        <input type="number" name="poly_qty[]" class="form-control" value="<?= esc($row['poly_qty']) ?>">
                                                    </td>
                                                    <td>
                                                        <input type="number" name="poly_weight[]" class="form-control" value="<?= esc($row['poly_weight']) ?>">
                                                    </td>
                                                </tr>
                                            <?php endforeach;
                                            
                                            $existingCount = count($poly);
                                            for ($j = $existingCount; $j < count($defaultPoly); $j++): 
                                                $no = $j + 1; 
                                                $defaultRow = $defaultPoly[$j];
                                            ?>
                                                <tr>
                                                    <td class="row-number"><?= $no ?></td>
                                                    <td>
                                                        <input type="text" name="poly_partlist[]" class="form-control" value="<?= esc($defaultRow['poly_partlist']) ?>" readonly>
                                                    </td>
                                                    <td>
                                                        <input type="text" name="poly_material[]" class="form-control" value="<?= esc($defaultRow['poly_material']) ?>" readonly>
                                                    </td>
                                                    <td>
                                                        <input type="text" name="poly_size_type_l[]" class="form-control form-control-sm mr-1 mb-1" style="width: 60px; display: inline-block;" value="<?= esc($ppsDies['die_length']) ?>" placeholder="L">
                                                        <input type="text" name="poly_size_type_w[]" class="form-control form-control-sm mr-1 mb-1" style="width: 60px; display: inline-block;" value="<?= esc($ppsDies['die_width']) ?>" placeholder="W">
                                                        <input type="text" name="poly_size_type_h[]" class="form-control form-control-sm mb-1" style="width: 60px; display: inline-block;" value="<?= esc($ppsDies['die_height']) ?>" placeholder="H">
                                                    </td>

                                                    <td>
                                                        <input type="number" name="poly_qty[]" class="form-control" placeholder="Input Qty" value="1">
                                                    </td>
                                                    <td>
                                                        <input type="number" name="poly_weight[]" class="form-control" placeholder="Input Weight"
                                                            value="<?php 
                                                                if ($i == 0) {
                                                                    echo $weight_poly;
                                                                } elseif ($i == 1) {
                                                                    echo $weight_foam;
                                                                }
                                                            ?>">
                                                    </td>

                                                </tr>
                                            <?php endfor;
                                        else: 
                                            foreach ($defaultPoly as $i => $defaultRow): 
                                                $no = $i + 1;
                                            ?>
                                                <tr>
                                                    <td class="row-number"><?= $no ?></td>
                                                    <td>
                                                        <input type="text" name="poly_partlist[]" class="form-control" value="<?= esc($defaultRow['poly_partlist']) ?>" readonly>
                                                    </td>
                                                    <td>
                                                        <input type="text" name="poly_material[]" class="form-control" value="<?= esc($defaultRow['poly_material']) ?>" readonly>
                                                    </td>
                                                    <td>
                                                        <input type="text" name="poly_size_type_l[]" class="form-control form-control-sm mr-1 mb-1" style="width: 60px; display: inline-block;" value="<?= esc($ppsDies['die_length']) ?>" placeholder="L">
                                                        <input type="text" name="poly_size_type_w[]" class="form-control form-control-sm mr-1 mb-1" style="width: 60px; display: inline-block;" value="<?= esc($ppsDies['die_width']) ?>" placeholder="W">
                                                        <input type="text" name="poly_size_type_h[]" class="form-control form-control-sm  mb-1" style="width: 60px; display: inline-block;" value="<?= esc($ppsDies['die_height']) ?>" placeholder="H">
                                                    </td>

                                                    <td>
                                                        <input type="number" name="poly_qty[]" class="form-control" placeholder="Input Qty"  value="1">
                                                    </td>
                                                    <td>
                                                        <input type="number" name="poly_weight[]" class="form-control" placeholder="Input Weight"
                                                            value="<?php 
                                                                if ($i == 0) {
                                                                    echo $weight_poly;
                                                                } elseif ($i == 1) {
                                                                    echo $weight_foam;
                                                                }
                                                            ?>">
                                                    </td>
                                                </tr>
                                            <?php endforeach;
                                        endif; 
                                        ?>
                                    </tbody>
                                </table>
                                <table class="table table-bordered table-input">
                                    <thead>
                                        <tr>
                                            <th>No</th>
                                            <th>Process</th>
                                            <th>Man Power</th>
                                            <th>Working Time</th>
                                    
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td><input type="text" name="no[]" class="form-control" value="1" readonly></td>
                                            <td><input type="text" name="process_poly[]" class="form-control" value="Pattern" readonly></td>
                                            <td><input type="number" name="man_power[]" class="form-control" value="1"></td>
                                            <td><input type="text" name="working_time[]" class="form-control" value="<?= isset($polyRow['hour']) ? $polyRow['hour'] : '' ?>">
                                            </td>
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

                    
                    <!-- Step 4: Main Material -->
                    <?php
                        $parts = [
                            "BASE LOWER",
                            "BASE UPPER",
                            "PAD",
                            "INSERT",
                            "HOOK",
                            "HOOK L",
                            "BACKUP INSERT LOWER",
                            "BACKUP INSERT UPPER",
                            "BACKUP GUIDE POST",
                            "BACKUP END BLOCK",
                            "BOX PART & SCRAP",
                            "STOPPER PLATE",
                            "BACKUP SCRAP CUTTER",
                            "BACKUP SLIDE",
                            "SCRAP CUTTER"
                        ];
                        ?>

                        <div class="tab-pane fade" id="step4" role="tabpanel">
                            <div class="segment">
                                <h4>Segment Main Material</h4>
                                <div class="table-responsive">
                                <table class="table table-bordered table-input" id="mainMaterialTable">
                                    <thead>
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
                                        <?php foreach ($parts as $index => $part): ?>
                                            <tr>
                                                <td class="row-number"><?= $index + 1 ?></td>
                                                <td style="position: relative;">
                                                    <input type="text" name="mm_part_list[]" class="form-control mm-part-list" value="<?= $part ?>">
                                                    <div class="suggestions-dropdown partlist-suggestions"></div>
                                                </td>
                                                <td style="position: relative;">
                                            <?php 
                                        $materialSpec = '';

                                        if (strpos($part, 'LOWER') !== false && $part !== 'BACKUP INSERT LOWER') {
                                            $materialSpec = $ppsDies['lower']; 
                                        } elseif (strpos($part, 'UPPER') !== false && $part !== 'BACKUP INSERT UPPER') {
                                            $materialSpec = $ppsDies['upper']; 
                                        } else {
                                            $materialSpec = '';
                                        }
                                        
                                        ?>                    
                                            <input type="text" name="mm_material_spec[]" class="form-control mm-material-spec" value="<?= $materialSpec ?>"> 
                                            <div class="suggestions-dropdown materialspec-suggestions"></div>
                                        </td>
                                                <td>
                                                    <div class="d-flex gap-1">
                                                        <input type="text" name="mm_size_type_l[]" class="form-control form-control-sm mm-l mr-1 mb-1" placeholder="L" style="width: 60px;">
                                                        <input type="text" name="mm_size_type_w[]" class="form-control form-control-sm mm-w mr-1  mb-1" placeholder="W" style="width: 60px;">
                                                        <input type="text" name="mm_size_type_h[]" class="form-control form-control-sm mm-h  mb-1" placeholder="H" style="width: 60px;">
                                                    </div>
                                                </td>
                                                <td><input type="number" name="mm_qty[]" class="form-control"></td>
                                                <td>
                                                    <input type="number" name="mm_weight[]" class="form-control mm-weight" placeholder="Auto" readonly>
                                                </td>
                                                <td><button type="button" class="btn btn-danger btn-sm removeRow">Hapus</button></td>
                                            </tr>
                                        <?php endforeach; ?>
                                    </tbody>
                                </table>
                                <button type="button" id="addMainMaterial" class="btn btn-primary btn-sm mb-3">Tambah Baris</button>
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
                                        <tr>
                                            <td class="row-number">1</td>
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
                                        </tr>
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
                    
                    <!-- Step 6: Machining -->
                    <div class="tab-pane fade" id="step6" role="tabpanel">
                        <div class="segment">
                            <h4>Segment Machining</h4>
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
                                            <td><input type="number" name="machining_working_time[]" class="form-control calc-mp" data-target="machining_mp_time1"  value="16"></td>
                                            <!-- <td><input type="number" name="machining_mp_time[]" class="form-control" readonly></td> -->
                                        </tr>
                                        <tr>
                                            <td class="row-number">2</td>
                                            <td>
                                                <input type="text" name="machining_process[]" class="form-control" value="FABRICATION" readonly>
                                            </td>
                                            <td><input type="number" name="machining_man_power[]" class="form-control calc-mp" data-target="machining_mp_time2"  value="2"></td>
                                            <td><input type="number" name="machining_working_time[]" class="form-control calc-mp" data-target="machining_mp_time2"  value="8"></td>
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
                                            <th>Satuan (H)</th>
                                            <!-- <th>Price / H</th>
                                            <th>Cost</th> -->
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php 
                                        $processes = [
                                            "MACHINING", "MACHINING", "MACHINING", "MACHINING", "MACHINING", "MACHINING",
                                            "MACHINING", "MACHINING", "MACHINING", "MACHINING", "MACHINING",
                                            "WELDING", "MEASURING", "FABRICATION"
                                        ];
                                        $machines = [
                                            "CNC MILING RB 5 (5 AXIS)", "CNC MILING RB 3 (5 AXIS)", "CNC MILING HF3", "CNC MILING RB 2", "COPY MILLING KAFO",
                                            "MAKINO CNC", "SURFACE GRINDING", "MILLING NANTONG", "RADIAL DRILLING ZQ 3070",
                                            "WIRE CUTTING/ SODICK", "TURNING", "NATIONAL 300 AMPERE", "FARO CMM", "BLANDER BEAVER"
                                        ];
                                        $startNo = 3;
                                        
                                        $defaultHRows = [1,2,3,4,5,6, 7, 8,9, 10,11, 13,14,15];
                                        $defaultMm2Row = [12];

                                        foreach($processes as $index => $proc): 
                                            $no = $startNo + $index;

                                            if (in_array($no, $defaultHRows)) {
                                                $defaultValue = "H";
                                            } elseif (in_array($no, $defaultMm2Row)) {
                                                $defaultValue = "mm²";
                                            } else {
                                                $defaultValue = "";
                                            }
                                        ?>
                                        <tr>
                                            <td class="row-number"><?= $no ?></td>
                                            <td>
                                                <input type="text" name="machining_proc[]" class="form-control" value="<?= $proc ?>" readonly>
                                            </td>
                                            <td>
                                                <input type="text" name="machining_kom[]" class="form-control" value="<?= isset($machines[$index]) ? $machines[$index] : '' ?>" readonly>
                                            </td>
                                            <td><input type="number" name="machining_lead_time[]" class="form-control"></td>
                                            <td><input type="text" name="machining_lead_time_h[]" class="form-control" value="<?= $defaultValue ?>" readonly></td>
                                        </tr>
                                
                                        <?php endforeach; ?>
                                            <tr>
                                                <td colspan="3" class="text-right font-weight-bold">Total Lead Time (Selected Rows)</td>
                                                <td><input type="number" id="totalLeadTime" class="form-control" readonly value="<?= $hoursMachining ?>">
                                                    <div class="mt-2">
                                                        <strong>Max :</strong>
                                                        <span id="machiningHoursLabel"><?= $hoursMachining ?></span> hours
                                                    </div>
                                                </td>
                                            
                                            </tr>
                                    
                                    </tbody>

                                </table>
                            </div>
                            <!-- <div class="mt-2">
                                <strong>Total Machining Hours (from DB):</strong>
                                <span id="machiningHoursLabel"><?= $hoursMachining ?></span> hours
                            </div> -->

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
                                        <?php if (isset($finishing) && is_array($finishing) && count($finishing) > 0): ?>
                                            <?php foreach ($finishing as $i => $row): ?>
                                            <tr>
                                                <td class="row-number"><?= $i + 1 ?></td>
                                                <td>
                                                    <input type="text" name="finishing_part_list[]" class="form-control" value="<?= esc($row['part_list'] ?? '') ?>" readonly>
                                                </td>
                                                <td>
                                                    <input type="text" name="finishing_material_spec[]" class="form-control" value="<?= esc($row['material'] ?? '') ?>" readonly>
                                                </td>
                                                <td>
                                                    <input type="text" name="finishing_size_type[]" class="form-control" value="<?= esc($row['diameter'] ?? '') ?>" readonly>
                                                </td>
                                                <td>
                                                    <input type="text" name="finishing_qty[]" class="form-control" value="<?= esc($row['qty'] ?? '') ?>" readonly>
                                                </td>
                                                <td>
                                                    <button type="button" class="btn btn-danger btn-sm removeRow">Hapus</button>
                                                </td>
                                            </tr>
                                            <?php endforeach; ?>
                                        <?php else: ?>
                                            <tr>
                                                <td class="row-number">1</td>
                                                <td><input type="text" name="finishing_part_list[]" class="form-control"></td>
                                                <td><input type="text" name="finishing_material_spec[]" class="form-control"></td>
                                                <td><input type="text" name="finishing_size_type[]" class="form-control"></td>
                                                <td><input type="number" name="finishing_qty[]" class="form-control"></td>
                                                <td><button type="button" class="btn btn-danger btn-sm removeRow">Hapus</button></td>
                                            </tr>
                                        <?php endif; ?>
                                    </tbody>

                                </table>
                            </div>
                            <button type="button" id="addRowFinishing" class="btn btn-primary btn-sm mb-3">Tambah Baris</button>
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
                                        <input type="number" name="finishing_lead_time[]" class="form-control" value="<?= isset($finishingLeadTimeParts[0]) ? $finishingLeadTimeParts[0] : '' ?>">
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
                                                <input type="text" name="finishing_process3[]" class="form-control" value="Finishing 1" readonly>
                                            </td>
                                            <td><input type="number" name="finishing_mp[]" class="form-control calc-mp" data-target="finishing_mp_time1" value="1"></td>
                                            <td>
                                        <input type="number" name="finishing_working_time[]" class="form-control calc-mp" data-target="finishing_mp_time1" value="<?= isset($finishingLeadTimeParts[1]) ? $finishingLeadTimeParts[1] : '' ?>">
                                    </td>

                                            <!-- <td><input type="number" name="finishing_mp_time[]" id="finishing_mp_time1" class="form-control" readonly></td> -->
                                        </tr>
                                        <tr>
                                            <td>
                                                <input type="text" class="form-control" name="finishing_process3[]" value="Finishing 2" readonly>
                                            </td>
                                            <td><input type="number" name="finishing_mp[]" class="form-control calc-mp" data-target="finishing_mp_time2"></td>
                                            <td><input type="number" name="finishing_working_time[]" class="form-control calc-mp" data-target="finishing_mp_time2"></td>
                                            <!-- <td><input type="number" name="finishing_mp_time[]" id="finishing_mp_time2" class="form-control" readonly></td> -->
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                            <?php if (!empty($finishingRow) && isset($finishingRow['hour'])): ?>
                                <div class="mb-3">
                                    <label>Nilai Maksimal Finishing Hour + Die Spot & Try:</label>
                                    <span class="fw-bold text-primary"><?= $finishingRow['hour'] ?> jam</span>
                                </div>
                            <?php endif; ?>
                            <script>
                            // document.addEventListener("DOMContentLoaded", function () {
                            //     document.querySelectorAll(".calc-mp").forEach(input => {
                            //         input.addEventListener("input", function () {
                            //             let row = this.closest("tr");
                            //             let mp = row.querySelector("input[name='finishing_mp[]']").value;
                            //             let time = row.querySelector("input[name='finishing_working_time[]']").value;
                            //             let targetId = row.querySelector("input[name='finishing_mp_time[]']").id;

                            //             if (mp && time && mp > 0) {
                            //                 document.getElementById(targetId).value = (time / mp).toFixed(2);
                            //             } else {
                            //                 document.getElementById(targetId).value = "";
                            //             }
                            //         });
                            //     });
                            // });
                            </script>

                        </div>
                        <div class="d-flex justify-content-between">
                            <button type="button" class="btn btn-step btn-secondary prev-step">Previous</button>
                            <button type="button" class="btn btn-step btn-primary next-step">Next</button>
                        </div>
                    </div>
                    
                    <!-- Step 8: Heat Treatment -->
                    <div class="tab-pane fade" id="step8" role="tabpanel">
                        <div class="segment">
                            <h4>Segment Heat Treatment</h4>
                            <div class="table-responsive">
                                <table class="table table-bordered table-input">
                                    <thead>
                                        <tr>
                                            <th>No</th>
                                            <th>Process</th>
                                            <th>Kind of Machine</th>
                                            <th>Weight (KG)</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php 
                                        $heatProcesses = ["HARDENING", "HARDENING", "HARDENING"];
                                        $heatMachines  = ["TD (COATING)", "NABER N.321 (FULL HARD)", "O2 & ACYTILENE (FLAME)"];
                                        foreach($heatProcesses as $i => $proc):
                                        ?>
                                        <tr>
                                            <td class="row-number"><?= $i+1 ?></td>
                                            <td>
                                                <input type="text" name="heat_process[]"  class="form-control" value="<?= $proc ?>" readonly>
                                            </td>
                                            <td>
                                                <input type="text" name="heat_machine[]" class="form-control" value="<?= $heatMachines[$i] ?>" readonly>
                                            </td>
                                            <td><input type="number" name="heat_weight[]" class="form-control"></td>
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
                    
                    <!-- Step 9: Die Spot & Try -->
                    <div class="tab-pane fade" id="step9" role="tabpanel">
                        <div class="segment">
                            <h4>Segment Die Spot & Try</h4>
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
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php 
                                    $dieSpotData = [
                                        ['PARAFIN', 'SHEET WAX', '1'],
                                        ['SANDING', 'SHEET', '1'],
                                        ['MATERIAL BLANK SIZE', '-', ''],
                                        ['FITTING', 'AKAI PAINT', '1']
                                    ];
                                    foreach($dieSpotData as $i => $row):
                                    ?>
                                    <tr>
                                        <td class="row-number"><?= $i+1 ?></td>
                                        <td>
                                            <input type="text" class="form-control" name="die_spot_part_list[]" value="<?= $row[0] ?>" readonly>
                                        </td>
                                        <td>
                                            <input type="text" class="form-control"  name="die_spot_material[]" value="<?= $row[1] ?>" >
                                        </td>
                                        <td>
                                            <input type="text" class="form-control"  name="die_spot_qty[]"  value="<?= $row[2] ?>" >
                                        </td>
                                        <td><input type="number" name="die_spot_weight[]" class="form-control"></td>
                                    </tr>
                                    <?php endforeach; ?>
                                </tbody>
                            </table>
                            </div>
                            <!-- Tabel 2 -->
                            <?php 
                                $dieSpotProcess = [
                                    ['DIE SPOTTING', '', '32'], 
                                    ['TRY OUT', '', '32']
                                ];

                                $machineOptions = [
                                    'PRESS M/C 1000 T',
                        
                                    'PRESS M/C 350 T',
                                    'PRESS M/C 150 T',
                                    'PRESS M/C 110 T',
                                    'PRESS M/C 80 T',
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
                                        <?php foreach($dieSpotProcess as $i => $row): ?>
                                        <tr>
                                            <td class="row-number"><?= $i+5 ?></td>
                                            <td>
                                            <input type="text" class="form-control" name="die_spot_process[]" value="<?= esc($row[0]) ?>" readonly>
                                            </td>
                                            <td>
                                            <select name="die_spot_kom[]" class="form-control">
                                                <option value="">-- Pilih --</option>
                                                <?php foreach($machineOptions as $opt): ?>
                                                <option value="<?= esc($opt) ?>" <?= $row[1] === $opt ? 'selected' : '' ?>><?= esc($opt) ?></option>
                                                <?php endforeach; ?>
                                            </select>
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
                                        $dieSpotProcess2 = ['DIE SPOTTING', 'TRY OUT', 'QUALITY CHECK'];
                                        foreach($dieSpotProcess2 as $i => $proc):
                                        ?>
                                        <tr>
                                            <td class="row-number"><?= $i+7 ?></td>
                                            <td>
                                                <input type="text" name="die_spot_process[]" class="form-control" value="<?= $proc ?>" readonly>
                                            </td>
                                            <td><input type="number" name="die_spot_mp[]" class="form-control calc-die-spot" data-target="die_spot_mp_time<?= $i ?>"></td>
                                            <td>
                                                <input type="number" name="die_spot_working_time[]" class="form-control calc-die-spot"
                                                    data-target="die_spot_mp_time<?= $i ?>" 
                                                    value="<?= isset($finishingLeadTimeParts[$i+2]) ? $finishingLeadTimeParts[$i+2] : '' ?>">
                                            </td>

                                            <!-- <td><input type="number" name="die_spot_mp_time[]" id="die_spot_mp_time<?= $i ?>" class="form-control" readonly></td> -->
                                        </tr>
                                        <?php endforeach; ?>
                                    </tbody>
                                </table>
                            </div>
                            <?php if (!empty($finishingRow) && isset($finishingRow['hour'])): ?>
                                <div class="mb-3">
                                    <label>Nilai Maksimal Finishing Hour + Die Spot & Try:</label>
                                    <span class="fw-bold text-primary"><?= $finishingRow['hour'] ?> jam</span>
                                </div>
                            <?php endif; ?>
                            <script>
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
                            </script>
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
                                                    <input type="text" name="tool_cost_process[]" class="form-control" value="<?= esc($row['spec_cutter'] ?? '') ?>" readonly>
                                                </td>
                                                <td>
                                                    <input type="text" name="tool_cost_tool[]" class="form-control" value="<?= esc($row['diameter'] ?? '') ?>" readonly>
                                                </td>
                                                <td>
                                                    <input type="text" name="tool_cost_spec[]" class="form-control" value="<?= esc($row['jenis_chip'] ?? '') ?>" readonly>
                                                </td>
                                                <td>
                                                    <input type="number" name="tool_cost_qty[]" class="form-control" value="<?= esc($row['kebutuhan_chip'] ?? '') ?>" >
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
                                            "CORD CONNECTOR",
                                            "CONNECTOR CABLE",
                                            "CABLE SHOES",
                                            "C A B L E",
                                            "CABLE CLAMP",
                                            "P/URETHANE  TUBE",
                                            "UNION  TEE",
                                            "AIR SPEED CONTROL",
                                            "AIR HOSE NIPPLE",
                                            "MALE CONNECTOR",
                                            "MALE ELBOW",
                                            "AIR HEAD BRACKET",
                                            "RECEPTACLE",
                                            "TERMINAL",
                                            "TERMINAL BOX",
                                            "A N T E N A"
                                        ];

                                        $specs = [
                                            "MISUMI / OA 1",
                                            "TMS / D - NCLS - 1991",
                                            "MISUMI / BVF 125 - 3 RE",
                                            "MISUMI / VCTP-1,25 x 2 - 4",
                                            "TMS / D - CCL - A - 2",
                                            "SMC / TU - 10 - 6,5",
                                            "SMC / KQT 10 - 100",
                                            "SMC / AS - 4000",
                                            "NITTO / 30 PM",
                                            "SMC / KQH 10 - 02 S",
                                            "SMC / KQL 10 - 02 - S",
                                            "MISUMI / TAHK - D - 2",
                                            "MISUMI  / NSC 40-8 R",
                                            "MISUMI / ML-15-12P",
                                            "TMS / D - TBX -D1",
                                            "OMRON / WLHAL 5"
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
                                                <td><input type="number" name="aksesoris_qty[]" class="form-control" value="1"></td>
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
                            <button type="submit" class="btn btn-step btn-success">Simpan Data DCP</button>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>

<script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
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
<?php
$filteredPartList = array_filter(array_unique(array_column($mainMaterial, 'mm_part_list')), function($item) {
    return !empty($item);
});

$filteredMaterialSpec = array_filter(array_unique(array_column($mainMaterial, 'mm_material_spec')), function($item) {
    return !empty($item);
});
?>

<script>
const mmPartList = <?= json_encode(array_values($filteredPartList)); ?>;
const mmMaterialSpec = <?= json_encode(array_values($filteredMaterialSpec)); ?>;
</script>
<script>
const spPartList = <?= json_encode(array_values($spPartList)) ?>;
const spMaterialSpec = <?= json_encode(array_values($spMaterialSpec)) ?>;
const aksesorisPartList = <?= json_encode(array_values($aksesorisPartList)) ?>;
const aksesorisSpec = <?= json_encode(array_values($aksesorisSpec)) ?>;

function applySuggestion(inputClass, dropdownClass, dataArray) {
    $(document).on('input', inputClass, function () {
        const $input = $(this);
        const val = $input.val().toLowerCase();
        const $dropdown = $input.siblings(dropdownClass);
        $dropdown.empty();

        if (val.length === 0) {
            $dropdown.hide();
            return;
        }

        const filtered = dataArray.filter(item => item.toLowerCase().includes(val));
        if (filtered.length > 0) {
            filtered.forEach(item => {
                $dropdown.append(`<div class="suggestion-item">${item}</div>`);
            });
            $dropdown.show();
        } else {
            $dropdown.hide();
        }
    });
    $(document).on('click', dropdownClass + ' .suggestion-item', function () {
        const selected = $(this).text();
        const $input = $(this).closest('td').find(inputClass);
        $input.val(selected);
        $(this).parent().hide();
    });

    $(document).on('click', function (e) {
        if (!$(e.target).closest(inputClass).length && !$(e.target).closest(dropdownClass).length) {
            $(dropdownClass).hide();
        }
    });
}

applySuggestion('.sp-part-list', '.sp-partlist-suggestions', spPartList);
applySuggestion('.sp-material-spec', '.sp-materialspec-suggestions', spMaterialSpec);
</script>

<script>
   
console.log(mmPartList);
    function applySuggestion(inputSelector, dropdownSelector, dataArray) {
        $(document).on('input', inputSelector, function () {
            const input = $(this);
            const val = input.val().toLowerCase();
            const dropdown = input.siblings(dropdownSelector);
            dropdown.empty();

            if (val.length === 0) {
                dropdown.hide();
                return;
            }

            const filtered = dataArray.filter(item => item.toLowerCase().includes(val));
            if (filtered.length > 0) {
                filtered.forEach(item => {
                    dropdown.append('<div class="suggestion-item">' + item + '</div>');
                });
                dropdown.show();
            } else {
                dropdown.hide();
            }
        });

        $(document).on('click', dropdownSelector + ' .suggestion-item', function () {
            const selected = $(this).text();
            const input = $(this).closest('td').find(inputSelector);
            input.val(selected);
            $(this).parent().hide();
        });

       
        $(document).on('click', function (e) {
            if (!$(e.target).closest(inputSelector).length && !$(e.target).closest(dropdownSelector).length) {
                $(dropdownSelector).hide();
            }
        });
    }

    $(document).ready(function () {
        applySuggestion('.mm-part-list', '.partlist-suggestions', mmPartList);
        applySuggestion('.mm-material-spec', '.materialspec-suggestions', mmMaterialSpec);
        applySuggestion('.aksesoris-part-list', '.aksesoris-partlist-suggestions', aksesorisPartList);
applySuggestion('.aksesoris-spec', '.aksesoris-spec-suggestions', aksesorisSpec);
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
                    <input type="text" name="mm_size_type_l[]" class="form-control form-control-sm mm-l mr-1" placeholder="L" style="width: 60px;">
                    <input type="text" name="mm_size_type_w[]" class="form-control form-control-sm mm-w mr-1" placeholder="W" style="width: 60px;">
                    <input type="text" name="mm_size_type_h[]" class="form-control form-control-sm mm-h" placeholder="H" style="width: 60px;">
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
    

    $(document).on('keyup change', 'input.calc-mp', function(){
        var $row = $(this).closest('tr');
        var target = $(this).data('target');
        var workingTime = parseFloat($row.find("input[name*='working_time']").val()) || 0;
        var manPower = parseFloat($row.find("input[name*='man_power']").val()) || 1;
        var result = workingTime / manPower;
        $row.find("input[name='"+target+"']").val(result);
    });
    $(document).ready(function () {
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
    document.addEventListener("DOMContentLoaded", function () {
    let hoursMachining = parseFloat("<?= $hoursMachining ?? 0 ?>");
    const leadTimeInputs = document.querySelectorAll('input[name="machining_lead_time[]"]');
    const totalLeadTimeInput = document.getElementById("totalLeadTime");
    
    const calculationMap = {
        1: 0.7,
        4: 0.1,
        5: 0.0667,
        7: 0.0667,
        11: 0.0667
    };
    
    const defaultRowsToSum = [1, 2, 3, 4, 5, 6, 8]; 
    
    const excludeRows = [7, 9, 10, 11, 12, 13, 14];
    
    function updateTotalLeadTime() {
        let total = 0;
        
        leadTimeInputs.forEach((input, index) => {
            if (defaultRowsToSum.includes(index + 1) && !excludeRows.includes(index + 1)) {
                if (input && !isNaN(parseFloat(input.value))) {
                    total += parseFloat(input.value);
                }
            }
        });
        
        if (totalLeadTimeInput) {
            totalLeadTimeInput.value = total.toFixed(1);
        }
    }
    
    leadTimeInputs.forEach((input, index) => {
        // Uncomment this if you want to use the calculation map
        // if (calculationMap.hasOwnProperty(index + 1)) {
        //     let result = hoursMachining * calculationMap[index + 1];
        //     input.value = parseFloat(result.toFixed(1));
        // }
        
        if (defaultRowsToSum.includes(index + 1)) {
            input.addEventListener('input', updateTotalLeadTime);
        }
    });
    
    updateTotalLeadTime();
});
    function hitungBerat($row) {
    let l = parseFloat($row.find('.mm-l').val()) || 0;
    let w = parseFloat($row.find('.mm-w').val()) || 0;
    let h = parseFloat($row.find('.mm-h').val()) || 0;

    let berat = l * w * h * 0.00000785;
    $row.find('.mm-weight').val(berat.toFixed(1)); // 4 desimal
}

$(document).on('input', '.mm-l, .mm-w, .mm-h', function () {
    let $row = $(this).closest('tr');
    hitungBerat($row);
});
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

<?= $this->endSection() ?>
