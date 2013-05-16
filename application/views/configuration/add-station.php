<?=form_open('configuration/do/add-station', array(
		'id' => 'add-station',
		'class' => 'modal setup form-horizontal  tabbable'
	)
);
?>

	<div class="modal-header">
		<ul class="nav nav-tabs" id="tabs-step">
		<?php 
			$active = 'active';
			$i = 1;
			foreach ($form as $label => $type):
		?>
			<li class="<?=$active; $active=null; ?>">
				<a href="#settings-<?=$label?>" data-toggle="tab">
					<?=$i++.'. '.i18n('configuration-station.tab.'.$label, true)?>
				</a>
			</li>
		<?php endforeach; ?>
		</ul>
	</div>

	<article class="modal-body tab-content">
	<!-- <article class="tab-content"> -->
		<?=validation_errors()?>

		<fieldset id="settings-dbms" class="tab-pane active">
			<p class="alert alert-info">
				<?=i18n('configuration-station.settings.dbms.info')?>
			</p>
			<?php foreach ($form['dbms'] as $input => $type): ?>
				<!-- <?=$input?> <?=$type?> -->
				<div class="control-group">
					<?php if (is_array($type) && ($type['type'] == 'radio' || $type['type'] == 'select')): ?>
						<label class="control-label">
							<?=sprintf('%s <span class="hidden">(%s)</span>%s',
                                i18n('configuration-dbms.engine.label'),
                                i18n('required'),
                                i18n('&nbsp;:')
                            ) ?>
						</label>
						<div class="controls">
						<?php foreach ($type['values'] as $value): ?>
							<label class="control-label inline" for="dbms-<?=$input?>-<?=$value?>">
								<input id="dbms-<?=$input?>-<?=$value?>"
			 						type="radio" 
									name="dbms-<?=$input?>" value="<?=$value?>"
								>
								<?=sprintf('%s <span class="hidden">(%s)</span>', 
									i18n(sprintf('configuration-dbms.%s:%s.label', $input, $value), true),
                                    i18n('required')
                                ) ?>
                            </label>
						<?php endforeach; ?>
					</div>
					<?php else: ?>
						<label class="control-label" for="dbms-<?=$input?>">
							<?=sprintf('%s <span class="hidden">(%s)</span>%s', 
								i18n(sprintf('configuration-dbms.%s.label', $input), true),
								i18n('required'), 
								i18n('&nbsp;:')
                            ) ?>
                        </label>
						<div class="controls">
							<?=var_dump($input, $type);?>
							<input id="dbms-<?=$input?>"
								required
								type="<?=$type?>" 
								name="dbms-<?=$input?>" 
								value="<?=set_value('dbms-'.$input)?>"
								class="input-large" 
								placeholder="<?=i18n(sprintf('configuration-dbms.%s.placeholder', $input), true)?>"
							>
						</div>
					<?php endif; ?>
				</div>
			<?php endforeach; ?>
		</fieldset>

		<fieldset id="settings-network" class="tab-pane">
			<p class="alert alert-info">
				<?=i18n('configuration-station.settings.network.info')?>
			</p>
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
								i18n(sprintf('configuration-station.network-%s.label', $input), true),
								i18n('required'), 
								i18n('&nbsp;:')) 
						?>
						</label>
						<div class="controls">
							<input id="network-<?=$input?>"
								<?php 
									if (strpos($type, 'pattern') === FALSE) { echo sprintf('type="%s"', $type); }
									else { echo $type; }
							 	?>
								required
								name="network-<?=$input?>" 
								value="<?=set_value('network-'.$input)?>"
								class="input-large" 
								placeholder="<?=i18n(sprintf('configuration-station.network-%s.placeholder', $input), true)?>"
							>
						</div>
					<?php endif; ?>
				</div>
			<?php endforeach; ?>
		</fieldset>


	</article>
	<div class="modal-footer">
		<?=form_submit('configure', i18n('configuration-station.add-new.label'), 'class="btn btn-primary pull-right"')?>
	</div>
<?=form_close()?>

<script>
	$('#tabs-step a').click(function (e) {
    e.preventDefault();
    $(this).tab('show');
  })
</script>