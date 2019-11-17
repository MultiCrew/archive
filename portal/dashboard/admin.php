<?php

include $_SERVER['DOCUMENT_ROOT'].'/../config.php';
$the_db = $sso->db;

if (!$sso->logged_in() || $sso->get_user_data("type") != "admin") {
	header("LOCATION: /");
	die();
}

if(isset($_POST['deleteUser'])) {
	if($_POST['username'] == $sso->get_user_data('username', $_POST['id'])) {
		$success = $sso->delete_user($_POST['id']);
	}
	else {
		$success = false;
	}
}

/**
* nifty thing that (hopefully) outputs all registered emails for manual mass-mailing ;)
*/
$emailquery = $sso->db->query('SELECT email FROM users')->fetchAll();
$emails = [];
for ($i=0; $i < sizeof($emailquery); $i++) {
	// cause PDO array queries are apparently a bag of rice
	array_push($emails, $emailquery[$i]['email']);
}
$emailstring = implode('; ', $emails);

/*
 * DO NOT USE THIS FUNCTION
	if (isset($_POST['policyEmail'])) {

		$emails = array('DoverEightMike', 'mtctest');

		foreach ($emails as $user) {
			$sso->send_email('policies', $user, 'Change to our Terms and Policies');
		}

		$emailquery = $sso->db->query('SELECT * FROM users');

		foreach ($emailquery as $user) {
			$sso->send_email('policies', $sso->get_user_data('username', $user['id']), 'Change to our Terms and Policies');
		}

	}
 */

$page = 'admin';
include '../assets/layout/header.php';

?>

<div class="row align-items-center">
	<div class="col-sm">
		<h1>Manage Users</h1>
	</div>
	<div class="col-sm-auto">
		<button class="btn btn-secondary float-right mb-2" data-toggle="modal" data-target="#emailModal">Export Emails</button>
		<button class="btn btn-info float-right mb-2 mr-2" data-toggle="modal" data-target="#changePolicies">Change of Policies</button>
	</div>
</div>

<?php if(isset($_SESSION['success'])) { if ($_SESSION['success']) { ?>
	<div class="alert alert-success alert-dismissible fade show">
		Profile edited!
		<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
	</div>
<?php $_SESSION['success'] = false; }} ?>

<div class="table-responsive">

	<table class="table table-hover table-sm table-striped border" id="dev-table">

		<thead class="thead-light">
			<th class="text-center" style="width: 4%;">#</th>
			<th style="width: 16%;">Username</th>
			<th style="width: 20%;">Name</th>
			<th style="width: 20%;">Email</th>
			<th style="width: 10%;">Birthday</th>
			<th style="width: 10%;">Type</th>
			<th style="width: 10%;">
				<div class="input-group input-group-sm search-in-form float-right">
					<div class="input-group-prepend">
						<div class="input-group-text"><i class="fas fa-fw fa-search"></i></div>
					</div>
					<input type="text" class="form-control" id="dev-table-filter" data-action="filter" data-filters="#dev-table" placeholder="Search for users">
				</div>
			</th>
		</thead>

		<tbody>

			<?php

			foreach (
				$the_db->query(
					'SELECT * FROM users u JOIN types t ON u.type = t.type ORDER BY t.rankorder DESC, u.username'
				) as $row
			) {

				// adjust formatting of dob and id
				$birthday = new DateTime($row['birthday']);
				if ($row['id']<10) $id = '000'.$row['id']; elseif ($row['id']<100) $id = '00'.$row['id']; elseif ($row['id']<1000) $id = '0'.$row['id']; else $id = $row['id'];

				// decide what colour to highlight row
				if ($row['type'] == 'admin') $context_class = 'class="table-danger"';
				elseif ($row['type'] == 'academy' || $row['type'] == 'beta tester' || $row['type'] == 'web') $context_class = 'class="table-info"';
				elseif ($row['type'] == 'mod') $context_class = 'class="table-danger"';
				elseif ($row['type'] == 'training manager') $context_class = 'class="table-danger"';
				elseif ($row['type'] == 'mentor') $context_class = 'class="table-warning"';
				elseif ($row['type'] == 'pilot') $context_class = '';
				elseif ($row['type'] == 'trainee') $context_class = '';
				else $context_class = 'class="table-active"';

				?>

				<tr <?= $context_class ?>>

					<td class="text-center"><samp><?= $id; ?></samp></td>
					<td><?= $row['username']; ?></td>
					<td><span class="text-capitalize"><?= $row['name']; ?></span></td>
					<td><?= $row['email']; ?></td>
					<td><samp><?= date_format($birthday, 'd-m-Y'); ?></samp></td>
					<td><?php echo $row['type']; ?></td>
					<td class="text-center">

						<form class="d-inline" id="editForm<?php echo $row['id']; ?>" action="user_edit.php" method="POST">
							<input type="hidden" name="editid" value="<?php echo $row['id']; ?>">
							<a href="#" onclick="document.getElementById('editForm<?php echo $row['id']; ?>').submit()"><i class="fas fa-fw fa-edit"></i> Edit</a>
						</form>
						<?php /*&middot;
						<form class="d-inline" id="delForm<?php echo $row['id']; ?>" action="user_delete.php" method="POST">
							<input type="hidden" name="delid" value="<?php echo $row['id']; ?>">
							<a href="#" onclick="document.getElementById('delForm<?php echo $row['id']; ?>').submit()"><i class="fas fa-fw fa-trash"></i> Delete</a>
						</form>*/ ?>

					</td>

				</tr>

			<?php } ?>

		</tbody>

	</table>

</div>

<?php

/*
 * BROKEN
	if (isset($_GET['delete'])) {

		if ($sso->get_user_data('username', $_GET['delete'])) { ?>

			<div class="modal show" id="deleteUser" tabindex="-1" role="dialog" aria-labelledby="deleteUserLabel">
				<div class="modal-dialog" role="document">
					<div class="modal-content">
						<div class="modal-header">
							<h4 class="modal-title" id="deleteUserLabel">Delete user: <?php echo $sso->get_user_data('username', $_GET['delete']); ?></h4>
						</div>
						<form class="form-horizontal" action="/admin" method="post">
						<input type="hidden" name="id" value="<?php echo $sso->get_user_data('id', $_GET['delete']); ?>" />
							<div class="modal-body">
								<p>Are you sure you want to delete this user? Type the username to confirm</p>
								<div class="form-group">
									<div class="col-md-8 col-md-offset-2">
										<input type="text" class="form-control border-input" id="username" name="username" placeholder = "Type user name to confirm" autofocus>
									</div>
								</div>
							</div>
						<div class="modal-footer">
							<a href="/admin" class="btn btn-default">Close</a>
							<button type="submit" class="btn btn-danger" name="deleteUser" value="true">Confirm delete</button>
						</div>
					</form>
					</div>
				</div>
			</div>

	<?php  } }
 */

if (isset($success)) { ?>
	<p class="text-success">Your action was completed sucessfully.</p>
<?php } ?>

<!-- email export modal -->
<div class="modal fade" id="emailModal" tabindex="-1" role="dialog">
	<div class="modal-dialog modal-lg" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title" id="exampleModalLabel">Email Export</h5>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>
			<div class="modal-body">
				<?php echo $emailstring; ?>
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
			</div>
		</div>
	</div>
</div>
<!-- /END email export modal -->

<?php
/*
 * MODAL FOR IMPLEMENTING MASS MAILING
	<div class="modal fade" id="changePolicies" tabindex="-1" role="dialog">
		<div class="modal-dialog" role="document">
			<div class="modal-content">
				<div class="modal-header">
					<h5 class="modal-title" id="exampleModalLabel">Change of Policies</h5>
					<button type="button" class="close" data-dismiss="modal" aria-label="Close">
						<span aria-hidden="true">&times;</span>
					</button>
				</div>
				<div class="modal-body">
					By clicking confirm, all registered users will receive an email regarding a change of Terms and Policies. Are you sure you want to continue?
				</div>
				<div class="modal-footer">
					<form action="" method="POST">
						<button type="submit" name="policyEmail" class="btn btn-primary">Confirm</button>
					</form>
					<button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
				</div>
			</div>
		</div>
	</div>
 */

?>

<?php include '../assets/layout/footer.php'; ?>
