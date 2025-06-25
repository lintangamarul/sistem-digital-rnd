<?= $this->extend('layout/template') ?>
<?= $this->section('content') ?>

<div class="pd-ltr-20 xs-pd-20-10">
    <div class="min-height-200px">
        <div class="page-header d-flex justify-content-between align-items-center mb-3">
            <h4>Daftar Try Out Report Jig</h4>
            <a href="<?= site_url('tryout/create'); ?>" class="btn btn-primary">
                <i class="fas fa-plus-circle"></i> Tambah Tryout
            </a>
        </div>

        <div class="card-box mb-30">
            <div class="pd-20">
                <h4 class="text-blue h4">Try Out Report Dies</h4>
                <p class="mb-0">Data tryout yang tersimpan akan digunakan dalam laporan produksi.</p>
            </div>
            <div class="pb-20">
                <table class="data-table table stripe hover nowrap">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Part No</th>
                            <th>Process</th>
                            <th> Part Name</th>
                            <th>Projek/Cust</th> <!-- Kolom baru -->
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $i = 1; ?>
                        <?php foreach ($tryouts as $tryout): ?>
                            <tr>
                        <td><?= $i++; ?></td>
                        <td><?= $tryout['part_no'] ?: '-'; ?></td>
                        <td><?= $tryout['process'] ?: '-'; ?></td>
                        <td><?= isset($projects[$tryout['project_id']]) ? esc($projects[$tryout['project_id']]['nama']) : '-'; ?></td>
                        <td><?= ($tryout['projek'] ?? '-') . '/' . ($tryout['cust'] ?? '-'); ?></td>
                        <td>
                            <a href="<?= site_url('tryout/edit/' . $tryout['id']); ?>" class="btn btn-sm btn-warning">
                                <i class="fas fa-edit"></i> Edit
                            </a>
                            <a href="javascript:void(0);" class="btn btn-sm btn-danger" onclick="confirmDelete(<?= $tryout['id']; ?>)">
                                <i class="fas fa-trash"></i> Hapus
                            </a>
                            <a href="<?= site_url('tryout/show/' . $tryout['id']); ?>" class="btn btn-info btn-sm">Detail</a>
                            <a href="<?= site_url('tryout/print/' . $tryout['id']); ?>" class="btn btn-danger btn-sm" target="_blank">
                                <i class="fas fa-file-pdf"></i> Save PDF
                            </a>
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
        title: "Yakin hapus tryout ini?",
        text: "Data yang dihapus tidak dapat dikembalikan!",
        icon: "warning",
        showCancelButton: true,
        confirmButtonColor: "#d33",
        cancelButtonColor: "#3085d6",
        confirmButtonText: "Ya, hapus!",
        cancelButtonText: "Batal"
    }).then((result) => {
        if (result.isConfirmed) {
            window.location.href = "<?= site_url('tryout/delete/'); ?>" + id;
        }
    });
}
</script>

<?= $this->endSection() ?>
