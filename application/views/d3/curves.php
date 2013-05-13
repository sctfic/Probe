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
?>
<style>

</style>
<div id="filename" class="canvas" style="clear:both;">
    <div id="display0" style="clear:both; _width: 1600px;">
        <!-- d3 content should be -dynamically- placed here -->
    </div>
    <noscript><?=i18n('warning.javascript.disable');?></noscript>
</div>
<script src="http://d3js.org/d3.v3.js"></script>
<script>
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

function probeViewer(){
    (tsv, '#display0', 1600, 480);
}
</script>
