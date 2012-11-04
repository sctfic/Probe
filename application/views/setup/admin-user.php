<div class="navbar navbar-inverse navbar-fixed-top">
	<ul class="breadcrumb">
	    <li><a href="/install/dbms"><?=i18n("setup.breadcrumb.dbms")?></a> <span class="divider">/</span></li>
	    <li class="active"><a href="/install/adminUser"><?=i18n("setup.breadcrumb.administrator")?></a> <span class="divider">/</span></li>
	    <li class="disabled"><?=i18n("setup.breadcrumb.dashboard")?> <span class="divider">/</span></li>
	</ul>
</div>

<div class="container">
	<?=form_open('install/setupAdministrator', array('class' => 'modal setup form-horizontal', 'id' => 'administrator'))?>
		<div class="modal-header">
			<!-- <legend> -->
				<h3><?=i18n("setup.administrator.legend")?></h3>
			<!-- </legend>	 -->
		</div>

		<fieldset class="modal-body">
			<?=validation_errors()?>

    <div class="alert alert-info">
    	<?=i18n('setup.administrator.description')?>
    </div>

			<!-- Admin Username -->
			<div class="control-group">
				<label class="control-label" for="administrator-username">
					<?=sprintf('%s <span class="hidden">(%s)</span>%s', i18n('setup.administrator.username'), i18n('required'), i18n('&nbsp;:')) ?>
				</label>
				<div class="controls">
					<input id="administrator-username"
						type="text" required
						name="administrator-username" value="<?=$administratorUsername?>" 
						class="input-large" placeholder="<?=i18n('setup.administrator.username.placeholder')?>">
				</div>
			</div>

			<!-- Administrator's password -->
			<div class="control-group">		
				<label class="control-label" for="administrator-password">
					<?=sprintf('%s <span class="hidden">(%s)</span>%s', i18n('setup.administrator.password'), i18n('required'), i18n('&nbsp;:'))?>
				</label>
				<div class="controls">
					<input id="administrator-password"
						type="password" required
						name="administrator-password" value="<?=$administratorPassword?>" 
						class="input-large" placeholder="<?=i18n('setup.administrator.password.placeholder')?>">
				</div>
			</div>

			<!-- Administrator's password confirmation -->
			<div class="control-group">		
				<label class="control-label" for="administrator-password-confirmation">
					<?=sprintf('%s <span class="hidden">(%s)</span>%s', i18n('setup.administrator.password-confirmation'), i18n('required'), i18n('&nbsp;:'))?>
				</label>
				<div class="controls">
					<input id="administrator-password-confirmation"
					type="password" required
					name="administrator-password-confirmation" value="<?=$administratorPassword?>"
					class="input-large" placeholder="<?=i18n('setup.administrator.password-confirmation.placeholder')?>">
				</div>
			</div>

		</fieldset>
		<div class="modal-footer">
			<?=form_submit('configure', i18n('setup.administrator.configure'), 'class="btn btn-primary pull-right"')?>
		</div>
	<?=form_close()?>
</div>
