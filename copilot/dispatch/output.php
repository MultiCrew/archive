<?php

$sect = 'copilot';
$title = ' - Copilot';
$page = 'output';

require_once('simbrief.apiv1.php');
require_once('../assets/includes/core.php');

// if the plan ID is in the URL
if (isset($_GET['ofp_id'])) {

	// find the plan
	$stmt = $mysqli->prepare('SELECT * FROM plans WHERE ofp=?');
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
				$copilot->redirect('/dispatch/plan.php');
			}
			else{
				$acceptance_status = $copilot->acceptance_check($mysqli, $_GET['ofp_id']);
				if ($acceptance_status == "accepted"){
					$copilot->redirect('/dispatch/export.php?ofp_id='.$_GET['ofp_id']);
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

			// get all the request info
			$stmt = $mysqli->prepare('SELECT * FROM accepted WHERE requestee=? OR acceptee=?');
			$discord = $sso->get_user_data('discord');
			$stmt->bind_param("ss", $discord, $discord);
			$stmt->execute();
			$result = $stmt->get_result();
			$row = $result->fetch_array();
			$stmt->close();

			// remove plan from accepted
			$stmt = $mysqli->prepare('DELETE FROM accepted WHERE id=?');
			$stmt->bind_param("i", $row['id']);
			$stmt->execute();
			$stmt->close();

			// insert the above info into plans
			$stmt = $mysqli->prepare('INSERT INTO plans (id, requestee, acceptee, ofp) VALUES (?, ?, ?, ?)');
			$stmt->bind_param('ssss', $row['id'], $row['requestee'], $row['acceptee'], $_GET['ofp_id']);
			$stmt->execute();
			$stmt->close();
			echo'<script type="text/javascript">window.location.reload(true)</script>';
		}
		else{
			//redirect to plan if plan doesn't already exist
			$copilot->redirect('/dispatch/plan.php');
		}

	}

} else {

	// find a plan for the user
	$stmt = $mysqli->prepare('SELECT * FROM plans WHERE requestee=? or acceptee=?');
	$discord = $sso->get_user_data('discord');
	$stmt->bind_param("ss", $discord, $discord);
	$stmt->execute();
	$result = $stmt->get_result();

	// check if a plan exists
	if ($result->num_rows!=0) {

		// redirect to the plan if it exists
		$row = $result->fetch_array();
		$copilot->redirect('/dispatch/output.php?ofp_id='.$row['ofp']);

	} else {

		// redirect to plan as plan does not exist
		$copilot->redirect('/dispatch/plan.php');

	}

}

if (isset($_POST['reject']) and $_POST['reject'] == "true"){
	$copilot->reject_plan($mysqli, $row['id'], $fpl['aircraft']['icaocode'], $fpl['origin']['icao_code'], $fpl['destination']['icao_code']);
	$copilot->redirect('/dispatch/plan.php');
}

if (isset($_POST['accept']) and $_POST['accept'] == "true"){
	$discord = $sso->get_user_data('discord');
	$copilot->accept_plan($mysqli, $discord);
	$copilot->redirect('/dispatch/output.php?ofp_id='.$row['ofp']);
}

if (isset($_POST['proceed']) and $_POST['proceed'] == "true"){
	$discord = $sso->get_user_data('discord');
	$proceed_status = $copilot->accepted_plan($mysqli, $discord);
	if ($proceed_status == 'accepted'){
		$copilot->redirect('/dispatch/export.php?ofp_id='.$_GET['ofp_id']);
	}
	else{
		echo'<div class="alert alert-danger alert-dismissible">
  				<a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
				Your copilot has not accepted this flight plan. Please wait for them to accept it.
			</div>';
	}

}

?>

<div class="card mb-4">
	<div class="card-body">
		<h4 class="card-title">Review</h4>
		<p class="card-text">Your draft OFP has been generated. Both pilots are required to review and accept the flight plan before cockpit preparation can begin.</p>
	</div>
</div>

<div class="alert alert-danger mb-4">
	<strong>Do not operate with this flight plan!</strong> Please review and choose "Accept" or "Reject" at the bottom of this page.
</div>

<div class="row">

	<div class="col-lg-8">

		<div class="card mb-4">

			<div class="card-body">

				<h5 class="card-title">General</h5>

				<div class="card-text">

					<div class="form-row">

						<div class="col-md-4 form-group">
							<label>Planned with</label>
							<input type="text" class="form-control" readonly value="AIRAC <?php echo $fpl['params']['airac']; ?>">
						</div>

						<div class="col-md-4 form-group">
							<label>Flight Number</label>
							<div class="input-group">
								<div class="input-group-prepend">
									<span class="input-group-text"><?php echo $fpl['general']['icao_airline']; ?></span>
								</div>
								<input type="text" class="form-control" readonly value="<?php echo $fpl['general']['flight_number']; ?>" size="9">
							</div>
						</div>

						<div class="col-md-4 form-group">
							<label>Callsign</label>
							<input type="text" class="form-control" readonly value="<?php echo $fpl['atc']['callsign']; ?>">
						</div>

					</div>

					<div class="form-row">

						<div class="col-md-4 form-group">
							<label>ADEP</label>
							<input type="text" class="form-control" readonly value="<?php echo $fpl['origin']['icao_code'].' / '.$fpl['origin']['iata_code']; ?>">
						</div>

						<div class="col-md-4 form-group">
							<label>ADES</label>
							<input type="text" class="form-control" readonly value="<?php echo $fpl['destination']['icao_code'].' / '.$fpl['destination']['iata_code']; ?>">
						</div>

						<div class="col-md-4 form-group">
							<label>ALTN</label>
							<input type="text" class="form-control" readonly value="<?php echo $fpl['alternate']['icao_code'].' / '.$fpl['alternate']['iata_code']; ?>">
						</div>

					</div>

				</div>

			</div>

		</div>

		<div class="card mb-4">

			<div class="card-body">

				<h5 class="card-title">Routing</h5>

				<div class="card-text">

					<div class="form-group">
						<label>ATC Route</label>
						<textarea class="form-control" readonly rows="3"><?php echo $fpl['atc']['route']; ?></textarea>
					</div>

					<div class="form-group">
						<label>ATC Remarks</label>
						<textarea class="form-control" readonly rows="3"><?php echo $fpl['atc']['section18']; ?></textarea>
					</div>

					<div class="form-row">

						<div class="form-group col-lg-4">
							<label>Cost Index</label>
							<input type="text" class="form-control" readonly value="<?php echo $fpl['general']['costindex']; ?>">
						</div>

						<div class="form-group col-lg-4">
							<label>Fuel Burn</label>
							<input type="text" class="form-control" readonly value="<?php echo $fpl['general']['total_burn']; ?>">
						</div>

						<div class="form-group col-lg-4">
							<label>Init CRZ Alt</label>
							<input type="text" class="form-control" readonly value="<?php echo $fpl['general']['initial_altitude']; ?>">
						</div>

					</div>

				</div>

			</div>

		</div>

	</div>

	<div class="col-lg-4">

		<div class="card mb-4">

			<div class="card-body">

				<h5 class="card-title">Fuel Figures</h5>

				<div class="card-text">

					<div class="form-group row mb-2">
						<label class="col-md-6 col-form-label">Block</label>
						<div class="col-md-6">
							<input type="text" class="form-control" readonly value="<?php echo $fpl['fuel']['plan_ramp']; ?>">
						</div>
					</div>

					<div class="form-group row mb-2">
						<label class="col-md-6 col-form-label">Max</label>
						<div class="col-md-6">
							<input type="text" class="form-control" readonly value="<?php echo $fpl['fuel']['max_tanks']; ?>">
						</div>
					</div>

					<div class="form-group row mb-2">
						<label class="col-md-6 col-form-label">Burn</label>
						<div class="col-md-6">
							<input type="text" class="form-control" readonly value="<?php echo $fpl['fuel']['enroute_burn']; ?>">
						</div>
					</div>

					<div class="form-group row mb-2">
						<label class="col-md-6 col-form-label">Landing</label>
						<div class="col-md-6">
							<input type="text" class="form-control" readonly value="<?php echo $fpl['fuel']['plan_landing']; ?>">
						</div>
					</div>

				</div>

			</div>

		</div>

		<div class="card mb-4">

			<div class="card-body">

				<h5 class="card-title">Aircraft</h5>

				<div class="card-text">

					<div class="form-group row mb-2">
						<label class="col-md-6 col-form-label">ICAO</label>
						<div class="col-md-6">
							<input type="text" class="form-control" readonly value="<?php echo $fpl['aircraft']['icaocode']; ?>">
						</div>
					</div>

					<div class="form-group row mb-2">
						<label class="col-md-6 col-form-label">Type</label>
						<div class="col-md-6">
							<input type="text" class="form-control" readonly value="<?php echo $fpl['aircraft']['name']; ?>">
						</div>
					</div>

					<div class="form-group row mb-2">
						<label class="col-md-6 col-form-label">Registration</label>
						<div class="col-md-6">
							<input type="text" class="form-control" readonly value="<?php echo $fpl['aircraft']['reg']; ?>">
						</div>
					</div>

					<div class="form-group row mb-2">
						<label class="col-md-6 col-form-label">PAX</label>
						<div class="col-md-6">
							<input type="text" class="form-control" readonly value="<?php echo $fpl['general']['passengers']; ?> / <?php echo $fpl['aircraft']['max_passengers']; ?>">
						</div>
					</div>

				</div>

			</div>

		</div>

		<div class="card mb-4">

			<div class="card-body">

				<h5 class="card-title">Crew</h5>

				<div class="card-text">

					<div class="form-group row mb-2">
						<label class="col-md-4 col-form-label">OFP by</label>
						<div class="col-md-8">
							<input type="text" class="form-control" readonly value="<?php echo $fpl['crew']['cpt'] ?>">
						</div>
					</div>

				</div>

			</div>

		</div>

	</div>

</div>

<div class="card mb-4">

	<div class="card-body">

		<h5 class="card-title">Weights</h5>

		<div class="card-text">

			<div class="form-row">

				<div class="form-group col-md-3">
					<label>PAX</label>
					<input type="text" class="form-control" readonly value="<?php echo $fpl['weights']['pax_count']; ?> / <?php echo $fpl['aircraft']['max_passengers']; ?>">
				</div>

				<div class="form-group col-md-3">
					<label>Est. ZFW</label>
					<input type="text" class="form-control" readonly value="<?php echo $fpl['weights']['est_zfw']; ?>">
				</div>

				<div class="form-group col-md-3">
					<label>Est. TOW</label>
					<input type="text" class="form-control" readonly value="<?php echo $fpl['weights']['est_tow']; ?>">
				</div>

				<div class="form-group col-md-3">
					<label>Est. LAW</label>
					<input type="text" class="form-control" readonly value="<?php echo $fpl['weights']['est_ldw']; ?>">
				</div>

			</div>

			<div class="form-row">

				<div class="col-md-3"></div>

				<div class="form-group col-md-3">
					<label>Max. ZFW</label>
					<input type="text" class="form-control" readonly value="<?php echo $fpl['weights']['max_zfw']; ?>">
				</div>

				<div class="form-group col-md-3">
					<label>Max. TOW</label>
					<input type="text" class="form-control" readonly value="<?php echo $fpl['weights']['max_tow']; ?>">
				</div>

				<div class="form-group col-md-3">
					<label>Max. LAW</label>
					<input type="text" class="form-control" readonly value="<?php echo $fpl['weights']['max_ldw']; ?>">
				</div>

			</div>

		</div>

	</div>

</div>

<div class="card mb-4">

	<div class="card-body">

		<h5 class="card-title">Paperwork Preview</h5>

		<p class="card-text text-danger mb-2 text-center">DRAFT PLAN! Not operational paperwork.</p>

		<div class="card-text border rounded mx-auto" style="width: 600px; height:600px; overflow:auto;">

			<pre><?php echo $fpl['text']['plan_html'].'<br>'; ?></pre>

		</div>

	</div>

</div>

<div class="card mb-4">

	<div class="card-body">

		<h5 class="card-title">Review</h5>

		<div class="card-text">

			<p>Please select one of the following options to indicate whether you have reviewed, and are happy to continue with, the flight plan detailed above.</p>

			<p>Upon accepting the flight plan, a PDF document and other export options will become available.</p>

			<p>Upon rejecting the flight plan, another will have to be generated.</p>

			<?php

			$discord = $sso->get_user_data('discord');

			$accept_status = $copilot->accepted_plan($mysqli, $discord);

			if ($accept_status == $discord){ ?>
				<div class="text-center mb-3">
					<form action="" method="post">
					<button type="submit" name="proceed" value="true" class="btn button-accept"><i class="fas fa-5x fa-check"></i><br>Proceed</button>
					</form>
				</div>
			<?php }
			else{ ?>

			<div class="text-center mb-3">

				<form action="" method="post">
				<?php

				$discord = $sso->get_user_data('discord');

				$accept_status = $copilot->accepted_plan($mysqli, $discord);

				if ($accept_status != $discord and $accept_status != "accepted"){

					echo '<button type="submit" name="accept" value="true" class="btn button-accept"><i class="fas fa-5x fa-check"></i><br>Accept</button>';
				}
				?>

				<button type="submit" name="reject" value="true" class="btn button-reject"><i class="fas fa-5x fa-times"></i><br>Reject</button>

				</form>


			</div>

			<?php } ?>

		</div>

	</div>

</div>

<?php require_once('../assets/layout/footer.php'); ?>
