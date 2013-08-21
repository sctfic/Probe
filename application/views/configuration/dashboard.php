<?php
 /**
 * Configuration dashboard (authenticated users)
 *
 * @category Template
 * @package  Probe
 * 
 * @author   Édouard Lopez <dev+probe@edouard-lopez.com>
 *
 * @license  http://creativecommons.org/licenses/by-nc-sa/3.0/legalcode CC-by-nc-sa-3.0
 * @link     http://Probe.com/doc
 *
 * @datetime: 6/8/13T10:50 PM
 */
?>
<ul id="dashboard">
    <li>
        <a href="/configuration/list-stations">
            <?=i18n("configuration-stations.list.label")?>
        </a>
    </li>
    <li>
        <a href="/configuration/add-station">
            <?=i18n("configuration-stations.add.label")?>
        </a>
    </li>
</ul>
