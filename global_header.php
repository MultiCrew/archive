<!doctype html>
<html lang="en">

	<head>

		<!-- google analytics
		<script async src="https://www.googletagmanager.com/gtag/js?id=UA-107332493-1"></script>
		<script>
		  window.dataLayer = window.dataLayer || [];
		  function gtag(){dataLayer.push(arguments)};
		  gtag('js', new Date());
		  gtag('config', 'UA-107332493-1');
		</script>-->

		<!-- meta and branding -->
		<meta charset="utf-8">
		<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
		<meta name="description" content="<?php if (isset($pagedesc)) { echo $pagedesc; } else { echo 'MultiCrew is community-driven flight simulation organisation that provides training and support for shared cockpit aircraft addons.'; } ?>">
		<meta name="keywords" content="multicrew, multicrew academy, multicrew copilot, multicrew forums, multicrew portal, academy, copilot, forums, portal, shared cockpit, flight simulation, flight sim, connected flight deck, p3d, prepar3d, p3dv4, xp11, x-plane, x-plane 11, fsx, fsx:se, flight simulator x">
		<link rel="icon" href="<?= PROTOCOL ?>://www.<?= DOMAIN ?>/assets/img/favicon.ico">
		<title><?php if (isset($title)) { echo 'MultiCrew'.$title; } else { echo 'MultiCrew'; } ?></title>

		<!-- bootstrap -->
		<?php if ( isset($page) && ( $page=='login' || $page=='register' ) ) { ?>
			<link rel="stylesheet" type="text/css" href="<?= PROTOCOL ?>://www.<?= DOMAIN ?>/assets/css/bootstrap.css">
		<?php } else { ?>
			<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.2.1/css/bootstrap.min.css" integrity="sha384-GJzZqFGwb1QTTN6wy59ffF1BuGJpLSa9DkKMp0DgiMDm4iYMj70gZWKYbI706tWS" crossorigin="anonymous">
		<?php } ?>

		<!-- font awesome -->
		<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.6.3/css/all.css" integrity="sha384-UHRtZLI+pbxtHCWp1t77Bi1L4ZtiqrqD80Kn4Z8NTSRyMA2Fd33n5dQ8lWUE00s/" crossorigin="anonymous">

		<!-- custom css -->
		<link rel="stylesheet" type="text/css" href="<?= PROTOCOL ?>://www.<?= DOMAIN ?>/assets/css/custom.css">
		<?php if (isset($sect) && $sect == 'copilot') { ?>
			<link rel="stylesheet" type="text/css" href="<?= PROTOCOL ?>://copilot.<?= DOMAIN ?>/assets/css/copilot.css">
		<?php } ?>

		<!-- custom js -->
		<?php if (isset($page) && $page == 'plan') { ?>
			<script type="text/javascript" src="simbrief.apiv1.js"></script>
		<?php }	elseif (isset($page) && $page == 'register') { ?>
			<script src='https://www.google.com/recaptcha/api.js'></script>
		<?php } ?>

	</head>

	<body>

		<!-- dark navbar, expads at XL -->
		<nav class="navbar sticky-top navbar-expand-xl <?php if ( isset($page) && ( $page=='login' || $page=='register' ) ) echo 'navbar-light bg-light'; else echo 'navbar-dark bg-dark'; ?>" <?php if (isset($sect) && $sect=='copilot') { echo ` style="background-color: #353a3f; height: 60px; font: 'Trebuchet MS';"`; } ?>>

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
