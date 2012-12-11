<?php
/**
* HTML to load JavaScript librairies
*
* @category Template
* @package  Probe
* @author   Édouard Lopez <dev+probe@edouard-lopez.com>
* @license  http://creativecommons.org/licenses/by-nc-sa/3.0/legalcode CC-by-nc-sa-3.0
* @link     http://probe.com/doc
 */
?>
<script src="//ajax.googleapis.com/ajax/libs/jquery/1.7.2/jquery.min.js"></script>
<script>window.jQuery || document.write('<script src="/resources/js/libs/jquery-1.7.1.min.js"><\/script>')</script>

<script src="/resources/js/libs/jquery-1.7.2.min.js"></script>
<script src="/resources/js/libs/jquery-ui-1.8.20.custom.min.js"></script>
<script src="/resources/js/libs/jquery.bgpos.js"></script>

<script src="/resources/js/libs/bootstrap/bootstrap.js"></script>

<?php if ($viewer === true) : ?>

    <!--script src="/resources/js/libs/d3.v2.min.js"></script-->
    <script src="/resources/js/libs/d3.v3.js"></script>
    <script src="/resources/js/<?=$dataBinder;?>.js"></script>
<?php endif; ?>

<!-- Custom javascript -->
<script src="/resources/js/probe.js"></script>
<script>
    var _gaq=[['_setAccount','UA-XXXXX-X'],['_trackPageview']];
    (function(d,t){var g=d.createElement(t),s=d.getElementsByTagName(t)[0];
    g.src=('https:'==location.protocol?'//ssl':'//www')+'.google-analytics.com/ga.js';
    s.parentNode.insertBefore(g,s)}(document,'script'));
</script>

<script>
 $.getJSON('http://probe.dev/draw?station=VP2_GTD&sensors=TA:Arch:Temp:Out:Average&Since=2012-11-26T00:00:00&StepUnit=WEEK&StepNbr=6',
 	function(data)
    // d3.json('http://probe.dev/draw?station=VP2_GTD&sensors=TA:Arch:Temp:Out:Average&Since=2012-11-26T00:00:00&StepUnit=WEEK&StepNbr=6',
    // function(json)
    {
	// console.log(json);

   // var data = json.entries();	//.forEach(
								//    	function logArrayElements(element, index, array) {
								//     	console.log("[" + index + "] = " + element);
								// 	});//.entries();//valuecase;

console.log(data);

    drawBigWindrose(data, "#windrose", "caption");
    drawBigWindrose(data, "#avg", "caption");

    //need to reformat the data to get smallPlot to work, not sure how yet
    //var rollup = rollupForStep(data, months);
    //var small = svg.append("g")
    //.attr("id", "small");
    //plotSmallRose(small, rollup)

    //Style the plots, this doesn't capture everything from windhistory.com  
    svg.selectAll("text").style( { font: "14px sans-serif", "text-anchor": "middle" });
    svg.selectAll(".arcs").style( {  stroke: "#000", "stroke-width": "0.5px", "fill-opacity": 0.9 });
    svg.selectAll(".caption").style( { font: "18px sans-serif" });
    svg.selectAll(".axes").style( { stroke: "#aaa", "stroke-width": "0.5px", fill: "none" });
    svg.selectAll("text.labels").style( { "letter-spacing": "1px", fill: "#444", "font-size": "12px" });
    svg.selectAll("text.arctext").style( { "font-size": "9px" });

    }
    	);
</script>