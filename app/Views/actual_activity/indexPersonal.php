<?= $this->extend('layout/template') ?>
<?= $this->section('content') ?>

<div class="pd-ltr-20 xs-pd-20-10">
    <div class="min-height-200px">
        <div class="page-header d-flex justify-content-between align-items-center mb-3">
            <h4>Daily Report</h4>
                <?php if (has_permission(20)): ?>
                <a href="<?= site_url('actual-activity/create'); ?>" class="btn btn-primary">Tambah LKH</a>
            <?php endif; ?>
        </div>
        <div class="card-box mb-30">
        <div class="pd-20">
                <h4 class="text-blue h4">Riwayat Pengisian Daily Report (LKH)</h4>
                <p class="mb-0">LKH hanya dapat dilihat oleh Pembuat apabila masih berstatus draft dan dapat dilihat oleh role tertentu apabila ter-submit</p>
            </div>
            <div class="pb-20">
            <div class="table-responsive">
                <?php $showKomentar = false; ?>
                    <?php foreach ($activities as $act) {
                        if (!empty($act['comment'])) {
                            $showKomentar = true;
                          
                        }
                    } ?>
                    <table class="data-table table stripe hover nowrap">
                        <thead>
                            <tr>
                                <th>#</th>
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
                                    <td><?= date('d M Y', strtotime($activity['dates'])); ?></td>
                                    <td>
                                    <span class="badge badge-<?= $activity['status'] == 2 ? 'warning' : ($activity['status'] == 7 ? 'danger' : 'success') ?>">
                                        <?= $activity['status'] == 2 ? 'Draft' : ($activity['status'] == 7 ? 'dikembalikan' : 'Submitted'); ?>
                                    </span>
                                </td>
                                    <?php if ($showKomentar): ?>
                                        <td>
                                            <?= $activity['comment'] ? $activity['comment'] . ' - ' . $activity['comment_by_name'] : '-' ?>
                                        </td>
                                    <?php endif; ?>
                                    <td>
                                        <?php if ($activity['status'] == 2 || ($activity['status'] == 7) ): ?>
                                            <?php if (has_permission(21)): ?>
                                                <?php $encryptedId = urlsafe_b64encode(service('encrypter')->encrypt($activity['id'])); ?>
                                                <a href="<?= site_url('actual-activity/edit/'.$encryptedId); ?>" class="btn btn-sm btn-warning">Edit</a>
                                            <?php endif; ?>
                                            <?php if (has_permission(18)): ?>
                                                <a href="#" class="btn btn-sm btn-danger" onclick="swalDelete('<?= site_url('actual-activity/delete/'.$activity['id']); ?>'); return false;">Hapus</a>
                                            <?php endif; ?>
                                            <?php if (has_permission(27)): ?>
                                                <a href="#" class="btn btn-sm btn-success" onclick="swalSubmit('<?= site_url('actual-activity/submit/'.$activity['id']); ?>'); return false;">Submit</a>
                                            <?php endif; ?>
                                        <?php elseif ($activity['status'] == 1): ?>
                                            <?php $encryptedId = urlsafe_b64encode(service('encrypter')->encrypt($activity['id'])); ?>
                                            <a href="<?= site_url('actual-activity/detail/'.$encryptedId); ?>" class="btn btn-sm btn-primary">Detail</a>
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
</script>
<?= $this->endSection() ?>
