<nav class="col-lg-2 bg-light sidebar sidebar-academy d-none d-lg-block">

	<ul class="nav nav-pills flex-column">

		<li class="nav-item">
			<a class="nav-link <?php if (isset($page) && $page=='index') echo 'active'; ?>" href="/index.php">
				<i class="fas fa-fw fa-home mr-2"></i>Index
			</a>
		</li>

		<li class="nav-item">
			<a class="nav-link <?php if (isset($page) && $page=='aircraft') echo 'active'; ?>" href="/general/aircraft.php">
				<i class="fas fa-fw fa-plane mr-2"></i>Supported Aircraft
			</a>
		</li>

		<li class="nav-item">
			<a class="nav-link <?php if (isset($page) && $page=='security') echo 'active'; ?>" href="/general/security.php">
				<i class="fas fa-fw fa-lock mr-2"></i>Security
			</a>
		</li>

		<li class="nav-item">
			<a class="nav-link <?php if (isset($page) && $page=='setup') echo 'active'; ?>" href="/general/setup.php">
				<i class="fas fa-fw fa-cogs mr-2"></i>Setup
			</a>
		</li>

		<li class="nav-item">
			<a class="nav-link <?php if (isset($page) && $page=='wxscenery') echo 'active'; ?>" href="/general/wxscenery.php">
				<i class="fas fa-fw fa-image mr-2"></i>Weather &amp; Scenery
			</a>
		</li>

		<li class="nav-item">
			<a class="nav-link <?php if (isset($page) && $page=='glossary') echo 'active'; ?>" href="/general/glossary.php">
				<i class="fas fa-fw fa-book mr-2"></i>Glossary
			</a>
		</li>

	</ul>

</nav>

<main class="col-lg-10 offset-lg-2 p-3">
