<?php

include $_SERVER['DOCUMENT_ROOT'].'/../config.php';

$name = $username = $password = $email = $bday = $ivao = $vatsim = $response = null;

// if form was submitted, process registration
if (isset($_POST['register']) and $_POST['register'] = true) {

	$name = $_POST['name'];
	$email = $_POST['email'];
	$username = $_POST['username'];
	$password = $_POST['password'];
	$confirm = $_POST['confirm'];
	$bday = $_POST['BornDate'];
	$ivao = $_POST['ivao_cid'];
	$vatsim = $_POST['vatsim_cid'];

	// check if passwords match
	if ($password != $confirm) {

		$response = 'no_match';

	} else {

		// google recaptcha
		if (isset($_POST['g-recaptcha-response']))
			$captcha = $_POST['g-recaptcha-response'];
		else
			$captcha = 'fail';

		if (!$captcha)
			$captcha = 'fail';
		$secretKey = '6Le68HEUAAAAAKh4tJRS_f-BfrLE43_zG0kjMYJN';
		$ip = $_SERVER['REMOTE_ADDR'];
		$reCaptcha = file_get_contents('https://www.google.com/recaptcha/api/siteverify?secret='.$secretKey.'&response='.$captcha.'&remoteip='.$ip);
		$responseKeys = json_decode($reCaptcha,true);

		// check recaptcha status
		if (intval($responseKeys['success']) !== 1){
			$captcha = 'fail';
		} else {

			// make the registration
			$response = $sso->add_user($name, $email, $username, $password, $bday, $ivao, $vatsim, 'pending');

			if ($response == 'success') {

				// send confirmation email
				$mail_status = $sso->send_email('verification', $username, 'Welcome to MultiCrew! Please verify your email!');

				// redirect or present error msg
				if ($mail_status == 'success')
					header('location: index.php?v=t');
				else
					die('There was an error sending you an email...<br>Please contact us at admin@multicrew.co.uk.');

			}

		}

	}

}

$title = ' - Portal';
$global_section = 'portal';
$page = 'register';
include $_SERVER['DOCUMENT_ROOT'].'/../global_header.php';

?>

<div class="container-fluid">

	<div class="row">

		<div class="col-lg-3 col-md-2 col-xs-1"></div>

		<div class="col-lg-6 col-md-8 col-xs-10">

			<div class="card mx-auto my-5">

				<h1 class="card-header text-center">Register</h1>

				<div class="card-body">

					<form action="" method="POST" class="card-text">

						<div class="alert alert-danger <?php if ($response != "username_exists") { echo "d-none"; } ?>">
							An account already exists with that username! Perhaps you meant to <a href="/">log in</a>?
						</div>

						<?php if (isset($captcha) && $captcha == 'fail') { ?>
							<div class="alert alert-danger">
								<strong>Captcha failed!</strong> Please check the reCaptcha box to verify you are not a spammer.
							</div>
						<?php } ?>

						<div class="form-group">
							<div class="input-group">
								<div class="input-group-prepend">
									<span class="input-group-text"><i class="fas fa-fw fa-user"></i></span>
								</div>
								<input type="text" name="name" id="name" class="form-control" placeholder="Full name" required value="<?php echo $name; ?>">
							</div>
						</div>

						<div class="alert alert-danger <?php if ($response != "email_exists") { echo "d-none"; } ?>">
							An account already exists for that email address! Perhaps you meant to <a href="/">log in</a>?
						</div>

						<div class="form-group">
							<div class="input-group">
								<div class="input-group-prepend">
									<span class="input-group-text"><i class="fas fa-fw fa-envelope"></i></span>
								</div>
								<input type="email" name="email" id="email" class="form-control" placeholder="Email address" required value="<?php echo $email; ?>">
							</div>
						</div>

						<div class="form-group">
							<div class="input-group">
								<div class="input-group-prepend">
									<span class="input-group-text"><i class="fas fa-fw fa-users"></i></span>
								</div>
								<input type="text" name="username" id="username" class="form-control" pattern="^[A-Za-z0-9_]{1,15}$" placeholder="Username" required value="<?php echo $username; ?>">
							</div>
						</div>

						<div class="alert alert-danger <?php if ($response != "no_match") { echo "d-none"; } ?>">
							Passwords do not match!
						</div>

						<div class="form-group">
							<div class="input-group">
								<div class="input-group-prepend">
									<span class="input-group-text"><i class="fas fa-fw fa-key"></i></span>
								</div>
								<input type="password" name="password" id="password" class="form-control" placeholder="Password" required value="<?php echo $password; ?>">
							</div>
						</div>

						<div class="form-group">
							<div class="input-group">
								<div class="input-group-prepend">
									<span class="input-group-text"><i class="fas fa-fw fa-key"></i></span>
								</div>
								<input type="password" name="confirm" id="confirm" class="form-control" placeholder="Confirm password" required>
							</div>
						</div>

						<div class="form-group">
							<div class="input-group">
								<div class="input-group-prepend">
									<span class="input-group-text"><i class="fas fa-fw fa-calendar"></i></span>
								</div>
								<input type="date" name="BornDate" id="BornDate" class="form-control" placeholder="Confirm password" value="<?php echo $bday; ?>" required>
							</div>
						</div>

						<div class="form-group">
							<div class="input-group">
								<div class="input-group-prepend">
									<span class="input-group-text"><i class="fas fa-fw fa-globe"></i></span>
								</div>
								<input type="text" name="vatsim_cid" id="vatsim_cid" class="form-control" placeholder="VATSIM CID" value="<?php echo $vatsim; ?>">
							</div>
						</div>

						<div class="form-group">
							<div class="input-group">
								<div class="input-group-prepend">
									<span class="input-group-text"><i class="fas fa-fw fa-plane"></i></span>
								</div>
								<input type="text" name="ivao_cid" id="ivao_cid" class="form-control" placeholder="IVAO ID" value="<?php echo $ivao; ?>">
							</div>
						</div>

						<div class="custom-control custom-checkbox my-2">
							<input type="checkbox" class="custom-control-input" id="terms" required>
							<label class="custom-control-label" for="terms">
								By checking this box, you agree to all of our policies laid out on our <a href="https://www.multicrew.co.uk/policies.php" target="_blank"><i class="fas fa-external-link-alt"></i> Terms and Policies page</a>.
							</label>
						</div>

						<div class="g-recaptcha" data-sitekey="6Le68HEUAAAAAG88KJTiGi-_1CHIHtftD73lpx6d"></div>

						<button type="submit" name="register" class="btn btn-primary btn-lg btn-block mt-3" value="true">Register</button>
						<p class="form-text text-muted text-center card-text">
							Already have an account? <a href="/">Log in</a>.
						</p>

					</form>

				</div>

			</div>

		</div>

		<div class="col-lg-3 col-md-2 col-xs-1"></div>

	</div>

</div>

<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.6/umd/popper.min.js" integrity="sha384-wHAiFfRlMFy6i5SRaxvfOCifBUQy1xHdJ/yoi7FRNXMRBu5WHdZYu1hA6ZOblgut" crossorigin="anonymous"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.2.1/js/bootstrap.min.js" integrity="sha384-B0UglyR+jN6CkvvICOB2joaf5I4l3gm9GU6Hc1og6Ls7i6U/mkkaduKaBhlAXv9k" crossorigin="anonymous"></script>

</body>
</html>
