<?= $this->extend('layout/template') ?>
<?= $this->section('content') ?>

<div class="pd-ltr-20 xs-pd-20-10">
  <div class="min-height-200px">
    <!-- Header -->
    <div class="page-header d-flex justify-content-between align-items-center mb-3">
      <h4>List Data CCF</h4>
      <?php if (has_permission(32)): ?>
        <a href="<?= site_url('ccf/create'); ?>" class="btn btn-primary">Tambah CCF</a>
      <?php endif; ?>
    </div>
    <div class="card-box mb-30">
      <div class="pd-20">
        <h4 class="text-blue h4">List Data CCF</h4>
        <p class="mb-0">Data CCF digunakan untuk mengelola informasi terkait die process, dimensi, dan dokumen sketch.</p>
        <!-- <a href="<?= site_url('ccf/create') ?>" class="btn btn-success">Tambah ccf</a> -->
      </div>
      
      <div class="pb-20">
        <?php if (session()->getFlashdata('success')): ?>
          <div class="alert alert-success"><?= session()->getFlashdata('success'); ?></div>
        <?php endif; ?>
        <?php if (session()->getFlashdata('error')): ?>
          <div class="alert alert-danger"><?= session()->getFlashdata('error'); ?></div>
        <?php endif; ?>

        <!-- Tabel List Data CCF -->
        <div class="table-responsive">
          <table id="ccf-table" class="table table-striped hover nowrap">
            <thead>
              <tr>
                <th>No</th>
                <th>Part No</th>
                <th>Customer</th>
                <th>CF Process</th>
                <th>Class</th>
                <th>Aksi</th>
              </tr>
            </thead>
            <tbody>
              <?php $no = 1; foreach ($groupedCcf as $partNo => $items): ?>
                <?php $first = $items[0]; ?>
                <tr class="main-row" data-items='<?= json_encode($items) ?>'>
                  <td><?= $no++ ?></td>
                  <td><?= esc($partNo) ?></td>
                  <td><?= esc($first['customer']) ?></td>
                  <td><?= esc($first['cf_process']) ?></td>
                  <td><?= esc($first['class']) ?></td>
                  <td>
                    <?php if (count($items) > 1): ?>
                      <em>Klik untuk lihat revisi lainnya</em>
                      <?php else: ?>
                        <a href="<?= base_url('ccf/edit/'.$first['id']) ?>" class="btn btn-sm btn-warning">Edit</a>
                        <a href="<?= base_url('ccf/editNew/'.$first['id']) ?>" class="btn btn-sm btn-secondary">Save As New</a>
                        <a href="<?= base_url('ccf/export/'.$first['id']) ?>" class="btn btn-sm btn-success">Excel</a>
                        <?php if ($first['status'] == 1): ?>
                            <a href="<?= base_url('ccf/delete/' . $first['id']) ?>" class="btn btn-danger btn-sm btn-delete" data-toggle="tooltip" title="Delete Data">
                                <i class="fa fa-trash"></i> Delete
                            </a>
                        <?php elseif ($first['status'] == 0): ?>
                            <a href="<?= base_url('ccf/rollback/' . $first['id']) ?>" class="btn btn-light btn-sm btn-rollback" data-toggle="tooltip" title="Rollback Data">
                                <i class="fa fa-recycle"></i> Rollback
                            </a>
                        <?php endif; ?>
                      <?php endif; ?>

                  </td>
                </tr>
              <?php endforeach; ?>
            </tbody>
          </table>
        </div>


        <!-- Tombol untuk menambah data baru -->
       
      </div>
    </div>
  </div>
</div>
<script>
  const BASE_URL = "<?= base_url() ?>";
  $(document).ready(function () {
  $('#ccf-table').on('click', '.main-row', function () {
    var tr = $(this);
    var items = tr.data('items');

    if (tr.hasClass('opened')) {
      tr.next('.detail-row').remove();
      tr.removeClass('opened');
      return;
    }

    $('.detail-row').remove();
    $('.main-row').removeClass('opened');

    var html = '<tr class="detail-row"><td colspan="6"><div class="card p-3 mb-2 bg-light"><ul class="list-group mb-0">';

    items.forEach((item, i) => {
      const revisionText = i === 0 ? 'Dokumen Asli' : `Revisi ${i}`;
      html += `
        <li class="list-group-item d-flex justify-content-between align-items-center">
          <div>- ${revisionText} (Created: ${item.created_at})</div>
          <div>
            <a href="${BASE_URL}/ccf/edit/${item.id}" class="btn btn-sm btn-warning">Edit</a>
            <a href="${BASE_URL}/ccf/editNew/${item.id}" class="btn btn-sm btn-secondary">Save As New</a>
            <a href="${BASE_URL}/ccf/export/${item.id}" class="btn btn-sm btn-success">Excel</a>
            ${
              item.status == 1
                ? `<a href="${BASE_URL}/pps/delete/${item.id}" class="btn btn-danger btn-sm btn-delete ml-1" data-toggle="tooltip" title="Delete Data">
                    <i class="fa fa-trash"></i>
                   </a>`
                : `<a href="${BASE_URL}/pps/rollback/${item.id}" class="btn btn-light btn-sm btn-rollback ml-1" data-toggle="tooltip" title="Rollback Data">
                    <i class="fa fa-recycle"></i>
                   </a>`
            }
          </div>
        </li>`;
    });

    html += '</ul></div></td></tr>';

    tr.after(html);
    tr.addClass('opened');
  });
});


  // SweetAlert for delete
  $(document).on('click', '.btn-delete', function (e) {
    e.preventDefault();
    var url = $(this).attr('href');
    Swal.fire({
      title: 'Yakin ingin menghapus data ini?',
      icon: 'warning',
      showCancelButton: true,
      confirmButtonColor: '#d33',
      cancelButtonColor: '#3085d6',
      confirmButtonText: 'Ya, Hapus!',
      cancelButtonText: 'Batal'
    }).then((result) => {
      if (result.isConfirmed) {
        window.location.href = url;
      }
    });
  });

</script>

<?= $this->endSection() ?>
