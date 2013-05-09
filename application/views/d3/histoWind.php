<?php
/** histoWind.php
* D3 binder to visualize <dataset> data
*
* @category D3Binder
* @package  Probe
* @author   alban lopez <alban.lopez+probe@gmail.com>
* @license  http://creativecommons.org/licenses/by-nc-sa/3.0/legalcode CC-by-nc-sa-3.0
* @link     http://probe.com/doc
 */

//http://probe.dev/viewer/histoWind/VP2_GTD

?>
<div id="resizable" class="ui-widget-content">
    <h4 class="ui-widget-header">Resizable</h4>
    <div id="SvgZone" style='border:solid red 1px;height:160px;'>
        <!-- d3 content should be -dynamically- placed here -->
    </div>
</div>

<style>
#sensitive {
    cursor: move;
    fill: none;
    pointer-events: all;
}
.line {
	/*fill: none;*/
	stroke-width: 1px;
}
svg {
	font-size: 10px;
}

.axis {
	shape-rendering: crispEdges;
}

.axis path, .axis line {
	stroke: #000;
	fill: none;
	stroke-width: 1px;
}

.x.axis path, .x.axis line {
	stroke: #555;
	/*stroke-opacity: .5;*/
}

.y.axis path, .y.axis line {
	stroke: #555;
	/*stroke-opacity: .5;*/
}
.Legend {
	/*font-family: Arial;*/
	font-size:12px;
	font-weight:bold;
	fill:#999;
	stroke:#000;
	kerning:1.1;
	stroke:#000;
	stroke-width:1px;
	stroke-opacity:.2;
}
  /*.line:hover {
	stroke-width: 1.6px;
	stroke-opacity: .6;
}*/
</style>
<script>
	$(document).ready(function(){
		var station='<?=$station?>';
	    var url = "/data/histoWind?station="+station+"&Granularity=720";

		d3.tsv(url, function(data) {
			var formatDate = d3.time.format("%Y-%m-%d %H:%M");

			d3.select("#SvgZone")
				.datum(data)
				.call(timeSeriesChart()
					.date(function(d) { return formatDate.parse(d.date); })
					.speed(function(d) { return +d.speed; })
					.angle(function(d) { return +d.angle; }));
		});
	});
</script>
<script src="/resources/js/ProbeTools.js"></script>
<script src="/resources/js/libs/base64.js"></script>
<script src="/resources/js/libs/jquery-ui-1.10.2.custom.js"></script>

