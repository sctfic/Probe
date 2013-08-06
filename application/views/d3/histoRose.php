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
	.calm{
		fill: #fff;
		stroke: #000;
		stroke-width: 0.5px;
	}

	.stepPointBox g {
		/*display: none;*/
		/*fill-opacity: .0;*/
		/*visibility: hidden;*/
	}

	.stepPetalsBox {
		/*display: none;*/
		/*fill-opacity: .0;*/
		/*visibility: hidden;*/
	}
	.sensitive {
		/*display: none;*/
		opacity: 0.1;
		/*visibility: hidden;*/
		}


	.hoverBox .sensitive:hover + .petals {
		visibility: visible;
		opacity: .8;
		zoom: 2;
		transition:visibility 0s linear;
		-webkit-transition:visibility 0s linear;
        /*shape-rendering: crispEdges;*/
		}

	.petals{
		fill: #58e;
		stroke: #000;
		stroke-width: 0.5px;
		visibility: hidden;
		opacity: 0.1;
		transition:visibility 0s linear .7s, opacity .6s linear;
		-webkit-transition:visibility 0s linear .7s, opacity .6s linear;
        /*shape-rendering: crispEdges;*/
	}

	.line {
	  fill: none;
	  stroke: #000;
	  stroke-width: 1px;
        shape-rendering: crispEdges;
	}

	.axis line,.axis path {
	  fill: none;
	  stroke: #AAA;
	  stroke-width: 1px;
	  shape-rendering: crispEdges;
	}

	/*Blue:#1F77B4 #3182bd #6baed6*/
	/*Red:#E6550D*/
	</style>
<script>
	function probeViewer(){
		include_histoRose("#svgArea", '<?=$station?>', 1900);
	}
	</script>
<script src="/resources/js/ProbeTools.js"></script>
<script src="/resources/js/libs/base64.js"></script>
<!-- <script src="/resources/js/libs/jquery-ui-1.10.2.custom.js"></script> -->

