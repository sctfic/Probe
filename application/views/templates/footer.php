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
    <footer class="span12">
        <div id="copyright" class="span6">
            <p>
                ©&nbsp;<?=date('Y')?> –
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
            </p>
        </div>

        <ul id="links" class="span6 unstyled">
            <li><a id="docs" href="https://probe-meteo.com/docs/">
                    <i class="icon-question-sign"></i>
                    <?=i18n('footer.docs.label')?></a>
            </li>
            <li><a id="twitter" href="https://twitter.com/ProbeMeteo">
                    <i class="tw-ico"></i>
                    <?= i18n('footer.twitter.label')?></a>
            </li>
            <li><a id="github" href="https://github.com/sctfic/probe/">
                    <i class="gh-ico"></i>
                    <?=i18n('footer.github.label')?></a>
            </li>
        </ul>
    </footer>
    <noscript><?=i18n('warning.javascript.disable');?></noscript>
</body>
</html>
