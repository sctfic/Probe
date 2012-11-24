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
						<?php
						if (!empty($stationsConf)){
						 	foreach ($stationsConf as $_name=>$conf){
						 		?>
								<li><?=$_name?></li>
								<?php
							}
						}
						else {
							?>
							<li><a href="configuration/add-station"><?=i18n('configuration.stations.add-new.station')?></a></li>
							<?php
						}
						?>
					</ol>
				</nav>
			</section>
			<section id="kstations-form" class="span4">
				<?php
				if (!empty($stationsConf)){
					foreach ($stationsConf as $_name => $conf) {
						$confs['confs']=$conf;
						$this->load->view('configuration/stations-form', $confs);
					}
				}
				?>
				<!-- <a href="#" class="btn"><i class="fam-add"></i> Add New Station</a> -->
				<a href="configuration/add-station" class="btn btn-success"><i class="icon-white icon-plus"></i><?=i18n('configuration.stations.add-new.station')?></a>
			</section>
		</article>
	<!-- </div> -->
</div>