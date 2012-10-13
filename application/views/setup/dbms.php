<?=form_open('setup/installer/setupDbms', array('class' => 'setup form-horizontal', 'id' => 'dbms'))?>
	<legend><?=i18n("setup.dbms.legend")?></legend>
	<fieldset>
	<?=validation_errors()?>

	<!-- Server host/IP -->
	<div class="control-group">
		<label class="control-label" for="dbms-ip">
			<?=sprintf('%s <span class="hidden">(%s)</span>%s', i18n('setup.dbms.ip'), i18n('required'), i18n('&nbsp;:')) ?>
		</label>
		<div class="controls">
			<input type="text" id="dbms-ip" value="<?=$dbmsIp?>" class="input-medium" placeholder="<?=i18n('setup.dbms.ip.placeholder')?>">
		</div>
	</div>

	<!-- Server port (range between: 1-65535) -->
	<div class="control-group">
		<label class="control-label" for="dbms-port">
			<?=sprintf('%s <span class="hidden">(%s)</span>%s', i18n('setup.dbms.port'), i18n('required'), i18n('&nbsp;:')) ?>
		</label>
		<div class="controls">
			<input type="number" min="1" max="65535" id="dbms-port" value="<?=$dbmsPort?>" class="input-mini" placeholder="<?=i18n('setup.dbms.port.placeholder')?>">
		</div>
	</div>

	<!-- Engine: MySQL vs. SQLite  -->
	<div class="control-group">
		<label class="control-label">
			<?=sprintf('%s <span class="hidden">(%s)</span>%s', i18n('setup.dbms.engine'), i18n('required'), i18n('&nbsp;:')) ?>
		</label>
		<div class="controls">
			<label class="control-label inline" for="dbms-engine-mysql">
				<input type="radio" name="dbms-engine" id="dbms-engine-mysql" value="<?=$dbmsPort?>" checked class="input-mini" >
				<?=sprintf('%s <span class="hidden">(%s)</span>', i18n('setup.dbms.engine-mysql'), i18n('required')) ?>
			</label>
			<label class="control-label inline" for="dbms-engine-sqlite">
				<input type="radio" name="dbms-engine" id="dbms-engine-sqlite" value="<?=$dbmsPort?>" class="input-mini" >
				<?=sprintf('%s <span class="hidden">(%s)</span>', i18n('setup.dbms.engine-sqlite'), i18n('required')) ?>
			</label>
		</div>
	</div>


	<!-- Existing database vs. new one -->
<!-- 	<div class="control-group">
		<label class="control-label">
			<?=sprintf('%s <span class="hidden">(%s)</span>%s', i18n('setup.dbms.database.selection'), i18n('required'), i18n('&nbsp;:')) ?>
		</label>
		<div class="controls">
			<label class="control-label inline" for="dbms-database-reuse">
				<input type="radio" name="dbms-database-selection" id="dbms-database-reuse" value="<?=$dbmsPort?>" checked class="input-mini" >
				<?=sprintf('%s <span class="hidden">(%s)</span>', i18n('setup.dbms.database-reuse'), i18n('required')) ?>
			</label>
			<label class="control-label inline" for="dbms-database-create">
				<input type="radio" name="dbms-database-selection" id="dbms-database-create" value="<?=$dbmsPort?>" class="input-mini" >
				<?=sprintf('%s <span class="hidden">(%s)</span>', i18n('setup.dbms.database-create'), i18n('required')) ?>
			</label>
		</div>
	</div> -->

	<div class="control-group">
	<!-- Server database name -->
		<label class="control-label" for="dbms-database-name">
			<?=sprintf('%s %s', i18n('setup.dbms.database-name'), i18n('&nbsp;:'))?>
		</label>
		<div class="controls">
			<input type="text" id="dbms-database-name" disabled value="<?=$dbmsDatabaseName?>" class="input-large" >
		</div>
	</div>

	<div class="control-group">		
	<!-- Server admin username -->
		<label class="control-label" for="dbms-username">
			<?=sprintf('%s <span class="hidden">(%s)</span>%s', i18n('setup.dbms.username'), i18n('required'), i18n('&nbsp;:'))?>
		</label>
		<div class="controls">
			<input type="text" id="dbms-username" required value="<?=$dbmsUsername?>" class="input-large" placeholder="<?=i18n('setup.dbms.username.placeholder')?>">
		</div>
	</div>

	<div class="control-group">		
	<!-- Server admin password -->
		<label class="control-label" for="dbms-password">
			<?=sprintf('%s <span class="hidden">(%s)</span>%s', i18n('setup.dbms.password'), i18n('required'), i18n('&nbsp;:'))?>
		</label>
		<div class="controls">
			<input type="text" id="dbms-password" required value="<?=$dbmsPassword?>" class="input-large" placeholder="<?=i18n('setup.dbms.password.placeholder')?>">
		</div>
	</div>
		
	
	<?=form_submit('configure', i18n('setup.dbms.configure'), 'class="btn pull-right"')?>
	<!--keygen name="security" /-->
	</fieldset>
<?=form_close()?>
<p>
Problème de connexion localhost vs. any host :
1. accès depuis le serveur à un utilisateur sur @'%'. Il faut supprimer les utilisateur anonyme (cf. ci-dessus). sur @'localhost' pas de soucis.
2. accès depuis un serveur distant à @'%', il faut changer dans /etc/mysql/my.cnf la valeur de bind-address. Connexion vers @'localhost' ok
</p>