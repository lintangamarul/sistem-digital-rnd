<?= $this->extend('layout/template') ?>
<?= $this->section('content') ?>

<div class="pd-ltr-20 xs-pd-20-10">
    <div class="min-height-200px">
        <div class="page-header d-flex justify-content-between align-items-center mb-3">
            <h4>Daily Report</h4>
           
        </div>

        <div class="card-box mb-30">
            <div class="pd-20">
                    <h4 class="text-blue h4">Daftar Riwayat Daily Report (LKH)</h4>
                    <p class="mb-0">List LKH yang telah dilakukan submit Pengguna</p>
            </div>
                <div class="col-6 col-sm-4">
                    <form method="get" action="<?= site_url('actual-activity'); ?>" class="d-flex align-items-center mr-3">
                        <div class="form-group mr-2 mb-0">
                            <label for="start_date" class="mr-1">Start Date:</label>
                            <input type="date" name="start_date" id="start_date" class="form-control" value="<?= esc($start_date); ?>">
                        </div>
                        <div class="form-group mr-2 mb-0">
                            <label for="end_date" class="mr-1">End Date:</label>
                            <input type="date" name="end_date" id="end_date" class="form-control" value="<?= esc($end_date); ?>">
                        </div>
                        <br>
                        <button type="submit" class="btn btn-primary mt-4" style="margin-top: 50px;">Filter</button>
                    </form>

                    <form action="<?= site_url('actual-activity/export-excel'); ?>" method="post" class="d-flex align-items-center">
                    <?= csrf_field(); ?>
                    <input type="hidden" name="start_date" value="<?= esc($start_date); ?>">
                    <input type="hidden" name="end_date" value="<?= esc($end_date); ?>"> 
                    <button type="submit" class="btn btn-success mt-3 mb-3">Export Excel</button>
                    </form>
                </div>
                <div class="pb-20">
                    <div class="table-responsive">
                    <?php $showKomentar = false; ?>
                        <?php foreach ($activities as $act) {
                            if (!empty($act['comment_by'])) {
                                $showKomentar = true;
                                break;
                            }
                        } ?>
                        <table class="data-table table stripe hover nowrap">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Nama</th>
                                    <th>Tanggal LKH</th>
                                    <th>Status</th>
                                    <?php if ($showKomentar): ?>
                                        <th>Komentar</th>
                                    <?php endif; ?>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                
                            <?php $i = 1; ?>
                                <?php foreach ($activities as $activity) : ?>
                                    <tr>
                                    <td><?= $i++; ?></td>
                                    <td><?= $activity['created_by_name']; ?></td>
                                    <td><?= date('d-m-Y', strtotime($activity['dates'])); ?></td>

                                    <td>
                                        <span class="badge badge-<?= $activity['status'] == 2 ? 'warning' : ($activity['status'] == 7 ? 'danger' : 'success') ?>">
                                            <?= $activity['status'] == 2 ? 'Draft' : ($activity['status'] == 7 ? 'dikembalikan' : 'Submitted'); ?>
                                        </span>
                                    </td>
                                        <?php if ($showKomentar): ?>
                                            <td>
                                                <?= $activity['comment']  ?>
                                            </td>
                                        <?php endif; ?>
                                
                                    <td>
                                        <?php if (has_permission(22)):?>
                                            <a href="<?= site_url('actual-activity/detail/' . urlsafe_b64encode(service('encrypter')->encrypt($activity['id']))); ?>" class="btn btn-sm btn-primary">Detail</a>
                                        <?php endif; ?>
                                        <?php if (has_permission(34)):?>
                                            <a href="#" class="btn btn-sm btn-warning" onclick="swalRollback('<?= site_url('actual-activity/rollback/'.$activity['id']); ?>'); return false;">Rollback</a>
                                        <?php endif; ?>
                                    </td>

                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
        
        </div>
    </div>
</div>
<script>
    function swalDelete(url) {
    Swal.fire({
        title: 'Hapus data ini?',
        icon: 'warning',
        showCancelButton: true,
        text: 'Data yang dihapus tidak dapat dikembalikan.',
        confirmButtonColor: '#d33',
        cancelButtonColor: '#3085d6',
        confirmButtonText: 'Ya, hapus!',
        cancelButtonText: 'Batal'
    }).then((result) => {
        if (result.isConfirmed) {
            window.location.href = url;
        }
    });
}

function swalSubmit(url) {
    Swal.fire({
        title: 'Kirim aktivitas ini?',
        icon: 'warning',
        text: 'Anda tidak dapat melakukan perubahan apabila telah berhasil mengirim.',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Ya, kirim!',
        cancelButtonText: 'Batal'
    }).then((result) => {
        if (result.isConfirmed) {
            window.location.href = url;
        }
    });
}
function swalRollback(url) {
    Swal.fire({
        title: 'Rollback/Kembalikan LKH ini?',
        icon: 'warning',
        text: 'Hal ini akan membuat LKH ini dikembalikan ke Pengguna',
        input: 'text',
        inputPlaceholder: 'Tambahkan komentar (opsional)',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Ya!',
        cancelButtonText: 'Batal'
    }).then((result) => {
        if (result.isConfirmed) {
            const comment = result.value ? encodeURIComponent(result.value) : '';
            window.location.href = url + '?comment=' + comment;
        }
    });
}

</script>
<?= $this->endSection() ?>