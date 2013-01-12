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

<div id="filename" class="canvas" style="clear:both;">
    <div id="display0" style="clear:both; width: 1320px;">
        <!-- d3 content should be -dynamically- placed here -->
    </div>
    <noscript><?=i18n('warning.javascript.disable');?></noscript>
</div>

<script>
/**
    HOUR()          Extract the hour
    DAY()           Synonym for DAYOFMONTH()
    DAYNAME()       Return the name of the weekday
    DAYOFMONTH()    Return the day of the month (0-31)
    DAYOFWEEK()     Return the weekday index of the argument
    DAYOFYEAR()     Return the day of the year (1-366)
    WEEK()          Return the week number
    MONTH()         Return the month from the date passed
    YEAR()          Return the year
*/
$(document).ready(function(){
    var url = "http://probe.dev/draw/curve?station=VP2_GTD&StepUnit=WEEK&StepNbr=2&Since=2012-12-29";
    // $.getJSON(url, function(json) {
    d3.json(url, function(error, json) {
        if (error) return console.warn(error);
        plotCurve(json.data, '#display0',500,120);

   });
});
</script>
