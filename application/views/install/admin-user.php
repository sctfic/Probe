<?php
/**
* Form to setup application's admin account
*
* @category Install
* @package  Probe
* @author   Édouard Lopez <dev+probe@edouard-lopez.com>
* @license  http://creativecommons.org/licenses/by-nc-sa/3.0/legalcode CC-by-nc-sa-3.0
* @link     http://probe.dev/install/admin-user.php
*/
?>
<div class="navbar navbar-inverse navbar-fixed-top">
    <ul class="breadcrumb">
        <li><a href="/install/dbms"><?=i18n("install.breadcrumb.dbms")?></a> <span class="divider">/</span></li>
        <li class="active"><a href="/install/admin-user"><?=i18n("install.breadcrumb.administrator")?></a> <span class="divider">/</span></li>
        <li class="disabled"><?=i18n("install.breadcrumb.dashboard")?> <span class="divider">/</span></li>
    </ul>
</div>

<div class="container">
    <?=
    form_open(
        'install/setup-administrator',
        array(
            'id' => 'administrator',
            'class' => 'modal setup form-horizontal'
        )
    );
    ?>
        <div class="modal-header">
            <!-- <legend> -->
                <h3><?=i18n("install.administrator.legend")?></h3>
            <!-- </legend>	 -->
        </div>

        <fieldset class="modal-body">
            <?=validation_errors()?>

    <div class="alert alert-info">
        <?=i18n('install.administrator.description')?>
    </div>

            <!-- Admin Username -->
            <div class="control-group">
                <label class="control-label" for="administrator-username">
                    <?=sprintf('%s <span class="hidden">(%s)</span>%s', i18n('install.administrator.username'), i18n('required'), i18n('&nbsp;:')) ?>
                </label>
                <div class="controls">
                    <input id="administrator-username"
                        type="text" required
                        name="administrator-username" value="<?=$adminUsername?>"
                        class="input-large" placeholder="<?=i18n('install.administrator.username.placeholder')?>">
                </div>
            </div>

            <!-- Administrator's password -->
            <div class="control-group">
                <label class="control-label" for="administrator-password">
                    <?=sprintf('%s <span class="hidden">(%s)</span>%s', i18n('install.administrator.password'), i18n('required'), i18n('&nbsp;:'))?>
                </label>
                <div class="controls">
                    <input id="administrator-password"
                        type="password" required
                        name="administrator-password" value="<?=$adminPassword?>"
                        class="input-large" placeholder="<?=i18n('install.administrator.password.placeholder')?>">
                </div>
            </div>

            <!-- Administrator's password confirmation -->
            <div class="control-group">
                <label class="control-label" for="administrator-password-confirmation">
                    <?=sprintf('%s <span class="hidden">(%s)</span>%s', i18n('install.administrator.password-confirmation'), i18n('required'), i18n('&nbsp;:'))?>
                </label>
                <div class="controls">
                    <input id="administrator-password-confirmation"
                    type="password" required
                    name="administrator-password-confirmation" value="<?=$adminConfirm?>"
                    class="input-large" placeholder="<?=i18n('install.administrator.password-confirmation.placeholder')?>">
                </div>
            </div>

        </fieldset>
        <div class="modal-footer form-actions">
      <a href="/install/dbms" class="btn"><?=i18n('form.action.back');?></a>
            <?=form_submit('configure', i18n('install.administrator.configure'), 'class="btn btn-primary pull-right"')?>
        </div>
    <?=form_close()?>
</div>
