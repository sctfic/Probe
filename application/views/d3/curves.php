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
    <span id="curveSvgArea1">
        <!-- d3 content should be -dynamically- placed here -->
    </span>
    <span id="curveSvgArea2">
        <!-- d3 content should be -dynamically- placed here -->
    </span>
    <span id="curveSvgArea3">
        <!-- d3 content should be -dynamically- placed here -->
    </span>
    <span id="curveSvgArea4">
        <!-- d3 content should be -dynamically- placed here -->
    </span>
    <span id="curveSvgArea5">
        <!-- d3 content should be -dynamically- placed here -->
    </span>
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
    /*stroke: #1F77B4;*/
    stroke-width: 1px;
}
.Dot {
    fill: none;
    /*fill-opacity: .2;*/
    /*stroke: #1F77B4;*/
    stroke-width: 1px;
}
.spotCircle {
    fill: none;
    /*fill-opacity: .2;*/
    /*stroke: #aec7e8;*/
    stroke-opacity: .2;
    stroke-width: 6px;
}
.legend text {
    /*fill: #1F77B4;*/
    /*fill-width: 5px;*/
    text-anchor:end;
    font-weight:bold;
    /*fill-opacity: .2;*/
    stroke: #fff;
    stroke-width: .5px;
    /*stroke-position:2;*/
    stroke-opacity: .8;
}
.sensitive {
    opacity: 0;
}
.line {
    fill: none;
    /*stroke: #1F77B4;*/
    stroke-width: 1px;
    /*clip-path:url(#pathArea);*/
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
        include_curves("#curveSvgArea1", '<?=$station?>', '<?=$sensor?>', 300);
        include_curves("#curveSvgArea2", '<?=$station?>', 'TA:Arch:Temp:In:Average', 600);
        include_curves("#curveSvgArea3", '<?=$station?>', 'TA:Arch:Various:Solar:HighRadiation', 900);
        include_curves("#curveSvgArea4", '<?=$station?>', 'TA:Arch:Various:UV:IndexAvg', 1900);
        include_curves("#curveSvgArea5", '<?=$station?>', 'TA:Arch:Various:Bar:Current', 1900);
    }
</script>
<script src="/resources/js/ProbeTools.js"></script>
<script src="/resources/js/libs/base64.js"></script>

