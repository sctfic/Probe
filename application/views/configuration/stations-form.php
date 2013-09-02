<article id="station-<?=$confs['_name']?>" class="tab-pane <?=$active?> form-horizontal span10">

	<fieldset>
		<legend>
            <h2><?=$confs['_name']?></h2>
		</legend>
		<?php foreach ($confs as $confName => $value) {
		?>
		<!-- Server host/IP -->
		<div class="control-group">
			<label class="control-label" for="station-<?=$confName?>">
				<?=sprintf('%s <span class="hidden">(%s)</span>%s',
                    i18n(sprintf('configuration-station.%s.label', $confName), true),
                    i18n('required'),
                    i18n('&nbsp;:')
                )
                ?>
			</label>
			<div class="controls">
				<input id="station-<?=$confName?>"
					type="text" required
					name="station-<?=$confName?>" value="<?=$value?>"
					class="input-large" placeholder="<?=i18n(
                        sprintf('configuration-station.%s.placeholder', $confName), true
                    )?>"
				>
			</div>
		</div>
		<?php
		}
		?>
	</fieldset>
</article>