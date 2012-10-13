<?=form_open('setup/installer/setupDbms', array('class' => 'setup', 'id' => 'dbms'))?>
	<fieldset>
	<?=validation_errors()?>

<!-- Server host/IP -->
	<?=form_label( sprintf('%s <span class="hidden">(%s)</span>%s', i18n('setup.dbms.ip'), i18n('required'), i18n('&nbsp;:')), 'dbms-ip')?>
	<?=form_input( array( 'name' => 'dbms-ip', 'id' => 'dbms-ip', 'value' => $dbmsIp, 'placeholder' => i18n('setup.dbms.ip.placeholder') ) )?>

<!-- Server port (range between: 1-65535) -->
	<?=form_label( sprintf('%s <span class="hidden">(%s)</span>%s', i18n('setup.dbms.port'), i18n('required'), i18n('&nbsp;:')), 'dbms-port')?>
	<?=form_input( array( 'name' => 'dbms-port', 'id' => 'dbms-port', 'value' => $dbmsPort, 'placeholder' => i18n('setup.dbms.port.placeholder') ) )?>

<!-- Engine: MySQL vs. SQLite  -->
	<?=form_label( sprintf('%s <span class="hidden">(%s)</span>%s', i18n('setup.dbms.engine-mysql'), i18n('required'), i18n('&nbsp;:')), 'dbms-engine-mysql')?>
	<?=form_radio( array( 'name' => 'dbms-engine', 'id' => 'dbms-engine-mysql', 'value' => 'mysql', 'checked' => true ) )?>
	<?=form_label( sprintf('%s <span class="hidden">(%s)</span>%s', i18n('setup.dbms.engine-sqlite'), i18n('required'), i18n('&nbsp;:')), 'dbms-engine-sqlite')?>
	<?=form_radio( array( 'name' => 'dbms-engine', 'id' => 'dbms-engine-sqlite', 'value' => 'sqlite', 'checked' => false ) )?>

<!-- Server admin user -->
	<?=form_label( sprintf('%s <span class="hidden">(%s)</span>%s', i18n('setup.dbms.username'), i18n('required'), i18n('&nbsp;:')), 'dbms-username')?>
	<?=form_input( array( 'name' => 'dbms-username', 'id' => 'dbms-username', 'value' => $dbmsUsername, 'placeholder' => i18n('setup.dbms.username.placeholder') ) )?>
<!-- Server admin password -->
	<?=form_label( sprintf('%s <span class="hidden">(%s)</span>%s', i18n('setup.dbms.password'), i18n('required'),i18n('&nbsp;:')), 'dbms-password')?>
	<?= sprintf('');//form_password( 'password', $username, sprintf('placeholder="%s" %s',i18n('longer is better'), getStatus('password') ) )?>
	<?=form_input( array( 'name' => 'dbms-password', 'id' => 'dbms-password', 'value' => $dbmsPassword, 'placeholder' => i18n('setup.dbms.password.placeholder') ) )?>
	
	
	<?=form_submit('setup-dbms', i18n('setup.dbms.do-it'), 'class="btn"')?>
	<!--keygen name="security" /-->
	</fieldset>
<?=form_close()?>