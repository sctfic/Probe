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
    <svg id="histobarre" style="height:60px"></svg>
    <div id="Details">
        <div id="windrose"></div>
        <div id="windspeed"></div>
    </div>
    <!--a id="maplink">maplink</a>
    <a id="nmlink">nmlink</a>
    <a id="whlink">whlink</a-->
    <a id="wslink">wslink</a>
    <a id="wulink">wulink</a>
    <a id="vmlink">vmlink</a>
    <a id="rflink">rflink</a>
    <!-- d3 content should be -dynamically- placed here -->
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
function probeViewer(){
    var url = "/data/windRose?station=VP2_GTD&&Since=2013-01-01&XdisplaySizePxl="+1000;

    // $.getJSON(url, function(json) {
    d3.json(url, function(error, json) {
        if (error) return console.warn(error);
        histograph (json.data, '#histobarre');
        // plotProbabilityRose(json.data['2012-01-29'], '#display1',120);
        // plotSpeedRose(json.data['2012-01-29'], '#display2',120);

   });
}
</script>
