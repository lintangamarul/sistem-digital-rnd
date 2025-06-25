<?= $this->extend('layout/template') ?>
<?= $this->section('content') ?>

<div class="pd-ltr-20 xs-pd-20-10">
    <div class="min-height-200px">
        <div class="page-header mb-3 d-flex justify-content-between align-items-center">
            <h4>Jadwal Piket</h4>
        </div>

        <?php if (session()->getFlashdata('success')): ?>
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                <?= session()->getFlashdata('success') ?>
                <button type="button" class="close" data-dismiss="alert"><span>&times;</span></button>
            </div>
        <?php endif; ?>

        <?php if (session()->getFlashdata('error')): ?>
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                <?= session()->getFlashdata('error') ?>
                <button type="button" class="close" data-dismiss="alert"><span>&times;</span></button>
            </div>
        <?php endif; ?>

        <?php
        function hari_indonesia($tanggal) {
            $hari = ['Sunday'=>'Minggu','Monday'=>'Senin','Tuesday'=>'Selasa','Wednesday'=>'Rabu','Thursday'=>'Kamis','Friday'=>'Jumat','Saturday'=>'Sabtu'];
            return $hari[date('l', strtotime($tanggal))] ?? $tanggal;
        }
        ?>

        <?php foreach ($weeks as $weekData): ?>
            <?php 
                $weekInfo = $weekData['info'];
                $schedule = $weekData['schedule'];
                $hasSchedule = $weekData['has_schedule'];
                $weekOffset = $weekData['week_offset'];
            ?>
            <div class="card shadow-sm mb-4">
                <div class="card-header bg-white d-flex justify-content-between align-items-center">
                    <h5 class="text-primary mb-0"><?= $weekInfo['title'] ?></h5>
                    <?php if ($weekInfo['can_edit']): ?>
                        <div class="btn-group">
                            <?php if ($hasSchedule): ?>
                                <?php if (has_permission(69)): ?>
                                    <a href="<?= site_url('piket/atur?week=' . $weekOffset) ?>" class="btn btn-sm btn-warning"><i class="fa fa-edit mr-2"></i> Edit Jadwal</a>
                                <?php endif; ?>
                                <?php if (has_permission(70)): ?>
                                    <button type="button" class="btn btn-sm btn-danger ml-1" onclick="confirmDelete(<?= $weekOffset ?>)"><i class="fa fa-trash"></i> Hapus</button>
                                <?php endif; ?>
                            <?php else: ?>
                                <?php if (has_permission(67)): ?>
                                    <a href="<?= site_url('piket/atur?week=' . $weekOffset) ?>" class="btn btn-sm btn-primary"><i class="fa fa-plus"></i> Buat Jadwal</a>
                                <?php endif; ?>
                            <?php endif; ?>
                        </div>
                    <?php endif; ?>
                </div>
                <div class="card-body">
                    <?php if ($hasSchedule || $weekOffset === 0): ?>
                        <div class="row">
                            <?php foreach ($weekInfo['dates'] as $tgl): ?>
                                <div class="col-md-6 col-lg-2 mb-4">
                                    <div class="schedule-day border rounded shadow-sm h-100 d-flex flex-column">
                                        <?php $isHoliday = in_array($tgl, $holiday_dates); ?>
                                        <div class="text-center py-3 <?= $isHoliday ? 'bg-danger' : 'bg-primary' ?> text-white rounded-top">
                                            <div class="font-weight-bold small"><?= hari_indonesia($tgl) ?></div>
                                            <div class="small"><?= date('d M Y', strtotime($tgl)) ?></div>
                                        </div>
                                        <div class="p-3 flex-fill bg-white" style="min-height: 300px; border-radius: 0 0 0.375rem 0.375rem;">
                                            <?php if (!empty($schedule[$tgl])): ?>
                                                <?php foreach ($schedule[$tgl] as $index => $u): ?>
                                                    <div class="d-flex align-items-center border rounded bg-light shadow-sm p-2 mb-2 position-relative">
                                                        <div class="position-absolute" style="top: 5px; left: 5px; background: #007bff; color: white; border-radius: 50%; width: 20px; height: 20px; display: flex; align-items: center; justify-content: center; font-size: 10px; font-weight: bold;">
                                                            <?= $index + 1 ?>
                                                        </div>
                                                        <img src="<?= empty($u['foto']) ? base_url('assets/images/person.jpg') : base_url('uploads/users/' . $u['foto']) ?>"
                                    class="rounded-circle mr-2"
                                    width="40" height="40"
                                    style="width: 40px; height: 40px; object-fit: cover; object-position: center; border: 2px solid #6c757d; margin-left: 30px;">
                                                        <div class="flex-fill">
                                                            <div class="font-weight-bold text-dark small"><?= esc($u['nickname']) ?></div>
                                                            <div class="text-muted small">Grup <?= esc($u['group']) ?></div>
                                                        </div>
                                                    </div>
                                                <?php endforeach ?>
                                            <?php else: ?>
                                                <div class="text-muted small text-center">
                                                    <?php if ($weekOffset === 0): ?>
                                                        Tidak ada jadwal
                                                    <?php else: ?>
                                                        Belum dijadwalkan
                                                    <?php endif; ?>
                                                </div>
                                            <?php endif ?>
                                        </div>
                                    </div>
                                </div>
                            <?php endforeach ?>
                        </div>
                    <?php else: ?>
                        <div class="text-center py-4">
                            <div class="text-muted mb-3">
                                <i class="fa fa-calendar-times fa-3x"></i>
                            </div>
                            <h6 class="text-muted">Belum ada jadwal untuk <?= strtolower($weekInfo['title']) ?></h6>
                            <p class="text-muted small">Klik tombol "Buat Jadwal" untuk membuat jadwal piket</p>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        <?php endforeach; ?>
    </div>
</div>

<div class="modal fade" id="deleteModal" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Konfirmasi Hapus</h5>
                <button type="button" class="close" data-dismiss="modal"><span>&times;</span></button>
            </div>
            <div class="modal-body">Apakah Anda yakin ingin menghapus jadwal piket untuk minggu ini?</div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                <form method="post" action="<?= site_url('piket/hapus') ?>">
                    <?= csrf_field() ?>
                    <input type="hidden" name="week" id="deleteWeek">
                    <button type="submit" class="btn btn-danger">Hapus</button>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
function confirmDelete(week) {
    document.getElementById('deleteWeek').value = week;
    $('#deleteModal').modal('show');
}
</script>

<?= $this->endSection() ?>
