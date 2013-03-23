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

<!--script src="/resources/js/libs/jquery-ui-1.9.2.custom.min.js"></script-->
<script src="/resources/js/libs/jquery-ui-1.10.2.custom.js"></script>
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

<script type="text/javascript">

  var _gaq = _gaq || [];
  _gaq.push(['_setAccount', 'UA-39489032-1']);
  _gaq.push(['_setDomainName', 'no-ip.org']);
  _gaq.push(['_trackPageview']);

  (function() {
    var ga = document.createElement('script'); ga.type = 'text/javascript'; ga.async = true;
    ga.src = ('https:' == document.location.protocol ? 'https://ssl' : 'http://www') + '.google-analytics.com/ga.js';
    var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(ga, s);
  })();

</script>
