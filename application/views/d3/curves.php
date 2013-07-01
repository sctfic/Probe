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
    <div id="curveSvgArea" style='border:solid red 1px;height:160px;'>
        <!-- d3 content should be -dynamically- placed here -->
    </div>
</div>

<style>
svg {
    font-size: 10px;
}
#spot {
    
}
.spot {
    fill: none;
    /*fill-opacity: .2;*/
    stroke: #1F77B4;
    stroke-width: 1px;
}
.Dot {
    fill: none;
    /*fill-opacity: .2;*/
    stroke: #1F77B4;
    stroke-width: 1px;
}
.spotCircle {
    fill: none;
    /*fill-opacity: .2;*/
    stroke: #aec7e8;
    stroke-opacity: .2;
    stroke-width: 6px;
}
.legend {
    fill: #000;
    text-anchor:end;
    /*fill-opacity: .2;*/
    stroke: #1F77B4;
    stroke-width: 2px; 
    stroke-opacity: .3;
}
.sensitive {
    opacity: 0;
}
.line {
    fill: none;
    stroke: #1F77B4;
    stroke-width: 1px;
}

.axis line,.axis path {
    fill: none;
    stroke: #000;
    stroke-width: 1px;
    shape-rendering: crispEdges;
}

</style>
<script>
    function probeViewer(){
        include_curves("#curveSvgArea", '<?=$station?>', '<?=$sensor?>', 1900);
    }
</script>
<script src="/resources/js/ProbeTools.js"></script>
<script src="/resources/js/libs/base64.js"></script>

