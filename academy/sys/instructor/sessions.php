<?php

$tab = 'sys';
$page = 'sessions';
include $_SERVER['DOCUMENT_ROOT'].'/assets/layout/header.php';
include $_SERVER['DOCUMENT_ROOT'].'/assets/layout/sidebar_sys.php';

// get the aircraft that the instructor can mentor on
$stmt = $mysqli->prepare('SELECT * FROM instr WHERE `users.id`=?');
$user_id = $sso->get_user_data('id');
$stmt->bind_param("i", $user_id);
$stmt->execute();
$acft = $stmt->get_result()->fetch_assoc();
unset($acft['users.id']);
$key = array_search("", $acft);
$remove = array(0);
$acft = array_diff($acft, $remove);

?>

<h3>Pending Requests</h3>

<table class="table table-hover table-striped table-sm border">

	<thead class="thead-dark">
		<tr>
			<th>Username</th>
			<th>Full name</th>
			<th>Aircraft</th>
			<th></th>
		</tr>
	</thead>

	<tbody>

		<?php

		$stmt = $mysqli->prepare('SELECT `users.id`, COUNT(DISTINCT `date` OR stime OR ftime) AS id FROM availability GROUP BY `users.id`');
		$stmt->execute();
		$result = $stmt->get_result();

		if ($result->num_rows != 0) {

			while ($row1 = $result->fetch_array()) {

				$stmt = $mysqli->prepare('SELECT * FROM enrolment WHERE `users.id`=?');
				$stmt->bind_param("i", $row1['users.id']);
				$stmt->execute();
				$row2 = $stmt->get_result()->fetch_array();

				if (array_key_exists($row2['active'], $acft)) { ?>

					<tr>
						<td><?php echo $sso->get_user_data('username', $row2['users.id']); ?></td>
						<td><?php echo $sso->get_user_data('name', $row2['users.id']); ?></td>
						<td><?php echo strtoupper($row2['active']); ?></td>
						<td>
							<form action="avail.php" method="POST" id="<?php echo $row2['users.id']; ?>">
								<input type="hidden" name="userid" value="<?php echo $row2['users.id']; ?>">
								<a href="#" onclick="document.getElementById('<?php echo $row2['users.id']; ?>').submit();">See avail &raquo;</a>
							</form>
						</td>
					</tr>

				<?php }

			}

		} else { ?>
			<tr>
				<td colspan="4">No requests!</td>
			</tr>
		<?php } ?>

	</tbody>

</table>

<?php $call = 'academy'; include $_SERVER['DOCUMENT_ROOT'].'/../footer_sys.php'; ?>
