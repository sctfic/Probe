<?php
require_once '../config/stations.conf.php';
?>
<article id="admin-station">

<a href="#" class="btn btn-success">
    <i class="icon-white icon-plus"></i> Ajouter une station
</a>

    <nav id="stations-list" class="nav-tabs">
        <ol>
        <? // Build sidebar navigation
        foreach ($stationsConf as $stationId => $stationInfos): ?>
                <li><?= $stationId; ?></li>
        <?php endforeach // END: sidebar navigation?>
            </ol>
    </nav>

    <section>
   <? foreach ($stationsConf as $stationId => $stationInfos): ?>
        <article id="<?=$stationId?>" class="station-config">
            <h3><?=$stationId?>
                <a href='/admin/edit/station:<?=$stationId?>'>
                    [<?=sprintf(i18n('edit %s properties'), sprintf('<i class="hidden">%s</i>', $stationId))?>]
                </a>
            </h3>
            <summary><b><?=sprintf('%s: ', i18n('Model'));?></b><i><?=$stationInfos['config:type']?></i></summary>
            <details open="open">
                <form action="edit.php" method="get">
                    <fieldset>
                        <input type="hidden" name="config" value="station" />
                        <input type="hidden" name="stationId" value="<?=$stationId?>" />
                        <dl>
                            <?php foreach ($stationInfos as $infoKey => $infoVal): ?>
                                <dt><label for="<?=strtolower($infoKey)?>"><?=i18n($infoKey)?></label></dt>
                                <dd><input disabled
                                    id="<?=$infoKey?>"
                                    name="<?=$infoKey?>"
                                    type="text"
                                    value="<?=$infoVal?>"
                                /></dd>
                            <?php endforeach ?>
                        </dl>
                    </fieldset>
                </form>
            </details>
        </article>
    <?php endforeach ?>
    </section>
</article>
<a href="./?stop" class='btn'><?=i18n('logout.request.label'); ?></a>
<a href="/admin/logout" class='btn'><?=i18n('logout.request.label'); ?></a>