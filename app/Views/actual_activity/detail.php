<?= $this->extend('layout/template') ?>
<?= $this->section('content') ?>

<div class="pd-ltr-20 xs-pd-20-10">
    <div class="min-height-200px">
        <div class="page-header">
            <h4>Detail Daily Report</h4>
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="<?= site_url('actual-activity/personal'); ?>">Home</a></li>
                    <li class="breadcrumb-item"><a href="#">Daily Report</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Detail Daily Report</li>
                </ol>
            </nav>
        </div>
        <div class="card-box pd-20">
                <div class="table-responsive">
                <table class="table table-bordered" id="details-table">
                    <thead>
                        <tr>
                            <th>Kelompok Kerja/Project</th>
                            <th>Activity</th>
                            <th>Part No</th>
                            <th>Remark</th>
                            <th>Start Time</th>
                            <th>End Time</th>
                            <th>Total Time</th>
                            <th>Progress (%)</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($details as $index => $detail): ?>
                            <tr>
                            <td class="wrap-text">
                                    <?= $detail['jenis'] == 'Others' ? esc($detail['another_project']) : esc($detail['model']) ?>
                                </td>
                                <td class="wrap-text"><?= esc($detail['activity_name']) ?></td>
                               
                                <td class="wrap-text">
                                    <?= esc($detail['part_no']) . ' - ' . esc($detail['process']) ?>
                                </td>
                              
                                <td class="wrap-text"><?= esc($detail['remark']) ?></td>
                                <td class="wrap-text"><?= esc($detail['start_time']) ?></td>
                                <td class="wrap-text"><?= esc($detail['end_time']) ?></td>
                                <td class="wrap-text">
                                    <?php 
                                        $hours = floor($detail['total_time'] / 60);
                                        $minutes = $detail['total_time'] % 60;
                                        echo $hours . " jam " . $minutes . " menit";
                                    ?>
                                </td>
                                <td class="wrap-text"><?= esc($detail['progress']) ?>%</td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>

                </table>
                </div>
           
        </div>
    </div>
</div>


<?= $this->endSection() ?>
