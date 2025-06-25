<!-- View: dashboard/index.php -->
<?= $this->extend('layout/template') ?>
<?= $this->section('content') ?>
<div class="pd-ltr-20 xs-pd-20-10">
  <div class="min-height-200px">
    <div class="page-header">
      <h4>Dashboard Analisis Daily Report</h4>
   </div>
    <div class="card-box  pd-20 ">

    <form method="get" class="mb-3">
      <div class="row">
        <div class="col-md-4 mt-1">
          <label for="start_date">Start Date:</label>
          <input type="date" class="form-control" name="start_date" value="<?= esc($startDate) ?>">
        </div>
        <div class="col-md-4 mt-1">
          <label for="end_date">End Date:</label>
          <input type="date" class="form-control" name="end_date" value="<?= esc($endDate) ?>">
        </div>
        <div class="col-md-4 d-flex align-items-end mt-1">
          <button type="submit" class="btn btn-primary">Filter</button>
        </div>
      </div>
    </form>
</div>
    <div class="row">
      <div class="col-md-6 mt-3">
        <div class="card-box pd-20 text-center">
          <div id="projectDurationChart" style="height: 300px; width: 100%;"></div>
        </div>
      </div>
      <div class="col-md-6 mt-3">
        <div class="card-box pd-20 text-center">
          <div id="durationChart" style="height: 300px; width: 100%;"></div>
        </div>
      </div>
    </div>
    <div class="row">
      <!-- <div class="col-md-6 mt-3">
        <div class="card-box pd-20 text-center">
          <div id="stackedColumnChart" style="height: 400px; width: 100%;"></div>
        </div>
      </div> -->
      <!-- <div class="col-md-6 mt-3">
        <div class="card-box pd-20 text-center">
          <div id="packedBubbleChart" style="height: 400px; width: 100%;"></div>
        </div>
      </div> -->
    </div>
  </div>
</div>
<script src="https://code.highcharts.com/highcharts.js"></script>
<script src="https://code.highcharts.com/modules/exporting.js"></script>
<script src="https://code.highcharts.com/highcharts-more.js"></script>
<script src="https://code.highcharts.com/modules/packed-bubble.js"></script>
<script>
Highcharts.setOptions({ credits: { enabled: false } });

  // document.addEventListener('DOMContentLoaded', function () {
  //   Highcharts.chart('stackedColumnChart', {
  //     chart: { type: 'column' },
  //     title: { text: 'Data Cuti dan Ganti Hari' },  
  //     xAxis: {
  //       categories: <?= $categories ?>,
  //       title: { text: 'Tanggal' },
  //       labels: {
  //         formatter: function () {
  //           var parts = this.value.split('-');
  //           return parts[2] + '-' + parts[1] + '-' + parts[0];
  //         }
  //       }
  //     },
  //     yAxis: { min: 0, title: { text: 'Total' }, stackLabels: { enabled: true } },
  //     tooltip: {
  //       formatter: function () {
  //         return '<b>' + this.series.name + '</b><br/>' +
  //                'Jumlah: ' + this.y + '<br/>' +
  //                'Nama: ' + (this.point.custom.users.length > 0 ? this.point.custom.users.join(', ') : '-');
  //       }
  //     },
  //     plotOptions: { 
  //       column: { 
  //         stacking: 'normal', 
  //         dataLabels: { 
  //           enabled: true,
  //           formatter: function () {
  //             return this.y > 0 ? this.y : null; // Hanya tampilkan jika y > 0
  //           }
  //         } 
  //       } 
  //     },
  //     series: <?= $chartData ?>
  //   });
  // });


const durationData = <?= json_encode($durationData) ?>;
const projectDurationChartData = <?= $projectDurationChartData ?>;
const durationChartData = durationData.map(item => ({
  name: item.activities_name,
  y: parseInt(item.total_duration)
}));
const blueShades = ['#004080', '#0059b3', '#0073e6', '#3399ff', '#66b2ff', '#99ccff'];
Highcharts.chart('durationChart', {
  chart: { type: 'pie' },
  title: { text: 'Durasi berdasarkan Aktivitas' },
  plotOptions: {
    pie: {
      allowPointSelect: true,
      cursor: 'pointer',
      colors: blueShades,
      dataLabels: { enabled: true, format: '{point.name}: {point.y} menit' }
    }
  },
  series: [{
    name: 'Durasi',
    colorByPoint: true,
    data: durationChartData
  }]
});
document.addEventListener('DOMContentLoaded', function () {
  Highcharts.chart('projectDurationChart', {
    chart: { type: 'pie' },
    title: { text: 'Durasi berdasarkan Proyek (Klik chart untuk detail)' },
    plotOptions: {
      pie: {
        allowPointSelect: true,
        cursor: 'pointer',
        dataLabels: { enabled: true, format: '{point.name}: {point.y} menit' },
        point: {
          events: {
            click: function () {
              if (this.model) {
                let modelEncoded = encodeURIComponent(this.model);
                window.location.href = '<?= site_url("dashboard/projectDetail/") ?>' + modelEncoded;
              }
            }
          }
        }
      }
    },
    colors: ['#004080', '#0059b3', '#0073e6', '#3399ff', '#66b2ff', '#99ccff'],
    series: [{
      name: 'Durasi Proyek',
      colorByPoint: true,
      data: projectDurationChartData
    }]
  });
});
document.addEventListener('DOMContentLoaded', function () {
  Highcharts.chart('packedBubbleChart', {
    chart: { type: 'packedbubble' },
    title: { text: 'User Groups' },
    tooltip: {
      useHTML: true,
      pointFormat: '<b>User:</b> {point.fullName}'
    },
    plotOptions: {
      packedbubble: {
        minSize: '30%',
        maxSize: '120%',
        layoutAlgorithm: { splitSeries: true, gravitationalConstant: 0.02 },
        dataLabels: {
          enabled: true,
          format: '{point.name}'
        }
      }
    },
    series: <?= $packedBubbleData ?>
  });
});
</script>
<?= $this->endSection() ?>



