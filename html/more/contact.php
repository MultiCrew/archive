<?php

$title = ' - Contact Us';
include $_SERVER['DOCUMENT_ROOT'].'/../config.php';
include $_SERVER['DOCUMENT_ROOT'].'/../global_header.php';

?>

<!-- Page Content -->
<div class="container mb-4">

	<div class="text-center mb-4">
		<h1 class="display-2">Contact Us</h1>
		<p class="lead">You can get in touch with us through many different communication methods.</p>
	</div>

	<div class="row">

		<div class="col-md-6">

			<div class="card mb-3">

				<h3 class="card-header"><i class="fas fa-envelope fa-fw mr-2"></i>Email</h3>

				<div class="card-body">

					<p class="card-title">Email is the best way to get in touch formally. If you have a serious enquiry or a comprehensive message, please use the appropriate email address below!</p>

					<table class="table table-sm table-striped card-text border">
						<tbody>
							<tr>
								<td>admin@multicrew.co.uk</td>
								<td>General Enquiries</td>
							</tr>
							<tr>
								<td>support@multicrew.co.uk</td>
								<td>Support Queries</td>
							</tr>
							<tr>
								<td>web@multicrew.co.uk</td>
								<td>Bug Reports, Suggestions</td>
							</tr>
							<tr>
								<td><a href="/about/staff.php">Staff Addresses</a></td>
								<td>Personal Enquiries</td>
							</tr>
						</tbody>
					</table>

				</div>

			</div>

		</div>

		<div class="col-md-6">

			<div class="card">

				<h3 class="card-header"><i class="fas fa-retweet fa-fw mr-2"></i>Social Media</h3>

				<div class="card-body">

					<p class="card-title">Just looking to send a quick message or keep up-to-date with us? Check out our social media below, and make sure you follow us to stay in the loop!</p>

					<table class="table table-sm table-striped card-text border">
						<tbody>
							<tr>
								<td><i class="fab fa-facebook-f fa-fw mr-2"></i></td>
								<td><a href="http://fb.me/flymulticrew">fb.me/flymulticrew</a></td>
							</tr>
							<tr>
								<td><i class="fab fa-twitter fa-fw mr-2"></i></td>
								<td><a href="https://twitter.com/flymulticrew">twitter.com/flymulticrew</a></td>
							</tr>
							<tr>
								<td><i class="fab fa-youtube fa-fw mr-2"></i></td>
								<td><a href="https://www.youtube.com/channel/UCT7U2Ss79D76FkyRsNIadMA">youtube.com/channel/UCT7U2Ss79D76FkyRsNIadMA</a></td>
							</tr>
							<tr>
								<td><i class="fab fa-twitch fa-fw mr-2"></i></td>
								<td><a href="http://twitch.tv/multicrew">twitch.tv/multicrew</a></td>
							</tr>
						</tbody>
					</table>

				</div>

			</div>

		</div>

	</div>

	<?php include $_SERVER['DOCUMENT_ROOT'].'/../footer_plain.php'; ?>
