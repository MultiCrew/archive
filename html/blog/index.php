<?php

$global_section = 'about';
$page = 'blog';
$title = ' - Blog';
include $_SERVER['DOCUMENT_ROOT'].'/../config.php';
include 'core.php';
include $_SERVER['DOCUMENT_ROOT'].'/../global_header.php';

function trunc($phrase, $max_words) {
	$phrase_array = explode(' ',$phrase);
	if(count($phrase_array) > $max_words && $max_words > 0)
		$phrase = implode(' ',array_slice($phrase_array, 0, $max_words)).' ...';
	return $phrase;
}

?>

<div class="container mt-4">

	<div class="text-center mb-4">
		<h1 class="display-2">Dev Blog</h1>
		<p class="lead">You can expect regular development updates from the MultiCrew development team detailing progress, what's been achieved since the last update and what's coming up in the near future too.</p>
	</div>

	<div class="row">

		<div class="col-md-8">

			<?php

			$posts = $blog->getPosts($mysqli);

			while ($post = $posts->fetch_array()) {

				$date = new DateTime($post['postDate']); ?>

				<div class="card mb-4">

					<div class="card-body">

						<h3 class="card-title"><a href="viewpost.php?id=<?= $post['postID'] ?>"><?= $post['postTitle'] ?></a></h3>

						<p class="card-text"><?= trunc($post['postCont'], 50) ?></p>

						<a class="card-text btn btn-primary" href="viewpost.php?id=<?= $post['postID'] ?>">Read<i class="fas fa-angle-double-right fa-fw ml-2"></i></a>

					</div>

					<div class="card-footer">
						Posted at <?= date_format($date, 'H:i e, D j F y') ?>
					</div>

				</div>

			<?php } ?>

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
