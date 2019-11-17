<?php

$tab = 'sys';
$page = 'instr';
include $_SERVER['DOCUMENT_ROOT'].'/assets/layout/header.php';
include $_SERVER['DOCUMENT_ROOT'].'/assets/layout/sidebar_sys.php';

$stmt = $mysqli->prepare('SELECT * FROM instr');
$stmt->execute();
$result = $stmt->get_result();
$row1 = $result->fetch_array();
$stmt->close();

$sql = 'SELECT id FROM users WHERE type="instructor" OR type="trngman" OR type="admin"';
foreach ($sso->db->query($sql) as $row) {
	$stmt2 = $mysqli->prepare('SELECT * FROM instr WHERE `users.id`=?');
	$stmt2->bind_param("i", $row['id']);
	$stmt2->execute();
	$result = $stmt2->get_result();
	if ($result->num_rows==0) {
		$stmt1 = $mysqli->prepare('INSERT INTO instr (`users.id`) VALUES (?)');
		$stmt1->bind_param("i", $row['id']);
		$stmt1->execute();
	}
	continue;
}

$stmt = $mysqli->prepare('SELECT `users.id` FROM instr');
$stmt->execute();
$result = $stmt->get_result();
while ($row = $result->fetch_array()) {
	$stmt = $sso->db->prepare('SELECT * FROM users WHERE id=?');
	$stmt->execute(array($row['users.id']));
	$type = $stmt->fetchAll(PDO::FETCH_ASSOC)[0]['type'];
	if ($type!="admin" && $type!="trngman" && $type!="instructor") {
		$stmt = $mysqli->prepare('DELETE FROM instr WHERE `users.id`=?');
		$stmt->bind_param("i", $row['users.id']);
		$stmt->execute();
		$stmt->close();
	}
}

$stmt = $mysqli->prepare('SELECT * FROM instr');
$stmt->execute();
$result = $stmt->get_result();

?>

<h3>Instructors</h3>

<input class="form-control mt-2 mb-1" type="text" id="search" data-table="order-table" placeholder="Start typing to search users...">

<table class="table table-striped table-hover table-sm border" id="instr">

	<thead class="thead-dark">
		<tr>
			<th>Full Name</th>
			<th>Username</th>
			<th>A320</th>
			<th>A330</th>
			<th>DH8D</th>
			<th>B712</th>
			<th></th>
		</tr>
	</thead>

	<tbody>

		<?php while ($row = $result->fetch_array()) { ?>
			<tr>
				<td><?php echo $sso->get_user_data('name', $row['users.id']); ?></td>
				<td><?php echo $sso->get_user_data('username', $row['users.id']); ?></td>
				<td class="<?php if ($row['a320']=="1") { echo "table-success"; } else { echo "table-danger"; } ?>"><?php if ($row['a320']=="1") { echo "1";} else { echo "0"; } ?></td>
				<td class="<?php if ($row['a330']=="1") { echo "table-success"; } else { echo "table-danger"; } ?>"><?php if ($row['a330']=="1") { echo "1";} else { echo "0"; } ?></td>
				<td class="<?php if ($row['dh8d']=="1") { echo "table-success"; } else { echo "table-danger"; } ?>"><?php if ($row['dh8d']=="1") { echo "1";} else { echo "0"; } ?></td>
				<td class="<?php if ($row['b712']=="1") { echo "table-success"; } else { echo "table-danger"; } ?>"><?php if ($row['b712']=="1") { echo "1";} else { echo "0"; } ?></td>
				<td class="text-center">
					<form action="instructors_edit.php" method="POST" id="<?php echo $row['users.id']; ?>">
						<input type="hidden" name="userid" value="<?php echo $row['users.id']; ?>">
						<a href="#" onclick="document.getElementById('<?php echo $row['users.id']; ?>').submit();"><i class="fas fa-pencil-alt"></i> Edit</a>
					</form>
				</td>
			</tr>
		<?php } ?>

	</tbody>

</table>

<script>
var $rows = $('#instr tr:not(:first)');
$('#search').keyup(function() {
    var val = $.trim($(this).val()).replace(/ +/g, ' ').toLowerCase();

    $rows.show().filter(function() {
        var text = $(this).text().replace(/\s+/g, ' ').toLowerCase();
        return !~text.indexOf(val);
    }).hide();
});
</script>

<?php $call = 'academy'; include $_SERVER['DOCUMENT_ROOT'].'/../footer_sys.php'; ?>
