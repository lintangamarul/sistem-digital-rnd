<?= $this->extend('layout/template'); ?> 
<?= $this->section('content'); ?>

<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">

<style>
/* Day Indicator Styling */
.day-indicator {
    width: 45px;
    height: 45px;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 16px;
    font-weight: bold;
    margin: 0 auto 8px;
    color: white;
    box-shadow: 0 2px 6px rgba(0,0,0,0.15);
    transition: transform 0.2s ease;
}

.day-indicator:hover {
    transform: scale(1.05);
}

.day-indicator.monday { background: linear-gradient(135deg, #007bff, #0056b3); }
.day-indicator.tuesday { background: linear-gradient(135deg, #28a745, #1e7e34); }
.day-indicator.wednesday { background: linear-gradient(135deg, #ffc107, #e0a800); color: #000; }
.day-indicator.thursday { background: linear-gradient(135deg, #dc3545, #c82333); }
.day-indicator.friday { background: linear-gradient(135deg, #6f42c1, #5a32a3); }

/* Card Styling */
.card {
    border: none;
    border-radius: 10px;
    box-shadow: 0 2px 8px rgba(0,0,0,0.08);
    transition: all 0.3s ease;
    margin-bottom: 1rem;
}

.card:hover {
    box-shadow: 0 4px 15px rgba(0,0,0,0.12);
    transform: translateY(-2px);
}

.card-header {
    background: linear-gradient(135deg, #f8f9fa, #e9ecef);
    border-bottom: 1px solid #dee2e6;
    border-radius: 10px 10px 0 0 !important;
    padding: 0.75rem 1rem;
}

.card-body {
    padding: 1rem;
}

/* Schedule Card Specific */
.schedule-card {
    transition: all 0.3s ease;
    border: 1px solid #e3e6f0;
    border-radius: 10px;
    height: 100%;
    margin-bottom: 0.75rem;
}

.schedule-card:hover {
    transform: translateY(-2px);
    box-shadow: 0 4px 15px rgba(0,0,0,0.12);
    border-color: #007bff;
}

.schedule-date {
    position: absolute;
    top: 10px;
    right: 10px;
    text-align: center;
    background: linear-gradient(135deg, #f8f9fa, #e9ecef);
    border-radius: 8px;
    padding: 6px 10px;
    box-shadow: 0 2px 4px rgba(0,0,0,0.1);
    min-width: 45px;
}

.schedule-date h6 {
    font-size: 1rem;
    font-weight: 700;
    margin-bottom: 2px;
    color: #495057;
}

.schedule-date small {
    font-size: 0.7rem;
    color: #6c757d;
    text-transform: uppercase;
    font-weight: 600;
}

/* Month Section */
.schedule-month {
    margin-bottom: 1.5rem;
    background: #fff;
    border-radius: 10px;
    padding: 1rem;
    box-shadow: 0 2px 8px rgba(0,0,0,0.06);
}

.schedule-month h6 {
    font-size: 1.1rem;
    font-weight: 600;
    margin-bottom: 1rem;
    padding-bottom: 0.5rem;
    border-bottom: 2px solid #e9ecef;
}

/* User Profile Card */
.profile-card {
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    color: white;
    border-radius: 12px;
    overflow: hidden;
    margin-bottom: 1rem;
}

.profile-card .card-body {
    position: relative;
    z-index: 2;
    padding: 1rem;
}

.profile-card::before {
    content: '';
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    background: rgba(255,255,255,0.1);
    z-index: 1;
}

.profile-stats {
    background: rgba(255,255,255,0.15);
    border-radius: 8px;
    padding: 0.75rem;
    margin-top: 0.75rem;
    backdrop-filter: blur(10px);
}

.profile-stats h3 {
    font-size: 1.5rem;
    font-weight: 700;
    margin-bottom: 0.25rem;
}

/* Statistics Cards */
.stat-item {
    padding: 1rem;
    border-radius: 10px;
    background: linear-gradient(135deg, #f8f9fa, #ffffff);
    border: 1px solid #e9ecef;
    height: 100%;
    transition: all 0.3s ease;
    margin-bottom: 0.75rem;
}

.stat-item:hover {
    transform: translateY(-2px);
    box-shadow: 0 4px 12px rgba(0,0,0,0.1);
}

.stat-item h4 {
    font-size: 1.5rem;
    font-weight: 700;
    margin-bottom: 0.25rem;
}

/* Badge Improvements */
.badge {
    font-size: 0.75rem;
    padding: 0.4rem 0.6rem;
    border-radius: 15px;
    font-weight: 500;
}

/* Empty State */
.empty-state {
    text-align: center;
    padding: 3rem 1.5rem;
    color: #6c757d;
}

.empty-state i {
    font-size: 3rem;
    margin-bottom: 1rem;
    opacity: 0.6;
}

.empty-state h5 {
    font-size: 1.3rem;
    margin-bottom: 0.75rem;
    color: #495057;
}

/* Distribution Chart */
.distribution-chart {
    background: #f8f9fa;
    border-radius: 10px;
    padding: 1rem;
}

.distribution-item {
    text-align: center;
    padding: 0.5rem;
}

.distribution-item small {
    font-weight: 600;
    text-transform: uppercase;
    color: #6c757d;
    font-size: 0.7rem;
}

/* Responsive Improvements */
@media (max-width: 768px) {
    .schedule-card {
        margin-bottom: 0.75rem;
    }
    
    .schedule-date {
        position: relative;
        top: auto;
        right: auto;
        margin-bottom: 0.75rem;
        display: inline-block;
    }
    
    .day-indicator {
        width: 40px;
        height: 40px;
        font-size: 14px;
    }
    
    .stat-item {
        margin-bottom: 0.75rem;
    }
}

/* Page Header */
.page-header {
    background: linear-gradient(135deg, #ffffff, #f8f9fa);
    border-radius: 10px;
    padding: 1rem;
    margin-bottom: 1rem;
    border: 1px solid #e9ecef;
}

.page-header h4 {
    color: #495057;
    font-weight: 600;
    margin-bottom: 0.25rem;
    font-size: 1.2rem;
}

.page-header p {
    margin-bottom: 0;
    font-size: 0.9rem;
}

/* Button Improvements */
.btn {
    border-radius: 6px;
    padding: 0.5rem 1rem;
    font-weight: 500;
    transition: all 0.3s ease;
}

.btn:hover {
    transform: translateY(-1px);
    box-shadow: 0 3px 10px rgba(0,0,0,0.15);
}

/* Compact spacing */
.mb-4 { margin-bottom: 1rem !important; }
.mb-3 { margin-bottom: 0.75rem !important; }
.mb-2 { margin-bottom: 0.5rem !important; }

/* Schedule card content spacing */
.schedule-card .card-body {
    padding: 0.75rem;
}

.schedule-card h6 {
    font-size: 0.95rem;
    margin-bottom: 0.25rem;
}

.schedule-card p {
    font-size: 0.8rem;
    margin-bottom: 0.5rem;
}

.schedule-card .badge {
    font-size: 0.7rem;
    padding: 0.25rem 0.5rem;
}
</style>

<div class="pd-ltr-20 xs-pd-20-10">
    <div class="min-height-200px">
        <!-- Page Header -->
        <div class="page-header d-flex justify-content-between align-items-center mb-3">
            <div>
                <h4>Jadwal Briefing - <?= $user['nama']; ?></h4>
                <p class="text-muted">Prediksi jadwal briefing 3 bulan ke depan</p>
            </div>
            <div>
                <a href="<?= site_url('briefing/calendar'); ?>" class="btn btn-primary">
                    <i class="fas fa-arrow-left"></i> Kembali ke Kalender
                </a>
            </div>
        </div>

        <!-- User Profile & Distribution Section -->
        <div class="row mb-3">
            <!-- User Profile Card -->
            <div class="col-lg-4 mb-3">
                <div class="card profile-card">
                    <div class="card-body text-center">
                        <div class="mb-2">
                            <i class="fas fa-user-tie fa-2x"></i>
                        </div>
                        <h5 class="mb-1"><?= $user['nama']; ?></h5>
                        <p class="mb-0 opacity-75 small">NIK: <?= $user['nik']; ?></p>
                        
                        <div class="profile-stats">
                            <div class="row">
                                <div class="col-6">
                                    <h3><?= count($schedule); ?></h3>
                                    <small>Total Hari</small>
                                </div>
                                <div class="col-6">
                                    <h3><?= count(array_unique(array_column($schedule, 'date'))); ?></h3>
                                    <small>Hari Unik</small>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Distribution Chart -->
            <div class="col-lg-8 mb-3">
                <div class="card">
                    <div class="card-header">
                        <h6 class="mb-0"><i class="fas fa-chart-bar me-2"></i> Distribusi Hari</h6>
                    </div>
                    <div class="card-body">
                        <?php 
                        $dayCount = [];
                        foreach ($schedule as $item) {
                            $dayName = date('l', strtotime($item['date']));
                            $dayCount[$dayName] = ($dayCount[$dayName] ?? 0) + 1;
                        }
                        ?>
                        <div class="distribution-chart">
                            <div class="row">
                                <?php foreach (['Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday'] as $day): ?>
                                <div class="col distribution-item">
                                    <div class="day-indicator <?= strtolower($day); ?>">
                                        <?= $dayCount[$day] ?? 0; ?>
                                    </div>
                                    <small><?= substr($day, 0, 3); ?></small>
                                </div>
                                <?php endforeach; ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Schedule Content -->
        <?php if (!empty($schedule)): ?>
        <div class="card mb-3">
            <div class="card-header">
                <h5 class="mb-0">
                    <i class="fas fa-calendar-alt me-2"></i> Jadwal Lengkap
                </h5>
            </div>
            <div class="card-body">
                <?php 
                $scheduleByMonth = [];
                foreach ($schedule as $item) {
                    $monthYear = date('F Y', strtotime($item['date']));
                    $scheduleByMonth[$monthYear][] = $item;
                }
                ?>
                
                <?php foreach ($scheduleByMonth as $month => $monthSchedule): ?>
                <div class="schedule-month">
                    <h6 class="text-primary">
                        <i class="fas fa-calendar me-2"></i><?= $month; ?>
                        <span class="badge badge-primary ms-2"><?= count($monthSchedule); ?> hari</span>
                    </h6>
                    
                    <div class="row">
                        <?php foreach ($monthSchedule as $item): ?>
                        <div class="col-md-6 col-xl-4 mb-2">
                            <div class="card schedule-card position-relative">
                                <div class="card-body">
                                    <div class="schedule-date">
                                        <h6 class="mb-0"><?= date('d', strtotime($item['date'])); ?></h6>
                                        <small><?= date('M', strtotime($item['date'])); ?></small>
                                    </div>
                                    
                                    <div class="text-center mt-2">
                                        <h6 class="mb-1 text-dark"><?= $item['day_name']; ?></h6>
                                        <p class="text-muted mb-2 small"><?= date('d M Y', strtotime($item['date'])); ?></p>
                                        
                                        <?php
                                        $dayClass = '';
                                        switch ($item['day_name']) {
                                            case 'Monday': $dayClass = 'badge-primary'; break;
                                            case 'Tuesday': $dayClass = 'badge-success'; break;
                                            case 'Wednesday': $dayClass = 'badge-warning'; break;
                                            case 'Thursday': $dayClass = 'badge-danger'; break;
                                            case 'Friday': $dayClass = 'badge-info'; break;
                                        }
                                        ?>
                                        <span class="badge <?= $dayClass; ?> mb-1">
                                            Briefing Leader
                                        </span>
                                        
                                        <div class="mt-1">
                                            <small class="text-muted">
                                                <i class="fas fa-clock me-1"></i>
                                                <?= date('D, d M Y', strtotime($item['date'])); ?>
                                            </small>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <?php endforeach; ?>
                    </div>
                </div>
                <?php endforeach; ?>
            </div>
        </div>

        <!-- Summary Statistics -->
        <div class="card">
            <div class="card-header">
                <h6 class="mb-0"><i class="fas fa-chart-line me-2"></i> Ringkasan Statistik</h6>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-6 col-xl-3 mb-2">
                        <div class="stat-item text-center">
                            <h4 class="text-primary"><?= count($schedule); ?></h4>
                            <p class="text-muted mb-0 small">Total Hari Memimpin</p>
                        </div>
                    </div>
                    <div class="col-md-6 col-xl-3 mb-2">
                        <div class="stat-item text-center">
                            <h4 class="text-success"><?= round(count($schedule) / 3, 1); ?></h4>
                            <p class="text-muted mb-0 small">Rata-rata per Bulan</p>
                        </div>
                    </div>
                    <div class="col-md-6 col-xl-3 mb-2">
                        <div class="stat-item text-center">
                            <h4 class="text-info">
                                <?php if (!empty($schedule)): ?>
                                    <?= date('d M', strtotime($schedule[0]['date'])); ?>
                                <?php else: ?>
                                    -
                                <?php endif; ?>
                            </h4>
                            <p class="text-muted mb-0 small">Jadwal Pertama</p>
                        </div>
                    </div>
                    <div class="col-md-6 col-xl-3 mb-2">
                        <div class="stat-item text-center">
                            <h4 class="text-warning">
                                <?php if (!empty($schedule)): ?>
                                    <?= date('d M', strtotime(end($schedule)['date'])); ?>
                                <?php else: ?>
                                    -
                                <?php endif; ?>
                            </h4>
                            <p class="text-muted mb-0 small">Jadwal Terakhir</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <?php else: ?>
        <!-- Empty State -->
        <div class="card">
            <div class="card-body">
                <div class="empty-state">
                    <i class="fas fa-calendar-times"></i>
                    <h5>Tidak Ada Jadwal</h5>
                    <p class="mb-3">User ini belum memiliki jadwal briefing dalam 3 bulan ke depan</p>
                    <a href="<?= site_url('briefing'); ?>" class="btn btn-primary">
                        <i class="fas fa-plus me-2"></i> Atur Jadwal
                    </a>
                </div>
            </div>
        </div>
        <?php endif; ?>
    </div>
</div>

<?= $this->endSection(); ?>