<?php

$sect = 'copilot';
$title = ' - Copilot';
$page = 'plan';

require_once('../assets/includes/core.php');

$stmt = $mysqli->prepare('SELECT * FROM plans WHERE requestee=? OR acceptee=?');
$discord = $sso->get_user_data('discord');
$stmt->bind_param("ss", $discord, $discord);
$stmt->execute();
$result = $stmt->get_result();
if ($result->num_rows!=0) {
	$row = $result->fetch_array();
	$copilot->redirect('https://copilot.multicrew.co.uk/dispatch/output.php?ofp_id='.$row['ofp']);
}
$stmt->close();

$stmt = $mysqli->prepare('SELECT * FROM flights WHERE requestee=? OR acceptee=?');
$discord = $sso->get_user_data('discord');
$stmt->bind_param("ss", $discord, $discord);
$stmt->execute();
$result = $stmt->get_result();
if ($result->num_rows!=0) {
	$row = $result->fetch_array();
	$copilot->redirect('https://copilot.multicrew.co.uk/dispatch/export.php?ofp_id='.$row['ofp']);
}
$stmt->close();

?>

<div class="card mb-4">
	<div class="card-body">
		<h4 class="card-title">Plan</h4>
		<div class="row">
			<div class="col-sm">
				<p class="card-text">The following form makes use of the SimBrief API to generate a draft flight plan which both pilots must review. A SimBrief account is <strong>required</strong>, and upon generating the plan you will be prompted to sign in to or create your SimBrief account.</p>
			</div>
			<div class="col-sm-auto">
				<h5 class="card-title">Current UTC Time:</h5>
				<p class="card-text text-center mt-3"><span id="time" class="border rounded p-2"></p>
			</div>
		</div>
	</div>
</div>

<?php

$stmt = $mysqli->prepare('SELECT * FROM accepted WHERE requestee=? OR acceptee=?');
$discord = $sso->get_user_data('discord');
$stmt->bind_param("ss", $discord, $discord);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows==0) { ?>

	<div class="alert alert-warning">
		<strong>You have not accepted any shared cockpit requests.</strong> The dispatcher will become available when you accept a request.
	</div>

<?php } else {

	$row = $result->fetch_array(); ?>

	<form id="sbapiform" action="dispatch_output.php">

		<div class="row align-items-center">

			<div class="col-md-8">

				<div class="card mb-4">

					<div class="card-body">

						<div class="card-text">

							<div class="form-row">

								<div class="col-sm-3 form-group">
									<label>Aircraft Type</label>
									<input type="text" name="type" class="form-control" readonly value="<?php echo $row['aircraft']; ?>">
								</div>

								<div class="col-sm-3 form-group">
									<label>Departure</label>
									<input type="text" name="orig" class="form-control" maxlength="4" readonly value="<?php echo $row['dep']; ?>">
								</div>

								<div class="col-sm-3 form-group">
									<label>Arrival</label>
									<input type="text" name="dest" class="form-control" maxlength="4" readonly value="<?php echo $row['arr']; ?>">
								</div>

								<div class="col-sm-3 form-group">
									<label>Alternate</label>
									<input type="text" name="altn" class="form-control" maxlength="4" required>
								</div>

							</div>

							<div class="form-row">

								<div class="col-md form-group">
									<label>Date of Flight</label>
									<select class="custom-select" name="date" required>
										<?php
										for ($i=0; $i < 7; $i++) {
											$date = strtotime('+ '.$i.' day');
											echo '<option value="'.$date.'">'.date('d-M-y', $date).'</option>';
										}
										?>
									</select>
								</div>

								<?php

								$date = strtotime("+30 minutes");
								$hour = date('H', $date);
								$minute = date('i', $date);
								?>

								<div class="col-md form-group">
									<label>Departure Time (UTC)</label>
										<div class="form-inline">
										<select class="custom-select mr-2" name="dephour" required>
											<?php
											for ($i=0; $i < 24; $i++) {
												if ($i==$hour) {
													echo '<option value="'.$i*(60^2).'" selected>'.$i.'</option>';
												} else {
													echo '<option value="'.$i*(60^2).'">'.$i.'</option>';
												}
											}
											?>
										</select> : &nbsp;
										<select class="custom-select" name="depmin" required>
											<?php
											for ($i=0; $i < 60; $i++) {
												if ($i==$minute) {
													echo '<option value="'.$i*(60).'" selected>'.$i.'</option>';
												} else {
													echo '<option value="'.$i*(60).'">'.$i.'</option>';
												}
											}
											?>
										</select>
									</div>
								</div>

							</div>

							<div class="form-row">

								<div class="col-sm-3 form-group">
									<label>Flight Number</label>
									<input type="hidden" name="airline" value="MC">
									<div class="input-group">
										<div class="input-group-prepend">
											<span class="input-group-text">MC</span>
										</div>
										<input type="text" name="fltnum" class="form-control" required placeholder="1234">
									</div>
								</div>

								<div class="col-sm-3 form-group">
									<label>Callsign</label>
									<input type="text" name="callsign" class="form-control" placeholder="MTC12AB" required>
								</div>

								<div class="col-sm-3 form-group">
									<label>Aircraft Reg</label>
									<input type="text" name="reg" class="form-control" placeholder="G-MTXX" required>
								</div>

							</div>

						</div>

					</div>

				</div>

			</div>

			<div class="col-md-4">

				<div class="card mb-4">

					<div class="card-body">

						<h5 class="card-title">OFP Options</h5>

						<div class="form-group row card-text mb-1">
							<label class="col-sm-7 col-form-label">Plan Format</label>
							<div class="col-sm-5">
								<select name="planformat" class="custom-select" required>
									<option value="lido" selected>LIDO</option>
									<option value="aal">AAL</option>
									<option value="aca">ACA</option>
									<option value="afr">AFR '12</option>
									<option value="afr2017">AFR '17</option>
									<option value="awe">AWE</option>
									<option value="baw">BAW</option>
									<option value="ber">BER</option>
									<option value="dal">DAL</option>
									<option value="dlh">DLH</option>
									<option value="etd">ETD</option>
									<option value="ezy">EZY</option>
									<option value="gwi">GWI</option>
									<option value="jbu">JBU</option>
									<option value="jza">JZA</option>
									<option value="klm">KLM</option>
									<option value="qfa">QFA</option>
									<option value="ryr">RYR</option>
									<option value="swa">SWA</option>
									<option value="thy">THY</option>
									<option value="uae">UAE</option>
									<option value="ual">UAL '12</option>
									<option value="ual f:wz">UAL '14</option>
								</select>
							</div>
						</div>

						<div class="form-group row card-text">
							<label class="col-sm-7 col-form-label">Units</label>
							<div class="col-sm-5">
								<select name="units" class="custom-select" required>
									<option value="KGS" selected>KGS</option>
									<option value="LBS">LBS</option>
								</select>
							</div>
						</div>

						<h5 class="card-title">Fuel Options</h5>

						<div class="form-group row card-text mb-1">
							<label class="col-sm-7 col-form-label">Contingency</label>
							<div class="col-sm-5">
								<select name="contpct" class="custom-select" required>
									<option value="auto" selected>AUTO</option>
									<option value="0">NONE</option>
									<option value disabled>- - - - - -</option>
									<option value="0.05/5">5% or 05 MIN</option>
									<option value="0.05/10">5% or 10 MIN</option>
									<option value="0.05/15">5% or 15 MIN</option>
									<option value="0.05/20">5% or 20 MIN</option>
									<option value disabled>- - - - - -</option>
									<option value="0.02">2 PCT</option>
									<option value="0.03">3 PCT</option>
									<option value="0.05">5 PCT</option>
									<option value="0.1">10 PCT</option>
									<option value="0.15">15 PCT</option>
									<option value="0.2">20 PCT</option>
									<option value disabled>- - - - - -</option>
									<option value="1">01 MIN</option>
									<option value="2">02 MIN</option>
									<option value="3">03 MIN</option>
									<option value="4">04 MIN</option>
									<option value="5">05 MIN</option>
									<option value="6">06 MIN</option>
									<option value="7">07 MIN</option>
									<option value="8">08 MIN</option>
									<option value="9">09 MIN</option>
									<option value="10">10 MIN</option>
									<option value="11">11 MIN</option>
									<option value="12">12 MIN</option>
									<option value="13">13 MIN</option>
									<option value="14">14 MIN</option>
									<option value="15">15 MIN</option>
									<option value="20">20 MIN</option>
									<option value="25">25 MIN</option>
									<option value="30">30 MIN</option>
								</select>
							</div>
						</div>

						<div class="form-group row card-text">
							<label class="col-sm-7 col-form-label">Reserve</label>
							<div class="col-sm-5">
								<select name="resvrule" class="custom-select" required>
									<option value="auto" selected>AUTO</option>
									<option value="0">0 MIN</option>
									<option value="15">15 MIN</option>
									<option value="30">30 MIN</option>
									<option value="35">35 MIN</option>
									<option value="40">40 MIN</option>
									<option value="45">45 MIN</option>
									<option value="60">60 MIN</option>
									<option value="75">75 MIN</option>
									<option value="90">90 MIN</option>
								</select>
							</div>
						</div>

						<input type="hidden" name="etops" value="0">
						<input type="hidden" name="stepclimbs" value="0">
						<input type="hidden" name="tlr" value="0">
						<input type="hidden" name="notams" value="0">
						<input type="hidden" name="firnot" value="0">

					</div>

				</div>

			</div>

		</div>

		<div class="card mb-4">

			<div class="card-body">

				<div class="form-text">

					<div class="form-group">
						<label>Custom Route</label>
						<textarea name="route" class="form-control" placeholder="LEAVE BLANK TO GENERATE AUTOMATICALLY" rows="3"></textarea>
					</div>

					<input type="hidden" name="reqid" value="<?php echo $row['id']; ?>">

					<input type="button" onclick="simbriefsubmit('output.php');" class="btn btn-primary btn-lg" value="Dispatch">
					<button type="reset" class="btn btn-secondary btn-lg">Cancel</button>

				</div>

			</div>

		</div>

	</form>

<?php } ?>

<script>
	function startTime() {
	    var today = new Date();
	    var h = today.getHours();
	    var m = today.getMinutes();
	    h = checkTime(h);
	    m = checkTime(m);
	    document.getElementById('time').innerHTML = h + "" + m + "Z";
	    var t = setTimeout(startTime, 500);
	}
	function checkTime(i) {
	    if (i < 10) {i = "0" + i};  // add zero in front of numbers < 10
	    return i;
	}
	startTime();
</script>

<?php require_once('../assets/layout/footer.php'); ?>
