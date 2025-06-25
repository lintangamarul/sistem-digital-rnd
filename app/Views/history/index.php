<?= $this->extend('layout/template'); ?>

<?= $this->section('content'); ?>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">

<div class="pd-ltr-20 xs-pd-20-10">
    <div class="min-height-200px">
        <!-- Header -->
        <div class="page-header d-flex justify-content-between align-items-center mb-3">
            <div class="d-flex align-items-center">
                <h4 class="mr-3">Status Pengisian Daily Report </h4>
            </div>
            <?php if (has_permission(35)): ?>
            <a href="<?= site_url('history/create'); ?>" class="btn btn-primary">Perizinan</a>
            <?php endif; ?>
        </div>
        <!-- Card Data -->
        <div class="card-box mb-30">
            <div class="pd-20">
                <h4 class="text-blue h4">Status Pengisian Daily Report</h4>
                <form method="get" action="<?= site_url('history'); ?>" class="d-flex align-items-center">
                    <label for="week" class="mr-2 mb-0">Pilih Minggu:</label>
                    <select name="week" class="custom-select2 form-control" style="width: 100%; height: 38px;" onchange="this.form.submit()">
                        <?php foreach ($weeks as $weekStart => $weekLabel): ?>
                            <option value="<?= $weekStart; ?>" <?= $selectedWeek == $weekStart ? 'selected' : ''; ?>>
                                <?= $weekLabel; ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </form>
            </div>
            <div class="pb-20">
                <div class="mt-3 mb-3 ml-3">
                    <ul class="list-inline mb-0">
                        <li class="list-inline-item"><span class="badge badge-warning">GH</span> : Ganti Hari</li>
                        <li class="list-inline-item"><span class="badge badge-warning">I</span> : Izin</li>
                        <li class="list-inline-item"><span class="badge badge-warning">S</span> : Sakit</li>
                        <li class="list-inline-item"><span class="badge badge-warning">C</span> : Cuti</li>
                        <li class="list-inline-item"><span class="badge badge-danger">D</span> : Dikembalikan</li>
                    </ul>
                </div>

                    <div class="table-responsive">
                        <table class="data-table table stripe hover nowrap">
                        <thead>
                            <tr>
                                <th>Foto</th>
                                <th>NIK - Nama</th>
                                <?php foreach ($dates as $date): 
                                    $dayOfWeek = date('l', strtotime($date)); 
                                    $isWeekend = in_array($dayOfWeek, ['Saturday', 'Sunday']);
                                    $isHoliday = in_array($date, $holidayDates);
                                    $style = ($isWeekend || $isHoliday) ? 'background-color: red; color: #fff;' : '';
                                ?>
                                    <th style="<?= $style ?>">
                                        <?= date('d M', strtotime($date)) ?>
                                        <br><small><?= $dayOfWeek ?></small>
                                    </th>
                                <?php endforeach; ?>
                                <th>Persentase Pengisian</th>
                                <?php if (has_permission(26)): ?>
                                    <th>Aksi</th>
                                <?php endif; ?>
                            </tr>
                        </thead>
                            <tbody>
                                <?php foreach ($users as $user): ?>
                                    <tr>
                                        <td>
                                            <a href="#" class="photo-modal-trigger" data-photo="<?= empty($user['foto']) ? base_url('assets/images/person.jpg') : base_url('uploads/users/' . $user['foto']) ?>">
                                                <img src="<?= empty($user['foto']) ? base_url('assets/images/person.jpg') : base_url('uploads/users/' . $user['foto']) ?>" width="50" height="50"  style="max-width: 50px;max-height: 50px;"  class="img-thumbnail">
                                            </a>
                                        </td>

                                        <td><?= esc($user['nik']); ?> - <?= esc($user['nama']); ?></td>
                                        <?php foreach ($user['status_pengisian'] as $date => $status): ?>
                                            <td>
                                                <?php if ($status == 1): ?>
                                                    <span class="text-success">✔</span>
                                                <?php elseif ($status == 3): ?> 
                                                    <span class="badge badge-warning">GH</span>
                                                <?php elseif ($status == 4): ?>
                                                    <span class="badge badge-warning">I</span>
                                                <?php elseif ($status == 5): ?>
                                                    <span class="badge badge-warning">S</span>
                                                <?php elseif ($status == 6): ?>
                                                    <span class="badge badge-warning">C</span>
                                                    <?php elseif ($status == 7): ?>
                                                        <span class="badge badge-danger">D</span>
                                                <?php else: ?>
                                                    <span class="text-danger">✖</span>
                                                <?php endif; ?>
                                            </td>
                                        <?php endforeach; ?>
                                        <td>
                                            <?= number_format($userPercentages[$user['id']], 2) ?>%
                                        </td>
                                        <?php if (has_permission(26)): ?>
                                            <td>
                                                <?php 
                                                    $encryptedId = urlsafe_b64encode(service('encrypter')->encrypt($user['id']));
                                                ?>
                                                <a href="<?= site_url('history/detail/'.$encryptedId); ?>" class="btn btn-sm btn-primary">Detail</a>
                                            </td>
                                        <?php endif; ?>
                                    </tr>
                                <?php endforeach; ?>
                            </tbody>

                            <tbody>
                                <tr>
                                    <td colspan="2"><strong>Persentase Pengisian LKH (+ Yang Sudah Izin)</strong></td>
                                    <?php foreach ($dates as $date): ?>
                                        <?php $day = date('l', strtotime($date)); ?>
                                        <td >
                                            <?= number_format($datePercentages[$date], 2) ?>%
                                        </td>
                                    <?php endforeach; ?>
                                    <td></td>
                                    <?php if (has_permission(26)): ?>
                                        <td></td>
                                    <?php endif; ?>
                                </tr>
                            </tbody>
                        </table>
                        <!-- Photo Modal -->
                        <div class="modal fade" id="photoModal" tabindex="-1" role="dialog" aria-labelledby="photoModalLabel" aria-hidden="true">
                            <div class="modal-dialog modal-dialog-centered" role="document">
                                <div class="modal-content">
                                <div class="modal-body text-center">
                                    <img id="modalPhoto" src="" alt="User Photo" class="img-fluid">
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                </div>
                                </div>
                            </div>
                        </div>

                    </div>
            </div>
            
        </div>
    </div>
</div>
<script>
$(document).ready(function(){
    $('.photo-modal-trigger').on('click', function(e){
        e.preventDefault();
        var photoUrl = $(this).data('photo');
        $('#modalPhoto').attr('src', photoUrl);
        $('#photoModal').modal('show');
    });
});
</script>

<?= $this->endSection(); ?>
