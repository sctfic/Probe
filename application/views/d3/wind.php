<?php
/** Wind.php
* D3 binder to visualize <dataset> data
*
* @category D3Binder
* @package  Probe
* @author   alban lopez <alban.lopez+probe@gmail.com>
* @license  http://creativecommons.org/licenses/by-nc-sa/3.0/legalcode CC-by-nc-sa-3.0
* @link     http://probe.com/doc
 */

//http://probe.dev/dashboard/wind/VP2_GTD

?>
<style>
/* Bootstrap style */
.row-fluid > .sidebar-nav {
    position: relative;
    top: 0;
    left:auto;
    width: 220px;
    padding: 9px 0;
}

.left {
    float:left;
}

.right {
    float:right;
}

/*.fixed-fluid {
    margin-left: 240px;
}
.fluid-fixed {
    margin-right: 240px;
    margin-left:auto !important;
}*/
.fixed-fixed {
    margin-left: 240px;
}
</style>
<div class="container-fluid">
    <div class="row-fluid">

        <div class="well sidebar-nav left">
            <ul class="nav nav-list">
                  <li class="nav-header"><?=$station?></li>
                  <li class="active"><a href="#">Wind DashBoard</a></li>
                  <li><a href="#">Rose</a></li>
                  <li><a href="#">Vector</a></li>
                  <li><a href="#">Curve Speed</a></li>
                  <li><a href="#">Curve Direction</a></li>
                  <li class="nav-header">Rain Dashboard</li>
                  <li><a href="#">Link</a></li>
                  <li><a href="#">Link</a></li>
            </ul>
        </div>
      <!--   <div class="well sidebar-nav right">
            <ul class="nav nav-list">
                  <li class="nav-header">Station List</li>
                  <li class="active"><a href="#"><?=$station?></a></li>
                  <li><a href="#">Link</a></li>
                  <li><a href="#">Link</a></li>
                  <li><a href="#">Link</a></li>
            </ul>
        </div -->
        <div id="middleChartsArea" class="content fixed-fixed">
            <div id="HistoricalRose">    </div>
            <div id="detailWindRose"style="text-align: center; mavrgin:0 auto;">
                <p>Detail :</p>
                <div>
                    <span id="detailWindRoseSpeed">    </span>
                    <span id="detailWindRoseRatio" class="right">    </span>
                </div>
            </div>
            <div id="HistoricalVector">    </div>
            <div id="HistoricalSpeed">    </div>
            <div id="HistoricalDirection">    </div>
        </div>

    </div>
</div>
<style>
    /* D3 style */
    svg {
        font-size: 10px;
    }
    #spot {
        
    }
    .spot {
        fill: none;
        stroke-width: 1px;
    }
    .Dot {
        fill: none;
        stroke-width: 1px;
    }
    .spotCircle {
        fill: none;
        stroke-opacity: .3;
        stroke-width: 6px;
    }
    .legend text {
        /*fill: #1F77B4;*/
        /*fill-width: 5px;*/
        /*font-weight:bold;*/
        /*fill-opacity: .2;*/
        /*stroke: #fff;*/
        /*stroke-width: .5px;*/
        /*stroke-position:2;*/
        /*stroke-opacity: .8;*/
    }
    .legend .val, .legend .date {
        text-anchor:end;
    }
    .sensitive {
        opacity: 0;
    }
/*    .line {
        fill: none;
        stroke-width: 1px;
    }

    .axis line,.axis path {
        fill: none;
        stroke: #000;
        stroke-width: 1px;
        shape-rendering: crispEdges;
    }*/



/*    .line {
        fill: none;
        stroke: #000;
        stroke-width: 1px;
        shape-rendering: crispEdges;
    }*/

/*    .axis line,.axis path {
        fill: none;
        stroke: #000;
        stroke-width: 1px;
        shape-rendering: crispEdges;
    }*/
    .arrow:hover>.hair, .arrow:hover>.marker {
        stroke: #E6550D;
        stroke-width: 2px;
    }
    /*Blue:#1F77B4 #3182bd #6baed6*/
    /*Red:#E6550D*/
    .hair {
        fill: none;
        stroke: #3182bd;
        stroke-width: 1px;
        /*shape-rendering: crispEdges;*/
    }
    .marker {
        fill: #FFF;
        stroke: #3182bd;
        stroke-width: .7px;
        /*shape-rendering: crispEdges;*/
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
        opacity: 0;
        /*visibility: hidden;*/
        }


    .stepPetalsBox .sensitive:hover + .petals {
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
        /*stroke: #000;*/
        stroke-width: 1px;
        /*shape-rendering: crispEdges;*/
    }

    .axis line,.axis path {
      fill: none;
      stroke: #AAA;
      stroke-width: 1px;
      shape-rendering: crispEdges;
    }

</style>
<script type="text/javascript">
    var station = '<?=$station?>';
</script>
    <script src="/resources/js/libs/d3.v3.js"></script>
<script src="/resources/js/ProbeTools.js"></script>
<script src="/resources/js/libs/base64.js"></script>
<script src="/resources/js/binders/histoWind.js"></script>
<script src="/resources/js/binders/histoRose.js"></script>
<script src="/resources/js/binders/curves.js"></script>
<script src="/resources/js/binders/windrose.js"></script>
