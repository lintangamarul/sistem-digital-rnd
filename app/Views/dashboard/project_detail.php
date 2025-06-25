<?= $this->extend('layout/template') ?>
<?= $this->section('content') ?>

<div class="pd-ltr-20 xs-pd-20-10">
  <div class="min-height-200px">
    <div class="page-header d-flex justify-content-between align-items-center mb-3">
      <h4>Detail Proyek</h4>
    </div>

    <div class="card-box mb-30">
      <div class="pd-20">
        <h4 class="text-blue h4">Detail Proyek: <?= esc($model) ?></h4>
    
        <p class="mb-0">Berikut adalah detail aktivitas dalam proyek ini.</p>
        <a href="<?= site_url('dashboard') ?>" class="btn btn-secondary mt-2 mb-3">Kembali</a>
        <form method="get" action="<?= site_url('dashboard/projectDetail/' . urlencode($model)) ?>" class="mb-3">
            <div class="form-group">
                <label for="start_date">Start Date</label>
                <input type="date" name="start_date" id="start_date" class="form-control" value="<?= isset($start_date) ? esc($start_date) : '' ?>">
            </div>
            <div class="form-group">
                <label for="end_date">End Date</label>
                <input type="date" name="end_date" id="end_date" class="form-control" value="<?= isset($end_date) ? esc($end_date) : '' ?>">
            </div>
            <button type="submit" class="btn btn-primary">Filter</button>
        </form>

      </div>
     
      <div id="activityChart" style="width: 100%; height: 400px;"></div>
  


      <div class="pb-20">
        <table class="data-table table stripe hover nowrap">
          <thead>
            <tr>
              <th>No</th>
              <th>Nama Aktivitas</th>
              <th>Part No</th>
              <th>Process</th>
              <th>Remark</th>
              <th>Nama User</th>
              <th>Total Waktu (menit)</th>
            </tr>
          </thead>
          <tbody>
            
            <?php if (!empty($results)) : ?>
                <?php $i = 1; ?>
              <?php foreach ($results as $row) : ?>
                <tr>
                    <td><?= $i++; ?></td>
                  <td><?= esc($row['activity_name']) ?></td>
                  <td><?= esc($row['part_no']) ?></td>
                  <td>
                      <?= esc($row['process']) ?> 
                      <?= !empty($row['proses']) ? '-' . esc($row['proses']) : '' ?>
                  </td>

                  <td><?= esc($row['remark']) ?></td>
                  <td><?= esc($row['created_by']) ?></td>
                  <td><?= esc($row['total_time']) ?></td>
                </tr>
              <?php endforeach; ?>
            <?php else: ?>
              <tr><td colspan="5" class="text-center">Data tidak ditemukan.</td></tr>
            <?php endif; ?>
          </tbody>
        </table>
      </div>
    </div>

    <!-- Highcharts Pie Chart -->
   
  </div>
</div>

<!-- Highcharts Library -->
<script src="https://code.highcharts.com/highcharts.js"></script>
<script>
document.addEventListener('DOMContentLoaded', function () {
    Highcharts.chart('activityChart', {
        chart: {
            type: 'pie'
        },
        title: {
            text: 'Distribusi Waktu Aktivitas'
        },
        tooltip: {
            pointFormat: '{series.name}: <b>{point.y} menit ({point.percentage:.1f}%)</b>'
        },
        plotOptions: {
            pie: {
                allowPointSelect: true,
                cursor: 'pointer',
                dataLabels: {
                    enabled: true,
                    format: '<b>{point.name}</b>: {point.y} menit'
                }
            }
        },
        colors: ['#004080', '#0059b3', '#0073e6', '#3399ff', '#66b2ff', '#99ccff'], 
        series: [{
            name: 'Total Waktu',
            colorByPoint: true,
            data: <?= $chartData ?>
        }]
    });
});
</script>

<?= $this->endSection() ?>
