<?php

/**
* Developer: Yurii Sychov
* Site: http://sychov.pp.ua
* Email: yurii@sychov.pp.ua
*/

defined('BASEPATH') OR exit('No direct script access allowed');

?>

<?php if (isset($users_rights)): ?>
<div class="row">
	<div class="col-lg-12">
		<div class="main-card mb-3 card">
			<div class="card-header">
				<div class="card-header-title"><?php echo $title; ?></div>
			</div>
			<div class="card-body">
				<div class="table-responsive">
					<table class="mb-0 table table-striped table-bordered">
						<thead>
							<tr class="text-center">
								<th width="5%">ID</th>
								<th width="45%" class="text-left">Користувач</th>
								<th width="10%">Створювати</th>
								<th width="10%">Читати</th>
								<th width="10%">Змінювати</th>
								<th width="10%">Видаляти</th>
								<th width="10%">Сторінка</th>
							</tr>
						</thead>
						<tbody>
							<?php foreach ($users_rights as $item): ?>
								<tr class="text-center">
									<td><?php echo $item->id; ?></td>
									<td class="text-left"><?php echo $item->surname.' '.$item->name.' '.$item->patronymic; ?></td>
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
			</div>
		</div>
	</div>
</div>
<?php endif; ?>