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
			foreach ($form as $tabLabel => $type):
		?>
			<li class="<?=$active; $active=null; ?>">
				<a href="#<?=$tabLabel?>" data-toggle="tab">
					<?=$i++.'. '.i18n(sprintf('configuration-station.%s.label', $tabLabel), true)?>
				</a>
			</li>
		<?php endforeach; ?>
		</ul>
	</div>

	<article class="modal-body tab-content">
	<!-- <article class="tab-content"> -->
		<?=validation_errors()?>

		<fieldset id="dbms" class="tab-pane active">
			<p class="alert alert-info">
				<?=i18n('configuration-add-station.main-content:dbms.tip')?>
			</p>
			<?php foreach ($form['dbms'] as $input => $type): ?>
				<!-- <?=$input?> <?=$type?> -->
				<div id="dbms-engine" class="control-group">
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

		<fieldset id="network" class="tab-pane">
			<p class="alert alert-info">
				<?=i18n('configuration-add-station.main-content:network.tip')?>
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
								<?= printf("%s", strpos($type, 'pattern')===false? null: $type); ?>
                                type="text"
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
    <div class="modal-footer form-actions">
        <a href="/configuration/" class="btn pull-left">
            <i class="icon-arrow-left"></i>
            <?=i18n('configuration-station.list.button');?>
        </a>
        <a href="#dbms" class="btn btn-primary pull-right hidden">
            <i class="icon-white icon-arrow-right"></i>
            <?=i18n('configuration-station.configure:dbms.button');?>
        </a>
        <a href="#network" class="btn btn-primary pull-right">
            <?=i18n('configuration-station.configure:network.button');?>
            <i class="icon-white icon-arrow-right"></i>
        </a>
		<?=form_submit('configure', i18n('configuration-station.add-new.label'), 'class="btn btn-primary pull-right hidden"')?>
	</div>
<?=form_close()?>

<script>
	$('#tabs-step a').click(function (e) {
        e.preventDefault();
        $(this).tab('show');
  })
</script>