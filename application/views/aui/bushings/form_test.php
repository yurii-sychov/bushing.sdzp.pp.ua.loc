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

<div class="row">
	<div class="col-lg-12">
		<div class="main-card mb-3 card">
			<div class="card-header">Місце випробувань</div>
			<div class="card-body">
				<div class="row">
					<div class="col-md-3">
						<label><strong>Підрозділ</strong></label>
						<select class="mb-2 form-control" disabled="disabled">
							<option><?php echo $passport->filial; ?></option>
						</select>
					</div>
					<div class="col-md-3">
						<label><strong>Підстанція</strong></label>
						<select class="mb-2 form-control" disabled="disabled">
							<option><?php echo $passport->stantion; ?></option>
						</select>
					</div>
					<div class="col-md-3">
						<label><strong>Диспетчерське найменування</strong></label>
						<select class="mb-2 form-control" disabled="disabled">
							<option><?php echo $passport->disp; ?></option>
						</select>
					</div>
					<div class="col-md-3">
						<label><strong>Фаза (місце)</strong></label>
						<select class="mb-2 form-control" disabled="disabled">
							<option><?php echo $passport->phase; ?></option>
						</select>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>

<div class="row">
	<div class="col-lg-12">
		<div class="main-card mb-3 card">
			<div class="card-header">Форма</div>
			<div class="card-body">
				<form method="POST" class="needs-validatio" novalidate>
					<input type="hidden" name="filial_id" value="<?php echo $passport->filial_id; ?>" />
					<input type="hidden" name="stantion_id" value="<?php echo $passport->stantion_id; ?>" />
					<input type="hidden" name="disp_id" value="<?php echo $passport->disp_id; ?>" />
					<input type="hidden" name="phase_id" value="<?php echo $passport->phase_id; ?>" />
					<input type="hidden" name="passport_id" value="<?php echo $passport->id; ?>" />
					<div class="form-row">
						<div class="col-md-3">
							<div class="position-relative form-group">
								<label for="selectTypeTest" class=""><strong>Тип випробування</strong></label>
								<select class="mb-2 form-control" id="selectTypeTest" name="type_test" required>
									<option value="">Виберіть тип випробування</option>
									<?php foreach ($types_tests as $item): ?>
										<option value="<?php echo $item->id; ?>" <?php echo $page === 'update_test' ? set_select('type_test', $item->id, $item->id == $test->type_test_id ? TRUE : FALSE) : set_select('type_test', $item->id); ?>><?php echo $item->name; ?></option>
									<?php endforeach; ?>
								</select>
							</div>
						</div>
						<div class="col-md-3">
							<div class="position-relative form-group">
								<label for="inputTestDate" class=""><strong>Дата випробувань</strong></label>
								<input name="test_date" id="inputTestDate" placeholder="Введіть дату випробувань" type="date" class="form-control" value="<?php echo set_value('test_date', isset($test->test_date) ? $test->test_date : NULL); ?>" required>
							</div>
						</div>
						<div class="col-md-3">
							<div class="position-relative form-group">
								<label for="inputProtokol" class=""><strong>Протокол</strong></label>
								<input name="protokol" id="inputProtokol" placeholder="Введіть номер протоколу" type="text" class="form-control" value="<?php echo set_value('protokol', isset($test->protokol) ? $test->protokol : $future_protokol); ?>" required>
							</div>
						</div>
						<div class="col-md-3">
							<div class="position-relative form-group">
								<label for="inputWeather" class="">
								<?php echo anchor_popup('/tests/get_value/weather', '<strong>Погода</strong>', ['width' => 800, 'height' => 600, 'scrollbars'  => 'yes', 'status' => 'yes', 'resizable' => 'yes', 'screenx' => 0, 'screeny' => 0, 'window_name' => '_blank']); ?>
							</label>
								<input name="weather" id="inputWeather" placeholder="Введіть погоду" type="text" class="form-control" value="<?php echo set_value('weather', isset($test->weather) ? $test->weather : NULL); ?>">
							</div>
						</div>
					</div>

					<div class="form-row">
						<div class="col-md-3">
							<div class="position-relative form-group">
								<label for="inputTempOkr" class=""><strong>Токр. &deg;C</strong></label>
								<input name="t_okr" id="inputTempOkr" placeholder="Введіть температуру повітря" type="number" min="-30" max="100" class="form-control" value="<?php echo set_value('t_okr', isset($test->t_okr) ? $test->t_okr : NULL); ?>">
							</div>
						</div>
						<div class="col-md-3">
							<div class="position-relative form-group">
								<label for="inputTempVSM1" class=""><strong>ТС1. &deg;C</strong></label>
								<input name="t_vsm1" id="inputTempVSM1" placeholder="Введіть температуру масла" type="number" min="-30" max="100" class="form-control" value="<?php echo set_value('t_vsm1', isset($test->t_vsm1) ? $test->t_vsm1 : NULL); ?>">
							</div>
						</div>
						<div class="col-md-3">
							<div class="position-relative form-group">
								<label for="inputTempVSM2" class=""><strong>ТС2. &deg;C</strong></label>
								<input name="t_vsm2" id="inputTempVSM2" placeholder="Введіть температуру масла" type="number" min="-30" max="100" class="form-control" value="<?php echo set_value('t_vsm2', isset($test->t_vsm2) ? $test->t_vsm2 : NULL); ?>">
							</div>
						</div>
						<div class="col-md-3">
							<div class="position-relative form-group">
								<label for="inputTempBushing" class=""><strong>Твводу. &deg;C</strong></label>
								<input name="t_bushing" id="inputTempBushing" placeholder="Введіть температуру вводу" type="number" min="-30" max="100" class="form-control" value="<?php echo set_value('t_bushing', isset($test->t_bushing) ? $test->t_bushing : NULL); ?>" required>
							</div>
						</div>
					</div>

					<div class="form-row">
						<div class="col-md-12">
							<div class="position-relative form-group">
								<label for="inputMore" class="">
								<?php echo anchor_popup('/tests/get_value/more', '<strong>Додаткова інформація про вимірювання</strong>', ['width' => 800, 'height' => 600, 'scrollbars'  => 'yes', 'status' => 'yes', 'resizable' => 'yes', 'screenx' => 0, 'screeny' => 0, 'window_name' => '_blank']); ?>
							</label>
								<input name="more" id="inputMore" placeholder="Введіть додаткову інформацію про вимірювання" type="text" class="form-control" value="<?php echo set_value('more', isset($test->more) ? $test->more : NULL); ?>">
							</div>
						</div>
					</div>

					<div class="form-row">
						<div class="col-md-2">
							<div class="position-relative form-group">
								<label for="inputR1" class=""><strong>R1, МОм</strong></label>
								<input name="r1" id="inputR1" placeholder="Введіть R1" type="number" min="1" max="2500000" maxlength="11" class="form-control" value="<?php echo set_value('r1', isset($test->r1) ? $test->r1 : NULL); ?>">
							</div>
						</div>
						<div class="col-md-2">
							<div class="position-relative form-group">
								<label for="inputR3" class=""><strong>R3, МОм</strong></label>
								<input name="r3" id="inputR3" placeholder="Введіть R3" type="number" min="1" max="2500000" maxlength="11" class="form-control" value="<?php echo set_value('r3', isset($test->r3) ? $test->r3 : NULL); ?>">
							</div>
						</div>
						<div class="col-md-2">
							<div class="position-relative form-group">
								<label for="inputTg1" class=""><strong>Tg&delta;1, %</strong></label>
								<input name="tg1" id="inputTg1" placeholder="Введіть Tg&delta;1" type="text" maxlength="7" class="form-control" value="<?php echo set_value('tg1', isset($test->tg1) ? $test->tg1 : NULL); ?>" required>
							</div>
						</div>
						<div class="col-md-2">
							<div class="position-relative form-group">
								<label for="inputTg3" class=""><strong>Tg&delta;3, %</strong></label>
								<input name="tg3" id="inputTg3" placeholder="Введіть Tg&delta;3" type="text" maxlength="7" class="form-control" value="<?php echo set_value('tg3', isset($test->tg3) ? $test->tg3 : NULL); ?>">
							</div>
						</div>
						<div class="col-md-2">
							<div class="position-relative form-group">
								<label for="inputCapacity1" class=""><strong>C1, пФ</strong></label>
								<input name="capacity1" id="inputCapacity1" placeholder="Введіть C1" type="text" maxlength="8" class="form-control" value="<?php echo set_value('capacity1', isset($test->capacity1) ? $test->capacity1 : NULL); ?>" required>
							</div>
						</div>
						<div class="col-md-2">
							<div class="position-relative form-group">
								<label for="inputCapacity3" class=""><strong>C3, пФ</strong></label>
								<input name="capacity3" id="inputCapacity3" placeholder="Введіть C3" type="text" maxlength="8" class="form-control" value="<?php echo set_value('capacity3', isset($test->capacity3) ? $test->capacity3 : NULL); ?>">
							</div>
						</div>
					</div>

					<div class="form-row">
						<div class="col-md-12">
							<div class="position-relative form-group">
								<label for="inputDevice" class="">
									<?php echo anchor_popup('/tests/get_value/device', '<strong>Прилади для вимірювань</strong>', ['width' => 800, 'height' => 600, 'scrollbars'  => 'yes', 'status' => 'yes', 'resizable' => 'yes', 'screenx' => 0, 'screeny' => 0, 'window_name' => '_blank']); ?>
								</label>
								<input name="device" id="inputDevice" placeholder="Введіть прилади для вимірювань" type="text" class="form-control" value="<?php echo set_value('device', isset($test->device) ? $test->device : NULL); ?>">
							</div>
						</div>
						<div class="col-md-12">
							<div class="position-relative form-group">
								<label for="inputTestsConducted" class="">
								<?php echo anchor_popup('/tests/get_value/tests_conducted', '<strong>Керівник робіт</strong>', ['width' => 800, 'height' => 600, 'scrollbars'  => 'yes', 'status' => 'yes', 'resizable' => 'yes', 'screenx' => 0, 'screeny' => 0, 'window_name' => '_blank']); ?>
								</label>
								<input name="tests_conducted" id="inputTestsConducted" placeholder="Введіть керівника робіт" type="text" class="form-control" value="<?php echo set_value('tests_conducted', isset($test->tests_conducted) ? $test->tests_conducted : NULL); ?>">
							</div>
						</div>
					</div>

					<div class="form-row">
						<div class="col-md-12">
							<div class="position-relative form-group">
								<label for="inputConclusion" class="">
									<?php echo anchor_popup('/tests/get_value/conclusion', '<strong>Висновок</strong>', ['width' => 800, 'height' => 600, 'scrollbars'  => 'yes', 'status' => 'yes', 'resizable' => 'yes', 'screenx' => 0, 'screeny' => 0, 'window_name' => '_blank']); ?>
								</label>
								<input name="conclusion" id="inputConclusion" placeholder="Введіть висновок" type="text" class="form-control" value="<?php echo set_value('conclusion', isset($test->conclusion) ? $test->conclusion : NULL); ?>" required>
							</div>
						</div>
					</div>

					<button class="mt-2 mx-2 btn btn-outline-primary">
						<?php if ($page === 'create_test'): ?>
							Створити випробування
						<?php else: ?>
							Редагувати випробування
						<?php endif; ?>
					</button>
					<a href="/tests/index<?php echo isset($passport) ? '/'.$passport->id : NULL ?>" class="mt-2 mx-2 btn btn-outline-warning">Назад до випробувань</a>
				</form>
			</div>
		</div>
	</div>
</div>

<script>

</script>
