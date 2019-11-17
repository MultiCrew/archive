<?php

$tab = 'sys';
$page = 'dashboard';
include $_SERVER['DOCUMENT_ROOT'].'/assets/layout/header.php';
include $_SERVER['DOCUMENT_ROOT'].'/assets/layout/sidebar_sys.php';

// get enrolled course
$stmt = $mysqli->prepare('SELECT active FROM enrolment WHERE `users.id`=?');
$user_id = $sso->get_user_data('id');
$stmt->bind_param('i', $user_id);
$stmt->execute();
$courses = $stmt->get_result();
$course = $courses->fetch_array();

// get booked sessions
$stmt = $mysqli->prepare('SELECT * FROM sessions WHERE `users.id`=? AND reported=?');
$user_id = $sso->get_user_data('id');
$reported = 0;
$stmt->bind_param('ii', $user_id, $reported);
$stmt->execute();
$sessions = $stmt->get_result();

?>

<h1 class="display-4">Dashboard</h1>
<p class="lead">myAcademy is your place to manage your MultiCrew training! Here you can view basic statistics.</p>

<hr>

<h5>
	Enrolled course:
	<span class="badge badge-info">
		<?= strtoupper($course['active']) ?>
	</span>

<h5>
	Booked sessions:
	<span class="badge <?php if ($sessions->num_rows==0) echo 'badge-warning'; else echo 'badge-info'; ?>">
		<?= $sessions->num_rows ?>
	</span>
</h5>

<?php $call = 'academy'; include $_SERVER['DOCUMENT_ROOT'].'/../footer_sys.php'; ?>
