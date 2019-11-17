<?php

$tab = 'sys';
$page = 'management';
include $_SERVER['DOCUMENT_ROOT'].'/assets/layout/header.php';
include $_SERVER['DOCUMENT_ROOT'].'/assets/layout/sidebar_sys.php';

// add avail
if (isset($_POST['addavail'])) {

	// check for duplicate entires
	$stmt = $mysqli->prepare('SELECT * FROM availability WHERE `users.id`=? AND `date`=?');
	$user_id = $sso->get_user_data('id');
	$stmt->bind_param("is", $user_id, $_POST['date']);
	$stmt->execute();
	$result = $stmt->get_result();

	if ($result->num_rows!=0){

		$stmt = $mysqli->prepare('SELECT * FROM availability WHERE ? BETWEEN `stime` AND `ftime` OR ? BETWEEN `stime` AND `ftime`');
		$stmt->bind_param("ss", $_POST['stime'], $_POST['ftime']);
		$stmt->execute();
		$result = $stmt->get_result();

		if ($result->num_rows==0) {

			$stmt = $mysqli->prepare('INSERT INTO `availability` (`users.id` , `date`, stime, ftime) VALUES(?,?,?,?)');
			$stmt->bind_param("isss", $user_id, $_POST['date'], $_POST['stime'],$_POST['ftime']);
			$stmt->execute();
			echo($stmt->error);

			if ($stmt->error) { $adderror = true; } else { $added = true; }

		} else { $addexists = true; }

	} else {

		$stmt = $mysqli->prepare('INSERT INTO `availability` (`users.id` , `date`, stime, ftime) VALUES(?,?,?,?)');
		$stmt->bind_param("isss", $user_id, $_POST['date'], $_POST['stime'],$_POST['ftime']);
		$stmt->execute();
		echo($stmt->error);

		if ($stmt->error) { $adderror = true; } else { $added = true; }

	}

	$stmt->close();

}

// delete avail
if (isset($_POST['delid'])) {

	$stmt = $mysqli->prepare('DELETE FROM availability WHERE id=?');
	$stmt->bind_param("i", $_POST['delid']);

	if ($stmt->execute()) { $del = true; } else { $delerror = true; }

	$stmt->close();

}

if (isset($_POST['updatecourse'])){

	// check to see if first time enrolment
	$stmt = $mysqli->prepare('SELECT * FROM enrolment WHERE `users.id`=?');
	$users_id=$sso->get_user_data('id');
	$stmt->bind_param("i", $users_id);
	$stmt->execute();
	$result = $stmt->get_result();

	if ($result->num_rows!=0){

		// update course
		$stmt = $mysqli->prepare('UPDATE enrolment SET active=? WHERE `users.id`=?');
		$stmt->bind_param("si", $_POST['active'], $users_id);
		$stmt->execute();
		$stmt->close();

	} else {

		$stmt = $mysqli->prepare('INSERT INTO enrolment (`users.id`,active) VALUES(?, ?)');
		$stmt->bind_param("is", $users_id, $_POST['active']);
		$stmt->execute();
		$stmt->close();

	}

}

?>

<h1 class="display-4">Management</h1>
<p class="lead">Manage your course enrolment and add availability to get your practical training sessions</p>

<hr>

<div class="row">

	<div class="col-sm-6">

		<div class="card mb-3">

			<h3 class="card-header">
				Course Enrolment
				<!--<a href="#" data-toggle="modal" data-target="#enrolHelp">
					<i class="far fa-question-circle"></i>
				</a>-->
			</h3>

			<div class="card-body">

				<?php if (isset($saveerr)) { ?>

					<div class="alert alert-danger card-text">
						<h4 class="alert-heading">An error occured!</h4>
						<p class="card-body">Please send the error message (below the line) to <a href="mailto:&#097;&#100;&#109;&#105;&#110;&#064;&#109;&#117;&#108;&#116;&#105;&#099;&#114;&#101;&#119;&#046;&#099;&#111;&#046;&#117;&#107;">&#097;&#100;&#109;&#105;&#110;&#064;&#109;&#117;&#108;&#116;&#105;&#099;&#114;&#101;&#119;&#046;&#099;&#111;&#046;&#117;&#107;</a>, including the full URL of the page and the last action you performed.</p>
						<hr>
						<p class="mb-0">MySQLi Error: <?php echo $mysqli->error; ?></p>
					</div>

				<?php } if (isset($saved)) { ?>

					<div class="alert alert-success alert-dismissible fade show card-text">
						Options saved!
						<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
					</div>

				<?php } ?>

				<p class="card-text">Below you can select the course which you wish to train on. <strong>Note that you can only train on one course at a time</strong>, and whilst you can change at any time, we recommend that you at least <em>attempt</em> to complete an entire course before changing!</p>

				<form action="" method="POST">

					<div class="input-group card-text">
						<select name="active" class="custom-select" required <?php if ($academy->session_check($mysqli, $sso)){ echo "disabled"; }?>>
							<option value="0">- NOT ENROLLED -</option>
							<option disabled>------------------</option>
							<option <?php if ($academy->active_course($mysqli, $sso, "a320")){ echo "selected"; } ?> value="a320">Aerosoft Airbus A318-A321 Professional</option>
							<option <?php if ($academy->active_course($mysqli, $sso, "a330")){ echo "selected"; } ?> value="a330">Aerosoft Airbus A330 Professional</option>
							<option <?php if ($academy->active_course($mysqli, $sso, "dh8d")){ echo "selected"; } ?> value="dh8d">Majestic Software Dash 8 Q400 Pro Editon</option>
							<option <?php if ($academy->active_course($mysqli, $sso, "b712")){ echo "selected"; } ?> value="b712">TFDi Design Boeing 717</option>
						</select>
						<div class="input-group-append">
							<button class="btn btn-primary" type="submit" name="updatecourse" <?php if ($academy->session_check($mysqli, $sso)){ echo "disabled"; }?>>Submit</button>
						</div>
					</div>

				</form>

			</div>

		</div>

		<div class="card mb-3">

			<h3 class="card-header">Add Availability
				<!--<a href="#" data-toggle="modal" data-target="#availHelp">
					<i class="far fa-question-circle"></i>
				</a>-->
			</h3>

			<div class="card-body">

				<?php if (isset($adderror)) { ?>

					<div class="alert alert-danger card-text">
						<h4 class="alert-heading">An error occured!</h4>
						<p class="card-body">Please send the error message (below the line) to <a href="mailto:&#097;&#100;&#109;&#105;&#110;&#064;&#109;&#117;&#108;&#116;&#105;&#099;&#114;&#101;&#119;&#046;&#099;&#111;&#046;&#117;&#107;">&#097;&#100;&#109;&#105;&#110;&#064;&#109;&#117;&#108;&#116;&#105;&#099;&#114;&#101;&#119;&#046;&#099;&#111;&#046;&#117;&#107;</a>, including the full URL of the page and the last action you performed.</p>
						<hr>
						<p class="mb-0">MySQLi Error: <?php printf($mysqli->error); ?></p>
					</div>

				<?php } if (isset($addexists) && $addexists) { ?>

					<div class="alert alert-danger alert-dismissible fade show card-text">
						You are trying to add availability that overlaps existing availability. Please try again.
						<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
					</div>

				<?php } if (isset($added)) { ?>

					<div class="alert alert-success alert-dismissible fade show card-text">
						Availability added!
						<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
					</div>

				<?php } ?>

				<form class="card-text" action="" method="POST">

					<p class="small">All times are in Zulu (UTC)!</p>

					<div class="form-group row">
						<label class="col-form-label col-sm-3">Date</label>
						<div class="col-sm-9">
							<input type="date" name="date" class="form-control">
						</div>
					</div>

					<div class="form-group row">
						<label class="col-form-label col-sm-3">Start time</label>
						<div class="col-sm-9">
							<input type="time" name="stime" class="form-control">
						</div>
					</div>

					<div class="form-group row">
						<label class="col-form-label col-sm-3">End time</label>
						<div class="col-sm-9">
							<input type="time" name="ftime" class="form-control">
						</div>
					</div>

					<div class="row">
						<div class="col">
							<input type="submit" class="btn btn-primary" name="addavail" value="Add">
							<button class="btn btn-secondary" onclick="window.location.reload()">Cancel</button>
						</div>
					</div>

				</form>

			</div>

		</div>

	</div>

	<div class="col-sm-6">

		<div class="card">

			<h3 class="card-header">Current Availability</h3>

			<div class="card-body">

				<?php

				$stmt = $mysqli->prepare('SELECT * FROM availability WHERE `users.id`=?');
				$user_id = $sso->get_user_data('id');
				$stmt->bind_param("i", $user_id);
				$stmt->execute();
				$result = $stmt->get_result();

				if ($result->num_rows!=0) { ?>

					<p class="small card-text">All times are in Zulu (UTC)!</p>

					<?php if (isset($del)) { ?>

						<div class="alert alert-success alert-dismissible fade show">
							Availability deleted!
							<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
						</div>

					<?php } if (isset($delerror)) { ?>

						<div class="alert alert-danger">
							<h4 class="alert-heading">An error occured!</h4>
							<p>Please send the error message (below the line) to <a href="mailto:&#097;&#100;&#109;&#105;&#110;&#064;&#109;&#117;&#108;&#116;&#105;&#099;&#114;&#101;&#119;&#046;&#099;&#111;&#046;&#117;&#107;">&#097;&#100;&#109;&#105;&#110;&#064;&#109;&#117;&#108;&#116;&#105;&#099;&#114;&#101;&#119;&#046;&#099;&#111;&#046;&#117;&#107;</a>, including the full URL of the page and the last action you performed.</p>
							<hr>
							<p class="mb-0">MySQLi Error: <?php echo $mysqli->error; ?></p>
						</div>

					<?php } ?>

					<table class="table table-striped table-hover card-text table-sm border">

						<thead class="thead-dark">
							<tr>
								<th>Date (DD/MM/YYYY)</th>
								<th class="text-center">Start</th>
								<th class="text-center">End</th>
								<th class="text-center"></th>
							</tr>
						</thead>

						<tbody>

							<?php while ($row = $result->fetch_object()) { ?>

								<tr>
									<td>
										<?php
										$date = new DateTime($row->date);
										echo $date->format('d/m/Y');
										?>
									</td>
									<td class="text-center"><?php echo $row->stime; ?></td>
									<td class="text-center"><?php echo $row->ftime; ?></td>
									<td class="text-center">
										<form class="col" id="delAvail<?php echo $row->id; ?>" action="" method="POST">
											<input type="hidden" name="delid" value="<?php echo $row->id; ?>">
											<a href="#" onclick="document.getElementById('delAvail<?php echo $row->id; ?>').submit()"><i class="fa fa-fw fa-times"></i> Delete</a>
										</form>
									</td>
								</tr>

							<?php } ?>

						</tbody>

					</table>

				<?php } else { ?>

					<p class="card-text"><strong>You have no availability set!</strong></p>
					<p class="card-text">When you add availability, Instructors will be able to pick up practical sessions at any time within your availability on the aircraft you have enrolled on, provided you have completed all the necessary prerequisites.</p>
					<p class="card-text"><strong>Ensure your availability is up to date at all times!</strong></p>

				<?php } ?>

			</div>

		</div>

		<div class="card mt-3">

			<h3 class="card-header">Current Sessions</h3>

			<div class="card-body">

				<?php

				$stmt = $mysqli->prepare('SELECT * FROM sessions WHERE `users.id`=? and reported=?');
				$reported = 0;
				$user_id = $sso->get_user_data('id');
				$stmt->bind_param("ii", $user_id, $reported);
				$stmt->execute();
				$result = $stmt->get_result();

				if ($result->num_rows!=0) { ?>

				<table class="card-text table table-sm table-striped table-hover border">

					<thead class="thead-dark">
						<tr>
							<th>Date</th>
							<th>Start Time</th>
							<th>End Time</th>
							<th>Instructor</th>
							<th></th>
						</tr>
					</thead>

					<tbody>

						<?php while ($row = $result->fetch_array()) {

							$mysqldate = DateTime::createFromFormat('Y-m-d', $row['date']);
							$date = $mysqldate->format('j M Y');

							$stime = date_format(new DateTime($row['stime']), 'H:i');
							$ftime = date_format(new DateTime($row['ftime']), 'H:i'); ?>

						<tr>
							<td><?php echo $date; ?></td>
							<td><?php echo $stime; ?></td>
							<td><?php echo $ftime; ?></td>
							<td><?php echo $sso->get_user_data('name', $row['users.mentor']); ?></td>
							<td>
								<form action="cancellation.php" method="POST" id="<?php echo $row['id']; ?>">
									<input type="hidden" name="cancel" value="<?php echo $row['id']; ?>">
									<a href="#" onclick="document.getElementById('<?php echo $row['id']; ?>').submit();"><i class="fa fa-fw fa-times"></i> Cancel</a>
								</form>
							</td>
						</tr>

					<?php } ?>

					</tbody>

				</table>

				<?php } else { ?>

					<p class="card-text"><strong>You have no sessions accepted!</strong></p>
					<p class="card-text">You will be notified when an Instructor picks accepts a session on the aircraft you have enrolled on.</p>

				<?php } ?>

			</div>

		</div>

	</div>

</div>

<!--
<div class="modal fade" id="enrolHelp" tabindex="-1" role="dialog">
	<div class="modal-dialog" role="document">
		<div class="modal-content">

			<div class="modal-header">
				<h5 class="modal-title" id="optHelpLabel">Training Options - Help</h5>
				<button type="button" class="close" data-dismiss="modal">
					<span>&times;</span>
				</button>
			</div>

			<div class="modal-body">
				<p>The Training Options section of the Academy allows you to configure your Academy training to your liking. Please note that we <strong>only provide training for P3D v4</strong>!</p>
				<h6>Aircraft Options</h6>
				<p>Select the aircraft which you wish to train on here. Your mentoring sessions will be picked up for <strong>any</strong> of the aircraft you have selected, i.e. if you only want practical sessions on one aircraft, only select that aircraft!<br>Note than this <strong>only affects your practical sessions</strong> and you can still continue with as many theory courses as you wish.</p>
			</div>

			<div class="modal-footer">
				<button type="button" class="btn btn-outline-secondary" data-dismiss="modal">Close</button>
			</div>

		</div>
	</div>
</div>

<div class="modal fade" id="availHelp" tabindex="-1" role="dialog">
	<div class="modal-dialog" role="document">
		<div class="modal-content">

			<div class="modal-header">
				<h5 class="modal-title" id="optHelpLabel">Availability - Help</h5>
				<button type="button" class="close" data-dismiss="modal">
					<span>&times;</span>
				</button>
			</div>

			<div class="modal-body">
				<p>Availability allows Instructors to see when you have indicated you'd like to take part in mentoring sessions. By adding availability, you will appear among a list of other students with availability. Instructors can then create sessions during any of the availability that you have set. You should ensure that your <strong>availability is always up to date</strong> to avoid having to cancel sessions.</p>
				<h6>Adding Availability</h6>
				<p>To add some availability, insert a date, start and end time. Sessions can be created by Instructors at any time, but should never lapse beyond the end time. If they do, just contact the mentor to request a change.</p>
				<h6>Removing Availability</h6>
				<p>To remove availability, just click the cross next to the corresponding entry in the "Current Availability" table. You cannot modify any entries, so just remove it and add it again.</p>
				<p><strong>Remember that all times are in UTC (Zulu)! If you need to check what this is, use <a href="https://www.zulutime.net/">https://www.zulutime.net/</a>.</strong>
			</div>

			<div class="modal-footer">
				<button type="button" class="btn btn-outline-secondary" data-dismiss="modal">Close</button>
			</div>

		</div>
	</div>
</div>
-->

<?php $call = 'academy'; include $_SERVER['DOCUMENT_ROOT'].'/../footer_sys.php'; ?>
