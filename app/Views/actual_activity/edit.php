<?= $this->extend('layout/template') ?>
<?= $this->section('content') ?>
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
<!-- Flatpickr JS -->
<script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
<style>
    .suggestions-dropdown {
        border: 1px solid #ccc;
        max-height: 250px;
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
</style>
<div class="pd-ltr-20 xs-pd-20-10">
    <div class="min-height-200px">
        <div class="page-header">
            <h4>Edit Daily Report</h4>
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="<?= site_url('actual-activity/personal'); ?>">Home</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Edit Daily Report</li>
                </ol>
            </nav>
        </div>
        <?php if (session()->getFlashdata('success')): ?>
          <div class="alert alert-success"><?= session()->getFlashdata('success'); ?></div>
        <?php endif; ?>
        <?php if (session()->getFlashdata('error')): ?>
          <div class="alert alert-danger"><?= session()->getFlashdata('error'); ?></div>
        <?php endif; ?>
        <div class="card-box pd-20">
        <form action="<?= site_url('actual-activity/update/' . $actualActivity['id']); ?>" method="post" id="actual-activity-form">
        <?= csrf_field(); ?>
                <div class="form-group row">
                    <div class="col-md-4">
                        <label>Tanggal LKH<span style="color: red;">*</span></label>
                        <input type="date" id="dates" name="dates" class="form-control" max="<?= date('Y-m-d') ?>" value="<?= set_value('dates', $actualActivity['dates']) ?>" >
                    </div>
                </div>
                <div class="form-group row">
                    <div class="col-md-4">
                        <label>Project<span style="color: red;">*</span></label>
                        <select id="project_id" name="project_id" class="custom-select2 form-control" style="width: 100%; height: 38px;">
                            <option value="">Pilih Project</option>
                            <?php 
                            $diesShown = false; 
                            $jigShown = false; 
                            foreach ($projects as $project):
                                if ($project['jenis'] === "Tooling Project") {
                                    if ($project['jenis_tooling'] === "Dies") {
                                        if ($diesShown) continue;
                                        $diesShown = true;
                                    }
                                    if ($project['jenis_tooling'] === "Jig") {
                                        if ($jigShown) continue;
                                        $jigShown = true;
                                    }
                                }
                            ?>
                            <option value="<?= $project['jenis'] . ' - ' . $project['id']. ' - ' . $project['jenis_tooling']; ?>">
                                <?= $project['jenis']; ?><?= !empty($project['another_project']) ? ' - ' . $project['another_project'] : ''; ?>
                                <?= ($project['jenis_tooling'] === "Jig") ? ' - Jig' : ''; ?>
                            </option>
                            <?php endforeach; ?>
                        </select>
                    </div>

                    <div class="col-md-4" id="model-div" style="display:none;">
                        <label>Model<span style="color: red;">*</span></label>
                        <select id="model_id" name="model_id" class="custom-select2 form-control" style="width: 100%; height: 38px;">
                            <option value="">Pilih Model</option>
                        </select>
                    </div>

                    <div class="col-md-4" id="part-no-process-div" style="display:none;">
                        <label>Part No - Process<span style="color: red;">*</span></label>
                        <select id="part_no" name="part_no" class="custom-select2 form-control" style="width: 100%; height: 38px;">
                            <option value="">Pilih Part No - Process</option>
                        </select>
                    </div>
                </div>
                <div style = "display: none" id="form-completed">
                <div class="form-group">
                    <label>Activity<span style="color: red;">*</span></label>
                    <select id="activity_id" name="activity_id" class="custom-select2 form-control" style="width: 100%; height: 38px;" >
                        <option value="">Pilih Aktivitas</option>
                        <?php foreach ($activities as $activity): ?>
                            <option value="<?= $activity['id']; ?>"><?= $activity['name']; ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>  
                <div class="form-group" style="position: relative;">
                    <label>Remark<span style="color: red;">*</span></label>
                    <input id="remark" class="form-control" placeholder="Remark">
               
                    <div id="remark-suggestions" class="suggestions-dropdown"></div>
                </div>


                <div class="form-group row">
                    <div class="col-md-6">
                        <label>Start Time<span style="color: red;">*</span></label><small> (Mohon Buat dalam format 24 jam)</small>
                        <input type="time" id="start_time" class="form-control" step="900">
                    </div>
                    <div class="col-md-6">
                        <label>End Time<span style="color: red;">*</span></label>
                        <input type="time" id="end_time" class="form-control" step="900">
                    </div>
                </div>

                <!-- <div class="form-group row">
                    <div class="col-md-6">
                        <label>Start Time</label>
                        <input type="text" id="start_time" class="form-control time-picker" step="900">
                    </div>
                    <div class="col-md-6">
                        <label>End Time</label>
                        <input type="text" id="end_time" class="form-control time-picker" step="900">
                    </div>
                </div> -->

                <div class="form-group">
                    <label>Progress (%)</label>
                    <select id="progress" name="progress" class="custom-select2 form-control" style="width: 100%; height: 38px;">
                        <option value="">Pilih Progress</option>
                        <?php for ($i = 5; $i <= 100; $i += 5): ?>
                            <option value="<?= $i; ?>"><?= $i; ?>%</option>
                        <?php endfor; ?>
                    </select>
                </div>
                <button type="button" id="add-detail" class="btn btn-info">Tambah Detail</button>
                <hr>
                </div>
                <div class="table-responsive">
                <label><span style="color: red;">*</span>Data yang akan disimpan adalah data yang terdapat di dalam tabel</label> <br>
               <label><span style="color: red;">*</span>Data akan otomatis diurutkan dari baris waktu terpagi apabila disimpan</label>
                <table class="table table-bordered" id="details-table">
                    <thead>
                        <tr>
                            <th>Activity</th>
                            <th>Project</th>
                            <th>Part No</th>
                            <th>Remark</th>
                            <th>Start Time</th>
                            <th>End Time</th>
                            <th>Progress (%)</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($details as $index => $detail): ?>
                            <tr>
                                <td>
                                    <input type="text" class="form-control-plaintext" value="<?= $detail['activity_name'] ?>" readonly>
                                </td>
                                <td>
                                     <input type="text" class="form-control-plaintext" value="<?= $detail['jenis'] == 'Others' ? $detail['another_project'] : $detail['model']  ?>" readonly>
                                </td>
                                 <td>
                                    <input type="text" class="form-control-plaintext" value="<?= $detail['part_no']. ' - ' . $detail['process'] ?> " readonly>
                                </td>
                              
                                <td>
                                   <input type="text" class="form-control-plaintext" value="<?= $detail['remark']  ?>" readonly>
                                </td>
                                <td>
                                    <input type="text" class="form-control-plaintext" value="<?= $detail['start_time'] ?>" readonly>
                                </td>
                                <td>
                                  <input type="text" class="form-control-plaintext" value="<?= $detail['end_time'] ?>" readonly>
                                </td>
                                <td>
                                    <input type="text" class="form-control-plaintext" value="<?= $detail['progress'] ?>%" readonly>
                                </td>
                                <td>
                                    <button type="button" class="btn btn-danger btn-sm" onclick="confirmdelete(<?= $detail['id_detail'] ?>)">Hapus</button>
                                </td>

                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
                </div>
                <button type="submit" name="submit_status" value="draft" class="btn btn-success" id="btn-draft">Simpan Draft</button>
                <a href="<?= site_url('actual-activity/personal'); ?>" class="btn btn-secondary">Kembali</a>
            </form>
        </div>
    </div>
</div>
<script>
    document.getElementById('dates').addEventListener('change', function() {
        document.getElementById('btn-draft').removeAttribute('disabled');
    });
</script>
<script>
document.querySelectorAll('input[type="time"]').forEach(input => {
    input.addEventListener('change', function() {
        let [hour, minute] = this.value.split(':').map(Number);
        minute = Math.round(minute / 15) * 15;
        if (minute === 60) {
            minute = 0;
            hour = (hour + 1) % 24;
        }
        this.value = `${String(hour).padStart(2, '0')}:${String(minute).padStart(2, '0')}`;
    });
});
</script>
<script>
document.addEventListener("DOMContentLoaded", function(){
    flatpickr("#start_time, #end_time", {
        enableTime: true,
        noCalendar: true,
        dateFormat: "H:i",     
        time_24hr: true,      
        minuteIncrement: 15    
    });
});
</script>

<script>
    let detailIndex = 0;
    $('#add-detail').click(function () {
        let isValid = true;
        const requiredFields = ['#activity_id', '#project_id', '#start_time', '#end_time', '#progress', '#dates', '#remark'];
        let firstInvalid = null;

        requiredFields.forEach(function (selector) {
            const field = $(selector);
            if (!field.val()) {
                field.css('border', '2px solid red');
                isValid = false;
                if (!firstInvalid) firstInvalid = field;
            } else {
                field.css('border', '');
            }
        });
        if (!isValid) {
            Swal.fire({
                icon: 'error',
                title: 'Oops...',
                text: 'Silakan lengkapi semua data terlebih dahulu.',
            });
            firstInvalid.focus();
            return;
        }
        const startTime = $('#start_time').val();
        const endTime = $('#end_time').val();
        const newRow = `
            <tr>
                <td><input type="hidden" name="details[${detailIndex}][activity_id]" value="${$('#activity_id').val()}" >${$('#activity_id option:selected').text()}</td>
                <td><input type="hidden" name="details[${detailIndex}][project_id]" value="${$('#project_id').val()}">${$('#project_id option:selected').text()}</td>
                <td>
                    <input type="hidden" name="details[${detailIndex}][part_no]" value="${$('#part_no').val()}">
                    ${($('#part_no option:selected').text() === "Pilih Part No - Process" ? '-' : $('#part_no option:selected').text())}
                </td>
                <td><input type="text" name="details[${detailIndex}][remark]" value="${$('#remark').val()}" class="form-control"></td>
                <td><input type="time" name="details[${detailIndex}][start_time]" value="${$('#start_time').val()}" class="form-control"></td>
                <td><input type="time" name="details[${detailIndex}][end_time]" value="${$('#end_time').val()}" class="form-control"></td>
                <td><input type="number" name="details[${detailIndex}][progress]" value="${$('#progress').val()}" class="form-control"></td>
                <td><button type="button" class="btn btn-danger btn-sm remove-detail">Hapus</button></td>
            </tr>
        `;

        $('#details-table tbody').append(newRow);
        detailIndex++;

        $('#remark').val('');
        $('#start_time').val(endTime);
        $('#end_time').val('');

        $('#add-detail').prop('disabled', false);
        $('button[type="submit"]').prop('disabled', false);
    });

    $(document).on('click', '.remove-detail', function () {
        $(this).closest('tr').remove();
    });

    // $('#actual-activity-form').submit(function (e) {
    //     if ($('#details-table tbody tr').length === 0) {
    //         e.preventDefault();
    //         Swal.fire({
    //             icon: 'error',
    //             title: 'Oops...',
    //             text: 'Silakan tambahkan minimal satu detail aktivitas.',
    //         });
    //     }
    // });
function confirmdelete(id_detail) {
        Swal.fire({
            title: 'Apakah Anda yakin?',
            text: 'Data ini akan dihapus secara permanen!',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#d33',
            cancelButtonColor: '#3085d6',
            confirmButtonText: 'Ya, Hapus!',
            cancelButtonText: 'Batal'
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    url: '<?= site_url('detail/delete') ?>', 
                    type: 'POST',
                    data: { id_detail: id_detail,
                        "<?= csrf_token(); ?>": "<?= csrf_hash(); ?>" 
                     },
                    dataType: 'json',
                    success: function (response) {
                        if (response.status == 'success') {
                            Swal.fire('Terhapus!', 'Data berhasil dihapus.', 'success').then(() => {
                                location.reload(); 
                            });
                        } else {
                            Swal.fire('Gagal!', 'Data gagal dihapus.', 'error');
                        }
                    },
                    error: function () {
                        Swal.fire('Error!', 'Terjadi kesalahan pada server.', 'error');
                    }
                });
            }
        });
    }
    $(document).ready(function() {
      
    function clearFormValues() {
        $('#activity_id').val('').trigger('change');
        $('#model_id').val('').trigger('change');
        $('#part_no').val('').trigger('change');
        $('#remark').val('');
     
        // Reset buttons
        $('#add-detail').prop('disabled', true);
        $('button[type="submit"]').prop('disabled', true);
    }

    $('#project_id').change(function() {
        var parts = $(this).val().split(' - ');
        var project_type = parts[0]; // Tooling Project
        var tooling_type = parts[2]; 
        var projectText = $('#project_id option:selected').text();

        clearFormValues();

        if (project_id && projectText.toLowerCase().includes("tooling")) {
            $('#model-div').show();
            $('#part-no-process-div').hide();
            $('#form-completed').hide();

            $.ajax({
                url: '<?= site_url('actual-activity/fetchModels'); ?>',
                type: 'GET',
                data: {  project_type: project_type, 
                    tooling_type: tooling_type  },
                success: function(data) {
                    var modelDropdown = $('#model_id');
                    modelDropdown.empty();
                    modelDropdown.append('<option value="">Pilih Model</option>');
                    $.each(data, function(index, models) {
                        modelDropdown.append('<option value="' + models.model + ' - ' + models.jenis_tooling + '">' + models.model + '</option>');
                    });
                }
            });
        } else if (project_id && projectText.toLowerCase().includes("others")) {
            $('#form-completed').show();
            $('#model-div').hide();
            $('#part-no-process-div').hide();

            $('#add-detail').prop('disabled', false);
            $('button[type="submit"]').prop('disabled', false);
        } else {
            $('#form-completed').hide();
            $('#model-div').hide();
            $('#part-no-process-div').hide();
        }
    });

    $('#model_id').change(function() {
        // var model_id = $(this).val();
        var parts = $(this).val().split(' - ');
        var model_id = parts[0];
        var jenis_tooling = parts[1];
        $('#part_no').val('').trigger('change');
        $('#form-completed').hide();
        if (model_id) {
            $('#part-no-process-div').show();

            $.ajax({
                url: '<?= site_url('actual-activity/fetchPartNoProcess'); ?>',
                type: 'GET',
                  data: { model_id: model_id, jenis_tooling: jenis_tooling },
                success: function(data) {
                    var partNoProcessDropdown = $('#part_no');
                    partNoProcessDropdown.empty();
                    partNoProcessDropdown.append('<option value="">Pilih Part No - Process</option>');
                    $.each(data, function(index, partNoProcesses) {
                        partNoProcessDropdown.append('<option value="' + partNoProcesses.id + '-' + partNoProcesses.model + '-' + partNoProcesses.jenis  + '-' + partNoProcesses.part_no + '-' + partNoProcesses.process+ '">' + partNoProcesses.part_no + ' - ' + partNoProcesses.process +  ' (' +  
                        partNoProcesses.proses  + ')' + '</option>');
                    });
                }
            });
        } else {
            $('#part-no-process-div').hide();
        }
    });

    $('#part_no').change(function() {
        var partNo = $(this).val();
        if (partNo) {
            $('#form-completed').show();
            $('#add-detail').prop('disabled', false);
            $('button[type="submit"]').prop('disabled', false);
        } else {
            $('#form-completed').hide();
            $('button[type="submit"]').prop('disabled', true);
        }
    });
});


</script>
<script>
var remarkSuggestions = <?php echo json_encode(array_values(array_unique(array_column($remarkSuggestions, 'remark')))); ?>;

$(document).ready(function(){
    $('#remark').on('input', function(){
        var inputVal = $(this).val().toLowerCase();
        var suggestionBox = $('#remark-suggestions');
        suggestionBox.empty();
        
        var matches = remarkSuggestions.filter(function(item){
            return item.toLowerCase().indexOf(inputVal) !== -1;
        });
        
        if(matches.length > 0 && inputVal.length > 0){
            matches.forEach(function(match){
                suggestionBox.append('<div class="suggestion-item">' + match + '</div>');
            });
            suggestionBox.show();
        } else {
            suggestionBox.hide();
        }
    });
    
    $('#remark-suggestions').on('click', '.suggestion-item', function(){
        $('#remark').val($(this).text());
        $('#remark-suggestions').hide();
    });
    
    $(document).on('click', function(event){
        if(!$(event.target).closest('#remark, #remark-suggestions').length){
            $('#remark-suggestions').hide();
        }
    });
});
</script>

<script>
// $('#start_time, #end_time').change(function() {
//     const startTimeStr = $('#start_time').val();
//     const endTimeStr = $('#end_time').val();
//     if (startTimeStr && endTimeStr) {
//         if (startTimeStr === endTimeStr) {
//             Swal.fire({
//                 icon: 'error',
//                 title: 'Oops...',
//                 text: 'Start Time dan End Time tidak boleh sama.'
//             });
//             $('#end_time').val('');
//         }
//         // Otherwise, allow the input. If end time is less than start time,
//         // it will be treated as crossing midnight.
//     }
// });
</script>

<!-- <script>
document.querySelectorAll('input[type="time"]').forEach(input => {
    input.addEventListener('change', function() {
        let [hour, minute] = this.value.split(':').map(Number);
        minute = Math.round(minute / 15) * 15;
        if (minute === 60) {
            minute = 0;
            hour = (hour + 1) % 24;
        }
        this.value = `${String(hour).padStart(2, '0')}:${String(minute).padStart(2, '0')}`;
    });
});
</script> -->
<?= $this->endSection() ?>
