<?php

$global_section = 'academy';
$title = ' - Academy';
include $_SERVER['DOCUMENT_ROOT'].'/../config.php';
include $_SERVER['DOCUMENT_ROOT'].'/assets/core.php';
include $_SERVER['DOCUMENT_ROOT'].'/../global_header.php';

?>

<div class="container-fluid border-bottom bg-light" style="position: fixed; z-index: 999;">

	<nav class="nav nav-pills py-3">
		<a class="nav-item nav-link <?php if (isset($tab) && $tab=='general') echo 'active'; ?>" href="/index.php">General</a>
		<a class="nav-item nav-link <?php if (isset($tab) && $tab=='sys') echo 'active'; ?>" href="/sys/student/dashboard.php">myAcademy</a>
		<a class="nav-item nav-link disabled <?php if (isset($tab) && $tab=='a320') echo 'active'; ?>" href="<?php /*/a320/index.php*/ ?>#">Aerosoft A320</a>
		<a class="nav-item nav-link disabled <?php if (isset($tab) && $tab=='a330') echo 'active'; ?>" href="<?php /*/a330/index.php*/ ?>#">Aerosoft A330</a>
		<a class="nav-item nav-link disabled <?php if (isset($tab) && $tab=='dh8d') echo 'active'; ?>" href="<?php /*/dh8d/index.php*/ ?>#">Majestic Q400</a>
		<a class="nav-item nav-link disabled <?php if (isset($tab) && $tab=='b712') echo 'active'; ?>" href="<?php /*/b712/index.php*/ ?>#">TFDi B717</a>
		<a class="nav-item nav-link disabled <?php if (isset($tab) && $tab=='support') echo 'active'; ?>" href="<?php /*/support/index.php*/?>#">Support</a>
	</nav>

</div>

<div class="container-fluid" style="padding-top: 73px; padding-bottom: 45px;">

	<div class="row">
