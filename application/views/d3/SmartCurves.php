<?php
/**
* D3 binder to visualize <dataset> data
*
* @category D3Binder
* @package  Probe
* @author   Édouard Lopez <dev+probe@edouard-lopez.com>
* @license  http://creativecommons.org/licenses/by-nc-sa/3.0/legalcode CC-by-nc-sa-3.0
* @link     http://probe.com/doc
 */
// data getter
// http://probe.dev/draw?station=VP2_GTD&sensors=TA:Arch:Temp:Out:Average&Since=2012-10-26T00:00:00&StepUnit=WEEK&StepNbr=6


?>
<div id="resizable" class="ui-widget-content">
    <h4 class="ui-widget-header">Resizable</h4>
    <div id="SvgZone" style='border:solid red 1px;height:480px;'>
        <!-- d3 content should be -dynamically- placed here -->
    </div>
</div>

<style>
#Sensitive {
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
	var station='<?=$station?>';
	var sensor='<?=$sensor?>';
</script>
<script src="/resources/js/ProbeTools.js"></script>
<script src="/resources/js/libs/base64.js"></script>
<script src="/resources/js/libs/jquery-ui-1.10.2.custom.js"></script>

