		</main>

	</div>

</div>

<footer class="footer navbar-dark bg-dark">

	<div class="px-3">

		<p class="float-right text-white">
			<a class="footer-link" href="https://www.facebook.com/flymulticrew/"><i class="fab fa-fw fa-lg fa-facebook-square"></i></a>
			<a class="footer-link"  href="https://www.twitter.com/flymulticrew/"><i class="fab fa-fw fa-lg fa-twitter-square"></i></a>
			<a class="footer-link"  href="https://www.youtube.com/channel/UCT7U2Ss79D76FkyRsNIadMA"><i class="fab fa-fw fa-lg fa-youtube-square"></i></a>
			<a class="footer-link"  href="https://go.twitch.tv/multicrew"><i class="fab fa-fw fa-lg fa-twitch"></i></i></a>
		</p>

		<p class="text-white">&copy; MultiCrew <script>document.write(new Date().getFullYear())</script> &middot; <a class="footer-link" href="<?= PROTOCOL ?>://www.<?= DOMAIN ?>/more/policies.php">Terms and Policies</a> &middot; SSO developed by <a href="https://bpmct.net">bpmct</a></p>

	</div>

</footer>

<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js" integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49" crossorigin="anonymous"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js" integrity="sha384-ChfqqxuZUCnJSK3+MXmPNIyE6ZbWh2IMqE241rYiqJxyMiZ6OW/JmZQ5stwEULTy" crossorigin="anonymous"></script>

<?php if (isset($page) && $page=='admin') { ?>
	<script type="text/javascript" src="/assets/js/admin.js"></script>
<?php } ?>

</body>
</html>
