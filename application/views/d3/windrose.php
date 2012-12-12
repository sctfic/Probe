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
		<svg xmlns="http://www.w3.org/2000/svg" xlink="http://www.w3.org/1999/xlink" class="tributary_svg">
		</svg>
		<!--a id="maplink">maplink</a>
		<a id="whlink">whlink</a-->
		<a id="wslink">wslink</a>
		<a id="wulink">wulink</a>
		<a id="vmlink">vmlink</a>
		<a id="rflink">rflink</a>
		<!--a id="nmlink">nmlink</a-->
	</div>
    <!-- d3 content should be -dynamically- placed here -->
    <noscript><?=i18n('warning.javascript.disable');?></noscript>
</div>


