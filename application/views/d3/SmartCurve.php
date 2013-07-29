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
<link rel="stylesheet" href="/resources/css/redmond/jquery-ui-1.10.2.custom.css" />
<style>
    body {
        font-family: "Trebuchet MS", "Helvetica", "Arial",  "Verdana", "sans-serif";
        /*font-size: 62.5%;*/
    }
    #resizable { width: 1200px; height: 320px; padding: 0.5em; }
    #resizable h4 { text-align: center; margin: 0; }
    .ui-menu { width: 250px; }
</style>
<!-- <ul id='StationList'>
    <li id='VP2_GTD' class='sensor'><a href="#">VP2_GTD</a>
        <ul id='SensorList'>
        <li id='TA:Arch:Hum:In:Current' class='sensor'><a href="/viewer/SmartCurve/VP2_GTD/TA:Arch:Hum:In:Current">TA:Arch:Hum:In:Current</a></li>
        <li id='TA:Arch:Hum:Out:Current' class='sensor'><a href="/viewer/SmartCurve/VP2_GTD/TA:Arch:Hum:Out:Current">TA:Arch:Hum:Out:Current</a></li>
        <li id='TA:Arch:none:Time:UTC' class='sensor'><a href="#">TA:Arch:none:Time:UTC</a></li>
        <li id='TA:Arch:Temp:Out:Average' class='sensor'><a href="#">TA:Arch:Temp:Out:Average</a></li>
        <li id='TA:Arch:Temp:Out:High' class='sensor'><a href="#">TA:Arch:Temp:Out:High</a></li>
    </ul></li>
    <li id='VP2_GTD2' class='sensor'><a href="#">VP2_GTD2</a>
    <ul id='SensorList2'>
        <li id='TA:Arch:Temp:Out:Low' class='sensor'><a href="#">TA:Arch:Temp:Out:Low</a></li>
        <li id='TA:Arch:Various::ForecastRule' class='sensor'><a href="#">TA:Arch:Various::ForecastRule</a></li>
        <li id='TA:Arch:Various:Bar:Current' class='sensor'><a href="#">TA:Arch:Various:Bar:Current</a></li>
        <li id='TA:Arch:Various:ET:Hour' class='sensor'><a href="#">TA:Arch:Various:ET:Hour</a></li>
        <li id='TA:Arch:Various:RainFall:Sample' class='sensor'><a href="#">TA:Arch:Various:RainFall:Sample</a></li>
        <li id='TA:Arch:Various:RainRate:HighSample' class='sensor'><a href="#">TA:Arch:Various:RainRate:HighSample</a></li>
        <li id='TA:Arch:Various:Solar:HighRadiation' class='sensor'><a href="#">TA:Arch:Various:Solar:HighRadiation</a></li>
    </ul></li>
    <li id='VP2_GTD3' class='sensor'><a href="#">VP2_GTD3</a>
    <ul id='SensorList3'>
        <li id='TA:Arch:Various:Solar:Radiation' class='sensor'><a href="#">TA:Arch:Various:Solar:Radiation</a></li>
        <li id='TA:Arch:Various:UV:HighIndex' class='sensor'><a href="#">TA:Arch:Various:UV:HighIndex</a></li>
        <li id='TA:Arch:Various:UV:IndexAvg' class='sensor'><a href="#">TA:Arch:Various:UV:IndexAvg</a></li>
        <li id='TA:Arch:Various:Wind:DominantDirection' class='sensor'><a href="#">TA:Arch:Various:Wind:DominantDirection</a></li>
        <li id='TA:Arch:Various:Wind:HighSpeed' class='sensor'><a href="#">TA:Arch:Various:Wind:HighSpeed</a></li>
        <li id='TA:Arch:Various:Wind:HighSpeedDirection' class='sensor'><a href="#">TA:Arch:Various:Wind:HighSpeedDirection</a></li>
        <li id='TA:Arch:Various:Wind:SpeedAvg' class='sensor'><a href="#">TA:Arch:Various:Wind:SpeedAvg</a></li>
    </ul></li>
</ul> -->

<script>
    $(function() {
        $( "#resizable" ).resizable({
            stop: function( event, ui ) {
                var parentblock = $('#resizable');
                drawGraph (dataFullView, '#SvgZone', parentblock.width(), parentblock.height() - $('#resizable h4:first-child').height() - 10);
            },
            maxHeight: 640,
            // maxWidth: 1800,
            minHeight: 120,
            minWidth: 480,
            helper: "ui-selectable-helper"
            // animate: true
        });
    });
</script>
<div id="resizable" class="ui-widget-content">
    <h4 class="ui-widget-header">Resizable</h4>
    <div id="SvgZone" >
        <!-- d3 content should be -dynamically- placed here -->
    </div>
</div>


<script src="/resources/js/ProbeTools.js"></script>
<script src="/resources/js/libs/base64.js"></script>
<script src="/resources/js/libs/jquery-1.9.1.js"></script>
<script src="/resources/js/libs/jquery-ui-1.10.2.custom.js"></script>
<script>
var station='<?=$station?>';
var sensor='<?=$sensor?>';
var dataFullView=null;


function probeViewer(){
    var url = "/data/curve?station="+station+"&sensor="+sensor+"&Since=2012-01-01&_To=2099-01-01&_Granularity=120";
    // $.getJSON(url, function(json) {
    d3.tsv(url, function(error, tsv) {
      // console.log(tsv);
        if (error) return console.warn(error);
        else {
            tsv.forEach(function(d) {
                d.date = parse(d.date);
                d.val = +d.val;
            });
            dataFullView = tsv;
            var parentblock = $('#resizable');
            drawGraph (dataFullView, '#SvgZone', parentblock.width(), parentblock.height() - $('#resizable h4:first-child').height() - 10);
        }
   });



}
</script>

<script>
    $(function() {
        $( "#StationList" ).menu();
    });

    $(function() {
        $( ".sensor" ).draggable();
        $( "#SvgZone" ).droppable({
            drop: function( event, ui ) {
                console.log('ok')
            }
        });
    });
  
</script>