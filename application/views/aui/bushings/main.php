<?php

/**
* Developer: Yurii Sychov
* Site: http://sychov.pp.ua
* Email: yurii@sychov.pp.ua
*/

defined('BASEPATH') OR exit('No direct script access allowed');

?>

<div class="row">
	<div class="col-md-12">
		<div class="card mb-3">
			<div class="card-header">Новини&nbsp;<span class="ml-auto badge-pill badge badge badge-secondary"><?php echo count($news); ?></span></div>
			<div class="card-body">
				<div style="height: 200px; position: relative; overflow: auto;">
					<div class="scrollbar-container" style="display: none;">
						<table class="table table-striped">
							<thead>
								<tr>
									<th width="15%">Дата</th>
									<th width="15%">Тип</th>
									<th width="70%">Зміст</th>
								</tr>
							</thead>
							<tbody>
								<?php foreach ($news as $item): ?>
									<tr class="<?php echo $item->text_color ? $item->text_color : NULL; ?>">
										<td width="15%"><?php echo $item->created_at_format; ?></td>
										<td width="15%"><?php echo $item->title; ?></td>
										<td width="70%"><?php echo $item->description; ?></td>
									</tr>
								<?php endforeach; ?>
							</tbody>	
						</table>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>

<div class="row">
	<div class="col-md-4">
		<div class="card mb-3 widget-content bg-midnight-bloom">
			<div class="widget-content-wrapper text-white">
				<div class="widget-content-left">
					<div class="widget-heading">Паспорти</div>
					<div class="widget-subheading">Кількість паспортів в реєстрі по підприємству</div>
				</div>
				<div class="widget-content-right">
					<div class="widget-numbers text-white">
						<span id="widget1"><?php echo $count_passports; ?></span>
					</div>
				</div>
			</div>
		</div>
	</div>
	<div class="col-md-4">
		<div class="card mb-3 widget-content bg-arielle-smile">
			<div class="widget-content-wrapper text-white">
				<div class="widget-content-left">
					<div class="widget-heading">Випробування</div>
					<div class="widget-subheading">Кількість випробувань в реєстрі по підприємству</div>
				</div>
				<div class="widget-content-right">
					<div class="widget-numbers text-white">
						<span><?php echo $count_tests; ?></span>
					</div>
				</div>
			</div>
		</div>
	</div>
	<div class="col-md-4">
		<div class="card mb-3 widget-content bg-grow-early">
			<div class="widget-content-wrapper text-white">
				<div class="widget-content-left">
					<div class="widget-heading">Виконавці</div>
					<div class="widget-subheading">Кількість виконавців в реєстрі по підприємству</div>
				</div>
				<div class="widget-content-right">
					<div class="widget-numbers text-white">
						<span><?php echo $count_tests_conducted; ?></span>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>

<div class="row">
	<div class="col-md-6">
		<div class="main-card mb-3 card">
			<div class="card-header">Кількість вводів по рокам</div>
			<div class="card-body">
				<canvas id="countPassportsYear"></canvas>
			</div>
		</div>
	</div>

	<div class="col-md-6">
		<div class="main-card mb-3 card">
			<div class="card-header">Кількість вводів по типам</div>
			<div class="card-body">
				<canvas id="countPassportsTip"></canvas>
			</div>
		</div>
	</div>
</div>

<div class="row">
	<div class="col-md-12">
		<div class="main-card mb-3 card">
			<div class="card-header">Що випробувалось в <?php echo date('Y'); ?> році&nbsp;<span class="ml-auto badge-pill badge badge-secondary"><?php echo count($tests_current_year); ?></span></div>
			<div class="card-body">
				<div style="height: 400px; position: relative; overflow: auto;">
					<div class="scrollbar-container" style="display: none;">
						<table class="table table-striped">
							<thead>
								<tr>
									<th width="20%">Підстанція</th>
									<th width="20%" class="text-center">Диспетчерське найменування</th>
									<th width="10%" class="text-center">Фаза</th>
									<th width="20%" class="text-center">Протокол</th>
									<th width="20%" class="text-center">Дата</th>
									<th width="10%" class="text-center">Дія</th>
								</tr>
							</thead>

							<tbody>
								<?php foreach ($tests_current_year as $item): ?>
									<tr>
										<td width="20%"><?php echo $item->stantion; ?></td>
										<td width="20%" class="text-center"><?php echo $item->disp; ?></td>
										<td width="10%" class="text-center"><?php echo $item->phase; ?></td>
										<td width="20%" class="text-center"><?php echo $item->protokol; ?></td>
										<td width="20%" class="text-center"><?php echo $item->test_date_format; ?></td>
										<td width="10%" class="text-center">
											<?php if ((isset($user_rights) && $user_rights->right_read)): ?>
												<a href="<?php echo base_url().'tests/index/'.$item->passport_id; ?>" title="Випробування"><i class="text-warning fas fa-list mx-2"></i></a>
											<?php else: ?>
												<a href="javascript:void(0);" title="Випробування"><i class="text-secondary fas fa-list mx-2"></i></a>
											<?php endif; ?>

											<?php if ((isset($user_rights) && $user_rights->right_read)): ?>
												<a href="<?php echo base_url().'tests/protokol_test/'.$item->id; ?>" title="Протокол" target="_blank"><i class="text-info fas fa-print mx-2"></i></a>
											<?php else: ?>
												<a href="javascript:void(0);" title="Протокол" target="_blank"><i class="text-secondary fas fa-print mx-2"></i></a>
											<?php endif; ?>

											<?php if ($item->is_update && (isset($user_rights) && $user_rights->right_update)): ?>
												<a href="<?php echo base_url(); ?>main/not_update_test/<?php echo $item->id; ?>" title="Заборонити редагувати" onclick="return confirm('Заборонити редагувати дані?')"><i class="text-success fas fa-lock-open mx-2"></i></a>
											<?php else: ?>
												<a href="javascript:void(0);" title="Заборонено редагувати"><i class="text-secondary fas fa-lock mx-2"></i></a>
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
</div>

<div class="row">
	<div class="col-md-6">
		<div class="main-card mb-3 card">
			<div class="card-header">Хто скільки випробував вводів</div>
			<div class="card-body">
				<div style="height: 300px; position: relative; overflow: auto;">
					<div class="scrollbar-container" style="display: none;">
						<table class="table table-striped">
							<thead>
								<tr>
									<th width="60%">ПІБ</th>
									<th width="40%">Кількість, шт</th>
								</tr>
							</thead>
							<tbody>
								<?php $count = 0;  foreach ($how_many_tests_conducted as $item): ?>
								<tr>
									<td width="60%"><?php echo $item->tests_conducted ? $item->tests_conducted : 'NULL'; ?></td>
									<td width="40%"><?php echo $item->count; ?></td>
								</tr>
								<?php $count = $count + $item->count; endforeach; ?>
							</tbody>
							<tfoot>
								<tr>
									<th width="60%" class="text-primary">Підсумок</th>
									<th width="40%" class="text-left text-primary"><?php echo $count; ?></th>	
								</tr>
							</tfoot>
						</table>
					</div>
				</div>
			</div>
		</div>
	</div>
	<div class="col-md-6">
		<div class="main-card mb-3 card">
			<div class="card-header">Скільки випробувано в <?php echo date('Y'); ?> році по місяцям</div>
			<div class="card-body">
				<div style="height: 300px; position: relative; overflow: auto;">
					<div class="scrollbar-container" style="display: none;">
						<table class="table table-striped">
							<thead>
								<tr>
									<th width="60%">Місяць</th>
									<th width="40%">Кількість, шт</th>
								</tr>
							</thead>
							<tbody>
								<?php $count = 0; foreach ($count_tests_current_year_month as $item): ?>
								<tr>
									<td width="60%"><?php echo $item->test_date_format ? $item->test_date_format : 'NULL'; ?></td>
									<td width="40%"><?php echo $item->count; ?></td>
								</tr>
								<?php $count = $count + $item->count; endforeach; ?>
							</tbody>
							<tfoot>
								<tr>
									<th width="60%" class="text-primary">Підсумок</th>
									<th width="40%" class="text-left text-primary"><?php echo $count; ?></th>
								</tr>
							</tfoot>
						</table>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
