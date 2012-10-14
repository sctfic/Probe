<!--j6
<?php //echo $msg; ?>
<form action="<?php //echo site_url("admin/admin/connecter"); ?>">
	Login  : <input name="login" type="text" /><br />
	Mdp  : <input name="mdp" type="text" /><br />
	<input type="submit" value="connexion" />
</form>-->

<?=form_open('admin/admin/connect', array('class' => 'login', 'id' => 'authentification'))?>
    <fieldset>
<?php

?>
    <?=validation_errors()?>

    <?=form_label( sprintf('%s <span class="hidden">(%s)</span>%s', i18n('username'), i18n('required'), i18n('&nbsp;:')), 'username')?>
    <?=form_input( 'username', $username, sprintf('placeholder="%s"',i18n('fill in your username') ) )?>

    <?=form_label( sprintf('%s <span class="hidden">(%s)</span>%s', i18n('password'), i18n('required'),i18n('&nbsp;:')), 'password')?>
    <?= sprintf('');//form_password( 'password', $username, sprintf('placeholder="%s" %s',i18n('longer is better'), getStatus('password') ) )?>
    <?=form_password( 'password', $username, sprintf('placeholder="%s"',i18n('longer is better') ) )?>

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
<?=form_close()?>