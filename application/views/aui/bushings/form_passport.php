<?php

/**
 * Developer: Yurii Sychov
 * Site: http://sychov.pp.ua
 * Email: yurii@sychov.pp.ua
 */

defined('BASEPATH') OR exit('No direct script access allowed');

?>

<?php if (validation_errors()): ?>
	<div class="alert alert-danger fade show" role="alert">
		<?php echo validation_errors(); ?>
	</div>
<?php endif; ?>

<?php if ($page === 'move_passport'): ?>

<div class="main-card mb-3 card">
	<div class="card-header">Форма</div>
	<div class="card-body">
		<form class="" method="POST">
			<div class="form-row">
				<div class="col-md-3">
					<div class="position-relative form-group">
						<label for="selectFilial" class="ml-1"><strong>Підрозділ</strong></label>
						<input type="text" class="form-control mb-2" value="<?php echo htmlspecialchars($passport->filial); ?>" disabled />
						<select name="filial_id" id="selectFilial" class="form-control" onchange="document.location=this.options[this.selectedIndex].value">
							<option value="/passports/move_passport">Виберіть підрозділ</option>
							<?php foreach ($filials as $item):  ?>
							<option value="/passports/move_passport/<?php echo $passport->id;  ?>/<?php echo $item->id;  ?>" <?php if ($this->uri->segment(4) === $item->id): ?>selected<?php endif; ?>>
								<?php echo $item->name;  ?>
							</option>
							<?php endforeach; ?>
						</select>
					</div>
				</div>
				<div class="col-md-3">
					<div class="position-relative form-group">
						<label for="selectStantion" class="ml-1ml-1"><strong>Підстанція</strong></label>
						<input type="text" class="form-control mb-2" value="<?php echo htmlspecialchars($passport->stantion); ?>" disabled />
						<select name="stantion_id" id="selectStantion" class="form-control" onchange="document.location=this.options[this.selectedIndex].value">
							<option value="/passports/move_passport/<?php echo $passport->id;  ?>/<?php echo $this->uri->segment(4); ?>">Виберіть підстанцію</option>
							<?php foreach ($stantions as $item):  ?>
							<option value="/passports/move_passport/<?php echo $passport->id;  ?>/<?php echo $this->uri->segment(4); ?>/<?php echo $item->id;  ?>" <?php if ($this->uri->segment(5) === $item->id): ?>selected<?php endif; ?>>
								<?php echo $item->name;  ?>
							</option>
							<?php endforeach; ?>
						</select>
					</div>
				</div>
				<div class="col-md-3">
					<div class="position-relative form-group">
						<label for="selectDisp" class="ml-1"><strong>Диспетчерське найменування</strong></label>
						<input type="text" class="form-control mb-2" value="<?php echo htmlspecialchars($passport->disp); ?>" disabled />
						<select name="disp_id" id="selectDisp" class="form-control" onchange="document.location=this.options[this.selectedIndex].value">
							<option value="/passports/move_passport/<?php echo $passport->id;  ?>/<?php echo $this->uri->segment(4); ?>/<?php echo $this->uri->segment(5); ?>">Виберіть диспетчерське найменування</option>
							<?php foreach ($disps as $item):  ?>
							<option value="/passports/move_passport/<?php echo $passport->id;  ?>/<?php echo $this->uri->segment(4); ?>/<?php echo $this->uri->segment(5); ?>/<?php echo $item->id;  ?>" <?php if ($this->uri->segment(6) === $item->id): ?>selected<?php endif; ?>>
								<?php echo $item->name;  ?>
							</option>
							<?php endforeach; ?>
						</select>
					</div>
				</div>
				<div class="col-md-3">
					<div class="position-relative form-group">
						<label for="selectPhase" class="ml-1"><strong>Фаза (місце)</strong></label>
						<input type="text" class="form-control mb-2" value="<?php echo htmlspecialchars($passport->phase); ?>" disabled />
						<select name="phase_id" id="selectPhase" class="form-control">
							<option value="">Виберіть фазу (місце)</option>
							<?php foreach ($phases as $item):  ?>
							<option value="<?php echo $item->id;  ?>"><?php echo $item->name;  ?></option>
							<?php endforeach; ?>
						</select>
					</div>
				</div>
			</div>
			<button class="mt-2 mx-2 btn btn-outline-primary">
				Перемістити паспорт
			</button>
			<a href="<?php echo base_url($this->session->userdata('current_passport_page')); ?>" class="mt-2 mx-2 btn btn-outline-warning">Назад до паспортів</a>
			<a href="<?php echo base_url('/passports/move_passport/'.$passport->id); ?>" class="mt-2 mx-2 btn btn-outline-success">Скинути форму</a>
		</form>
	</div>
</div>

<?php else: ?>

<div class="main-card mb-3 card">
	<div class="card-header">Форма</div>
	<div class="card-body">
		<form class="" method="POST">
			<div class="form-row">
				<div class="col-md-3">
					<div class="position-relative form-group">
						<label for="selectFilial" class="ml-1"><strong>Підрозділ</strong></label>
						<!-- <select name="filial_id" id="selectFilial" class="form-control" onchange="changeFilial(event)">
							<option value="">Виберіть підрозділ</option>
							<?php //foreach ($filials as $item):  ?>
							<option value="<?php //echo $item->id; ?>"><?php //echo $item->name; ?></option>
							<?php //endforeach; ?>
						</select> -->
						<select name="filial_id" id="selectFilial" class="form-control" onchange="document.location=this.options[this.selectedIndex].value" <?php echo $page === 'update_passport' ? 'disabled' : ''; ?>>
							<?php if ($page === 'create_passport'): ?>
							<option value="/passports/create_passport">Виберіть підрозділ</option>
							<?php endif; ?>
							<?php foreach ($filials as $item):  ?>
							<option value="/passports/create_passport/<?php echo $item->id;  ?>" <?php if ($this->uri->segment(3) === $item->id): ?>selected<?php endif; ?>>
								<?php echo $item->name;  ?>
							</option>
							<?php endforeach; ?>
						</select>
					</div>
				</div>
				<div class="col-md-3">
					<div class="position-relative form-group">
						<label for="selectStantion" class="ml-1ml-1"><strong>Підстанція</strong></label>
						<!-- <select name="stantion_id" id="selectStantion" class="form-control" onchange="changeStantion(event)" disabled>
							<option value="">Виберіть підстанцію</option>
						</select> -->
						<select name="stantion_id" id="selectStantion" class="form-control" onchange="document.location=this.options[this.selectedIndex].value" <?php echo $page === 'update_passport' ? 'disabled' : ''; ?>>
							<?php if ($page === 'create_passport'): ?>
							<option value="/passports/create_passport/<?php echo $this->uri->segment(3); ?>">Виберіть підстанцію</option>
							<?php endif; ?>
							<?php foreach ($stantions as $item):  ?>
							<option value="/passports/create_passport/<?php echo $this->uri->segment(3); ?>/<?php echo $item->id;  ?>" <?php if ($this->uri->segment(4) === $item->id): ?>selected<?php endif; ?>>
								<?php echo $item->name;  ?>
							</option>
							<?php endforeach; ?>
						</select>
					</div>
				</div>
				<div class="col-md-3">
					<div class="position-relative form-group">
						<label for="selectDisp" class="ml-1"><strong>Диспетчерське найменування</strong></label>
						<!-- <select name="disp_id" id="selectDisp" class="form-control" onchange="changeDisp(event)" disabled>
							<option value="">Виберіть диспетчерське найменування</option>
						</select> -->
						<select name="disp_id" id="selectDisp" class="form-control" onchange="document.location=this.options[this.selectedIndex].value" <?php echo $page === 'update_passport' ? 'disabled' : ''; ?>>
							<?php if ($page === 'create_passport'): ?>
							<option value="/passports/create_passport/<?php echo $this->uri->segment(3); ?>/<?php echo $this->uri->segment(4); ?>">Виберіть диспетчерське найменування</option>
							<?php endif; ?>
							<?php foreach ($disps as $item):  ?>
							<option value="/passports/create_passport/<?php echo $this->uri->segment(3); ?>/<?php echo $this->uri->segment(4); ?>/<?php echo $item->id;  ?>" <?php if ($this->uri->segment(5) === $item->id): ?>selected<?php endif; ?>>
								<?php echo $item->name;  ?>
							</option>
							<?php endforeach; ?>
						</select>
					</div>
				</div>
				<div class="col-md-3">
					<div class="position-relative form-group">
						<label for="selectPhase" class="ml-1"><strong>Фаза (місце)</strong></label>
						<select name="phase_id" id="selectPhase" class="form-control" <?php echo $page === 'update_passport' ? 'disabled' : ''; ?>>
							<?php if ($page === 'create_passport'): ?>
							<option value="">Виберіть фазу (місце)</option>
							<?php endif; ?>
							<?php foreach ($phases as $item):  ?>
							<option value="<?php echo $item->id;  ?>" <?php echo $page === 'update_passport' ? set_select('phase_id', $item->id, $item->id == $passport->phase_id ? TRUE : FALSE) : set_select('phase_id', $item->id); ?>><?php echo $item->name;  ?></option>
							<?php endforeach; ?>
						</select>
					</div>
				</div>
			</div>
			<div class="form-row">
				<div class="col-md-6">
					<div class="position-relative form-group">
						<label for="inputTip" class="">
						<?php echo anchor_popup('/passports/get_value/tip', '<strong>Тип вводу</strong>', ['width' => 800, 'height' => 600, 'scrollbars'  => 'yes', 'status' => 'yes', 'resizable' => 'yes', 'screenx' => 0, 'screeny' => 0, 'window_name' => '_blank']); ?>
						</label>
						<input name="tip" id="inputTip" placeholder="Введіть тип вводу" type="text" class="form-control" value="<?php echo set_value('tip', isset($passport->tip) ? $passport->tip : NULL); ?>">
					</div>
				</div>
				<div class="col-md-6">
					<div class="position-relative form-group">
						<label for="inputYearMade" class=""><strong>Рік випуску вводу</strong></label>
						<input name="year_made" id="inputYearMade" placeholder="Введіть рік випуску" type="date" class="form-control" value="<?php echo set_value('year_made', isset($passport->year_made) ? $passport->year_made : NULL); ?>">
					</div>
				</div>
			</div>
			<div class="form-row">
				<div class="col-md-6">
					<div class="position-relative form-group">
						<label for="selectTypeBushing" class="ml-1"><strong>Признак вводу</strong></label>
						<select name="type_bushing_id" id="selectTypeBushing" class="form-control">
							<option value="">Виберіть признак вводу</option>
							<?php foreach ($types_bushing as $item):  ?>
							<option value="<?php echo $item->id;  ?>" <?php echo $page === 'update_passport' ? set_select('type_bushing_id', $item->id, $item->id == $passport->type_bushing_id ? TRUE : FALSE) : set_select('type_bushing_id', $item->id); ?>><?php echo $item->name;  ?></option>
							<?php endforeach; ?>
						</select>
					</div>
				</div>
				<div class="col-md-6">
					<div class="position-relative form-group">
						<label for="inputWeight" class="">
						<?php echo anchor_popup('/passports/get_value/weight', '<strong>Вага вводу</strong>', ['width' => 800, 'height' => 600, 'scrollbars'  => 'yes', 'status' => 'yes', 'resizable' => 'yes', 'screenx' => 0, 'screeny' => 0, 'window_name' => '_blank']); ?>
						</label>
						<input name="weight" id="inputWeight" placeholder="Введіть вагу" type="text" class="form-control" value="<?php echo set_value('weight', isset($passport->weight) ? $passport->weight : NULL); ?>">
					</div>
				</div>
			</div>
			<div class="form-row">
				<div class="col-md-6">
					<div class="position-relative form-group">
						<label for="inputNumber" class=""><strong>Номер вводу</strong></label>
						<input name="number" id="inputNumber" placeholder="Введіть номер вводу" type="text" class="form-control" value="<?php echo set_value('number', isset($passport->number) ? $passport->number : NULL); ?>">
					</div>
				</div>
				<div class="col-md-6">
					<div class="position-relative form-group">
						<label for="inputNumberScheme" class="">
						<?php echo anchor_popup('/passports/get_value/number_scheme', '<strong>№ креслення вводу</strong>', ['width' => 800, 'height' => 600, 'scrollbars'  => 'yes', 'status' => 'yes', 'resizable' => 'yes', 'screenx' => 0, 'screeny' => 0, 'window_name' => '_blank']); ?>
						</label>
						<input name="number_scheme" id="inputNumberScheme" placeholder="Ведіть № креслення" type="text" class="form-control" value="<?php echo set_value('number_scheme', isset($passport->number_scheme) ? $passport->number_scheme : NULL); ?>">
					</div>
				</div>
			</div>
			<button class="mt-2 mx-2 btn btn-outline-primary">
				<?php if ($page === 'create_passport'): ?>
					Створити паспорт
				<?php else: ?>
					Редагувати паспорт
				<?php endif; ?>
			</button>
			<a href="<?php echo base_url($this->session->userdata('current_passport_page')); ?>" class="mt-2 mx-2 btn btn-outline-warning">Назад до паспортів</a>
			<a href="<?php echo base_url('/passports/create_passport'); ?>" class="mt-2 mx-2 btn btn-outline-success">Скинути форму</a>
		</form>
	</div>
</div>
<?php endif; ?>

<?php if ($page === 'update_passport'): ?>
	<div class="main-card mb-3 card">
		<div class="card-header">Форма для завантаження скана паспорту ввода</div>
		<div class="card-body">
			<form method="POST" action="/passports/upload_scan_passport/<?php echo $passport->id; ?>" enctype="multipart/form-data" id="scanPassport">
				<?php if ($page === 'update_passport'): ?>
					<div class="form-row">
						<div class="col-md-12">
							<div class="position-relative form-group">
								<label for="inputScanPassport" class=""><strong>Скан паспорту вводу</strong></label>
								<div class="input-group">
									<div class="custom-file">
										<input type="hidden" name="id" value="<?php echo $passport->id; ?>" form="scanPassport" />
										<input type="hidden" name="filial_id" value="<?php echo $passport->filial_id; ?>" form="scanPassport" />
										<input type="hidden" name="stantion_id" value="<?php echo $passport->stantion_id; ?>" form="scanPassport" />
										<input type="hidden" name="disp_id" value="<?php echo $passport->disp_id; ?>" form="scanPassport" />
										<input type="file" class="custom-file-input" id="inputScanPassport" name="scan_passport" accept=".pdf" form="scanPassport"
										>
										<label class="custom-file-label" for="inputScanPassport">Оберіть файл типу .pdf</label>
									</div>
								</div>
							</div>
						</div>
					</div>
				<?php endif; ?>
				<button class="mt-2 mx-2 btn btn-outline-secondary" type="submit">Завантажити файл</button>
				<a href="/passoprts/delete_scan_passport/<?php echo $passport->id; ?>" class="mt-2 mx-2 btn btn-outline-danger" type="submit">Видалити файл</a>
			</form>
		</div>
	</div>
<?php endif; ?> 