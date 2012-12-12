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
?>
<div id="filename" class="canvas">
	<div id="graph_1" class="canvas">
	</div>
    <!-- d3 content should be -dynamically- placed here -->
    <noscript>
<?=i18n('warning.javascript.disable');?></noscript>
</div>

<div id="display" style="width: 930.3px; height: 379px; ">
	<svg xmlns="http://www.w3.org/2000/svg" xlink="http://www.w3.org/1999/xlink" class="tributary_svg">
		<g id="windrose" transform="translate(35,100)"></g>
		<g id="avg" transform="translate(464,100)"></g>
	</svg>
</div>