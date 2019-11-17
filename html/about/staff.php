<?php

$global_section = 'about';
$page = 'staff';
$title = ' - Home';
include $_SERVER['DOCUMENT_ROOT'].'/../config.php';
include $_SERVER['DOCUMENT_ROOT'].'/../global_header.php';

?>

<!-- Page Content -->
<div class="container mb-4">

	<div class="text-center mb-4">
		<h1 class="display-2">Staff</h1>
		<p class="lead">The Staff team put in a tremendous effort to develop and expand MultiCrew's services and resources. Of course, we are always looking for more people to get involved, so if you've got some skills you can bring to the team, just email <a href="mailto:&#097;&#100;&#109;&#105;&#110;&#064;&#109;&#117;&#108;&#116;&#105;&#099;&#114;&#101;&#119;&#046;&#099;&#111;&#046;&#117;&#107;">&#097;&#100;&#109;&#105;&#110;&#064;&#109;&#117;&#108;&#116;&#105;&#099;&#114;&#101;&#119;&#046;&#099;&#111;&#046;&#117;&#107;</a>!</p>
	</div>

	<h3 class="text-center mt-4 mb-3">Administration Team</h3>

	<div class="card-deck">

		<div class="card mb-3">

			<div class="card-body">
				<h4 class="card-title text-center">Founder</h4>
				<h5 class="card-subtitle text-muted text-center">Harry Cameron</h5>

				<div class="mx-auto text-center"><img width="200" class="img-thumbnail img-responsive rounded-circle my-3" src="<?= PROTOCOL ?>://portal.<?= DOMAIN ?>/pic/AdmagTwoXRay.png" alt="Harry Cameron"></div>

				<p class="card-text text-justify">Harry, the founding member of staff, comprises half of the admin team. Harry's responsibilities are to set the wheels in motion for new projects and improvements, and to ensure everything runs smoothly from the top-down. He's also in charge of our Finances, so he's certainly kept busy behind the scenes! Harry is looking to join the RAF in the future, so his passion for flying is certainly strong.</p>

				<h5 class="card-subtitle text-muted">Contact</h5>
				<p class="card-text"><strong>Email: </strong><a href="mailto:&#104;&#097;&#114;&#114;&#121;&#064;&#109;&#117;&#108;&#116;&#105;&#099;&#114;&#101;&#119;&#046;&#099;&#111;&#046;&#117;&#107;">&#104;&#097;&#114;&#114;&#121;&#064;&#109;&#117;&#108;&#116;&#105;&#099;&#114;&#101;&#119;&#046;&#099;&#111;&#046;&#117;&#107;</a><br>
				<strong>Username: </strong>AdmagTwoXray</p>

			</div>

		</div>

		<div class="card mb-3">

			<div class="card-body">
				<h4 class="card-title text-center">Chief Operations Officer</h4>
				<h5 class="card-subtitle text-muted text-center">Calum Shepherd</h5>

				<div class="mx-auto text-center"><img width="200" class="img-thumbnail img-responsive rounded-circle my-3" src="<?= PROTOCOL ?>://portal.<?= DOMAIN ?>/pic/DoverEightMike.png" alt="Calum Shepherd"></div>

				<p class="card-text text-justify">Calum completes the admin team by taking charge of Operations and Web Development. He keeps the wheels in motion and steers everyone in the right direction. Most of the original web development work and site structure was taken care of by Calum. In his spare time, Calum is a ski racer, competing internationally during the winter season.</p>

				<h5 class="card-subtitle text-muted">Contact</h5>
				<p class="card-text"><strong>Email: </strong><a href="mailto:&#099;&#097;&#108;&#117;&#109;&#064;&#109;&#117;&#108;&#116;&#105;&#099;&#114;&#101;&#119;&#046;&#099;&#111;&#046;&#117;&#107;">&#099;&#097;&#108;&#117;&#109;&#064;&#109;&#117;&#108;&#116;&#105;&#099;&#114;&#101;&#119;&#046;&#099;&#111;&#046;&#117;&#107;</a><br>
				<strong>Username: </strong>DoverEightMike</p>

			</div>

		</div>

	</div>

	<hr>

	<h3 class="text-center mt-4 mb-3">Recruitment</h3>

	<p>MultiCrew is always looking for keen, mature and respectful individuals to join its team of volunteers to help make its services better! If you think you can help with our projects, development or administration, please don't hesitate to get in touch!</p>

	<?php include $_SERVER['DOCUMENT_ROOT'].'/../footer_plain.php'; ?>
