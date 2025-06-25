
<?= $this->extend('layout/template') ?>
<?= $this->section('content') ?>
<div class="row">
	<div class="col-xl-4 col-lg-4 col-md-4 col-sm-12 mb-30">
		<div class="pd-20 card-box height-100-p">
		<style>
.profile-photo {
    margin-bottom: 60px;
}
.avatar-photo {
    display: block;
    max-width: 100%;
    height: auto;
    margin: 0 auto;
}

</style>
<style>
.profile-timeline {
    max-height: 1000px;
    overflow-y: auto;
}
</style>

<div class="profile-photo">
<?php if ($user['id'] == session()->get('user_id')): ?>
    <a href="#" data-toggle="modal" data-target="#modal" class="edit-avatar">
        <i class="fa fa-pencil"></i>
    </a>
<?php endif; ?>

    <img id="current-photo" src="<?= !empty($user['foto']) ? base_url('uploads/users/' . $user['foto']) : base_url('assets/images/person.jpg') ?>" style="max-height: 200px; " alt="User Photo" class="avatar-photo">
</div>

<!-- Modal -->
<div class="modal fade" id="modal" tabindex="-1" role="dialog" aria-labelledby="modalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <form action="<?= site_url('user/update-photo') ?>" method="post" enctype="multipart/form-data">
			<?= csrf_field(); ?>
                <div class="modal-body pd-5">
                    <div class="img-container text-center">
                        <img id="preview" src="<?= base_url('assets/images/person.jpg') ?>" alt="Preview" class="avatar-photo mb-3" style="max-width: 150px;max-height: 150px; display: none;">
						<input type="file" class="form-control" name="foto" accept=".png, .jpg, .jpeg, .gif" id="fotoUpload" required>

                    </div>
                </div>
                <div class="modal-footer">
                    <input type="submit" value="Update" class="btn btn-primary">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
document.getElementById('fotoUpload').addEventListener('change', function(event) {
    const preview = document.getElementById('preview');
    const file = event.target.files[0];

    if (file) {
        const reader = new FileReader();
        reader.onload = function(e) {
            preview.src = e.target.result;
            preview.style.display = 'block';
        };
        reader.readAsDataURL(file);
    } else {
        preview.style.display = 'none';
    }
});
</script>


<h5 class="text-center h5 mb-0"><?= esc($user['nama']) ?></h5>
	<p class="text-center text-muted font-14"> Hak Akses : <?= esc($user['role_name']) ?></p>
			<div class="profile-info">
				<h5 class="mb-20 h5 text-blue">Informasi Diri</h5>
				<ul>
					<!-- <li>
						<span>Alamat Email:</span>
						<?= esc($user['email']) ?>
					</li>
					<li>
						<span>Nomor Telepon:</span>
						<?= esc($user['no_hp']) ?>
					</li> -->
					<li>
						<span>Departemen:</span>
                        <?= esc($user['department']) ?>
					</li>
              
				</ul>
			</div>
		</div>
	</div>
	<div class="col-xl-8 col-lg-8 col-md-8 col-sm-12 mb-30">
		<div class="card-box height-100-p overflow-hidden">
			<div class="profile-tab height-100-p">
				<div class="tab height-100-p">
					<ul class="nav nav-tabs customtab" role="tablist">
						<li class="nav-item">
							<a class="nav-link active" data-toggle="tab" href="#timeline" role="tab">Timeline</a>
						</li>
					</ul>
					<div class="tab-content">
						<div class="tab-pane fade show active" id="timeline" role="tabpanel">
							<div class="pd-10">
							<div class="profile-timeline" style="max-height: 1000px; overflow-y: auto;">
								

								<?php if(!empty($timelineData)): ?>
									<?php if ($user['id'] == session()->get('user_id')): ?>
									<form method="get" action="<?= site_url('profile'); ?>" class="d-flex align-items-center">
										<div class="form-group mr-2">
											<label for="start_date" class="mr-1">Start Date:</label>
											<input type="date" name="start_date" id="start_date" class="form-control" value="<?= esc($start_date); ?>">
										</div>
										<div class="form-group mr-2">
											<label for="end_date" class="mr-1">End Date:</label>
											<input type="date" name="end_date" id="end_date" class="form-control" value="<?= esc($end_date); ?>">
										</div>
										<button type="submit" class="btn btn-primary mt-3">Filter</button>
									</form>
									<?php endif; ?>
									<?php foreach($timelineData as $month => $events): ?>
										<div class="timeline-month">
											   <h5><?= esc(strftime('%B %Y', strtotime($month))) ?></h5>
										</div>
										<div class="profile-timeline-list">
											<ul>
												<?php $lastDate = ''; ?>
												<?php foreach($events as $event): ?>
													<li>
														<?php if($lastDate !== $event['date']): ?>
															<div class="date"><?= esc(date('d/m', strtotime($event['date']))) ?></div>
															<?php $lastDate = $event['date']; ?>
														<?php endif; ?>
														
														<div class="task-name">
															<i class="ion-ios-clock"></i> <?= esc($event['activity_name']) ?>
														</div>
														<p>
															<?php if (!empty($event['model']) || !empty($event['part_no']) || !empty($event['process']) || !empty($event['idss'])): ?>
																<?php if (!empty($event['model'])): ?>
																	Model: <?= esc($event['model']) ?>
																<?php endif; ?>
																<?php if (!empty($event['part_no'])): ?>
																	- <?= esc($event['part_no']) ?>
																<?php endif; ?>
																<?php if (!empty($event['process'])): ?>
																	- <?= esc($event['process']) ?>
																<?php endif; ?>
																<?php if (!empty($event['proses'])): ?>
																	(<?= esc($event['proses']) ?>)
																<?php endif; ?>
															<?php endif; ?>

															<?php if(!empty($event['another_project'])): ?>
																<br>Project: <?= esc($event['another_project']) ?>
															<?php endif; ?>
															<?php if(!empty($event['remark'])): ?>
																<br>Remark: <?= esc($event['remark']) ?>
															<?php endif; ?>
														</p>
														<div class="task-time">
															<?= esc($event['time']) ?> s/d <?= esc($event['end_time']) ?> = 
															<?= floor($event['total_time'] / 60) . ' jam ' . ($event['total_time'] % 60) . ' menit' ?>
														</div>
													</li>
												<?php endforeach; ?>
											</ul>
										</div>
									<?php endforeach; ?>
								<?php else: ?>
									<p>Tidak ada aktivitas.</p>
								<?php endif; ?>
							</div>

							</div>
						</div>
					</div>
				</div>
			</div>            
		</div>
	</div>
</div>
<?= $this->endSection() ?>
