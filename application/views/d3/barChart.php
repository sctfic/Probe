<?php
/** barChart.php
* D3 binder to visualize <dataset> data
*
* @category D3Binder
* @package  Probe
* @author   alban lopez <alban.lopez+probe@gmail.com>
* @license  http://creativecommons.org/licenses/by-nc-sa/3.0/legalcode CC-by-nc-sa-3.0
* @link     http://probe.com/doc
 */

//http://probe.dev/viewer/dotChart/VP2_GTD

?>
<div id="resizable" class="ui-widget-content">
    <h4 class="ui-widget-header">Resizable</h4>
    <div id="barSvgArea" style='border:solid red 1px;height:160px;'>
        <!-- d3 content should be -dynamically- placed here -->
    </div>
</div>

<style>
    svg {
    	font-size: 10px;
        }

    .Barbox {
        /*clip-path:url(#8b65a37af5cb476adf3e0e0e623b1896);*/
    }
    .bar {
        fill: #aec7e8;
        stroke: #1F77B4;
        stroke-width: 1px;
        shape-rendering: crispEdges;
        }

    .bar:hover, .sensitive:hover > .bar {
        stroke: #E6550D;
        stroke-width: 2px;
        shape-rendering: crispEdges;
        }

    .axis line,.axis path {
        fill: none;
        stroke: #2C3539;
        stroke-width: 1px;
        shape-rendering: crispEdges;
    }
    .sensitive {
        opacity: 0;
    }
    </style>

<script>
  function probeViewer(){
    include_barChart("#barSvgArea", '<?=$station?>', '<?=$sensor?>', 1900);
  }
  </script>
<script src="/resources/js/ProbeTools.js"></script>
<script src="/resources/js/libs/base64.js"></script>
<!-- <script src="/resources/js/libs/jquery-ui-1.10.2.custom.js"></script> -->

