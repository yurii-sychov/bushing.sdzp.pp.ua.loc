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

<div class="main-card mb-3 card">
	<div class="card-body">
		<h5 class="card-title">Форма</h5>
		<form method="POST" enctype="multipart/form-data" class="">
			<div class="form-row">
				<div class="col-md-6">
					<div class="position-relative form-group">
						<label for="selectTable" class="ml-1">Таблиця</label>
						<select name="table" id="selectTable" class="form-control">
							<option value="">Виберіть таблицю для імпорту</option>
							<?php foreach ($tables as $table): ?>
								<option value="<?php echo $table; ?>"><?php echo $table; ?></option>
							<?php endforeach; ?>
						</select>
					</div>
				</div>
				<div class="col-md-6">
					<div class="position-relative form-group">
						<label for="selectFile" class="ml-1">Файл</label>
						<input name="file" accept="text/xml" id="selectFile" type="file" class="form-control-file">
						<small class="form-text text-muted">Виберіть для імпорту файл в форматі XML</small>
					</div>
				</div>
			</div>
				<button type="submit" class="mt-2 mx-2 btn btn-outline-primary">Імпортувати дані</button>
		</form>
	</div>
</div>  