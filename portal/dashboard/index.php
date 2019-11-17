<?php

include $_SERVER['DOCUMENT_ROOT'].'/../config.php';

if (!$sso->logged_in()) {
	header("LOCATION: /");
	die();
}

$page = 'dashboard';
include '../assets/layout/header.php';

?>

<h1 class="display-1">Hello, <?php echo $sso->get_user_data("first_name"); ?>.</h1>

<p class="lead">Welcome to MultiCrew Portal, our Single Sign On (SSO) system. Your Portal account unlocks all of MultiCrew's services!</p>
<p class="text-muted">More will be added here in future!</p>

<?php if ($sso->get_user_data("discord")=="") { ?>
	<div class="alert alert-warning mt-4">
		You haven't set up a Discord ID in your MultiCrew profile. Without it, you won't have access to the bulk of our Discord server!
		<hr>
		<a href="https://discord.gg/3jHRAkE">Join our server</a> and type <kbd>!myid</kbd> into the <samp>#roles</samp> channel. Then, copy and paste the 18-digit number into the "Discord ID" field of your <a href="/Account">profile</a>.
	</div>
<?php } ?>

<?php include '../assets/layout/footer.php'; ?>
