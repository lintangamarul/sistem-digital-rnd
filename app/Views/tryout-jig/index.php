<?= $this->extend('layout/template') ?>
<?= $this->section('content') ?>

<div class="pd-ltr-20 xs-pd-20-10">
    <div class="min-height-200px">
        <div class="page-header d-flex justify-content-between align-items-center mb-3">
            <h4>Daftar Try Out Report Jig</h4>
            <a href="<?= site_url('tryout-jig/create'); ?>" class="btn btn-primary">
                <i class="fas fa-plus-circle"></i> Tambah Tryout Jig
            </a>
        </div>

        <!-- Alert Notice untuk Contoh Rujukan -->
        <div class="alert alert-info alert-dismissible fade show" role="alert">
            <i class="fas fa-info-circle"></i>
            <strong>Informasi:</strong> Baris pertama dengan latar belakang biru adalah contoh rujukan untuk memudahkan Anda dalam mengisi data tryout jig yang baru.
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>

        <div class="card-box mb-30">
            <div class="pd-20">
                <h4 class="text-blue h4">Try Out Report Jig</h4>
                <p class="mb-0">Data tryout jig yang tersimpan akan digunakan dalam laporan produksi.</p>
            </div>
            <div class="pb-20">
                <table class="data-table table stripe hover nowrap">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Jig No</th>
                            <th>Event</th>
                            <th>Cust</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $i = 1; ?>
                        <?php foreach ($tryout_jigs as $tryout_jig): ?>
                            <tr <?= ($tryout_jig['id'] == 147) ? 'class="table-primary" style="background-color: #cce5ff !important;"' : ''; ?>>
                                <td>
                                    <?= $i++; ?>
                                    <?php if ($tryout_jig['id'] == 147): ?>
                                        <span class="badge badge-info ml-2">
                                            <i class="fas fa-star"></i> Contoh Rujukan
                                        </span>
                                    <?php endif; ?>
                                </td>
                                <td><?= esc($tryout_jig['part_no']); ?></td>
                                <td><?= esc($tryout_jig['event']); ?></td>
                                <td><?= esc($tryout_jig['cust']); ?></td>
                                <td>
                                    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">

                                    <?php if (has_permission(52)): ?>
                                        <a href="<?= site_url('tryout-jig/edit/' . $tryout_jig['id']); ?>" class="btn btn-sm btn-warning" title="Edit">
                                            <i class="fas fa-edit"></i>
                                        </a>
                                    <?php endif; ?>

                                    <?php if (has_permission(53)): ?>
                                        <?php if ($tryout_jig['id'] != 147): // Jangan tampilkan tombol hapus untuk contoh rujukan ?>
                                            <a href="javascript:void(0);" class="btn btn-sm btn-danger" onclick="confirmDelete(<?= $tryout_jig['id']; ?>)" title="Hapus">
                                                <i class="fas fa-trash"></i>
                                            </a>
                                        <?php else: ?>
                                            <span class="btn btn-sm btn-secondary disabled" title="Contoh rujukan tidak dapat dihapus">
                                                <i class="fas fa-lock"></i>
                                            </span>
                                        <?php endif; ?>
                                    <?php endif; ?>                    
                                    
                                    <a href="<?= site_url('tryout-jig/show/' . $tryout_jig['id']); ?>" class="btn btn-info btn-sm" title="Detail">
                                        <i class="fas fa-eye"></i>
                                    </a>

                                    <?php if (has_permission(54)): ?>
                                        <a href="<?= site_url('tryout-jig/exportPdf/' . $tryout_jig['id']); ?>" class="btn btn-sm btn-danger" target="_blank" title="Save PDF">
                                            <i class="fas fa-file-pdf"></i>
                                        </a>
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
        title: "Yakin hapus tryout jig ini?",
        text: "Data yang dihapus tidak dapat dikembalikan!",
        icon: "warning",
        showCancelButton: true,
        confirmButtonColor: "#d33",
        cancelButtonColor: "#3085d6",
        confirmButtonText: "Ya, hapus!",
        cancelButtonText: "Batal"
    }).then((result) => {
        if (result.isConfirmed) {
            window.location.href = "<?= site_url('tryout-jig/delete/'); ?>" + id;
        }
    });
}
</script>

<?= $this->endSection() ?>