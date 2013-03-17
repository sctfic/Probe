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
    $requested['station'] = rawurldecode($this->input->get('station'));

    $requested['sensor'] = rawurldecode($this->input->get('sensor'));



?>
<style>
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

  .x.axis path {
    stroke: #000;
  }

  .x.axis line { /* defini la grille */
    stroke: #CCC;
    stroke-opacity: .5;
  }

  .y.axis line { /* defini la grille */
    stroke: #BBB;
    stroke-opacity: .5;
  }

  path.line { /* defini la courbe */
    fill: none;
    /*stroke: #00F;*/
    stroke-width: 1px;
  }

  rect.pane {
    cursor: move;
    fill: none;
    pointer-events: all;
  }
</style>
<div id="filename" class="canvas" style="clear:both;">
    <div id="display0" style="clear:both; _width: 1600px;">
        <!-- d3 content should be -dynamically- placed here -->
    </div>
    <noscript><?=i18n('warning.javascript.disable');?></noscript>
</div>
<!-- <script src="http://d3js.org/d3.v3.js"></script> -->
<script>
var staion='<?=$requested['station']?>';
var sensor='<?=$requested['sensor']?>';
/*
    TA:Arch:Hum:In:Current
    TA:Arch:Hum:Out:Current
    TA:Arch:none:Time:UTC
    TA:Arch:Temp:Out:Average
    TA:Arch:Temp:Out:High
    TA:Arch:Temp:Out:Low
    TA:Arch:Various::ForecastRule
    TA:Arch:Various:Bar:Current
    TA:Arch:Various:ET:Hour
    TA:Arch:Various:RainFall:Sample
    TA:Arch:Various:RainRate:HighSample
    TA:Arch:Various:Solar:HighRadiation
    TA:Arch:Various:Solar:Radiation
    TA:Arch:Various:UV:HighIndex
    TA:Arch:Various:UV:IndexAvg
    TA:Arch:Various:Wind:DominantDirection
    TA:Arch:Various:Wind:HighSpeed
    TA:Arch:Various:Wind:HighSpeedDirection
    TA:Arch:Various:Wind:SpeedAvg
*/

$(document).ready(function(){
    var url = "/data/curve?station="+staion+"&sensor="+sensor+"&Since=2013-01-01&_To=2099-01-01&_Granularity=120";
    // $.getJSON(url, function(json) {
    d3.tsv(url, function(error, tsv) {
      // console.log(tsv);
        if (error) return console.warn(error);
        else drawGraph (tsv, '#display0', 1600, 480);

   });
});
</script>
