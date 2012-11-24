<?=form_open('install/setupDbms', array(
		'id' => 'dbms',
		'class' => 'modal setup form-horizontal'
	)
);
?>

	<!-- <div class="modal-header"> -->
		<!-- <legend> -->
			<!-- <h3><?=i18n("install.dbms.legend")?></h3> -->
		<!-- </legend>	 -->
	<!-- </div> -->

	<fieldset class="modal-body">
		<?=validation_errors()?>


		<h4><?=i18n('configuration.station.settings.dbms')?></h4>
		<?php foreach ($form['dbms'] as $input => $type): ?>
			<!-- <?=$input?> <?=$type?> -->
			<div class="control-group">
				<?php if (is_array($type) && ($type['type'] == 'radio' || $type['type'] == 'select')): ?>
					<label class="control-label">
						<?=sprintf('%s <span class="hidden">(%s)</span>%s', i18n('install.dbms.engine'), i18n('required'), i18n('&nbsp;:')) ?>
					</label>
					<div class="controls">
					<?php foreach ($type['values'] as $value): ?>
						<label class="control-label inline" for="dbms-<?=$input?>-<?=$value?>">
							<input id="dbms-<?=$input?>-<?=$value?>"
		 						type="radio" 
								name="dbms-<?=$input?>" value="<?=$value?>"
							>
							<?=sprintf('%s <span class="hidden">(%s)</span>', 
								i18n(sprintf('install.dbms.%s-%s', $input, $value)), i18n('required'));
							?>
						</label>
					<?php endforeach; ?>
				</div>
				<?php else: ?>
					<label class="control-label" for="dbms-<?=$input?>">
						<?=sprintf('%s <span class="hidden">(%s)</span>%s', 
							i18n('install.dbms.'.$input), 
							i18n('required'), 
							i18n('&nbsp;:')) 
					?>
					</label>
					<div class="controls">
						<input id="dbms-<?=$input?>"
							type="text" required
							name="dbms-<?=$input?>" value="" 
							class="input-large" 
							placeholder="<?=i18n('install.dbms.'.$input.'.placeholder')?>"
						>
					</div>
				<?php endif; ?>
			</div>
		<?php endforeach; ?>

		<h4><?=i18n('configuration.station.settings.network')?></h4>
		<?php foreach ($form['network'] as $input => $type): ?>
			<!-- <?=$input?> <?=$type?> -->
			<div class="control-group">
				<?php if (is_array($type) && ($type['type'] == 'radio' || $type['type'] == 'select')): ?>
					<div class="controls">
						<?php foreach ($type['values'] as $value): ?>
						<?php endforeach; ?>
					</div>
				<?php else: ?>
					<label class="control-label" for="network-<?=$input?>">
						<?=sprintf('%s <span class="hidden">(%s)</span>%s', 
							i18n(sprintf('configuration.station.network.%s', $input), true), 
							i18n('required'), 
							i18n('&nbsp;:')) 
					?>
					</label>
					<div class="controls">
						<input id="network-<?=$input?>"
							<?php 
								if (strpos($type, 'pattern') === FALSE) { echo 'type="<?=$type?>"'; }
								else { echo $type; }
						 	?>
							required
							name="network-<?=$input?>" value="" 
							class="input-large" 
							placeholder="<?=i18n(sprintf('configuration.station.network.%s.placeholder', $input), true)?>"
						>
					</div>
				<?php endif; ?>
			</div>
		<?php endforeach; ?>


	</fieldset>
	<!-- <div class="modal-footer"> -->
		<!-- <?=form_submit('configure', i18n('configuration.station.add-new'), 'class="btn btn-primary pull-right"')?> -->
	<!-- </div> -->
<?=form_close()?>