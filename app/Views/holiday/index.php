<?= $this->extend('layout/template') ?>
<?= $this->section('content') ?>

<div class="pd-ltr-20 xs-pd-20-10">
  <div class="min-height-200px">
    <!-- Page Header -->
    <div class="page-header d-flex justify-content-between align-items-center mb-3">
      <h4>Master Data Holiday</h4>
      <?php if (has_permission(29)): ?>
            <a href="<?= site_url('holiday/create'); ?>" class="btn btn-primary">Tambah Hari Libur</a>
      <?php endif; ?>
    </div>

    <div class="card-box mb-30">
      <div class="pd-20">
        <h4 class="text-blue h4">Daftar Hari Libur MAJ</h4>
        <p class="mb-0">Data Hari Libur akan digunakan pada perhitungan persentase kehadiran di Status Pengisian LKH agar sesuai aktual kerja</p>
        <p class="mb-0"><small><span style="color:red">*</span>Sabtu Minggu tidak perlu ditambahkan sebagai hari libur</small></p>
      </div>
      <div class="pb-20">
        <?php if (session()->getFlashdata('success')): ?>
          <div class="alert alert-success"><?= session()->getFlashdata('success'); ?></div>
        <?php endif; ?>
        <?php if (session()->getFlashdata('error')): ?>
          <div class="alert alert-danger"><?= session()->getFlashdata('error'); ?></div>
        <?php endif; ?>

        <table class="data-table table stripe hover nowrap">
          <thead>
            <tr>
              <th>No</th>
              <th>Tanggal Libur</th>
              <th>Deskripsi</th>
              <?php if (has_permission(30)): ?>
              <th>Aksi</th>
              <?php endif; ?>
            </tr>
          </thead>
          <tbody>
            <?php if (!empty($holidays)): ?>
                <?php $i = 1; ?>
              <?php foreach ($holidays as $holiday): ?>
                <tr>
                <td><?= $i++; ?></td>
                  <td><?= date('d M Y', strtotime($holiday['holiday_date'])); ?></td>
                  <td><?= esc($holiday['description']); ?></td>
                  <?php if (has_permission(30)): ?>
                  <td>
                    <a href="#" class="btn btn-sm btn-danger" onclick="swalDelete('<?= site_url('holiday/delete/' . $holiday['id']); ?>')">Delete</a>
                  </td>
                <?php endif; ?>
                </tr>
              <?php endforeach; ?>
            <?php else: ?>
              <tr>
                <td colspan="4" class="text-center">Tidak Ada Hari Libur Tercatat</td>
              </tr>
            <?php endif; ?>
          </tbody>
        </table>
      </div>
    </div>
  </div>
</div>
<script>
function swalDelete(url) {
    Swal.fire({
        title: 'Apakah Anda yakin?',
        text: "Data ini akan dihapus!",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Ya, hapus!'
    }).then((result) => {
        if (result.isConfirmed) {
            window.location.href = url;
        }
    });
}
</script>

<?= $this->endSection() ?>
