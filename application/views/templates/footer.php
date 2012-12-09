<?php
/**
* Main footer template
*
* @category Template
* @package  Probe
* @author   Édouard Lopez <dev+probe@edouard-lopez.com>
* @license  http://creativecommons.org/licenses/by-nc-sa/3.0/legalcode CC-by-nc-sa-3.0
* @link     http://probe.com/doc
 */
?>
    <footer>
        © <?=date('Y')?> –
        <span
            xmlns:dct="http://purl.org/dc/terms/"
            property="dct:title"
        >Probe</span>
        <?php
            echo sprintf(
                i18n('project.license.by%s,%s,%s'),
                i18n('project.team-name'),
                i18n('project.license.logo-alt'),
                i18n('project.license.logo-title')
            );
        ?>
        .
    </footer>
    <noscript><?=i18n('warning.javascript.disable');?></noscript>
</body>
</html>
