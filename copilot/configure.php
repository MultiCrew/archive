<?php

$sect = 'copilot';
$title = ' - Copilot';
$page = 'index';

include 'assets/includes/core.php';

?>

<div class="card" style="height: 300px;">

	<div class="card-body">

		<h4 class="card-title">Copilot Configuration</h4>

		<ul class="nav nav-pills mb-3 border rounded" id="pills-tab">
			<li class="nav-item">
				<a class="nav-link active" id="pills-home-tab" data-toggle="pill" href="#pills-home">Intro</a>
			</li>
			<li class="nav-item">
				<a class="nav-link" id="pills-sim-tab" data-toggle="pill" href="#pills-sim">Simulator</a>
			</li>
			<li class="nav-item">
				<a class="nav-link" id="pills-connect-tab" data-toggle="pill" href="#pills-connect">Connection</a>
			</li>
		</ul>

		<div class="tab-content" id="pills-tabContent">

			<div class="tab-pane fade show active" id="pills-home">
				<p class="card-text">We're going to walk you through some initial configuration steps to help you get the most out of Copilot.</p>
				<p class="card-text">The settings you're about to choose will be visible to all other users of Copilot on your profile, and will help like-minded pilots to find and fly with you!</p>
				<div class="row">
					<div class="col text-left"></div>
					<div class="col text-right">
						<button class="btn btn-primary" onclick="next()">
							Simulator<i class="fas fa-angle-double-right fa-fw ml-2"></i>
						</button>
					</div>
				</div>
			</div>

			<div class="tab-pane fade" id="pills-sim">

			</div>

			<div class="tab-pane fade" id="pills-connect">

			</div>

		</div>

	</div>

</div>

<?php $call = 'copilot'; include $_SERVER['DOCUMENT_ROOT'].'/../footer_plain.php'; ?>
