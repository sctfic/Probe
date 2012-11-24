<div class="navbar navbar-inverse navbar-fixed-top">
	<ul class="breadcrumb">
	    <li><a href="/configuration/stations-list"><?=i18n("configuration.stations.breadcrumb")?></a> <span class="divider">/</span></li>
	</ul>
</div>


<div class="container">
	<!-- <div class="row"> -->
		<article class="row-fluid">
			<section id="stations-list" class="span3">
				<nav>
					<ol>
						<?php if (!empty($stationsList)): ?>
							<?php foreach ($stationsList as $station): ?>
								<li><?=$station['name']?></li>
							<?php endforeach ?>					
						<?php else: ?>
							<li><a href="/configuration/add-station"><?=i18n('configuration.stations.add-new.station')?></a></li>
						<?php endif;?>
					</ol>
				</nav>
			</section>
			<section id="stations-form" class="span4">
				<?php if (!empty($stationsList)): ?>
					<?php foreach ($stationsConfig as $config => $value) {
						$data = array(
			               'title' => 'My Title',
			               'heading' => 'My Heading',
			               'message' => 'My Message'
			          );

						$this->load->view('configuration/stations-form', $data);
					}
				?>
				<?php endif;?>
				<!-- <a href="#" class="btn"><i class="fam-add"></i> Add New Station</a> -->
				<a href="/configuration/add-station" class="btn btn-success">
					<i class="icon-white icon-plus"></i>
					<?=i18n('configuration.station.add-new')?>
				</a>
			</section>
		</article>
	<!-- </div> -->
</div>