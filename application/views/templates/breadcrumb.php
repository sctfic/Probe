<?php
/**
 * Breadcrumb template
 *
 * @category Template
 * @package  Probe
 * @author   Édouard Lopez <dev+probe@edouard-lopez.com>
 * @license  http://creativecommons.org/licenses/by-nc-sa/3.0/legalcode CC-by-nc-sa-3.0
 * @link     http://probe.com/doc
 * @param array $breadcrumb
 * array(
 *     '0' => 'i18n.key-text',
 *     '1' => array(
 *         'status'  =>  'active',
 *         'url'     =>  '/viewer',
 *         'i18n'    =>  'viewer.list'
 *     )
 * )
 */
?>
<div class="navbar navbar-inverse navbar-fixed-top">
    <?php if (isset($breadcrumb)): ?>
    <ul class="breadcrumb">
    <?php foreach ($breadcrumb as $key => $step): ?>
        <?php if (is_array($step)): ?>
        <li class="<?=isset($step['status']) ? $step['status'] : 'disabled';?>">
            <a href="<?=$step['url']?>"><?=i18n($step['i18n'], true)?></a>
            <?php else: ?>
        <li>
            <?= i18n($step); ?>
        <?php endif // non-dependent tag : ?>
        <span class="divider">/</span>
        </li>
    <?php endforeach ?>
    </ul>
    <?php endif ?>
</div>
