<?php

$global_section = 'about';
$page = 'blog';
$title = ' - Blog';
include $_SERVER['DOCUMENT_ROOT'].'/../config.php';
include '../core.php';
include $_SERVER['DOCUMENT_ROOT'].'/../global_header.php';
$blog->checkAdmin($sso);

?>

<div class="container mt-4">

	<div class="text-center mb-4">
		<h1 class="display-2">Dev Blog</h1>
		<p class="lead">You can expect regular development updates from the MultiCrew development team detailing progress, what's been achieved since the last update and what's coming up in the near future too.</p>
	</div>

	<?php if (isset($_GET['action']) && $_GET['action']=='added') { ?>
		<div class="alert alert-success alert-dismissible fade show mb-3">
			Post was created!
			<button class="close" data-dismiss="alert">
				<span>&times;</span>
			</button>
		</div>
	<?php } elseif (isset($_GET['action']) && $_GET['action']=='updated') { ?>
		<div class="alert alert-success alert-dismissible fade show mb-3">
			Post was updated!
			<button class="close" data-dismiss="alert">
				<span>&times;</span>
			</button>
		</div>
	<?php } elseif (isset($_GET['action']) && $_GET['action']=='deleted') { ?>
		<div class="alert alert-warning alert-dismissible fade show mb-3">
			Post was deleted!
			<button class="close" data-dismiss="alert">
				<span>&times;</span>
			</button>
		</div>
	<?php } ?>

	<p class="text-right">
		<a class="btn btn-primary" href="post_create.php">
			<i class="fas fa-plus fa-fw mr-2"></i>New Post
		</a>
		<a class="btn btn-secondary" href="/blog/index.php">
			<i class="fas fa-home fa-fw mr-2"></i>Blog Home
		</a>
	</p>

	<table class="table table-hover table-striped border">

		<thead class="thead-light">
			<tr>
				<th>Title</th>
				<th>Date</th>
				<th></th>
			</tr>
		</thead>

		<tbody>

			<?php

			$posts = $blog->getPosts($mysqli);

			while ($post = $posts->fetch_array()) {

				$date = new DateTime($post['postDate']); ?>

				<tr>

					<td><?= $post['postTitle'] ?></td>
					<td><?= date_format($date, 'H:i e, D j F y') ?></td>

					<td>
						<a href="post_edit.php?id=<?= $post['postID'] ?>">
							<i class="fa fa-edit fa-fw mr-1"></i>Edit
						</a>
						&middot;
						<a href="post_delete.php?id=<?= $post['postID'] ?>">
							<i class="fa fa-trash fa-fw mr-1"></i>Delete
						</a>
					</td>

				</tr>

			<?php } ?>

		</tbody>

	</table>

	<?php include $_SERVER['DOCUMENT_ROOT'].'/../footer_plain.php'; ?>
