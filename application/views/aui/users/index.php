<?php

/**
* Developer: Yurii Sychov
* Site: http://sychov.pp.ua
* Email: yurii@sychov.pp.ua
*/

defined('BASEPATH') OR exit('No direct script access allowed');

?>

<?php if (isset($users)): ?>
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
								<th width="15%">Прізвище</th>
								<th width="15%">Ім`я</th>
								<th width="15%">По батькові</th>
								<th width="10%">Email</th>
								<th width="15%">Логін</th>
								<th width="10%">Позиція</th>
								<th width="15%">Дія</th>
							</tr>
						</thead>
						<tbody>
							<?php foreach ($users as $item): ?>
								<tr class="text-center">
									<td><?php echo $item->id; ?></td>
									<td><?php echo $item->surname; ?></td>
									<td><?php echo $item->name; ?></td>
									<td><?php echo $item->patronymic; ?></td>
									<td><?php echo $item->email; ?></td>
									<td><?php echo $item->login; ?></td>
									<td><?php echo $item->position; ?></td>
									<td>
										<a href="javascript:void(0);" title="Детальніше" data-toggle="modal" data-target="#modalUser" data-id="<?php echo $item->id; ?>"><i class="text-primary fas fa-eye mx-2"></i></a>
										<?php if ($this->session->user->id == 1): ?>
										<a href="/authentication/go_to_user/<?php echo $item->id; ?>" title="До кабінету користувача"><i class="text-warning fas fa-sign-in-alt mx-2"></i></a>
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
</div>
<?php endif; ?>