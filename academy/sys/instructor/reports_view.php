<?php

$tab = 'sys';
$page = 'reports';
include $_SERVER['DOCUMENT_ROOT'].'/assets/layout/header.php';
include $_SERVER['DOCUMENT_ROOT'].'/assets/layout/sidebar_sys.php';

if (isset($_POST['session'])){

	$stmt = $mysqli->prepare('SELECT * FROM sessions WHERE id=?');
	$stmt->bind_param("i", $_POST['session']);
	$stmt->execute();

	if ($result = $stmt->get_result()) {
		$row1 = $result->fetch_array();
	}

	$stmt = $mysqli->prepare('SELECT * FROM reports WHERE `sessions.id`=?');
	$stmt->bind_param("i", $_POST['session']);
	$stmt->execute();


	if ($result = $stmt->get_result()) {
		$row2 = $result->fetch_array();
	}

}
else {
	$academy->redirect("reports.php");
}

?>

<h1>View Report</h1>

<form>

	<fieldset disabled>

		<div class="form-row">

			<div class="form-group col">
				<label>Student</label>
				<input type="text" class="form-control" value="<?php echo $sso->get_user_data('name',$row1['users.id']); ?>">
			</div>

			<div class="form-group col">
				<label>Username</label>
				<input type="text" class="form-control" value="<?php echo $sso->get_user_data('username',$row1['users.id']); ?>">
			</div>

			<div class="form-group col">
				<label>Date</label>
				<input type="text" class="form-control" value="<?php echo date_format(new DateTime($row1['date']), 'd M Y'); ?>">
			</div>

			<div class="form-group col">
				<label>Start Time</label>
				<input type="text" class="form-control" value="<?php echo date_format(new DateTime($row1['stime']), 'H:i e'); ?>">
			</div>

			<div class="form-group col">
				<label>End Time</label>
				<input type="text" class="form-control" value="<?php echo date_format(new DateTime($row1['ftime']), 'H:i e'); ?>">
			</div>

			<div class="form-group col">
				<label>Aircraft</label>
				<input type="text" class="form-control" value="<?php echo strtoupper($row1['acft']); ?>">
			</div>

		</div>

	</fieldset>

</form>

<form>

	<fieldset disabled>

		<div class="form-group">
			<label>Report</label>
			<textarea name="sys" rows="10" class="form-control"><?php echo $row2['report']; ?></textarea>
		</div>

	</fieldset>

	<a class="btn btn-secondary" href="reports.php">Back</a>

</form>

<?php $call = 'academy'; include $_SERVER['DOCUMENT_ROOT'].'/../footer_sys.php'; ?>
