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

<script src="/resources/js/libs/jquery-ui-1.9.2.custom.min.js"></script>
<script src="/resources/js/libs/jquery.bgpos.js"></script>

<script src="/resources/js/libs/bootstrap/bootstrap.js"></script>

<?php if ($viewer === true) : ?>
    <script src="/resources/js/libs/d3.v3.js"></script>
    <script src="/resources/js/binders/<?=$dataBinder;?>.js"></script>
<?php endif; ?>

<?php if (file_exists(FCPATH.'resources/js/pages/'.$page.'.js')) : ?>
    <!--Page specific JavaScript-->
    <script src="/resources/js/pages/<?=$page;?>.js"></script>
<?php endif; ?>

<script>
    var _gaq=[['_setAccount','UA-XXXXX-X'],['_trackPageview']];
    (function(d,t){var g=d.createElement(t),s=d.getElementsByTagName(t)[0];
    g.src=('https:'==location.protocol?'//ssl':'//www')+'.google-analytics.com/ga.js';
    s.parentNode.insertBefore(g,s)}(document,'script'));
</script>
