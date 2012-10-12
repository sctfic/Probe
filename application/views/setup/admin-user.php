<?=form_open('setup/installer/setupAdminUser', array('class' => 'setup', 'id' => 'admin-user'))?>
    <fieldset>
    <?=validation_errors()?>

    <?=form_label( sprintf('%s <span class="hidden">(%s)</span>%s', i18n('setup.admin.username'), i18n('required'), i18n('&nbsp;:')), 'admin-username')?>
    <?=form_input( 'admin-username', $adminUsername, sprintf('placeholder="%s"',i18n('setup.admin.username.placeholder') ) )?>

    <?=form_label( sprintf('%s <span class="hidden">(%s)</span>%s', i18n('setup.admin.password'), i18n('required'),i18n('&nbsp;:')), 'admin-password')?>
    <?= sprintf('');//form_password( 'password', $username, sprintf('placeholder="%s" %s',i18n('longer is better'), getStatus('password') ) )?>
    <?=form_password( 'admin-password', $adminPassword, sprintf('placeholder="%s"',i18n('setup.admin.password.placeholder') ) )?>

    <?php
    if ( _empty($this->config->item('ws:username') ) ) {?>
        <?=form_label( sprintf('%s <span class="hidden">(%s)</span>%s', i18n('setup.admin.password-confirmation'), i18n('required'),i18n('&nbsp;:')), 'confirm')?>
        <?= sprintf('');//form_password( 'confirm', '', sprintf('placeholder="%s" %s',i18n('so we can prevent mistakes'), getStatus('confirm') ) )?>
        <?=form_password( 'admin-password-confirm', $adminPasswordConfirmation, sprintf('placeholder="%s"',i18n('setup.admin.password-confirmation.placeholder') ) )?>
    <?php } ?>

    <?=form_submit('setup-admin-user', i18n('setup.admin.user.do-it'), 'class="btn"')?>
    <!--keygen name="security" /-->
    </fieldset>
    <aside class="js time-indicator">
        <div class="now"><?=date('Y-m-d H:i')?>
        <!-- <img class="time-indicator" src="/themes/icons/weather-clear.png" alt="<?=i18n("sunny weather")?>?>" /> -->
        </div>
    </aside>
<?=form_close()?>