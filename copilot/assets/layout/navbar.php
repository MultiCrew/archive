<nav class="navbar navbar-dark bg-primary navbar-expand-md">

	<div class="container">

		<ul class="navbar-nav mr-auto">

			<li class="nav-item">
				<a class="nav-link <?php if ($page == 'index') { echo 'active'; } ?>" href="/index.php">
					<i class="fas fa-fw fa-home"></i> &nbsp;Home
				</a>
			</li>

			<li class="nav-item">
				<a class="nav-link <?php if ($page == 'search') { echo 'active'; } ?>" href="/search.php">
					<i class="fas fa-fw fa-search"></i> &nbsp;Search
				</a>
			</li>

			<li class="nav-item">
				<a class="nav-link <?php if ($page == 'manage') { echo 'active'; } ?>" href="/manage.php">
					<i class="fas fa-fw fa-cog"></i> &nbsp;Manage
				</a>
			</li>

			<li class="nav-item">
				<a class="nav-link <?php if ($page == 'output' or $page == 'export' or $page == 'plan') { echo 'active'; } ?>" href="/dispatch/plan.php">
					<i class="far fa-fw fa-file-alt"></i> &nbsp;Dispatch
				</a>
			</li>

			<li class="nav-item">
				<a class="nav-link <?php if ($page == 'logbook') { echo 'active'; } ?>" href="/logbook.php">
					<i class="fas fa-fw fa-book"></i> &nbsp;Logbook
				</a>
			</li>

		</ul>

		<ul class="navbar-nav ml-auto">

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

		</ul>

	</div>

</nav>
