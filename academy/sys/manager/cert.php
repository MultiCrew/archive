<?php

$tab = 'sys';
$page = 'cert';
include $_SERVER['DOCUMENT_ROOT'].'/assets/layout/header.php';
include $_SERVER['DOCUMENT_ROOT'].'/assets/layout/sidebar_sys.php';

$stmt = $mysqli->prepare('SELECT * FROM cert');
$stmt->execute();
$result = $stmt->get_result();
$stmt->close();

?>

<div class="row">
	<div class="col-sm-8"><h3>Certifications</h3></div>
</div>

<p>Users will appear in this table after completing at least one mentoring session, <strong>and the instructor has reported on it</strong>.</p>

<input class="form-control mt-1 mb-1" type="text" id="search" data-table="order-table" placeholder="Start typing to search users...">

<table class="table table-striped table-sm table-hover border" id="cert">

	<?php if ($result->num_rows!=0){ ?>

	<thead class="thead-dark">
		<tr>
			<th>Student Name</th>
			<th>Student Username</th>
			<th>A320</th>
			<th>A330</th>
			<th>DH8D</th>
			<th>B712</th>
			<th class="text-right"></th>
		</tr>
	</thead>

	<tbody>

		<?php while ($row = $result->fetch_array()) { ?>

		<tr>
			<td><?php echo $sso->get_user_data('name', $row['users.id']); ?></td>
			<td><?php echo $sso->get_user_data('username', $row['users.id']); ?></td>
			<td class="<?php echo ($academy->cert_info($row, "a320", "class"))?>"><?php echo ($academy->cert_info($row, "a320", "text"))?></td>
			<td class="<?php echo ($academy->cert_info($row, "a330", "class"))?>"><?php echo ($academy->cert_info($row, "a330", "text"))?></td>
			<td class="<?php echo ($academy->cert_info($row, "dh8d", "class"))?>"><?php echo ($academy->cert_info($row, "dh8d", "text"))?></td>
			<td class="<?php echo ($academy->cert_info($row, "b712", "class"))?>"><?php echo ($academy->cert_info($row, "b712", "text"))?></td>
			<td class="text-center">
				<form action="cert_edit.php" method="POST" id="<?php echo $row['users.id']; ?>">
					<input type="hidden" name="userid" value="<?php echo $row['users.id']; ?>">
					<a href="#" onclick="document.getElementById('<?php echo $row['users.id']; ?>').submit();"><i class="fas fa-pencil-alt"></i> Edit</a>
				</form>
			</td>
		</tr>

	<?php } ?>

	</tbody>

<?php } ?>

</table>

<script>
	var $rows = $('#cert tr:not(:first)');
	$('#search').keyup(function() {
		var val = $.trim($(this).val()).replace(/ +/g, ' ').toLowerCase();

		$rows.show().filter(function() {
			var text = $(this).text().replace(/\s+/g, ' ').toLowerCase();
			return !~text.indexOf(val);
		}).hide();
	});
</script>

<?php $call = 'academy'; include $_SERVER['DOCUMENT_ROOT'].'/../footer_sys.php'; ?>
