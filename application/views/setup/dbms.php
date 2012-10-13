<?=form_open('setup/installer/setupDbms', array('class' => 'setup', 'id' => 'dbms'))?>
	<fieldset>
	<?=validation_errors()?>

	<!-- Server host/IP -->
	<?=form_label( sprintf('%s <span class="hidden">(%s)</span>%s', i18n('setup.dbms.ip'), i18n('required'), i18n('&nbsp;:')), 'dbms-ip')?>
	<?=form_input( 'dbms-ip', $dbmsIp, sprintf('placeholder="%s"',i18n('setup.dbms.ip.placeholder') ) )?>

	<!-- Server port (range between: 1-65535) -->
	<?=form_label( sprintf('%s <span class="hidden">(%s)</span>%s', i18n('setup.dbms.port'), i18n('required'), i18n('&nbsp;:')), 'dbms-port')?>
	<?=form_input( 'dbms-port', $dbmsPort, sprintf('placeholder="%s"',i18n('setup.dbms.port.placeholder') ) )?>

	<!-- Engine: MySQL vs. SQLite  -->
	<?=form_label( sprintf('%s <span class="hidden">(%s)</span>%s', i18n('setup.dbms.engine-mysql'), i18n('required'), i18n('&nbsp;:')), 'dbms-engine-mysql')?>
	<?=form_radio( array( 'name' => 'dbms-engine', 'id' => 'dbms-engine-mysql', 'value' => 'mysql', 'checked' => true ) )?>
	<?=form_label( sprintf('%s <span class="hidden">(%s)</span>%s', i18n('setup.dbms.engine-sqlite'), i18n('required'), i18n('&nbsp;:')), 'dbms-engine-sqlite')?>
	<?=form_radio( array( 'name' => 'dbms-engine', 'id' => 'dbms-engine-sqlite', 'value' => 'sqlite', 'checked' => false ) )?>

	<!-- Server admin user -->
	<?=form_label( sprintf('%s <span class="hidden">(%s)</span>%s', i18n('setup.dbms.username'), i18n('required'), i18n('&nbsp;:')), 'dbms-username')?>
	<?=form_input( 'dbms-username', $dbmsUsername, sprintf('placeholder="%s"',i18n('setup.dbms.password.placeholder') ) )?>
	<!-- Server admin password -->
	<?=form_label( sprintf('%s <span class="hidden">(%s)</span>%s', i18n('setup.dbms.password'), i18n('required'),i18n('&nbsp;:')), 'dbms-password')?>
	<?= sprintf('');//form_password( 'password', $username, sprintf('placeholder="%s" %s',i18n('longer is better'), getStatus('password') ) )?>
	<?=form_password( 'dbms-password', $dbmsPassword, sprintf('placeholder="%s"',i18n('setup.dbms.password.placeholder') ) )?>
	
	<!-- Server admin baseName -->
	<?=form_label( sprintf('%s <span class="hidden">(%s)</span>%s', i18n('setup.dbms.basename'), i18n('required'),i18n('&nbsp;:')), 'dbms-basename')?>
	<?= sprintf('');//form_basename( 'basename', $username, sprintf('placeholder="%s" %s',i18n('longer is better'), getStatus('basename') ) )?>
	<?=form_password( 'dbms-basename', $dbmsBaseName, sprintf('placeholder="%s"',i18n('setup.dbms.basename.placeholder') ) )?>
	
	
	<?=form_submit('authentificate', i18n('setup.dbms.do-it'), 'class="btn"')?>
	<!--keygen name="security" /-->
	</fieldset>
<?=form_close()?>
<p>
Problème de connexion localhost vs. any host :
1. accès depuis le serveur à un utilisateur sur @'%'. Il faut supprimer les utilisateur anonyme (cf. ci-dessus). sur @'localhost' pas de soucis.
2. accès depuis un serveur distant à @'%', il faut changer dans /etc/mysql/my.cnf la valeur de bind-address. Connexion vers @'localhost' ok
</p>