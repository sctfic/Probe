<div class="navbar navbar-inverse navbar-fixed-top">
    <ul class="breadcrumb">
        <li><a href="/install/dbms"><?=i18n("setup.breadcrumb.dbms")?></a> <span class="divider">/</span></li>
        <li class="active"><a href="/install/adminUser"><?=i18n("setup.breadcrumb.administrator")?></a> <span class="divider">/</span></li>
        <li class="disabled"><?=i18n("setup.breadcrumb.dashboard")?> <span class="divider">/</span></li>
    </ul>
</div>

<?php
//     require_once($GLOBALS['workingFolder'].'../resources/php/toolbox.phpc');
//     require_once($GLOBALS['workingFolder'].'../resources/php/configManager.phpc');
//     $stationConf = configManager::getConfig('station');

// echo getcwd();
// just for prototyping
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
                    [<?=sprintf(_('edit %s properties'), sprintf('<i class="hidden">%s</i>', $stationId))?>]
                </a>
            </h3>
            <summary><b><?=sprintf('%s: ', _('Model'));?></b><i><?=$stationInfos['config:type']?></i></summary>
            <details open="open">
                <form action="edit.php" method="get">
                    <fieldset>
                        <input type="hidden" name="config" value="station" />
                        <input type="hidden" name="stationId" value="<?=$stationId?>" />
                        <dl>
                            <?php foreach ($stationInfos as $infoKey => $infoVal): ?>
                                <dt><label for="<?=strtolower($infoKey)?>"><?=_($infoKey)?></label></dt>
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
<a href="./?stop" class='btn'><?=_('logOut'); ?></a>
<a href="/admin/logout" class='btn'><?=_('logOut'); ?></a>