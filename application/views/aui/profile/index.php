<?php

/**
* Developer: Yurii Sychov
* Site: http://sychov.pp.ua
* Email: yurii@sychov.pp.ua
*/

defined('BASEPATH') OR exit('No direct script access allowed');

?>

<?php if (isset($user)): ?>
	<div class="row">
		<div class="col-lg-12">
			<div class="main-card mb-3 card">
				<div class="card-header-tab card-header">
					<div class="card-header-title"><?php echo $title; ?></div>
					<ul class="nav">
						<li class="nav-item"><a data-toggle="tab" href="#tabProfile" class="nav-link active show">Профіль</a></li>
						<li class="nav-item"><a data-toggle="tab" href="#tabProfileEdit" class="nav-link show">Редагувати</a></li>
						<li class="nav-item"><a data-toggle="tab" href="#tabProfileRights" class="nav-link show">Права</a></li>
					</ul>
				</div>
				<div class="card-body">
					<div class="tab-content">
						<div class="tab-pane show active" id="tabProfile" role="tabpanel">
							<pre>
								<?php print_r($user); ?>
							</pre>
						</div>
						<div class="tab-pane show" id="tabProfileEdit" role="tabpanel">
							<pre>
								<?php print_r($user); ?>
							</pre>
						</div>
						<div class="tab-pane show" id="tabProfileRights" role="tabpanel">
							<?php if (isset($rights)): ?>
								<div class="table-responsive">
									<table class="mb-0 table table-striped table-bordered">
										<thead>
											<tr class="text-center">
												<th width="5%">ID</th>
												<th width="20%">Створювати</th>
												<th width="20%">Читати</th>
												<th width="20%">Змінювати</th>
												<th width="20%">Видаляти</th>
												<th width="15%">Сторінка</th>
											</tr>
										</thead>
										<tbody>
											<?php foreach ($rights as $item): ?>
												<tr class="text-center">
													<td><?php echo $item->id; ?></td>
													<td><?php echo $item->right_create ? '<i class="text-success fas fa-check"></i>' : '<i class="text-danger fas fa-times"></i>'; ?></td>
													<td><?php echo $item->right_read ? '<i class="text-success fas fa-check"></i>' : '<i class="text-danger fas fa-times"></i>'; ?></td>
													<td><?php echo $item->right_update ? '<i class="text-success fas fa-check"></i>' : '<i class="text-danger fas fa-times"></i>'; ?></td>
													<td><?php echo $item->right_delete ? '<i class="text-success fas fa-check"></i>' : '<i class="text-danger fas fa-times"></i>'; ?></td>
													<td><?php echo $item->page; ?></td>
												</tr>
											<?php endforeach; ?>
										</tbody>
									</table>
								</div>
							<?php endif; ?>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
	<?php endif; ?>