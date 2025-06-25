<?= $this->extend('layout/template') ?>

<?= $this->section('content') ?>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/Sortable/1.15.0/Sortable.min.css">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">

<style>
/* Card styling improvements */
.card-box {
    border-radius: 12px;
    box-shadow: 0 2px 10px rgba(0,0,0,0.08);
    border: none;
    transition: all 0.3s ease;
}

.card-box:hover {
    box-shadow: 0 4px 20px rgba(0,0,0,0.12);
}

/* Sortable list styling */
.sortable-list {
    list-style: none;
    padding: 0;
    margin: 0;
}

.sortable-item {
    background: linear-gradient(135deg, #f8f9fa 0%, #ffffff 100%);
    border: 1px solid #e3e6f0;
    border-radius: 10px;
    margin: 8px 0;
    padding: 15px 18px;
    cursor: move;
    display: flex;
    align-items: center;
    justify-content: space-between;
    transition: all 0.3s ease;
    position: relative;
    overflow: hidden;
}

.sortable-item::before {
    content: '';
    position: absolute;
    left: 0;
    top: 0;
    height: 100%;
    width: 4px;
    background: linear-gradient(45deg, #4e73df, #36b9cc);
    opacity: 0;
    transition: opacity 0.3s ease;
}

.sortable-item:hover {
    background: linear-gradient(135deg, #e3f2fd 0%, #f8f9ff 100%);
    box-shadow: 0 4px 15px rgba(78, 115, 223, 0.15);
    border-color: #4e73df;
    transform: translateY(-2px);
}

.sortable-item:hover::before {
    opacity: 1;
}

.sortable-ghost {
    opacity: 0.5;
    background: #f1f3f4 !important;
    transform: rotate(5deg);
}

/* User info styling */
.user-info {
    display: flex;
    align-items: center;
    flex: 1;
}

.order-number {
    background: linear-gradient(45deg, #4e73df, #36b9cc);
    color: white;
    border-radius: 50%;
    width: 38px;
    height: 38px;
    display: flex;
    align-items: center;
    justify-content: center;
    font-weight: bold;
    margin-right: 15px;
    font-size: 15px;
    box-shadow: 0 3px 10px rgba(78, 115, 223, 0.3);
}

.user-details {
    flex: 1;
}

.user-name {
    font-size: 15px;
    font-weight: 600;
    color: #2c3e50;
    margin-bottom: 3px;
}

.user-nik {
    font-size: 12px;
    color: #6c757d;
    background: #f8f9fa;
    padding: 2px 8px;
    border-radius: 12px;
    display: inline-block;
}

.drag-handle {
    color: #6c757d;
    font-size: 18px;
    cursor: grab;
    padding: 8px;
    border-radius: 6px;
    transition: all 0.3s ease;
}

.drag-handle:hover {
    color: #4e73df;
    background: rgba(78, 115, 223, 0.1);
}

.drag-handle:active {
    cursor: grabbing;
}

/* Available users styling */
.available-user {
    background: #ffffff;
    border: 1px solid #e3e6f0;
    border-radius: 8px;
    padding: 12px 15px;
    margin-bottom: 8px;
    transition: all 0.3s ease;
}

.available-user:hover {
    background: #f8f9ff;
    border-color: #4e73df;
    box-shadow: 0 2px 8px rgba(78, 115, 223, 0.1);
}

.btn-add {
    width: 32px;
    height: 32px;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 14px;
    transition: all 0.3s ease;
}

.btn-add:hover {
    transform: scale(1.1);
}

/* Empty state styling */
.empty-state {
    text-align: center;
    padding: 40px 20px;
    color: #6c757d;
}

.empty-state i {
    font-size: 3rem;
    margin-bottom: 15px;
    opacity: 0.5;
}

/* Button improvements */
.btn {
    border-radius: 8px;
    font-weight: 500;
    padding: 10px 20px;
    transition: all 0.3s ease;
}

.btn-success {
    background: linear-gradient(45deg, #1cc88a, #13855c);
    border: none;
    box-shadow: 0 3px 10px rgba(28, 200, 138, 0.3);
}

.btn-success:hover {
    transform: translateY(-2px);
    box-shadow: 0 6px 20px rgba(28, 200, 138, 0.4);
}

.btn-info {
    background: linear-gradient(45deg, #36b9cc, #2c9faf);
    border: none;
}

.btn-primary {
    background: linear-gradient(45deg, #4e73df, #3a5bc7);
    border: none;
}

/* Info card styling */
.info-list {
    list-style: none;
    padding: 15px;
    margin: 0;
    background: #f8f9fa;
    border-radius: 8px;
}

.info-list li {
    padding: 8px 0;
    border-bottom: 1px solid #e9ecef;
    display: flex;
    align-items: center;
    font-size: 14px;
}

.info-list li:last-child {
    border-bottom: none;
}

.info-list i {
    margin-right: 10px;
    width: 16px;
    font-size: 14px;
}

/* Section headers */
.section-header {
    border-bottom: 2px solid #f1f3f4;
    padding-bottom: 15px;
    margin-bottom: 15px;
}

.section-title {
    font-size: 17px;
    font-weight: 600;
    color: #2c3e50;
    margin-bottom: 5px;
}

.section-subtitle {
    font-size: 13px;
    color: #6c757d;
    margin: 0;
}

/* Container improvements */
.container-spacing {
    padding: 0 15px;
}

/* Responsive improvements */
@media (max-width: 768px) {
    .sortable-item {
        padding: 12px 15px;
        margin: 6px 0;
    }
    
    .order-number {
        width: 32px;
        height: 32px;
        margin-right: 12px;
        font-size: 13px;
    }
    
    .user-name {
        font-size: 14px;
    }
    
    .available-user {
        padding: 10px 12px;
    }
    
    .container-spacing {
        padding: 0 10px;
    }
}
</style>

<div class="pd-ltr-20 xs-pd-20-10">
    <div class="min-height-200px">
        <!-- Header tidak diubah sesuai permintaan -->
        <div class="page-header d-flex justify-content-between align-items-center mb-4">
            <div>
                <h4>Pengaturan Jadwal Petugas Briefing</h4>
                <p class="text-muted">Atur urutan petugas briefing harian (Senin - Jumat)</p>
            </div>
            <div>
                <a href="<?= site_url('briefing/calendar'); ?>" class="btn btn-info">
                    <i class="fas fa-calendar-alt"></i> Lihat Kalender
                </a>
            </div>
        </div>

        <div class="row">
            <!-- Kolom utama untuk daftar pemimpin -->
            <div class="col-md-8">
                <div class="card-box mb-30">
                    <div class="section-header container-spacing" style="padding-top: 20px;">
                        <h5 class="section-title text-blue">
                            <i class="fas fa-list-ol"></i> Urutan Petugas Briefing
                        </h5>
                        <p class="section-subtitle">Drag dan drop untuk mengubah urutan petugas briefing</p>
                    </div>
                    
                    <div class="container-spacing" style="padding-bottom: 20px;">
                        <?php if (!empty($leaders)): ?>
                            <ul id="sortable-leaders" class="sortable-list">
                                <?php foreach ($leaders as $index => $leader): ?>
                                <li class="sortable-item" data-user-id="<?= $leader['user_id']; ?>">
                                    <div class="user-info">
                                        <div class="order-number"><?= $index + 1; ?></div>
                                        <div class="user-details">
                                            <div class="user-name"><?= $leader['nama']; ?></div>
                                            <div class="user-nik">NIK: <?= $leader['nik']; ?></div>
                                        </div>
                                    </div>
                                    <div class="drag-handle">
                                        <i class="fas fa-grip-vertical"></i>
                                    </div>
                                </li>
                                <?php endforeach; ?>
                            </ul>
                            
                            <div class="mt-3 pt-3 border-top">
                                <button id="save-order" class="btn btn-success">
                                    <i class="fas fa-save"></i> Simpan Urutan
                                </button>
                            </div>
                        <?php else: ?>
                            <div class="empty-state">
                                <i class="fas fa-users text-muted"></i>
                                <h6 class="text-muted">Belum ada petugas briefing</h6>
                                <p class="text-muted small">Tambahkan petugas briefing dari daftar user di samping</p>
                            </div>
                        <?php endif; ?>
                    </div>
                </div>
            </div>

            <!-- Kolom sidebar -->
            <div class="col-md-4">
                <!-- Card untuk menambah pemimpin -->
                <div class="card-box mb-30">
                    <div class="section-header container-spacing" style="padding-top: 20px;">
                        <h5 class="section-title text-blue">
                            <i class="fas fa-user-plus"></i> Tambah Petugas
                        </h5>
                        <p class="section-subtitle">Pilih user untuk ditambahkan sebagai petugas briefing</p>
                    </div>
                    
                    <div class="container-spacing" style="padding-bottom: 20px;">
                        <?php if (!empty($available_users)): ?>
                            <?php foreach ($available_users as $user): ?>
                            <div class="available-user d-flex justify-content-between align-items-center">
                                <div class="flex-grow-1">
                                    <div class="user-name" style="font-size: 14px; margin-bottom: 3px;"><?= $user['nama']; ?></div>
                                    <div class="user-nik" style="font-size: 11px;"><?= $user['nik']; ?></div>
                                </div>
                                <button class="btn btn-primary btn-add add-leader" data-user-id="<?= $user['id']; ?>">
                                    <i class="fas fa-plus"></i>
                                </button>
                            </div>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <div class="text-center py-3">
                                <i class="fas fa-check-circle text-success mb-2" style="font-size: 2rem;"></i>
                                <p class="text-muted small mb-0">Semua user aktif sudah menjadi petugas briefing</p>
                            </div>
                        <?php endif; ?>
                    </div>
                </div>

                <!-- Card informasi -->
                <div class="card-box">
                    <div class="section-header container-spacing" style="padding-top: 20px;">
                        <h5 class="section-title text-blue">
                            <i class="fas fa-info-circle"></i> Informasi
                        </h5>
                        <p class="section-subtitle">Ketentuan jadwal briefing</p>
                    </div>
                    
                    <div class="container-spacing" style="padding-bottom: 20px;">
                        <ul class="info-list">
                            <li class="d-flex align-items-center">
                                <i class="fas fa-check text-success"></i>
                                <span>Briefing hanya Senin - Jumat</span>
                            </li>
                            <li class="d-flex align-items-center">
                                <i class="fas fa-calendar-times text-warning"></i>
                                <span>Melewati hari libur/tanggal merah</span>
                            </li>
                            <li class="d-flex align-items-center">
                                <i class="fas fa-sync text-info"></i>
                                <span>Rotasi otomatis sesuai urutan</span>
                            </li>
                            <li class="d-flex align-items-center">
                                <i class="fas fa-user-slash text-danger"></i>
                                <span>Penggantian jika absen</span>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script src="https://cdnjs.cloudflare.com/ajax/libs/Sortable/1.15.0/Sortable.min.js"></script>
<script>
document.addEventListener('DOMContentLoaded', function() {
    const sortableList = document.getElementById('sortable-leaders');
    
    if (sortableList) {
        const sortable = Sortable.create(sortableList, {
            animation: 200,
            ghostClass: 'sortable-ghost',
            chosenClass: 'sortable-chosen',
            dragClass: 'sortable-drag',
            onEnd: function() {
                updateOrderNumbers();
            }
        });
    }

    function updateOrderNumbers() {
        const items = document.querySelectorAll('.sortable-item');
        items.forEach((item, index) => {
            const orderNumber = item.querySelector('.order-number');
            orderNumber.textContent = index + 1;
        });
    }

    // Save order functionality
    const saveButton = document.getElementById('save-order');
    if (saveButton) {
        saveButton.addEventListener('click', function() {
            const items = document.querySelectorAll('.sortable-item');
            const order = Array.from(items).map(item => parseInt(item.dataset.userId));
            
            // Disable button during save
            saveButton.disabled = true;
            saveButton.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Menyimpan...';
            
            fetch('<?= site_url('briefing/update-order'); ?>', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-Requested-With': 'XMLHttpRequest'
                },
                body: JSON.stringify({order: order})
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    Swal.fire('Berhasil!', data.message, 'success');
                } else {
                    Swal.fire('Gagal!', data.message, 'error');
                }
            })
            .catch(error => {
                console.error('Error:', error);
                Swal.fire('Error!', 'Terjadi kesalahan saat menyimpan', 'error');
            })
            .finally(() => {
                // Re-enable button
                saveButton.disabled = false;
                saveButton.innerHTML = '<i class="fas fa-save"></i> Simpan Urutan';
            });
        });
    }

    // Add leader functionality
    document.querySelectorAll('.add-leader').forEach(button => {
        button.addEventListener('click', function() {
            const userId = this.dataset.userId;
            const userName = this.closest('.available-user').querySelector('.user-name').textContent;
            
            Swal.fire({
                title: 'Tambah Pemimpin',
                text: `Tambahkan ${userName} sebagai pemimpin briefing?`,
                icon: 'question',
                showCancelButton: true,
                confirmButtonText: 'Ya, Tambahkan',
                cancelButtonText: 'Batal',
                confirmButtonColor: '#4e73df',
                cancelButtonColor: '#6c757d'
            }).then((result) => {
                if (result.isConfirmed) {
                    // Disable button during request
                    button.disabled = true;
                    button.innerHTML = '<i class="fas fa-spinner fa-spin"></i>';
                    
                    fetch('<?= site_url('briefing/add-leader'); ?>', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/x-www-form-urlencoded',
                            'X-Requested-With': 'XMLHttpRequest'
                        },
                        body: `user_id=${userId}`
                    })
                    .then(response => response.json())
                    .then(data => {
                        if (data.success) {
                            Swal.fire('Berhasil!', data.message, 'success')
                            .then(() => location.reload());
                        } else {
                            Swal.fire('Gagal!', data.message, 'error');
                            // Re-enable button on error
                            button.disabled = false;
                            button.innerHTML = '<i class="fas fa-plus"></i>';
                        }
                    })
                    .catch(error => {
                        console.error('Error:', error);
                        Swal.fire('Error!', 'Terjadi kesalahan', 'error');
                        // Re-enable button on error
                        button.disabled = false;
                        button.innerHTML = '<i class="fas fa-plus"></i>';
                    });
                }
            });
        });
    });
});

</script>

<?= $this->endSection() ?>