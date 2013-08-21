<?php
/** histoWind.php
* D3 binder to visualize <dataset> data
*
* @category D3Binder
* @package  Probe
* @author   alban lopez <alban.lopez+probe@gmail.com>
* @license  http://creativecommons.org/licenses/by-nc-sa/3.0/legalcode CC-by-nc-sa-3.0
* @link     http://probe-meteo.com/doc
 */


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
    shape-rendering: crispEdges;
}

.axis line,.axis path {
    fill: none;
    stroke: #000;
    stroke-width: 1px;
    shape-rendering: crispEdges;
}
.arrow:hover>.hair {
    stroke: #E6550D;
    stroke-width: 2px;
    marker-end:url(#arrowheadHover);
}

/*Blue:#1F77B4 #3182bd #6baed6*/
/*Red:#E6550D*/
.hair {
    fill: none;
    stroke: #3182bd;
    marker-end:url(#arrowhead);
}
.hair2 {
    fill: none;
    stroke: #3182bd;
    stroke-width: 5px;
    stroke-opacity: 0;
    /*marker-end:url(#arrowhead);*/
}
marker polygon {
    fill:#FFF;
}

/*.marker {
    fill: #FFF;
    stroke: #3182bd;
    stroke-width: .7px;
}*/
.sensitive {
    opacity: 0;
}
</style>
<script>
	function probeViewer(){
        include_histoWind("#svgArea", '<?=$station?>', 1900);
	}
</script>
<script src="/resources/js/ProbeTools.js"></script>
<script src="/resources/js/libs/base64.js"></script>
<!-- <script src="/resources/js/libs/jquery-ui-1.10.2.custom.js"></script> -->

