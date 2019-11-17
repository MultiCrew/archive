<?php if (isset($call) && $call=='academy') echo '</main></div>'; ?>

</div>

<footer class="footer <?php if (isset($call) && $call=='landing') { echo 'navbar-light bg-light'; } else { echo 'navbar-dark bg-dark'; } ?>">

	<div class="px-3">

		<p class="float-right text-white">
			<a class="footer-link" href="https://www.facebook.com/flymulticrew/"><i class="fab fa-fw fa-lg fa-facebook-f"></i></a>
			<a class="footer-link"  href="https://www.twitter.com/flymulticrew/"><i class="fab fa-fw fa-lg fa-twitter"></i></a>
			<a class="footer-link"  href="https://www.youtube.com/channel/UCT7U2Ss79D76FkyRsNIadMA"><i class="fab fa-fw fa-lg fa-youtube"></i></a>
			<a class="footer-link"  href="https://go.twitch.tv/multicrew"><i class="fab fa-fw fa-lg fa-twitch"></i></a>
		</p>

		<p class="text-white">&copy; MultiCrew 2018 &middot; <a class="footer-link" href="https://www.<?= DOMAIN ?>/more/policies.php">Terms and Policies</a> &middot; <a class="footer-link" href="https://www.<?= DOMAIN ?>/more/contact.php">Contact Us</p>

	</div>

</footer>

<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.6/umd/popper.min.js" integrity="sha384-wHAiFfRlMFy6i5SRaxvfOCifBUQy1xHdJ/yoi7FRNXMRBu5WHdZYu1hA6ZOblgut" crossorigin="anonymous"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.2.1/js/bootstrap.min.js" integrity="sha384-B0UglyR+jN6CkvvICOB2joaf5I4l3gm9GU6Hc1og6Ls7i6U/mkkaduKaBhlAXv9k" crossorigin="anonymous"></script>
<?php /*if (isset($page) && $page == 'plan') { ?>
	<script type="text/javascript" src="simbrief.apiv1.js"></script>
<?php }*/ ?>

</body>
</html>

<?php if (isset($mysqli)) { $mysqli->close(); } ?>
