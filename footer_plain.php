	</div>

	<footer class="<?php if (isset($call) && $call='copilot') echo 'bg-light'; else echo 'bg-dark text-white'; ?>">

		<div class="container py-5">

			<div class="row align-items-center">

				<div class="col-md-4">

					<div class="card bg-secondary">

						<div class="card-body">

							<h4 class="card-title">Advertisement</h4>

							<script async src="//pagead2.googlesyndication.com/pagead/js/adsbygoogle.js"></script>
							<ins class="adsbygoogle" style="display: block;" data-ad-client="ca-pub-3761068779458014" data-ad-slot="2687430955" data-ad-format="auto"></ins>
							<script>
							(adsbygoogle = window.adsbygoogle || []).push({});
							</script>

						</div>

					</div>

				</div>

				<div class="col-md-8">

					<h1>MultiCrew</h1>

					<p>We're all about bringing people from the aviation industry and the flight simulation community together to enjoy flight simulators. We are a community-driven, non-profit organisation, which specialises in shared cockpit flying, training and support.</p>

					<p>
						<a href="<?= PROTOCOL ?>://www.<?= DOMAIN ?>/more/contact.php" class="btn btn-info">Contact Us<i class="fas fa-fw fa-lg fa-angle-double-right ml-2"></i></a>
					</p>

				</div>

			</div>

		</div>

	</footer>

	<div class="container my-3">
		<p class="float-right">
			<a href="https://www.facebook.com/flymulticrew/"><i class="fab fa-facebook-f fa-fw fa-lg"></i></a>
			<a href="https://www.twitter.com/flymulticrew/"><i class="fab fa-twitter fa-fw fa-lg"></i></a>
			<a href="https://www.youtube.com/channel/UCT7U2Ss79D76FkyRsNIadMA"><i class="fab fa-youtube fa-fw fa-lg"></i></a>
			<a href="https://go.twitch.tv/multicrew"><i class="fab fa-twitch fa-fw fa-lg"></i></a>
			&middot;
			<a href="#"><i class="fas fa-fw fa-lg fa-angle-double-up"></i></a>
		</p>
		<p>&copy; MultiCrew <?php echo date('Y'); ?> &middot; <a href="<?= PROTOCOL ?>://www.<?= DOMAIN ?>/more/policies.php">Terms and Policies</a></p>
	</div>

	<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.6/umd/popper.min.js" integrity="sha384-wHAiFfRlMFy6i5SRaxvfOCifBUQy1xHdJ/yoi7FRNXMRBu5WHdZYu1hA6ZOblgut" crossorigin="anonymous"></script>
	<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.2.1/js/bootstrap.min.js" integrity="sha384-B0UglyR+jN6CkvvICOB2joaf5I4l3gm9GU6Hc1og6Ls7i6U/mkkaduKaBhlAXv9k" crossorigin="anonymous"></script>
	<?php /*if (isset($page) && $page == 'plan') { ?>
		<script type="text/javascript" src="simbrief.apiv1.js"></script>
	<?php }*/ ?>

</body>

</html>
