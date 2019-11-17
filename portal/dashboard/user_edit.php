<?php

include $_SERVER['DOCUMENT_ROOT'].'/../config.php';
$the_db = $sso->db;

if (!$sso->logged_in() or $sso->get_user_data("type") != "admin") {
	header("LOCATION: /");
	die();
}

if(isset($_POST['editUser']) and $_POST['editUser']) {

	$password = null;
	if ($_POST['password'] != "dontchange")
		$password = password_hash($_POST['password'], PASSWORD_DEFAULT);

	if ($sso->get_user_data('discord', $_POST['id'])!=$_POST['discord'] || $sso->get_user_data('type', $_POST['id'])!=$_POST['type']) {

		$newdiscord = $_POST['discord'];
		$data = 'roles,'.$_POST['type'].','.$newdiscord;

		set_time_limit(5);
		if (($socket = socket_create(AF_INET, SOCK_STREAM, 0)) === false) die("Could not create socket\n");
		socket_bind($socket, "127.0.0.1");
		if (($connection = socket_connect($socket, "127.0.0.1", 9001)) === false) die("Could not connect to server\n");
		if (socket_write($socket, $data)) {	} else die("Error seding data");
		socket_close($socket);

	}

	$sso->update_user($_POST['id'], $_POST['name'], $_POST['email'], $_POST['username'], $password, $_POST['birthday'], $_POST['ivao'], $_POST['vatsim'], $_POST['type'], $_POST['discord']);
	$_SESSION['success'] = true;
	header("LOCATION: Admin");

}

if (isset($_POST['editid']))
	$userID = $_POST['editid'];

$page = 'admin';
include '../assets/layout/header.php';

?>

<h1>Edit User</h1>

<form action="" method="POST">

	<input type="hidden" name="id" value="<?php echo $sso->get_user_data('id', $userID); ?>">

	<div class="row">
		<div class="col-lg-6">
			<div class="form-group">
				<label>Username</label>
				<input type="text" class="form-control" name="username" required value="<?php echo $sso->get_user_data('username', $userID); ?>">
			</div>
		</div>
		<div class="col-lg-6">
			<div class="form-group">
				<label>Email</label>
				<input type="email" class="form-control" name="email" required value="<?php echo $sso->get_user_data('email', $userID); ?>">
			</div>
		</div>
	</div>

	<div class="form-group">
		<label for="name">Full name</label>
		<input type="text" class="form-control" name="name" required value="<?php echo $sso->get_user_data('name', $userID); ?>">
	</div>

	<hr>

	<div class="row">
		<div class="col-md-6">
			<div class="form-group">
				<label>VATSIM CID</label>
				<input type="text" class="form-control" name="vatsim" value="<?php echo $sso->get_user_data('vatsim', $userID); ?>">
			</div>
		</div>
		<div class="col-md-6">
			<div class="form-group">
				<label>IVAO CID</label>
				<input type="text" class="form-control" name="ivao" value="<?php echo $sso->get_user_data('ivao', $userID); ?>">
			</div>
		</div>
	</div>

	<div class="row">
		<div class="col-md-6">
			<div class="form-group">
				<label>Date of Birth</label>
				<input type="date" class="form-control" name="birthday" value="<?php echo $sso->get_user_data('birthday', $userID); ?>">
			</div>
		</div>
		<div class="col-md-6">
			<div class="form-group">
				<label>Discord ID</label>
				<input type="text" class="form-control" name="discord" value="<?php echo $sso->get_user_data('discord', $userID); ?>">
			</div>
		</div>
	</div>

	<hr>

	<div class="form-group">
		<label>Password</label>
		<input type="password" name="password" class="form-control" id="password" value="dontchange">
	</div>

	<div class="form-group">

		<label>User Type</label>

		<select class="form-control" name="type" value = "<?php echo $sso->get_user_data('type', $userID); ?>">

			<?php foreach(
				$the_db->query(
					'SELECT * FROM types ORDER BY rankorder')
					as $row
				) { ?>
				<option value="<?php echo $row['type']; ?>" <?php if ($sso->get_user_data('type', $userID)==$row['type']) { echo 'selected'; } ?>>
					<span class="text-capitalize"><?php echo $row['type']; ?></span>
				</option>
			<?php } ?>

		</select>

	</div>

	<input type="hidden" name="editid" value="<?php echo $userid; ?>">

	<a href="admin.php" class="btn btn-secondary">Cancel</a>
	<button type="submit" class="btn btn-primary" name="editUser" value="true">Update Profile</button>

</form>

<?php include '../assets/layout/footer.php'; ?>
