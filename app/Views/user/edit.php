<?= $this->extend('layout/template') ?>

<?= $this->section('content') ?>
<div class="pd-ltr-20 xs-pd-20-10">
    <div class="min-height-200px">
        <div class="page-header">
            <div class="row">
                <div class="col-md-6 col-sm-12">
                    <div class="title">
                        <h4>Edit Pengguna</h4>
                    </div>
                    <nav aria-label="breadcrumb" role="navigation">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item">
                                <a href="<?= site_url('actual-activity/personal'); ?>">Home</a>
                            </li>
                            <li class="breadcrumb-item">
                                <a href="<?= site_url('user'); ?>">Pengguna</a>
                            </li>
                            <li class="breadcrumb-item active" aria-current="page">Edit Pengguna</li>
                        </ol>
                    </nav>
                </div>
            </div>
        </div>

        <div class="pd-20 card-box mb-30">
            <form action="<?= site_url('user/update/'.$user['id']); ?>" method="post" enctype="multipart/form-data">
            <?= csrf_field(); ?>
                <div class="form-group row">
                    <div class="col-md-6">
                        <label>Nama <span style="color: red">*</span></label>
                        <input type="text" name="nama" value="<?= $user['nama']; ?>" class="form-control" required>
                    </div>
                    <div class="col-md-6">
                        <label class="col-form-label">Nickname <span style="color: red">*</span></label>
                        <input type="text" name="nickname" value="<?= $user['nickname']; ?>" class="form-control" required>
                    </div>
                   
                </div>

                <div class="form-group row">
                    <div class="col-md-6">
                        <label>NIK <span style="color: red">*</span></label>
                        <input type="text" name="nik" value="<?= $user['nik']; ?>" class="form-control" required>
                    </div>
                    <div class="col-md-6">
                        <label>Password (Kosongkan jika tidak ingin diubah)</label>
                        <input type="password" name="password" class="form-control" placeholder="******">
                    </div>
                
                </div>

                <div class="form-group row">
                    <div class="col-md-6">
                        <label>Departemen</label>
                        <input type="text" name="department" value="<?= $user['department']; ?>" class="form-control">
                    </div>
                    <div class="col-md-6">
                        <label class=" col-form-label">Role <span style="color: red;">*</span></label>
                        <select name="role_id" class="custom-select2 form-control" style="width: 100%; height: 38px;" required>
                            <option value="">-- Pilih Role --</option>
                            <?php foreach ($roles as $role) : ?>
                                <?php if (session('role_id') == 5 || $role['id'] != 5) : ?>
                                    <option value="<?= $role['id']; ?>" <?= ($role['id'] == $user['role_id']) ? 'selected' : ''; ?>>
                                        <?= $role['role_name']; ?>
                                    </option>
                                <?php endif; ?>
                            <?php endforeach; ?>
                        </select>
                    </div>
                </div>
                <input type="hidden" name="old_foto" value="<?= $user['foto']; ?>">
                <div class="form-group row">
                    <div class="col-md-6">
                        <label class="col-form-label">Foto Profil</label>
                        <input type="file" name="foto" class="form-control" onchange="previewImage(event)">
                    </div>
                    <div class="col-md-6">
                    <label>Group</label>
              
                        <input type="text" name="group" value="<?= $user['group']; ?>" class="form-control">
                    </div>
                </div>
                <div class="form-group row">
               
                    <div class="col-md-6">
                        <label class="col-form-label">Pratinjau Foto</label>
                        <br>
                        <img id="imagePreview" src="<?= $user['foto'] ? base_url('uploads/users/' . $user['foto']) : base_url('uploads/default.png') ?>" width="100" class="img-thumbnail">
                    </div>
                </div>
                <div class="form-group row">
                    <div class="col-md-12 text-right">
                        <button type="submit" class="btn btn-success">Update</button>
                        <a href="<?= site_url('user'); ?>" class="btn btn-secondary">Kembali</a>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
function previewImage(event) {
    var input = event.target;
    var reader = new FileReader();

    reader.onload = function () {
        var imgElement = document.getElementById('imagePreview');
        imgElement.src = reader.result;
    };

    reader.readAsDataURL(input.files[0]);
}
</script>

<?= $this->endSection() ?>
