<?php

$sect = 'copilot';
$title = ' - Copilot';
$page = 'index';

include 'assets/includes/core.php';

?>

<?php if ( $sso->get_user_data('type')=='admin' || $sso->get_user_data('type')=='beta tester' || $sso->get_user_data('type')=='web' ) { ?>

	<?php if (1==1 || isset($configAsk) && $configAsk) { ?>
		<div class="alert alert-warning text-light">
			<div class="row align-items-center">
				<div class="col">It looks like this is the first time you've used Copilot. Would you like to configure your settings?</div>
				<div class="col-auto text-right">
					<a class="btn btn-success btn-sm" href="configure.php">Configure</a>
					<button class="btn btn-outline-secondary btn-sm" onclick="window.location.reload(true)">Cancel</button>
				</div>
			</div>
		</div>
	<?php } ?>

	<div class="row my-4">

		<div class="col-lg-7">

			<div class="card my-md-3 my-lg-auto">
				<div class="card-body">

					<h4 class="card-title">Active Now</h4>

					<div class="table-responsive-md">

						<table class="card-text table table-hover">
							<tbody>
								<tr>
									<td>Not yet implemented!</td>
								</tr>
							</tbody>
						</table>

					</div>

				</div>
			</div>

		</div>

		<div class="col-lg-5">

			<div class="card my-md-3 my-lg-auto">
				<div class="card-body">

					<h4 class="card-title">Development News</h4>

						<table class="card-text table table-hover" style="table-layout: fixed;">

							<?php

							$connect->dbDefineCredentials('blog');
							$blog = $connect->dbConnect();

							$stmt = $blog->prepare('SELECT * FROM blog_posts WHERE postTitle LIKE "Dev Blog%" ORDER BY postDate DESC LIMIT 3');
							$stmt->execute();
							$result = $stmt->get_result();
							$stmt->close();

							while ($row = $result->fetch_array()) { ?>

								<tr>
									<td class="text-truncate" style="width: 80%;"><?= str_replace("Dev Blog", "", $row['postTitle']) ?></td>
									<td class="text-right" style="width: 20%;"><a class="btn btn-primary btn-sm py-0 px-2 my-0 mx-0 border-0" href="https://www.multicrew.co.uk/blog/viewpost.php?id=<?= $row['postID']; ?>">Read &raquo;</a></td>
								</tr>

							<?php } ?>

						</table>



				</div>
			</div>

		</div>

	</div>

	<div class="card">
		<div class="card-body">

			<h4 class="card-title">Welcome</h4>

			<p class="card-text">Copilot allows you to search, create your own and accept requests for shared cockpit flights. Upon accepting requests, users are put in touch with each other to organise crew roles, flight plans, etc.</p>

			<ol class="card-text">
				<li>To get started, make sure you have your Discord ID in your MultiCrew Portal acconunt. More info is available upon <a href="https://discord.gg/3jHRAkE">joining our Discord server</a>.</li>
				<li>Next, either search for reqests on the "Search Requests" page, or add a request on the "Manage Requests" page.</li>
				<li>You will both receive further information from the "MTC Copilot" Bot on Discord. From here, you can contact each other and organise the rest of the flight.</li>
				<li>We recommend you make use of the custom SimBrief dispatch system which forms part of Copilot. You can find it on the "Dispatch" navbar link.</li>
			</ol>

			<p class="card-text">Enjoy your flight! If you need any help using Copilot, please feel free to contact a member of staff!</p>

		</div>
	</div>

<?php } else { ?>

	<h1 class="display-1 text-center">Coming soon...</h1>

	<p class="lead text-center mt-5"><strong>Release date:</strong> TBA</p>

	<p class="lead text-center">To find out more, visit the <a href="help/index.php">Help page</a></p>

<?php }

$call = 'copilot'; include $_SERVER['DOCUMENT_ROOT'].'/../footer_plain.php'; ?>
