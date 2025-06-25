<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Kehadiran Harian</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600&display=swap" rel="stylesheet">
  <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
  <!-- Sertakan plugin Chart.js Data Labels -->
  <script src="https://cdn.jsdelivr.net/npm/chartjs-plugin-datalabels@2"></script>
  <style>
    /* Tema Dark Modern */
    body {
      background: linear-gradient(135deg, rgb(3, 15, 41), rgb(13, 41, 73));
      color: #ffffff;
      font-family: 'Poppins', sans-serif;
      padding: 20px;
      font-size: 24px;
    }
    .header-container {
      position: relative;
      display: flex;
      align-items: center;
      justify-content: space-between;
      padding: 15px 20px;
      border-radius: 10px;
      margin-bottom: 20px;  
    }
    .header-left .logo {
      height: 60px;
    }
    .header-title {
      position: absolute;
      left: 50%;
      transform: translateX(-50%);
      width: max-content;
    }
    .header-right {
      font-size: 20px;
      font-weight: bold;
      color: #ffffff;
    }
    h1 {
      text-align: center;
      font-weight: bold;
      text-transform: uppercase;
      letter-spacing: 1px;
      text-shadow: 2px 2px 10px rgba(255, 255, 255, 0.15);
      margin-top: 50px;
      margin-bottom: 30px;
    }
    .container-box {
      max-width: 98%;
      margin: auto;
    }
    .auto-scroll-table th,
    .auto-scroll-table td {
      font-weight: bold;
    }
    .card-box {
      background: rgba(255, 255, 255, 0.13);
      border-radius: 8px;
      padding: 5px;
      font-size: 14px;
      box-shadow: 0px 4px 12px rgba(255, 255, 255, 0.13);
      margin-bottom: 10px;
      font-weight: bold;
    }
    .table-container {
      background: rgba(255, 255, 255, 0.1);
      border-radius: 8px;
      padding: 15px;
      font-size: 16px;
      max-width: 100%;
      overflow: hidden;
      margin-bottom: -17px;
    }
    /* Container khusus untuk tbody yang discroll */
    .tbody-scroll-container {
      max-height: 680px;
      overflow-y: auto;
      border-radius: 10px;
      padding-bottom: 1px;
      position: relative;
    }
    .tbody-scroll-container::-webkit-scrollbar {
      width: 8px;
    }
    .tbody-scroll-container::-webkit-scrollbar-track {
      background: rgba(0, 0, 0, 0);
    }
    .tbody-scroll-container::-webkit-scrollbar-thumb {
      background: rgba(255, 255, 255, 0.09);
      border-radius: 10px;
    }
    .table {
      border-radius: 12px;
      overflow: hidden;
      table-layout: fixed;
    }
    .table thead {
      background: rgba(0, 0, 0, 0.8);
    }
    .table tbody tr:hover {
      background-color: rgba(255, 255, 255, 0.09);
      transition: 0.3s;
    }
    .table th,
    .table td {
      padding: 3px;
      vertical-align: middle;
    }
    /* Badge Kehadiran */
    .badge-success { background-color: #28a745; }
    .badge-danger { background-color: #dc3545; }
    .badge-warning { background-color: #ffc107; color: black; }
    .status-list {
      display: flex;
      flex-wrap: wrap;
      justify-content: center;
      gap: 2px;
      padding: 10px 0;
    }
    .status-list .badge {
      font-size: 16px;
      padding: 10px 15px;
      border-radius: 8px;
    }
  </style>
</head>
<body>

<div class="header-container">
  <div class="header-left">
    <!-- Logo -->
    <a href="<?= base_url('outdoor-activity') ?>">
      <img src="<?= base_url('assets/images/logo2.png') ?>" alt="Logo" class="logo">
    </a>
  </div>
  <div class="header-title">
    <h1>Kehadiran & Posisi Man Power R&D</h1>
  </div>
  <div class="header-right">
    <span id="real-time-clock"></span>
  </div>
</div>

<div class="container-box">
  <!-- Tabel Kehadiran: Header dan Body dipisah -->
  <div class="container-box">
    <!-- Header -->
    <div class="card-box d-flex justify-content-between align-items-center p-3 bg-dark rounded">
      <div>
        <h4 class="text-light m-0"><b>Daftar Outdoor Activity</b></h4>
        <p class="text-light mb-0"><b>Data aktivitas outdoor untuk pencatatan kehadiran dan posisi keberadaan</b></p>
      </div>
      <div class="status-list text-end">
        <?php 
        foreach ($statusMapping as $code => $text):
            $count = 0;
            foreach ($statusCounts as $sc) {
                if ($sc['kehadiran'] == $code) {
                    $count = $sc['total'];
                    break;
                }
            }
            $badgeClass = match($code) {
                1 => 'badge-success',
                3,4,5,6 => 'badge-danger',
                7 => 'badge-warning',
                default => 'badge-secondary',
            };
        ?>
        <span class="badge <?= $badgeClass ?> mx-1">
            <?= $text ?>: <?= $count ?>
        </span>
        <?php endforeach; ?>
      </div>
    </div>

    <!-- Grid Layout -->
    <div class="row">
<?php 
// Assuming you have a function to get week dates similar to piket controller
// You'll need to add this function to your controller or helper
function getWeekDates($week = 0) {
    $today = date('Y-m-d');
    $currentMonday = date('Y-m-d', strtotime('monday this week', strtotime($today)));
    $start = strtotime("+{$week} week", strtotime($currentMonday));
    $dates = [];

    for ($i = 0; $i < 5; $i++) { // Monday to Friday
        $dates[] = date('Y-m-d', strtotime("+{$i} day", $start));
    }

    return $dates;
}

// Get current week dates
$weekDates = getWeekDates(0); // Current week

// Group activities by date instead of group
$activitiesByDate = [];
foreach ($weekDates as $date) {
    $activitiesByDate[$date] = array_filter($activities, function($act) use ($date) {
        // Check for different possible date field names
        if (isset($act['dates'])) {
            return $act['dates'] == $date;
        } elseif (isset($act['date'])) {
            return $act['date'] == $date;
        } elseif (isset($act['created_at'])) {
            return date('Y-m-d', strtotime($act['created_at'])) == $date;
        } elseif (isset($act['activity_date'])) {
            return $act['activity_date'] == $date;
        }
        return false;
    });
}
?>

<div class="card-body">
    <!-- Statistics Chart Row -->
    <div class="row mb-4">
        <div class="col-md-12">
            <div class="table-container bg-dark p-3 rounded">
                <h4 class="text-center text-light fw-bold">Statistik Kehadiran Mingguan</h4>
                <div class="text-center mt-3">
                    <canvas id="attendanceChart" style="max-height: 170px;"></canvas>
                    <div class="d-flex justify-content-center align-items-center gap-3 small-text mt-2">
                        <span>Persentase Kehadiran Mingguan: <span class="highlight"><?= $weeklyPercentage; ?>%</span></span>
                        <span>Persentase Kehadiran Bulanan: <span class="highlight"><?= $monthlyPercentage; ?>%</span></span>
                    </div>
                    <style>
                        .small-text {
                            font-size: 14px;
                        }
                        .highlight {
                            font-weight: bold;
                            text-decoration: underline;
                        }
                    </style>
                </div>
            </div>
        </div>
    </div>

    <!-- Daily Activities Row -->
    <div class="row">
        <?php foreach ($weekDates as $tgl): ?>
            <div class="col-md-6 col-lg-2 mb-4">
                <div class="schedule-day border rounded shadow-sm h-100 d-flex flex-column">
                    <?php $isHoliday = in_array($tgl, $holiday_dates ?? []); ?>
                    <div class="text-center py-3 <?= $isHoliday ? 'bg-danger' : 'bg-primary' ?> text-white rounded-top">
                        <div class="font-weight-bold small"><?=$tgl ?></div>
                        <div class="small"><?= date('d M Y', strtotime($tgl)) ?></div>
                    </div>
                    <div class="p-3 flex-fill bg-white" style="min-height: 400px; border-radius: 0 0 0.375rem 0.375rem;">
                        <?php if (!empty($activitiesByDate[$tgl])): ?>
                            <?php 
                            // Sort activities by group for better organization
                            $dayActivities = $activitiesByDate[$tgl];
                            usort($dayActivities, function($a, $b) {
                                return $a['group'] <=> $b['group'];
                            });
                            ?>
                            <?php foreach ($dayActivities as $index => $act): ?>
                                <div class="d-flex align-items-center border rounded bg-light shadow-sm p-2 mb-2 position-relative">
                                    <div class="position-absolute" style="top: 5px; left: 5px; background: #007bff; color: white; border-radius: 50%; width: 20px; height: 20px; display: flex; align-items: center; justify-content: center; font-size: 10px; font-weight: bold;">
                                        G<?= $act['group'] ?>
                                    </div>
                                    <img src="<?= empty($act['foto']) ? base_url('assets/images/person.jpg') : base_url('uploads/users/' . $act['foto']) ?>"
                                         class="rounded-circle mr-2"
                                         width="35" height="35"
                                         style="width: 35px; height: 35px; object-fit: cover; object-position: center; border: 2px solid #6c757d; margin-left: 25px;">
                                    <div class="flex-fill">
                                        <div class="font-weight-bold text-dark small"><?= esc($act['nickname']) ?></div>
                                        <div class="text-muted" style="font-size: 11px;">
                                            <?php 
                                            $status = $act['kehadiran'];
                                            if ($status == 1): ?> 
                                                <span class="badge badge-success badge-sm">Hadir</span> 
                                            <?php elseif (in_array($status, [3, 4, 5, 6])): ?> 
                                                <span class="badge badge-danger badge-sm"><?= $statusMapping[$status] ?? 'Tidak Diketahui' ?></span>
                                            <?php elseif ($status == 7): ?>
                                                <span class="badge badge-warning badge-sm">Shift Malam</span>
                                            <?php else: ?>
                                                <span class="badge badge-secondary badge-sm">-</span>
                                            <?php endif; ?>
                                        </div>
                                        <?php if (!empty($act['keterangan'])): ?>
                                            <div class="text-muted" style="font-size: 10px;"><?= esc($act['keterangan']) ?></div>
                                        <?php endif; ?>
                                    </div>
                                </div>
                            <?php endforeach ?>
                        <?php else: ?>
                            <div class="text-muted small text-center mt-4">
                                <i class="fa fa-calendar-times fa-2x mb-2"></i>
                                <div>Tidak ada aktivitas</div>
                            </div>
                        <?php endif ?>
                    </div>
                </div>
            </div>
        <?php endforeach ?>
    </div>

    <!-- Summary by Group Row -->
    <div class="row mt-4">
        <div class="col-12">
            <div class="table-container bg-dark p-3 rounded">
                <h5 class="text-center text-light fw-bold mb-3">Ringkasan per Grup</h5>
                <div class="row">
                    <?php 
                    $groups = [1, 2, 3, 4, 5, 7]; // Adjust according to your groups
                    foreach ($groups as $groupNum): 
                        $filteredActivities = array_filter($activities, function($act) use ($groupNum) {
                            return $act['group'] == $groupNum;
                        });
                        $presentCount = count(array_filter($filteredActivities, function($act) {
                            return $act['kehadiran'] == 1;
                        }));
                        $totalCount = count($filteredActivities);
                        $percentage = $totalCount > 0 ? round(($presentCount / $totalCount) * 100, 1) : 0;
                    ?>
                        <div class="col-md-2 mb-3">
                            <div class="bg-light p-3 rounded text-center">
                                <h6 class="font-weight-bold text-dark">Grup <?= $groupNum ?></h6>
                                <div class="text-success font-weight-bold"><?= $presentCount ?>/<?= $totalCount ?></div>
                                <div class="text-muted small"><?= $percentage ?>% Hadir</div>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
.badge-sm {
    font-size: 9px;
    padding: 2px 6px;
}

.schedule-day {
    transition: transform 0.2s ease-in-out;
}

.schedule-day:hover {
    transform: translateY(-2px);
    box-shadow: 0 4px 8px rgba(0,0,0,0.1) !important;
}

.table-container {
    box-shadow: 0 2px 4px rgba(0,0,0,0.1);
}
</style>
    </div>
  </div>
</div>

<script>
  $(document).ready(function(){
    var $scrollContainer = $('.tbody-scroll-container');

    function autoScroll() {
      var scrollSpeed = 40;
      var step = 1;
      var scrollInterval = setInterval(function() {
        if ($scrollContainer.scrollTop() + $scrollContainer.innerHeight() >= $scrollContainer[0].scrollHeight) {
          $scrollContainer.css("scroll-behavior", "auto").scrollTop(0);
          setTimeout(() => $scrollContainer.css("scroll-behavior", "smooth"), 50);
        } else {
          $scrollContainer.scrollTop($scrollContainer.scrollTop() + step);
        }
      }, scrollSpeed);
      $scrollContainer.hover(
        function() { clearInterval(scrollInterval); },
        function() { autoScroll(); }
      );
    }
    autoScroll();
  });
</script>

<script>
  function updateClock() {
    const now = new Date();
    const days = ['Minggu', 'Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat', 'Sabtu'];
    const dayName = days[now.getDay()];
    const months = ['Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni', 'Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember'];
    const monthName = months[now.getMonth()];
    const date = now.getDate();
    const year = now.getFullYear();
    const hours = now.getHours().toString().padStart(2, '0');
    const minutes = now.getMinutes().toString().padStart(2, '0');
    const seconds = now.getSeconds().toString().padStart(2, '0');
    const formattedTime = `${dayName}, ${date} ${monthName} ${year} - ${hours}:${minutes}:${seconds}`;
    document.getElementById('real-time-clock').textContent = formattedTime;
  }
  setInterval(updateClock, 1000);
  updateClock();
</script>
<script>
  // Ambil data chart dari controller
  let chartData = <?php echo json_encode($chartData); ?>;
  let labels = [];
  let hadirData = [];
  let tidakHadirData = [];
  const daysOfWeek = ['Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat', 'Sabtu', 'Minggu'];
  daysOfWeek.forEach(function(day) {
    labels.push(day);
    hadirData.push(chartData[day].hadir);
    tidakHadirData.push(chartData[day].tidak_hadir);
  });
  let holidayList = <?php echo json_encode($holidayList); ?>;
  let holidayDays = [];
  if (holidayList && holidayList.length > 0) {
    holidayList.forEach(function(holiday) {
      let dateObj = new Date(holiday.holiday_date);
      let dayIndex = dateObj.getDay();
      let dayName = '';
      switch(dayIndex) {
        case 0: dayName = 'Minggu'; break;
        case 1: dayName = 'Senin'; break;
        case 2: dayName = 'Selasa'; break;
        case 3: dayName = 'Rabu'; break;
        case 4: dayName = 'Kamis'; break;
        case 5: dayName = 'Jumat'; break;
        case 6: dayName = 'Sabtu'; break;
      }
      if (!holidayDays.includes(dayName)) {
        holidayDays.push(dayName);
      }
    });
  }
  const ctx = document.getElementById('attendanceChart').getContext('2d');
  const attendanceChart = new Chart(ctx, {
    type: 'bar',
    data: {
      labels: labels,
      datasets: [{
        label: 'Hadir',
        data: hadirData,
        backgroundColor: '#28a745'
      },{
        label: 'Tidak Hadir',
        data: tidakHadirData,
        backgroundColor: '#dc3545'
      }]
    },
    options: {
      plugins: {
        datalabels: {
          anchor: 'center',
          align: 'center',
          color: 'white',
          formatter: function(value, context) {
            return value === 0 ? '' : value;
          },
          font: {
            weight: 'bold'
          }
        },
        title: { display: false },
        legend: {
          labels: {
            color: 'white',
            font: { weight: 'bold' }
          }
        }
      },
      responsive: true,
      scales: {
        x: {
          stacked: true,
          ticks: {
            color: function(context) {
              let label = context.tick.label;
              if (label === 'Sabtu' || label === 'Minggu' || holidayDays.includes(label)) {
                return 'red';
              }
              return 'white';
            },
            font: { weight: 'bold' }
          }
        },
        y: {
          stacked: true,
          beginAtZero: true,
          ticks: {
            color: 'white',
            font: { weight: 'bold' }
          }
        }   
      }
    },
    plugins: [ChartDataLabels]
  });
</script>
<script>
    setInterval(function() {
      location.reload();
    }, 60000);
  </script>
</body>
</html>
