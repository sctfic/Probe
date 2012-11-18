<div class="navbar navbar-inverse navbar-fixed-top">
  <ul class="breadcrumb">
      <li class="disabled"><a href="/install/dbms"><?=i18n("install.breadcrumb.dbms")?></a> <span class="divider">/</span></li>
      <li class="disabled"><?=i18n("install.breadcrumb.administrator")?> <span class="divider">/</span></li>
      <li class="active"><?=i18n("install.breadcrumb.dashboard")?> <span class="divider">/</span></li>
  </ul>
</div>

<?=form_open('admin/admin/connect', array(
  'id' => 'authentification',
  'class' => 'modal login'
  )
);
?>
  <div class="modal-header">
    <fieldset>
      <?=validation_errors()?>

      <?=form_label( sprintf('%s <span class="hidden">(%s)</span>%s', i18n('username'), i18n('required'), i18n('&nbsp;:')), 'username')?>
      <?=form_input( 'username', $userName, sprintf('placeholder="%s"',i18n('fill in your username') ) )?>

      <?=form_label( sprintf('%s <span class="hidden">(%s)</span>%s', i18n('password'), i18n('required'),i18n('&nbsp;:')), 'password')?>
      <?= sprintf('');//form_password( 'password', $userName, sprintf('placeholder="%s" %s',i18n('longer is better'), getStatus('password') ) )?>
      <?=form_password( 'password', $userName, sprintf('placeholder="%s"',i18n('longer is better') ) )?>

      <?php
      if ( _empty($this->config->item('probe:username') ) ) {?>
      <?=form_label( sprintf('%s <span class="hidden">(%s)</span>%s', i18n('password confirmation'), i18n('required'),i18n('&nbsp;:')), 'confirm')?>
      <?= sprintf('');//form_password( 'confirm', '', sprintf('placeholder="%s" %s',i18n('so we can prevent mistakes'), getStatus('confirm') ) )?>
      <?=form_password( 'confirm', '', sprintf('placeholder="%s"',i18n('so we can prevent mistakes') ) )?>
      <?php } ?>

      <?=form_submit('authentificate', i18n('login'), 'class="btn"')?>
      <!--keygen name="security" /-->
    </fieldset>
    <aside class="js time-indicator">
      <div class="now"><?=date('Y-m-d H:i')?>
        <!-- <img class="time-indicator" src="/themes/icons/weather-clear.png" alt="<?=i18n("sunny weather")?>?>" /> -->
      </div>
    </aside>
  </div>
  
<?=form_close()?>