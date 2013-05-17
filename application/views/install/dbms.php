<?php
/**
 * Form to setup application's database holding configuration
 *
 * @category Install
 * @package  Probe
 * @author   Édouard Lopez <dev+probe@edouard-lopez.com>
 * @license  http://creativecommons.org/licenses/by-nc-sa/3.0/legalcode CC-by-nc-sa-3.0
 * @link     http://probe.dev/install/admin-user.php
 */
?>

<?=form_open('install/setupDbms', array(
		'id' => 'dbms',
		'class' => 'modal setup form-horizontal'
	)
);
?>

	<div class="modal-header">
		<!-- <legend> -->
			<h3><?=i18n("install-dbms.main-content.header")?></h3>
		<!-- </legend>	 -->
	</div>
	<fieldset class="modal-body">
		<?=validation_errors()?>

        <!-- Engine: MySQL vs. SQLite  -->
        <div id="dbms-engine" class="control-group">
            <label class="control-label">
                <?=sprintf('%s%s', i18n('install-dbms.engine.label'), i18n('&nbsp;:')) ?>
            </label>
            <div class="controls">
                <label class="control-label inline" for="dbms-engine-mysql">
                    <input id="dbms-engine-mysql"
                           type="radio" checked
                           name="dbms-engine" value="mysql"
                    >
                    <?=sprintf('%s', i18n('install-dbms.engine:mysql.label')) ?>
                </label>
                <label class="control-label inline" for="dbms-engine-sqlite">
                    <input id="dbms-engine-sqlite"
                           type="radio"
                           name="dbms-engine" value="sqlite"
                    >
                    <?=sprintf('%s', i18n('install-dbms.engine:sqlite.label')) ?>
                </label>
                <?
                /*
                <label class="control-label inline" for="dbms-engine-postgresql">
                    <input id="dbms-engine-postgresql"
                           type="radio"
                           name="dbms-engine" value="postgresql"
                            >
                    <?=sprintf('%s', i18n('install-dbms.engine:postgresql.label')) ?>
                </label>
                */
                ?>
            </div>
        </div>

        <!-- MySQL Server host/IP -->
		<div id="dbms-host" class="control-group mysql">
			<label class="control-label" for="dbms-host">
				<?=sprintf('%s <span class="hidden">(%s)</span>%s', i18n('install-dbms.host.label'), i18n('required'), i18n('&nbsp;:')) ?>
			</label>
			<div class="controls">
                <input name="dbms-host"
                    value="<?=$dbmsHost?>"
                    type="text" required
					class="input-large"
                    placeholder="<?=i18n('install-dbms.host.placeholder')?>"
				>
			</div>
		</div>

		<!-- Server port (range between: 1-65535) -->
		<div class="control-group mysql">
			<label class="control-label" for="dbms-port">
				<?=sprintf('%s <span class="hidden">(%s)</span>%s', i18n('install-dbms.port.label'), i18n('required'), i18n('&nbsp;:')) ?>
			</label>
			<div class="controls">
				<input id="dbms-port"
                   type="number" min="1" max="65535"
                   name="dbms-port" value="<?=$dbmsPort?>"
                   class="input-mini" placeholder="<?=i18n('install-dbms.port.placeholder')?>"
				>
			</div>
		</div>

		<div class="control-group mysql">
		<!-- Server database name -->
			<label class="control-label" for="dbms-database-name">
				<?=sprintf('%s %s', i18n('install-dbms.database-name.label'), i18n('&nbsp;:'))?>
			</label>
			<div class="controls">
				<input id="dbms-database-name"
                    type="text" disabled
                    name="dbms-database-name" value="<?=$dbmsDatabaseName?>"
                    class="input-large"
				>
			    <!-- <span class="input-large uneditable-input"><?=$dbmsDatabaseName?></span> -->
				<!-- <input type="hidden" id="dbms-database-name" value="<?=$dbmsDatabaseName?>" class="input-large" > -->
			</div>
		</div>

        <div class="alert mysql">
            <?=i18n('install-dbms.advanced-user-management.label')?>
        </div>

		<!-- Database's manager's username -->
		<div class="control-group mysql">
			<label class="control-label" for="dbms-username">
				<?=sprintf('%s <span class="hidden">(%s)</span>%s', i18n('install-dbms.username.label'), i18n('required'), i18n('&nbsp;:'))?>
			</label>
			<div class="controls">
				<input id="dbms-username"
					type="text" required
					name="dbms-username" value="<?=$dbmsUsername?>" 
					class="input-large" placeholder="<?=i18n('install-dbms.username.placeholder')?>"
				>
			</div>
		</div>

		<!-- Database's manager's password -->
		<div class="control-group mysql">
			<label class="control-label" for="dbms-password">
				<?=sprintf('%s <span class="hidden">(%s)</span>%s', i18n('install-dbms.password.label'), i18n('required'), i18n('&nbsp;:'))?>
			</label>
			<div class="controls">
				<input id="dbms-password"
					type="password" required
					name="dbms-password" value="<?=$dbmsPassword?>"
					class="input-large" placeholder="<?=i18n('install-dbms.password.placeholder')?>"
				>
			</div>
		</div>

        <!-- SQLite file Path (disable by default) -->
        <div id="dbms-path" class="control-group sqlite">
            <label class="control-label" for="dbms-path">
                <?=sprintf('%s <span class="hidden">(%s)</span>%s', i18n('install-dbms.path.label'), i18n('required'), i18n('&nbsp;:')) ?>
            </label>
            <div class="controls">
                <input name="dbms-path"
                       value="./<?=SQLITE_PATH?>"
                       type="text" disabled
                       class="input-xlarge" placeholder="<?=i18n('install-dbms.path.placeholder')?>"
                >
            </div>
        </div>

	</fieldset>
	<div class="modal-footer">
        <!-- TODO replace arrow by icon -->
		<?=form_submit('configure', i18n('install-dbms.configure.label'), 'class="btn btn-primary pull-right"')?>
	</div>
<?=form_close()?>
<?
// <p>
// Problème de connexion localhost vs. any host :
// 1. accès depuis le serveur à un utilisateur sur @'%'. Il faut supprimer les utilisateur anonyme (cf. ci-dessus). sur @'localhost' pas de soucis.
// 2. accès depuis un serveur distant à @'%', il faut changer dans /etc/mysql/my.cnf la valeur de bind-address. Connexion vers @'localhost' ok
// </p>
?>