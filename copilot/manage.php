<?php

$sect = 'copilot';
$title = ' - Copilot';
$page = 'manage';

require_once('assets/includes/core.php');

if (isset($_POST['deleted'])) {

	// get disord ID of request
	$stmt = $mysqli->prepare('SELECT discord FROM `requests` WHERE id=?');
	$stmt->bind_param("i", $_POST['id']);
	$stmt->execute();
	$result = $stmt->get_result();
	$row = $result->fetch_array();
	$discord = $row['discord'];
	$stmt->close();

	// get username from discord id
	$namesquery = $sso->db->query('SELECT id FROM `users` WHERE discord='.$discord);
	foreach ($namesquery as $names) {
		$name = $names['id'];
	}

	// do not delete if discord id and portal id don't correspond
	if ($name==$sso->get_user_data('id')) {

		$stmt = $mysqli->prepare('DELETE FROM `requests` WHERE id=?');
		$stmt->bind_param("i", $_POST['id']);
		$stmt->execute();
		$stmt->close();
		$deleted = true;

	} else { $notuser = true; }

} elseif (isset($_POST['add'])) {

	$copilot->request_create($mysqli, $_POST, $sso);

} elseif (isset($_POST['unaccept'])) {

	// double-check one of the involved users is the current user
	$stmt = $mysqli->prepare('SELECT * FROM accepted WHERE id=?');
	$stmt->bind_param("s", $_POST['id']);
	$stmt->execute();
	$result = $stmt->get_result();
	$row = $result->fetch_array();

	if ($row['acceptee']==$sso->get_user_data('discord') || $row['requestee']==$sso->get_user_data('discord')) {

		$stmt->close();

		$stmt = $mysqli->prepare('INSERT INTO requests VALUES (?,?,?,?,?)');
		$stmt->bind_param("sssss", $row['id'], $row['requestee'], $row['aircraft'], $row['dep'], $row['arr']);
		$stmt->execute();
		$stmt->close();

		$stmt = $mysqli->prepare('DELETE FROM accepted WHERE id=?');
		$stmt->bind_param("s", $_POST['id']);
		$stmt->execute();
		$unaccepted = true;

	} else {

		$unaccepterr = true;

	}

	$stmt->close();

} elseif (isset($_POST['prefs'])) {

	$stmt = $mysqli->prepare('SELECT * FROM profiles WHERE user_id=?');
	$user_id = $sso->get_user_data('id');
	$stmt->bind_param('i', $user_id);
	$stmt->execute();
	$result = $stmt->get_result();
	$stmt->close();

	if ($result->num_rows!=0) {		// update if already exists
		$stmt = $mysqli->prepare('UPDATE profiles SET sim=?, scenery=?, wxengine=?, airac=?, conn=?, level=?, procs=? WHERE user_id=?');
		$stmt->bind_param('sssssssi', $_POST['sim'], $_POST['scenery'], $_POST['wxengine'], $_POST['airac'], $_POST['conn'], $_POST['level'], $_POST['procs'], $user_id);
		$stmt->execute();
		$stmt->close();
	} else {		// make new row if new prefs
		$stmt = $mysqli->prepare('INSERT INTO profiles VALUES (?,?,?,?,?,?,?,?)');
		$stmt->bind_param('isssssss', $user_id, $_POST['sim'], $_POST['scenery'], $_POST['wxengine'], $_POST['airac'], $_POST['conn'], $_POST['level'], $_POST['procs']);
		$stmt->execute();
		$stmt->close();
	}

}

if (isset($added)) { ?>
	<div class="alert alert-success alert-dismissible fade show">
		Your request was added!
		<button type="button" class="close" data-dismiss="alert">
			<span>&times;</span>
		</button>
	</div>
<?php } ?>

<div class="card mb-4">

	<div class="card-body text-center mx-auto">

		<h4 class="card-title">Add Request</h4>

		<form action="" method="POST" class="form-inline card-text">

			<input type="text" name="aircraft" placeholder="ACFT" class="form-control mx-1 mb-2" autocomplete="off" tabindex="1" required>

			<input type="text" name="dep" placeholder="ADEP" class="form-control mx-1 mb-2" autocomplete="off" tabindex="2" required>

			<input type="text" name="arr" placeholder="ADES" class="form-control mx-1 mb-2" autocomplete="off" tabindex="3" required>

			<button type="submit" name="add" value="true" class="btn btn-primary mx-1 mb-2" tabindex="4"><i class="fas fa-plus fa-fw mr-2"></i>Add</button>

		</form>

	</div>

</div>

<?php if (isset($deleted)) { ?>
	<div class="alert alert-warning alert-dismissible fade show mb-4">
		Your request was deleted.
		<button type="button" class="close" data-dismiss="alert">
			<span>&times;</span>
		</button>
	</div>
<?php } elseif (isset($notuser)) { ?>
	<div class="alert alert-danger alert-dismissible fade show mb-4">
		That request does not appear to belong to you. The request was not deleted.
		<button type="button" class="close" data-dismiss="alert">
			<span>&times;</span>
		</button>
	</div>
<?php } elseif (isset($unaccepted)) { ?>
	<div class="alert alert-warning alert-dismissible fade show mb-4">
		You unaccepted the request.
		<button type="button" class="close" data-dismiss="alert">
			<span>&times;</span>
		</button>
	</div>
<?php } elseif (isset($unaccepterr)) { ?>
	<div class="alert alert-warning alert-dismissible fade show mb-4">
		<strong>An error occurred.</strong> Perhaps that request does not belong to you.
		<button type="button" class="close" data-dismiss="alert">
			<span>&times;</span>
		</button>
	</div>
<?php } ?>

<div class="row">

	<div class="col-md-6">

		<div class="card mb-4">

			<div class="card-body">

				<h4 class="card-title">My Requests</h4>

				<table class="table table-striped table-hover card-text table-main">

					<thead>
						<tr>
							<th>#</th>
							<th><samp>ACFT</samp></th>
							<th><samp>ADEP</samp></th>
							<th><samp>ADES</samp></th>
							<th></th>
						</tr>
					</thead>

					<tbody>

						<?php

						$stmt = $mysqli->prepare('SELECT * FROM `requests` WHERE discord='.$sso->get_user_data('discord'));
						$stmt->execute();
						$result = $stmt->get_result();

						if ($result->num_rows!=0) {

							while ($row = $result->fetch_array()) {	?>

								<tr>
									<td class="align-middle"><?php echo $row['id']; ?></td>
									<td class="align-middle"><samp><?php echo $row['aircraft']; ?></samp></td>
									<td class="align-middle"><samp><?php echo $row['dep']; ?></samp></td>
									<td class="align-middle"><samp><?php echo $row['arr']; ?></samp></td>
									<td class="align-middle text-center">
										<form action="" method="POST" id="delReq<?php echo $row['id']; ?>">
											<input type="hidden" name="id" value="<?php echo $row['id']; ?>">
											<input type="hidden" name="deleted" value="true">
											<a href="#" class="btn btn-danger btn-sm" onclick="document.getElementById('delReq<?php echo $row['id']; ?>').submit()">
												<i class="far fa-trash-alt"></i> &nbsp; Delete
											</a>
										</form>
									</td>
								</tr>

							<?php }

						} else { ?>

							<tr>
								<td colspan="6">No requests!</td>
							</tr>

						<?php } $stmt->close(); ?>

					</tbody>

				</table>

			</div>

		</div>

	</div>

	<div class="col-md-6">

		<div class="card mb-4">

			<div class="card-body">

				<h4 class="card-title">Accepted Request</h4>

				<table class="table table-striped table-hover card-text table-main">

					<thead>
						<tr>
							<th>#</th>
							<th>Other Pilot</th>
							<th><samp>ACFT</samp></th>
							<th><samp>ADEP</samp></th>
							<th><samp>ADES</samp></th>
							<th></th>
						</tr>
					</thead>

					<tbody>

						<?php

						$stmt = $mysqli->prepare('SELECT * FROM `accepted` WHERE acceptee=? OR requestee=?');
						$discord = $sso->get_user_data('discord');
						$stmt->bind_param("ii", $discord, $discord);
						$stmt->execute();
						$result = $stmt->get_result();

						if ($result->num_rows!=0) {

							while ($row = $result->fetch_array()) {

								// get username depending on which role in the request the other pilot is
								if ($row['acceptee']==$sso->get_user_data('discord')) {
									$query = 'SELECT id,username FROM users WHERE discord='.$row['requestee'];
									foreach ($sso_db->query($query) as $names) {
										$name = $names['username'];
										$id = $names['id'];
									}
								} else {
									$query = 'SELECT id,username FROM users WHERE discord='.$row['acceptee'];
									foreach ($sso_db->query($query) as $names) {
										$name = $names['username'];
										$id = $names['id'];
									}
								}

								?>

								<tr>
									<td class="align-middle"><?php echo $row['id']; ?></td>
									<td class="align-middle text-truncate"><a href="profile.php?id=<?php echo $id; ?>&from=manage"><?php echo $name; ?></a></td>
									<td class="align-middle"><samp><?php echo $row['aircraft']; ?></samp></td>
									<td class="align-middle"><samp><?php echo $row['dep']; ?></samp></td>
									<td class="align-middle"><samp><?php echo $row['arr']; ?></samp></td>
									<td class="align-middle text-center">
										<form action="" method="POST" id="unAccept<?php echo $row['id']; ?>">
											<input type="hidden" name="unaccept" value="true">
											<input type="hidden" name="id" value="<?php echo $row['id']; ?>">
												<a href="#" class="btn btn-danger btn-sm" onclick="document.getElementById('unAccept<?php echo $row['id']; ?>').submit()">
												<i class="fas fa-times"></i> &nbsp; Unaccept
											</a>
										</form>
									</td>
								</tr>

							<?php }

						} else { ?>

							<tr>
								<td colspan="6">No requests!</td>
							</tr>

						<?php } $stmt->close(); ?>

					</tbody>

				</table>

			</div>

		</div>

	</div>

</div>

<div class="card mb-4">

	<div class="card-body">

		<h4 class="cart-text">Preferences</h4>

		<p class="card-text">All fields marked <span class="text-danger">*</span> are required. These preferences are visible to other pilots in the Search table. Please <strong>keep this section up-to-date</strong> as it helps ensure that other similarly-configured and like-minded pilots can find you!</p>

		<?php $prefqry = 'SELECT * FROM profiles WHERE user_id='.$sso->get_user_data('id'); $prefs = $mysqli->query($prefqry)->fetch_array(); ?>

		<form action="" method="POST" class="card-text">

			<div class="form-row">

				<div class="form-group col-md-3">
					<label>Simulator <span class="text-danger">*</span></label>
					<select name="sim" class="custom-select" required>
						<option disabled selected value>Please select...</option>
						<option value="fsx1" <?php if (isset($prefs['sim']) && $prefs['sim']=='fsx1') { echo 'selected'; } ?>>Microsoft Flight Simulator X</option>
						<option value="fsxs" <?php if (isset($prefs['sim']) && $prefs['sim']=='fsxs') { echo 'selected'; } ?>>Microsoft Flight Simulator X: Steam Edition</option>
						<option value="p3d3" <?php if (isset($prefs['sim']) && $prefs['sim']=='p3d3') { echo 'selected'; } ?>>Lockheed Martin Prepar3D v1-3</option>
						<option value="p3d4" <?php if (isset($prefs['sim']) && $prefs['sim']=='p3d4') { echo 'selected'; } ?>>Lockheed Martin Prepar3D v4</option>
						<option value="xp10" <?php if (isset($prefs['sim']) && $prefs['sim']=='xp10') { echo 'selected'; } ?>>Laminar Research X-Plane v8-10</option>
						<option value="xp11" <?php if (isset($prefs['sim']) && $prefs['sim']=='xp11') { echo 'selected'; } ?>>Laminar Research X-Plane v11</option>
						<option value="afs2" <?php if (isset($prefs['sim']) && $prefs['sim']=='afs2') { echo 'selected'; } ?>>Aerofly FS 2</option>
					</select>
				</div>

				<div class="form-group col-md-3">
					<label>Scenery <span class="text-danger">*</span></label>
					<select name="scenery" class="custom-select" required>
						<option disabled selected value>Please select...</option>
						<option value="default" <?php if (isset($prefs['scenery']) && $prefs['scenery']=='default') { echo 'selected'; } ?>>Default Scenery</option>
						<option value="orbxvector" <?php if (isset($prefs['scenery']) && $prefs['scenery']=='orbxvector') { echo 'selected'; } ?>>ORBX FTX Vector</option>
						<option value="othermesh" <?php if (isset($prefs['scenery']) && $prefs['scenery']=='othermesh') { echo 'selected'; } ?>>Other 3rd Party Mesh</option>
					</select>
				</div>

				<div class="form-group col-md-3">
					<label>Weather Engine <span class="text-danger">*</span></label>
					<select name="wxengine" class="custom-select" required>
						<option disabled selected value>Please select...</option>
						<option value="default" <?php if (isset($prefs['wxengine']) && $prefs['wxengine']=='default') { echo 'selected'; } ?>>Default Weather / No 3rd Party Engine</option>
						<option value="asn" <?php if (isset($prefs['wxengine']) && $prefs['wxengine']=='asn') { echo 'selected'; } ?>>Active Sky Next</option>
						<option value="as16" <?php if (isset($prefs['wxengine']) && $prefs['wxengine']=='as16') { echo 'selected'; } ?>>Active Sky 2016 (32-bit for FSX/P3Dv1-3)</option>
						<option value="asp4" <?php if (isset($prefs['wxengine']) && $prefs['wxengine']=='asp4') { echo 'selected'; } ?>>Active Sky (64-bit for P3Dv4)</option>
						<option value="rex" <?php if (isset($prefs['wxengine']) && $prefs['wxengine']=='rex') { echo 'selected'; } ?>>REX SkyForce</option>
						<option value="fsgrw" <?php if (isset($prefs['wxengine']) && $prefs['wxengine']=='fsgrw') { echo 'selected'; } ?>>FS Global Real Weather</option>
						<option value="fsxwx" <?php if (isset($prefs['wxengine']) && $prefs['wxengine']=='fsxwx') { echo 'selected'; } ?>>FSXWX</option>
						<option value="noaa" <?php if (isset($prefs['wxengine']) && $prefs['wxengine']=='noaa') { echo 'selected'; } ?>>NOAA Weather Plugin for XP11</option>
						<option value="xenviro" <?php if (isset($prefs['wxengine']) && $prefs['wxengine']=='xenviro') { echo 'selected'; } ?>>XEnviro for XP11</option>
						<option value="other" <?php if (isset($prefs['wxengine']) && $prefs['wxengine']=='other') { echo 'selected'; } ?>>Other</option>
					</select>
				</div>

				<div class="form-group col-md-3">
					<label>Nav Data <span class="text-danger">*</span></label>
					<select name="airac" class="custom-select" required>
						<option disabled selected value>Please select...</option>
						<option value="ltst" <?php if (isset($prefs['airac']) && $prefs['airac']=='ltst') { echo 'selected'; } ?>>Latest</option>
						<option value="tsyr" <?php if (isset($prefs['airac']) && $prefs['airac']=='tsyr') { echo 'selected'; } ?>>This year</option>
						<option value="lsyr" <?php if (isset($prefs['airac']) && $prefs['airac']=='lsyr') { echo 'selected'; } ?>>Last year</option>
						<option value="oldr" <?php if (isset($prefs['airac']) && $prefs['airac']=='oldr') { echo 'selected'; } ?>>Older</option>
					</select>
				</div>

			</div>

			<div class="form-row">

				<div class="form-group col-md-4">
					<label data-toggle="tooltip" data-placement="right" title="Please indicate your level of experience level with using shared cockpit">
						Shared Cockpit Level <i class="far fa-question-circle"></i>
					</label>
					<select name="level" class="custom-select">
						<option value="beg" <?php if (isset($prefs['level']) && $prefs['level']=='beg') { echo 'selected'; } ?>>Beginner</option>
						<option value="int" <?php if (isset($prefs['level']) && $prefs['level']=='int') { echo 'selected'; } ?>>Intermediate</option>
						<option value="adv" <?php if (isset($prefs['level']) && $prefs['level']=='adv') { echo 'selected'; } ?>>Advanced</option>
					</select>
				</div>

				<div class="form-group col-md-4">
					<label data-toggle="tooltip" data-placement="right" title="Please indicate the method you prefer to use when making shared cockpit connetions">
						Connection Method <i class="far fa-question-circle"></i>
					</label>
					<select name="conn" class="custom-select">
						<option value="nopf" <?php if (isset($prefs['conn']) && $prefs['conn']=='nopf') { echo 'selected'; } ?>>No preference</option>
						<option value="ptfw" <?php if (isset($prefs['conn']) && $prefs['conn']=='ptfw') { echo 'selected'; } ?>>Port Forwarding</option>
						<option value="hmch" <?php if (isset($prefs['conn']) && $prefs['conn']=='hmch') { echo 'selected'; } ?>>Hamachi / Other Tunneling Engine</option>
					</select>
				</div>

				<div class="form-group col-md-4">
					<label data-toggle="tooltip" data-placement="right" title="Please indicate whether you prefer to follow any specific procedures when flying shared cockpit">
						Procedures <i class="far fa-question-circle"></i>
					</label>
					<select name="procs" class="custom-select">
						<option value="nopref" <?php if (isset($prefs['procs']) && $prefs['procs']=='nopref') { echo 'selected'; } ?>>No preference</option>
						<option value="beg" <?php if (isset($prefs['procs']) && $prefs['procs']=='beg') { echo 'selected'; } ?>>Beginner - Looking to learn</option>
						<option value="mtcflow" <?php if (isset($prefs['procs']) && $prefs['procs']=='mtcflow') { echo 'selected'; } ?>>MultiCrew flows - I use flows from the Internet</option>
						<option value="realworld" <?php if (isset($prefs['procs']) && $prefs['procs']=='realworld') { echo 'selected'; } ?>>Real World - I follow real-world procedures</option>
					</select>
				</div>

			</div>

			<button type="submit" name="prefs" class="btn btn-primary"><i class="far fa-save"></i> &nbsp;Save</button>

		</form>

	</div>

</div>

<script>
	$(document).ready(function(){
		$('[data-toggle="tooltip"]').tooltip();
	});
</script>

<?php $call = 'copilot'; include $_SERVER['DOCUMENT_ROOT'].'/../footer_plain.php'; ?>
