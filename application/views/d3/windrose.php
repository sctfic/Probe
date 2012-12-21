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

<div id="filename" class="canvas">
    <div id="display0" style="width: 800px; height: 80px; "></div>
    <div id="display1" style="width: 260px; height: 260px; "></div>
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

<!--script>
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

    makeWindVis('VP2_GTD', '2012-10-19T00:00:00', 'WEEK', 8);
    var url = "http://probe.dev/draw/smallrose?station=VP2_GTD&sensors=&Since=2012-10-19T00:00:00&StepUnit=DAY&StepNbr=12";

    $.getJSON(url, function(d) {
        console.log(d);
        plotSmallRose(d);
    });
});
</script-->









