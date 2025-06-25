<?= $this->extend('layout/template') ?>

<?= $this->section('content') ?>
<link rel="stylesheet" type="text/css" href="<?= base_url('assets/vendors/styles/icon-font.min.css') ?>"><link rel="stylesheet" type="text/css" href="<?= base_url('assets/plugins/datatables/css/dataTables.bootstrap4.min.css') ?>">
<link rel="stylesheet" type="text/css" href="<?= base_url('assets/plugins/datatables/css/responsive.bootstrap4.min.css') ?>">
<div class="pd-ltr-20 xs-pd-20-10">
    <div class="min-height-200px">
    <div class="page-header d-flex justify-content-between align-items-center mb-3">
            <h4>Master Data Pengguna</h4>
            <?php if (has_permission(2)):?>
            <a href="<?= site_url('user/create'); ?>" class="btn btn-primary">Tambah Pengguna</a>
            <?php endif;?>

        </div>
        <!-- <div class="page-header d-flex justify-content-between align-items-center mb-3">
            <h4>Master Data Pengguna</h4>
            <?php if (has_permission(2)): ?>
                <a href="<?= site_url('user/create'); ?>" class="btn btn-primary">Tambah Pengguna</a>
            <?php endif; ?>
            <a href="<?= site_url('user/downloadExcel'); ?>" class="btn btn-success ml-2">Download Excel</a>
        </div> -->

        <div class="card-box mb-30">
        <div class="pd-20">
                <h4 class="text-blue h4">Daftar Pengguna Aktif Sistem Daily Report</h4>
                <p class="mb-0"></p>
            </div>
            <div class="pb-20">      
                <table class="data-table table stripe hover nowrap">
                    <thead>
                        <tr>
                        <th>Foto</th>
                            <th class="table-plus datatable-nosort">NIK</th>
                            <th>Nama</th>
                            <th>Group</th>
                            <th>Departemen</th>
                            
                            <?php if (has_permission(4) || has_permission(5)): ?>
                                <th>Aksi</th>
                            <?php endif; ?>

                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($users as $user): ?>
                            <tr>
                                
                                <td>
                                    <a href="#" class="photo-modal-trigger" data-photo="<?= empty($user['foto']) ? base_url('assets/images/person.jpg') : base_url('uploads/users/' . $user['foto']) ?>">
                                        <img src="<?= empty($user['foto']) ? base_url('assets/images/person.jpg') : base_url('uploads/users/' . $user['foto']) ?>"  style="width: 30px;weight: 30px;"  class="img-thumbnail">
                                    </a>
                                </td>

                                <td><?= $user['nik']; ?></td>
                                <td><?= $user['nama']; ?></td>
                                <td><?= $user['group']; ?></td>
                                <td><?= $user['department']; ?></td>
                                <td>
                                    <?php 
                                    $sessionRoleId = session('role_id'); 
                                    $encryptedId = urlsafe_b64encode(service('encrypter')->encrypt($user['id']));
                               
                  
                                    if ($user['role_id'] == 5 && $sessionRoleId == 5) : ?>
                                        <?php if (has_permission(3)): ?>
                                            <a href="<?= site_url('user/edit/'.$encryptedId); ?>" class="btn btn-sm btn-warning">Edit</a>
                                        <?php endif; ?>
                                        <?php if (has_permission(4)): ?>
                                            <a href="#" class="btn btn-sm btn-danger" onclick="confirmDelete('<?= site_url('user/delete/'.$user['id']); ?>')">Hapus</a>
                                        <?php endif; ?>
                                    <?php 
                                    elseif ($user['role_id'] != 5) : ?>

                                        <?php if (has_permission(3)): ?>
                                            <a href="<?= site_url('user/edit/'.$encryptedId); ?>" class="btn btn-sm btn-warning">Edit</a>
                                        <?php endif; ?>
                                        <?php if (has_permission(4)): ?>
                                            <a href="#" class="btn btn-sm btn-danger" onclick="confirmDelete('<?= site_url('user/delete/'.$user['id']); ?>')">Hapus</a>
                                        <?php endif; ?>
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
<!-- Image Modal -->
<div class="modal fade" id="photoModal" tabindex="-1" role="dialog" aria-labelledby="photoModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-body text-center">
        <img id="modalPhoto" src="" alt="User Photo" class="img-fluid">
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
</div>

<script>
function confirmDelete(url) {
    Swal.fire({
        title: "Apakah Anda yakin?",
        text: "Data yang dihapus tidak bisa dikembalikan!",
        icon: "warning",
        showCancelButton: true,
        confirmButtonColor: "#d33",
        cancelButtonColor: "#3085d6",
        confirmButtonText: "Ya, hapus!",
        cancelButtonText: "Batal"
    }).then((result) => {
        if (result.isConfirmed) {
            window.location.href = url;
        }
    });
}
</script>
<script>
$(document).ready(function(){
    $('.photo-modal-trigger').on('click', function(e){
        e.preventDefault();
        var photoUrl = $(this).data('photo'); 
        $('#modalPhoto').attr('src', photoUrl); 
        $('#photoModal').modal('show'); 
    });
});
</script>

<?= $this->endSection() ?>
