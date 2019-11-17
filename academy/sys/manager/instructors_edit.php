<?php

$tab = 'sys';
$page = 'instr';
include $_SERVER['DOCUMENT_ROOT'].'/assets/layout/header.php';
include $_SERVER['DOCUMENT_ROOT'].'/assets/layout/sidebar_sys.php';

if (isset($_POST['updateinstr'])) {
	$stmt = $mysqli->prepare("UPDATE instr SET `a320`=?, `a330`=?, `dh8d`=?, `b712`=? WHERE `users.id`=?");
	echo(mysqli_error($mysqli));
	$stmt->bind_param("iiiii", $_POST['a320'], $_POST['a330'], $_POST['dh8d'], $_POST['b712'], $_POST['userid']);
	echo(mysqli_error($mysqli));
	$stmt->execute();
	echo(mysqli_error($mysqli));
}

if (isset($_POST['userid'])){
	$stmt = $mysqli->prepare('SELECT * FROM instr WHERE `users.id`=?');
	$stmt->bind_param("i", $_POST['userid']);
	$stmt->execute();
	$result = $stmt->get_result();
	$row = $result->fetch_array();
}
else{
	$academy->redirect('/sys/manager/instructors.php');
}

?>

<h3>Instructors</h3>

<div class="row w-50">

	<div class="col-md-6">

		<div class="form-group">
			<label>Instructor</label>
			<input type="text" class="form-control" disabled value="<?php echo $sso->get_user_data('name', $row['users.id'])?>">
		</div>

	</div>

	<div class="col-md-6">

		<div class="form-group">
			<label>Username</label>
			<input type="text" class="form-control" disabled value="<?php echo $sso->get_user_data('username', $row['users.id'])?>">
		</div>

	</div>

</div>

<h5>Authorised Aircraft</h5>

<form action="" method="POST">

	<div class="row">

		<div class="col-md-3">

			<div class="form-group">
				<label>A320</label>
				<select name="a320" class="custom-select">
					<option value="0" <?php if ($row['a320']=="0") { echo "selected"; } ?>>No</option>
					<option value="1" <?php if ($row['a320']=="1") { echo "selected"; } ?>>Yes</option>
				</select>
			</div>

		</div>

		<div class="col-md-3">

			<div class="form-group">
				<label>A330</label>
				<select name="a330" class="custom-select">
					<option value="0" <?php if ($row['a330']=="0") { echo "selected"; } ?>>No</option>
					<option value="1" <?php if ($row['a330']=="1") { echo "selected"; } ?>>Yes</option>
				</select>
			</div>

		</div>

		<div class="col-md-3">

			<div class="form-group">
				<label>DH8D</label>
				<select name="dh8d" class="custom-select">
					<option value="0" <?php if ($row['dh8d']=="0") { echo "selected"; } ?>>No</option>
					<option value="1" <?php if ($row['dh8d']=="1") { echo "selected"; } ?>>Yes</option>
				</select>
			</div>

		</div>

		<div class="col-md-3">

			<div class="form-group">
				<label>B712</label>
				<select name="b712" class="custom-select">
					<option value="0" <?php if ($row['b712']=="0") { echo "selected"; } ?>>No</option>
					<option value="1" <?php if ($row['b712']=="1") { echo "selected"; } ?>>Yes</option>
				</select>
			</div>

		</div>


	</div>

	<p class="mb-3">
		<input type="hidden" name="userid" value="<?php echo $row['users.id']; ?>">
		<button type="submit" name="updateinstr" class="btn btn-primary">Submit</button>
		<button type="reset" class="btn btn-secondary">Cancel</button>
	</p>

</form>

<?php $call = 'academy'; include $_SERVER['DOCUMENT_ROOT'].'/../footer_sys.php'; ?>
