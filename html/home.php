<?php

$global_section = 'home';
$title = ' - Home';
include $_SERVER['DOCUMENT_ROOT'].'/../config.php';
include $_SERVER['DOCUMENT_ROOT'].'/../global_header.php';

?>

<!-- header image -->
<div class="" id="home-header" class="justify-contents-center p-5" style="background: url(<?= PROTOCOL ?>://www.<?= DOMAIN ?>/assets/img/747.jpg) no-repeat center center fixed;">
	<div class="p-5">
		<h1 class="text-white text-center display-2 mt-5">MultiCrew</h1>
		<h5 class="text-white text-center lead">The home of shared cockpit</h5>
	</div>
</div>
<!--/END header image -->

<div class="container">

	<div class="row my-4 align-items-center">

		<!-- about us -->
		<div class="col-md-8">
			<h1 class="display-3">Welcome</h1>
			<p class="lead">We're all about bringing people from the aviation industry and the flight simulation community together to enjoy flight simulators. We are a community-driven, non-profit organisation, which specialises in shared cockpit flying, training and support. Find out more about the services we provide to enhance your virtual flying below!</p>
		</div>
		<!-- /END about us -->

		<!-- latest blog -->
		<div class="col-md-4">

			<div class="card">

				<h3 class="card-header">Latest News</h3>

				<div class="card-body">

					<?php

					$connect->dbDefineCredentials('blog');
					$mysqli = $connect->dbConnect();

					$sql = 'SELECT * FROM blog_posts ORDER BY postDate DESC';
					$result = $mysqli->query($sql);
					$row = $result->fetch_array();

					// get most recent blog post
					$postID = $row['postID'];
					$postTitle = $row['postTitle'];
					$postDesc = $row['postDesc'];
					$postDateTime = new DateTime($row['postDate']);
					$postTime = date_format($postDateTime, 'H:i');
					$postDate = date_format($postDateTime, 'D j M Y');

					$mysqli->close();

					?>

					<h6><?php echo $postTitle; ?></h6>
					<p class="card-text"><?php echo $postDesc; ?></p>
					<a class="btn btn-primary text-center" href="<?= PROTOCOL ?>://www.<?= DOMAIN ?>/blog/viewpost.php?id=<?php echo $postID; ?>">
						Read &raquo;
					</a>

				</div>

				<div class="card-footer text-muted text-center">
					Posted <?php echo $postTime.' UTC, '.$postDate; ?>
				</div>

			</div>

		</div>
		<!-- /END latest blog -->

	</div>

</div>

<div class="py-4 bg-primary">

	<div class="container my-4">

		<h1 class="display-4 text-center text-white">Looking for...</h1>

		<div class="card-columns align-items-center">

			<div class="card text-white bg-success">
				<div class="card-body text-center">
					<h5 class="card-title">Shared Cockpit Flights?</h5>
					<p class="card-text">MultiCrew Copilot is a unique system which helps users to organise and dispatch shared cockpit flights. You need a MultiCrew Portal account, and you need to be on our Discord server, too. Check it out below!</p>
					<a href="<?= PROTOCOL ?>://copilot.<?= DOMAIN ?>/" class="btn btn-outline-light">
						<i class="fas fa-plane"></i> &nbsp;Copilot
					</a>
				</div>
			</div>

			<div class="card bg-danger text-white">
				<div class="card-body text-center">
					<h5 class="card-title">Aircraft Training?</h5>
					<p class="card-text">The MultiCrew Academy has all the resources and expertise to get you your flight sim type rating! Our comprehensive courses and experienced instructors are here to teach you the basics or the ins-and-outs of every system of your favourite shared cockpit aircraft!</p>
					<a href="<?= PROTOCOL ?>://academy.<?= DOMAIN ?>/" class="btn btn-outline-light">
						<i class="fas fa-fw fa-chalkboard-teacher mr-2"></i>Academy
					</a>
				</div>
			</div>

			<div class="card bg-warning">
				<div class="card-body text-center">
					<h5 class="card-title">Flight Sim Support?</h5>
					<p class="card-text">MultiCrew provides <strong>unofficial</strong> support for shared cockpit capable aircraft for FSX and P3D (all versions) throughout various social media and other platforms. Use Discord server or Facebook groups to get the help you need!</p>
				</div>
			</div>

			<div class="card text-white bg-info">
				<div class="card-body text-center">
					<h5 class="card-title">A Place to Chat?</h5>
					<p class="card-text">Coming soon, the MultiCrew Forums will provide a centralised place for all shared cockpit discussion! Check out our <a href="/blog/index.php">Dev Blog</a> for updates on development progress.</p>
				</div>
			</div>

			<div class="card text-white bg-dark">
				<div class="card-body text-center">
					<h5 class="card-title">VoIP Comms?</h5>
					<p class="card-text">We have a Discord server ready and waiting for you to chat to other flight simmers or communicate during shared cockpit or group flights!</p>
					<a href="https://discord.gg/3jHRAkE" class="btn btn-outline-light">
						<i class="fab fa-discord"></i> &nbsp;Discord
					</a>
				</div>
			</div>

			<div class="card bg-light">
				<div class="card-body text-center">
					<h5 class="card-title">Pilot Tools?</h5>
					<p class="card-text">MultiCrew is affiliated with ATC-Com, a website which provides useful tools to sim pilots. You can check these out at ATC-Com's website below!</p>
					<a href="http://atccom.de/" class="btn btn-outline-dark">
						<i class="fas fa-wrench"></i> &nbsp;ATC-Com
					</a>
				</div>
			</div>

		</div>

	</div>

</div>

<div id="home-infopanel" style="background: url(<?= PROTOCOL ?>://www.<?= DOMAIN ?>/assets/img/dash_lhrg.jpg) no-repeat center center fixed;">

	<div class="container">
		<div class="p-5">
			<div class="jumbotron my-5">
				<h1 class="display-4">Our History</h1>
				<p class="lead">We've always been focused on shared cockpit flying in the flight simulation community, but read on to find out how we started</p>
				<hr>
				<p>MultiCrew was an idea coined by two high school students in late 2016 as a brand name to encompass some social media groups promoting shared cockpit flying. Starting out as a Facebook page, several iterations of a static website containing information and advice on shared cockpit were developed, and since then many more changes have been made. The development of the MultiCrew Academy required a comprehensive web-based system to make it as easy as possible for users to use, and the website grew. Now it's the home to a whole host of useful tools and resources, whilst being interactive and useful to users to help them with our three main goals: flying, training and support.</p>
			</div>
		</div>
	</div>

	<?php include $_SERVER['DOCUMENT_ROOT'].'/../footer_plain.php'; ?>
