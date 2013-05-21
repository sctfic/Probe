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
    <div id="svgArea" style='border:solid red 1px;height:160px;'>
        <!-- d3 content should be -dynamically- placed here -->
    </div>
</div>

<style>
svg {
	font-size: 10px;
}
.line {
  fill: none;
  stroke: #000;
  stroke-width: 1px;
}

.axis line,.axis path {
  fill: none;
  stroke: #000;
  stroke-width: 1px;
  shape-rendering: crispEdges;
}
.arrow:hover>.hair, .arrow:hover>.marker {
  stroke: #E6550D;
  stroke-width: 2px;
}
/*Blue:#1F77B4 #3182bd #6baed6*/
/*Red:#E6550D*/
.hair {
  fill: none;
  stroke: #3182bd;
  stroke-width: 1px;
}
.marker {
  fill: #FFF;
  stroke: #3182bd;
  stroke-width: .7px;
}
</style>
<script>
	function probeViewer(){

		var station='<?=$station?>';
	    var url = "/data/histoWind?station="+station+"&XdisplaySizePxl="+1800;

		d3.tsv(url, function(data) {
		  var formatDate = d3.time.format("%Y-%m-%d %H:%M");
		  d3.select("#svgArea")
		      .datum(data)
		    .call(timeSeriesChart()
				.date(function(d) { return formatDate.parse(d.date); })
				.speed(function(d) { return +d.speed; })
				.angle(function(d) { return +d.angle; })
				.xSpeed(function(d) { return +d.x; })
				.ySpeed(function(d) { return +d.y; })
		    );
		});
	}
</script>
<script src="/resources/js/ProbeTools.js"></script>
<script src="/resources/js/libs/base64.js"></script>
<script src="/resources/js/libs/jquery-ui-1.10.2.custom.js"></script>

