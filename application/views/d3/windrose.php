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
	<div id="display" style="width: 930.3px; height: 600px; ">
		<svg id="windroses" xmlns="http://www.w3.org/2000/svg" xlink="http://www.w3.org/1999/xlink" class="tributary_svg">
		</svg>
		<!--a id="maplink">maplink</a>
		<a id="nmlink">nmlink</a>
		<a id="whlink">whlink</a-->
		<a id="wslink">wslink</a>
		<a id="wulink">wulink</a>
		<a id="vmlink">vmlink</a>
		<a id="rflink">rflink</a>

	</div>
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
    makeWindVis('VP2_GTD', '2012-10-19T00:00:00', 'WEEK', 8);


    var recapData = {"null":15,"0.0":2,"22.5":3,"45.0":5,"67.5":12,"90.0":14,"112.5":6,"135.0":7,"157.5":5,"180.0":5,"202.5":4,"225.0":2,"247.5":3,"270.0":4,"292.5":7,"315.0":9,"337.5":3};
    plotSmallRose(recapData);

</script>