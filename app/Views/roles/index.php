<!-- File: app/Views/roles/index.php -->
<?= $this->extend('layout/template') ?>
<?= $this->section('content') ?>

<div class="pd-ltr-20 xs-pd-20-10">
  <div class="min-height-200px">
    <div class="page-header d-flex justify-content-between align-items-center mb-3">
      <h4>Master Data Roles</h4>
      <?php if (has_permission(10)):?>
      <a href="<?= site_url('role/create'); ?>" class="btn btn-primary">Tambah Role</a>
      <?php endif; ?>
    </div>

    <div class="card-box mb-30">
      <div class="pd-20">
        <h4 class="text-blue h4">Daftar Roles</h4>
        <p class="mb-0">Roles digunakan untuk mengatur hak akses pengguna.</p>
      </div>
      <div class="pb-20">
        <table class="data-table table stripe hover nowrap">
          <thead>
            <tr>
              <th>No</th>
              <th>Role Name</th>
              <th>Aksi</th>
            </tr>
          </thead>
          <tbody>
            <?php $i = 1; ?>
            <?php if (!empty($roles)) : ?>
              <?php foreach ($roles as $role) : ?>
                <tr>
                  <td><?= $i++; ?></td>
                  <td><?= esc($role['role_name']); ?></td>
                  <td>
                  <?php 
                            $encryptedId = urlsafe_b64encode(service('encrypter')->encrypt($role['id']));
                        ?>
                
                  <?php if (has_permission(11)): ?>
                      <a href="<?= site_url('role/edit/'.$encryptedId); ?>" class="btn btn-sm btn-warning">Edit</a>
                  <?php endif; ?>

                

                 <?php if ($role['id'] != 5 && $role['id'] != 6): ?> 
                    <?php if (has_permission(12)): ?>
                        <a href="#" class="btn btn-sm btn-danger" onclick="swalDelete('<?= site_url('role/delete/'.$role['id']); ?>'); return false;">Delete</a>
                    <?php endif; ?>
                <?php endif; ?>

                </td>

                </tr>
              <?php endforeach; ?>
            <?php else: ?>
              <tr><td colspan="3">No roles found.</td></tr>
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
    title: 'Anda yakin?',
    text: "Data role akan dihapus dan tidak dapat dikembalikan.",
    icon: 'warning',
    showCancelButton: true,
    confirmButtonColor: '#3085d6',
    cancelButtonColor: '#d33',
    confirmButtonText: 'Ya, hapus!',
    cancelButtonText: 'Batal'
  }).then((result) => {
    if (result.isConfirmed) {
      window.location.href = url;
    }
  });
}
</script>
<?= $this->endSection() ?>
