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
                        <h4>Tambah JCP</h4>
                    </div>
                    <nav aria-label="breadcrumb" role="navigation">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item">
                                <a href="<?= site_url('actual-activity/personal'); ?>">Home</a>
                            </li>
                            <li class="breadcrumb-item"><a href="<?= site_url('jcp'); ?>">JCP</a></li>
                            <li class="breadcrumb-item active" aria-current="page">
                                Form Tambah JCP
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
                    <h2 class="mt-3 text-center mb-3">JCP Data Form </h2>
                    
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
                    
                    <form action="<?= site_url('jcp/store'); ?>" method="post" enctype="multipart/form-data" id="dcpForm" novalidate>
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
                                                <label>Part No<span style="color: red">*</span></label>
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
                                                <label>Jig Process<span style="color: red">*</span></label>
                                                <select class="custom-select2 form-control" name="cf_process" id="cf_process">  <!-- ### PERUBAHAN: dari input ke select -->
                                                    <option value="">-- Pilih Jig Process --</option>
                                                    <option value="Single">Single</option>
                                                    <option value="Assy">Assy</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label>Jig Dimension (L × W × H)<span style="color: red">*</span></label>
                                                <div class="d-flex gap-1">
                                                    <input type="number" step="any" class="form-control mr-1" name="jig_length" id="jig_length" placeholder="Length">
                                                    <input type="number" step="any" class="form-control mr-1" name="jig_width" id="jig_width" placeholder="Width">
                                                    <input type="number" step="any" class="form-control mr-1" name="jig_height" id="jig_height" placeholder="Height">
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-md-4">
                                                <div class="form-group">
                                                    <label>Customer<span style="color: red">*</span></label>
                                                    <input type="text" class="form-control" name="cust" id="cust" readonly>
                                                </div>
                                            </div>
                                            <div class="col-md-4">
                                                <div class="form-group">
                                                    <label>Model<span style="color: red">*</span></label>
                                                    <input type="text" class="form-control" name="model" id="model" readonly>
                                                </div>
                                            </div>
                                            <div class="col-md-4">
                                                <div class="form-group">
                                                    <label>Part Name<span style="color: red">*</span></label>
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
                                                <label>Class<span style="color: red">*</span></label>
                                                <input type="text" class="form-control" name="class" id="classInput" value="<?= esc($class) ?>" readonly>
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label>Jumlah Part<span style="color: red">*</span></label>
                                                <input type="text" class="form-control" name="ukuran_part" id="ukuranPart" oninput="debounceUpdateMachiningData()">
                                            </div>
                                        </div>
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

                                <script>
                                    let machiningDataTimer = null;

                                    function debounceUpdateMachiningData() {
                                        clearTimeout(machiningDataTimer); 
                                        machiningDataTimer = setTimeout(updateMachiningData, 500); 
                                    }

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
                                    function updateMachiningData() {
                                        const cls = document.getElementById('classInput').value;
                                        const ukuranPart = document.getElementById('ukuranPart').value; 
                                        
                                        if (!cls || !ukuranPart) {
                                            alert('Please select a class and enter number of parts');
                                            return;
                                        }
                                        
                                        const baseUrl = "<?= base_url() ?>";
                                        fetch(`${baseUrl}/jcp/lead-time/${encodeURIComponent(cls)}?ukuran_part=${encodeURIComponent(ukuranPart)}`)
                                            .then(r => r.json())
                                            .then(data => {
                                                if (data.error) {
                                                    alert(data.error);
                                                    return;
                                                }
                                                
                                                const measuring_hour = data.measuring_hour || 0;
                                                const hour_machine_big = data.hour_machine_big || 0;
                                                const hour_machine_small = data.hour_machine_small || 0;
                                                const hour_machine_laser_cutting = data.hour_machine_laser_cutting || 0;
                                                
                                                // Update machiningTable1
                                                
                                                const measuringRows = document.querySelectorAll('#machiningTable1 input[name="machining_process[]"]');
                                                for (let i = 0; i < measuringRows.length; i++) {
                                                    if (measuringRows[i].value.trim() === "MEASURING") {
                                                        const workingTimeInput = measuringRows[i].closest('tr').querySelector('input[name="machining_working_time[]"]');
                                                        if (workingTimeInput) {
                                                            workingTimeInput.value = measuring_hour;
                                                        }
                                                    }
                                                }
                                                
                                                // 2. Calculate and update MACHINING row
                                                const machiningAvg = (hour_machine_big + hour_machine_small) / 2;
                                                for (let i = 0; i < measuringRows.length; i++) {
                                                    if (measuringRows[i].value.trim() === " MACHINING") {
                                                        const workingTimeInput = measuringRows[i].closest('tr').querySelector('input[name="machining_working_time[]"]');
                                                        if (workingTimeInput) {
                                                            workingTimeInput.value = machiningAvg;
                                                        }
                                                    }
                                                }
                                                
                                                // Update machiningTable2
                                                
                                                // gather required lead times
                                                let radialDrillingLeadTime = 0;
                                                let bubutLeadTime = 0;
                                                
                                                const machineTypeInputs = document.querySelectorAll('#machiningTable2 input[name="machining_kom[]"]');
                                                for (let i = 0; i < machineTypeInputs.length; i++) {
                                                    if (machineTypeInputs[i].value === "RADIAL DRILLING") {
                                                        const leadTimeInput = machineTypeInputs[i].closest('tr').querySelector('input[name="machining_lead_time[]"]');
                                                        if (leadTimeInput) {
                                                            radialDrillingLeadTime = parseFloat(leadTimeInput.value) || 0;
                                                        }
                                                    }
                                                    else if (machineTypeInputs[i].value === "BUBUT") {
                                                        const leadTimeInput = machineTypeInputs[i].closest('tr').querySelector('input[name="machining_lead_time[]"]');
                                                        if (leadTimeInput) {
                                                            bubutLeadTime = parseFloat(leadTimeInput.value) || 0;
                                                        }
                                                    }
                                                }
                                                
                                                // Calculate MILLING MANUAL lead time
                                                const millingManualLeadTime = (hour_machine_small - radialDrillingLeadTime - bubutLeadTime) / 4;
                                                
                                                //  update all machine types
                                                for (let i = 0; i < machineTypeInputs.length; i++) {
                                                    const leadTimeInput = machineTypeInputs[i].closest('tr').querySelector('input[name="machining_lead_time[]"]');
                                                    if (!leadTimeInput) continue;
                                                    
                                                    const machineType = machineTypeInputs[i].value.trim();
                                                    
                                                    switch (machineType) {
                                                        case "MILLING MANUAL":
                                                            leadTimeInput.value = millingManualLeadTime;
                                                            break;
                                                            
                                                        case "MAKINO":
                                                            leadTimeInput.value = millingManualLeadTime * 3;
                                                            break;
                                                            
                                                        case "CNC HF-3":
                                                            leadTimeInput.value = hour_machine_big;
                                                            break;
                                                            
                                                        case "FARO OMM":
                                                            leadTimeInput.value = measuring_hour;
                                                            break;
                                                            
                                                        case "PLASMA CUTTING":
                                                            leadTimeInput.value = hour_machine_laser_cutting;
                                                            break;
                                                    }
                                                }
                                                
                                                console.log('Machining data updated successfully');
                                            })
                                            .catch(error => {
                                                console.error('Error updating machining data:', error);
                                                alert('Failed to update machining data. Please try again.');
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
                                                    <td><input type="number" name="design_working_time" class="form-control calc-mp" data-target="design_mp_time" value="36"></td>
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
                                                    <td><input type="number" name="prog_working_time" class="form-control calc-mp" data-target="prog_mp_time" value="16"></td>
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
                                                <?php foreach ($jcp_master_main_material as $index => $material): ?>
                                                    <tr>
                                                        <td class="row-number"><?= $index + 1 ?></td>
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
                                                        <td>
                                                            <input type="number" name="mm_weight[]" class="form-control mm-weight" value="<?= esc($material['mm_weight']) ?>" placeholder="Auto" readonly>
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
                                                <?php if (!empty($jcp_master_standard_part)): ?>
                                                    <?php foreach ($jcp_master_standard_part as $index => $part): ?>
                                                    <tr>
                                                        <td class="row-number"><?= $index + 1 ?></td>
                                                        <td>
                                                            <input type="text" name="sp_part_list[]" class="form-control" value="<?= esc($part['sp_part_list'] ?? '') ?>">
                                                        </td>
                                                        <td>
                                                            <input type="text" name="sp_material_spec[]" class="form-control" value="<?= esc($part['sp_material_spec'] ?? '') ?>">
                                                        </td>
                                                        <td>
                                                            <input type="text" name="sp_size_type[]" class="form-control" value="<?= esc($part['sp_size_type'] ?? '') ?>">
                                                        </td>
                                                        <td>
                                                            <input type="number" name="sp_qty[]" class="form-control" value="<?= esc($part['sp_qty'] ?? 1) ?>">
                                                        </td>
                                                        <td><button type="button" class="btn btn-danger btn-sm removeRow">Hapus</button></td>
                                                    </tr>
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
                                                    <td><input type="number" name="machining_man_power[]" class="form-control calc-mp" data-target="machining_mp_time1" value="1" ></td>
                                                    <td><input type="number" name="machining_working_time[]" class="form-control calc-mp" data-target="machining_mp_time1" value="4"  ></td>
                                                    <!-- <td><input type="number" name="machining_mp_time[]" class="form-control" readonly></td> -->
                                                </tr>
                                                <tr>
                                                    <td class="row-number">2</td>
                                                    <td>
                                                        <input type="text" name="machining_process[]" class="form-control" value=" FABRICATION + WELDING" readonly>
                                                    </td>
                                                    <td><input type="number" name="machining_man_power[]" class="form-control calc-mp" data-target="machining_mp_time2"  value="2" ></td>
                                                    <td><input type="number" name="machining_working_time[]" class="form-control calc-mp" data-target="machining_mp_time2"  value="16" ></td>
                                                    <!-- <td><input type="number" name="machining_mp_time[]" class="form-control" readonly></td> -->
                                                </tr>
                                                <tr>
                                                    <td class="row-number">3</td>
                                                    <td>
                                                        <input type="text" name="machining_process[]" class="form-control" value=" MACHINING" readonly>
                                                    </td>
                                                    <td><input type="number" name="machining_man_power[]" class="form-control calc-mp" data-target="machining_mp_time3" value="2" ></td>
                                                    <td><input type="number" name="machining_working_time[]" class="form-control calc-mp" data-target="machining_mp_time3" value="25"  ></td>
                                                    <!-- <td><input type="number" name="machining_mp_time[]" class="form-control" readonly></td> -->
                                                </tr>
                                                <tr>
                                                    <td class="row-number">4</td>
                                                    <td>
                                                        <input type="text" name="machining_process[]" class="form-control" value=" ASSEMBLY + TUNNING" readonly>
                                                    </td>
                                                    <td><input type="number" name="machining_man_power[]" class="form-control calc-mp" data-target="machining_mp_time4" value="1"  ></td>
                                                    <td><input type="number" name="machining_working_time[]" class="form-control calc-mp" data-target="machining_mp_time4" value="32" ></td>
                                                    <!-- <td><input type="number" name="machining_mp_time[]" class="form-control" readonly></td> -->
                                                </tr>
                                                <tr>
                                                    <td class="row-number">4</td>
                                                    <td>
                                                        <input type="text" name="machining_process[]" class="form-control" value="SETTING WIRING (JUNCTION BOX)" readonly>
                                                    </td>
                                                    <td><input type="number" name="machining_man_power[]" class="form-control calc-mp" data-target="machining_mp_time4" value="1" ></td>
                                                    <td><input type="number" name="machining_working_time[]" class="form-control calc-mp" data-target="machining_mp_time4" value="16"  ></td>
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
                                                    "MACHINING", "MACHINING", "MACHINING", "MACHINING", "WELDING", "MEASURING", "MACHINING", "MACHINING", "MACHINING"
                                                ];
                                                $machines = [
                                                    "CNC HF-3", "MAKINO", "MILLING MANUAL", "RADIAL DRILLING", "NATIONAL 300 AMPERE",
                                                    "FARO OMM", "BUBUT", "CUTTING WHEEL", "PLASMA CUTTING"
                                                ];
                                                $time = [
                                                    "8", "53", "18", "16", "32", "4", "16", "8", "10"
                                                ];
                                                foreach($processes as $index => $proc): 
                                                    $no =  $index;
                                                    $no++;
                                                
                                                ?>
                                                <tr>
                                                    <td class="row-number"><?= $no ?></td>
                                                    <td>
                                                        <input type="text" name="machining_proc[]" class="form-control" value="<?= $proc ?>" readonly>
                                                    </td>
                                                    <td>
                                                        <input type="text" name="machining_kom[]" class="form-control" value="<?= isset($machines[$index]) ? $machines[$index] : '' ?>" readonly>
                                                    </td>
                                                    <td><input type="number" name="machining_lead_time[]" class="form-control" value="<?= isset($time[$index]) ? $time[$index] : '' ?>"></td>
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
                                                <?php foreach ($jcp_master_finishing_3 as $i => $item): ?>
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
                                                <input type="number" name="finishing_lead_time[]" class="form-control" value="8">
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
                                                <input type="number" name="finishing_lead_time[]" class="form-control" value="8">
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
                                                <input type="number" name="finishing_working_time[]" class="form-control calc-mp" data-target="finishing_mp_time1" value="8">
                                            </td>

                                                    <!-- <td><input type="number" name="finishing_mp_time[]" id="finishing_mp_time1" class="form-control" readonly></td> -->
                                                </tr>
                                                <tr>
                                                    <td>
                                                        <input type="text" class="form-control" name="finishing_process3[]" value="Painting" readonly>
                                                    </td>
                                                    <td><input type="number" name="finishing_mp[]" class="form-control calc-mp" data-target="finishing_mp_time2"  value="1"></td>
                                                    <td><input type="number" name="finishing_working_time[]" class="form-control calc-mp" data-target="finishing_mp_time2" value="8"></td>
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
                                                $harderningDefaults = [
                                                    [
                                                        'process' => 'FLAME HARD',
                                                        'machine' => 'OKSIGEN ARC WELDING',
                                                        'weight' => 0
                                                    ],
                                                    // Kalau mau tambah data default lain, cukup tambah array di sini
                                                    // [
                                                    //     'process' => 'INDUCTION HARD',
                                                    //     'machine' => 'LASER WELDING',
                                                    //     'weight' => 0
                                                    // ],
                                                ];

                                                foreach($harderningDefaults as $i => $data): ?>
                                                <tr>
                                                    <td class="row-number"><?= $i+1 ?></td>
                                                    <td>
                                                        <input type="text" name="heat_process[]" class="form-control" value="<?= esc($data['process']) ?>" readonly>
                                                    </td>
                                                    <td>
                                                        <input type="text" name="heat_machine[]" class="form-control" value="<?= esc($data['machine']) ?>">
                                                    </td>
                                                    <td>
                                                        <input type="number" name="heat_weight[]" class="form-control" value="<?= esc($data['weight']) ?>">
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
                                                <?php foreach($trial_process as $i => $row): ?>
                                                <tr>
                                                    <td class="row-number"><?= $i + 1 ?></td>
                                                    <td>
                                                        <input type="text" class="form-control" name="die_spot_part_list[]" value="<?= esc($row['tp_part_list']) ?>" readonly>
                                                    </td>
                                                    <td>
                                                        <input type="text" class="form-control" name="die_spot_material[]" value="<?= esc($row['tp_material_spec']) ?>">
                                                    </td>
                                                    <td>
                                                        <input type="text" class="form-control" name="die_spot_qty[]" value="<?= esc($row['tp_qty']) ?>">
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
                                            ['PROJECTION NUT', 'WSS NUT WELD', ''], 
                                            ['PROJECTION BOLT', 'WSS BOLT WELD', ''],
                                            ['Co2 Weld', 'ARC WELDING', ''],
                                            ['Sub-Assy', 'SPOT WELDING', ''],
                                            ['Projection Stud Bolt', 'STUDBOLT WELDING', ''],
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
                                                    <?php 
                                                    $no = 0;
                                                    foreach($dieSpotProcess as $i => $row): ?>
                                                    <tr>
                                                        <td class="row-number"><?= $no++ ?></td>
                                                        <td>
                                                        <input type="text" class="form-control" name="die_spot_process[]" value="<?= esc($row[0]) ?>" >
                                                        </td>
                                                        <td>
                                                        <!-- <select name="die_spot_kom[]" class="form-control">
                                                            <option value="">-- Pilih --</option>
                                                            <?php foreach($machineOptions as $opt): ?>
                                                            <option value="<?= esc($opt) ?>" <?= $row[1] === $opt ? 'selected' : '' ?>><?= esc($opt) ?></option>
                                                            <?php endforeach; ?>
                                                        </select> -->
                                                        <input type="text" class="form-control" name="die_spot_kom[]" value="<?= esc($row[1]) ?>" >
                                                      
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
                                                    <td class="row-number"><?= $i++ ?></td>
                                                    <td>
                                                        <input type="text" name="die_spot_process2[]" class="form-control" value="<?= $proc ?>" >
                                                    </td>
                                                    <td><input type="number" name="die_spot_mp[]" class="form-control calc-die-spot" value="1" data-target="die_spot_mp_time<?= $i ?>"></td>
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
                                            <tbody>
                                                <?php foreach($aksesoris as $i => $row): ?>
                                                <tr>
                                                    <td class="row-number"><?= $i + 1 ?></td>
                                                    <td style="position: relative;">
                                                        <input type="text" name="aksesoris_part_list[]" class="form-control aksesoris-part-list" value="<?= esc($row['part_list']) ?>" autocomplete="off">
                                                        <div class="suggestions-dropdown aksesoris-partlist-suggestions"></div>
                                                    </td>
                                                    <td style="position: relative;">
                                                        <input type="text" name="aksesoris_spec[]" class="form-control aksesoris-spec" value="<?= esc($row['material_spec']) ?>" autocomplete="off">
                                                        <div class="suggestions-dropdown aksesoris-spec-suggestions"></div>
                                                    </td>
                                                    <td>
                                                        <input type="number" name="aksesoris_qty[]" class="form-control" value="0">
                                                    </td>
                                                    <td>
                                                        <button type="button" class="btn btn-danger btn-sm removeRow">Hapus</button>
                                                    </td>
                                                </tr>
                                                <?php endforeach; ?>
                                            </tbody>
                                        </table>
                                    </div>
                                    <button type="button" id="addAksesoris" class="btn btn-primary btn-sm mb-3">Tambah Baris</button>
                                </div>
                                <div class="d-flex justify-content-between">
                                    <button type="button" class="btn btn-step btn-secondary prev-step">Previous</button>
                          
                                    <button type="submit" class="btn btn-step btn-success">Simpan Data JCP</button>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>

<!-- Load jQuery dan Bootstrap JS -->\
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

<script>
    function refreshRowNumbers(tableId) {
    document.querySelectorAll(`#${tableId} tbody tr`).forEach((tr, i) => {
        tr.querySelector('.row-number').textContent = i+1;
    });
    }

    document.addEventListener('click', function(e){
        if (e.target.matches('#harderningTable .removeRow')) {
            e.target.closest('tr').remove();
            refreshRowNumbers('harderningTable');
        }
    });

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
    
    // Fungsi untuk update nomor urut pada tabel dinamis
    function updateRowNumbers(tableId) {
        $("#" + tableId + " tbody tr").each(function(index){
            $(this).find(".row-number").text(index + 1);
        });
    }
    
    // Event untuk menghapus baris
    $(document).on('click', '.removeRow', function(){
        var $table = $(this).closest('table');
        $(this).closest('tr').remove();
        updateRowNumbers($table.attr('id'));
    });


    
    // Tambah baris untuk Tool Cost
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
    
    // Tambah baris untuk Aksesoris
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
    // Process all editable input fields to add appropriate styling classes
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
function hitungBerat($row) {
    let l = parseFloat($row.find('.mm-l').val()) || 0;
    let w = parseFloat($row.find('.mm-w').val()) || 0;
    let h = parseFloat($row.find('.mm-h').val()) || 0;
    let partList = $row.find('.mm-part-list').val().trim().toLowerCase(); 

    let berat = 0;

    // Tambahan untuk Shim Plate
    if (partList === 'shim plate 1.0' || partList === 'shim plate 0.5') {
        berat = l * l * 3.14 * 0.25 * w * 7.85 / 1000000;
    } else {
        berat = (l * w * h * 0.00000785);
    }
    console.log( berat);

    $row.find('.mm-weight').val(berat.toFixed(1));
}


$(document).on('input', '.mm-l, .mm-w, .mm-h', function () {
    let $row = $(this).closest('tr');
    hitungBerat($row);
});
$(document).on('input', '.mm-part-list', function () {
    let $row = $(this).closest('tr');
    hitungBerat($row);
});

</script>
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
