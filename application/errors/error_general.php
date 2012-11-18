<?php if (isset($_SERVER['REMOTE_ADDR'])) {

	$title = $message['error-title'];
	$author = 'Probe';
	$description = 'General Error';
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

			<?php if (!empty($message['error-solution'])): ?>
				<div class="alert alert-block alert-info">
					<!-- <i class="icon-white icon-ok"></i> -->
					<?php echo $message['error-solution']; ?>
				</div>	
			<?php endif; ?>
			</div>	
			<!-- <div class="modal-footer"> </div> -->
		</div>
	</div>	
<?php }
 ?>
</body>
</html>
