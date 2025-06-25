<?= $this->extend('layout/template') ?>
<?= $this->section('content') ?>

<!-- CSS Step Wizard -->
<style>
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

<div class="pd-ltr-20 xs-pd-20-10">
  <div class="min-height-200px">
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
      <form action="<?= site_url('dcp/update/' . $overview['id']); ?>" method="post" enctype="multipart/form-data" id="dcpForm">
        <!-- Hidden Field -->
        <input type="hidden" name="old_sketch" value="<?= $overview['sketch'] ?>">
        
        <!-- Tab Content -->
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
                      <small>File saat ini: <?= esc($overview['sketch']) ?></small>
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
                    <!-- <th>Time/MP</th> -->
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
                      <input type="number" name="design_man_power" class="form-control calc-mp" data-target="design_mp_time" value="<?= $designProgram['design_man_power'] ?>">
                    </td>
                    <td>
                      <input type="number" name="design_working_time" class="form-control calc-mp" data-target="design_mp_time" value="<?= $designProgram['design_working_time'] ?>">
                    </td>
                    <!-- <td>
                      <input type="number" name="design_mp_time" class="form-control" readonly value="<?= $designProgram['design_mp_time'] ?>">
                    </td> -->
                  </tr>
                  <!-- Baris 2: Programming -->
                  <tr>
                    <td class="row-number">2</td>
                    <td>
                      <input type="text" class="form-control" value="Programming" readonly>
                    </td>
                    <td>
                      <input type="number" name="prog_man_power" class="form-control calc-mp" data-target="prog_mp_time" value="<?= $designProgram['prog_man_power'] ?>">
                    </td>
                    <td>
                      <input type="number" name="prog_working_time" class="form-control calc-mp" data-target="prog_mp_time" value="<?= $designProgram['prog_working_time'] ?>">
                    </td>
                    <!-- <td>
                      <input type="number" name="prog_mp_time" class="form-control" readonly value="<?= $designProgram['prog_mp_time'] ?>">
                    </td> -->
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
                          <input type="text" name="poly_size_type_l[]" class="form-control mb-2" value="<?= $row['poly_size_type_l'] ?>" placeholder="L">
                          <input type="text" name="poly_size_type_w[]" class="form-control mb-2" value="<?= $row['poly_size_type_w'] ?>" placeholder="W">
                          <input type="text" name="poly_size_type_h[]" class="form-control mb-2" value="<?= $row['poly_size_type_h'] ?>" placeholder="H">
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
                        <input type="text" name="poly_size_type_l[]" class="form-control" placeholder="L">
                        <input type="text" name="poly_size_type_w[]" class="form-control" placeholder="W">
                        <input type="text" name="poly_size_type_h[]" class="form-control" placeholder="H">
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
                        <td><input type="text" name="mm_part_list[]" class="form-control" value="<?= $row['mm_part_list'] ?>"></td>
                        <td><input type="text" name="mm_material_spec[]" class="form-control" value="<?= $row['mm_material_spec'] ?>"></td>
                        <td><input type="text" name="mm_size_type[]" class="form-control" value="<?= $row['mm_size_type'] ?>"></td>
                        <td><input type="number" name="mm_qty[]" class="form-control" value="<?= $row['mm_qty'] ?>"></td>
                        <td><input type="number" name="mm_weight[]" class="form-control" value="<?= $row['mm_weight'] ?>"></td>
                        <td><button type="button" class="btn btn-danger btn-sm removeRow">Hapus</button></td>
                      </tr>
                    <?php endforeach; ?>
                  <?php else : ?>
                    <tr>
                      <td class="row-number">1</td>
                      <td><input type="text" name="mm_part_list[]" class="form-control"></td>
                      <td><input type="text" name="mm_material_spec[]" class="form-control"></td>
                      <td><input type="text" name="mm_size_type[]" class="form-control"></td>
                      <td><input type="number" name="mm_qty[]" class="form-control"></td>
                      <td><input type="number" name="mm_weight[]" class="form-control"></td>
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
                        <td><input type="text" name="sp_part_list[]" class="form-control" value="<?= $row['sp_part_list'] ?>"></td>
                        <td><input type="text" name="sp_material_spec[]" class="form-control" value="<?= $row['sp_material_spec'] ?>"></td>
                        <td><input type="text" name="sp_size_type[]" class="form-control" value="<?= $row['sp_size_type'] ?>"></td>
                        <td><input type="number" name="sp_qty[]" class="form-control" value="<?= $row['sp_qty'] ?>"></td>
                        <td><button type="button" class="btn btn-danger btn-sm removeRow">Hapus</button></td>
                      </tr>
                    <?php endforeach; ?>
                  <?php else : ?>
                    <tr>
                      <td class="row-number">1</td>
                      <td><input type="text" name="sp_part_list[]" class="form-control"></td>
                      <td><input type="text" name="sp_material_spec[]" class="form-control"></td>
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
                // Filter data fixed process dari $machining untuk Measuring dan FABRICATION
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
                    <!-- <th>Time/MP</th> -->
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
                      <input type="number" name="machining_man_power[]" class="form-control calc-mp" data-target="machining_mp_time1" value="<?= isset($measuring['machining_man_power']) ? $measuring['machining_man_power'] : '' ?>">
                    </td>
                    <td>
                      <input type="number" name="machining_working_time[]" class="form-control calc-mp" data-target="machining_mp_time1" value="<?= isset($measuring['machining_working_time']) ? $measuring['machining_working_time'] : '' ?>">
                    </td>
                    <!-- <td>
                      <input type="number" name="machining_mp_time[]" class="form-control" readonly value="<?= isset($measuring['machining_mp_time']) ? $measuring['machining_mp_time'] : '' ?>">
                    </td> -->
                  </tr>
                  <!-- Baris 2: FABRICATION -->
                  <tr>
                    <td class="row-number">2</td>
                    <td>
                      <input type="text" name="machining_process[]" class="form-control" value="FABRICATION" readonly>
                    </td>
                    <td>
                      <input type="number" name="machining_man_power[]" class="form-control calc-mp" data-target="machining_mp_time2" value="<?= isset($fabrication['machining_man_power']) ? $fabrication['machining_man_power'] : '' ?>">
                    </td>
                    <td>
                      <input type="number" name="machining_working_time[]" class="form-control calc-mp" data-target="machining_mp_time2" value="<?= isset($fabrication['machining_working_time']) ? $fabrication['machining_working_time'] : '' ?>">
                    </td>
                    <!-- <td>
                      <input type="number" name="machining_mp_time[]" class="form-control" readonly value="<?= isset($fabrication['machining_mp_time']) ? $fabrication['machining_mp_time'] : '' ?>">
                    </td> -->
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
                    <th>Lead Time (H)</th>
                  </tr>
                </thead>
                <tbody>
                  <?php 
                    // Daftar proses dan mesin sebagai referensi
                    $processes = [
                      "MACHINING", "MACHINING", "MACHINING", "MACHINING", "MACHINING",
                      "MACHINING", "MACHINING", "MACHINING", "MACHINING", "MACHINING",
                      "WELDING", "MEASURING", "FABRICATION"
                    ];
                    $machines = [
                      "CNC MILING RB 5", "CNC MILING HF3", "CNC MILING RB 2", "COPY MILLING KAFO",
                      "MAKINO CNC", "SURFACE GRINDING", "MILLING NANTONG", "RADIAL DRILLING ZQ 3070",
                      "WIRE CUTTING/ SODICK", "TURNING", "NATIONAL 300 AMPERE", "FARO CMM", "BLANDER BEAVER"
                    ];
                    $startNo = 3;
                    // Baris yang harus memiliki nilai default
                    $defaultHRows = [2, 5, 6, 8, 12];
                    $defaultMm2Row = [9];

                    foreach($processes as $index => $proc): 
                      $no = $startNo + $index;

                      // Tentukan default value berdasarkan nomor baris
                      if (in_array($no, $defaultHRows)) {
                          $defaultValue = "H";
                      } elseif (in_array($no, $defaultMm2Row)) {
                          $defaultValue = "mm²";
                      } else {
                          $defaultValue = ""; // Default kosong jika tidak termasuk
                      }
                      
                      // Cek apakah ada data dari query (misal: $machining2) untuk proses ini
                      $rowData = null;
                      if (!empty($machining2)) {
                          foreach ($machining2 as $row) {
                              // Menggunakan field 'machining_proc' sesuai dengan query
                              if (isset($row['machining_proc']) && strtoupper($row['machining_proc']) == strtoupper($proc)) {
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
                    <td colspan="5" class="text-right"><small>Note: Satuan untuk WIRE CUTTING/ SODICK adalah mm²</small></td>
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
                        <input type="number" name="finishing_qty[]" class="form-control" value="<?= esc($row['finishing_qty'] ?? '') ?>" readonly>
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
                    <!-- <th>Time/MP</th> -->
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
                        <input type="number" name="finishing_mp[]" class="form-control calc-mp" data-target="finishing_mp_time<?= $i + 1 ?>" value="<?= esc($row['finishing_mp'] ?? '') ?>">
                      </td>
                      <td>
                        <input type="number" name="finishing_working_time[]" class="form-control calc-mp" data-target="finishing_mp_time<?= $i + 1 ?>" value="<?= esc($row['finishing_working_time'] ?? '') ?>">
                      </td>
                      <!-- <td>
                        <input type="number" name="finishing_mp_time[]" id="finishing_mp_time<?= $i + 1 ?>" class="form-control" readonly value="<?= esc($row['finishing_mp_time'] ?? '') ?>">
                      </td> -->
                    </tr>
                    <?php endforeach; ?>
                  <?php else: ?>
                    <tr>
                      <td>
                        <input type="text" class="form-control" name="finishing_process3[]" value="Finishing 1" readonly>
                      </td>
                      <td>
                        <input type="number" name="finishing_mp[]" class="form-control calc-mp" data-target="finishing_mp_time1">
                      </td>
                      <td>
                        <input type="number" name="finishing_working_time[]" class="form-control calc-mp" data-target="finishing_mp_time1">
                      </td>
                      <!-- <td>
                        <input type="number" name="finishing_mp_time[]" id="finishing_mp_time1" class="form-control" readonly>
                      </td> -->
                    </tr>
                    <tr>
                      <td>
                        <input type="text" class="form-control" name="finishing_process3[]" value="Finishing 2" readonly>
                      </td>
                      <td>
                        <input type="number" name="finishing_mp[]" class="form-control calc-mp" data-target="finishing_mp_time2">
                      </td>
                      <td>
                        <input type="number" name="finishing_working_time[]" class="form-control calc-mp" data-target="finishing_mp_time2">
                      </td>
                      <!-- <td>
                        <input type="number" name="finishing_mp_time[]" id="finishing_mp_time2" class="form-control" readonly>
                      </td> -->
                    </tr>
                  <?php endif; ?>
                </tbody>
              </table>
              <script>
                document.addEventListener("DOMContentLoaded", function () {
                    document.querySelectorAll(".calc-mp").forEach(input => {
                        // input.addEventListener("input", function () {
                        //     let row = this.closest("tr");
                        //     let mp = row.querySelector("input[name='finishing_mp[]']").value;
                        //     let time = row.querySelector("input[name='finishing_working_time[]']").value;
                        //     let targetId = row.querySelector("input[name='finishing_mp_time[]']").id;
                        //     if (mp && time && mp > 0) {
                        //         document.getElementById(targetId).value = (time / mp).toFixed(2);
                        //     } else {
                        //         document.getElementById(targetId).value = "";
                        //     }
                        // });
                    });
                });
              </script>
            </div>
            <div class="d-flex justify-content-between">
              <button type="button" class="btn btn-step btn-secondary prev-step">Previous</button>
              <button type="button" class="btn btn-step btn-primary next-step">Next</button>
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
                  <?php 
                   if(isset($heat) && is_array($heat) && count($heat) > 0): ?>
                    <?php foreach($heat as $i => $row): ?>
                  
                  <tr>
                    <td class="row-number"><?= $i+1 ?></td>
                    <td>
                      <input type="text" name="heat_process[]" class="form-control" value="<?=  isset($row['heat_process'])  ?>" readonly>
                    </td>
                    <td>
                      <input type="text" name="heat_machine[]" class="form-control" value="<?= isset($row['heat_machine'])  ?>" readonly>
                    </td>
                    <td>
                      <input type="number" name="heat_weight[]" class="form-control" value="<?= isset($row['heat_weight']) ?>">
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
                      // Jika data dieSpot2 ada, kita tetapkan nilai default untuk proses (jika diperlukan)
                      $dieSpotProcess = [
                          'DIE SPOTTING', 'TRY OUT'
                      ];
                  ?>
                    <?php foreach($dieSpot2 as $i => $row): ?>
                      <tr>
                        <td class="row-number"><?= $i+1 ?></td>
                        <td>
                          <!-- Gunakan $dieSpotProcess[$i][0] sebagai nilai proses -->
                          <input type="text" name="die_spot_process[]" class="form-control" value="<?= esc($dieSpotProcess[$i] ?? '') ?>" readonly>
                        </td>
                        <td>
                          <!-- Gunakan $dieSpotProcess[$i][1] sebagai nilai komponen -->
                          <input type="text" name="die_spot_kom[]" class="form-control" value="<?= esc($row['die_spot_kom'] ?? '') ?>" readonly>
                        </td>
                        <td>
                          <input type="number" name="die_spot_lead_time[]" class="form-control" value="<?= esc($row['die_spot_lead_time'] ?? '') ?>">
                        </td>
                      </tr>
                    <?php endforeach; ?>
                  <?php else: 
                      // Jika tidak ada data dieSpot2, gunakan array default
                      $dieSpotProcess = [
                          ['DIE SPOTTING', 'SMALL PRESS'],
                          ['TRY OUT', 'SMALL PRESS']
                      ];
                      foreach($dieSpotProcess as $i => $row):
                  ?>
                      <tr>
                        <!-- Misalnya, nomor baris dimulai dari 5 untuk data default -->
                        <td class="row-number"><?= $i+5 ?></td>
                        <td>
                          <input type="text" class="form-control" name="die_spot_process[]" value="<?= esc($row[0]) ?>" readonly>
                        </td>
                        <td>
                          <input type="text" name="die_spot_kom[]" class="form-control" value="<?= esc($row[1]) ?>" readonly>
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
                    <!-- <th>Time/MP</th> -->
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
                      <input type="number" name="die_spot_mp[]" class="form-control calc-mp" data-target="die_spot_mp_time<?= $i ?>" value="<?= esc($row['die_spot_mp'] ?? '') ?>">
                    </td>
                    <td>
                      <input type="number" name="die_spot_working_time[]" class="form-control calc-mp" data-target="die_spot_mp_time<?= $i ?>" value="<?= esc($row['die_spot_working_time'] ?? '') ?>">
                    </td>
                    <!-- <td>
                      <input type="number" name="die_spot_mp_time[]" class="form-control" readonly value="<?= esc($row['die_spot_mp_time'] ?? '') ?>">
                    </td> -->
                  </tr>
                  <?php endforeach; else: ?>
                  <tr>
                    <td class="row-number">7</td>
                    <td>
                      <input type="text" name="die_spot_process[]" class="form-control" value="DIE SPOTTING" readonly>
                    </td>
                    <td>
                      <input type="number" name="die_spot_mp[]" class="form-control calc-mp" data-target="die_spot_mp_time0">
                    </td>
                    <td>
                      <input type="number" name="die_spot_working_time[]" class="form-control calc-mp" data-target="die_spot_mp_time0">
                    </td>
                    <!-- <td>
                      <input type="number" name="die_spot_mp_time[]" class="form-control" readonly>
                    </td> -->
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
                    <!-- <th>Aksi</th> -->
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
                            <input type="number" name="tool_cost_qty[]" class="form-control" value="<?= esc($row['tool_cost_qty'] ?? '') ?>" readonly>
                        </td>
                        <!-- <td>
                            <button type="button" class="btn btn-danger btn-sm removeRow">Hapus</button>
                        </td> -->
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
                      <td><input type="text" name="aksesoris_part_list[]" class="form-control" value="<?= $row['aksesoris_part_list'] ?>"></td>
                      <td><input type="text" name="aksesoris_spec[]" class="form-control" value="<?= $row['aksesoris_spec'] ?>"></td>
                      <td><input type="number" name="aksesoris_qty[]" class="form-control" value="<?= $row['aksesoris_qty'] ?>"></td>
                      <td><button type="button" class="btn btn-danger btn-sm removeRow">Hapus</button></td>
                    </tr>
                    <?php endforeach; ?>
                  <?php else : ?>
                    <tr>
                      <td class="row-number">1</td>
                      <td><input type="text" name="aksesoris_part_list[]" class="form-control"></td>
                      <td><input type="text" name="aksesoris_spec[]" class="form-control"></td>
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

<script>
  // Fungsi untuk mengupdate nomor baris
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

  // Tambah baris untuk Aksesoris
  $("#addAksesoris").click(function() {
    var row = `<tr>
      <td class="row-number"></td>
      <td><input type="text" name="aksesoris_part_list[]" class="form-control"></td>
      <td><input type="text" name="aksesoris_spec[]" class="form-control"></td>
      <td><input type="number" name="aksesoris_qty[]" class="form-control"></td>
      <td><button type="button" class="btn btn-danger btn-sm removeRow">Hapus</button></td>
    </tr>`;
    $("#aksesorisTable tbody").append(row);
    updateRowNumbers("aksesorisTable");
  });

  // Tambah baris untuk Standard Part
  $("#addStandardPart").click(function() {
    var row = `<tr>
      <td class="row-number"></td>
      <td><input type="text" name="sp_part_list[]" class="form-control"></td>
      <td><input type="text" name="sp_material_spec[]" class="form-control"></td>
      <td><input type="text" name="sp_size_type[]" class="form-control"></td>
      <td><input type="number" name="sp_qty[]" class="form-control"></td>
      <td><button type="button" class="btn btn-danger btn-sm removeRow">Hapus</button></td>
    </tr>`;
    $("#standardPartTable tbody").append(row);
    updateRowNumbers("standardPartTable");
  });

  // Tambah baris untuk Main Material
  $("#addMainMaterial").click(function() {
    var row = `<tr>
      <td class="row-number"></td>
      <td><input type="text" name="mm_part_list[]" class="form-control"></td>
      <td><input type="text" name="mm_material_spec[]" class="form-control"></td>
      <td><input type="text" name="mm_size_type[]" class="form-control"></td>
      <td><input type="number" name="mm_qty[]" class="form-control"></td>
      <td><input type="number" name="mm_weight[]" class="form-control"></td>
      <td><button type="button" class="btn btn-danger btn-sm removeRow">Hapus</button></td>
    </tr>`;
    $("#mainMaterialTable tbody").append(row);
    updateRowNumbers("mainMaterialTable");
  });

  // Tambah baris untuk Finishing (Tabel 1)
  $("#addRowFinishing").click(function() {
    var newRow = `<tr>
      <td class="row-number"></td>
      <td><input type="text" name="finishing_part_list[]" class="form-control"></td>
      <td><input type="text" name="finishing_material_spec[]" class="form-control"></td>
      <td><input type="text" name="finishing_size_type[]" class="form-control"></td>
      <td><input type="number" name="finishing_qty[]" class="form-control"></td>
      <td><button type="button" class="btn btn-danger btn-sm removeRow">Hapus</button></td>
    </tr>`;
    $("#finishingTable1 tbody").append(newRow);
    updateRowNumbers("finishingTable1");
  });
</script>
<script>
    // Navigasi Step Wizard dengan next dan previous
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
    
    // Update nomor baris dinamis untuk tabel
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
    
    // Tambah baris untuk Main Material
    $("#addMainMaterial").click(function(){
        var row = `<tr>
                        <td class="row-number"></td>
                        <td><input type="text" name="mm_part_list[]" class="form-control"></td>
                        <td><input type="text" name="mm_material_spec[]" class="form-control"></td>
                        <td><input type="text" name="mm_size_type[]" class="form-control"></td>
                        <td><input type="number" name="mm_qty[]" class="form-control"></td>
                        <td><input type="number" name="mm_weight[]" class="form-control"></td>
                        <td><button type="button" class="btn btn-danger btn-sm removeRow">Hapus</button></td>
                    </tr>`;
        $("#mainMaterialTable tbody").append(row);
        updateRowNumbers("mainMaterialTable");
    });
    
    // Tambah baris untuk Standard Part
    $("#addStandardPart").click(function(){
        var row = `<tr>
                        <td class="row-number"></td>
                        <td><input type="text" name="sp_part_list[]" class="form-control"></td>
                        <td><input type="text" name="sp_material_spec[]" class="form-control"></td>
                        <td><input type="text" name="sp_size_type[]" class="form-control"></td>
                        <td><input type="number" name="sp_qty[]" class="form-control"></td>
                        <td><button type="button" class="btn btn-danger btn-sm removeRow">Hapus</button></td>
                    </tr>`;
        $("#standardPartTable tbody").append(row);
        updateRowNumbers("standardPartTable");
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
                        <td><input type="text" name="aksesoris_part_list[]" class="form-control"></td>
                        <td><input type="text" name="aksesoris_spec[]" class="form-control"></td>
                        <td><input type="number" name="aksesoris_qty[]" class="form-control"></td>
                        <td><button type="button" class="btn btn-danger btn-sm removeRow">Hapus</button></td>
                    </tr>`;
        $("#aksesorisTable tbody").append(row);
        updateRowNumbers("aksesorisTable");
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

    // Fungsi untuk menambah baris baru
    $('#addRowFinishing').click(function () {
        let newRow = `<tr>
            <td class="row-number"></td>
            <td><input type="text" name="finishing_part_list[]" class="form-control"></td>
            <td><input type="text" name="finishing_material_spec[]" class="form-control"></td>
            <td><input type="text" name="finishing_size_type[]" class="form-control"></td>
            <td><input type="number" name="finishing_qty[]" class="form-control"></td>
            <td><button type="button" class="btn btn-danger btn-sm removeRow">Hapus</button></td>
        </tr>`;
        $('#finishingTable1 tbody').append(newRow);
        updateRowNumbers();
    });

    // Fungsi untuk memperbarui nomor urut
    function updateRowNumbers() {
        $('#finishingTable1 tbody tr').each(function (index) {
            $(this).find('.row-number').text(index + 1);
        });
    }

    // Memperbarui nomor awal jika ada data
    updateRowNumbers();
});

</script>
<?= $this->endSection() ?>
