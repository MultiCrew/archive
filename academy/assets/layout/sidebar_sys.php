<?php $type = $sso->get_user_data("type"); ?>

<nav class="col-lg-2 bg-light sidebar sidebar-academy d-none d-lg-block">

	<ul class="nav nav-pills flex-column">

		<?php if ($type=='instructor' || $type=='training manager' || $type=='admin') { ?>
			<small class="text-secondary ml-3">TRAINEE</small>
		<?php } ?>

		<li class="nav-item">
			<a class="nav-link <?php if ($page=='dashboard') echo 'active'; ?>" href="/sys/student/dashboard.php">
				<i class="fas fa-fw fa-home"></i> &nbsp;Dashboard
			</a>
		</li>

		<li class="nav-item">
			<a class="nav-link <?php if ($page=='management') echo 'active'; ?>" href="/sys/student/management.php">
				<i class="fas fa-fw fa-plane"></i> &nbsp;Management
			</a>
		</li>

		<li class="nav-item border-bottom pb-3">
			<a class="nav-link <?php if ($page=='stats') echo 'active'; ?>" href="/sys/student/stats.php">
				<i class="fas fa-fw fa-chart-line"></i> &nbsp;My stats
			</a>
		</li>

		<?php if ($type=='instructor' || $type=='training manager' || $type=='admin') { ?>

			<small class="text-secondary ml-3 mt-3">INSTRUCTORS</small>

			<li class="nav-item">
				<a class="nav-link <?php if ($page=='sessions') echo 'active'; ?>" href="/sys/instructor/sessions.php">
					<i class="fas fa-fw fa-graduation-cap"></i> &nbsp;Sessions
				</a>
			</li>

			<li class="nav-item border-bottom pb-3">
				<a class="nav-link <?php if ($page=='reports') echo 'active'; ?>" href="/sys/instructor/reports.php">
					<i class="fas fa-fw fa-book-open"></i> &nbsp;Reports

					<?php 		// number of due reports badge
					$stmt = $mysqli->prepare('SELECT * FROM sessions WHERE `users.mentor`=? AND reported=?');
					$user_id = $sso->get_user_data('id'); $reported = 0;
					$stmt->bind_param("si", $user_id, $reported);
					$stmt->execute();
					$res = $stmt->get_result();
					$stmt->close();
					if($res->num_rows!=0){ ?>

						<span class="badge badge-warning">
							<?= $res->num_rows ?>
						</span>

					<?php } ?>

				</a>
			</li>

			<?php if ($type=='training manager' || $type=='admin') { ?>

			<small class="text-secondary ml-3 mt-3">TRAINING MANAGERS</small>

			<li class="nav-item">
				<a class="nav-link <?php if ($page=='cert') echo 'active'; ?>" href="/sys/manager/cert.php">
					<i class="fas fa-fw fa-user-check"></i> &nbsp;Certifications
				</a>
			</li>

			<li class="nav-item border-bottom pb-3">
				<a class="nav-link <?php if ($page=='instr') echo 'active'; ?>" href="/sys/manager/instructors.php">
					<i class="fas fa-fw fa-users"></i> &nbsp;Instructors
				</a>
			</li>

	<?php } } ?>

	</ul>

</nav>

<main class="col-lg-10 offset-lg-2 p-3">
