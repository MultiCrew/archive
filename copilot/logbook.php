<?php

$sect = 'copilot';
$title = ' - Copilot';
$page = 'logbook';

require_once('assets/includes/core.php');

?>

<div class="card">

	<div class="card-body">

		<h4 class="card-title">Logbook</h4>

		<div class="table-responsive">

			<table class="table table-hover card-text table-main">

				<thead>
					<tr>
						<th>ID</th>
						<th>Requestee</th>
						<th>Acceptee</th>
						<th><samp>ACFT</samp></th>
						<th><samp>ADEP</samp></th>
						<th><samp>ADES</samp></th>
						<th>Date</th>
					</tr>
				</thead>

				<tbody>

					<?php

					$stmt = $mysqli->prepare('SELECT * FROM `logbook` WHERE requestee=? or acceptee=?');
					$discord = $sso->get_user_data('discord');
					$stmt->bind_param("ss", $discord, $discord);
					$stmt->execute();
					$result = $stmt->get_result();

					if ($result->num_rows!=0) {

						while ($row = $result->fetch_array()) {

							$query = $sso->db->query('SELECT username FROM users WHERE discord='.$row['acceptee']);
							$acceptee = $query->fetch(PDO::FETCH_ASSOC);
							$query = $sso->db->query('SELECT username FROM users WHERE discord='.$row['requestee']);
							$requestee = $query->fetch(PDO::FETCH_ASSOC);

							$mysqldate = DateTime::createFromFormat('Y-m-d H:i:s', $row['date']);
							$date = $mysqldate->format('H:i T j M Y');

							?>

							<tr>
								<td class="align-middle"><?php echo $row['id']; ?></td>
								<td class="align-middle"><?php echo $acceptee['username']; ?></td>
								<td class="align-middle"><?php echo $requestee['username']; ?></td>
								<td class="align-middle"><samp><?php echo $row['aircraft']; ?></samp></td>
								<td class="align-middle"><samp><?php echo $row['dep']; ?></samp></td>
								<td class="align-middle"><samp><?php echo $row['arr']; ?></samp></td>
								<td class="align-middle"><samp><?php echo $date; ?></samp></td>
							</tr>

						<?php }

					} else { ?>

						<tr>
							<td colspan="7">No logged flights!</td>
						</tr>

					<?php }

					$stmt->close();

					?>

				</tbody>

			</table>

		</div>

	</div>

</div>

<?php $call = 'copilot'; include $_SERVER['DOCUMENT_ROOT'].'/../footer_plain.php'; ?>
