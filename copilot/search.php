<?php

$sect = 'copilot';
$title = ' - Copilot';
$page = 'search';

require_once('assets/includes/core.php');

if (isset($_POST['accept'])) {

	$req_id = $_POST['reqid'];
	$acceptee = $sso->get_user_data('discord');

	$stmt = $mysqli->prepare('SELECT * FROM requests WHERE id=?');
	$stmt->bind_param("s", $req_id);
	$stmt->execute();
	$result = $stmt->get_result();
	$stmt->close();
	$request = $result->fetch_array();
	$requestee = $request['discord'];

	if ($result->num_rows!=0) {

		$stmt = $mysqli->prepare('INSERT INTO accepted VALUES (?,?,?,?,?,?)');
		$stmt->bind_param('iiisss', $req_id, $requestee, $acceptee, $request['aircraft'], $request['dep'], $request['arr']);
		$stmt->execute();
		$stmt->close();

		$stmt = $mysqli->prepare('DELETE FROM requests WHERE id=?');
		$stmt->bind_param('i', $req_id);
		$stmt->execute();
		$stmt->close();
		$accepted = true;

		/**
		* OLD SOCKET FOR IF BOT DOES THE SHITE
		$data = 'copilot,'.$req.','.$discord;

		set_time_limit(5);

		if (($socket = socket_create(AF_INET, SOCK_STREAM, 0)) === false) {
			die("Could not create socket\n");
		}

		socket_bind($socket, "127.0.0.1");

		if (($connection = socket_connect($socket, "127.0.0.1", 9000)) === false) {
			die("Could not connect to server\n");
		}

		if (socket_write($socket, $data)) {
			$accepted = true;
		} else {
			die("Error seding data");
		}

		socket_close($socket);
		*/

	} else {

		$deleted = true;

	}

}

if (isset($deleted) && $deleted) { ?>

	<div class="alert alert-danger alert-dismissible fade show">
		<strong>An error occurred. The request you tried to accept does not exist.</strong> Perhaps it's already been accepted, or the requestee deleted it.
		<button type="button" class="close" data-dismiss="alert">
			<span>&times;</span>
		</button>
	</div>

<?php } elseif (isset($accepted)) { ?>

	<div class="alert alert-success alert-dismissible fade show">
		<strong>You accepted a request!</strong> Please keep an eye Discord for further correspondance.
		<button type="button" class="close" data-dismiss="alert">
			<span>&times;</span>
		</button>
	</div>

<?php $donotdisplay = true; }

$sql = 'SELECT * FROM accepted WHERE requestee='.$sso->get_user_data('discord').' OR acceptee='.$sso->get_user_data('discord');
$result = $mysqli->query($sql);
$sql = 'SELECT * FROM plans WHERE requestee='.$sso->get_user_data('discord').' OR acceptee='.$sso->get_user_data('discord');
$result2 = $mysqli->query($sql);
$sql = 'SELECT * FROM flights WHERE requestee='.$sso->get_user_data('discord').' OR acceptee='.$sso->get_user_data('discord');
$result3 = $mysqli->query($sql);

if ($result->num_rows!=0 || $result2->num_rows!=0 || $result3->num_rows!=0) { ?>

	<div class="alert alert-warning">
		<strong>You have already accepted a reqest!</strong>
		You should dispatch and fly that flight before attempting to organise another.
	</div>

<?php $donotdisplay = true; }

if (!isset($donotdisplay)) {?>

	<div class="card">

		<div class="card-body">

			<div class="row align-items-center justify-content-between mb-2">
				<div class="col-sm-auto">
					<h4 class="card-title">Search</h4>
				</div>
				<div class="col-sm-auto">
					<button type="reset" class="btn btn-primary" onClick="window.location.reload()">
						<i class="fas fa-sync fa-fw mr-2"></i>Refresh
					</button>
				</div>
			</div>

			<p class="card-text">Use the search boxes to filter your request!</p>

			<div class="table-responsive">

				<table class="table table-hover card-text table-main" id="tableSearch">

					<thead>
						<tr>
							<th style="width: 7%;" class="align-middle">#</th>
							<th style="width: 22%;" class="align-middle">Requestee</th>
							<th style="width: 22%;" class="align-middle">Name</th>
							<th style="width: 14%;"><input type="text" class="form-control form-control-sm" id="searchAircraft" onkeyup="searchAircraft()" placeholder="ACFT"></th>
							<th style="width: 14%;"><input type="text" class="form-control form-control-sm" id="searchDep" onkeyup="searchDep()" placeholder="ADEP"></th>
							<th style="width: 14%;"><input type="text" class="form-control form-control-sm" id="searchArr" onkeyup="searchArr()" placeholder="ADES"></th>
							<th></th>
						</tr>
					</thead>

					<tbody>

						<?php

						$stmt = $mysqli->prepare('SELECT * FROM `requests`');
						$stmt->execute();
						$result = $stmt->get_result();

						if ($result->num_rows!=0) {

							while ($row = $result->fetch_array()) {

								$namesquery = $sso->db->query('SELECT id,username,name FROM users WHERE discord='.$row['discord']);
								foreach ($namesquery as $names) {
									$username = $names['username'];
									$name = $names['name'];
									$user_id = $names['id'];
								}

								?>

								<tr>
									<td class="align-middle"><?php echo $row['id']; ?></td>
									<td class="align-middle"><a href="profile.php?id=<?php echo $user_id; ?>&from=search"><?php echo $username; ?></a></td>
									<td class="align-middle"><a href="profile.php?id=<?php echo $user_id; ?>&from=search"><?php echo $name; ?></a></td>
									<td class="align-middle"><samp><?php echo $row['aircraft']; ?></samp></td>
									<td class="align-middle"><samp><?php echo $row['dep']; ?></samp></td>
									<td class="align-middle"><samp><?php echo $row['arr']; ?></samp></td>
									<td class="align-middle text-right">
										<?php if ($username!=$sso->get_user_data('username')) { ?>
											<form action="" method="POST">
												<input type="hidden" name="reqid" value="<?php echo $row['id']; ?>">
												<button type="submit" name="accept" class="btn btn-success btn-sm">
													<i class="fas fa-check"></i> &nbsp;Accept
												</button>
											</form>
										<?php } ?>
									</td>
								</tr>

							<?php }

						} else { ?>

							<tr>
								<td colspan="6">No requests!</td>
							</tr>

						<?php }

						$stmt->close();

						?>

					</tbody>

				</table>

			</div>

		</div>

	</div>

	<p class="text-muted mt-2 mb-3">Clicking on a username will show the user's profile.</p>

<?php } ?>

<script>

	function searchAircraft() {

	  // Declare variables
	  var input, filter, table, tr, td, i;

	  input = document.getElementById("searchAircraft");
	  filter = input.value.toUpperCase();
	  table = document.getElementById("tableSearch");
	  tr = table.getElementsByTagName("tr");

	  // Loop through all table rows, and hide those who don't match the search query
	  for (i = 0; i < tr.length; i++) {
	    td = tr[i].getElementsByTagName("td")[3];
	    if (td) {
	      if (td.innerHTML.toUpperCase().indexOf(filter) > -1) {
	        tr[i].style.display = "";
	      } else {
	        tr[i].style.display = "No results!";
	      }
	    }
	  }

	}

	function searchDep() {

	  // Declare variables
	  var input, filter, table, tr, td, i;

	  input = document.getElementById("searchDep");
	  filter = input.value.toUpperCase();
	  table = document.getElementById("tableSearch");
	  tr = table.getElementsByTagName("tr");

	  // Loop through all table rows, and hide those who don't match the search query
	  for (i = 0; i < tr.length; i++) {
	    td = tr[i].getElementsByTagName("td")[4];
	    if (td) {
	      if (td.innerHTML.toUpperCase().indexOf(filter) > -1) {
	        tr[i].style.display = "";
	      } else {
	        tr[i].style.display = "No results!";
	      }
	    }
	  }

	}

	function searchArr() {

	  // Declare variables
	  var input, filter, table, tr, td, i;

	  input = document.getElementById("searchArr");
	  filter = input.value.toUpperCase();
	  table = document.getElementById("tableSearch");
	  tr = table.getElementsByTagName("tr");

	  // Loop through all table rows, and hide those who don't match the search query
	  for (i = 0; i < tr.length; i++) {
	    td = tr[i].getElementsByTagName("td")[5];
	    if (td) {
	      if (td.innerHTML.toUpperCase().indexOf(filter) > -1) {
	        tr[i].style.display = "";
	      } else {
	        tr[i].style.display = "No results!";
	      }
	    }
	  }

	}

</script>

<?php $call = 'copilot'; include $_SERVER['DOCUMENT_ROOT'].'/../footer_plain.php'; ?>
