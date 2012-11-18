<div class="navbar navbar-inverse navbar-fixed-top">
  <ul class="breadcrumb">
      <li class="disabled"><a href="/install/dbms"><?=i18n("install.breadcrumb.dbms")?></a> <span class="divider">/</span></li>
      <li class="disabled"><a href="/install/admin-user"><?=i18n("install.breadcrumb.administrator")?></a> <span class="divider">/</span></li>
      <li class="active"><?=i18n("install.breadcrumb.login")?> <span class="divider">/</span></li>
  </ul>
</div>

<?php $username = null; $administratorPassword = null; ?>
<div class="container">
  <?=form_open('admin/admin/connect', array(
    'id' => 'authentification',
    'class' => 'modal login form-horizontal'
    ) );
  ?>
    <div class="modal-header">
      <!-- <legend> -->
        <h3><?=i18n("login.legend")?></h3>
      <!-- </legend>   -->
    </div>

    <fieldset class="modal-body">
      <?=validation_errors()?>

      <!-- <div class="alert alert-info"> -->
        <!-- <?=i18n('login.description')?> -->
      <!-- </div> -->

        <!-- Admin userName -->
        <div class="control-group">
          <label class="control-label" for="login-username">
            <?=sprintf('%s <span class="hidden">(%s)</span>%s', i18n('login.username'), i18n('required'), i18n('&nbsp;:')) ?>
          </label>
          <div class="controls">
            <input id="login-username"
              type="text" required
              name="login-username" value="<?=$username?>" 
              class="input-large" placeholder="<?=i18n('login.username.placeholder')?>">
          </div>
        </div>

        <!-- Administrator's password -->
        <div class="control-group">   
          <label class="control-label" for="login-password">
            <?=sprintf('%s <span class="hidden">(%s)</span>%s', i18n('login.password'), i18n('required'), i18n('&nbsp;:'))?>
          </label>
          <div class="controls">
            <input id="login-password"
              type="password" required
              name="login-password" value="<?=@$loginPassword?>" 
              class="input-large" placeholder="<?=i18n('login.password.placeholder')?>">
          </div>
        </div>

        <!-- <?=form_label( sprintf('%s <span class="hidden">(%s)</span>%s', i18n('userName'), i18n('required'), i18n('&nbsp;:')), 'userName')?> -->
        <!-- <?=form_input( 'userName', $username, sprintf('placeholder="%s"',i18n('fill in your userName') ) )?> -->

        <!-- <?=form_label( sprintf('%s <span class="hidden">(%s)</span>%s', i18n('password'), i18n('required'),i18n('&nbsp;:')), 'password')?> -->
        <!-- <?= sprintf('');//form_password( 'password', $username, sprintf('placeholder="%s" %s',i18n('longer is better'), getStatus('password') ) )?> -->
        <!-- <?=form_password( 'password', $username, sprintf('placeholder="%s"',i18n('longer is better') ) )?> -->

        <!-- <?php if ( _empty($this->config->item('probe:userName') ) ) {?> -->
        <!-- <?=form_label( sprintf('%s <span class="hidden">(%s)</span>%s', i18n('password confirmation'), i18n('required'),i18n('&nbsp;:')), 'confirm')?> -->
        <!-- <?= sprintf('');//form_password( 'confirm', '', sprintf('placeholder="%s" %s',i18n('so we can prevent mistakes'), getStatus('confirm') ) )?> -->
        <!-- <?=form_password( 'confirm', '', sprintf('placeholder="%s"',i18n('so we can prevent mistakes') ) )?> -->
        <!-- <?php } ?> -->

    </fieldset>

    <aside class="js time-indicator">
      <div class="now"><?=date('Y-m-d H:i')?>
        <!-- <img class="time-indicator" src="/themes/icons/weather-clear.png" alt="<?=i18n("sunny weather")?>?>" /> -->
      </div>
    </aside>

    <div class="modal-footer">
      <?=form_submit('authentificate', i18n('login.authentificate'), 'class="btn btn-primary pull-right"')?>
    </div>
  <?=form_close()?>
</div>  