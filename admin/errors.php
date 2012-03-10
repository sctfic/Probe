<?php
// include main script
	include "ajax.php";
	require_once 'search.phpc';
// display the <head> html block
	display_head_html();

	echo "<h1>Error {$_REQUEST['e']}</h1>";
// <!-- Bottom navigation bar -->
	navbar('char');


$randimg = rand(1, 5);
$page = $_SERVER['REDIRECT_URL'];
// print_r($_SERVER);

echo <<<BEG
<div id='main-content'>
	<div id='eimg'>
		<img src='_files/images/error{$randimg}.png' alt='error' />
	</div>
	<div>
BEG;

$e401 = <<<BODY
		<p>Sorry, you need to be <em>logged-in</em> to have access to this page.</p>
		<h2>What can you do?</h2>
		<div class='p'>
			Please try one of this action:
			<ul>
				<li>If you don't have an account, <a href='map'>create one</a> and login&thinsp;;</li>
				<li>If you have one, <a href='login'>log-in news</a>&thinsp;;</li>
			</ul>
				<p>Otherwise, you can send me an <a href='contact.php&amp;subject=error401_on_{$page}_page'>email</a> explaining your problem.</p>
BODY;
$e403 = <<<BODY
		<p>Sorry, this ressources is forbidden to you.</p>
		<h2>What can you do?</h2>
		<div class='p'>
			Please try one of this action:
			<ul>
				<li>go to the <a href='map'>previous page</a>&thinsp;;</li>
				<li>go to the <a href='/'>homepage</a>&thinsp;;</li>
			</ul>
				<p>Otherwise, you can send me an <a href='contact.php&amp;subject=error403_on_{$page}_page'>email</a> explaining your problem.</p>
BODY;
$e404 = <<<BODY
		<p>Sorry, the <em>{$page}</em> page <em>doesn't exist</em>.</p>
		<h2>What can you do?</h2>
		<div class='p'>
			Please try one of this action:
			<ul>
				<li>check the <a href='map'>site map</a> to know if this page doesn't really exists&thinsp;;</li>
				<li>look at the <a href='news'>latest news</a> to know if it's a page under construction&thinsp;;</li>
				<li>go to the <a href='/'>homepage</a>&thinsp;;</li>
			</ul>
				<p>Otherwise, you can send me an <a href='contact.php&amp;subject=error404_on_{$page}_page'>email</a> explaining your problem.</p>
BODY;
$e500 = <<<BODY
		<p>Oops! Seem our server got a problem&hellip; Try again later</p>
BODY;

switch ($_REQUEST['e'])
{
	case '401': echo $e401;
		break;
	case '403': echo $e403;
		break;
	case '500': echo $e500;
		break;
	default: echo $e404;
}
echo <<<END
		</div>
	</div>
</div>
END;

?>
</body>
</html>
