<article class="span10">

	<fieldset>
		<legend>
			<h2><?=i18n('configuration.stations-list.legend.stem');?></h2>
		</legend>
		<?php foreach ($confs as $confName => $value) {
		?>
		<!-- Server host/IP -->
		<div class="control-group">
			<label class="control-label" for="station-"<?=$confName?>>
				<?=sprintf('%s <span class="hidden">(%s)</span>%s', i18n('configuration.station.'.$confName), i18n('required'), i18n('&nbsp;:')) ?>
			</label>
			<div class="controls">
				<input id="station-host"
					type="text" required
					name="station-host" value="<?=$value?>" 
					class="input-large" placeholder="<?=i18n('configuration.station.host.placeholder')?>"
				>
			</div>
		</div>
		<?php
		}
		?>
	</fieldset>
</article>