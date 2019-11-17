<?php

include $_SERVER['DOCUMENT_ROOT'].'/../config.php';
$the_db = $sso->db;

if (!$sso->logged_in() and $sso->get_user_data("type") != "admin") {
	header("LOCATION: /");
	die();
}

if(isset($_POST['ban_user']) and $_POST['ban_user']) {
	$sso->discord_ban($_POST['username']);
	$ban_status = $sso->ban_user($_POST['username'], $_POST['duration']);
}

if(isset($_GET['lift'])) {
	$sso->discord_unban($_GET['lift']);
	$lift_status = $sso->lift_ban($_GET['lift']);
}

$page = 'ban';
include '../assets/layout/header.php';

?>

<h1>Manage Bans</h1>

<div class="row">

	<div class="col-lg-9">

		<?php

		if (isset($ban_status)) {
			if ($ban_status == "success") { ?>
				<div class="alert-warning">User has been banned.</div>
			<?php } else { ?>
				<div class="alert-danger">Error banning user: <?php echo $ban_status; ?></div>
		<?php } }

		if (isset($lift_status)) {
			if ($lift_status == "success") { ?>
				<div class="alert-success">The ban has been lifted.</div>
			<?php } else { ?>
				<div class="alert-danger">Error lifting ban: <?php echo $lift_status; ?></div>
		<?php } } ?>

		<div class="table-responsive">

			<table class="table table-hover table-sm table-striped border" id="dev-table">

				<thead class="thead-light">
					<th>Username</th>
					<th>Date Start</th>
					<th>Date End</th>
					<th>Status</th>
					<th>
						<div class="input-group input-group-sm search-in-form float-right">
							<div class="input-group-prepend">
								<span class="input-group-text"><i class="fas fa-fw fa-search"></i></span>
							</div>
							<input type="text" class="form-control" id="dev-table-filter" data-action="filter" data-filters="#dev-table" placeholder="Search for users" />
						</div>
					</th>
				</thead>

				<tbody>

					<?php

					$bans = $the_db->query('SELECT * FROM bans');

					foreach ($bans as $row) { ?>
						<tr>

							<td><?php echo $row['username']; ?></td>
							<td><?php echo $row['date_start']; ?></td>
							<td><?php echo $row['date_end']; ?></td>
							<td><?php
								if ($sso->is_banned($row['username']))
									echo $row['status'];
								else
									echo "Expired & lifted";
							?></td>

							<td>
								<div class="user-buttons">
									<a href="/ban&amp;lift=<?php echo $row['username']; ?>" class="btn btn-primary">Lift ban</a>
								</div>
							</td>

						</tr>

					<?php } if ($bans->rowCount==0) { ?>
						<tr>
							<td colspan="5">No current bans!</td>
						</tr>
					<?php } ?>

				</tbody>

			</table>

		</div>

	</div>

	<div class="col-lg-3">

		<div class="card">

			<h3 class="card-header">Ban a user</h5>

			<div class="card-body">

				<form name="banauser" action="/ban" method="post">

				<div class="form-group">
					<label>Username</label>
					<input type="text" class="form-control" aria-describedby="username" name="username" <?php if (isset($_GET['user'])) { ?> value="<?php echo $_GET['user']; ?>" autofocus<?php } ?>>
				</div>

				<div class="form-group">
					<label>Ban duration:</label>
					<select class="form-control custom-select" name="duration">
						<option>1 day</option>
						<option>1 week</option>
						<option>2 weeks</option>
						<option>1 month</option>
						<option>6 months</option>
						<option>1 year</option>
						<option>Forever</option>
					</select>
				</div>

				<button type="submit" class="btn btn-danger" name="ban_user" value="true">Submit</button>

			  </form>

			</div>
		</div>

	</div>

</div>

<?php include '../assets/layout/footer.php'; ?>
