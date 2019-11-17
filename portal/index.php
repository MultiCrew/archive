<?php

include $_SERVER['DOCUMENT_ROOT'].'/../config.php';

$login_status = null;
$redirect = "dashboard";

if (isset($_GET['rd'])) {
	if ($_GET['rd'] == "academy")
		$redirect = PROTOCOL.'://academy.'.DOMAIN.'/sys/dashboard.php';
	elseif ($_GET['rd'] == "copilot" and isset($_GET['ofp']))
		$redirect = PROTOCOL.'://copilot.'.DOMAIN.'/dispatch/export.php?ofp_id='.$_GET['ofp'];
	elseif ($_GET['rd'] == "copilot")
		$redirect = PROTOCOL.'://copilot.'.DOMAIN.'/index.php';
} /*elseif (isset($_SERVER['HTTP_REFERER'])){
	$redirect = $_SERVER['HTTP_REFERER'];
}*/ else {
	$redirect = 'dashboard/index.php';
}

if (isset($_POST['sign_in']) && $_POST['sign_in'] == true) {

	if (isset($_POST['remember']) && $_POST['remember'] == 'true') {
	  $remember = true;
	} else {
	  $remember = false;
	}

	$login_status = $sso->log_in($_POST['user'], "manual" ,$_POST['pass'], $remember);
	$redirect = $_POST['redirect'];

}

if ($sso->logged_in()) {
	header('LOCATION: '.$redirect);
	die();
}

$user_email = null;

if (isset($_SESSION['temp_email'])) {
  $user_email = $_SESSION['temp_email'];
}

$title = ' - Portal';
$global_section = 'portal';
$page = 'login';
include $_SERVER['DOCUMENT_ROOT'].'/../global_header.php';

?>

<div class="container-fluid">

	<div class="row">

		<div class="col-lg-3 col-md-2 col-xs-1"></div>

		<div class="col-lg-6 col-md-8 col-xs-10">

			<div class="card mx-auto mt-5">

				<h1 class="card-header text-center">MultiCrew Portal</h1>

				<div class="card-body">

					<?php if (isset($_GET['v']) and $_GET['v'] == 't') { ?>
						<div class="alert alert-success"><strong>Nearly there!</strong> Check your emails to verify your account.</div>
					<?php } elseif ($login_status == "no_user" or $login_status == "bad_pass") { ?>
						<div class="alert alert-danger">Your username or password is incorrect.</div>
					<?php } elseif ($login_status == "not_verified") { ?>
						<div class="alert alert-warning">
							You have not verified your email<br>
							<strong><?php echo $user_email; ?></strong> &middot; <a href="resend_email">Re-send</a>
						</div>
					<?php } elseif (isset($_GET['e']) and $_GET['e'] == "s") { ?>
						<div class="alert alert-primary">Email has been sent.</div>
					<?php } elseif (isset($_GET['v']) and $_GET['v'] == "d") { ?>
						<div class="alert alert-success">You've verified your email! You can now log in.</div>
					<?php } ?>

					<form action="" method="POST">

						<span id="reauth-email" class="reauth-email"></span>

						<div class="form-group">
							<input type="text" id="inputEmail" name="user" class="form-control" placeholder="Username or email address" required autofocus>
						</div>

						<div class="form-group">
							<input type="password" id="inputPassword" name="pass" class="form-control" placeholder="Password" required>
						</div>

						<div class="custom-control custom-checkbox" id="remember">
							<input type="checkbox" class="custom-control-input" name="remember" checked>
							<label class="custom-control-label">Remember me</label>
						</div>

						<input type="hidden" name="redirect" value="<?php echo $redirect; ?>">

						<button type="submit" name="sign_in" class="btn btn-lg btn-primary btn-block mt-3" value="true">Log In</button>
						<p class="form-text text-muted text-center card-text">
							<a href="register">Create an account</a> &middot; <a href="/forgot">Forgot password</a>
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
