<article class="span10">

	<fieldset>
		<legend>
			<h2><?=i18n('configuration.stations-list.legend.stem');?></h2>
		</legend>

	<!-- Server host/IP -->
	<div class="control-group">
		<label class="control-label" for="station-host">
			<?=sprintf('%s <span class="hidden">(%s)</span>%s', i18n('configuration.station.host'), i18n('required'), i18n('&nbsp;:')) ?>
		</label>
		<div class="controls">
			<input id="station-host"
				type="text" required
				name="station-host" value="<?=$stationHost?>" 
				class="input-large" placeholder="<?=i18n('configuration.station.host.placeholder')?>"
			>
		</div>
	</div>

	<!-- Server port (range between: 1-65535) -->
	<div class="control-group">
		<label class="control-label" for="station-port">
			<?=sprintf('%s <span class="hidden">(%s)</span>%s', i18n('configuration.station.port'), i18n('required'), i18n('&nbsp;:')) ?>
		</label>
		<div class="controls">
			<input id="station-port"
				type="number" min="1" max="65535" 
				name="station-port" value="<?=$stationPort?>" 
				class="input-mini" placeholder="<?=i18n('configuration.station.port.placeholder')?>"
			>
		</div>
	</div>
	</fieldset>
</article>