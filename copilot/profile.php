<?php

$sect = 'copilot';
$title = ' - Copilot';
$page = 'search';

require_once('assets/includes/core.php');

if (isset($_GET['id'])) {

	$id = $_GET['id'];
	$usrnm = $sso->get_user_data('username', $id);
	$name = $sso->get_user_data('name', $id);

	$stmt = $mysqli->prepare('SELECT * FROM profiles WHERE user_id=?');
	$stmt->bind_param('i', $id);
	$stmt->execute();
	$result = $stmt->get_result();
	$prefs = $result->fetch_array();
	$profile = $prefs;
	$stmt->close();


} else {
	$copilot->redirect('search.php');
	die();
}

?>

<div class="card mb-4">

	<div class="card-body">

		<h4 class="card-title">View Profile</h4>

		<div class="card w-75 mx-auto bg-secondary mb-4">

			<div class="card-body">

				<div class="row align-items-center">

					<?php
					foreach ($sso->db->query('SELECT pic FROM users WHERE id='.$sso->get_user_data('id', $id)) as $row) {
						$ext = $row['pic'];
						$file = $sso->get_user_data('username', $id).'.'.$ext;
					}
					if ($ext!='' && file_exists('/var/www/portal/pic/'.$file)) { ?>
						<div class="col-md-auto"><div class="rounded-circle mx-auto" style="background: url(<?= 'https://portal.multicrew.co.uk/pic/'.$file; ?>); background-repeat: no-repeat; background-size: auto 200px; background-position: center; height: 200px; width: 200px;"></div></div>
					<?php } else { ?>
						<div class="col-md-auto"><img src="https://portal.multicrew.co.uk/pic/default.png" class="rounded-circle img-thumbnail img-fluid mx-auto"></div>
					<?php } ?>

					<div class="col-md">

						<div class="form-group">
							<label>Username</label>
							<input type="text" readonly value="<?php echo $usrnm; ?>" class="form-control">
						</div>

						<div class="form-group">
							<label>Full Name</label>
							<input type="text" readonly value="<?php echo $name; ?>" class="form-control">
						</div>

					</div>

				</div>

			</div>

		</div>

		<div class="card-text">

			<h5>Simulator Config</h5>

			<div class="form-row">

				<div class="form-group col-md-3">
					<label>Simulator <span class="text-danger">*</span></label>
					<?php
					if (isset($prefs['sim']) && $prefs['sim']=='fsx1') { $sim = 'Microsoft Flight Simulator X'; }
					elseif (isset($prefs['sim']) && $prefs['sim']=='fsxs') { $sim = 'Microsoft Flight Simulator X: Steam Edition'; }
					elseif (isset($prefs['sim']) && $prefs['sim']=='p3d3') { $sim = 'Lockheed Martin Prepar3D v1-3'; }
					elseif (isset($prefs['sim']) && $prefs['sim']=='p3d4') { $sim = 'Lockheed Martin Prepar3D v4'; }
					elseif (isset($prefs['sim']) && $prefs['sim']=='xp10') { $sim = 'Laminar Research X-Plane v8-10'; }
					elseif (isset($prefs['sim']) && $prefs['sim']=='xp11') { $sim = 'Laminar Research X-Plane v11'; }
					elseif (isset($prefs['sim']) && $prefs['sim']=='afs2') { $sim = 'Aerofly FS 2'; }
					else { $sim = 'Not set!'; }
					?>
					<input type="text" class="form-control" readonly value="<?= $sim; ?>">
				</div>

				<div class="form-group col-md-3">
					<label>Scenery <span class="text-danger">*</span></label>
					<?php
					if (isset($prefs['scenery']) && $prefs['scenery']=='default') { $scenery = 'Default Scenery'; }
					elseif (isset($prefs['scenery']) && $prefs['scenery']=='orbxvector') { $scenery = 'ORBX FTX Vector'; }
					elseif (isset($prefs['scenery']) && $prefs['scenery']=='othermesh') { $scenery = 'Other 3rd Party Mesh'; }
					else { $scenery = 'Not set!'; }
					?>
					<input type="text" class="form-control" readonly value="<?= $scenery; ?>">
				</div>

				<div class="form-group col-md-3">
					<label>Weather Engine <span class="text-danger">*</span></label>
					<?php
					if (isset($prefs['wxengine']) && $prefs['wxengine']=='default') { $wxengine = 'Default Weather / No 3rd Party Engine'; }
					elseif (isset($prefs['wxengine']) && $prefs['wxengine']=='asn') { $wxengine = 'Active Sky Next'; }
					elseif (isset($prefs['wxengine']) && $prefs['wxengine']=='as16') { $wxengine = 'Active Sky 2016 (32-bit for FSX/P3Dv1-3)'; }
					elseif (isset($prefs['wxengine']) && $prefs['wxengine']=='asp4') { $wxengine = 'Active Sky (64-bit for P3Dv4)'; }
					elseif (isset($prefs['wxengine']) && $prefs['wxengine']=='rex') { $wxengine = 'REX SkyForce'; }
					elseif (isset($prefs['wxengine']) && $prefs['wxengine']=='fsgrw') { $wxengine = 'FS Global Real Weather'; }
					elseif (isset($prefs['wxengine']) && $prefs['wxengine']=='fsxwx') { $wxengine = 'FSXWX'; }
					elseif (isset($prefs['wxengine']) && $prefs['wxengine']=='noaa') { $wxengine = 'NOAA Weather Plugin for XP11'; }
					elseif (isset($prefs['wxengine']) && $prefs['wxengine']=='xenviro') { $wxengine = 'XEnviro for XP11'; }
					elseif (isset($prefs['wxengine']) && $prefs['wxengine']=='other') { $wxengine = 'Other'; }
					else { $wxengine = 'Not set!'; }
					?>
					<input type="text" class="form-control" readonly value="<?= $wxengine; ?>">
				</div>

				<div class="form-group col-md-3">
					<label>Nav Data <span class="text-danger">*</span></label>
					<?php
					if (isset($prefs['airac']) && $prefs['airac']=='ltst') { $airac = 'Latest'; }
					elseif (isset($prefs['airac']) && $prefs['airac']=='tsyr') { $airac = 'This year'; }
					elseif (isset($prefs['airac']) && $prefs['airac']=='lsyr') { $airac = 'Last year'; }
					elseif (isset($prefs['airac']) && $prefs['airac']=='oldr') { $airac = 'Older'; }
					else { $airact = 'Not set!'; }
					?>
					<input type="text" class="form-control" readonly value="<?= $airac; ?>">
				</div>

			</div>

			<h5>Flying Style</h5>

			<div class="form-row">

				<div class="form-group col-md-4">
					<label data-toggle="tooltip" data-placement="right" title="Please indicate your level of experience level with using shared cockpit">
						Shared Cockpit Level <i class="far fa-question-circle"></i>
					</label>
					<?php
					if (isset($prefs['level']) && $prefs['level']=='beg') { $level = 'Beginner'; }
					elseif (isset($prefs['level']) && $prefs['level']=='int') { $level = 'Intermediate'; }
					elseif (isset($prefs['level']) && $prefs['level']=='adv') { $level = 'Advanced'; }
					else { $level = 'Not set!'; }
					?>
					<input type="text" class="form-control" readonly value="<?= $level; ?>">
				</div>

				<div class="form-group col-md-4">
					<label data-toggle="tooltip" data-placement="right" title="Please indicate the method you prefer to use when making shared cockpit connetions">
						Connection Method <i class="far fa-question-circle"></i>
					</label>
					<?php
					if (isset($prefs['conn']) && $prefs['conn']=='nopf') { $conn = 'No preference'; }
					elseif (isset($prefs['conn']) && $prefs['conn']=='ptfw') { $conn = 'Port Forwarding'; }
					elseif (isset($prefs['conn']) && $prefs['conn']=='hmch') { $conn = 'Hamachi / Other Tunneling Engine'; }
					else { $conn = 'Not set!'; }
					?>
					<input type="text" class="form-control" readonly value="<?= $conn; ?>">
				</div>

				<div class="form-group col-md-4">
					<label data-toggle="tooltip" data-placement="right" title="Please indicate whether you prefer to follow any specific procedures when flying shared cockpit">
						Procedures <i class="far fa-question-circle"></i>
					</label>
					<?php
					if (isset($prefs['procs']) && $prefs['procs']=='nopref') { $procs = 'No preference'; }
					elseif (isset($prefs['procs']) && $prefs['procs']=='beg') { $procs = 'Beginner - Looking to learn'; }
					elseif (isset($prefs['procs']) && $prefs['procs']=='mtcflow') { $procs = 'MultiCrew flows - I use flows from the Internet'; }
					elseif (isset($prefs['procs']) && $prefs['procs']=='realworld') { $procs = 'Real World - I follow real-world procedures'; }
					else { $procs = 'Not set!'; }
					?>
					<input type="text" class="form-control" readonly value="<?= $procs; ?>">
				</div>

			</div>

			<a class="btn btn-primary btn-lg card-text" href="<?php if (isset($_GET['from'])) { echo $_GET['from']; } else { echo 'search'; } ?>.php"><i class="fas fa-angle-double-left"></i> &nbsp;Back</a>

		</div>

	</div>

</div>

<?php $call = 'copilot'; include $_SERVER['DOCUMENT_ROOT'].'/../footer_plain.php'; ?>
