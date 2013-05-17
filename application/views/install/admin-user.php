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
                <h3><?=i18n("install-administrator.main-content.header")?></h3>
            <!-- </legend>	 -->
        </div>

        <fieldset class="modal-body">
            <?=validation_errors()?>

    <div class="alert alert-info">
        <?=i18n('install-administrator.main-content.description')?>
    </div>

            <!-- Admin Username -->
            <div class="control-group">
                <label class="control-label" for="admin-username">
                    <?=sprintf('%s <span class="hidden">(%s)</span>%s', i18n('install-administrator.username.label'), i18n('required'), i18n('&nbsp;:')) ?>
                </label>
                <div class="controls">
                    <input id="admin-username"
                        type="text" required
                        name="admin-username" value="<?=$adminUsername?>"
                        class="input-large" placeholder="<?=i18n('install-administrator.username.placeholder')?>">
                </div>
            </div>

            <!-- Administrator's password -->
            <div class="control-group">
                <label class="control-label" for="admin-password">
                    <?=sprintf('%s <span class="hidden">(%s)</span>%s', i18n('install-administrator.password.label'), i18n('required'), i18n('&nbsp;:'))?>
                </label>
                <div class="controls">
                    <input id="admin-password"
                        type="password" required
                        name="admin-password" value="<?=$adminPassword?>"
                        class="input-large" placeholder="<?=i18n('install-administrator.password.placeholder')?>">
                </div>
            </div>

            <!-- Administrator's password confirmation -->
            <div class="control-group">
                <label class="control-label" for="admin-password-confirmation">
                    <?=sprintf('%s <span class="hidden">(%s)</span>%s', i18n('install-administrator.password-confirmation.label'), i18n('required'), i18n('&nbsp;:'))?>
                </label>
                <div class="controls">
                    <input id="admin-password-confirmation"
                    type="password" required
                    name="admin-password-confirmation" value="<?=$adminConfirm?>"
                    class="input-large" placeholder="<?=i18n('install-administrator.password-confirmation.placeholder')?>">
                </div>
            </div>

        </fieldset>
        <div class="modal-footer form-actions">
            <a href="/install/dbms" class="btn">
                <i class="icon-arrow-left"></i>
                <?=i18n('form.action.back');?>
            </a>

            <!-- TODO replace arrow by icon -->
            <?=form_submit('configure', i18n('install-administrator.configure.label'), 'class="btn btn-primary pull-right"')?>
        </div>
    <?=form_close()?>
</div>
