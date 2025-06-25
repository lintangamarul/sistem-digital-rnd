<?= $this->extend('layout/template'); ?>
<?= $this->section('content'); ?>

<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
<link href='https://cdn.jsdelivr.net/npm/fullcalendar@5.11.0/main.min.css' rel='stylesheet' />

<style>
/* Calendar Styling */
.fc-daygrid-day.fc-day-today {
    background-color: #e3f2fd !important;
    border: 2px solid #2196f3 !important;
}

.fc-working-day {
    background-color: #f8f9fa !important;
    cursor: pointer;
}

.fc-weekend-day {
    background-color: #fafafa !important;
    opacity: 0.8;
}

/* Event Styling */
.fc-event {
    padding: 4px 8px;
    border-radius: 6px;
    font-size: 12px;
    font-weight: 500;
    margin: 1px 0;
    cursor: pointer;
    transition: all 0.2s ease;
}

.fc-event:hover {
    transform: translateY(-1px);
    box-shadow: 0 2px 8px rgba(0,0,0,0.15);
}

.event-briefing {
    background: linear-gradient(45deg, #28a745, #20c997) !important;
    border-color: #28a745 !important;
    color: #fff !important;
}

.event-absent {
    background: linear-gradient(45deg, #dc3545, #e74c3c) !important;
    border-color: #dc3545 !important;
    color: #fff !important;
}

.event-replacement {
    background: linear-gradient(45deg, #ffc107, #ffb300) !important;
    border-color: #ffc107 !important;
    color: #000 !important;
}

.event-holiday {
    background: linear-gradient(45deg, #6c757d, #5a6268) !important;
    border-color: #6c757d !important;
    color: #fff !important;
}

/* Leader Cards */
.leader-card {
    transition: all 0.3s ease;
    border: none;
    border-radius: 12px;
    box-shadow: 0 2px 10px rgba(0,0,0,0.08);
    background: linear-gradient(145deg, #ffffff, #f8f9fa);
}

.leader-card:hover {
    transform: translateY(-4px);
    box-shadow: 0 8px 25px rgba(0,0,0,0.15);
}



/* Calendar Container */
.calendar-container {
    background: white;
    border-radius: 12px;
    box-shadow: 0 4px 20px rgba(0,0,0,0.08);
    overflow: hidden;
    max-width: 1600px; /* Batasi lebar maksimum */
    width: 100%;
    margin: 0 auto; /* Center alignment */
}
.row.mt-4.mb-4 {
    max-width: 1590px; /* Sama dengan calendar container */
    width: 100%;
    margin: 1.9rem auto; /* Center alignment dengan margin yang sama */
}

.calendar-header {
    background: linear-gradient(135deg, #f8f9fa, #e9ecef);
    padding: 20px 24px;
    border-bottom: 1px solid #dee2e6;
}


.calendar-header h5 {
    margin: 0;
    color: #495057;
    font-weight: 700;
    font-size: 20px;
}

/* Legend Styling */
.legend {
    display: flex;
    flex-wrap: wrap;
    gap: 12px;
    align-items: center;
}

.legend .badge {
    padding: 8px 12px;
    font-size: 12px;
    font-weight: 500;
    border-radius: 6px;
    display: flex;
    align-items: center;
    gap: 6px;
}

.legend .badge i {
    font-size: 8px;
}

/* Modal Improvements */
.modal-content {
    border: none;
    border-radius: 12px;
    box-shadow: 0 10px 40px rgba(0,0,0,0.2);
}

.modal-header {
    background: linear-gradient(135deg, #667eea, #764ba2);
    color: white;
    border-radius: 12px 12px 0 0;
    padding: 20px 24px;
    border-bottom: none;
}

.modal-header h5 {
    margin: 0;
    font-weight: 600;
}

.modal-header .close {
    color: white;
    opacity: 0.8;
    font-size: 28px;
    font-weight: 300;
    text-shadow: none;
    padding: 0;
    margin: 0;
    background: none;
    border: none;
    outline: none;
    cursor: pointer;
    transition: all 0.2s ease;
}

.modal-header .close:hover {
    opacity: 1;
    transform: scale(1.1);
}

.modal-body {
    padding: 24px;
}

.modal-footer {
    padding: 16px 24px;
    border-top: 1px solid #dee2e6;
    background-color: #f8f9fa;
    border-radius: 0 0 12px 12px;
}

/* Schedule Info Styling */
.schedule-info {
    background: #f8f9fa;
    padding: 20px;
    border-radius: 8px;
    border-left: 4px solid #007bff;
}

.schedule-info h6 {
    color: #495057;
    font-weight: 700;
    margin-bottom: 16px;
    font-size: 18px;
}

.schedule-info .row {
    margin-bottom: 12px;
    align-items: center;
}

.schedule-info .row:last-child {
    margin-bottom: 0;
}

.schedule-info strong {
    color: #6c757d;
    font-weight: 600;
}

/* Loading and Error States */
#calendar-loading {
    background: white;
    border-radius: 8px;
    margin: 20px 0;
}

.spinner-border {
    width: 3rem;
    height: 3rem;
}

#calendar-error {
    border-radius: 8px;
    border-left: 4px solid #dc3545;
}

/* Form Styling */
.form-group label {
    font-weight: 600;
    color: #495057;
    margin-bottom: 8px;
}

.form-control {
    border-radius: 6px;
    border: 1px solid #ced4da;
    padding: 10px 12px;
    transition: all 0.2s ease;
}

.form-control:focus {
    border-color: #007bff;
    box-shadow: 0 0 0 0.2rem rgba(0,123,255,0.25);
}

/* Button Styling */
.btn {
    border-radius: 6px;
    font-weight: 500;
    padding: 8px 16px;
    transition: all 0.2s ease;
}

.btn:hover {
    transform: translateY(-1px);
}

.btn-primary {
    background: linear-gradient(45deg, #007bff, #0056b3);
    border: none;
}

.btn-success {
    background: linear-gradient(45deg, #28a745, #20c997);
    border: none;
}

.btn-warning {
    background: linear-gradient(45deg, #ffc107, #ffb300);
    border: none;
    color: #000;
}

.btn-danger {
    background: linear-gradient(45deg, #dc3545, #c82333);
    border: none;
}

.btn-secondary {
    background: linear-gradient(45deg, #6c757d, #5a6268);
    border: none;
}

/* Responsive Design */
@media (max-width: 768px) {
    .page-header {
        text-align: center;
        padding: 20px;
    }
    
    .page-header .d-flex {
        flex-direction: column;
        gap: 16px;
    }
    
    .legend {
        justify-content: center;
        margin-top: 12px;
    }
    
    .modal-dialog {
        margin: 10px;
    }
    
    .calendar-header {
        padding: 16px;
    }
    
    .calendar-header .d-flex {
        flex-direction: column;
        gap: 16px;
        text-align: center;
    }
     .calendar-container,
    .row.mt-4.mb-4 {
        margin-left: 10px;
        margin-right: 10px;
    }
}

/* Calendar Toolbar Customization */
.fc-toolbar {
    padding: 16px;
    background: #f8f9fa;
    border-radius: 8px 8px 0 0;
}

.fc-toolbar-chunk {
    display: flex;
    align-items: center;
    gap: 8px;
}

.fc-button {
    background: linear-gradient(45deg, #007bff, #0056b3) !important;
    border: none !important;
    border-radius: 6px !important;
    padding: 8px 12px !important;
    font-weight: 500 !important;
    transition: all 0.2s ease !important;
}

.fc-button:hover {
    transform: translateY(-1px) !important;
    box-shadow: 0 4px 12px rgba(0,123,255,0.3) !important;
}

.fc-button-active {
    background: linear-gradient(45deg, #0056b3, #004085) !important;
}

/* Calendar Grid Improvements */
.fc-daygrid {
    background: white;
}

.fc-col-header {
    background: #f8f9fa;
    font-weight: 600;
    color: #495057;
}

.fc-daygrid-day-number {
    font-weight: 600;
    color: #495057;
    padding: 8px;
}

.fc-daygrid-day.fc-day-past {
    opacity: 0.6;
}

</style>

<div class="pd-ltr-20 xs-pd-20-10">
    <div class="min-height-200px">
        <!-- Enhanced Page Header -->
        <div class="page-header d-flex justify-content-between align-items-center mb-4">
            <div>
                <h4>Kalender Jadwal Briefing</h4>
                <p class="text-muted">Jadwal pemimpin briefing harian (Senin - Jumat)</p>
            </div>
            <div>
                <a href="<?= site_url('briefing'); ?>" class="btn btn-primary">
                    <i class="fas fa-cog"></i> Pengaturan
                </a>
            </div>
        </div>

        

        <!-- Enhanced Calendar Container -->
        <div class="calendar-container">
            <div class="calendar-header">
                <div class="d-flex justify-content-between align-items-center">
                    <h5><i class="fas fa-calendar mr-2"></i>Kalender Briefing</h5>
                    <div class="legend">
                        <span class="badge badge-success">
                            <i class="fas fa-circle"></i> Briefing Normal
                        </span>
                        <span class="badge badge-danger">
                            <i class="fas fa-circle"></i> Hari Libur
                        </span>
                        <span class="badge badge-warning">
                            <i class="fas fa-circle"></i> Pengganti
                        </span>
                        <span class="badge badge-dark">
                            <i class="fas fa-circle"></i> Absen
                        </span>
                    </div>
                </div>
            </div>
            
            <!-- Loading indicator -->
            <div id="calendar-loading" class="text-center p-4" style="display: none;">
                <div class="spinner-border text-primary" role="status">
                    <span class="sr-only">Loading...</span>
                </div>
                <p class="mt-3 text-muted">Memuat jadwal kalendar...</p>
            </div>
            
            <!-- Error message -->
            <div id="calendar-error" class="alert alert-danger m-3" style="display: none;">
                <div class="d-flex align-items-center">
                    <i class="fas fa-exclamation-triangle mr-2"></i>
                    <div>
                        <strong>Terjadi Kesalahan!</strong>
                        <div id="error-message"></div>
                    </div>
                </div>
                <button type="button" class="btn btn-sm btn-outline-danger mt-2" onclick="reloadCalendar()">
                    <i class="fas fa-redo mr-1"></i> Coba Lagi
                </button>
            </div>
            
            <div id="calendar" style="padding: 20px;"></div>
        </div>
    </div>
</div>

<!-- Enhanced Modal Detail Schedule -->
<div class="modal fade" id="scheduleModal" tabindex="-1" role="dialog" aria-labelledby="scheduleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="scheduleModalLabel">
                    <i class="fas fa-calendar-day mr-2"></i>Detail Jadwal Briefing
                </h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div id="schedule-detail-content">
                    <!-- Content will be loaded here -->
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">
                    <i class="fas fa-times mr-1"></i>Tutup
                </button>
                <button type="button" class="btn btn-warning" id="mark-absent-btn">
                    <i class="fas fa-user-slash mr-1"></i> Tandai Absen
                </button>
            </div>
        </div>
    </div>
</div>

<!-- Enhanced Modal Mark Absent -->
<div class="modal fade" id="absentModal" tabindex="-1" role="dialog" aria-labelledby="absentModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="absentModalLabel">
                    <i class="fas fa-user-slash mr-2"></i>Tandai Absen
                </h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form id="absent-form">
                    <input type="hidden" id="absent-date" name="date">
                    <input type="hidden" id="absent-user-id" name="user_id">
                    
                    <div class="form-group">
                        <label for="replacement-select">
                            <i class="fas fa-user-plus mr-1"></i>Pengganti (Opsional)
                        </label>
                        <select class="form-control" id="replacement-select" name="replacement_id">
                            <option value="">-- Pilih Pengganti --</option>
                        </select>
                        <small class="form-text text-muted">Kosongkan jika tidak ada pengganti</small>
                    </div>
                    
                    <div class="form-group">
                        <label for="notes">
                            <i class="fas fa-sticky-note mr-1"></i>Catatan
                        </label>
                        <textarea class="form-control" id="notes" name="notes" rows="4" placeholder="Tuliskan alasan absen atau catatan lainnya..."></textarea>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">
                    <i class="fas fa-times mr-1"></i>Batal
                </button>
                <button type="button" class="btn btn-danger" id="confirm-absent">
                    <i class="fas fa-save mr-1"></i> Simpan Absen
                </button>
            </div>
        </div>
    </div>
</div>
<!-- Enhanced Leader Cards -->
<div class="row mt-4 mb-4">
            <?php foreach ($leaders as $leader): ?>
            <div class="col-lg-3 col-md-6 mb-3">
                <div class="card leader-card h-100">
                    <div class="card-body text-center">
                        <div class="mb-3">
                            <div style="width: 60px; height: 60px; background: linear-gradient(45deg, #007bff, #0056b3); border-radius: 50%; display: flex; align-items: center; justify-content: center; margin: 0 auto;">
                                <i class="fas fa-user-tie fa-2x text-white"></i>
                            </div>
                        </div>
                        <h6 class="card-title font-weight-bold text-dark"><?= $leader['nama']; ?></h6>
                        <p class="text-muted small mb-2">NIK: <?= $leader['nik']; ?></p>
                        <?php 
                        $userScheduleCount = count(array_filter($schedule, function($s) use ($leader) {
                            return $s['user_id'] == $leader['user_id'];
                        }));
                        ?>
                       
                        <div class="mt-3">
                            <a href="<?= site_url('briefing/user-schedule/' . $leader['user_id']); ?>" 
                               class="btn btn-sm btn-outline-primary">
                                <i class="fas fa-calendar-alt mr-1"></i> Detail Jadwal
                            </a>
                        </div>
                    </div>
                </div>
            </div>
            <?php endforeach; ?>
        </div>
<script src='https://cdn.jsdelivr.net/npm/fullcalendar@5.11.0/main.min.js'></script>
<script src='https://cdn.jsdelivr.net/npm/fullcalendar@5.11.0/locales/id.min.js'></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
document.addEventListener('DOMContentLoaded', function() {
    console.log('DOM Content Loaded - Initializing calendar...');
    
    var calendarEl = document.getElementById('calendar');
    var currentScheduleData = null;
    var calendar = null;

    // Initialize calendar
    function initializeCalendar() {
        console.log('Initializing FullCalendar...');
        
        calendar = new FullCalendar.Calendar(calendarEl, {
            initialView: 'dayGridMonth',
            locale: 'id',
            height: 'auto',
            themeSystem: 'bootstrap',
            
            headerToolbar: {
                left: 'prev,next today',
                center: 'title',
                right: 'dayGridMonth,listWeek'
            },
            
            buttonText: {
                today: 'Hari Ini',
                month: 'Bulan',
                list: 'Daftar'
            },
            
            // Events configuration
            events: {
                url: '<?= site_url('briefing/events'); ?>',
                method: 'GET',
                failure: function(error) {
                    console.error('Failed to load events:', error);
                    showError('Gagal memuat jadwal: ' + error.message);
                },
                success: function(data) {
                    console.log('Events loaded successfully:', data.length + ' events');
                    hideError();
                    hideLoading();
                    return data;
                }
            },
            
            // Loading state
            loading: function(bool) {
                if (bool) {
                    showLoading();
                    console.log('Calendar loading events...');
                } else {
                    hideLoading();
                    console.log('Calendar events loaded');
                }
            },
            
            // Event click handler
            eventClick: function(info) {
                console.log('Event clicked:', info.event);
                
                // Prevent default action
                info.jsEvent.preventDefault();
                
                // Handle different event types
                if (info.event.extendedProps.type === 'holiday') {
                    showHolidayDetail(info.event);
                    return;
                }
                
                // For briefing events, show detail
                showScheduleDetail(info.event.startStr);
            },
            
            // Date cell click handler
            dateClick: function(info) {
                console.log('Date clicked:', info.dateStr);
                
                // Check if it's a working day (Monday-Friday)
                var clickedDate = new Date(info.dateStr);
                var dayOfWeek = clickedDate.getDay();
                
                if (dayOfWeek >= 1 && dayOfWeek <= 5) { // Monday to Friday
                    showScheduleDetail(info.dateStr);
                }
            },
            
            // Day cell styling
            dayCellClassNames: function(info) {
                var dayOfWeek = info.date.getDay();
                var classes = [];
                
                // Highlight working days
                if (dayOfWeek >= 1 && dayOfWeek <= 5) {
                    classes.push('fc-working-day');
                }
                
                // Highlight weekends
                if (dayOfWeek === 0 || dayOfWeek === 6) {
                    classes.push('fc-weekend-day');
                }
                
                return classes;
            },
            
            // Event content customization
            eventContent: function(info) {
    var event = info.event;
    var html = '<div class="fc-event-main-frame">';
    
    // Add icon based on event type
    var icon = '';
    switch (event.extendedProps.type) {
        case 'holiday':
            icon = '<i class="fas fa-calendar-times"></i>';
            break;
        case 'briefing':
            icon = '<i class="fas fa-user-tie"></i>';
            break;
        case 'replacement':
            icon = '<i class="fas fa-user-plus"></i>';
            break;
        case 'swap':
            icon = '<i class="fas fa-exchange-alt"></i>';
            break;
        case 'absent':
            icon = '<i class="fas fa-user-slash"></i>';
            break;
    }
    
    html += '<div class="fc-event-title-container">';
    html += '<div class="fc-event-title fc-sticky">';
    html += icon + ' ' + event.title;
    html += '</div></div></div>';
    
    return { html: html };
},
            
            // Event styling
            eventClassNames: function(info) {
    var classes = ['briefing-event'];
    
    switch (info.event.extendedProps.type) {
        case 'holiday':
            classes.push('event-holiday');
            break;
        case 'briefing':
            classes.push('event-briefing');
            break;
        case 'replacement':
            classes.push('event-replacement');
            break;
        case 'swap':
            classes.push('event-swap');
            break;
        case 'absent':
            classes.push('event-absent');
            break;
    }
    
    return classes;
},
            
            // Additional configuration
            dayMaxEvents: true,
            moreLinkText: 'lainnya',
            eventDisplay: 'block',
            displayEventTime: false,
            
            // Event constraints
            businessHours: {
                daysOfWeek: [1, 2, 3, 4, 5], // Monday - Friday
                startTime: '08:00',
                endTime: '17:00'
            }
        });

        // Render calendar
        try {
            calendar.render();
            console.log('Calendar rendered successfully');
        } catch (error) {
            console.error('Error rendering calendar:', error);
            showError('Gagal menampilkan kalender: ' + error.message);
        }
    }

    // Show/hide functions
    function showLoading() {
        document.getElementById('calendar-loading').style.display = 'block';
        document.getElementById('calendar-error').style.display = 'none';
    }

    function hideLoading() {
        document.getElementById('calendar-loading').style.display = 'none';
    }

    function showError(message) {
        document.getElementById('error-message').textContent = message;
        document.getElementById('calendar-error').style.display = 'block';
        hideLoading();
    }

    function hideError() {
        document.getElementById('calendar-error').style.display = 'none';
    }

    // Reload calendar function
    window.reloadCalendar = function() {
        hideError();
        if (calendar) {
            calendar.refetchEvents();
        } else {
            initializeCalendar();
        }
    };

    // Show holiday detail
    function showHolidayDetail(event) {
        Swal.fire({
            title: '<i class="fas fa-calendar-times text-danger"></i> Hari Libur',
            html: '<div class="text-left">' +
                  '<div class="mb-2"><strong><i class="fas fa-calendar mr-1"></i> Tanggal:</strong> ' + formatDate(event.startStr) + '</div>' +
                  '<div><strong><i class="fas fa-info-circle mr-1"></i> Keterangan:</strong> ' + event.title + '</div>' +
                  '</div>',
            icon: 'info',
            confirmButtonText: 'OK',
            confirmButtonColor: '#007bff',
            customClass: {
                popup: 'animated fadeInDown'
            }
        });
    }

    // Show schedule detail
    function showScheduleDetail(date) {
        console.log('Loading schedule detail for:', date);
        
        // Show loading state
        Swal.fire({
            title: 'Memuat...',
            text: 'Sedang mengambil detail jadwal',
            allowOutsideClick: false,
            didOpen: () => {
                Swal.showLoading();
            }
        });
        
        fetch('<?= site_url('briefing/schedule-detail'); ?>?date=' + date, {
            method: 'GET',
            headers: {
                'X-Requested-With': 'XMLHttpRequest'
            }
        })
        .then(response => {
            if (!response.ok) {
                throw new Error('Network response was not ok');
            }
            return response.json();
        })
        .then(data => {
            console.log('Schedule detail response:', data);
            Swal.close();
            
            if (data.success) {
                currentScheduleData = data;
                displayScheduleDetail(data);
                $('#scheduleModal').modal('show');
            } else {
                Swal.fire({
                    title: '<i class="fas fa-info-circle text-info"></i> Informasi',
                    text: data.message || 'Tidak ada jadwal briefing untuk tanggal ini',
                    icon: 'info',
                    confirmButtonText: 'OK',
                    confirmButtonColor: '#007bff'
                });
            }
        })
        .catch(error => {
            console.error('Error fetching schedule detail:', error);
            Swal.close();
            Swal.fire({
                title: '<i class="fas fa-exclamation-triangle text-danger"></i> Error',
                text: 'Terjadi kesalahan saat memuat detail jadwal',
                icon: 'error',
                confirmButtonText: 'OK',
                confirmButtonColor: '#dc3545'
            });
        });
    }

    // Display schedule detail in modal
    function displayScheduleDetail(data) {
    var schedule = data.schedule;
    var absenceRecord = data.absence_record;
    
    var html = '<div class="schedule-info">';
    html += '<h6><i class="fas fa-calendar-day text-primary mr-2"></i>' + formatDate(schedule.date) + ' (' + schedule.day_name + ')</h6>';
    html += '<hr>';
    
    html += '<div class="row mb-3">';
    html += '<div class="col-5"><strong><i class="fas fa-user-tie text-primary mr-1"></i>Pemimpin Terjadwal:</strong></div>';
    html += '<div class="col-7">' + schedule.user_name + ' <small class="text-muted">(' + schedule.user_nik + ')</small></div>';
    html += '</div>';

    // Perbaikan untuk menangani status swap
    if (schedule.status === 'absent') {
        // Cek apakah ini adalah swap schedule
        var isSwapSchedule = schedule.notes && schedule.notes.includes('Tukar jadwal');
        
        if (isSwapSchedule) {
            html += '<div class="row mb-3">';
            html += '<div class="col-5"><strong><i class="fas fa-exchange-alt text-info mr-1"></i>Status:</strong></div>';
            html += '<div class="col-7"><span class="badge badge-info"><i class="fas fa-exchange-alt mr-1"></i>Tukar Jadwal</span></div>';
            html += '</div>';
            
            html += '<div class="row mb-3">';
            html += '<div class="col-5"><strong><i class="fas fa-user-plus text-info mr-1"></i>Pengganti:</strong></div>';
            html += '<div class="col-7">';
            html += '<span class="badge badge-info">' + schedule.replacement_user_name + '</span>';
            html += ' <small class="text-muted">(' + schedule.replacement_user_nik + ')</small>';
            html += '</div>';
            html += '</div>';
        } else {
            html += '<div class="row mb-3">';
            html += '<div class="col-5"><strong><i class="fas fa-info-circle text-danger mr-1"></i>Status:</strong></div>';
            html += '<div class="col-7"><span class="badge badge-danger"><i class="fas fa-user-slash mr-1"></i>Absen</span></div>';
            html += '</div>';
            
            if (schedule.replacement_user_name) {
                html += '<div class="row mb-3">';
                html += '<div class="col-5"><strong><i class="fas fa-user-plus text-warning mr-1"></i>Pengganti:</strong></div>';
                html += '<div class="col-7">';
                html += '<span class="badge badge-warning">' + schedule.replacement_user_name + '</span>';
                html += ' <small class="text-muted">(' + schedule.replacement_user_nik + ')</small>';
                html += '</div>';
                html += '</div>';
            }
        }
        
        if (schedule.notes) {
            html += '<div class="row mb-3">';
            html += '<div class="col-5"><strong><i class="fas fa-sticky-note text-info mr-1"></i>Keterangan:</strong></div>';
            html += '<div class="col-7"><em>' + schedule.notes + '</em></div>';
            html += '</div>';
        }
    } else {
        html += '<div class="row mb-3">';
        html += '<div class="col-5"><strong><i class="fas fa-check-circle text-success mr-1"></i>Status:</strong></div>';
        html += '<div class="col-7"><span class="badge badge-success"><i class="fas fa-calendar-check mr-1"></i>Terjadwal</span></div>';
        html += '</div>';
    }

    // Link ke detail jadwal user
    html += '<div class="row mt-4">';
    html += '<div class="col-12">';
    html += '<a href="<?= site_url("briefing/user-schedule/"); ?>' + schedule.user_id + '" class="btn btn-sm btn-primary">';
    html += '<i class="fas fa-calendar-alt mr-1"></i> Detail Jadwal ' + schedule.user_name;
    html += '</a>';
    html += '</div>';
    html += '</div>';

    html += '</div>';
    document.getElementById('schedule-detail-content').innerHTML = html;
}

    // Format date function
    function formatDate(dateStr) {
        var date = new Date(dateStr + 'T00:00:00');
        var options = { 
            weekday: 'long', 
            year: 'numeric', 
            month: 'long', 
            day: 'numeric' 
        };
        return date.toLocaleDateString('id-ID', options);
    }

    // Fixed Modal Close Events
    // Schedule Modal Close Events
    $('#scheduleModal').on('hidden.bs.modal', function () {
        console.log('Schedule modal closed');
        currentScheduleData = null;
    });

    // Absent Modal Close Events
    $('#absentModal').on('hidden.bs.modal', function () {
        console.log('Absent modal closed');
        // Reset form
        document.getElementById('absent-form').reset();
        document.getElementById('replacement-select').innerHTML = '<option value="">-- Pilih Pengganti --</option>';
    });

    // Fix close button functionality
    $(document).on('click', '[data-dismiss="modal"]', function() {
        var modalId = $(this).closest('.modal').attr('id');
        $('#' + modalId).modal('hide');
    });

    // Mark Absent functionality
    document.getElementById('mark-absent-btn').addEventListener('click', function() {
        if (currentScheduleData && currentScheduleData.schedule) {
            document.getElementById('absent-date').value = currentScheduleData.schedule.date;
            document.getElementById('absent-user-id').value = currentScheduleData.schedule.user_id;
            
            // Populate replacement options
            var replacementSelect = document.getElementById('replacement-select');
            replacementSelect.innerHTML = '<option value="">-- Tidak ada pengganti --</option>';
            
            if (currentScheduleData.available_replacements) {
                currentScheduleData.available_replacements.forEach(function(replacement) {
                    if (replacement.user_id !== currentScheduleData.schedule.user_id) {
                        var option = document.createElement('option');
                        option.value = replacement.user_id;
                        option.textContent = replacement.nama + ' (' + replacement.nik + ')';
                        replacementSelect.appendChild(option);
                    }
                });
            }
            
            $('#scheduleModal').modal('hide');
            setTimeout(function() {
                $('#absentModal').modal('show');
            }, 300);
        }
    });

    // Confirm absent
    document.getElementById('confirm-absent').addEventListener('click', function() {
        var formData = new FormData(document.getElementById('absent-form'));
        var data = Object.fromEntries(formData);
        
        // Validation
        if (!data.date || !data.user_id) {
            Swal.fire({
                title: 'Error!',
                text: 'Data tidak lengkap',
                icon: 'error',
                confirmButtonText: 'OK',
                confirmButtonColor: '#dc3545'
            });
            return;
        }
        
        // Show loading
        Swal.fire({
            title: 'Menyimpan...',
            text: 'Sedang memproses data absen',
            allowOutsideClick: false,
            didOpen: () => {
                Swal.showLoading();
            }
        });
        
        fetch('<?= site_url('briefing/mark-absent'); ?>', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-Requested-With': 'XMLHttpRequest'
            },
            body: JSON.stringify(data)
        })
        .then(response => response.json())
        .then(data => {
            Swal.close();
            if (data.success) {
                Swal.fire({
                    title: '<i class="fas fa-check-circle text-success"></i> Berhasil!',
                    text: data.message,
                    icon: 'success',
                    confirmButtonText: 'OK',
                    confirmButtonColor: '#28a745',
                    timer: 3000,
                    timerProgressBar: true
                }).then(() => {
                    $('#absentModal').modal('hide');
                    if (calendar) {
                        calendar.refetchEvents();
                    }
                });
            } else {
                Swal.fire({
                    title: '<i class="fas fa-exclamation-triangle text-danger"></i> Gagal!',
                    text: data.message,
                    icon: 'error',
                    confirmButtonText: 'OK',
                    confirmButtonColor: '#dc3545'
                });
            }
        })
        .catch(error => {
            console.error('Error marking absent:', error);
            Swal.close();
            Swal.fire({
                title: '<i class="fas fa-exclamation-triangle text-danger"></i> Error!',
                text: 'Terjadi kesalahan saat menyimpan data',
                icon: 'error',
                confirmButtonText: 'OK',
                confirmButtonColor: '#dc3545'
            });
        });
    });

    // Escape key handler for modals
    $(document).keyup(function(e) {
        if (e.keyCode === 27) { // ESC key
            $('.modal.show').modal('hide');
        }
    });

    // Initialize calendar when DOM is ready
    initializeCalendar();
    
    // Debug: Test endpoint directly
    console.log('Testing events endpoint directly...');
    fetch('<?= site_url('briefing/events'); ?>?start=2025-06-01&end=2025-06-30')
        .then(response => {
            console.log('Direct test response status:', response.status);
            return response.json();
        })
        .then(data => {
            console.log('Direct test result:', data);
            console.log('Events count:', data.length);
        })
        .catch(error => {
            console.error('Direct test error:', error);
        });

    // Additional UI Enhancements
    // Tooltip initialization
    $('[data-toggle="tooltip"]').tooltip();
    
    // Smooth scrolling for internal links
    $('a[href^="#"]').on('click', function(event) {
        var target = $(this.getAttribute('href'));
        if( target.length ) {
            event.preventDefault();
            $('html, body').stop().animate({
                scrollTop: target.offset().top - 100
            }, 1000);
        }
    });

    // Add loading animation to buttons
    $('.btn').on('click', function() {
        var $btn = $(this);
        if (!$btn.hasClass('no-loading')) {
            $btn.addClass('btn-loading');
            setTimeout(function() {
                $btn.removeClass('btn-loading');
            }, 2000);
        }
    });

    // Notification for successful actions
    function showNotification(message, type = 'success') {
        var bgColor = type === 'success' ? '#28a745' : '#dc3545';
        var icon = type === 'success' ? 'fas fa-check-circle' : 'fas fa-exclamation-triangle';
        
        Swal.fire({
            toast: true,
            position: 'top-end',
            showConfirmButton: false,
            timer: 3000,
            timerProgressBar: true,
            title: message,
            icon: type,
            background: bgColor,
            color: '#fff',
            customClass: {
                popup: 'colored-toast'
            }
        });
    }

    // Calendar refresh button
    function addRefreshButton() {
        var refreshBtn = $('<button>', {
            class: 'btn btn-sm btn-outline-primary ml-2',
            html: '<i class="fas fa-sync-alt"></i> Refresh',
            click: function() {
                $(this).find('i').addClass('fa-spin');
                reloadCalendar();
                setTimeout(() => {
                    $(this).find('i').removeClass('fa-spin');
                }, 1000);
            }
        });
        
        $('.fc-toolbar-chunk').first().append(refreshBtn);
    }

    // Add refresh button after calendar is rendered
    setTimeout(addRefreshButton, 1000);
});

// Global utility functions
window.showLoading = function(message = 'Loading...') {
    Swal.fire({
        title: message,
        allowOutsideClick: false,
        didOpen: () => {
            Swal.showLoading();
        }
    });
};

window.hideLoading = function() {
    Swal.close();
};

window.showSuccess = function(message) {
    Swal.fire({
        title: 'Berhasil!',
        text: message,
        icon: 'success',
        confirmButtonText: 'OK',
        confirmButtonColor: '#28a745'
    });
};

window.showError = function(message) {
    Swal.fire({
        title: 'Error!',
        text: message,
        icon: 'error',
        confirmButtonText: 'OK',
        confirmButtonColor: '#dc3545'
    });
};

// Print functionality
window.printCalendar = function() {
    window.print();
};

// Export functionality placeholder
window.exportCalendar = function() {
    Swal.fire({
        title: 'Export Calendar',
        text: 'Fitur export akan segera tersedia',
        icon: 'info',
        confirmButtonText: 'OK'
    });
};
</script>

<style>
/* Additional Custom Styles */
.btn-loading {
    pointer-events: none;
    opacity: 0.6;
}

.btn-loading::after {
    content: "";
    display: inline-block;
    width: 16px;
    height: 16px;
    margin-left: 10px;
    border: 2px solid transparent;
    border-top-color: currentColor;
    border-radius: 50%;
    animation: spin 1s linear infinite;
}

@keyframes spin {
    0% { transform: rotate(0deg); }
    100% { transform: rotate(360deg); }
}

.colored-toast {
    border-radius: 8px !important;
    box-shadow: 0 4px 12px rgba(0,0,0,0.15) !important;
}

/* Print Styles */
@media print {
    .page-header .btn,
    .modal,
    .legend,
    .fc-toolbar {
        display: none !important;
    }
    
    .calendar-container {
        box-shadow: none !important;
        border: 1px solid #ddd !important;
    }
    
    .fc-event {
        color: #000 !important;
        background: #f0f0f0 !important;
        border: 1px solid #ddd !important;
    }
}

/* Mobile Responsive Improvements */
@media (max-width: 576px) {
    .modal-dialog {
        margin: 5px;
        max-width: calc(100% - 10px);
    }
    
    .calendar-header .d-flex {
        flex-direction: column;
        gap: 12px;
    }
    
    .legend {
        flex-direction: column;
        gap: 8px;
    }
    
    .legend .badge {
        justify-content: center;
        width: 100%;
    }
    
    .fc-toolbar {
        flex-direction: column !important;
        gap: 10px;
    }
    
    .fc-toolbar-chunk {
        justify-content: center;
    }
    
    .leader-card .card-body {
        padding: 15px;
    }

}

/* Dark Mode Support */
@media (prefers-color-scheme: dark) {
    .calendar-container,
    .leader-card,
    .modal-content {
        background-color: #2d3748 !important;
        color: #e2e8f0 !important;
    }
    
    .fc-daygrid-day {
        background-color: #4a5568 !important;
        border-color: #718096 !important;
    }
    
    .fc-col-header {
        background-color: #1a202c !important;
        color: #e2e8f0 !important;
    }
    
}

/* Animation Classes */
.animated {
    animation-duration: 0.5s;
    animation-fill-mode: both;
}

@keyframes fadeInDown {
    from {
        opacity: 0;
        transform: translate3d(0, -100%, 0);
    }
    to {
        opacity: 1;
        transform: translate3d(0, 0, 0);
    }
}

.fadeInDown {
    animation-name: fadeInDown;
}

@keyframes fadeInUp {
    from {
        opacity: 0;
        transform: translate3d(0, 100%, 0);
    }
    to {
        opacity: 1;
        transform: translate3d(0, 0, 0);
    }
}

.fadeInUp {
    animation-name: fadeInUp;
}

/* Accessibility Improvements */
.btn:focus,
.form-control:focus {
    outline: 2px solid #007bff;
    outline-offset: 2px;
}

.modal-content {
    max-height: 90vh;
    overflow-y: auto;
}

/* Loading Spinner */
.spinner-border-lg {
    width: 3rem;
    height: 3rem;
}

/* Custom Scrollbar */
::-webkit-scrollbar {
    width: 8px;
}

::-webkit-scrollbar-track {
    background: #f1f1f1;
}

::-webkit-scrollbar-thumb {
    background: #888;
    border-radius: 4px;
}

::-webkit-scrollbar-thumb:hover {
    background: #555;
}
</style>

<?= $this->endSection(); ?>