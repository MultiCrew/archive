<?php

$sect = 'copilot';
$title = ' - Copilot';

require_once('/var/www/portal/core.php');
if ($sso->logged_in()) {
	$hdrLoggedIn=true;
} else {
	header('LOCATION: https://portal.multicrew.co.uk/?rd=copilot');
	die();
}

require_once('../html/header.php');

?>

<div class="container-fluid px-4">

	<h1 class="display-2 text-center">Copilot</h1>

	<?php $tab = ''; require_once('includes/tabs.php'); ?>

		<p class="text-center">Copilot works closely with our MTC Copilot Bot which runs on our Discord server.</p>
		<p class="text-center">To use Copilot, you must join our Discord server and link your accounts.</p>
		<p class="text-center">Get started by <a href="https://discord.gg/3jHRAkE">joining our Discord server</a> or <a class="https://portal.multicrew.co.uk/">visiting Portal</a>.</p>

	</div>

</div>

<?php $call = 'copilot'; include $_SERVER['DOCUMENT_ROOT'].'/../footer_plain.php'; ?>
