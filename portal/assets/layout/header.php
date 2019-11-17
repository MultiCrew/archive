<?php

$global_section = 'portal';
$title = ' - Portal';

include $_SERVER['DOCUMENT_ROOT'].'/../global_header.php';

?>

<div class="container-fluid d-lg-none bg-light border-bottom p-3">

	<ul class="nav nav-pills flex-column flex-md-row">
		<?php $viewport = 'small'; include 'nav_links.php'; ?>
	</ul>

</div>

<div class="container-fluid">

	<div class="row">

		<nav class="col-lg-2 bg-light sidebar d-none d-lg-block">

			<ul class="nav nav-pills flex-column">
				<?php $viewport = 'large'; include 'nav_links.php'; ?>
			</ul>

		</nav>

		<main class="col-lg-10 offset-lg-2 pt-2 mb-5 pb-4">
