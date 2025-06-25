<?= $this->extend('layout/template') ?>
<?= $this->section('content') ?>

<div class="pd-ltr-20 xs-pd-20-10">
    <div class="min-height-200px">
        <div class="page-header d-flex justify-content-between align-items-center mb-3">
            <h4>Master Tool Cost</h4>
            <a href="<?= site_url('ccf-master-tool-cost/create'); ?>" class="btn btn-primary">Tambah Data</a>
        </div>

        <?php if (session()->getFlashdata('success')): ?>
            <div class="alert alert-success"><?= session()->getFlashdata('success') ?></div>
        <?php elseif (session()->getFlashdata('error')): ?>
            <div class="alert alert-danger"><?= session()->getFlashdata('error') ?></div>
        <?php endif; ?>

        <div class="card-box mb-30">
            <div class="pd-20">
                <h4 class="text-blue h4">Daftar Tool Cost</h4>
                <p class="mb-0">Data master tool cost dalam proses CCF</p>
            </div>
            <div class="pb-20">
                <table class="data-table table stripe hover nowrap">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Process</th>
                            <th>Tool</th>
                            <th>Spec</th>
                            <th>Qty</th>
                            <th>Jenis</th>
                            <th>Class</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $i = 1; foreach($items as $row): ?>
                            <tr>
                                <td><?= $i++ ?></td>
                                <td><?= esc($row['tool_cost_process']) ?></td>
                                <td><?= esc($row['tool_cost_tool']) ?></td>
                                <td><?= esc($row['tool_cost_spec']) ?></td>
                                <td><?= esc($row['tool_cost_qty']) ?></td>
                                <td><?= esc($row['jenis']) ?></td>
                                <td><?= esc($row['class']) ?></td>
                                <td>
                                    <a href="<?= site_url('ccf-master-tool-cost/edit/'.$row['id']) ?>" class="btn btn-sm btn-warning">Edit</a>
                                    <button onclick="deleteToolCost(<?= $row['id'] ?>)" class="btn btn-sm btn-danger">Hapus</button>
                                </td>
                            </tr>
                        <?php endforeach ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<script>
function deleteToolCost(id) {
    Swal.fire({
        title: 'Yakin hapus data?',
        text: "Data tidak bisa dikembalikan!",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Ya, hapus!'
    }).then((result) => {
        if (result.isConfirmed) {
            window.location.href = "<?= site_url('ccf-master-tool-cost/delete/') ?>" + id;
        }
    });
}
</script>

<?= $this->endSection() ?>
