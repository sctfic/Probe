<?php
/**
* D3 binder to visualize <dataset> data
*
* @category D3Binder
* @package  Probe
* @author   Édouard Lopez <dev+probe@edouard-lopez.com>
* @license  http://creativecommons.org/licenses/by-nc-sa/3.0/legalcode CC-by-nc-sa-3.0
* @link	 http://probe.com/doc
 */
// data getter
// http://probe.dev/draw?station=VP2_GTD&sensors=TA:Arch:Temp:Out:Average&Since=2012-10-26T00:00:00&StepUnit=WEEK&StepNbr=6
?>
<style>

</style>
<div id="filename" class="canvas" style="clear:both;">
	<div id="Tree">	</div>
	<noscript><?=i18n('warning.javascript.disable');?></noscript>
</div>

<script type="text/javascript" src="http://static.jstree.com/v.1.0pre/jquery.jstree.js"></script>

<script>
// http://jquery.bassistance.de/treeview/demo/

$(document).ready(function(){
	var url = "http://probe.dev/data/currents?station=VP2_GTD";
	// $.getJSON(url, function(json) {
	$.getJSON(url, function(data) {
		console.log(data);
		
		$.each(data.data, function(key, val) { str = ''; recursiveFunction(key, val, 'Tree') });
		// console.log(str);
		$('#Tree').append('<ul>'+str+'</ul>');

		$("#Tree").jstree({
			"themes" : {
				"theme" : "apple"
				// "dots" : false,
				// "icons" : false
			},
			"types" : {
				"types" : {
					"Sensor" : {
						"icon" : {
							// "image" : "../resources/icons/famfamfam/bricks.png"
							// "image" : "../resources/icons/famfamfam/map_go.png"
							"image" : "../resources/icons/famfamfam/tag_pink.png"
							// "image" : "../resources/icons/famfamfam/bullet_go.png"
							// "image" : "../resources/icons/famfamfam/feed.png"
						}
					}
				}
			},
			"plugins" : [ "html_data", "types", "themes" ]
		});
		console.log('end');

	});
});
</script>
