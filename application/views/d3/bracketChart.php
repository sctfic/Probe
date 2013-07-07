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
    <div id="svgArea" style='border:solid red 1px;height:480px;'>
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
.box:hover>.rect, .box:hover>.line {
  stroke: #E6550D;
  stroke-width: 2px;
        shape-rendering: crispEdges;
}
.box:hover>text{
	display: block;
        shape-rendering: crispEdges;
}


/*Blue:#1F77B4 #3182bd #6baed6*/
/*Red:#E6550D*/
.rect, .line {
  fill: #FFF;
  stroke: #1F77B4;
  stroke-width: 1px;
        /*shape-rendering: crispEdges;*/
}
.box text {
	display:none;
	font-size: 10px;
        /*shape-rendering: crispEdges;*/
}
</style>

<script>
	function probeViewer(){
		var station='<?=$station?>';
		var sensor='<?=$sensor?>';
	    var url = "/data/bracketCurve?station="+station+"&sensor="+sensor+"&XdisplaySizePxl="+1600;

		d3.tsv(url, function(data) {
		  var formatDate = d3.time.format("%Y-%m-%d %H:%M");
		  d3.select("#svgArea")
		      .datum(data)
		    .call(timeSeriesChart_backet()
				.date(function(d) { return formatDate.parse(d.date); })
				.min(function(d) { return +d.min; })
				.first(function(d) { return +d.first; })
				.avg(function(d) { return +d.avg; })
				.last(function(d) { return +d.last; })
				.max(function(d) { return +d.max; })
		    );
		});
	}
</script>
<script src="/resources/js/ProbeTools.js"></script>
<script src="/resources/js/libs/base64.js"></script>
<script src="/resources/js/libs/jquery-ui-1.10.2.custom.js"></script>

