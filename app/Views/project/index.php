<?= $this->extend('layout/template') ?>
<?= $this->section('content') ?>

<div class="pd-ltr-20 xs-pd-20-10">
    <div class="min-height-200px">
        <div class="page-header d-flex justify-content-between align-items-center mb-3">
            <h4>Master Data Project</h4>
            <?php if (has_permission(6)): ?>
            <a href="<?= site_url('project/create'); ?>" class="btn btn-primary">Tambah Project</a>
            <?php endif; ?>
        </div>

        <div class="card-box mb-30">
        <div class="pd-20">
                <h4 class="text-blue h4">Daftar Project</h4>
                <p class="mb-0">Project yang tersimpan akan digunakan pada Form Daily Report</p>
            </div>
            <div class="pb-20">
            <table class="data-table-export table stripe hover nowrap">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Jenis Project</th>
                        <th>Tooling</th>
                        <th>Model</th>
                        <th>Part No</th>
                        <th>Process</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                <?php $i = 1; ?>
                    <?php foreach ($projects as $project): ?>
                        <tr>
                        <!-- <td><?= $i++; ?></td> -->
                        <td><?= $project['id'] ?: '-';  ?></td>
                            <td>
                                <?php 
                                if ($project['jenis'] == "Others") {
                                    // Jika jenis adalah Others, tampilkan hanya another_project (jika ada)
                                    echo $project['another_project'];
                                } else {
                                    // Jika bukan Others, tampilkan jenis, dan jika ada another_project, tambahkan dengan tanda -
                                    echo $project['jenis'];
                                    if (!empty($project['another_project'])) {
                                        echo ' - ' . $project['another_project'];
                                    }
                                }
                                ?>
                            </td>
                            <td><?= $project['jenis_tooling'] ?: '-'; ?></td>

                            <td><?= $project['model'] ?: '-'; ?></td>
                            <td>
                                <?= !empty($project['part_no']) ? $project['part_no'] . ($project['status'] == 2 ? ' (RFQ)' : '') : '-' ?>
                            </td>


                            <td><?= $project['process'] ?: '-'; ?></td>

                            <td>
                            <?php
                                $encryptedId = urlsafe_b64encode(service('encrypter')->encrypt($project['id']));
                            ?>
                            <?php if (has_permission(7)):?>
                                <a href="<?= site_url('project/edit/'.$encryptedId); ?>" class="btn btn-sm btn-warning">Edit</a>
                                <?php endif; ?>
                                <?php if (has_permission(8)):?>
                                <a href="javascript:void(0);" class="btn btn-sm btn-danger" onclick="confirmDelete(<?= $project['id']; ?>)">Hapus</a>
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
function confirmDelete(id) {
    Swal.fire({
        title: "Yakin hapus project ini?",
        text: "Data yang dihapus tidak dapat dikembalikan!",
        icon: "warning",
        showCancelButton: true,
        confirmButtonColor: "#d33",
        cancelButtonColor: "#3085d6",
        confirmButtonText: "Ya, hapus!",
        cancelButtonText: "Batal"
    }).then((result) => {
        if (result.isConfirmed) {
            window.location.href = "<?= site_url('project/delete/'); ?>" + id;
        }
    });
}
</script>
<?= $this->endSection() ?>
