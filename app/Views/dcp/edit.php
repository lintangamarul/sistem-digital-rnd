<?= $this->extend('layout/template') ?>
<?= $this->section('content') ?>

<!-- CSS Step Wizard -->
<style>
  .suggestions-dropdown {
                border: 1px solid #ccc;
                max-height: 250px;
                /* max-width: 125px; */
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
        background-color: #e8f4ff; /* Light blue background */
        border-left: 3px solid #4dabf7; /* Blue left border for visual indicator */
    }

    /* Input fields that don't have default values */
    input[type="text"].no-default-value:not([readonly]),
    input[type="number"].no-default-value:not([readonly]) {
        background-color: #fff3e6; /* Light orange background */
        border-left: 3px solid #fd7e14; /* Orange left border */
    }

    /* Readonly fields - keep their standard styling */
    input[readonly] {
        background-color: #e9ecef; /* Bootstrap default for readonly */
    }

    /* Optional: Focus state styling */
    input.has-default-value:focus, input.no-default-value:focus {
        background-color: #ffffff; /* Reset to white when focused */
        border-color: #80bdff;
        box-shadow: 0 0 0 0.2rem rgba(0, 123, 255, 0.25);
    }
</style>
<div class="pd-ltr-20 xs-pd-20-10">
  <div class="min-height-200px">
  <div class="page-header">
      <div class="row">
        <div class="col-md-6 col-sm-12">
          <div class="title">
            <h4>Edit Data PPS</h4>
          </div>
          <nav aria-label="breadcrumb" role="navigation">
            <ol class="breadcrumb">
              <li class="breadcrumb-item"><a href="<?= site_url('dashboard'); ?>">Home</a></li>
              <li class="breadcrumb-item"><a href="<?= site_url('pps'); ?>">PPS</a></li>
              <li class="breadcrumb-item active" aria-current="page">Edit Data PPS</li>
            </ol>
          </nav>
        </div>
      </div>
    </div>
    <div class="card card-step">
      <h2 class="mt-3 text-center mb-3">Edit DCP</h2>

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
              <a class="nav-link" id="diespot-tab" data-toggle="tab" href="#step10" role="tab">Tool Cost</a>
          </li>
          <li class="nav-item">
              <a class="nav-link" id="aksesoris-tab" data-toggle="tab" href="#step11" role="tab">Aksesoris</a>
          </li>
      </ul>

      <!-- Form Edit DCP dengan Step Wizard -->
      <form action="<?= site_url('dcp/update/' . $overview['id']); ?>" method="post" enctype="multipart/form-data" id="dcpForm" novalidate>
  
        <input type="hidden" name="old_sketch" value="<?= $overview['sketch'] ?>">
        
        <div class="tab-content" id="stepWizardContent">

          <!-- Step 1: Overview -->
          <div class="tab-pane fade show active" id="step1" role="tabpanel">
            <div class="segment">
              <h4>Segment Overview</h4>
              <div class="row">
                <div class="col-md-4">
                  <div class="form-group">
                    <label>Customer</label>
                    <input type="text" class="form-control" readonly value="<?= esc($overview['cust']) ?>" name="cust">
                  </div>
                </div>
                <div class="col-md-4">
                  <div class="form-group">
                    <label>Part No</label>
                    <input type="text" class="form-control" readonly value="<?= esc($overview['part_no']) ?>" name="part_no">
                  </div>
                </div>
                <div class="col-md-4">
                  <div class="form-group">
                    <label>Die Process</label>
                    <?php 
                      $dieProcess = '';
                      if(isset($overview['process'])) $dieProcess .= $overview['process'];
                      if(!empty($overview['process_join'])) $dieProcess .= ',' . $overview['process_join'];
                      if(isset($overview['proses'])) $dieProcess .= '-' . $overview['proses'];
                    ?>
                    <input type="text" class="form-control" readonly value="<?= esc($dieProcess) ?>" name="die_process">
                  </div>
                </div>
              </div>
              <div class="row">
                <div class="col-md-4">
                  <div class="form-group">
                    <label>Die Dimension</label>
                    <?php 
                      $dieDimension = '';
                      if(isset($overview['die_length'])) $dieDimension .= $overview['die_length'];
                      $dieDimension .= ' x ';
                      if(isset($overview['die_width'])) $dieDimension .= $overview['die_width'];
                      $dieDimension .= ' x ';
                      if(isset($overview['die_height'])) $dieDimension .= $overview['die_height'];
                    ?>
                    <input type="text" class="form-control" readonly value="<?= esc($dieDimension) ?>" name="die_dimension">
                  </div>
                </div>
                <div class="col-md-4">
                  <div class="form-group">
                    <label>Weight</label>
                    <input type="text" class="form-control" readonly value="<?= esc($overview['die_weight'] ?? '') ?>" name="die_weight">
                  </div>
                </div>
                <div class="col-md-4">
                  <div class="form-group">
                    <label>Class</label>
                    <input type="text" class="form-control" readonly value="<?= esc($overview['class'] ?? '') ?>" name="class">
                  </div>
                </div>
              </div>
              <div class="row">
                <div class="col-md-4">
                  <div class="form-group">
                    <label>Sketch (Upload Gambar)</label>
                    <input type="file" class="form-control-file" name="sketch" accept=".png, .jpg, .jpeg">
                    <?php if (!empty($overview['sketch'])): ?>
                    <div class="mt-2">
                      <label>Preview:</label><br>
                      <img src="<?= base_url('uploads/dcp/' . $overview['sketch']) ?>" alt="Sketch Preview" class="img-thumbnail" style="max-width: 200px;">
                    </div>
              <?php endif; ?>

                  </div>
                </div>
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
              <table class="table table-bordered table-input" id="designProgramTable">
                <thead>
                  <tr>
                    <th>No</th>
                    <th>Process</th>
                    <th>Man Power</th>
                    <th>Working Time (hrs)</th>
  
                  </tr>
                </thead>
                <tbody>
                  <!-- Baris 1: Designing -->
                  <tr>
                    <td class="row-number">1</td>
                    <td>
                      <input type="text" class="form-control" value="Designing" readonly>
                      <input type="hidden" class="form-control" value="<?= $designProgram['id'] ?>" name="design_program_id" readonly>
                    </td>
                    <td>
                      <input type="number" name="design_man_power" class="form-control"  value="<?= $designProgram['design_man_power'] ?>">
                    </td>
                    <td>
                      <input type="number" name="design_working_time" class="form-control" value="<?= $designProgram['design_working_time'] ?>">
                    </td>
                   
                  </tr>
                  <!-- Baris 2: Programming -->
                  <tr>
                    <td class="row-number">2</td>
                    <td>
                      <input type="text" class="form-control" value="Programming" readonly>
                    </td>
                    <td>
                      <input type="number" name="prog_man_power" class="form-control"  value="<?= $designProgram['prog_man_power'] ?>">
                    </td>
                    <td>
                      <input type="number" name="prog_working_time" class="form-control"  value="<?= $designProgram['prog_working_time'] ?>">
                    </td>
                    
                  </tr>
                </tbody>
              </table>
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
                  <?php if (!empty($poly)) : ?>
                    <?php foreach ($poly as $i => $row) : ?>
                      <tr>
                        <td class="row-number"><?= $i + 1 ?></td>
                        <td>
                          <input type="text" name="poly_partlist[]" class="form-control" value="<?= $row['poly_partlist'] ?>" readonly>
                        </td>
                        <td>
                          <input type="text" name="poly_material[]" class="form-control" value="<?= $row['poly_material'] ?>" readonly>
                        </td>
                        <td>
                          <div style="display: flex; gap: 5px;">
                            <input type="text" name="poly_size_type_l[]" class="form-control" value="<?= $row['poly_size_type_l'] ?>" placeholder="L" style="width: 60px;">
                            <input type="text" name="poly_size_type_w[]" class="form-control" value="<?= $row['poly_size_type_w'] ?>" placeholder="W" style="width: 60px;">
                            <input type="text" name="poly_size_type_h[]" class="form-control" value="<?= $row['poly_size_type_h'] ?>" placeholder="H" style="width: 60px;">
                          </div>
                        </td>


                        <td>
                          <input type="number" name="poly_qty[]" class="form-control" value="<?= $row['poly_qty'] ?>">
                        </td>
                        <td>
                          <input type="number" name="poly_weight[]" class="form-control" value="<?= $row['poly_weight'] ?>">
                        </td>
                      </tr>
                    <?php endforeach; ?>
                  <?php else : ?>
                    <tr>
                      <td class="row-number">1</td>
                      <td><input type="text" name="poly_partlist[]" class="form-control"></td>
                      <td><input type="text" name="poly_material[]" class="form-control"></td>
                      <td>
                        <div style="display: flex; gap: 5px;">
                          <input type="text" name="poly_size_type_l[]" class="form-control" placeholder="L" style="width: 60px;">
                          <input type="text" name="poly_size_type_w[]" class="form-control" placeholder="W" style="width: 60px;">
                          <input type="text" name="poly_size_type_h[]" class="form-control" placeholder="H" style="width: 60px;">
                        </div>
                      </td>

                      <td><input type="number" name="poly_qty[]" class="form-control"></td>
                      <td><input type="number" name="poly_weight[]" class="form-control"></td>
                    </tr>
                  <?php endif; ?>
                </tbody>
              </table>
            </div>
            <div class="d-flex justify-content-between">
              <button type="button" class="btn btn-step btn-secondary prev-step">Previous</button>
              <button type="button" class="btn btn-step btn-primary next-step">Next</button>
            </div>
          </div>

          <!-- Step 4: Main Material -->
          <div class="tab-pane fade" id="step4" role="tabpanel">
            <div class="segment">
              <h4>Segment Main Material</h4>
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
                  <?php if (!empty($mainMaterial)) : ?>
                    <?php foreach ($mainMaterial as $i => $row) : ?>
                      <tr>
                        <td class="row-number"><?= $i + 1 ?></td>
                        <td style="position: relative;">
                          <input type="text" name="mm_part_list[]" class="form-control mm-part-list" value="<?= $row['mm_part_list'] ?>">
                          <div class="suggestions-dropdown partlist-suggestions"></div>
                        </td>
                        <td style="position: relative;">
                          <input type="text" name="mm_material_spec[]" class="form-control mm-material-spec" value="<?= $row['mm_material_spec'] ?>">
                          <div class="suggestions-dropdown materialspec-suggestions"></div>
                        </td>

                        <td>
                          <div style="display: flex; gap: 5px;">
                            <input type="number" name="mm_size_type_l[]" class="form-control mm-l" value="<?= $row['mm_size_type_l'] ?>" placeholder="L" style="width: 70px;">
                            <input type="number" name="mm_size_type_w[]" class="form-control mm-w" value="<?= $row['mm_size_type_w'] ?>" placeholder="W" style="width: 70px;">
                            <input type="number" name="mm_size_type_h[]" class="form-control mm-h" value="<?= $row['mm_size_type_h'] ?>" placeholder="H" style="width: 70px;">
                          </div>
                        </td>

                        <td><input type="number" name="mm_qty[]" class="form-control" value="<?= $row['mm_qty'] ?>"></td>
                        <td><input type="number" name="mm_weight[]" class="form-control  mm-weight" value="<?= $row['mm_weight'] ?>"></td>
                        <td><button type="button" class="btn btn-danger btn-sm removeRow">Hapus</button></td>
                      </tr>
                    <?php endforeach; ?>
                  <?php else : ?>
                    <tr>
                      <td class="row-number">1</td>
                      <td><input type="text" name="mm_part_list[]" class="form-control"></td>
                      <td><input type="text" name="mm_material_spec[]" class="form-control"></td>
                      <td>
                        <div style="display: flex; gap: 5px;">
                          <input type="number" name="mm_size_type_l[]" class="form-control mm-l" placeholder="L" style="width: 70px;">
                          <input type="number" name="mm_size_type_w[]" class="form-control mm-w" placeholder="W" style="width: 70px;">
                          <input type="number" name="mm_size_type_h[]" class="form-control mm-h" placeholder="H" style="width: 70px;">
                        </div>
                      </td>

                      <td><input type="number" name="mm_qty[]" class="form-control"></td>
                      <td><input type="number" name="mm_weight[]" class="form-control  mm-weight"></td>
                      <td><button type="button" class="btn btn-danger btn-sm removeRow">Hapus</button></td>
                    </tr>
                  <?php endif; ?>
                </tbody>
              </table>
              <button type="button" id="addMainMaterial" class="btn btn-primary btn-sm mb-3">Tambah Baris</button>
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
                  <?php if (!empty($standardPart)) : ?>
                    <?php foreach ($standardPart as $i => $row) : ?>
                      <tr>
                        <td class="row-number"><?= $i + 1 ?></td>
                        <td style="position: relative;">
                          <input type="text" name="sp_part_list[]" class="form-control sp-part-list" value="<?= $row['sp_part_list'] ?>">
                          <div class="suggestions-dropdown sp-partlist-suggestions"></div>
                        </td>
                        <td style="position: relative;">
                          <input type="text" name="sp_material_spec[]" class="form-control sp-material-spec" value="<?= $row['sp_material_spec'] ?>">
                          <div class="suggestions-dropdown sp-materialspec-suggestions"></div>
                        </td>

                        <td><input type="text" name="sp_size_type[]" class="form-control" value="<?= $row['sp_size_type'] ?>"></td>
                        <td><input type="number" name="sp_qty[]" class="form-control" value="<?= $row['sp_qty'] ?>"></td>
                        <td><button type="button" class="btn btn-danger btn-sm removeRow">Hapus</button></td>
                      </tr>
                    <?php endforeach; ?>
                  <?php else : ?>
                    <tr>
                      <td class="row-number">1</td>
                      <td><input type="text" name="sp_part_list[]" class="form-control sp-part-list">
                      <div class="suggestions-dropdown sp-partlist-suggestions"></div></td>
                      <td><input type="text" name="sp_material_spec[]" class="form-control sp-material-spec">
                      <div class="suggestions-dropdown sp-materialspec-suggestions"></td>
                      <td><input type="text" name="sp_size_type[]" class="form-control"></td>
                      <td><input type="number" name="sp_qty[]" class="form-control"></td>
                      <td><button type="button" class="btn btn-danger btn-sm removeRow">Hapus</button></td>
                    </tr>
                  <?php endif; ?>
                </tbody>
              </table>
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
              <?php 
                $measuring = null;
                $fabrication = null;
                if(!empty($machining)){
                    foreach($machining as $m){
                        if(strtoupper($m['machining_process']) == 'MEASURING'){
                            $measuring = $m;
                        } elseif(strtoupper($m['machining_process']) == 'FABRICATION'){
                            $fabrication = $m;
                        }
                    }
                }
              ?>
              <!-- Tabel 1: Fixed Process -->
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
                  <!-- Baris 1: Measuring -->
                  <tr>
                    <td class="row-number">1</td>
                    <td>
                      <input type="text" name="machining_process[]" class="form-control" value="MEASURING" readonly>
                     
                    </td>
                    <td>
                      <input type="number" name="machining_man_power[]" class="form-control" data-target="machining_mp_time1" value="<?= isset($measuring['machining_man_power']) ? $measuring['machining_man_power'] : '' ?>">
                    </td>
                    <td>
                      <input type="number" name="machining_working_time[]" class="form-control" data-target="machining_mp_time1" value="<?= isset($measuring['machining_working_time']) ? $measuring['machining_working_time'] : '' ?>">
                    </td>
                  </tr>
                  <!-- Baris 2: FABRICATION -->
                  <tr>
                    <td class="row-number">2</td>
                    <td>
                      <input type="text" name="machining_process[]" class="form-control" value="FABRICATION" readonly>
                    </td>
                    <td>
                      <input type="number" name="machining_man_power[]" class="form-control" data-target="machining_mp_time2" value="<?= isset($fabrication['machining_man_power']) ? $fabrication['machining_man_power'] : '' ?>">
                    </td>
                    <td>
                      <input type="number" name="machining_working_time[]" class="form-control" data-target="machining_mp_time2" value="<?= isset($fabrication['machining_working_time']) ? $fabrication['machining_working_time'] : '' ?>">
                    </td>
                  </tr>
                </tbody>
              </table>

              <!-- Tabel 2: Additional Machining -->
              <table class="table table-bordered table-input" id="machiningTableAdditional">
                <thead>
                  <tr>
                    <th>No</th>
                    <th>Process</th>
                    <th>Kind of Machine</th>
                    <th>Lead Time</th>
                    <th>satuan</th>
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
                    $defaultHRows = [1,2,3,4,5,6, 7, 8,9,10,11, 12,13,14];
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
                      
                      if (!empty($machining2)) {
                        foreach ($machining2 as $row) {
                            if (
                                isset($row['machining_proc'], $row['machining_kom']) &&
                                strtoupper($row['machining_proc']) == strtoupper($proc) &&
                                strtoupper($row['machining_kom']) == strtoupper($machines[$index])
                            ) {
                                $rowData = $row;
                                break;
                            }
                        }
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
                    <td>
                      <input type="number" name="machining_lead_time[]" class="form-control" value="<?= isset($rowData['machining_lead_time']) ? $rowData['machining_lead_time'] : '' ?>">
                    </td>
                    <td>
                      <input type="text" name="machining_lead_time_h[]" class="form-control" 
                            value="<?= isset($rowData['machining_lead_time_h']) && $rowData['machining_lead_time_h'] !== '' ? $rowData['machining_lead_time_h'] : $defaultValue ?>" readonly>
                    </td>
                  </tr>
                  <?php endforeach; ?>
                  <tr>
                      <td colspan="3" class="text-right font-weight-bold">Total Lead Time (Selected Rows)</td>
                      <td><input type="number" id="totalLeadTime" class="form-control" readonly>
                          <div class="mt-2">
                              <strong>Max :</strong>
                              <span id="machiningHoursLabel"><?= $hoursMachining ?></span> hours
                          </div>
                      </td>
                   
                  </tr>
                </tbody>

              </table>

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
              <!-- Tabel 1: Finishing Part Data -->
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
                  <?php if(isset($finishing3) && is_array($finishing3) && count($finishing3) > 0): ?>
                    <?php foreach($finishing3 as $i => $row): ?>
                    <tr>
                      <td class="row-number"><?= $i + 1 ?></td>
                      <td>
                        <input type="text" name="finishing_part_list[]" class="form-control" value="<?= esc($row['finishing_part_list'] ?? '') ?>" readonly>
                      </td>
                      <td>
                        <input type="text" name="finishing_material_spec[]" class="form-control" value="<?= esc($row['finishing_material_spec'] ?? '') ?>" readonly>
                      </td>
                      <td>
                        <input type="text" name="finishing_size_type[]" class="form-control" value="<?= esc($row['finishing_size_type'] ?? '') ?>" readonly>
                      </td>
                      <td>
                        <input type="text" name="finishing_qty[]" class="form-control" value="<?= esc($row['finishing_qty'] ?? '') ?>" >
                      </td>
                      <td><button type="button" class="btn btn-danger btn-sm removeRow">Hapus</button></td>
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
              <button type="button" id="addRowFinishing" class="btn btn-primary btn-sm mb-3">Tambah Baris</button>

              <!-- Tabel 2: Finishing Process & Lead Time -->
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
                  <?php if(isset($finishing) && is_array($finishing) && count($finishing) > 0): ?>
                    <?php foreach($finishing as $i => $row): ?>
                    <tr>
                      <td class="row-number"><?= $i + 1 ?></td>
                      <td>
                        <input type="text" name="finishing_process[]" class="form-control" value="<?= esc($row['finishing_process'] ?? 'Finishing') ?>" readonly>
                      </td>
                      <td>
                        <input type="text" name="finishing_kom[]" class="form-control" value="<?= esc($row['finishing_kom'] ?? 'Tools Grinder') ?>">
                      </td>
                      <td>
                        <input type="number" name="finishing_lead_time[]" class="form-control" value="<?= esc($row['finishing_lead_time'] ?? '') ?>">
                      </td>
                    </tr>
                    <?php endforeach; ?>
                  <?php else: ?>
                    <tr>
                      <td class="row-number">1</td>
                      <td>
                        <input type="text" name="finishing_process[]" class="form-control" value="Finishing" readonly>
                      </td>
                      <td>
                        <input type="text" name="finishing_kom[]" class="form-control" value="Tools Grinder">
                      </td>
                      <td>
                        <input type="number" name="finishing_lead_time[]" class="form-control">
                      </td>
                    </tr>
                  <?php endif; ?>
                </tbody>
              </table>

              <!-- Tabel 3: Finishing MP Calculation -->
              <table class="table table-bordered table-input" id="finishingTable3">
                <thead>
                  <tr>
                    <th>Process</th>
                    <th>Man Power</th>
                    <th>Working Time (Hrs)</th>
                  </tr>
                </thead>
                <tbody>
                  <?php if(isset($finishing2) && is_array($finishing2) && count($finishing2) > 0): ?>
                    <?php foreach($finishing2 as $i => $row): ?>
                    <tr>
                      <td>
                        <input type="text" class="form-control" name="finishing_process3[]" value="<?= esc($row['finishing_process'] ?? 'Finishing 1') ?>" readonly>
                      </td>
                      <td>
                        <input type="number" name="finishing_mp[]" class="form-control" data-target="finishing_mp_time<?= $i + 1 ?>" value="<?= esc($row['finishing_mp'] ?? '') ?>">
                      </td>
                      <td>
                        <input type="number" name="finishing_working_time[]" class="form-control" data-target="finishing_mp_time<?= $i + 1 ?>" value="<?= esc($row['finishing_working_time'] ?? '') ?>">
                      </td>
                    </tr>
                    <?php endforeach; ?>
                  <?php else: ?>
                    <tr>
                      <td>
                        <input type="text" class="form-control" name="finishing_process3[]" value="Finishing 1" readonly>
                      </td>
                      <td>
                        <input type="number" name="finishing_mp[]" class="form-control" data-target="finishing_mp_time1">
                      </td>
                      <td>
                        <input type="number" name="finishing_working_time[]" class="form-control" data-target="finishing_mp_time1">
                      </td>
                    </tr>
                    <tr>
                      <td>
                        <input type="text" class="form-control" name="finishing_process3[]" value="Finishing 2" readonly>
                      </td>
                      <td>
                        <input type="number" name="finishing_mp[]" class="form-control" data-target="finishing_mp_time2">
                      </td>
                      <td>
                        <input type="number" name="finishing_working_time[]" class="form-control" data-target="finishing_mp_time2">
                      </td>
                    </tr>
                  <?php endif; ?>
                </tbody>
              </table>
              <!-- <script>
                document.addEventListener("DOMContentLoaded", function () {
                    document.querySelectorAll(".calc-mp").forEach(input => {
                        input.addEventListener("input", function () {
                            let row = this.closest("tr");
                            let mp = row.querySelector("input[name='finishing_mp[]']").value;
                            let time = row.querySelector("input[name='finishing_working_time[]']").value;
                            let targetId = row.querySelector("input[name='finishing_mp_time[]']").id;
                            if (mp && time && mp > 0) {
                                document.getElementById(targetId).value = (time / mp).toFixed(2);
                            } else {
                                document.getElementById(targetId).value = "";
                            }
                        });
                    });
                });
              </script>
            </div> -->
            <div class="d-flex justify-content-between">
              <button type="button" class="btn btn-step btn-secondary prev-step">Previous</button>
              <button type="button" class="btn btn-step btn-primary next-step">Next</button>
            </div>
          </div>
                  </div>

          <!-- Step 7: Heat Treatment -->
          <div class="tab-pane fade" id="step8" role="tabpanel">
            <div class="segment">
              <h4>Segment Heat Treatment</h4>
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
                    <?php if(isset($heat) && is_array($heat) && count($heat) > 0): ?>
                      <?php foreach($heat as $i => $row): ?>
                      <tr>
                        <td class="row-number"><?= $i+1 ?></td>
                        <td>
                          <input type="text" name="heat_process[]" class="form-control" value="<?= $row['heat_process'] ?? '' ?>" readonly>
                        </td>
                        <td>
                          <input type="text" name="heat_machine[]" class="form-control" value="<?= $row['heat_machine'] ?? '' ?>" readonly>
                        </td>
                        <td>
                          <input type="number" name="heat_weight[]" class="form-control" value="<?= $row['heat_weight'] ?? '' ?>">
                        </td>
                      </tr>
                      <?php endforeach; ?>
                    <?php else: 
                      $heatProcesses = ["HARDENING", "HARDENING", "HARDENING"];
                      $heatMachines  = ["TD (COATING)", "NABER N.321 (FULL HARD)", "O2 & ACYTILENE (FLAME)"];
                      foreach($heatProcesses as $i => $proc): ?>
                      <tr>
                        <td class="row-number"><?= $i+1 ?></td>
                        <td>
                          <input type="text" name="heat_process[]" class="form-control" value="<?= $proc ?>" readonly>
                        </td>
                        <td>
                          <input type="text" name="heat_machine[]" class="form-control" value="<?= $heatMachines[$i] ?>" readonly>
                        </td>
                        <td>
                          <input type="number" name="heat_weight[]" class="form-control">
                        </td>
                      </tr>
                      <?php endforeach; ?>
                    <?php endif; ?>
                  </tbody>

              </table>
            </div>
            <div class="d-flex justify-content-between">
              <button type="button" class="btn btn-step btn-secondary prev-step">Previous</button>
              <button type="button" class="btn btn-step btn-primary next-step">Next</button>
            </div>
          </div>

          <!-- Step 8: Die Spot & Try -->
          <div class="tab-pane fade" id="step9" role="tabpanel">
            <div class="segment">
              <h4>Segment Die Spot & Try</h4>
              <!-- Tabel 1: Die Spot Data -->
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
                  if(isset($dieSpot1) && is_array($dieSpot1) && count($dieSpot1) > 0):
                    foreach($dieSpot1 as $i => $row):
                  ?>
                    <tr>
                      <td class="row-number"><?= $i+1 ?></td>
                      <td>
                        <input type="text" class="form-control" name="die_spot_part_list[]" value="<?= esc($row['die_spot_part_list'] ?? '') ?>" readonly>
                      </td>
                      <td>
                        <input type="text" class="form-control" name="die_spot_material[]" value="<?= esc($row['die_spot_material'] ?? '') ?>">
                      </td>
                      <td>
                        <input type="text" class="form-control" name="die_spot_qty[]" value="<?= esc($row['die_spot_qty'] ?? '') ?>">
                      </td>
                      <td>
                        <input type="number" class="form-control" name="die_spot_weight[]" value="<?= esc($row['die_spot_weight'] ?? '') ?>">
                      </td>
                    </tr>
                  <?php endforeach; else: ?>
                    <tr>
                      <td class="row-number">1</td>
                      <td><input type="text" name="die_spot_part_list[]" class="form-control"></td>
                      <td><input type="text" name="die_spot_material[]" class="form-control"></td>
                      <td><input type="text" name="die_spot_qty[]" class="form-control"></td>
                      <td><input type="number" name="die_spot_weight[]" class="form-control"></td>
                    </tr>
                  <?php endif; ?>
                </tbody>
              </table>
              <!-- Tabel 2: Die Spot Process & Lead Time -->
              <?php
              $machineOptions = [
                'PRESS M/C 1000 T',
                'PRESS M/C 800 T',
                'PRESS M/C 600 T',
                'PRESS M/C 400 T',
                'PRESS M/C 350 T',
                'PRESS M/C 150 T',
                'PRESS M/C 110 T',
                'PRESS M/C 80 T',
                'SMALL PRESS',
              ];
            ?>

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
                    <?php if(isset($dieSpot2) && is_array($dieSpot2) && count($dieSpot2) > 0):
                        $dieSpotProcess = ['DIE SPOTTING', 'TRY OUT'];
                    ?>
                      <?php foreach($dieSpot2 as $i => $row): ?>
                        <tr>
                          <td class="row-number"><?= $i+1 ?></td>
                          <td>
                            <input type="text" name="die_spot_process[]" class="form-control" value="<?= esc($dieSpotProcess[$i] ?? '') ?>" readonly>
                          </td>
                          <td>
                            <select name="die_spot_kom[]" class="form-control">
                              <option value="">-- Pilih --</option>
                              <?php foreach($machineOptions as $opt): ?>
                                <option value="<?= esc($opt) ?>" <?= ($row['die_spot_kom'] ?? '') === $opt ? 'selected' : '' ?>><?= esc($opt) ?></option>
                              <?php endforeach; ?>
                            </select>
                          </td>
                          <td>
                            <input type="number" name="die_spot_lead_time[]" class="form-control" value="<?= esc($row['die_spot_lead_time'] ?? '') ?>">
                          </td>
                        </tr>
                      <?php endforeach; ?>
                    <?php else:
                        $dieSpotProcess = [
                          ['DIE SPOTTING', 'SMALL PRESS'],
                          ['TRY OUT', 'SMALL PRESS']
                        ];
                        foreach($dieSpotProcess as $i => $row):
                    ?>
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
                          <input type="number" name="die_spot_lead_time[]" class="form-control">
                        </td>
                      </tr>
                    <?php endforeach; ?>
                    <?php endif; ?>
                  </tbody>
                </table>

                <!-- Tabel 3: Die Spot (MP Calculation) -->
                <table class="table table-bordered table-input" id="dieSpotTable3">
                  <thead>
                    <tr>
                      <th>C</th>
                      <th>Process</th>
                      <th>Man Power</th>
                      <th>Working Time (H)</th>
                    </tr>
                  </thead>
                  <tbody>
                    <?php 
                    $dieSpotProcess2 = ['DIE SPOTTING','TRY OUT','QUALITY CHECK'];
                    if(isset($dieSpot3) && is_array($dieSpot3) && count($dieSpot3) > 0):
                      foreach($dieSpot3 as $i => $row):
                    ?>
                    <tr>
                      <td class="row-number"><?= $i+7 ?></td>
                      <td>
                        <input type="text" name="die_spot_process[]" class="form-control" value="<?= esc($row['die_spot_process'] ?? $dieSpotProcess2[$i]) ?>" readonly>
                      </td>
                      <td>
                        <input type="number" name="die_spot_mp[]" class="form-control" data-target="die_spot_mp_time<?= $i ?>" value="<?= esc($row['die_spot_mp'] ?? '') ?>">
                      </td>
                      <td>
                        <input type="number" name="die_spot_working_time[]" class="form-control" data-target="die_spot_mp_time<?= $i ?>" value="<?= esc($row['die_spot_working_time'] ?? '') ?>">
                      </td>
                    </tr>
                    <?php endforeach; else: ?>
                    <tr>
                      <td class="row-number">7</td>
                      <td>
                        <input type="text" name="die_spot_process[]" class="form-control" value="DIE SPOTTING" readonly>
                      </td>
                      <td>
                        <input type="number" name="die_spot_mp[]" class="form-control" data-target="die_spot_mp_time0">
                      </td>
                      <td>
                        <input type="number" name="die_spot_working_time[]" class="form-control" data-target="die_spot_mp_time0">
                      </td>
                    </tr>
                    <?php endif; ?>
                  </tbody>
                </table>
              </div>
              <div class="d-flex justify-content-between">
                <button type="button" class="btn btn-step btn-secondary prev-step">Previous</button>
                <button type="button" class="btn btn-step btn-primary next-step">Next</button>
              </div>
            </div>
            <div class="tab-pane fade" id="step10" role="tabpanel">
            <div class="segment">
                <h4>Segment Tool Cost</h4>
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
                        <?php if (isset($toolCost) && is_array($toolCost) && count($toolCost) > 0): ?>
                            <?php foreach ($toolCost as $i => $row): ?>
                            <tr>
                                <td class="row-number"><?= $i + 1 ?></td>
                                <td>
                                    <input type="text" name="tool_cost_process[]" class="form-control" value="<?= esc($row['tool_cost_process'] ?? '') ?>" readonly>
                                </td>
                                <td>
                                    <input type="text" name="tool_cost_tool[]" class="form-control" value="<?= esc($row['tool_cost_tool'] ?? '') ?>" readonly>
                                </td>
                                <td>
                                    <input type="text" name="tool_cost_spec[]" class="form-control" value="<?= esc($row['tool_cost_spec'] ?? '') ?>" readonly>
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
                <button type="button" id="addToolCost" class="btn btn-primary btn-sm mb-3">Tambah Baris</button>
            </div>
            <div class="d-flex justify-content-between">
                <button type="button" class="btn btn-step btn-secondary prev-step">Previous</button>
                <button type="button" class="btn btn-step btn-primary next-step">Next</button>
            </div>
        </div>

          <!-- Step 9: Aksesoris -->
          <div class="tab-pane fade" id="step11" role="tabpanel">
            <div class="segment">
                <h4>Segment Aksesoris</h4>
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
                        <?php if (!empty($aksesoris)) : ?>
                            <?php foreach ($aksesoris as $i => $row) : ?>
                            <tr>
                                <td class="row-number"><?= $i + 1 ?></td>
                                <td style="position: relative;">
                                    <input type="text" name="aksesoris_part_list[]" class="form-control aksesoris-part-list" value="<?= $row['aksesoris_part_list'] ?>" autocomplete="off">
                                    <div class="suggestions-dropdown aksesoris-partlist-suggestions"></div>
                                </td>
                                <td style="position: relative;">
                                    <input type="text" name="aksesoris_spec[]" class="form-control aksesoris-spec" value="<?= $row['aksesoris_spec'] ?>" autocomplete="off">
                                    <div class="suggestions-dropdown aksesoris-spec-suggestions"></div>
                                </td>
                                <td><input type="number" name="aksesoris_qty[]" class="form-control" value="<?= $row['aksesoris_qty'] ?>"></td>
                                <td><button type="button" class="btn btn-danger btn-sm removeRow">Hapus</button></td>
                            </tr>
                            <?php endforeach; ?>
                        <?php else : ?>
                            <tr>
                                <td class="row-number">1</td>
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
                            </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
                <button type="button" id="addAksesoris" class="btn btn-primary btn-sm mb-3">Tambah Baris</button>
            </div>
            <div class="text-right mb-4">
                <button type="submit" class="btn btn-success">Perbarui Data DCP</button>
            </div>
        </div>

          
        </div>
      </form>
    </div>
  </div>
</div>


<!-- jQuery & Bootstrap JS -->
<script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
<script src="https://code.jquery.com/ui/1.13.2/jquery-ui.js"></script>
<script>
  const spPartList = <?= json_encode(array_values($spPartList)) ?>;
  const spMaterialSpec = <?= json_encode(array_values($spMaterialSpec)) ?>;
  const aksesorisPartList = <?= json_encode(array_values($aksesorisPartList)) ?>;
const aksesorisSpec = <?= json_encode(array_values($aksesorisSpec)) ?>;


  $(document).ready(function(){
    applySuggestion('.mm-part-list', '.partlist-suggestions', mmPartList);
    applySuggestion('.mm-material-spec', '.materialspec-suggestions', mmMaterialSpec);
    applySuggestion('.sp-part-list', '.sp-partlist-suggestions', spPartList);
applySuggestion('.sp-material-spec', '.sp-materialspec-suggestions', spMaterialSpec);
applySuggestion('.aksesoris-part-list', '.aksesoris-partlist-suggestions', aksesorisPartList);
applySuggestion('.aksesoris-spec', '.aksesoris-spec-suggestions', aksesorisSpec);

});


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

          const filtered = dataArray.filter(item => item && item.toLowerCase().includes(val));
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
              $('.suggestions-dropdown').hide();
          }
      });
  }

  function updateRowNumbers(tableId) {
    $("#" + tableId + " tbody tr").each(function(index) {
      $(this).find(".row-number").text(index + 1);
    });
  }

  $(document).on('click', '.removeRow', function() {
    var $table = $(this).closest('table');
    $(this).closest('tr').remove();
    updateRowNumbers($table.attr('id'));
  });

  $("#addAksesoris").click(function() {
      var row = `<tr>
          <td class="row-number"></td>
          <td style="position: relative;">
              <input type="text" name="aksesoris_part_list[]" class="form-control aksesoris-part-list ${getInputClass('')}" autocomplete="off">
              <div class="suggestions-dropdown aksesoris-partlist-suggestions"></div>
          </td>
          <td style="position: relative;">
              <input type="text" name="aksesoris_spec[]" class="form-control aksesoris-spec ${getInputClass('')}" autocomplete="off">
              <div class="suggestions-dropdown aksesoris-spec-suggestions"></div>
          </td>
          <td><input type="number" name="aksesoris_qty[]" class="form-control ${getInputClass('')}"></td>
          <td><button type="button" class="btn btn-danger btn-sm removeRow">Hapus</button></td>
      </tr>`;

      $("#aksesorisTable tbody").append(row);
      updateRowNumbers("aksesorisTable");

      applySuggestion('.aksesoris-part-list', '.aksesoris-partlist-suggestions', aksesorisPartList);
      applySuggestion('.aksesoris-spec', '.aksesoris-spec-suggestions', aksesorisSpec);
  });

  $("#addStandardPart").click(function() {
      var row = `<tr>
        <td class="row-number"></td>
        <td style="position: relative;">
          <input type="text" name="sp_part_list[]" class="form-control sp-part-list ${getInputClass('')}" autocomplete="off">
          <div class="suggestions-dropdown sp-partlist-suggestions"></div>
        </td>
        <td style="position: relative;">
          <input type="text" name="sp_material_spec[]" class="form-control sp-material-spec ${getInputClass('')}" autocomplete="off">
          <div class="suggestions-dropdown sp-materialspec-suggestions"></div>
        </td>
        <td><input type="text" name="sp_size_type[]" class="form-control ${getInputClass('')}"></td>
        <td><input type="number" name="sp_qty[]" class="form-control ${getInputClass('')}"></td>
        <td><button type="button" class="btn btn-danger btn-sm removeRow">Hapus</button></td>
      </tr>`;
      
      $("#standardPartTable tbody").append(row);
      updateRowNumbers("standardPartTable");
  });

  $("#addMainMaterial").click(function() {
      var row = `<tr>
          <td class="row-number"></td>
          <td style="position: relative;">
              <input type="text" name="mm_part_list[]" class="form-control mm-part-list ${getInputClass('')}" autocomplete="off">
              <div class="suggestions-dropdown partlist-suggestions"></div>
          </td>
          <td style="position: relative;">
              <input type="text" name="mm_material_spec[]" class="form-control mm-material-spec ${getInputClass('')}" autocomplete="off">
              <div class="suggestions-dropdown materialspec-suggestions"></div>
          </td>
        <td>
          <div style="display: flex; gap: 5px;">
            <input type="number" name="mm_size_type_l[]" class="form-control mm-l ${getInputClass('')}" placeholder="L" style="width: 70px;">
            <input type="number" name="mm_size_type_w[]" class="form-control mm-w ${getInputClass('')}" placeholder="W" style="width: 70px;">
            <input type="number" name="mm_size_type_h[]" class="form-control mm-h ${getInputClass('')}" placeholder="H" style="width: 70px;">
          </div>
        </td>

          <td><input type="number" name="mm_qty[]" class="form-control ${getInputClass('')}"></td>
          <td><input type="number" name="mm_weight[]" class="form-control mm-weight ${getInputClass('')}"></td>
          <td><button type="button" class="btn btn-danger btn-sm removeRow">Hapus</button></td>
      </tr>`;
      
      $("#mainMaterialTable tbody").append(row);
      updateRowNumbers("mainMaterialTable");

      applySuggestion('.mm-part-list', '.partlist-suggestions', mmPartList);
      applySuggestion('.mm-material-spec', '.materialspec-suggestions', mmMaterialSpec);
  });

  $("#addRowFinishing").click(function() {
      var newRow = `<tr>
        <td class="row-number"></td>
        <td><input type="text" name="finishing_part_list[]" class="form-control ${getInputClass('')}"></td>
        <td><input type="text" name="finishing_material_spec[]" class="form-control ${getInputClass('')}"></td>
        <td><input type="text" name="finishing_size_type[]" class="form-control ${getInputClass('')}"></td>
        <td><input type="number" name="finishing_qty[]" class="form-control ${getInputClass('')}"></td>
        <td><button type="button" class="btn btn-danger btn-sm removeRow">Hapus</button></td>
      </tr>`;
      
      $("#finishingTable1 tbody").append(newRow);
      updateRowNumbers("finishingTable1");
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

    

    $(document).ready(function () {
        $(document).on('click', '.removeRow', function () {
            $(this).closest('tr').remove();
            updateRowNumbers();
        });

        // Fungsi untuk menambah baris baru
        // $('#addRowFinishing').click(function () {
        //     let newRow = `<tr>
        //         <td class="row-number"></td>
        //         <td><input type="text" name="finishing_part_list[]" class="form-control"></td>
        //         <td><input type="text" name="finishing_material_spec[]" class="form-control"></td>
        //         <td><input type="text" name="finishing_size_type[]" class="form-control"></td>
        //         <td><input type="number" name="finishing_qty[]" class="form-control"></td>
        //         <td><button type="button" class="btn btn-danger btn-sm removeRow">Hapus</button></td>
        //     </tr>`;
        //     $('#finishingTable1 tbody').append(newRow);
        //     updateRowNumbers();
        // });

        function updateRowNumbers() {
            $('#finishingTable1 tbody tr').each(function (index) {
                $(this).find('.row-number').text(index + 1);
            });
        }

        updateRowNumbers();
    });

document.addEventListener("DOMContentLoaded", function () {
    const leadTimeInputs = document.querySelectorAll('input[name="machining_lead_time[]"]');
    const totalLeadTimeInput = document.getElementById("totalLeadTime");
 
    const defaultRowsToSum = [1,2,3, 4, 5,6, 7,8, 9, 11,12,13]; 

    function updateTotalLeadTime() {
        let total = 0;
        defaultRowsToSum.forEach(index => {
            const input = leadTimeInputs[index];
            if (input && !isNaN(parseFloat(input.value))) {
                total += parseFloat(input.value);
            }
        });

        if (totalLeadTimeInput) {
            totalLeadTimeInput.value = total.toFixed(1);
        }

    }

    defaultRowsToSum.forEach(index => {
        const input = leadTimeInputs[index];
        if (input) {
            input.addEventListener('input', updateTotalLeadTime);
        }
    });

    updateTotalLeadTime();
});

function getInputClass(value) {
    return value && value.trim() !== "" ? "has-default-value" : "no-default-value";
}
</script>
<script>
  function hitungBerat($row) {
    let l = parseFloat($row.find('.mm-l').val()) || 0;
    let w = parseFloat($row.find('.mm-w').val()) || 0;
    let h = parseFloat($row.find('.mm-h').val()) || 0;

    let berat = l * w * h * 0.00000785;
    $row.find('.mm-weight').val(berat.toFixed(1)); 
  }


  $(document).on('input', '.mm-l, .mm-w, .mm-h', function () {
    let $row = $(this).closest('tr');
    hitungBerat($row);
  });
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


</script>
<script>
document.addEventListener('DOMContentLoaded', function() {
    var inputs = document.querySelectorAll('input[type="text"]:not([readonly]), input[type="number"]:not([readonly])');
    
    inputs.forEach(function(input) {
        // Check if the input has a default value
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
    let mmPartList = <?= json_encode(array_values(array_unique(array_column($mainMaterial, 'mm_part_list')))) ?>;
    let mmMaterialSpec = <?= json_encode(array_values(array_unique(array_column($mainMaterial, 'mm_material_spec')))) ?>;
</script>

<?= $this->endSection() ?>
