<article>
<?php

    require_once($GLOBALS['workingFolder'].'../resources/php/toolbox.phpc');
    require_once($GLOBALS['workingFolder'].'../resources/php/configManager.phpc');
    $stationConf = configManager::getConfig('station');

    foreach ($stationConf as $stationId => $stationInfos) {?>
        <section id="<?php echo $stationId;?>">
            <h3><?php echo $stationId;?></h3>
            <?php
                foreach ($stationInfos as $key => $val) {

                }
            ?>
        </section>
    <?php
    }
?>
    <section>
        <h3><?php echo _('Station One');?></h3>
    </section>
</article>
<progress value="29" max="400"></progress><br />
<a href="./?stop" class='btn'><?php echo _('logOut'); ?></a>
<meter value="7" min="0" max="19"></meter><br />