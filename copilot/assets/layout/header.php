<!doctype html>
<html>

<head>

	<!-- google analytics -->
	<script async src="https://www.googletagmanager.com/gtag/js?id=UA-107332493-1"></script>
	<script>
	  window.dataLayer = window.dataLayer || [];
	  function gtag(){dataLayer.push(arguments)};
	  gtag('js', new Date());
	  gtag('config', 'UA-107332493-1');
	</script>

	<!-- bootstrap -->
	<!--<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">-->
	<link rel="stylesheet" type="text/css" href="/assets/css/bootstrap.css">
	<link rel="stylesheet" type="text/css" href="/assets/css/copilot.css">
	<link rel="stylesheet" type="text/css" href="https://www.multicrew.co.uk/assets/css/custom.css">

	<!-- font awesome -->
	<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.3.1/css/all.css" integrity="sha384-mzrmE5qonljUremFsqc01SB46JvROS7bZs3IO2EmfFsd15uHvIt+Y8vEf7N7fWAU" crossorigin="anonymous">

	<!-- meta -->
	<title>MultiCrew - Copilot</title>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
	<meta name="description" content="<?php if (isset($pagedesc)) { echo $pagedesc; } else { echo 'MultiCrew is community-driven flight simulation organisation that provides training and support for shared cockpit aircraft addons.'; } ?>">
	<meta name="keywords" content="multicrew, multicrew academy, multicrew copilot, multicrew forums, multicrew portal, academy, copilot, forums, portal, shared cockpit, flight simulation, flight sim, connected flight deck, p3d, prepar3d, p3dv4, xp11, x-plane, x-plane 11, fsx, fsx:se, flight simulator x">
	<link rel="icon" href="<?= PROTOCOL ?>://www.<?= DOMAIN ?>/assets/img/favicon.ico">

</head>

<body>

	<!-- dark navbar, expads at XL -->
	<nav class="navbar sticky-top navbar-expand-xl navbar-light">

		<!-- left aligned logo -->
		<a class="navbar-brand" href="<?= PROTOCOL ?>://www.<?= DOMAIN ?>/home.php">
			<img src="<?= PROTOCOL ?>://www.<?= DOMAIN ?>/assets/img/logo_long_light.png" height="30" alt="MultiCrew" class="align-top">
		</a>

		<!-- toggle button for small resolution -->
		<button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#mainNav">
			<span class="navbar-toggler-icon"></span>
		</button>

		<div class="collapse navbar-collapse" id="mainNav">

			<!-- main nav items -->
			<ul class="navbar-nav mr-auto">

				<li class="nav-item <?php if (isset($global_section) && $global_section == 'home') { echo 'active'; } ?>">
					<a class="nav-link" href="<?= PROTOCOL ?>://www.<?= DOMAIN ?>/home.php">
						<i class="fas fa-home"></i> &nbsp;Home
					</a>
				</li>

				<li class="nav-item dropdown <?php if (isset($global_section) && $global_section == 'about') { echo 'active'; } ?>">

					<a class="nav-link dropdown-toggle" href="#" data-toggle="dropdown">
						<i class="fas fa-info-circle"></i> &nbsp;About
					</a>

					<div class="dropdown-menu dropdown-menu-center">

						<a class="dropdown-item <?php if (isset($page) && $page == 'faqs') { echo 'active'; } ?>" href="<?= PROTOCOL ?>://www.<?= DOMAIN ?>/about/faq.php">
							<i class="fas fa-fw fa-question-circle"></i> &nbsp;FAQs
						</a>

						<a class="dropdown-item <?php if (isset($page) && $page == 'staff') { echo 'active'; } ?>" href="<?= PROTOCOL ?>://www.<?= DOMAIN ?>/about/staff.php">
							<i class="fas fa-fw fa-users"></i> &nbsp;Staff Team
						</a>

						<a class="dropdown-item <?php if (isset($page) && $page == 'partners') { echo 'active'; } ?>" href="<?= PROTOCOL ?>://www.<?= DOMAIN ?>/about/partners.php">
							<i class="far fa-fw fa-handshake"></i> &nbsp;Partners
						</a>

						<a class="dropdown-item <?php if (isset($page) && $page == 'blog') { echo 'active'; } ?>" href="<?= PROTOCOL ?>://www.<?= DOMAIN ?>/blog/">
							<i class="fas fa-fw fa-rss"></i> &nbsp;Dev Blog
						</a>

					</div>

				</li>

				<?php
				/*
				 * OLD RESOURCES DROPDOWN MENU
					<li class="nav-item dropdown <?php if (isset($global_section) && $global_section == 'resources') { echo 'active';} ?>">
						<a class="nav-link dropdown-toggle" href="#" data-toggle="dropdown">
							<i class="fas fa-book"></i> &nbsp;Resources
						</a>
						<div class="dropdown-menu dropdown-menu-center">
							<a class="dropdown-item <?php if (isset($page)) { if ($page == 'downloads') { echo 'active'; } } ?>" href="<?= PROTOCOL ?>://www.<?= DOMAIN ?>/resources/downloads.php">
								<i class="fas fa-fw fa-download"></i> &nbsp;Downloads
							</a>
							<a class="dropdown-item" href="http://atccom.de/">
								<i class="fas fa-fw fa-wrench"></i> &nbsp;Pilot Tools
							</a>
							<a class="dropdown-item <?php if (isset($page)) { if ($page == 'charts') { echo 'active'; } } ?>" href="<?= PROTOCOL ?>://www.<?= DOMAIN ?>/resources/charts.php">
								<i class="far fa-fw fa-map"></i> &nbsp;Charts
							</a>
						</div>
					</li>
				 */
				?>

				<li class="nav-item">
					<a class="nav-link" href="http://atccom.de">
						<i class="fas fa-fw fa-wrench mr-2"></i>Pilot Tools
					</a>
				</li>

				<li class="nav-item <?php if (isset($sect)) { if ($sect == 'copilot') { echo 'active'; } } ?>">
					<a class="nav-link" href="<?= PROTOCOL ?>://copilot.<?= DOMAIN ?>/index.php">
						<i class="fas fa-fw fa-plane mr-2"></i>Copilot
					</a>
				</li>

				<li class="nav-item <?php if (isset($global_section) && $global_section == 'academy') { echo 'active'; } ?>">
					<a class="nav-link" href="<?= PROTOCOL ?>://academy.<?= DOMAIN ?>/index.php">
						<i class="fas fa-fw fa-chalkboard-teacher mr-2"></i>Academy
					</a>
				</li>

			</ul>
			<!-- end main nav items -->

			<!-- portal nav items -->
			<ul class="navbar-nav ml-auto">

				<?php if ($sso->logged_in()) {	// show user menu ?>

					<li class="nav-item dropdown" href="#">

						<a class="nav-link dropdown-toggle <?php if (isset($global_section) && $global_section=='portal') { echo 'active'; } ?>" href="#" data-toggle="dropdown">
							<i class="fas fa-user mr-2"></i>Welcome, <?php echo $sso->get_user_data('username'); ?>!
						</a>

						<div class="dropdown-menu dropdown-menu-right">

							<?php if ($sso->get_user_data('type')=='admin' || $sso->get_user_data('type')=='mod') { ?>
								<small class="text-secondary ml-3 mt-3">USER</small>
							<?php } ?>

							<a class="dropdown-item <?php if (isset($page) && $page=='dashboard') { echo 'active'; } ?>" href="<?= PROTOCOL ?>://portal.<?= DOMAIN ?>/dashboard/index.php">
								<i class="fas fa-fw fa-chart-line mr-2"></i>Dashboard
							</a>

							<a class="dropdown-item <?php if (isset($page) && $page=='account') { echo 'active'; } ?>" href="<?= PROTOCOL ?>://portal.<?= DOMAIN ?>/dashboard/account.php">
								<i class="far fa-fw fa-address-card mr-2"></i>Profile
							</a>

							<?php if ($sso->get_user_data("type")=="admin" || $sso->get_user_data('type')=='mod') { ?>

								<div class="dropdown-divider"></div>

								<small class="text-secondary ml-3 mt-3">ADMINISTRATION</small>

								<a class="dropdown-item <?php if (isset($page) && $page=='admin') { echo 'active'; } ?>" href="<?= PROTOCOL ?>://portal.<?= DOMAIN ?>/dashboard/admin.php">
									<i class="fas fa-fw fa-users mr-2"></i>Manage users
								</a>

								<a class="dropdown-item <?php if (isset($page) && $page=='ban') { echo 'active'; } ?>" href="<?= PROTOCOL ?>://portal.<?= DOMAIN ?>/dashboard/ban.php">
									<i class="fas fa-fw fa-ban mr-2"></i>Manage bans
								</a>

							<?php } ?>

							<div class="dropdown-divider"></div>

							<a class="dropdown-item" href="<?= PROTOCOL ?>://portal.<?= DOMAIN ?>/logout.php">
								<i class="fas fa-fw fa-sign-out-alt mr-2"></i>Log Out
							</a>

						</div>

					</li>

				<?php } else {	// show login links ?>

					<li class="nav-item">
						<a class="nav-link" href="<?= PROTOCOL ?>://portal.<?= DOMAIN ?>/">
							<i class="fas fa-fw fa-sign-in-alt"></i> &nbsp;Login
						</a>
					</li>

					<li class="nav-item">
						<a class="nav-link" href="<?= PROTOCOL ?>://portal.<?= DOMAIN ?>/register.php">
							<i class="fas fa-fw fa-user-plus"></i> &nbsp;Register
						</a>
					</li>

				<?php } ?>

			</ul>
			<!-- /END portal nav links -->

		</div>

	</nav>
	<!-- /END dark navbar -->

	<!-- copilot title -->
	<div class="header-copilot">
		<div class="header-text text-center text-white">
			<h1 class="display-2">Copilot</h1>
			<p class="lead">Your shared cockpit dispatch system</p>
		</div>
	</div>

	<nav class="navbar navbar-expand-lg navbar-light bg-light navbar-copilot">

		<button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#mainNavbar">
			<span class="navbar-toggler-icon"></span>
		</button>

		<div class="collapse navbar-collapse justify-content-md-center" id="mainNavbar">

			<ul class="navbar-nav">

				<?php if ($sso->get_user_data('type')=='beta tester' || $sso->get_user_data('type')=='admin' || $sso->get_user_data('type')=='web') { ?>

					<li class="nav-item mx-3 <?php if (isset($page) && $page=='index') { echo 'active'; } ?>">
						<a class="nav-link" href="/index.php">
							<i class="fas fa-home fa-fw mr-2"></i>Home
						</a>
					</li>

					<li class="nav-item mx-3 <?php if (isset($page) && $page=='search') { echo 'active'; } ?>">
						<a class="nav-link" href="/search.php">
							<i class="fas fa-search fa-fw mr-2"></i>Search
						</a>
					</li>

					<li class="nav-item mx-3 <?php if (isset($page) && $page=='manage') { echo 'active'; } ?>">
						<a class="nav-link" href="/manage.php">
							<i class="fas fa-cog fa-fw mr-2"></i>Manage
						</a>
					</li>

					<li class="nav-item mx-3 <?php if (isset($page) && ($page == 'output' || $page == 'export' || $page == 'plan')) { echo 'active'; } ?>">
						<a class="nav-link" href="/dispatch/plan.php">
							<i class="fas fa-file-invoice fa-fw mr-2"></i>Dispatch
						</a>
					</li>

					<li class="nav-item mx-3 <?php if (isset($page) && $page=='logbook') { echo 'active'; } ?>">
						<a class="nav-link" href="/logbook.php">
							<i class="fas fa-atlas fa-fw mr-2"></i>Logbook
						</a>
					</li>

					<li class="nav-item mx-3 <?php if (isset($page) && $page=='help') { echo 'active'; } ?>">
						<a class="nav-link" href="/help/index.php">
							<i class="fas fa-info-circle fa-fw mr-2"></i>Help
						</a>
					</li>

					<li class="nav-item mx-3 <?php if (isset($page) && $page=='support') { echo 'active'; } ?>">
						<a class="nav-link" href="/help/support.php">
							<i class="fas fa-question-circle fa-fw mr-2"></i>Support
						</a>
					</li>

				<?php } else { ?>

					<li class="nav-item">
						<a class="nav-link <?php if ($page == 'index') { echo 'active'; } ?>" href="/index.php">
							<i class="fas fa-fw fa-home"></i> &nbsp;Home
						</a>
					</li>

					<li class="nav-item">
						<a class="nav-link <?php if ($page == 'help') { echo 'active'; } ?>" href="/help/index.php">
							<i class="fas fa-fw fa-question-circle"></i> &nbsp;Help
						</a>
					</li>

					<li class="nav-item">
						<a class="nav-link <?php if ($page == 'support') { echo 'active'; } ?>" href="/help/support.php">
							<i class="fas fa-fw fa-info-circle"></i> &nbsp;Support
						</a>
					</li>

				<?php } ?>

			</ul>

		</div>

	</nav>

	<div class="container my-4">
