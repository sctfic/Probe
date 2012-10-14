<div class="navbar navbar-inverse navbar-fixed-top">
	<ul class="breadcrumb">
	    <li><a href="/setup/installer/dbms"><?=i18n("setup.breadcrumb.dbms")?></a> <span class="divider">/</span></li>
	    <li class="active"><?=i18n("setup.breadcrumb.administrator")?> <span class="divider">/</span></li>
	</ul>
</div>

<div class="container">
	<?=form_open('setup/installer/setupadministrator', array('class' => 'modal setup form-horizontal', 'id' => 'administrator'))?>
		<div class="modal-header">
			<!-- <legend> -->
				<h3><?=i18n("setup.administrator.legend")?></h3>
			<!-- </legend>	 -->
		</div>
		<fieldset class="modal-body">
			<?=validation_errors()?>

			<!-- Admin Username -->
			<div class="control-group">
				<label class="control-label" for="administrator-username">
					<?=sprintf('%s <span class="hidden">(%s)</span>%s', i18n('setup.administrator.username'), i18n('required'), i18n('&nbsp;:')) ?>
				</label>
				<div class="controls">
					<input type="text" id="administrator-username" value="<?=$administratorUsername?>" required class="input-large" placeholder="<?=i18n('setup.administrator.username.placeholder')?>">				</div>
				</div>
			</div>

			<!-- Administrator's password -->
			<div class="control-group">		
				<label class="control-label" for="administrator-password">
					<?=sprintf('%s <span class="hidden">(%s)</span>%s', i18n('setup.administrator.password'), i18n('required'), i18n('&nbsp;:'))?>
				</label>
				<div class="controls">
					<input type="text" id="administrator-password" required value="<?=$administratorPassword?>" class="input-large" placeholder="<?=i18n('setup.administrator.password.placeholder')?>">
				</div>
			</div>

			<!-- Administrator's password confirmation -->
			<div class="control-group">		
				<label class="control-label" for="administrator-password-confirmation">
					<?=sprintf('%s <span class="hidden">(%s)</span>%s', i18n('setup.administrator.password-confirmation'), i18n('required'), i18n('&nbsp;:'))?>
				</label>
				<div class="controls">
					<input type="text" id="administrator-password-confirmation" required value="<?=$administratorPassword?>" class="input-large" placeholder="<?=i18n('setup.administrator.password-confirmation.placeholder')?>">
				</div>
			</div>

		</fieldset>
		<div class="modal-footer">
			<?=form_submit('configure', i18n('setup.administrator.configure'), 'class="btn btn-primary pull-right"')?>
		</div>
	<?=form_close()?>
</div>
