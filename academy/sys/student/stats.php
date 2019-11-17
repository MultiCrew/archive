<?php

$tab = 'sys';
$page = 'stats';
include $_SERVER['DOCUMENT_ROOT'].'/assets/layout/header.php';
include $_SERVER['DOCUMENT_ROOT'].'/assets/layout/sidebar_sys.php';

// get user cert data
$stmt = $mysqli->prepare('SELECT * FROM cert WHERE `users.id`=?');
$userid = $sso->get_user_data('id');
$stmt->bind_param("i", $userid);
$stmt->execute();
$result = $stmt->get_result();
$row = $result->fetch_array();

// get any instructor data
$stmt = $mysqli->prepare('SELECT * FROM instr WHERE `users.id`=?');
$userid = $sso->get_user_data('id');
$stmt->bind_param("i", $userid);
$stmt->execute();
$result3 = $stmt->get_result();
$row2 = $result3->fetch_array();

$stmt = $mysqli->prepare('SELECT * FROM sessions WHERE `users.id`=? and reported=? ORDER BY date DESC LIMIT 5');
$reported = 1;
$userid = $sso->get_user_data('id');
$stmt->bind_param("ii", $userid, $reported);
$stmt->execute();
$result2 = $stmt->get_result();

$stmt->close();

?>

<h1 class="display-4">Statistics</h1>
<p class="lead">Check out your progress through each course &middot; <a href="#" data-toggle="modal" data-target="#progHelp">Help <i class="far fa-question-circle"></i></a></p>

<hr>

<div class="modal fade" id="progHelp" tabindex="-1" role="dialog">
	<div class="modal-dialog" role="document">
		<div class="modal-content">

			<div class="modal-header">
				<h5 class="modal-title" id="optHelpLabel">Progress - Help</h5>
				<button type="button" class="close" data-dismiss="modal">
					<span>×</span>
				</button>
			</div>

			<div class="modal-body">
				<p>The <strong>Course Progress</strong> bar indicates your approximate progress through the course content. Most students will reach 100% progress before they are put forward to attempt the examinations.</p>
				<p><strong>Theory</strong> and <strong>Practical</strong> indications are for the respective examinations, and will be either <strong class="text-warning">N/A</strong> (not attempted), <strong class="text-success">PASS</strong> or <strong class="text-danger">FAIL</strong>.</p>
				<p><strong>Cert</strong> indication will become <strong class="text-success">YES</strong> upon completion of both the Theory and Practical examinations.</p>
			</div>

			<div class="modal-footer">
				<button type="button" class="btn btn-outline-secondary" data-dismiss="modal">Close</button>
			</div>

		</div>
	</div>
</div>

<div class="row">

	<div class="col-md-6 mb-4">

		<div class="card">

			<h3 class="card-header">Aerosoft Airbus A318-A321</h3>

			<div class="card-body">

				<h5 class="card-title">Course Progress</h5>

				<?php if ($row2['a320']!=1) { $academy->stats($row, 'a320'); } else { echo '<p class="card-text">You are an instructor on this course!</p>'; } ?>

			</div>

		</div>

	</div>

	<div class="col-md-6 mb-4">

		<div class="card">

			<h3 class="card-header">Aerosoft Airbus A330</h3>

			<div class="card-body">

				<h5 class="card-title">Course Progress</h5>

				<?php if ($row2['a330']!=1) { $academy->stats($row, 'a330'); } else { echo '<p class="card-text">You are an instructor on this course!</p>'; } ?>

			</div>

		</div>

	</div>

</div>

<div class="row">

	<div class="col-md-6 mb-4">

		<div class="card">

			<h3 class="card-header">Majestic Software Dash 8 Q400</h3>

			<div class="card-body">

				<h5 class="card-title">Course Progress</h5>

				<?php if ($row2['dh8d']!=1) { $academy->stats($row, 'dh8d'); } else { echo '<p class="card-text">You are an instructor on this course!</p>'; } ?>

			</div>

		</div>

	</div>

	<div class="col-md-6 mb-4">

		<div class="card">

			<h3 class="card-header">TFDi Boeing 717</h3>

			<div class="card-body">

				<h5 class="card-title">Course Progress</h5>

				<?php if ($row2['b712']!=1) { $academy->stats($row, 'b712'); } else { echo '<p class="card-text">You are an instructor on this course!</p>'; } ?>

			</div>

		</div>

	</div>

</div>

<?php if ($result2->num_rows!=0) { ?>

	<hr>

	<h3>Recent Sessions</h3>

	<table class="table table-sm table-hover table-striped border">

		<thead class="thead-dark">
			<tr>
				<th>Aircraft</th>
				<th>Date</th>
				<th>Start Time</th>
				<th>End Time</th>
				<th>Instructor</th>
				<th>Username</th>
				<th></th>
			</tr>
		</thead>

		<tbody>

			<?php

			while ($row2 = $result2->fetch_array()) {

			$mysqldate = DateTime::createFromFormat('Y-m-d', $row2['date']);
			$date = $mysqldate->format('j M Y');

			$stime = date_format(new DateTime($row2['stime']), 'H:i');
			$ftime = date_format(new DateTime($row2['ftime']), 'H:i');

			?>

			<tr>
				<td><?php echo(strtoupper($row2['acft'])); ?></td>
				<td><?php echo($date); ?></td>
				<td><?php echo $stime.' UTC'; ?></td>
				<td><?php echo $ftime.' UTC'; ?></td>
				<td><?php echo($sso->get_user_data('name', $row2['users.mentor'])); ?></td>
				<td><?php echo($sso->get_user_data('username', $row2['users.mentor'])); ?></td>
				<td>
					<form action="reports_view.php" method="POST" id="<?php echo $row2['id']; ?>">
						<input type="hidden" name="session" value="<?php echo $row2['id']; ?>">
						<a href="#" onclick="document.getElementById('<?php echo $row2['id']; ?>').submit();">View Report &raquo;</a>
					</form>
				</td>
			</tr>

		<?php } ?>

		</tbody>

	</table>

	<button class="btn btn-primary mb-3 float-right">View all &raquo;</button>

<?php }

$call = 'academy'; include $_SERVER['DOCUMENT_ROOT'].'/../footer_sys.php'; ?>
