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

    // makeWindVis('VP2_GTD');
    // drawBigWindrose(data, "#windrose", "Frequency by Direction");
    // drawBigWindrose(data, "#windspeed", "Average Speed by Direction");

    //need to reformat the data to get smallPlot to work, not sure how yet
    // var rollup = rollupForStep(data, months);
    // var small = svg.append("g")
    //     .attr("id", "small");
    // plotSmallRose(small, rollup);
    makeWindVis('VP2_GTD', '2012-10-19T00:00:00', 'WEEK', 8);

</script>