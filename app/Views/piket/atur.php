<?= $this->extend('layout/template') ?> 
<?= $this->section('content') ?>
<script src="https://cdn.jsdelivr.net/npm/sortablejs@1.15.0/Sortable.min.js"></script>

<div class="pd-ltr-20 xs-pd-20-10">
    <div class="min-height-200px">
        <div class="page-header mb-3 d-flex justify-content-between align-items-center">
            <div>
                <h4><?= $is_edit ? 'Edit' : 'Buat' ?> Jadwal Piket</h4>
                <small class="text-muted"><?= $week_info['title'] ?></small>
            </div>
            <a href="<?= site_url('piket') ?>" class="btn btn-secondary">
                <i class="fa fa-arrow-left"></i> Kembali
            </a>
        </div>

        <?php if (session()->getFlashdata('error')): ?>
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                <?= session()->getFlashdata('error') ?>
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
        <?php endif; ?>

        <div class="row">
            <div class="col-lg-9">
                <div class="card shadow-sm mb-4">
                    <div class="card-header bg-white d-flex justify-content-between align-items-center">
                        <h5 class="text-primary mb-0">
                            <i class="fa fa-calendar-alt"></i> 
                            <?= $week_info['title'] ?> (Drag & Drop untuk mengatur)
                        </h5>
                        <div>
                            <?php if (!$is_edit): ?>
                                <a href="<?= site_url('piket/acak?week=' . $week) ?>" class="btn btn-sm btn-outline-primary mr-2">
                                    <i class="fa fa-random"></i> Acak Ulang
                                </a>
                            <?php endif; ?>
                            <button type="submit" form="form-piket" class="btn btn-sm btn-success">
                                <i class="fa fa-save"></i> <?= $is_edit ? 'Update' : 'Simpan' ?> Jadwal
                            </button>
                        </div>
                    </div>

                    <form method="post" action="<?= site_url('piket/simpan') ?>" id="form-piket">
                        <?= csrf_field() ?>
                        <input type="hidden" name="week" value="<?= $week ?>">
                        
                        <div class="card-body">
                            <div class="row">
                                <?php foreach ($week_info['dates'] as $tgl): ?>
                                    <div class="col-md-6 col-lg-3 mb-4">
                                        <div class="schedule-day border rounded shadow-sm h-100 d-flex flex-column">
                                            <?php $isHoliday = in_array($tgl, $holiday_dates); ?>
                                            <div class="text-center py-3 <?= $isHoliday ? 'bg-danger' : 'bg-primary' ?> text-white rounded-top">
                                                <div class="font-weight-bold small"><?= date('l', strtotime($tgl)) ?></div>
                                                <div class="small"><?= date('d M Y', strtotime($tgl)) ?></div>
                                            </div>
                                            
                                            <div class="dropzone p-3 flex-fill bg-white" 
                                                 data-date="<?= $tgl ?>" 
                                                 style="min-height: 300px; border-radius: 0 0 0.375rem 0.375rem;">
                                                
                                                <?php if (!empty($jadwal[$tgl])): ?>
                                                    <?php foreach ($jadwal[$tgl] as $index => $u): ?>
                                                        <div class="draggable-item d-flex align-items-center border rounded bg-light shadow-sm p-2 mb-2 position-relative" 
                                                             data-user-id="<?= $u['id'] ?>" 
                                                             style="cursor: grab;">
                                                             
                                                            <div class="position-absolute" style="top: 5px; left: 5px; background: #007bff; color: white; border-radius: 50%; width: 20px; height: 20px; display: flex; align-items: center; justify-content: center; font-size: 10px; font-weight: bold;">
                                                                <?= $index + 1 ?>
                                                            </div>
                                                             
                                                            <img src="<?= empty($u['foto']) ? base_url('assets/images/person.jpg') : base_url('uploads/users/' . $u['foto']) ?>"
                                                                 class="rounded-circle mr-2"
                                                               
                                                                 style="width: 50px; height: 50px; object-fit: cover; object-position: center; border: 2px solid #007bff; margin-left: 15px;">
                                                             
                                                            <div class="flex-fill">
                                                                <div class="font-weight-bold text-dark small"><?= esc($u['nickname']) ?></div>
                                                                <div class="text-muted small">Grup <?= esc($u['group']) ?></div>
                                                            </div>
                                                        </div>
                                                    <?php endforeach ?>
                                                <?php endif; ?>
                                                
                                                <div class="drop-hint text-muted text-center small" style="<?= !empty($jadwal[$tgl]) ? 'display: none;' : '' ?>">
                                                    <i class="fa fa-hand-point-down"></i><br>
                                                    Drag anggota ke sini
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                <?php endforeach ?>
                            </div>
                        </div>

                        <div id="hidden-inputs"></div>
                    </form>
                </div>
            </div>

            <div class="col-lg-3">
                <div class="card shadow-sm mb-4">
                    <div class="card-header bg-secondary text-white">
                        <h5 class="mb-0 text-white"><i class="fa fa-users"></i> Daftar User</h5>

                    </div>
                    <div class="card-body" style="max-height: 700px; overflow-y: auto;">
                        <div id="user-list" class="dropzone" style="min-height: 500px; border: 2px dashed #6c757d; background: #f8f9fa; padding: 10px;">
                        <?php foreach ($allUsers as $index => $u): ?>
                            <div class="draggable-item d-flex align-items-center border rounded bg-white shadow-sm p-2 mb-2" 
                                data-user-id="<?= $u['id'] ?>" 
                                style="cursor: grab; position: relative;">
                                
                                <div class="position-absolute" style="top: 5px; left: 5px; 
                                    background: #6c757d; color: white; border-radius: 50%; 
                                    width: 20px; height: 20px; display: flex; align-items: center; 
                                    justify-content: center; font-size: 10px; font-weight: bold;">
                                    <?= $index + 1 ?>
                                </div>

                                <img src="<?= empty($u['foto']) ? base_url('assets/images/person.jpg') : base_url('uploads/users/' . $u['foto']) ?>"
                                    class="rounded-circle mr-2"
                                    width="40" height="40"
                                    style="width: 40px; height: 40px; object-fit: cover; object-position: center; border: 2px solid #6c757d; margin-left: 30px;">

                                <div class="flex-fill">
                                    <div class="font-weight-bold text-dark small"><?= esc($u['nickname']) ?></div>
                                    <div class="text-muted small">Grup <?= esc($u['group']) ?></div>
                                </div>
                            </div>
                        <?php endforeach ?>

                        </div>
                        <small class="text-muted d-block mt-2">Tarik user dari sini ke hari yang diinginkan</small>
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-md-6">
                <div class="card">
                    <div class="card-header bg-info text-white">
                        <h6 class="mb-0"><i class="fa fa-info-circle"></i> Petunjuk</h6>
                    </div>
                    <div class="card-body">
                        <ul class="list-unstyled mb-0 small">
                            <li><i class="fa fa-check text-success"></i> Drag dan drop anggota untuk mengatur jadwal</li>
                            <li><i class="fa fa-check text-success"></i> Setiap hari idealnya 5 orang piket</li>
                            <li><i class="fa fa-check text-success"></i> Nomor di pojok menunjukkan urutan piket</li>
                            <li><i class="fa fa-check text-success"></i> Hari libur tidak perlu dijadwalkan</li>
                        </ul>
                    </div>
                </div>
            </div>
            
            <div class="col-md-6">
                <div class="card">
                    <div class="card-header bg-warning text-white">
                        <h6 class="mb-0"><i class="fa fa-exclamation-triangle"></i> Catatan</h6>
                    </div>
                    <div class="card-body">
                        <div class="small">
                            <?php if ($is_edit): ?>
                                <p class="text-info"><i class="fa fa-edit"></i> Anda sedang mengedit jadwal yang sudah ada</p>
                            <?php else: ?>
                                <p class="text-success"><i class="fa fa-plus"></i> Jadwal otomatis telah dibuat berdasarkan grup</p>
                            <?php endif; ?>
                            <p class="text-muted mb-0">Pastikan untuk menyimpan perubahan setelah selesai mengatur</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', () => {
    const zones = document.querySelectorAll('.dropzone');
    
    zones.forEach(zone => {
        new Sortable(zone, {
            group: 'piketGroup',
            animation: 150,
            ghostClass: 'sortable-ghost',
            chosenClass: 'sortable-chosen',
            dragClass: 'sortable-drag',
            sort: zone.id !== 'user-list', 
            onAdd: function(evt) {
                if (evt.from.id === 'user-list') {
                 
                    evt.item.parentNode.removeChild(evt.item);
                    const clone = evt.clone;
                    clone.style.cursor = 'grab';
                    evt.to.insertBefore(clone, evt.to.children[evt.newIndex]);
                    updateHiddenInputs();
                    updateDropHints();
                    updateNumbering();
                }
            },
            onSort: function(evt) {
                updateHiddenInputs();
                updateDropHints();
                updateNumbering();
            }
        });
    });

    function updateHiddenInputs() {
        const container = document.getElementById('hidden-inputs');
        container.innerHTML = '';
        
        document.querySelectorAll('.dropzone').forEach(zone => {
            if (zone.id === 'user-list') return; 
            
            const date = zone.getAttribute('data-date');
            zone.querySelectorAll('.draggable-item').forEach(item => {
                const id = item.getAttribute('data-user-id');
                const input = document.createElement('input');
                input.type = 'hidden';
                input.name = `jadwal[${date}][]`;
                input.value = id;
                container.appendChild(input);
            });
        });
    }

    function updateDropHints() {
        document.querySelectorAll('.dropzone').forEach(zone => {
            if (zone.id === 'user-list') return;
            const hint = zone.querySelector('.drop-hint');
            const items = zone.querySelectorAll('.draggable-item');
            if (hint) {
                hint.style.display = items.length === 0 ? 'block' : 'none';
            }
        });
    }

    function updateNumbering() {
        document.querySelectorAll('.dropzone').forEach(zone => {
            if (zone.id === 'user-list') return;
            const items = zone.querySelectorAll('.draggable-item');
            items.forEach((item, index) => {
                const numberBadge = item.querySelector('.position-absolute');
                if (numberBadge) {
                    numberBadge.textContent = index + 1;
                }
            });
        });
    }

    updateHiddenInputs();
    updateDropHints();
    updateNumbering();
});

const style = document.createElement('style');
style.textContent = `
    .sortable-ghost {
        opacity: 0.5;
        background: #f8f9fa !important;
    }
    .sortable-chosen {
        transform: scale(1.05);
        box-shadow: 0 5px 15px rgba(0,0,0,0.3) !important;
    }
    .sortable-drag {
        transform: rotate(5deg);
    }
    .draggable-item:hover {
        transform: translateY(-2px);
        box-shadow: 0 4px 8px rgba(0,0,0,0.15);
        transition: all 0.2s ease;
    }
    .dropzone {
        border: 2px dashed transparent !important;
        transition: all 0.3s ease;
    }
    .dropzone.sortable-drag-over {
        border-color: #007bff !important;
        background-color: rgba(0, 123, 255, 0.1) !important;
    }
    .schedule-day:hover {
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(0,0,0,0.15) !important;
    }
    .draggable-item {
        transition: all 0.2s ease;
        cursor: grab;
    }
    .draggable-item:active {
        cursor: grabbing;
    }
    .drop-hint {
        pointer-events: none;
        transition: opacity 0.3s ease;
    }
    .position-absolute {
        z-index: 10;
        font-size: 10px;
        font-weight: bold;
    }
    @media (max-width: 768px) {
        .draggable-item {
            margin-bottom: 8px;
        }
        .schedule-day {
            margin-bottom: 20px;
        }
        .dropzone {
            min-height: 200px !important;
        }
    }
`;
document.head.appendChild(style);
</script>
<?= $this->endSection() ?>
