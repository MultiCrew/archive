<?php if (($sso->get_user_data('type')=='admin' || $sso->get_user_data('type')=='mod') && $viewport == 'large' ) { ?>
	<small class="text-secondary ml-3">MY PORTAL</small>
<?php } ?>

<li class="nav-item">
	<a class="nav-link <?php if ($page=="dashboard") echo 'active'; ?>" href="/dashboard/index.php">
		<i class="fas fa-fw fa-home mr-2"></i>Dashboard
	</a>
</li>

<li class="nav-item <?php if ($viewport=='large') echo 'border-bottom pb-3'; ?>">
	<a class="nav-link <?php if ($page=="account") echo 'active'; ?>" href="/dashboard/account.php">
		<i class="fas fa-fw fa-user mr-2"></i>Profile
	</a>
</li>

<?php if ($sso->get_user_data("type")=="admin" || $sso->get_user_data('type')=='mod') { ?>

	<?php if ($viewport == 'large') { ?>
		<small class="text-secondary ml-3 mt-3">ADMINISTRATION</small>
	<?php } ?>

	<li class="nav-item">
		<a class="nav-link <?php if ($page=="admin") echo 'active'; ?>" href="/dashboard/admin.php">
			<i class="fas fa-fw fa-users mr-2"></i>Manage users
		</a>
	</li>

	<li class="nav-item <?php if ($viewport=='large') echo 'border-bottom pb-3'; ?>">
		<a class="nav-link <?php if ($page=="ban") echo 'active'; ?>" href="/dashboard/ban.php">
			<i class="fas fa-fw fa-ban mr-2"></i>Manage bans
		</a>
	</li>

<?php } ?>

<li class="nav-item">
	<a class="nav-link" href="/logout.php">
		<i class="fas fa-fw fa-sign-out-alt mr-2"></i>Logout
	</a>
</li>
