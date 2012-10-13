<?=form_open('setup/installer/setupAdminUser', array('class' => 'setup', 'id' => 'admin-user'))?>
	<fieldset>
	<?=validation_errors()?>

	<?=form_label( sprintf('%s <span class="hidden">(%s)</span>%s', i18n('setup.admin-user.username'), i18n('required'), i18n('&nbsp;:')), 'admin-username')?>
	<?=form_input( array( 'name' => 'admin-username', 'id' => 'admin-username', 'value' => $adminUsername, 'placeholder' => i18n('setup.dbms.username.placeholder') ) )?>

	<?=form_label( sprintf('%s <span class="hidden">(%s)</span>%s', i18n('setup.admin-user.password'), i18n('required'),i18n('&nbsp;:')), 'admin-password')?>
	<?= sprintf('');//form_password( 'password', $username, sprintf('placeholder="%s" %s',i18n('longer is better'), getStatus('password') ) )?>
	<?=form_input( array( 'name' => 'admin-password', 'id' => 'admin-password', 'value' => $adminPassword, 'placeholder' => i18n('setup.dbms.password.placeholder') ) )?>

	<?php
	if ( _empty($this->config->item('ws:username') ) ) {?>
	<?=form_label( sprintf('%s <span class="hidden">(%s)</span>%s', i18n('setup.admin-user.password-confirmation'), i18n('required'),i18n('&nbsp;:')), 'confirm')?>
	<?= sprintf('');//form_password( 'confirm', '', sprintf('placeholder="%s" %s',i18n('so we can prevent mistakes'), getStatus('confirm') ) )?>
	<?=form_input( array( 'name' => 'admin-password-confirm', 'id' => 'admin-password-confirm', 'value' => $adminPasswordConfirmation, 'placeholder' => i18n('setup.dbms.password-confirm.placeholder') ) )?>
	<?php } ?>

	<?=form_submit('setup-admin-user', i18n('setup.admin-user.do-it'), 'class="btn"')?>
	<!--keygen name="security" /-->
	</fieldset>
<?=form_close()?>