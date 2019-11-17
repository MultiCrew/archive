<?php

$tab = 'sys';
$page = 'reports';
include $_SERVER['DOCUMENT_ROOT'].'/assets/layout/header.php';
include $_SERVER['DOCUMENT_ROOT'].'/assets/layout/sidebar_sys.php';

if (isset($_POST['submit'])) {

	$stmt = $mysqli->prepare('INSERT INTO reports VALUES (?,?)');
	$stmt->bind_param("is", $_POST['session'], $_POST['report']);
	$stmt->execute();

	$stmt = $mysqli->prepare('UPDATE sessions SET reported=? WHERE id=?');
	$reported = "1";
	$stmt->bind_param("ii", $reported, $_POST['session']);
	$stmt->execute();

	$stmt = $mysqli->prepare('SELECT * FROM sessions WHERE id=?');
	$stmt->bind_param("i", $_POST['session']);
	$stmt->execute();
	$result = $stmt->get_result();
	$row = $result->fetch_array();
	$acft = $row['acft'];

	$stmt = $mysqli->prepare('SELECT * FROM cert WHERE `users.id`=?');
	$stmt->bind_param("i", $row['users.id']);
	$stmt->execute();
	$result = $stmt->get_result();

	if ($result->num_rows==0){
		$stmt = $mysqli->prepare("INSERT INTO cert (`users.id`, `$acft.course`) VALUES(?,?)");
		$stmt->bind_param("ii", $row['users.id'], $_POST['progress']);
		$stmt->execute();
		$stmt->close();
		$academy->send_mail($sso, "[myAcademy] You have a new report", 'report', $row['users.id']);
		$reported = true;

	}

	elseif ($result->num_rows!=0){

		$stmt = $mysqli->prepare("UPDATE cert SET `$acft.course`=? WHERE `users.id`=?");
		$stmt->bind_param("ii", $_POST['progress'], $row['users.id']);
		$stmt->execute();
		$stmt->close();
		$academy->send_mail($sso, "[myAcademy] You have a new report", 'report', $row['users.id']);
		$reported = true;

	}
}

?>

<?php if (isset($reported) && $reported) { ?>

	<div class="alert alert-success alert-dismissable fade show">
		Report added!
		<button type="button" class="close" data-dismiss="alert"><span>&times;</span></button>
	</div>

<?php } ?>

<h3>Pending Reports</h3>

<?php

$sql1 = 'SELECT * FROM sessions WHERE `users.mentor`='.$sso->get_user_data('id').' AND `reported`=0';

if ($res1 = $mysqli->query($sql1)) {

	if ($res1->num_rows!=0) {

		?>

		<table class="table table-hover table-striped">

			<thead class="thead-dark">
				<tr>
					<th>Student</th>
					<th>Username</th>
					<th>Date</th>
					<th>Start Time</th>
					<th>End Time</th>
					<th>Aircraft</th>
					<th></th>
				</tr>
			</thead>

			<tbody>

				<?php while ($row1 = $res1->fetch_array()) { ?>

				<tr>
					<td><?php echo $sso->get_user_data('name',$row1['users.id']); ?></td>
					<td><?php echo $sso->get_user_data('username',$row1['users.id']); ?></td>
					<td><?php echo date_format(new DateTime($row1['date']), 'd M Y'); ?></td>
					<td><?php echo date_format(new DateTime($row1['stime']), 'H:i e'); ?></td>
					<td><?php echo date_format(new DateTime($row1['ftime']), 'H:i e'); ?></td>
					<td><?php echo strtoupper($row1['acft']); ?></td>
					<td>
						<form action="reports_create.php" method="POST">
							<input type="hidden" name="session" value="<?php echo $row1['id']; ?>">
							<input type="submit" class="btn btn-primary btn-sm" value="+ Add Report">
						</form>
					</td>
				</tr>

				<?php } ?>

			</tbody>

		</table>

		<?php } else { ?>

			<p>Congratulations! You're all up-to-date on your paperwork ;)</p>
			<img src="https://memegenerator.net/img/images/4277930/roz-from-monsters-inc.jpg" width="319" class="mb-4">

		<?php } } ?>


<h3>Previous Reports</h3>

<table class="table table-hover table-striped table-sm">

	<thead class="thead-dark">
		<tr>
			<th>Student</th>
			<th>Username</th>
			<th>Date</th>
			<th>Start Time</th>
			<th>End Time</th>
			<th>Aircraft</th>
			<th></th>
		</tr>
	</thead>

	<tbody>

		<?php

		$sql4 = 'SELECT * FROM sessions WHERE `users.mentor`='.$sso->get_user_data('id').' AND `reported`=1';

		if ($res4 = $mysqli->query($sql4)) {

			while ($row4 = $res4->fetch_array()) {

				?>

				<tr>
					<td><?php echo $sso->get_user_data('name',$row4['users.id']); ?></td>
					<td><?php echo $sso->get_user_data('username',$row4['users.id']); ?></td>
					<td><?php echo date_format(new DateTime($row4['date']), 'd M Y'); ?></td>
					<td><?php echo date_format(new DateTime($row4['stime']), 'H:i e'); ?></td>
					<td><?php echo date_format(new DateTime($row4['ftime']), 'H:i e'); ?></td>
					<td><?php echo strtoupper($row4['acft']); ?></td>
					<td>
						<form action="reports_view.php" method="POST">
							<input type="hidden" name="session" value="<?php echo $row4['id']; ?>">
							<input type="submit" class="btn btn-primary btn-sm" value="View Report &raquo;">
						</form>
					</td>
				</tr>

		<?php } } ?>

	</tbody>

</table>

<?php $call = 'academy'; include $_SERVER['DOCUMENT_ROOT'].'/../footer_sys.php'; ?>
