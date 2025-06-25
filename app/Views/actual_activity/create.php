<?= $this->extend('layout/template') ?>
<?= $this->section('content') ?>
<!-- Flatpickr CSS -->
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
<!-- Flatpickr JS -->
<script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>

<!-- Style untuk dropdown suggestion -->
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
            <h4>Tambah Daily Report</h4>
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="<?= site_url('actual-activity/personal'); ?>">Home</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Tambah Daily Report</li>
                </ol>
            </nav>
        </div>

        <div class="card-box pd-20">
            <form action="<?= site_url('actual-activity/store'); ?>" method="post" id="actual-activity-form">
                <?= csrf_field(); ?>
                
                <div class="form-group row">
                    <div class="col-md-4">
                        <label>Tanggal LKH<span style="color: red;">*</span></label>
                        <input type="date" id="dates" name="dates" class="form-control" max="<?= date('Y-m-d') ?>">
                    </div>
                </div>
             
                <div class="form-group row">
                    <div class="col-md-4">
                        <label>Project<span style="color: red;">*</span>(Info: Quality Up dipindah ke Activity)</label>
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

                <!-- Bagian detail default -->
                <div style="display: none" id="form-completed">
                    <div class="form-group">
                        <label>Activity<span style="color: red;">*</span></label>
                        <select id="activity_id" name="activity_id" class="custom-select2 form-control" style="width: 100%; height: 38px;">
                            <option value="">Pilih Aktivitas</option>
                            <?php foreach ($activities as $activity): ?>
                                <option value="<?= $activity['id']; ?>"><?= $activity['name']; ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                                
                    <div class="form-group" style="position: relative;">
                        <label><span style="color: red;">*</span>Suggestion yang tampil dapat digunakan apabila diinginkan berdasarkan history Anda 14 hari terakhir </label><br>
                        <label>Remark<span style="color: red;">*</span></label>
                        <input id="remark" class="form-control" placeholder="Remark">
                        <!-- Container dropdown suggestion -->
                        <div id="remark-suggestions" class="suggestions-dropdown"></div>
                    </div>

                    <div class="form-group row">
                        <div class="col-md-6">
                            <label>Start Time</label><span style="color: red;">*</span><small> (format 24 jam)</small>
                            <input type="text" id="start_time" name="start_time" class="form-control" placeholder="HH:mm">
                        </div>
                        <div class="col-md-6">
                            <label>End Time</label><span style="color: red;">*</span>
                            <input type="text" id="end_time" name="end_time" class="form-control" placeholder="HH:mm">
                        </div>
                    </div>

                    <div class="form-group">
                        <label>Progress (%)<span style="color: red;">*</span></label>
                        <select id="progress" name="progress" class="custom-select2 form-control" style="width: 100%; height: 38px;">
                            <option value="">Pilih Progress</option>
                            <?php for ($i = 5; $i <= 100; $i += 5): ?>
                                <option value="<?= $i; ?>"><?= $i; ?>%</option>
                            <?php endfor; ?>
                        </select>
                    </div>
                
                    <button type="button" id="add-detail" class="btn btn-info">Tambah Detail</button>
                </div>
                <hr>
                <div class="table-responsive">
                    <label><span style="color: red;">*</span>Data yang akan disimpan adalah data yang terdapat di dalam tabel</label><br>
                    <label><span style="color: red;">*</span>Data jam akan otomatis diurutkan berdasarkan waktu terawal ketika disimpan</label>
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
                        <tbody></tbody>
                    </table>
                </div>
                <br>
                <button type="submit" name="submit_status" value="draft" class="btn btn-warning mt-1" disabled>Simpan Draft</button>
                <a href="<?= site_url('actual-activity/personal'); ?>" class="btn btn-secondary mt-1">Kembali</a>
            </form>
        </div>
    </div>
</div>

<!-- Flatpickr for time fields -->
<script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
<script>
    // Fungsi untuk mendapatkan nilai default waktu berdasarkan hari
    function getDefaultStartTime() {
        let now = new Date();
        // getDay(): 0 = Minggu, 1 = Senin, ..., 5 = Jumat, 6 = Sabtu
        return (now.getDay() === 5) ? "08:00" : "07:30";
    }

    // Saat halaman load, set default waktu pada input start_time
    document.addEventListener("DOMContentLoaded", function(){
        flatpickr("#start_time, #end_time", {
            enableTime: true,
            noCalendar: true,
            dateFormat: "H:i",
            time_24hr: true,
            minuteIncrement: 15
        });
        // Set nilai default pada start_time
        document.getElementById('start_time').value = getDefaultStartTime();
    });
</script>

<script>
    // Konversi data remark suggestions dari PHP ke JavaScript
    // Menggunakan array unik berdasarkan kolom 'remark'
    var remarkSuggestions = <?php echo json_encode(array_values(array_unique(array_column($remarkSuggestions, 'remark')))); ?>;
    
    $(document).ready(function(){
        // Saat pengguna mengetik di input remark
        $('#remark').on('input', function(){
            var inputVal = $(this).val().toLowerCase();
            var suggestionBox = $('#remark-suggestions');
            suggestionBox.empty();
            
            // Filter suggestion yang mengandung inputVal
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

        // Ketika item suggestion diklik, isi input remark dengan nilai tersebut
        $('#remark-suggestions').on('click', '.suggestion-item', function(){
            $('#remark').val($(this).text());
            $('#remark-suggestions').hide();
        });

        // Sembunyikan dropdown suggestion ketika klik di luar area remark
        $(document).on('click', function(event){
            if(!$(event.target).closest('#remark, #remark-suggestions').length){
                $('#remark-suggestions').hide();
            }
        });
    });
</script>

<script>
$(document).ready(function() {
    let now = new Date();
    let day = now.getDay(); // 0 = Minggu, 6 = Sabtu
    // Hanya tambahkan default row jika hari bukan Sabtu (6) dan bukan Minggu (0)
    if (day !== 0 && day !== 6 && $('#details-table tbody').children().length === 0) {
        // Tentukan default start_time dan end_time berdasarkan hari
        let isFriday = (day === 5);
        let defaultEndTime = isFriday ? "08:00" : "07:30";
        let defaultStartTime = "07:05";
        
        let defaultRow = `
            <tr>
                <td>
                    <input type="hidden" name="details[0][activity_id]" value="<?= $defaultActivityId ?>">
                    BRIEFING PAGI
                </td>
                <td>
                    <input type="hidden" name="details[0][project_id]" value="<?= $defaultProjectId ?>">
                    DAILY
                </td>
                <td>
                    <input type="hidden" name="details[0][part_no]" value="-">
                    -
                </td>
                <td>
                    <input type="hidden" name="details[0][remark]" value="-">
                    -
                </td>
                <td>
                    <input type="hidden" name="details[0][start_time]" value="${defaultStartTime}">
                    ${defaultStartTime}
                </td>
                <td>
                    <input type="hidden" name="details[0][end_time]" value="${defaultEndTime}">
                    ${defaultEndTime}
                </td>
                <td>
                    <input type="hidden" name="details[0][progress]" value="100">
                    100%
                </td>
                <td>
                    <button type="button" class="btn btn-danger btn-sm remove-detail">Hapus</button>
                </td>
            </tr>
        `;
        $('#details-table tbody').append(defaultRow);
    }
});

</script>

<script>
    // Ketika tombol "Tambah Detail" diklik, baca data end_time baris terakhir dan set ke start_time field
    let detailIndex = 1; // Mulai dari 1 karena default sudah index 0

    function updateNoDataRow() {
        var tbody = $("#details-table tbody");
        if (tbody.children("tr").length === 0) {
            tbody.append('<tr class="no-data"><td colspan="8" class="text-center">Tidak ada data tersedia</td></tr>');
        }
    }

    $('#add-detail').click(function () {
        let isValid = true;
        const requiredFields = ['#activity_id', '#project_id', '#start_time', '#end_time', '#progress', '#remark', '#dates'];
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
                text: 'Silakan lengkapi semua data terlebih dahulu.'
            });
            firstInvalid.focus();
            return;
        }
  
        $("#details-table tbody").find(".no-data").remove();

        // const newRow = `
        //     <tr>
        //         <td>
        //             <input type="hidden" name="details[${detailIndex}][activity_id]" value="${$('#activity_id').val()}">
        //             ${$('#activity_id option:selected').text()}
        //         </td>
        //         <td>
        //             <input type="hidden" name="details[${detailIndex}][project_id]" value="${$('#project_id').val()}">
        //             ${$('#project_id option:selected').text()}
        //         </td>
        //         <td>
        //             <input type="hidden" name="details[${detailIndex}][part_no]" value="${$('#part_no').val()}">
        //             ${($('#part_no option:selected').text() === "Pilih Part No - Process" ? '-' : $('#part_no option:selected').text())}
        //         </td>
        //         <td>
        //             <input type="hidden" name="details[${detailIndex}][remark]" value="${$('#remark').val()}">
        //             ${$('#remark').val()}
        //         </td>
        //         <td>
        //             <input type="hidden" name="details[${detailIndex}][start_time]" value="${$('#start_time').val()}">
        //             ${$('#start_time').val()}
        //         </td>
        //         <td>
        //             <input type="hidden" name="details[${detailIndex}][end_time]" value="${$('#end_time').val()}">
        //             ${$('#end_time').val()}
        //         </td>
        //         <td>
        //             <input type="hidden" name="details[${detailIndex}][progress]" value="${$('#progress').val()}">
        //             ${$('#progress').val()}%
        //         </td>
        //         <td>
        //             <button type="button" class="btn btn-danger btn-sm remove-detail">Hapus</button>
        //         </td>
        //     </tr>
        // `;
        const newRow = `
            <tr>
                <td>
                    <input type="hidden" name="details[${detailIndex}][activity_id]" value="${$('#activity_id').val()}">
                    ${$('#activity_id option:selected').text()}
                </td>
                <td>
                    <input type="hidden" name="details[${detailIndex}][project_id]" value="${$('#project_id').val()}">
                    ${$('#project_id option:selected').text()}
                </td>
                <td>
                    <input type="hidden" name="details[${detailIndex}][part_no]" value="${$('#part_no').val()}">
                    ${($('#part_no option:selected').text() === "Pilih Part No - Process" ? '-' : $('#part_no option:selected').text())}
                </td>
                <td>
                    <input type="text" name="details[${detailIndex}][remark]" value="${$('#remark').val()}" class="form-control">
        
                </td>
                <td>
                    <input type="time" name="details[${detailIndex}][start_time]" value="${$('#start_time').val()}" class="form-control">
              
                </td>
                <td>
                    <input type="time" name="details[${detailIndex}][end_time]" value="${$('#end_time').val()}" class="form-control">
                
                </td>
                <td>
                    <input type="number" name="details[${detailIndex}][progress]" value="${$('#progress').val()}" class="form-control">
                 
                </td>
                <td>
                    <button type="button" class="btn btn-danger btn-sm remove-detail">Hapus</button>
                </td>
            </tr>
        `;
        $('#details-table tbody').append(newRow);
        detailIndex++;

        // Setelah menambahkan baris, set field start_time dengan nilai end_time dari baris terakhir
        let currentEndTime = $('#end_time').val();
        $('#start_time').val(currentEndTime);
        
        // Kosongkan remark dan end_time (start_time tetap tidak dikosongkan)
        $('#remark').val('');
        $('#end_time').val('');

        $('#add-detail').prop('disabled', false);
        $('button[type="submit"]').prop('disabled', false);
    });

    $(document).on('click', '.remove-detail', function () {
        $(this).closest('tr').remove();
        updateNoDataRow();
    });

    $('#actual-activity-form').submit(function (e) {
        if ($('#details-table tbody tr').length === 0 || $("#details-table tbody").find(".no-data").length) {
            e.preventDefault();
            Swal.fire({
                icon: 'error',
                title: 'Oops...',
                text: 'Silakan tambahkan minimal satu detail aktivitas.'
            });
        }
    });

    $(document).ready(function() {
        function clearFormValues() {
            // Clear form inputs
            $('#activity_id').val('').trigger('change');
            $('#model_id').val('').trigger('change');
            $('#part_no').val('').trigger('change');
            $('#remark').val('');
            let defaultTime = getDefaultStartTime();
 
            $('#end_time').val('');
     
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
                    data: { project_type: project_type, tooling_type: tooling_type },
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
                // $('button[type="submit"]').prop('disabled', false);
            } else {
                $('#form-completed').hide();
                $('#model-div').hide();
                $('#part-no-process-div').hide();
            }
        });

        $('#model_id').change(function() {
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
                            partNoProcessDropdown.append(
                               '<option value="' + partNoProcesses.id + '-' + partNoProcesses.model + '-' + partNoProcesses.jenis + '-' + partNoProcesses.part_no + '">' + 
                               partNoProcesses.part_no + ' - ' + partNoProcesses.process + 
                               (partNoProcesses.proses ? ' (' + partNoProcesses.proses + ')' : '') + 
                               '</option>'
                            );
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
<?= $this->endSection() ?>
