<div class="navbar navbar-inverse navbar-fixed-top">
	<ul class="breadcrumb">
	    <li><a href="/configuration/stations-list"><?=i18n("configuration.breadcrumb.stations-list")?></a> <span class="divider">/</span></li>
	</ul>
</div>


<article id="stations-list" class="row">
	<section class="span2">
		<nav>
			<ol>
				<?php foreach ($stationList as $station): ?>
					<li><?=$station['name']?></li>
				<?php endforeach ?>
			</ol>
		</nav>
	</section>

	<section class="span10">
			<!-- <a href="#" class="btn"><i class="fam-add"></i> Add New Station</a> -->
	<a href="#" class="btn btn-success"><i class="icon-white icon-plus"></i><?=i18n('configuration.stations-list.add-new.station')?></a>

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
	</section>
</article>
