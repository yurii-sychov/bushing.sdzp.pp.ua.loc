<?php

/**
 * Developer: Yurii Sychov
 * Site: http://sychov.pp.ua
 * Email: yurii@sychov.pp.ua
 */

defined('BASEPATH') OR exit('No direct script access allowed');

?>

<?php if ($this->session->status): ?>
<div class="row" id="message">
	<div class="col-lg-12">
		<div class="alert <?php echo $this->session->status === 'success' ? 'alert-info' : 'alert-danger'; ?>">
			<?php echo $this->session->message; ?>
		</div>
	</div>
</div>
<?php endif; ?>

<div class="row">
	<div class="col-lg-12">
		<div class="main-card mb-3 card">
			<div class="card-header">
				<div class="card-header-title text-primary"><?php echo $filial. ' / ' .$stantion. ' / ' .$disp. ' Фаза ' .$phase. ' / ';  ?><span class="text-danger"><?php echo ' (Зав. № '.$number.')'; ?></span></div>
			</div>
			<div class="card-body">
				<?php if (!$tests): ?>
					<div class="row">
						<div class="col-lg-12">
							<div class="alert alert-warning">
								Немає даних про випробування. Необхідно додати дані. <a href="<?php echo $button_create_href; ?>" class="alert-link">Створити дані.<a>
							</div>
						</div>
					</div>
				<?php else: ?>
					<div class="table-responsive">
						<table class="mb-0 table table-striped table-bordered">
							<thead>
								<tr class="text-center">
									<th width="5%">№ п/п</th>
									<th>Дата</th>
									<!-- <th>Підрозділ</th> -->
									<!-- <th>Підстанція</th> -->
									<!-- <th>Дисп. найм.</th> -->
									<!-- <th>Місце випроб.</th> -->
									<th>№ протоколу</th>
									<!-- <th>Керівник</th> -->
									<!-- <th>Tокр., &deg;C</th> -->
									<!-- <th>TС1, &deg;C</th> -->
									<!-- <th>TС2, &deg;C</th> -->
									<th>Tвв, &deg;C</th>
									<th>Вид випроб.</th>
									<th>R1, МОм</th>
									<th>R3, МОм</th>
									<th>Tg&delta;1, %</th>
									<th>Tg&delta;3, %</th>
									<th>C1, ПФ</th>
									<th>C3, ПФ</th>
									<th>&Delta;З, %</th>
									<th>&Delta;П, %</th>
									<th width="15%">Дія</th>
								</tr>
							</thead>
							<tbody>
								<?php foreach ($tests as $item): ?>
									<tr class="text-center">
										<td><?php echo $item->index; ?></td>
										<td><?php echo $item->test_data; ?></td>
										<!-- <td><?php echo $item->name_filial; ?></td> -->
										<!-- <td><?php echo $item->name_stantion; ?></td> -->
										<!-- <td><?php echo $item->name_disp; ?></td> -->
										<!-- <td><?php echo $item->phase; ?></td> -->
										<td><?php echo $item->protokol; ?></td>
										<!-- <td><?php echo $item->tests_conducted; ?></td> -->
										<!-- <td><?php echo $item->t_okr; ?></td> -->
										<!-- <td><?php echo $item->t_vsm1; ?></td> -->
										<!-- <td><?php echo $item->t_vsm2; ?></td> -->
										<td><?php echo $item->t_bushing; ?></td>
										<td><?php echo $item->type_test; ?></td>
										<td><?php echo $item->r1 === NULL ? '-' : $item->r1; ?></td>
										<td><?php echo $item->r3 === NULL ? '-' : $item->r3; ?></td>
										<td><?php echo $item->tg1 === NULL ? '-' : number_format($item->tg1, 3, '.', ''); ?></td>
										<td><?php echo $item->tg3 === NULL ? '-' : number_format($item->tg3, 3, '.', ''); ?></td>
										<td><?php echo $item->capacity1 === NULL ? '-' : number_format($item->capacity1, 2, '.', ''); ?></td>
										<td><?php echo $item->capacity3 === NULL ? '-' : number_format($item->capacity3, 1, '.', ''); ?></td>
										<td <?php echo (isset($item->delta_capacity1_pusk) && $item->delta_capacity1_pusk >= 5) ? 'class="text-danger"' : NULL;  ?>>
											<?php echo isset($item->delta_capacity1_pusk) ? $item->delta_capacity1_pusk : '-'; ?>
										</td>
										<td <?php echo (isset($item->delta_capacity1_expl) && $item->delta_capacity1_expl >= 5) ? 'class="text-danger"' : NULL;  ?>>
											<?php echo isset($item->delta_capacity1_expl) ? $item->delta_capacity1_expl : '-'; ?>										
										</td>
										<td>
											<?php if ($item->created_by == $this->session->user->id && $item->is_update == 1) : ?>
												<a href="/tests/update_test/<?php echo $item->id; ?>" title="Правити"><i class="text-success fas fa-pencil-alt mx-2"></i></a>
											<?php else: ?>
												<a href="javascript:void(0);"><i class="text-secondary fas fa-pencil-alt mx-2"></i></a>
											<?php endif; ?>
											<a href="javascript:void(0);" title="Детальніше" data-toggle="modal" data-target="#modalTest" data-id="<?php echo $item->id; ?>"><i class="text-primary fas fa-eye mx-2"></i></a>
											<?php if ($item->type_test_id != 1) : ?>
												<a href="/tests/protokol_test/<?php echo $item->id; ?>" title="Протокол" target="_blank"><i class="text-info fas fa-print mx-2"></i></a>
											<?php else: ?>
												<a href="javascript:void(0);"><i class="text-secondary fas fa-print mx-2"></i></a>
											<?php endif; ?>
											<?php if ($item->created_by == $this->session->user->id && $item->is_update == 1) : ?>
												<a href="/tests/delete_test/<?php echo $item->id; ?>" title="Видалити" onClick="return confirm('Видалити дані?')"><i class="text-danger fas fa-trash-alt mx-2"></i></a>
											<?php else: ?>
												<a href="javascript:void(0);"><i class="text-secondary fas fa-trash-alt mx-2"></i></a>
											<?php endif; ?>
											<?php if (($this->session->user->id == 1 OR $this->session->user->id == 2) && $item->is_update == 1): ?>
												<a href="/tests/not_update_test/<?php echo $item->id; ?>" title="Заборонити редагувати" onClick="return confirm('Заборонити редагувати дані?')"><i class="text-success fas fa-lock-open mx-2"></i></a>
											<?php else: ?>
												<a href="javascript:void(0);" title="Заборонено редагувати"><i class="text-secondary fas fa-lock mx-2"></i></a>
											<?php endif; ?>
										</td>
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

<div class="row">
	<div class="col-md-6">
		<div class="main-card mb-3 card">
			<div class="card-body">
				<h5 class="card-title">Зміна тангенса ділянки C1</h5>
				<canvas id="tg1"></canvas>
			</div>
		</div>
	</div>
	<div class="col-md-6">
		<div class="main-card mb-3 card">
			<div class="card-body">
				<h5 class="card-title">Зміна ємності ділянки C1</h5>
				<canvas id="capacity1"></canvas>
			</div>
		</div>
	</div>
</div>