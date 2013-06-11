<?php
/** SmartChart.php
* D3 binder to visualize <dataset> data
*
* @category D3Binder
* @package  Probe
* @author   alban lopez <alban.lopez+probe@gmail.com>
* @license  http://creativecommons.org/licenses/by-nc-sa/3.0/legalcode CC-by-nc-sa-3.0
* @link     http://probe.com/doc
 */

//http://probe.dev/viewer/SmartChart/VP2_GTD/TA:Arch:Temp:Out:Average

?>
<div id="resizable" class="ui-widget-content">
    <h4 class="ui-widget-header">Resizable</h4>
    <div id="SvgZone" style='border:solid red 1px;height:480px;'>
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
	fill: none;
	stroke-width: 1px;
}
svg {
	font-size: 10px;
}

.axis {
	shape-rendering: crispEdges;
        shape-rendering: crispEdges;
}

.axis path, .axis line {
	stroke: #000;
	fill: none;
	stroke-width: 1px;
        shape-rendering: crispEdges;
}

.x.axis path, .x.axis line {
	stroke: #555;
	/*stroke-opacity: .5;*/
        shape-rendering: crispEdges;
}

.y.axis path, .y.axis line {
	stroke: #555;
	/*stroke-opacity: .5;*/
        shape-rendering: crispEdges;
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
	function probeViewer(){
		var station='<?=$station?>';
		var sensor='<?=$sensor?>';
	    var url = "/data/curve?station="+station+"&sensor="+sensor+"&Since=2012-01-01&_To=2099-01-01&XdisplaySizePxl="+1600;

		d3.tsv(url, function(data) {
			var formatDate = d3.time.format("%Y-%m-%d %H:%M");

			d3.select("#SvgZone")
				.datum(data)
				.call(timeSeriesChart_smart()
					.x(function(d) { return formatDate.parse(d.date); })
					.y(function(d) { return +d.val; }));
		});
	}
</script>
<script src="/resources/js/ProbeTools.js"></script>
<script src="/resources/js/libs/base64.js"></script>
<script src="/resources/js/libs/jquery-ui-1.10.2.custom.js"></script>

