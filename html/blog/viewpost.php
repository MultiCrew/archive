<?php

$global_section = 'about';
$page = 'blog';
$title = ' - Blog';
include $_SERVER['DOCUMENT_ROOT'].'/../config.php';
include 'core.php';
include $_SERVER['DOCUMENT_ROOT'].'/../global_header.php';

?>

<div class="container mt-4">

	<div class="text-center mb-4">
		<h1 class="display-2">Dev Blog</h1>
		<p class="lead">You can expect regular development updates from the MultiCrew development team detailing progress, what's been achieved since the last update and what's coming up in the near future too.</p>
	</div>

	<div class="row">

		<div class="col-md-8">

			<?php
			$post = $blog->getPost($mysqli, $_GET['id']);
			$date = new DateTime($post['postDate']);
			$content = str_replace('<img', '<img class="img-fluid"', $post['postCont']);
			$content = str_replace('<p>Written', '<p class="lead">Written', $content);
			?>

			<h3 class="card-title"><?= $post['postTitle'] ?></h3>
			<hr>
			<div class="row align-items-center">
				<div class="col-auto align-middle">
					Posted at <?= date_format($date, 'H:i e, D j F y') ?>
				</div>
				<div class="col">
					<a href="index.php" class="btn btn-secondary float-right">
						<i class="fas fa-angle-double-left fa-fw mr-2"></i>Back
					</a>
				</div>
			</div>
			<hr>

			<?= $content; ?>

			<hr>

			<a class="btn btn-secondary mb-3" href="index.php"><i class="fas fa-fw fa-angle-double-left mr-2"></i>Back</a>

		</div>

		<div class="col-md-4">

			<?php if ($sso->logged_in() && $sso->get_user_data('type')=='admin') { ?>
				<a href="admin/index.php" class="btn btn-primary text-center mx-auto mb-3">Blog Admin</a>
			<?php } ?>

			<?php /*<div class="card mb-4">

				<h3 class="card-header">Search</h3>

				<div class="card-body">
					<div class="input-group">
						<input type="text" class="form-control" placeholder="Keywords">
						<div class="input-group-append">
							<button class="btn btn-outline-secondary"><i class="fas fa-search"></i></button>
						</div>
					</div>
				</div>

			</div>*/ ?>

			<div class="card mb-4">

				<h3 class="card-header">Advertisement</h3>

				<div class="card-body">
					<script async src="//pagead2.googlesyndication.com/pagead/js/adsbygoogle.js"></script>
					<!-- Forums sidebar -->
					<ins class="adsbygoogle"
					     style="display:block;"
					     data-ad-client="ca-pub-2977998344849380"
					     data-ad-slot="3395572306"
					     data-ad-format="auto"></ins>
					<script>
					(adsbygoogle = window.adsbygoogle || []).push({});
					</script>
				</div>

			</div>

		</div>

	</div>

	<?php include $_SERVER['DOCUMENT_ROOT'].'/../footer_plain.php'; ?>
