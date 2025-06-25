<?= $this->extend('layout/template') ?>
<?= $this->section('content') ?>

<div class="pd-ltr-20 xs-pd-20-10">
    <div class="min-height-200px">
        <div class="page-header d-flex justify-content-between align-items-center mb-3">
            <h4>Master Data Aktivitas</h4>
            <?php if (has_permission(15)):?>
                <a href="<?= site_url('activity/create'); ?>" class="btn btn-primary">Tambah Aktivitas</a>
            <?php endif; ?>
        </div>

        <div class="card-box mb-30">
            <div class="pd-20">
                <h4 class="text-blue h4">Daftar Aktivitas </h4>
                <p class="mb-0">Aktivitas akan terikat pada projek dan akan ditampilkan pada pengisian daily report</p>
            </div>
            <div class="pb-20">
            <table class="data-table table stripe hover nowrap">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Nama Aktivitas</th>
                    
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php $i = 1; ?>
                    <?php foreach ($activities as $activity) : ?>
                        <tr>
                            <td><?= $i++; ?></td>
                            <td><?= $activity['name']; ?></td>
                            <td>
                                <?php if (has_permission(15)): ?>
                                <?php
                                    $encryptedId = urlsafe_b64encode(service('encrypter')->encrypt($activity['id']));
                               ?>
                                <a href="<?= site_url('activity/edit/'.$encryptedId); ?>" class="btn btn-sm btn-warning">Edit</a>
                               <?php endif; ?>
                         
                                <?php if (has_permission(16)):?>
                                <a href="#" class="btn btn-sm btn-danger" onclick="deleteActivity(<?= $activity['id']; ?>)">Hapus</a>
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
<script>
    function deleteActivity(id) {
        Swal.fire({
            title: 'Anda yakin?',
            text: "Data aktivitas akan dihapus!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Ya, hapus!'
        }).then((result) => {
            if (result.isConfirmed) {
                window.location.href = "<?= site_url('activity/delete/') ?>" + id;
            }
        });
    }
</script>
<?= $this->endSection() ?>
