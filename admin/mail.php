<?
require_once 'mail.phpc';
$email = new email();
echo <<<MAIL
	<div id='email'>
		{$email->HTML}
	</div>
MAIL;
?>
