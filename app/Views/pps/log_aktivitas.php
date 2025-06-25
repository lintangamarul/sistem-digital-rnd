<?= $this->extend('layout/template') ?>
<?= $this->section('content') ?>

<div class="pd-ltr-20 xs-pd-20-10">
    <div class="min-height-200px">
        <div class="page-header mb-3 d-flex justify-content-between align-items-center">
            <h4>Log Aktivitas untuk Part No: <strong><?= esc($partNo) ?></strong></h4>
            <a href="<?= site_url('pps'); ?>" class="btn btn-secondary">← Kembali</a>
        </div>
        <div class="card-box mb-30">
        <div class="pd-20">
                <h4 class="text-blue h4">Riwayat perubahan PPS</h4>
                <?php if (has_permission(46)): ?>
                    <p>Setelah > 30 hari data yg dihapus tidak bisa di rollback/dikembalikan</p>
                <?php endif; ?>
                <p>Setelah > 90 hari, versi data sebelumnya akan terhapus otomatis dan hanya akan menyisakan data terakhir</p>
            </div>
            <div class="pb-20">
                <table class="data-table table stripe hover nowrap">
                    <thead>
                        <tr>
                            <th>Version</th>
                            <th>Pembuat</th>
                            <th>Tanggal Diubah</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $total = count($log); ?>
                        <?php foreach ($log as $index => $item): ?>
                            <tr>
                                <td>
                                    <?= 'Versi ' . ($index + 1) ?>
                                </td>
                                <td><?= esc($item['pembuat']) ?></td>
                                <td><?= esc($item['updated_at'] ?? '-') ?></td>
                                <td>
                                    <?php if (has_permission(43)): ?>
                                        <a href="<?= base_url('pps/edit/' . $item['id']) ?>" class="btn btn-sm btn-warning">Edit</a>
                                    <?php endif; ?>
                                    <?php if (has_permission(45)): ?>
                                        <a href="<?= base_url('pps/editNew/' . $item['id']) ?>" class="btn btn-sm btn-secondary">Save As New Data</a>
                                    <?php endif; ?>
                                    <a href="<?= base_url('pps/generate/' . $item['id']) ?>" class="btn btn-sm btn-success">Excel</a>

                                    <!-- Hanya tampilkan DCP di baris terakhir -->
                                    <?php if ($index === $total - 1 && has_permission(41)): ?>
                                        <a href="<?= base_url('pps/list-process-dies/' . $item['id']) ?>" class="btn btn-sm btn-primary">DCP</a>
                                    <?php endif; ?>

                                    <?php if ($item['status'] == 1 && has_permission(40)): ?>
                                        <a href="<?= base_url('pps/delete/' . $item['id']) ?>" class="btn btn-sm btn-danger btn-delete">Delete</a>
                                    <?php elseif ($item['status'] == 0 && has_permission(46)): ?>
                                        <a href="<?= base_url('pps/rollback/' . $item['id']) ?>" class="btn btn-sm btn-light btn-rollback">Rollback</a>
                                    <?php endif; ?>
                                </td>
                            </tr>
                        <?php endforeach ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<?= $this->endSection() ?>
