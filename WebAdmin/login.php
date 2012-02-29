<body class="login">
    <form action="?" class='container' method="get" id="authentification" >
        <fieldset>
        <?php
            // if user already tried one authentification and come back to this page, it means its credentials are not correct
            $fieldsStatus = null;
            if (isset($_GET['password'])) {
                $fieldsStatus['password']['label'] = sprintf(_('The %s you used is incorrect.'), _('password'));
                $fieldsStatus['password']['status'] = 1; // error by default
            }
            if (isset($_GET['username'])) {
                $fieldsStatus['username']['label'] = sprintf(_('The %s you used is incorrect.'), _('username'));
                $fieldsStatus['username']['status'] = 1; // error by default
            }

            if (count($fieldsStatus)>0) {
                echo "<ul class='form-errors'>";
                foreach ($fieldsStatus as $fieldName => $fieldInfo)
                {
                    echo sprintf('<li%s>%s</li>', getStatus($fieldInfo), $fieldInfo['label']);
                }
                echo '</ul>';
            }

            function getStatus($fieldInfo) {
                $class = null;
                if ($fieldInfo['status']!=0) {
                    $class = ' class="error"';
                }
                return $class;
            }
    ?>

        <label for='username'><?php echo _('username')._('&nbsp;'); ?>:</label>
            <input type="text" name="username" id="username" />
        <label for='password'><?php echo _('password')._('&nbsp;'); ?>:</label>
            <input type="password" name="password" id="password" <?php echo getStatus('password'); ?>/>
        <?php
            if (empty($WsWdsConfig['AdminInterface']['Username'])
                && empty($WsWdsConfig['AdminInterface']['Password'])
            ) { ?>
                <label for='confirm'><?php echo _('password confirmation')._('&nbsp;'); ?>:</label>
                <input type="password" name="confirm" id="confirm" <?php echo getStatus('username'); ?>/>
        <?php } ?>
        </fieldset>
        <input type="submit" class='btn' value="<?php echo _('login'); ?>" />
                <!--keygen name="security" /-->

    </form>
</body>