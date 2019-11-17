<?php

$sect = 'copilot';
$title = ' - Copilot';
$page = 'export';

require_once('simbrief.apiv1.php');
require_once('../assets/includes/core.php');

// if the plan ID is in the URL
if (isset($_GET['ofp_id'])) {

	// find the plan
	$stmt = $mysqli->prepare('SELECT * FROM flights WHERE ofp=?');
	$stmt->bind_param("s", $_GET['ofp_id']);
	$stmt->execute();
	$result = $stmt->get_result();

	// check that the plan exists
	if ($result->num_rows!=0) {

		$row = $result->fetch_array();

		// check that the plan belongs to the user or their SC partner
		if ($row['acceptee']==$sso->get_user_data('discord') || $row['requestee']==$sso->get_user_data('discord')) {

			// safety net in case the ofp_id is a load of shit
			if (!$fpl = $simbrief->ofp_array) {		// api stuff to get FPL data
				$cancel_status = $copilot->cancel_flight($mysqli, $_GET['ofp_id']);
				if ($cancel_status == "cancelled"){
					$copilot->redirect('/dispatch/plan.php');
					die();
				}
			}
		} else {

			// redirect to plan if plan doesn't belong to user
			$copilot->redirect('/dispatch/plan.php');
			die();

		}

	} else {

		// if no plan exists
		if ($result->num_rows==0){
			//redirect to plan if plan doesn't already exist
			$copilot->redirect('/dispatch/plan.php');
			die();
		}

	}

} else {

	// find a plan for the user
	$stmt = $mysqli->prepare('SELECT * FROM flights WHERE requestee=? or acceptee=?');
	$discord = $sso->get_user_data('discord');
	$stmt->bind_param("ss", $discord, $discord);
	$stmt->execute();
	$result = $stmt->get_result();

	// check if a plan exists
	if ($result->num_rows!=0) {

		// redirect to the plan if it exists
		$row = $result->fetch_array();
		$copilot->redirect('/dispatch/export.php?ofp_id='.$row['ofp']);

	} else {

		// redirect to plan as plan does not exist
		$copilot->redirect('/dispatch/plan.php');

	}

}

if (isset($_POST['complete']) and $_POST['complete']=="confirm"){
	$date = date('Y-m-d H:i');
	$complete_status = $copilot->completed($mysqli, $_GET['ofp_id'], $fpl['aircraft']['icaocode'], $fpl['origin']['icao_code'], $fpl['destination']['icao_code'], $date);
	if ($complete_status=='complete') {
		$copilot->redirect('/logbook.php');
	} else {
		$complete_err = $complete_status;
	}
}

elseif (isset($_POST['cancel']) and $_POST['cancel']=="confirm"){
	$cancel_status = $copilot->cancel_flight($mysqli, $_GET['ofp_id']);
		if ($cancel_status == "cancelled"){
			$copilot->redirect('/logbook.php');
			die();
		}
}

// echo(''.$fpl['images']['directory'] .$fpl['images']['map']['0']['link']);

?>

<div class="card mb-4">
	<div class="card-body">
		<h4 class="card-title">Dispatch</h4>
		<p class="card-text">Your operational flight plan is ready. <strong class="text-danger">This flight plan is for flight sim use only!</strong> You can export it in various formats at the bottom of this page.</p>
		<p class="card-text mt-3 text-center" style="font-size: 1.5rem;"><strong>Flight Number: </strong><?php echo $fpl['general']['icao_airline'].$fpl['general']['flight_number']; ?>;&nbsp; <strong>Callsign: </strong><?php echo $fpl['atc']['callsign']; ?></p>
	</div>
</div>

<?php if (isset($complete_err) && $complete_err) { ?>
	<div class="alert alert-danger">
		<strong>An error occurred while marking your flight complete:</strong><br>
		<?php echo $complete_err; ?>
	</div>
<?php } ?>

<div class="row">

	<div class="col-lg-4">

		<div class="card mb-4">

			<div class="card-body">

				<h5 class="card-title">Overview</h5>

				<div class="form-group row card-text">
					<label class="col-sm-6 col-form-label">Aircraft Type</label>
					<div class="col-sm-6">
						<input type="text" class="form-control" readonly value="<?php echo $fpl['aircraft']['icaocode']; ?>">
					</div>
				</div>

				<div class="form-group row card-text">
					<label class="col-sm-6 col-form-label">Departure</label>
					<div class="col-sm-6">
						<input type="text" class="form-control" readonly value="<?php echo $fpl['origin']['icao_code'].' / '.$fpl['origin']['iata_code']; ?>">
					</div>
				</div>

				<div class="form-group row card-text">
					<label class="col-sm-6 col-form-label">Arrival</label>
					<div class="col-sm-6">
						<input type="text" class="form-control" readonly value="<?php echo $fpl['destination']['icao_code'].' / '.$fpl['destination']['iata_code']; ?>">
					</div>
				</div>

				<div class="form-group row card-text">
					<label class="col-sm-6 col-form-label">Alternate</label>
					<div class="col-sm-6">
						<input type="text" class="form-control" readonly value="<?php echo $fpl['alternate']['icao_code'].' / '.$fpl['alternate']['iata_code']; ?>">
					</div>
				</div>

			</div>

		</div>

		<div class="card mb-4">

			<div class="card-body">

				<h5 class="card-title">ATC Route</h5>

				<textarea class="form-control card-text" rows="4" readonly><?php echo $fpl['atc']['route']; ?></textarea>

			</div>

		</div>

		<div class="card mb-4">

			<div class="card-body">

				<h5 class="card-title">PDF Documentation</h5>

				<p class="text-center card-text"><a class="btn btn-lg btn-primary" href="<?php echo $fpl['files']['directory'].$fpl['files']['pdf']['link']; ?>" target="_blank"><i class="fas fa-fw fa-external-link-alt"></i> &nbsp;Open in New Tab</a></p>

			</div>

		</div>

	</div>

	<div class="col-lg-8">

		<div class="card mb-4">

			<div class="card-body">

				<h5 class="card-title">Route Map</h5>

				<img class="card-text img-fluid" src="<?php echo(''.$fpl['images']['directory'] .$fpl['images']['map']['0']['link']); ?>" alt="Route map">

			</div>

		</div>

	</div>

</div>

<div class="card mb-4">

	<div class="card-body">

		<h5 class="card-title">Export OFP</h5>

		<div class="card-text">

			<p>The flight plan will also be available via the <a href="https://www.simbrief.com/home/index.php?page=fms-downloader">SimBrief Downloader</a>. This will allow you to instantly export the plan to the desired company route folder.</p>

			<table class="table table-striped table-hover table-sm border w-50 mx-auto mb-1">

				<thead class="thead-light">
					<tr>
						<th>Name</th>
						<th class="text-right">Export</th>
					</tr>
				</thead>

				<tbody>

					<?php for ($i=0; $i < count($fpl['files']['file']); $i++) { ?>
						<tr>
							<td class="align-middle"><?php echo $fpl['files']['file'][$i]['name']; ?></td>
							<td class="text-right"><a href="<?php echo $fpl['files']['directory'].$fpl['files']['file'][$i]['link']; ?>" class="btn btn-primary btn-sm" target="_blank">Download</a></td>
						</tr>
					<?php } ?>

				</tbody>

			</table>

		</div>

	</div>

</div>

<div class="card mb-4">

	<div class="card-body">

		<h5 class="card-title">End Flight</h5>

		<div class="card-text">

			<p>Please use the following buttons to mark your flight as either completed or cancelled. By marking your flight as completed, the flight will appear in both users logbooks. By cancelling, the flight will no longer exist in the Copilot system, and should only be used in the event of e.g. a sim crash where the plan is not to be used again.</p>

			<button type="button" class="btn button-complete mx-auto" data-toggle="modal" data-target="#complete"><i class="fas fa-5x fa-check"></i><br>Complete</button>
			<button type="button" class="btn button-cancel mx-auto" data-toggle="modal" data-target="#cancel"><i class="fas fa-2x fa-times"></i> <span style="vertical-align: 25%;">&nbsp;Cancel</span></button>

		</div>

	</div>

</div>

<!-- Complete Modal -->
<div class="modal fade" id="complete">
	<div class="modal-dialog">
		<div class="modal-content">

			<div class="modal-header">
				<h4 class="modal-title">Confirm Completion</h4>
				<button type="button" class="close" data-dismiss="modal">&times;</button>
			</div>

			<div class="modal-body">
				Are you sure you would like to complete this flight? You will no longer have access to the plan but it will appear in your logbook.
			</div>

			<div class="modal-footer">
				<form action="" method="post">
					<button type="submit" name="complete" value="confirm" class="btn btn-success">Confirm</button>
				</form>
				<button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
			</div>

		</div>
	</div>
</div>

<!-- Cancel Modal -->
<div class="modal fade" id="cancel">
	<div class="modal-dialog">
		<div class="modal-content">

			<div class="modal-header">
				<h4 class="modal-title">Confirm Cancellation</h4>
				<button type="button" class="close" data-dismiss="modal">&times;</button>
			</div>

			<div class="modal-body">
				Are you sure you would like to cancel this flight? You will no longer have access to the plan.
			</div>


			<div class="modal-footer">
				<form action="" method="post">
					<button type="submit" name="cancel" value="confirm" class="btn btn-success">Confirm</button>
				</form>
				<button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
			</div>

		</div>
	</div>
</div>

<?php require_once('../assets/layout/footer.php'); ?>
