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

</style>
<div id="filename" class="canvas" style="clear:both;">
  
    <noscript><?=i18n('warning.javascript.disable');?></noscript>
</div>
<script src="http://d3js.org/d3.v3.js"></script>
<script>
$(document).ready(function(){
    var url = "http://probe.dev/data/curents?station=VP2_GTD";
    // $.getJSON(url, function(json) {
    d3.tsv(url, function(error, tsv) {
        if (error) return console.warn(error);
        else return false;
   });
});
</script>
