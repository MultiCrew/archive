<?php

$sect = 'copilot';
$title = ' - Support';
$page = 'support';

require_once('/var/www/copilot/assets/includes/core.php');

if (isset($_POST['send']) && $_POST['send']) {
	$response = $copilot->new_support($sso, $_POST);
	if ($response == false) { $mail_fail = true; } else { $mail_sent = true; }
}

?>

<h3 class="text-center"><i class="fas fa-info-circle"></i> &nbsp;Support</h3>

<p>The <a href="https://academy.multicrew.co.uk/">MultiCrew Academy</a> contains several pages and resources to help you set up and troubleshoot stable and secure shared cockpit connections. Many common questions and problems can be answered or solved from these resources, so we <strong>require</strong> that you have read through and followed these in great detail before requesting any support.</p>

<p>However, should you still require assistance, please use the following form to create a formal support request (further communication will be via the email address linked to your MultiCrew Portal account). You can also get more instant support from the #support-requests channel in our <a href="https://discord.gg/3jHRAkE">Discord server</a>.</p>

<p>You may also use this form to report Copilot system bugs. Please select "Bug Report" from the help Category dropdown. <strong>Please only report bugs with MultiCrew's services!</strong></p>

<p class="text-danger"><strong>Please <em>do not</em> report bugs relating to aircraft addons here. We do not develop these addons and <em>cannot</em> help you with those. Direct these to the relevant developer's customer support system.</strong></p>

<?php if (isset($mail_fail) && $mail_fail) { ?>
	<div class="alert alert-danger">
		An error occurred whilst sending your support form. Please try again later or contact an administrator.
	</div>
<?php } elseif (isset($mail_sent) && $mail_sent) { ?>
	<div class="alert alert-success">
		Your support form has been submitted! The support team will be in contact shortly to help you.
	</div>
<?php } ?>

<form action="" method="POST">

	<div class="form-group">
		<label>Category</label>
		<select class="form-control" name="category" id="category" required onchange="catChange()">
			<option disabled selected value>Select...</option>
			<option value="support">Support Request</option>
			<option value="bug">Bug Report</option>
			<option value="suggestion">Suggestion</option>
		</select>
	</div>

	<div class="form-group">
		<label>Subject</label>
		<select class="form-control" name="subject" id="subject" required>
			<option disabled selected value>Please select a category first</option>
		</select>
	</div>

	<div class="form-group">
		<label>Message</label>
		<textarea class="form-control" name="msg" rows="7" required></textarea>
	</div>

	<p>Due to security reasons, if you wish to include a log output, for example, please use a service such as <a href="https://pastebin.com/">https://pastebin.com/</a>. For images, please use a service such as <a href="https://imgur.com/">https://imgur.com/</a>.</p>

	<div class="form-group mt-2 mb-3">
		<small class="form-text text-muted mb-2">By clicking submit, you agree to be contacted at your MultiCrew Portal registered email address regarding your support query.</small>
		<input type="submit" name="send" value="Submit" class="btn btn-primary">
	</div>

</form>

<?php require_once('/var/www/copilot/assets/layout/footer.php'); ?>

<script>

	function addOption(txt, val, def, sel,){
		var select = document.getElementById('subject');
		select.options[select.options.length] = new Option(txt, val, def, sel);
	}

	function removeAllOptions(){
		var select = document.getElementById('subject');
		select.options.length = 0;
	}

	function catChange() {

		var sel = document.getElementById('category');
		var selOpt = sel.options[sel.selectedIndex].value;

		if (selOpt == 'support') {

			removeAllOptions();

			addOption('Select...', 0, false, false);
			document.getElementById('subject').options[0].disabled = true;
			document.getElementById('subject').options[0].selected = true;
			document.getElementById('subject').options[0].value = '';
			addOption('Operating Procedures', 'ops', false, false);
			addOption('General Software', 'software', false, false);
			addOption('General Hardware', 'hardware', false, false);
			addOption('Connection', 'conn', false, false);
			addOption('Security', 'sec', false, false);
			addOption('Other', 'other', false, false);

		} else if (selOpt == 'bug') {

			removeAllOptions();

			addOption('Select...', 0, false, false);
			document.getElementById('subject').options[0].disabled = true;
			document.getElementById('subject').options[0].selected = true;
			document.getElementById('subject').options[0].value = '';
			addOption('Copilot', 'copilot', false, false);
			addOption('Academy', 'academy', false, false);
			addOption('Forums', 'forums', false, false);
			addOption('Other', 'other', false, false);

		} else if (selOpt == 'suggestion') {

			removeAllOptions();

			addOption('Select...', 0, false, false);
			document.getElementById('subject').options[0].disabled = true;
			document.getElementById('subject').options[0].selected = true;
			document.getElementById('subject').options[0].value = '';
			addOption('Copilot', 'copilot', false, false);
			addOption('Academy', 'academy', false, false);
			addOption('Forums', 'forums', false, false);
			addOption('Other', 'other', false, false);

		}

	}

</script>
