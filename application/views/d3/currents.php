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
	.da-center {margin: 0 auto;}?#JQTreeview
	{
	  border: 1px solid #11B700;
	  padding: 5px;
	}

	.expandNode
	{
	  cursor: pointer;
	  width: 16px;
	  height: 16px;
	  background-color: #000;
	  float: left;
	  margin-right: 8px;
	}

	.expand
	{
	  background: url(http://www.switchonthecode.com/sites/default/files/707/images/expandIcon.png) no-repeat;
	}

	.collapse
	{
	  background: url(http://www.switchonthecode.com/sites/default/files/707/images/collapseIcon.png) no-repeat;
	}

	.NodeContents
	{
	  border-left: 6px solid #D2FFCC;
	  margin-left: 4px;
	  display: none;
	  padding-left: 5px;
	}

	span.ItemTitle
	{
	  font-size: 10px;
	  width: 100px;
	  text-decoration: underline;
	}

	div.NodeItem div.ItemTxt
	{
	  font-size: 14px;
	  padding: 2px 5px;
	  margin-bottom: 2px;
	  text-decoration: none;
	}

</style>
<div id="filename" class="canvas" style="clear:both;">
	<div id="Treeview">	</div>
	<noscript><?=i18n('warning.javascript.disable');?></noscript>
</div>
<script>
// http://jquery.bassistance.de/treeview/demo/



$(document).ready(function(){
	var url = "http://probe.dev/data/currents?station=VP2_GTD";
	// $.getJSON(url, function(json) {
	$.getJSON(url, function(data) {
		 
		$.each(data, function(key, val) { str = ''; recursiveFunction(key, val) });
		console.log(str);
		$('#Treeview').append(str);
		$('#Treeview > ul').fadeToggle({ duration: 200 });
		//$('ul li:hidden:first').delay(50).fadeIn(fadeItem);
    });
});
</script>
