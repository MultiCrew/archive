<?php

include $_SERVER['DOCUMENT_ROOT'].'/../config.php';

$the_db = $sso->db;

if (!$sso->logged_in()) {
	header("LOCATION: /");
	die();
}

if (isset($_POST['change_profile']) and $_POST['change_profile']) {

	if (isset($_POST['password'])) {

		if ($_POST['password'] == '') {

			$password = $sso->get_user_data("password");

		} else {

			if ($_POST['password'] == $_POST['password-confirm'])
				$password = password_hash($_POST['password'], PASSWORD_DEFAULT);
			else
				$password_falsematch = true;

		}

	} else {
		$password = $sso->get_user_data("password");
	}

	if ($_POST['email'] == $_POST['confemail']) {

		if ($sso->get_user_data('discord')!=$_POST['discord']) {

			$newdiscord = $_POST['discord'];
			$data = 'roles,'.$sso->get_user_data('type').','.$newdiscord;
			set_time_limit(5);
			if (($socket = socket_create(AF_INET, SOCK_STREAM, 0)) === false) die("Could not create socket\n");
			socket_bind($socket, "127.0.0.1");
			if (($connection = socket_connect($socket, "127.0.0.1", 9001)) === false) die("Could not connect to server\n");
			if (socket_write($socket, $data)) {	} else die("Error seding data");
			socket_close($socket);

		}

		$update_status = $sso->update_user($sso->get_user_data("id"), $_POST['name'], $_POST['email'], $sso->get_user_data("username"), $password, $sso->get_user_data("birthday"), $_POST['ivao'], $_POST['vatsim'], $sso->get_user_data("type"), $_POST['discord']);

	} else {
		$email_falsematch = true;
	}

} elseif (isset($_POST['submitPic']) and $_POST['submitPic']) {

	$target_dir = $_SERVER['DOCUMENT_ROOT'].'/pic/';
	$target_file = $target_dir.basename($_FILES["pic"]["name"]);
	$uploadOk = 1;
	$imageFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));

	// check if file is an actual image
	$check = getimagesize($_FILES["pic"]["tmp_name"]);
	if($check == false) {
		$notimg = true;
		$uploadOk = 0;
	}

	// check file size
	if ($_FILES["pic"]["size"] > 500000) {
		$toobig = true;
		$uploadOk = 0;
	}

	// check file type
	if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg"
	&& $imageFileType != "gif" ) {
		$wrongtype = true;
		$uploadOk = 0;
	}

	// check if $uploadOk is not  0 and upload
	if ($uploadOk == 0) {
		$othererr = true;
	} else {
		if (move_uploaded_file($_FILES["pic"]["tmp_name"], $target_dir.$sso->get_user_data('username').'.'.$imageFileType)) {
			$the_db->query('UPDATE users SET pic="'.$imageFileType.'" WHERE id='.$sso->get_user_data('id'));
			$updated = true;
		} else {
			$othererr = true;
		}
	}

} elseif (isset($_GET['del'])) {

	$target_dir = $_SERVER['DOCUMENT_ROOT'].'/pic/';
	foreach ($the_db->query('SELECT pic FROM users WHERE id='.$sso->get_user_data('id')) as $row) {
		$ext = $row['pic'];
		$file = $sso->get_user_data('username').'.'.$ext;
	}
	unlink($target_dir.$file);
	$the_db->query('UPDATE users SET pic="" WHERE id ='.$sso->get_user_data('id'));
	$deleted = true;

}

$sso->custom_js = true;

$page = 'account';
include '../assets/layout/header.php';

?>

<h1 class="display-1">Account</h1>

<div class="row">

	<div class="col-md-4">

		<div class="card">

			<h3 class="card-header">Profile Picture</h3>

			<div class="card-body">

				<?php

				foreach ($the_db->query('SELECT pic FROM users WHERE id='.$sso->get_user_data('id')) as $row) {
					$ext = $row['pic'];
					$file = $sso->get_user_data('username').'.'.$ext;
				}

				if ($ext!='' && file_exists($_SERVER['DOCUMENT_ROOT'].'/pic/'.$file)) { ?>
					<div class="rounded-circle mx-auto img-thumbnail" style="background: url(<?= PROTOCOL.'://portal.'.DOMAIN.'/pic/'.$file; ?>); background-repeat: no-repeat; background-size: auto 200px; background-position: center; height: 200px; width: 200px;"></div>
				<?php } else { ?>
					<div class="rounded-circle mx-auto img-thumbnail" style="background: url(<?= PROTOCOL.'://portal.'.DOMAIN.'/pic/default.png' ?>); background-repeat: no-repeat; background-size: auto 200px; background-position: center; height: 200px; width: 200px;"></div>
				<?php } ?>

				<form action="" method="POST" enctype="multipart/form-data" class="mt-3 card-text">

					<?php if (isset($updated)) { ?>
						<div class="alert alert-success alert-dismissible fade show" role="alert">
							Profile picture updated!
							<button type="button" class="close" data-dismiss="alert" aria-label="Close">
								<span aria-hidden="true">&times;</span>
							</button>
						</div>
					<?php } elseif (isset($toobig)) { ?>
						<div class="alert alert-danger alert-dismissible fade show" role="alert">
							File size is too big! Max. file size is 500KB.
							<button type="button" class="close" data-dismiss="alert" aria-label="Close">
								<span aria-hidden="true">&times;</span>
							</button>
						</div>
					<?php } elseif (isset($wrongtype)) { ?>
						<div class="alert alert-danger alert-dismissible fade show" role="alert">
							File format is not valid. Acceptable file types are: .png, .jpg, .jpeg, .gif
							<button type="button" class="close" data-dismiss="alert" aria-label="Close">
								<span aria-hidden="true">&times;</span>
							</button>
						</div>
					<?php } elseif (isset($notimg)) { ?>
						<div class="alert alert-danger alert-dismissible fade show" role="alert">
							That file doesn't appear to be an image. The file may be corrupt.
							<button type="button" class="close" data-dismiss="alert" aria-label="Close">
								<span aria-hidden="true">&times;</span>
							</button>
						</div>
					<?php } elseif (isset($toobig)) { ?>
						<div class="alert alert-danger alert-dismissible fade show" role="alert">
							File size is too big! Max. file size is 500KB.
							<button type="button" class="close" data-dismiss="alert" aria-label="Close">
								<span aria-hidden="true">&times;</span>
							</button>
						</div>
					<?php } elseif (isset($othererr)) { ?>
						<div class="alert alert-danger alert-dismissible fade show" role="alert">
							An error occurred during the file upload. Please try again.
							<button type="button" class="close" data-dismiss="alert" aria-label="Close">
								<span aria-hidden="true">&times;</span>
							</button>
						</div>
					<?php } elseif (isset($deleted)) { ?>
						<div class="alert alert-warning alert-dismissible fade show" role="alert">
							Your profile picture has been deleted.
							<button type="button" class="close" data-dismiss="alert" aria-label="Close">
								<span aria-hidden="true">&times;</span>
							</button>
						</div>
					<?php } ?>

					<div class="custom-file">
						<input type="file" name="pic" class="custom-file-input" required>
						<label class="custom-file-label">New picture</label>
						<small class="form-text text-muted">Max. file size 500KB. Recommended 200x200 pixels.</small>
					</div>

					<input type="submit" name="submitPic" value="Submit" class="btn btn-primary mt-3">
					<a class="btn btn-secondary mt-3" href="index.php?page=picture&del=true">Remove Picture</a>

				</form>

			</div>

		</div>

	</div>

	<div class="col-md-8">

		<div class="card">

			<h3 class="card-header">Account Details</h3>

			<div class="card-body">

				<?php if(isset($email_falsematch) && $email_falsematch) { ?>
					<div class="alert alert-warning alert-dismissible fade show">
						Emails do not match!
						<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
					</div>
				<?php } elseif(isset($password_falsematch) && $password_falsematch) { ?>
					<div class="alert alert-warning alert-dismissible fade show">
						Passwords do not match!
						<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
					</div>
				<?php } elseif(isset($update_status) && $update_status == 'success') { ?>
					<div class="alert alert-success alert-dismissible fade show">
						Profile updated!
						<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
					</div>
				<?php } ?>

				<form action="/account" method="POST">

					<div class="row">
						<div class="col-lg-6">
							<div class="form-group">
								<label data-toggle="tooltip" data-placement="top" title="Email admin@multicrew.co.uk to change this">Username <i class="fas fa-fw fa-info-circle"></i></label>
								<input type="text" class="form-control" placeholder="Joe Bloggs" readonly autocomplete="off" value="<?php echo $sso->get_user_data("username"); ?>">
							</div>
						</div>
						<div class="col-lg-6">
							<div class="form-group">
								<label for="name">Full Name</label>
								<input type="text" name="name" class="form-control" placeholder="Your real first and last name" required autocomplete="off" value="<?php echo $sso->get_user_data("name"); ?>">
							</div>
						</div>
					</div>

					<div class="row">
						<div class="col-lg-6">
							<div class="form-group">
								<label>Email</label>
								<input type="email" name="email" class="form-control" placeholder="joebloggs@example.com" required autocomplete="off" value="<?php echo $sso->get_user_data("email"); ?>">
							</div>
						</div>
						<div class="col-lg-6">
							<div class="form-group">
								<label>Confirm Email</label>
								<input type="email" name="confemail" class="form-control" placeholder="joebloggs@example.com" required autocomplete="off" value="<?php echo $sso->get_user_data("email"); ?>">
							</div>
						</div>
					</div>

					<hr>

					<div class="row">
						<div class="col-md-6">
							<div class="form-group">
								<label>VATSIM CID</label>
								<input type="text" class="form-control" name="vatsim" autocomplete="off" value="<?php echo $sso->get_user_data("vatsim"); ?>">
							</div>
						</div>
						<div class="col-md-6">
							<div class="form-group">
								<label>IVAO CID</label>
								<input type="text" class="form-control" name="ivao" autocomplete="off" value="<?php echo $sso->get_user_data("ivao"); ?>">
							</div>
						</div>
					</div>

					<div class="row">
						<div class="col-md-6">
							<div class="form-group">
								<label data-toggle="tooltip" data-placement="top" title="Email admin@multicrew.co.uk to change this">Date of Birth <i class="fas fa-fw fa-info-circle"></i></label>
								<input type="text" class="form-control" placeholder="Your date of birth" readonly autocomplete="off" value="<?php echo date("F j, Y", strtotime($sso->get_user_data("birthday"))); ?>">
							</div>
						</div>
						<div class="col-md-6">
							<div class="form-group">
								<label data-toggle="tooltip" data-placement="top" title="Paste your Discord ID here for server perms">Discord ID <i class="fas fa-fw fa-info-circle"></i>
								</label>
								<input type="text" class="form-control" name="discord" autocomplete="off" value="<?php echo $sso->get_user_data("discord"); ?>">
							</div>
						</div>
					</div>

					<hr>

					<div class="row">
						<div class="col-md-6">
							<div class="form-group">
								<label>New password</label>
								<input type="password" class="form-control" name="password" autocomplete="off" placeholder="Leave blank to remain unchanged">
							</div>
						</div>
						<div class="col-md-6">
							<div class="form-group">
								<label>Confirm password</label>
								<input type="password" class="form-control" name="password-confirm" autocomplete="off" placeholder="">
							</div>
						</div>
					</div>

					<button type="submit" class="btn btn-primary" name="change_profile" value="true">Update Profile</button>

				</form>

			</div>

		</div>

	</div>

</div>

<?php include '../assets/layout/footer.php'; ?>
