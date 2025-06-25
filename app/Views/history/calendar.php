<?= $this->extend('layout/template'); ?>
<?= $this->section('content'); ?>

<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
<link href='https://cdn.jsdelivr.net/npm/fullcalendar@5.11.0/main.min.css' rel='stylesheet' />

<style>
    .fc-daygrid-day.fc-day-today {
        background-color: #d1f4ff !important;
    }

    .fc-event-title {
        font-weight: bold;
    }

    .fc-event {
        padding: 5px 8px;
        border-radius: 5px;
        font-size: 14px;
    }

    .fc-bg-warning {
        background-color: #ffc107 !important;
        color: #000 !important;
    }

    .fc-bg-success {
        background-color: #28a745 !important;
        color: #fff !important;
    }

    .fc-bg-primary {
        background-color: #0062cc !important;
        color: #fff !important;
    }

    .fc-bg-danger {
        background-color: #dc3545;
        border-color: #dc3545;
        color: #fff;
        font-weight: bold;
        padding: 4px 8px;
        border-radius: 4px;
    }

    .fc-holiday-bg {
        background-color: #ffdddd !important;
    }

    .fc .fc-toolbar-title {
        font-size: 1.5rem;
        font-weight: 600;
        color: #343a40;
    }

    .fc .fc-daygrid-day.fc-day-sun .fc-daygrid-day-number {
        background-color: #dc3545;
        border-color: #dc3545;
        color: #fff;
        font-weight: bold;
        padding: 4px 8px;
        border-radius: 4px;
    }
    
    .private-event {
        opacity: 0.7;
        border-style: dashed !important;
    }
    
    .event-time {
        font-size: 12px;
        font-weight: normal;
        margin-left: 5px;
        opacity: 0.8;
    }
</style>

<div class="pd-ltr-20 xs-pd-20-10">
    <div class="min-height-200px">
        <div class="page-header">
            <div class="row">
                <div class="col-md-12 col-sm-12">
                    <div class="title">
                        <h4>Calendar</h4>
                    </div>
                    <nav aria-label="breadcrumb" role="navigation">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="index.html">Home</a></li>
                            <li class="breadcrumb-item active" aria-current="page">Calendar</li>
                        </ol>
                    </nav>
                </div>
            </div>
        </div>

        <div class="card-box shadow-sm p-4">
            <div id='calendar'></div>
        </div>
    </div>
</div>

<div class="modal fade" id="addEventModal" tabindex="-1" aria-labelledby="addEventLabel" aria-hidden="true">
    <div class="modal-dialog">
    <form action="<?= base_url('calendar/add') ?>" method="post">

            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Tambah Event</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label>Tanggal</label>
                        <input type="text" class="form-control" name="date" id="eventDate" readonly>
                    </div>
                    <div class="mb-3">
                        <label>Waktu Mulai</label>
                        <input type="time" class="form-control" name="start_time">
           
                    </div>
                    <div class="mb-3">
                        <label>Judul</label>
                        <input type="text" class="form-control" name="title" required>
                    </div>
                    <!-- <div class="mb-3">
                        <label>Catatan</label>
                        <textarea class="form-control" name="notes"></textarea>
                    </div> -->
                    <div class="mb-3">
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" name="is_private" id="isPrivate" value="1">
                            <label class="form-check-label" for="isPrivate">
                                Event Pribadi (hanya Anda yang bisa melihat)
                            </label>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary">Simpan</button>
                </div>
            </div>
        </form>
    </div>
</div>

<script src='https://cdn.jsdelivr.net/npm/fullcalendar@5.11.0/main.min.js'></script>
<script>
    document.addEventListener('DOMContentLoaded', function () {
        var calendarEl = document.getElementById('calendar');

        var calendar = new FullCalendar.Calendar(calendarEl, {
            initialView: 'dayGridMonth',
            themeSystem: 'bootstrap',
            headerToolbar: {
                left: 'prev,next today',
                center: 'title',
                right: ''
            },
            events: '<?= base_url('calendar/events') ?>',


            dateClick: function (info) {
                document.getElementById('eventDate').value = info.dateStr;
                var myModal = new bootstrap.Modal(document.getElementById('addEventModal'));
                myModal.show();
            },
            eventClick: function (info) {
                if (info.event.extendedProps.eventType === 'calendar') {
                    const eventId = info.event.extendedProps.idEvent;
                    
                    if (!eventId || !eventId.startsWith('calendar_')) {
                        console.error('Invalid event ID:', eventId);
                        return;
                    }
                    
                    const actualId = eventId.replace('calendar_', '');
                    if (info.event.extendedProps.isPrivate && info.event.extendedProps.createdBy !== '<?= session()->get('id') ?>') {
                        Swal.fire({
                            title: 'Akses Ditolak',
                            text: 'Anda tidak memiliki izin untuk menghapus event ini',
                            icon: 'error',
                            confirmButtonText: 'OK'
                        });
                        return;
                    }
                    
                    Swal.fire({
                        title: `Hapus event "${info.event.title}"?`,
                        text: "Data akan dihapus secara permanen.",
                        icon: 'warning',
                        showCancelButton: true,
                        confirmButtonColor: '#d33',
                        cancelButtonColor: '#6c757d',
                        confirmButtonText: 'Ya, hapus',
                        cancelButtonText: 'Batal'
                    }).then((result) => {
                        if (result.isConfirmed) {
                            fetch('<?= base_url('calendar/delete/') ?>' + actualId, {

                                method: 'DELETE',
                                headers: {
                                    'X-Requested-With': 'XMLHttpRequest'
                                }
                            }).then(res => res.json()).then(data => {
                                if (data.success) {
                                    info.event.remove();
                                    Swal.fire(
                                        'Berhasil!',
                                        'Event telah dihapus.',
                                        'success'
                                    );
                                } else {
                                    Swal.fire(
                                        'Gagal!',
                                        'Gagal menghapus event.',
                                        'error'
                                    );
                                }
                            }).catch(error => {
                                console.error('Error:', error);
                                Swal.fire(
                                    'Error!',
                                    'Terjadi kesalahan saat menghapus event.',
                                    'error'
                                );
                            });
                        }
                    });
                } else {
                    let message = info.event.title;
                    if (info.event.extendedProps.notes) {
                        message += "\n\n" + info.event.extendedProps.notes;
                    }
                    
                    Swal.fire({
                        title: 'Info',
                        text: message,
                        icon: 'info',
                        confirmButtonText: 'OK'
                    });
                }
            },

			eventDidMount: function(info) {
    let titleEl = info.el.querySelector('.fc-event-title');
    
    if (info.event.extendedProps.isPrivate) {
        info.el.classList.add('private-event');
    }
    
    if (titleEl) {
        let titleHtml = '';
        
        if (info.event.title.includes("Izin")) {
            titleHtml = '<i class="fas fa-user-slash me-1 text-warning"></i> ';
        } else if (info.event.title.includes("Sakit")) {
            titleHtml = '<i class="fas fa-user-slash  me-1 text-danger"></i> ';
        } else if (info.event.title.includes("Cuti")) {
            titleHtml = '<i class="fas fa-user-slash  me-1 text-warning"></i> ';
        } else if (info.event.title.includes("GH")) {
            titleHtml = '<i class="fas fa-user-slash  me-1 text-warning"></i> ';
        } else if (info.event.extendedProps.isPrivate) {
            titleHtml = '<i class="fas fa-lock me-1"></i> ';
        } else {
            titleHtml = '<i class="fas fa-calendar-alt me-1 text-info"></i> ';
        }
        
        let eventTitle = info.event.title.length > 15 ? info.event.title.substring(0, 15) + '...' : info.event.title;
        
        titleHtml += eventTitle;
        
        if (info.event.extendedProps.start_time) {
            titleHtml += '<span class="event-time">' + info.event.extendedProps.start_time + '</span>';
        }
        
        titleEl.innerHTML = titleHtml;
    }
},

eventMouseEnter: function(info) {
    let tooltipTitle = info.event.title;
    
    if (info.event.extendedProps.start_time) {
        tooltipTitle += ' (' + info.event.extendedProps.start_time + ')';
    }
    
    if (info.event.extendedProps.notes) {
        tooltipTitle += '\n' + info.event.extendedProps.notes;
    }
    
    if (info.event.extendedProps.isPrivate) {
        tooltipTitle += '\n(Event Pribadi)';
    }
    
    const tooltip = new bootstrap.Tooltip(info.el, {
        title: tooltipTitle,
        placement: 'top',
        trigger: 'hover',
        container: 'body',
        html: true
    });
}

        });

        calendar.render();
    });
</script>

<?= $this->endSection(); ?>