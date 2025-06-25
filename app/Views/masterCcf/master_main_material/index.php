<?= $this->extend('layout/template') ?>
<?= $this->section('content') ?>

<div class="pd-ltr-20 xs-pd-20-10">
    <div class="min-height-200px">
        <div class="page-header d-flex justify-content-between align-items-center mb-3">
            <h4>Master Main Material</h4>
            <a href="<?= site_url('ccf-master-main-material/create'); ?>" class="btn btn-primary">Tambah Data</a>
        </div>

        <?php if (session()->getFlashdata('success')): ?>
            <div class="alert alert-success"><?= session()->getFlashdata('success') ?></div>
        <?php endif; ?>

        <div class="card-box mb-30">
            <div class="pd-20">
                <h4 class="text-blue h4">Daftar Main Material</h4>
                <p class="mb-0">Data master untuk material utama pada proses CCF JCP</p>
            </div>
            <div class="pb-20">
            <table class="data-table table stripe hover nowrap">
    <thead>
        <tr>
            <th>No</th>
            <th>Jenis</th>
            <th>Class</th>
            <th>Category</th>
            <th>Part List</th>
            <th>Material Spec</th>
            <th>Size</th>
            <th>Qty</th>
            <th>Weight</th>
            <th>Aksi</th>
        </tr>
    </thead>
    <tbody>
        <?php $i = 1; foreach($items as $row): ?>
            <tr>
                <td><?= $i++ ?></td>
                <td><?= esc($row['jenis']) ?></td>
                <td><?= esc($row['class']) ?></td>
                <td><?= esc($row['mm_category']) ?></td>
                <td><?= esc($row['mm_part_list']) ?></td>
                <td><?= esc($row['mm_material_spec']) ?></td>
                <td>
                    <?php
                        $sizes = array_filter([
                            $row['mm_size_type_l'],
                            $row['mm_size_type_w'],
                            $row['mm_size_type_h']
                        ], function($v){ return $v !== null && $v !== ''; });
                        echo implode('x', $sizes);
                    ?>
                </td>
                <td><?= esc($row['mm_qty']) ?></td>
                <td><?= esc($row['mm_weight']) ?></td>
                <td>
                    <a href="<?= site_url('ccf-master-main-material/edit/'.$row['id']) ?>" class="btn btn-sm btn-warning">Edit</a>
                    <button onclick="deleteMaterial(<?= $row['id'] ?>)" class="btn btn-sm btn-danger">Hapus</button>
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
    function deleteMaterial(id) {
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
                window.location.href = "<?= site_url('ccf-master-main-material/delete/') ?>" + id;
            }
        });
    }
</script>

<?= $this->endSection() ?>
