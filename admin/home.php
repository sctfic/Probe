<article id="admin-station">
<?php
    require_once($GLOBALS['workingFolder'].'../resources/php/toolbox.phpc');
    require_once($GLOBALS['workingFolder'].'../resources/php/configManager.phpc');
    $stationConf = configManager::getConfig('station');

    foreach ($stationConf as $stationId => $stationInfos) {?>
        <section id="<?php echo $stationId;?>">
            <h3><?php echo $stationId;?>
                    <a href='./edit/station:<?php echo $stationId;?>'><?php echo sprintf(_('[edit <i class="hidden">%s</i> properties]'), $stationId);?></a>
            </h3>
            <summary><b><?php echo sprintf('%s: ', _('Model'));?></b><i><?php echo $stationInfos['type'];?></i></summary>
            <details>
                <form action="edit.php" method="get">
                    <fieldset>
                        <input type="hidden" name="config" value="station" />
                        <input type="hidden" name="stationId" value="<?php echo $stationId;?>" />
                        <dl>
                        <?php
                            foreach ($stationInfos as $infoKey => $infoVal) {
                            ?>
                                <dt><label for="<?php echo strtolower($infoKey);?>"><?php echo _($infoKey);?></label></dt>
                                <dd><input disabled
                                    id="<?php echo $infoKey;?>"
                                    name="<?php echo $infoKey;?>"
                                    type="text"
                                    value="<?php echo $infoVal;?>"
                                /></dd>
                            <?php
                            }
                        ?>
                        </dl>
                    </fieldset>
                </form>
            </details>
        </section>
    <?php
    }
?>
</article>
<a href="./?stop" class='btn'><?php echo _('logOut'); ?></a>