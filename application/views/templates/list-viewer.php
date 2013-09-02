<?php
/**
* List available viewer template
*
* @category Template
* @package  Probe
* @author   Édouard Lopez <dev+probe@edouard-lopez.com>
* @license  http://creativecommons.org/licenses/by-nc-sa/3.0/legalcode CC-by-nc-sa-3.0
* @link     http://probe.com/doc
 */
?>
<ul id="list-viewer">
    <?php foreach ($list as $key => $file): ?>
        <li>
            <a href="/viewer/<?=$file;?>"><?=$file;?></a>
        </li>
    <?php endforeach ?>
</ul>
