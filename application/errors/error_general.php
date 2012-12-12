<?php
/**
* Main error page
*
* @category Template
* @package  Probe
* @author   Édouard Lopez <dev+probe@edouard-lopez.com>
* @license  http://creativecommons.org/licenses/by-nc-sa/3.0/legalcode CC-by-nc-sa-3.0
* @link     http://probe.com/doc
 */

if (isset($_SERVER['REMOTE_ADDR'])) {

    $title = $message['error-title'];
    $author = 'Probe';
    $description = 'General Error';
    $viewer = false;
    require_once APPPATH.'views/templates/header.php';
    ?>

    <body>
        <div class="container">
          <div class="modal">
              <h1 class="modal-header"><?php echo $heading; ?></h1>
                <div class="modal-body">
                    <div class="alert alert-block alert-error">
                        <!-- <i class="icon-white icon-exclamation-sign"></i> -->
                        <?php echo is_array($message) ? $message['error-description'] : $message; ?>
                    </div>

                    <?php if (!empty($message['error-solution'])) : ?>
                    <div class="alert alert-block alert-info">
                        <!-- <i class="icon-white icon-ok"></i> -->
                        <?php echo $message['error-solution']; ?>
                    </div>
                    <?php endif; ?>
                </div>
                <!-- <div class="modal-footer"> </div> -->
            </div>
        </div>
    </body>
    <?php
    require_once APPPATH.'views/templates/footer.php';

}
?>
</html>
