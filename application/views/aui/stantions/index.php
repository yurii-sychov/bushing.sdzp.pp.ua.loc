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
		<div class="card mb-3">
			<div class="card-header">Підстанції</div>
			<div class="card-body">
				<div class="table-responsive">
				<table class="table table-hover table-bordered">
					<thead>
						<tr class="text-center">
							<th width="5%">№ п/п</th>
							<th width="5%">#</th>
							<th width="40%">Підрозділ</th>
							<th width="40%">Підстанція</th>
						</tr>
					</thead>
					<?php $i = 1; foreach ($stantions as $item): ?>
					<tbody>
						<tr>
							<td class="text-center"><?php echo $i; ?></td>
							<td class="text-center"><?php echo $item->id; ?></td>
							<td><?php echo $item->filial_id; ?></td>
							<td><?php echo $item->name; ?></td>
						</tr>
					</tbody>
					<?php $i++; endforeach; ?>
				</table>
				</div>
			</div>
		</div>
	</div>
</div>