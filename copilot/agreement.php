<?php

$sect = 'copilot';
$title = ' - Copilot';
$page = 'agreement';

require_once('/var/www/portal/core.php');
if ($sso->logged_in()) {
	$hdrLoggedIn=true;
} else {
	header('LOCATION: https://copilot.multicrew.co.uk/index.php');
	die();
}

if ($sso->get_user_data('copilotAgree')) {
	header('LOCATION: https://copilot.multicrew.co.uk/index.php');
	die();
}

require_once('assets/layout/header.php');

?>

<h1>User Agreement</h1>

<p>Before using copilot, you must agree to the following User Agreement. This is to ensure security of all devices belonging to users who use Copilot. Computer security is extremely important when flying with a shared cockpit, and you can read more about it on the <a href="https://academy.multicrew.co.uk/general/security.php">MultiCrew Academy</a>.</p>

<div class="card w-75 mx-auto mb-3">

	<div class="card-body">

		<div class="card-text">

			<h5>Networking</h5>
			<p>Sometimes, when flying with a shared cockpit, you may create a direct peer-to-peer connection with another computer. This has various implications to the secuirty of both devices, and their networks. By using Copilot, you agree to:</p>
			<ul>
				<li>where possible, use port forwarding to provide maximum possible router firewall protection;</li>
				<li>secure your own home networks with a password-protected router;</li>
				<li>keep all operating system antivirus and firewall software on at least default settings, unless troubleshooting, and to use appropriate rules and exceptions to allow desired connections;</li>
				<li>report violations of these regulations to a member of staff.</li>
			</ul>

			<h5>Simulator Content and Settings</h5>
			<p>It is vital that both pilots share their simulator scenery, weather and nav data settings with each other to ensure a trouble-free connection in a shared cockpit environment. By using Copilot, you also agree to:</p>
			<ul>
				<li>match up with another pilot with the same, or similar, simulator content and settings;</li>
				<li>be truthful about these criteria on your profile;</li>
				<li>keep your profile fields up to date with your simulator and preferences.</li>
			</ul>

			<h5>Troubleshooting</h5>
			<p>It is common for users to experience issues establishing a shared cockpit connection. To resolve these, you agree to:</p>
			<ul>
				<li>have some understanding, technical knowledge and experience with your computer, operating system, software and network;</li>
				<li>install remote desktop connection software, such as TeamViewer, if requested;</li>
				<li>only allow a MultiCrew staff member, mentor, or other personally truster person access to your computer via a remote desktop connection.</li>
			</ul>

			<hr>

			<form action="index.php" method="POST">

				<div class="form-check mb-2">
					<input name="check" type="checkbox" class="form-check-input" required>
					<label class="form-check-label"><span class="text-danger">*</span>I have read and agree to the Copilot User Agreement</label>
				</div>

				<button name="agree" type="submit" class="btn btn-primary">Proceed &raquo;</button>

			</form>

		</div>

	</div>

</div>

<?php $call = 'copilot'; include $_SERVER['DOCUMENT_ROOT'].'/../footer_plain.php'; ?>
