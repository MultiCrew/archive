<?php

include $_SERVER['DOCUMENT_ROOT'].'/../config.php';

?>

<!doctype html>
<html lang="en" id="landing">

	<head>

		<!-- google analytics -->
		<script async src="<?= PROTOCOL ?>://www.googletagmanager.com/gtag/js?id=UA-107332493-1"></script>
		<script>
		  window.dataLayer = window.dataLayer || [];
		  function gtag(){dataLayer.push(arguments)};
		  gtag('js', new Date());
		  gtag('config', 'UA-107332493-1');
		</script>

		<!-- metadata -->
		<meta charset="utf-8">
		<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
		<meta name="description" content="<?php if (isset($pagedesc)) { echo $pagedesc; } else { echo 'MultiCrew is community-driven flight simulation organisation that provides training and support for shared cockpit aircraft addons.'; } ?>">
		<meta name="keywords" content="multicrew, multicrew academy, multicrew copilot, multicrew forums, multicrew portal, academy, copilot, forums, portal, shared cockpit, flight simulation, flight sim, connected flight deck, p3d, prepar3d, p3dv4, xp11, x-plane, x-plane 11, fsx, fsx:se, flight simulator x">
		<link rel="icon" href="<?= PROTOCOL ?>://www.<?= DOMAIN ?>/assets/img/favicon.ico">

		<title>MultiCrew</title>

		<link rel="stylesheet" type="text/css" href="<?= PROTOCOL ?>://www.<?= DOMAIN ?>/assets/css/bootstrap.css">
		<link rel="stylesheet" type="text/css" href="<?= PROTOCOL ?>://www.<?= DOMAIN ?>/assets/css/custom.css">
		<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.3.1/css/all.css" integrity="sha384-mzrmE5qonljUremFsqc01SB46JvROS7bZs3IO2EmfFsd15uHvIt+Y8vEf7N7fWAU" crossorigin="anonymous">

	</head>

	<body id="landing" class="pt-5">

		<div class="pt-5 mt-5 w-50 text-center mx-auto">

			<h1 class="display-4 mt-5 pt-5">MultiCrew</h1>
			<p class="lead">MultiCrew is a community-driven flight simulation organisation that provides training and support for shared cockpit aircraft addons.</p>
			<a href="/home.php" class="btn btn-lg btn-secondary">
				Learn more &nbsp;<i class="fas fa-angle-double-right"></i>
			</a>

<?php $call = 'landing'; include $_SERVER['DOCUMENT_ROOT'].'/../footer_sys.php'; ?>
