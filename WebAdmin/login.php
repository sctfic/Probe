<form action="?" class='container' method="get" id="authentification" >
    <fieldset class='login'>
    <?php
        // if user already tried one authentification and come back to this page, it means its credentials are not correct
        $messages = null;
        if (isset($_GET['password'])) {
            $messages[] = sprintf(_('The %s you used is incorrect.'), _('password'));
        }
        if (isset($_GET['login'])) {
            $messages[] = sprintf(_('The %s you used is incorrect.'), _('login'));
        }

        if (count($messages)>0) {
            echo "<ul class='error-list'>";
            foreach ($messages as $msg)
            {
                echo sprintf('<li>%s</li>', $msg);
            }
            echo '</ul>';
        }
?>

    <label for='username'><?php echo _('username')._('&nbsp;'); ?>:</label>
        <input type="text" name="username" id="username" />
    <label for='password'><?php echo _('password')._('&nbsp;'); ?>:</label>
        <input type="password" name="password" id="password" />
    <?php
        if (empty($WsWdsConfig['AdminInterface']['Username'])
            && empty($WsWdsConfig['AdminInterface']['Password'])
        ) { ?>
            <label for='confirm'><?php echo _('password confirmation')._('&nbsp;'); ?>:</label>
            <input type="password" name="confirm" id="confirm" />
    <?php } ?>
    </fieldset>
    <input type="submit" class='btn' value="<?php echo _('login'); ?>" />
            <!--keygen name="security" /-->

</form>
