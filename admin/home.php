<article>
<?php

    require_once($GLOBALS['workingFolder'].'../resources/php/toolbox.phpc');
    require_once($GLOBALS['workingFolder'].'../resources/php/configManager.phpc');
    $stationConf = configManager::getConfig('station');

    foreach ($stationConf as $stationId => $stationInfos) {?>
        <section id="<?php echo $stationId;?>">
            <h3><?php echo $stationId;?></h3>
            <form action="edit.php" method="get">
                <fieldset>
                <input type="hidden" name="config" value="station" />
                <input type="hidden" name="stationId" value="<?php echo $stationId;?>" />
                <?php
                    foreach ($stationInfos as $infoKey => $infoVal) {
                    ?>
                        <label for="<?php echo $infoKey;?>"><?php echo $infoKey;?></label>
                        <input id="<?php echo $infoKey;?>" name="<?php echo $infoKey;?>" type="text" readonly />
                    <?php
                    }
                ?>
                </fieldset>
            </form>
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