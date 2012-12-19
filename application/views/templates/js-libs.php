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
    var url = "http://probe.dev/draw/wind?station=VP2_GTD";

    $.getJSON(url, function(d) {
        console.log(d);
        for (var keydate in d.data) {
            // console.log(d.data[keydate]);
            // plotSmallRose(d.data[keydate]);
        }

        plotSmallRose(d.data[keydate]);

        makeWindVis(d.data[keydate]); 

        historybar(d.data);

   });
});
</script>