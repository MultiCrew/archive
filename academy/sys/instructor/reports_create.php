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
		$acft = $row1['acft'];
		$stmt = $mysqli->prepare("SELECT `$acft.course` FROM cert WHERE `users.id`=?");
		$stmt->bind_param("i", $row1['users.id']);
		$stmt->execute();
		$result = $stmt->get_result();
		$row2 = $result->fetch_array();
		$prog = $row2[0];
	}
}
else {
	$academy->redirect("reports.php");
}

?>

<h3>Create Report</h3>

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
				<input type="text" class="form-control" value="<?php echo $row1['date']; ?>">
			</div>

			<div class="form-group col">
				<label>Start Time</label>
				<input type="text" class="form-control" value="<?php echo $row1['stime']; ?>">
			</div>

			<div class="form-group col">
				<label>End Time</label>
				<input type="text" class="form-control" value="<?php echo $row1['ftime']; ?>">
			</div>

			<div class="form-group col">
				<label>Aircraft</label>
				<input type="text" class="form-control" value="<?php echo strtoupper($row1['acft']); ?>">
			</div>

		</div>

	</fieldset>

</form>

<form action="reports.php" method="POST">

	<div class="form-group">
		<label>Report</label>
		<textarea name="report" rows="10" class="form-control"></textarea>
	</div>

	<div class="form-group">
		<label>Course Progress</label>
		<select name="progress" class="custom-select">
			<?php for ($i=0; $i < 21; $i++) {
				if (($i*5)==$prog) {
					echo '<option selected value="',($i*5),'">',($i*5),'%</option>';
				}
				else {
				echo '<option value="',($i*5),'">',($i*5),'%</option>';
				}
			} ?>
		</select>
	</div>

	<input type="hidden" class="form-control" name="session" value="<?php echo $row1['id']; ?>">

	<p>
		<input type="submit" class="btn btn-primary" name="submit">
		<a href="reports.php" class="btn btn-secondary">Cancel</a>
	</p>

</form>

<?php $call = 'academy'; include $_SERVER['DOCUMENT_ROOT'].'/../footer_sys.php'; ?>
