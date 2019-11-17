<nav class="navbar navbar-dark bg-primary navbar-expand-md">

	<div class="container">

		<ul class="navbar-nav mr-auto">

			<li class="nav-item">
				<a class="nav-link <?php if ($page == 'index') { echo 'active'; } ?>" href="/index.php">
					<i class="fas fa-fw fa-home"></i> &nbsp;Home
				</a>
			</li>

		</ul>

		<ul class="navbar-nav ml-auto">

			<li class="nav-item">
				<a class="nav-link <?php if ($page == 'help') { echo 'active'; } ?>" href="/help/index.php">
					<i class="fas fa-fw fa-question-circle"></i> &nbsp;Help
				</a>
			</li>

			<?php /*
			<li class="nav-item">
				<a class="nav-link <?php if ($page == 'support') { echo 'active'; } ?>" href="/help/support.php">
					<i class="fas fa-fw fa-info-circle"></i> &nbsp;Support
				</a>
			</li>
			*/ ?>

		</ul>

	</div>

</nav>
