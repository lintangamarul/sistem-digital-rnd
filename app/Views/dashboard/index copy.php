<?= $this->extend('layout/template') ?>
<?= $this->section('content') ?>

<div class="pd-ltr-20 xs-pd-20-10">
    <div class="min-height-200px">
        <div class="page-header">
            <h4>Dashboard Activities (1 Bulan Terakhir)</h4>
            <p class="mb-0" style="color: red">Under Development</p>
        </div>
        <form method="get" class="mb-3">
            <div class="row">
                <div class="col-md-4">
                    <label for="start_date">Start Date:</label>
                    <input type="date" class="form-control" name="start_date" value="<?= esc($startDate) ?>">
                </div>
                <div class="col-md-4">
                    <label for="end_date">End Date:</label>
                    <input type="date" class="form-control" name="end_date" value="<?= esc($endDate) ?>">
                </div>
                <div class="col-md-4 d-flex align-items-end">
                    <button type="submit" class="btn btn-primary">Filter</button>
                </div>
            </div>
        </form>
        <div class="row">
            <!-- Grafik Frekuensi Activities -->
            <div class="col-md-6">
                <div class="card-box pd-20 text-center">
                    <div id="frequencyChart" style="height: 300px; width: 100%;"></div>
                </div>
            </div>

            <!-- Grafik Durasi Activities -->
            <div class="col-md-6">
                <div class="card-box pd-20 text-center">
                    <div id="durationChart" style="height: 300px; width: 100%;"></div>
                </div>
            </div>
        </div>

        <div class="row mt-3">
            <!-- Grafik Frekuensi Projects -->
            <div class="col-md-6">
                <div class="card-box pd-20 text-center">
                    <div id="projectFrequencyChart" style="height: 300px; width: 100%;"></div>
                </div>
            </div>

            <!-- Grafik Durasi Projects -->
            <div class="col-md-6">
                <div class="card-box pd-20 text-center">
                    <div id="projectDurationChart" style="height: 300px; width: 100%;"></div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Highcharts CDN -->
<script src="https://code.highcharts.com/highcharts.js"></script>

<script>
  

    const frequencyData = <?= json_encode($frequencyData) ?>;
    const durationData = <?= json_encode($durationData) ?>;
    const projectFrequencyData = <?= json_encode($projectFrequencyData) ?>;
    const projectDurationChartData = <?= $projectDurationChartData ?>;

    const frequencyChartData = frequencyData.map(item => ({
        name: item.activities_name,
        y: parseInt(item.frequency)
    }));

    const durationChartData = durationData.map(item => ({
        name: item.activities_name,
        y: parseInt(item.total_duration)
    }));

    const projectFrequencyChartData = projectFrequencyData.map(item => ({
        name: item.project_name,
        y: parseInt(item.frequency)
    }));

    const blueShades = ['#004080', '#0059b3', '#0073e6', '#3399ff', '#66b2ff', '#99ccff'];

    // Grafik Frekuensi Activities
    Highcharts.chart('frequencyChart', {
        chart: { type: 'pie' },
        title: { text: 'Frekuensi Aktivitas' },
        plotOptions: {
            pie: {
                allowPointSelect: true,
                cursor: 'pointer',
                colors: blueShades,
                dataLabels: { enabled: true, format: '{point.name}: {point.y} kali' }
            }
        },
        series: [{
            name: 'Frekuensi',
            colorByPoint: true,
            data: frequencyChartData
        }]
    });

    // Grafik Durasi Activities
    Highcharts.chart('durationChart', {
        chart: { type: 'pie' },
        title: { text: 'Durasi Aktivitas' },
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

    // Grafik Frekuensi Projects
    Highcharts.chart('projectFrequencyChart', {
        chart: { type: 'pie' },
        title: { text: 'Frekuensi berdasarkan Proyek' },
        plotOptions: {
            pie: {
                allowPointSelect: true,
                cursor: 'pointer',
                colors: blueShades,
                dataLabels: { enabled: true, format: '{point.name}: {point.y} kali' }
            }
        },
        series: [{
            name: 'Frekuensi Proyek',
            colorByPoint: true,
            data: projectFrequencyChartData
        }],
        
    });

    // Grafik Durasi Projects
    document.addEventListener('DOMContentLoaded', function () {
        Highcharts.chart('projectDurationChart', {
            chart: { type: 'pie' },
            title: { text: 'Durasi berdasarkan Proyek' },
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
                                } else {
                                    console.error("Model proyek tidak ditemukan!");
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
            }],
            credits: {
        enabled: false
    }
        });
    });
</script>

<?= $this->endSection() ?>
