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
      padding: 15px;
      font-size: 24px;
      margin: 0;
      overflow: hidden; /* Hilangkan scroll */
      height: 100vh; /* Fixed height */
    }
    .header-container {
      position: relative;
      display: flex;
      align-items: center;
      justify-content: space-between;
      padding: 10px 20px;
      border-radius: 0px;
      margin-bottom: 25px;  
    }
    .header-left .logo {
      height: 50px;
    }
    .header-title {
      position: absolute;
      left: 50%;
      transform: translateX(-50%);
      width: max-content;
    }
    .header-title h1 {
      font-size: 28px;
      margin: 0;
      text-align: center;
      font-weight: bold;
      text-transform: uppercase;
      letter-spacing: 1px;
      text-shadow: 2px 2px 10px rgba(255, 255, 255, 0.15);
    }
    .header-right {
      font-size: 16px;
      font-weight: bold;
      color: #ffffff;
    }
    .container-box {
      max-width: 100%;
      margin: auto;
      padding: 0 10px;
    }
  
    .card-box {
      background: rgba(255, 255, 255, 0.13);
      border-radius: 8px;
      padding: 15px;
      font-size: 14px;
      box-shadow: 0px 4px 12px rgba(255, 255, 255, 0.13);
      margin-bottom: 45px;
      font-weight: bold;
    }
    .table-container {
      background: rgba(255, 255, 255, 0.1);
      border-radius: 8px;
      padding: 12px;
      font-size: 16px;
      max-width: 100%;
      overflow: hidden;
      margin-bottom: 0;
      height: 310px;
      display: flex;
      flex-direction: column;
    }
    .chart-container {
      background: rgba(255, 255, 255, 0.1);
      border-radius: 8px;
      padding: 15px;
      height: 310px;
      display: flex;
      flex-direction: column;
    }
    .chart-container h4 {
      margin-bottom: 15px;
      font-size: 18px;
    }
    .chart-wrapper {
      flex: 1;
      display: flex;
      flex-direction: column;
      justify-content: center;
      align-items: center;
    }
    .chart-info {
      margin-top: 10px;
      display: flex;
      flex-direction: column;
      gap: 5px;
      font-size: 12px;
      text-align: center;
    }
    .chart-placeholder {
      background: rgba(255, 255, 255, 0.05);
      border: 2px dashed rgba(255, 255, 255, 0.3);
      border-radius: 8px;
      flex: 1;
      display: flex;
      align-items: center;
      justify-content: center;
      color: rgba(255, 255, 255, 0.7);
      font-size: 14px;
    }
    
    .table {
      border-radius: 12px;
      overflow: hidden;
      table-layout: fixed;
      margin-bottom: 0;
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
      padding: 12px 8px;
      vertical-align: middle;
      font-size: 16px;
    }
    .table-container h4 {
      text-align: center;
      font-weight: bold;
      margin-bottom: 10px;
      font-size: 21px;
    }
    /* Badge Kehadiran */
    .badge-success { 
      background-color: #28a745; 
      font-size: 11px;
      padding: 4px 8px;
    }
    .badge-danger { 
      background-color: #dc3545; 
      font-size: 11px;
      padding: 4px 8px;
    }
    .badge-warning { 
      background-color: #ffc107; 
      color: black; 
      font-size: 11px;
      padding: 4px 8px;
    }
    .status-list {
      display: flex;
      flex-wrap: wrap;
      justify-content: center;
      gap: 8px;
      padding: 5px 0;
    }
    .status-list .badge {
      font-size: 14px;
      padding: 8px 12px;
      border-radius: 6px;
    }

    /* Style untuk Jadwal Piket */
    .piket-container {
      background: rgba(255, 255, 255, 0.1);
      border-radius: 8px;
      padding: 15px;
      height: 310px;
      display: flex;
      flex-direction: column;
    }

    .piket-wrapper {
      display: flex;
      height: 100%;
      gap: 10px;
    }

    .piket-column {
      flex: 1;
      padding: 10px;
      display: flex;
      flex-direction: column;
    }

    .piket-today {
      border-right: 1px solid rgba(255, 255, 255, 0.2);
    }

    .piket-header {
      text-align: center;
      margin-bottom: 10px;
      font-weight: bold;
      font-size: 16px;
    }

    .piket-list {
      flex: 1;
      overflow-y: auto;
      border-radius: 6px;
      background: #212529;
    }

    .piket-list ul {
      list-style-type: none;
      padding: 0;
      margin: 0;
    }

    .piket-list li {
      padding: 10px;
      text-align: center;
      border-bottom: 1px solid rgba(255, 255, 255, 0.1);
      font-size: 16px;
    }

    .piket-list li:last-child {
      border-bottom: none;
    }

    .no-piket {
      text-align: center;
      padding: 20px;
      color: rgba(255, 255, 255, 0.6);
      font-size: 14px;
    }

    .piket-list::-webkit-scrollbar {
      width: 5px;
    }

    .piket-list::-webkit-scrollbar-track {
      background: rgba(0, 0, 0, 0.1);
    }

    .piket-list::-webkit-scrollbar-thumb {
      background: rgba(255, 255, 255, 0.2);
      border-radius: 5px;
    }

    /* Grid Layout Optimization */
    .main-grid {
        display: grid;
        grid-template-columns: 1fr 1fr 1fr 1fr;
        grid-template-rows: 1fr 1fr;
        gap: 15px 15px; 
          row-gap: 1px; /* Jarak vertikal diperkecil drastis dari 8px ke 3px */
        height: calc(100vh - 300px); /* Kurangi height untuk menghindari scroll */
        min-height: 700px;
      }
    .grid-item {
      display: flex;
      flex-direction: column;
    }
    /* Responsive adjustments */
    @media (max-width: 1600px) {
  .main-grid {
    min-height: 650px;
    row-gap: 2px; /* Kurangi lebih jauh untuk layar kecil */
  }
  .table th, .table td {
    font-size: 18px;
    padding: 10px 6px;
  }
}

@media (max-width: 1400px) {
  .header-title h1 {
    font-size: 24px;
  }
  .main-grid {
    min-height: 600px;
    row-gap: 1px; /* Jarak minimal untuk layar kecil */
  }
  .table th, .table td {
    padding: 8px 5px;
  }
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
  <!-- Header -->
  <div class="card-box d-flex justify-content-between align-items-center bg-dark rounded">
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

  <!-- Main Grid Layout: 4 kolom x 2 baris -->
  <div class="main-grid">
    <!-- Baris Pertama: Group 1, 2, 3, 4 -->
    <?php 
    $topGroups = [1, 2, 3, 4];
    foreach ($topGroups as $groupNum): 
        $filteredActivities = array_filter($activities, function($act) use ($groupNum) {
            return $act['group'] == $groupNum;
        });
    ?>
    <div class="grid-item">
      <div class="table-container">
        <h4 class="text-light">Group <?= $groupNum ?></h4>
        <!-- Table Header -->
        <table class="table table-dark table-hover text-center table-header">
          <colgroup>
            <col style="width:15%;">
            <col style="width:35%;">
            <col style="width:25%;">
            <col style="width:25%;">
          </colgroup>
          <thead >
            <tr class="fw-bold">
              <th>No</th>
              <th>Nama</th>
              <th>Kehadiran</th>
              <th>Posisi</th>
            </tr>
          </thead>
        </table>
        <div class="mb-1"></div>

          <table class="table table-dark table-hover text-center">
            <colgroup>
              <col style="width:15%;">
              <col style="width:35%;">
              <col style="width:25%;">
              <col style="width:25%;">
            </colgroup>
            <tbody>
              <?php if (!empty($filteredActivities)): ?>
                <?php $i = 1; foreach ($filteredActivities as $act): ?>
                  <tr>
                    <td><b><?= $i++; ?></b></td>
                    <td><b><?= $act['nickname'] ?></b></td>
                    <td>
                      <?php 
                      $status = $act['kehadiran'];
                      if ($status == 1): ?> 
                        <span class="badge badge-success">Hadir</span> 
                      <?php elseif (in_array($status, [3, 4, 5, 6])): ?> 
                        <span class="badge badge-danger"><?= $statusMapping[$status] ?? 'Tidak Diketahui' ?></span>
                      <?php elseif ($status == 7): ?>
                        <span class="badge badge-warning">Shift Malam</span>
                      <?php else: ?>
                        -
                      <?php endif; ?>
                    </td>
                    <td><b><?= !empty($act['keterangan']) ? $act['keterangan'] : '-' ?></b></td>
                  </tr>
                <?php endforeach; ?>
              <?php else: ?>
                <tr>
                  <td colspan="4" class="text-center"><b>Data tidak ditemukan</b></td>
                </tr>
              <?php endif; ?>
            </tbody>
          </table>
    
      </div>
    </div>
    <?php endforeach; ?>

    <!-- Baris Kedua: Group 5, Grafik 1, Grafik 2, Group 7 -->
    <?php 
    $filteredActivitiesGroup5 = array_filter($activities, function($act) {
        return $act['group'] == 5;
    });
    ?>
    <!-- Group 5 -->
    <div class="grid-item">
      <div class="table-container">
        <h4 class="text-light">Group 5</h4>
        <!-- Table Header -->
        <table class="table table-dark table-hover text-center table-header">
          <colgroup>
            <col style="width:15%;">
            <col style="width:35%;">
            <col style="width:25%;">
            <col style="width:25%;">
          </colgroup>
          <thead>
            <tr class="fw-bold">
              <th>No</th>
              <th>Nama</th>
              <th>Kehadiran</th>
              <th>Posisi</th>
            </tr>
          </thead>
        </table>
         <div class="mb-1"></div>
          <table class="table table-dark table-hover text-center">
            <colgroup>
              <col style="width:15%;">
              <col style="width:35%;">
              <col style="width:25%;">
              <col style="width:25%;">
            </colgroup>
            <tbody>
              <?php if (!empty($filteredActivitiesGroup5)): ?>
                <?php $i = 1; foreach ($filteredActivitiesGroup5 as $act): ?>
                  <tr>
                    <td><b><?= $i++; ?></b></td>
                    <td><b><?= $act['nickname'] ?></b></td>
                    <td>
                      <?php 
                      $status = $act['kehadiran'];
                      if ($status == 1): ?> 
                        <span class="badge badge-success">Hadir</span> 
                      <?php elseif (in_array($status, [3, 4, 5, 6])): ?> 
                        <span class="badge badge-danger"><?= $statusMapping[$status] ?? 'Tidak Diketahui' ?></span>
                      <?php elseif ($status == 7): ?>
                        <span class="badge badge-warning">Shift Malam</span>
                      <?php else: ?>
                        -
                      <?php endif; ?>
                    </td>
                    <td><b><?= !empty($act['keterangan']) ? $act['keterangan'] : '-' ?></b></td>
                  </tr>
                <?php endforeach; ?>
              <?php else: ?>
                <tr>
                  <td colspan="4" class="text-center"><b>Data tidak ditemukan</b></td>
                </tr>
              <?php endif; ?>
            </tbody>
          </table>
  
      </div>
    </div>

    <!-- Grafik 1 - Statistik Kehadiran Mingguan -->
    <div class="grid-item">
      <div class="chart-container">
        <h4 class="text-center text-light fw-bold">Statistik Kehadiran Mingguan</h4>
        <div class="chart-wrapper">
          <canvas id="attendanceChart" style="max-height: 200px; width: 100%;"></canvas>
          <div class="chart-info">
            <span>Persentase Kehadiran Mingguan: <span class="highlight"><?= $weeklyPercentage; ?>%</span></span>
            <span>Persentase Kehadiran Bulanan: <span class="highlight"><?= $monthlyPercentage; ?>%</span></span>
          </div>
        </div>
      </div>
    </div>

    <!-- Jadwal Piket -->
    <div class="grid-item">
      <div class="piket-container">
        <h4 class="text-center text-light fw-bold">Jadwal Piket</h4>
        <div class="piket-wrapper">
          
          <!-- Kolom Piket Hari Ini -->
          <div class="piket-column piket-today">
            <div class="piket-header text-warning">Hari Ini</div>
            <div class="piket-list">
              <?php if (!empty($piketToday)): ?>
                <ul>
                  <?php foreach ($piketToday as $nama): ?>
                    <li> <b><?= $nama ?></b></li>
                  <?php endforeach; ?>
                </ul>
              <?php else: ?>
                <div class="no-piket">Tidak ada jadwal piket hari ini</div>
              <?php endif; ?>
            </div>
          </div>

          <!-- Kolom Piket Bergilir (Besok dst) -->
          <div class="piket-column piket-rolling">
            <div id="piket-header" class="piket-header text-info">Besok</div>
            <div id="piket-list" class="piket-list">
              <!-- Diisi JS -->
            </div>
          </div>

        </div>
      </div>
    </div>

    <!-- Group 7 -->
    <?php 
    $filteredActivitiesGroup7 = array_filter($activities, function($act) {
        return $act['group'] == 7;
    });
    ?>
    <div class="grid-item">
      <div class="table-container">
        <h4 class="text-light">Group 7</h4>
        <!-- Table Header -->
        <table class="table table-dark table-hover text-center table-header">
          <colgroup>
            <col style="width:15%;">
            <col style="width:35%;">
            <col style="width:25%;">
            <col style="width:25%;">
          </colgroup>
          <thead>
            <tr class="fw-bold">
              <th>No</th>
              <th>Nama</th>
              <th>Kehadiran</th>
              <th>Posisi</th>
            </tr>
          </thead>
        </table>
        <div class="mb-1"></div>
          <table class="table table-dark table-hover text-center">
            <colgroup>
              <col style="width:15%;">
              <col style="width:35%;">
              <col style="width:25%;">
              <col style="width:25%;">
            </colgroup>
            <tbody>
              <?php if (!empty($filteredActivitiesGroup7)): ?>
                <?php $i = 1; foreach ($filteredActivitiesGroup7 as $act): ?>
                  <tr>
                    <td><b><?= $i++; ?></b></td>
                    <td><b><?= $act['nickname'] ?></b></td>
                    <td>
                      <?php 
                      $status = $act['kehadiran'];
                      if ($status == 1): ?> 
                        <span class="badge badge-success">Hadir</span> 
                      <?php elseif (in_array($status, [3, 4, 5, 6])): ?> 
                        <span class="badge badge-danger"><?= $statusMapping[$status] ?? 'Tidak Diketahui' ?></span>
                      <?php elseif ($status == 7): ?>
                        <span class="badge badge-warning">Shift Malam</span>
                      <?php else: ?>
                        -
                      <?php endif; ?>
                    </td>
                    <td><b><?= !empty($act['keterangan']) ? $act['keterangan'] : '-' ?></b></td>
                  </tr>
                <?php endforeach; ?>
              <?php else: ?>
                <tr>
                  <td colspan="4" class="text-center"><b>Data tidak ditemukan</b></td>
                </tr>
              <?php endif; ?>
            </tbody>
          </table>
      </div>
    </div>
  </div>
</div>


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
            weight: 'bold',
            size: 10
          }
        },
        title: { display: false },
        legend: {
          labels: {
            color: 'white',
            font: { weight: 'bold', size: 11 }
          }
        }
      },
      responsive: true,
      maintainAspectRatio: false,
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
            font: { weight: 'bold', size: 10 }
          }
        },
        y: {
          stacked: true,
          beginAtZero: true,
          ticks: {
            color: 'white',
            font: { weight: 'bold', size: 10 }
          }
        }   
      }
    },
    plugins: [ChartDataLabels]
  });
  const piketData = <?= json_encode(
    array_map(function($tanggal, $namaList) {
      return [
  'label' => $tanggal,

        'list' => $namaList
      ];
    }, array_keys($piketWeek), $piketWeek)
  ) ?>;

  let currentIndex = 0;

function renderPiket(data) {
  const header = document.getElementById('piket-header');
  const listContainer = document.getElementById('piket-list');

  // Ambil hari dalam bahasa Indonesia
  const dateObj = new Date(data.label);
  const dayName = daysOfWeek[dateObj.getDay()];
  const formattedLabel = `${dayName}, ${dateObj.toLocaleDateString('id-ID', { day: '2-digit', month: 'short', year: 'numeric' })}`;

  header.textContent = formattedLabel;
  listContainer.innerHTML = '';

  if (data.list && data.list.length > 0) {
    const ul = document.createElement('ul');
    data.list.forEach(nama => {
      const li = document.createElement('li');
      li.innerHTML = `<strong>${nama}</strong>`;
      ul.appendChild(li);
    });
    listContainer.appendChild(ul);
  } else {
    const div = document.createElement('div');
    div.className = 'no-piket';
    div.textContent = 'Tidak ada jadwal piket';
    listContainer.appendChild(div);
  }
}


  function rotatePiket() {
    if (piketData.length === 0) {
      document.getElementById('piket-header').textContent = 'Tidak ada jadwal piket';
      document.getElementById('piket-list').innerHTML = '';
      return;
    }

    renderPiket(piketData[currentIndex]);
    currentIndex = (currentIndex + 1) % piketData.length;
  }

  rotatePiket();
  setInterval(rotatePiket, 10000);
</script>
<script>
    setInterval(function() {
      location.reload();
    }, 60000);
</script>
</body>
</html>