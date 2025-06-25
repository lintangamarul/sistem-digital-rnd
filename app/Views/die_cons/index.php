<?= $this->extend('layout/template') ?>
<?= $this->section('content') ?>

<div class="pd-ltr-20 xs-pd-20-10">
  <div class="min-height-200px">
    <div class="page-header d-flex justify-content-between align-items-center mb-3">
      <h4>Daftar Die Cons Images</h4>
      <a href="<?= site_url('die-cons/new'); ?>" class="btn btn-primary">[+] Add New</a>
    </div>
    <div class="card-box mb-30">
      <div class="pd-20">
        <h4 class="text-blue h4">Daftar Gambar Proses Die Cons</h4>
        <p class="mb-0">Berikut adalah daftar gambar yang digunakan untuk proses die cons.</p>
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
              <th>Proses</th>
              <th>Pad Lifter</th>
              <th>Casting Plate</th>
              <th>Image</th>
              <th>Aksi</th>
            </tr>
          </thead>
          <tbody>
            <?php if (!empty($items)): ?>
              <?php $i = 1; ?>
              <?php foreach ($items as $row): ?>
                <tr>
                  <td><?= $i++; ?></td>
                  <td><?= esc($row['proses']) ?></td>
                  <td><?= esc($row['pad_lifter']) ?></td>
                  <td><?= esc($row['casting_plate']) ?></td>
                  <td>
                    <?php if ($row['image']): ?>
                      <img src="<?= base_url('uploads/die_cons/'.$row['image']) ?>" width="80">
                    <?php endif ?>
                  </td>
                  <td>
                    <a href="<?= site_url('die-cons/'.$row['id'].'/edit'); ?>" class="btn btn-sm btn-warning">Edit</a>
                    <form action="<?= site_url('die-cons/'.$row['id']); ?>" method="post" style="display:inline">
                      <?= csrf_field() ?>
                      <input type="hidden" name="_method" value="DELETE">
                      <button class="btn btn-sm btn-danger" onclick="return confirm('Hapus?')">Delete</button>
                    </form>
                  </td>
                </tr>
              <?php endforeach; ?>
            <?php else: ?>
              <tr>
                <td colspan="6" class="text-center">Tidak Ada Data Ditemukan</td>
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
