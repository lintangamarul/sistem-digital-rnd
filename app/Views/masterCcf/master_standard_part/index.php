<?= $this->extend('layout/template') ?>
<?= $this->section('content') ?>

<div class="pd-ltr-20 xs-pd-20-10">
    <div class="min-height-200px">
        <div class="page-header d-flex justify-content-between align-items-center mb-3">
            <h4>Master Standard Part</h4>
            <a href="<?= site_url('ccf-master-standard-part/create') ?>" class="btn btn-primary">Tambah Data</a>
        </div>

        <?php if (session()->getFlashdata('success')): ?>
            <div class="alert alert-success"><?= session()->getFlashdata('success') ?></div>
        <?php endif; ?>

        <div class="card-box mb-30">
            <div class="pd-20">
                <h4 class="text-blue h4">Daftar Standard Part</h4>
                <p class="mb-0">Data standard part untuk proses CCF</p>
            </div>
            <div class="pb-20">
            <table class="data-table table stripe hover nowrap">
                <thead style="text-align: center;">
                    <tr>
                        <th>No</th>
                        <th>Jenis</th>
                        <th>Class</th>
                        <th>Category</th>
                        <th>Part List</th>
                        <th>Material Spec</th>
                        <th>Size Type</th>
                        <th>Qty</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody style="text-align: left;">
                    <?php $i = 1; foreach ($parts as $p): ?>
                        <tr>
                            <td><?= $i++ ?></td>
                            <td><?= esc($p['jenis']) ?></td>
                            <td><?= esc($p['class']) ?></td>
                            <td><?= esc($p['sp_category']) ?></td>
                            <td><?= esc($p['sp_part_list']) ?></td>
                            <td><?= esc($p['sp_material_spec']) ?></td>
                            <td><?= esc($p['sp_size_type']) ?></td>
                            <td><?= esc($p['sp_qty']) ?></td>
                            <td>
                                <a href="<?= site_url('ccf-master-standard-part/edit/' . $p['id']) ?>" class="btn btn-sm btn-warning">Edit</a>
                                <button onclick="deletePart(<?= $p['id'] ?>)" class="btn btn-sm btn-danger">Hapus</button>
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
    function deletePart(id) {
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
                window.location.href = "<?= site_url('ccf-master-standard-part/delete/') ?>" + id;
            }
        });
    }
</script>

<?= $this->endSection() ?>
