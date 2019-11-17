<?php

$tab = 'general';
include $_SERVER['DOCUMENT_ROOT'].'/assets/layout/header.php';
$page = 'aircraft';
include $_SERVER['DOCUMENT_ROOT'].'/assets/layout/sidebar_general.php';

?>

<h1>MultiCrew Academy</h1>
<h4 class="text-muted">Supported Aircraft</h4>
<p>MultiCrew will provide training, resources and assistance to users of the community's favourite high-quality shared cockpit capable aircraft addons. Currently, MultiCrew supports the following aircraft:</p>

<div class="table-responsive">

	<table class="table table-hover w-75 mx-auto border">

		<thead class="thead-light">
			<tr>
				<th>Product</th>
				<th>Supported Version(s)</th>
				<th>Shared Cockpit type</th>
				<th></th>
			</tr>
		</thead>

		<tbody>

			<tr>
				<td>Aerosoft Airbus A318-A321</td>
				<td>Professional (P3D v4)</td>
				<td>Connected Flight Deck</td>
				<td class="text-right">
					<a href="#" class="btn btn-sm btn-info">More Info<i class="fas fa-fw ml-2 fa-angle-double-right"></i></a>
					<a href="https://www.aerosoft.com/en/flight-simulation/prepar3d/aircraft/2435/a320-family-professional-bundle" class="btn btn-primary btn-sm" target="_blank">Product Page<i class="fas fa-fw ml-2 fa-external-link-alt"></i></a>
				</td>
			</tr>

			<tr>
				<td>Majestic Software Dash 8 Q400</td>
				<td>Pro Edition</td>
				<td>Peer-to-peer shared cockpit</td>
				<td class="text-right">
					<a href="#" class="btn btn-sm btn-info">More Info<i class="fas fa-fw ml-2 fa-angle-double-right"></i></a>
					<a href="https://majesticsoftware.com/mjc8q400/" class="btn btn-primary btn-sm" target="_blank">Product Page<i class="fas fa-fw ml-2 fa-external-link-alt"></i></a>
				</td>
			</tr>

			<tr>
				<td>TFDi Design Boeing 717-200</td>
				<td>P3D v4</td>
				<td>Peer-to-peer shared cockpit</td>
				<td class="text-right">
					<a href="#" class="btn btn-sm btn-info">More Info<i class="fas fa-fw ml-2 fa-angle-double-right"></i></a>
					<a href="https://tfdidesign.com/717.php" class="btn btn-primary btn-sm" target="_blank">Product Page<i class="fas fa-fw ml-2 fa-external-link-alt"></i></a>
				</td>
			</tr>

			<tr>
				<td>Aerosoft Airbus A330</td>
				<td colspan="3" class="text-muted">Coming soon!</td>
			</tr>

			<tr>
				<td>Leonardo Fly the Maddog X (MD88)</td>
				<td colspan="3" class="text-muted">Coming soon!</td>
			</tr>

		</tbody>

	</table>

</div>

<?php $call = 'academy'; include $_SERVER['DOCUMENT_ROOT'].'/../footer_sys.php'; ?>
