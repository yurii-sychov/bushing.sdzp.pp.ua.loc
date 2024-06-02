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
			<div class="card-body">
				<div class="form-row">
					<div class="col-lg-4">
						<div class="position-relative form-group">
							<label for="selectFilial" class="ml-1"><strong>Підрозділ</strong></label>
							<select id="selectFilial" class="form-control" onchange="document.location=this.options[this.selectedIndex].value">
								<option value="/passports/index">Виберіть підрозділ</option>
								<?php foreach ($filials as $item):  ?>
								<option value="/passports/index/<?php echo $item->id;  ?>" <?php if ($this->uri->segment(3) === $item->id): ?>selected<?php endif; ?>>
									<?php echo $item->name;  ?>
								</option>
								<?php endforeach; ?>
							</select>
						</div>
					</div>
					<div class="col-lg-4">
						<div class="position-relative form-group">
							<label for="selectStantion" class="ml-1ml-1"><strong>Підстанція</strong></label>
							<select id="selectStantion" class="form-control" onchange="document.location=this.options[this.selectedIndex].value">
								<option value="/passports/index/<?php echo $this->uri->segment(3); ?>">Виберіть підстанцію</option>
								<?php foreach ($stantions as $item):  ?>
								<option value="/passports/index/<?php echo $this->uri->segment(3); ?>/<?php echo $item->id;  ?>" <?php if ($this->uri->segment(4) === $item->id): ?>selected<?php endif; ?>>
									<?php echo $item->name;  ?>
								</option>
								<?php endforeach; ?>
							</select>
						</div>
					</div>
					<div class="col-lg-4">
						<div class="position-relative form-group">
							<label for="selectDisp" class="ml-1"><strong>Диспетчерське найменування</strong></label>
							<select id="selectDisp" class="form-control" onchange="document.location=this.options[this.selectedIndex].value">
								<option value="/passports/index/<?php echo $this->uri->segment(3); ?>/<?php echo $this->uri->segment(4); ?>">Виберіть диспетчерське найменування</option>
								<?php foreach ($disps as $item):  ?>
								<option value="/passports/index/<?php echo $this->uri->segment(3); ?>/<?php echo $this->uri->segment(4); ?>/<?php echo $item->id;  ?>" <?php if ($this->uri->segment(5) === $item->id): ?>selected<?php endif; ?>>
									<?php echo $item->name;  ?>
								</option>
								<?php endforeach; ?>
							</select>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>

<?php if (isset($passports)): ?>
<div class="row">
	<div class="col-lg-12">
		<div class="main-card mb-3 card">
			<div class="card-header">
				<div class="card-header-title text-primary"><?php echo $filial. ' ' .$stantion. ' ' .$disp;  ?></div>
			</div>
			<div class="card-body">
				<div class="table-responsive">
					<table class="mb-0 table table-striped table-bordered">
						<thead>
							<tr class="text-center">
								<th width="5%">Фаза</th>
								<th width="10%">Ознака</th>
								<th width="20%">Тип вводу</th>
								<th width="15%">Рік випуску</th>
								<th width="10%">Зав. номер</th>
								<th width="15%">№ креслення</th>
								<th width="10%">Вага, кг</th>
								<th width="15%">Дія</th>
							</tr>
						</thead>
						<tbody>
							<?php if ($passports): ?>
							<?php foreach ($passports as $item): ?>
								<tr class="text-center<?php //echo ($item->phase_id == 1) ? " text-warning" : NULL ?><?php //echo ($item->phase_id == 2) ? " text-success" : NULL ?><?php //echo ($item->phase_id == 3) ? " text-danger" : NULL ?>">
									<td><?php echo $item->phase; ?></td>
									<td><?php echo $item->type_bushing; ?></td>
									<td><?php echo $item->tip; ?></td>
									<td><?php echo $item->year_made; ?></td>
									<td><?php echo $item->number; ?></td>
									<td>
										<?php if (file_exists('./uploads/images/scheme/'.$item->number_scheme.'.pdf')): ?>
										<a href="/uploads/images/scheme/<?php echo $item->number_scheme; ?>.pdf" target="_blank">
											<?php echo $item->number_scheme; ?>
										</a>
										<?php else: ?>
											<?php echo $item->number_scheme; ?>
										<?php endif; ?>
									</td>
									<td><?php echo $item->weight; ?></td>
									<td>
										<?php if (file_exists('./uploads/passports/'.$item->scan_passport) AND $item->scan_passport): ?>
											<a href="/uploads/passports/<?php echo $item->scan_passport; ?>" title="Паспорт" target="_blank"><i class="text-danger fas fa-file-pdf mx-2"></i></a>
											<?php else: ?>
												<a href="javascript:void(0);" title="Паспорт"><i class="text-secondary fas fa-file-pdf mx-2"></i></a>
											<?php endif; ?>
										
										<a href="/passports/update_passport/<?php echo $item->id; ?>" title="Правити"><i class="text-success fas fa-pencil-alt mx-2"></i></a>
										<a href="/tests/index/<?php echo $item->id; ?>" title="Випробування"><i class="text-warning fas fa-list mx-2"></i></a>
										<a href="/passports/move_passport/<?php echo $item->id; ?>" title="Перемістити"><i class="text-info fas fa-car-side mx-2"></i></a>
										<a href="/passports/delete_passport/<?php echo $item->id; ?>" title="Видалити"><i class="text-danger fas fa-trash-alt mx-2"></i></a>
									</td>
								</tr>
							<?php endforeach; ?>
							<?php else: ?>
								<tr class="text-center">
									<td colspan="8">Для даного вибору данних немає.</td>
								</tr>
							<?php endif; ?>
						</tbody>
					</table>
				</div>
			</div>
		</div>
	</div>
</div>
<?php endif; ?>
