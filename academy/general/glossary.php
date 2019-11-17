<?php

$tab = 'general';
include $_SERVER['DOCUMENT_ROOT'].'/assets/layout/header.php';
$page = 'glossary';
include $_SERVER['DOCUMENT_ROOT'].'/assets/layout/sidebar_general.php';

?>

<h1>MultiCrew Academy</h1>
<h4 class="text-muted">Glossary</h4>

<div class="table-responsive">

	<table class="table table-hover table-striped table-sm order-table mt-2 border" id="glossary">

		<!--<thead class="thead-light">
			<tr>
				<th colspan="2">
					<input class="form-control" type="search" id="search" data-table="order-table" placeholder="Start typing to search glossary...">
				</th>
			</tr>
		</thead>-->

		<tbody>
			<tr>
				<th>ACFT</th>
				<td>Aircraft</td>
			</tr>
			<tr>
				<th>A/C</th>
				<td>Aircraft</td>
			</tr>
			<tr>
				<th>AFIS</th>
				<td>Aerodrome Flight Information Service - a type of Air Traffic Control service.</td>
			</tr>
			<tr>
				<th>AGL</th>
				<td>Above Ground Level - used when quoting an altitude which is measured from the ground (either directly beneath an aircraft or at a reference point).</td>
			<tr>
				<th>AIP</th>
				<td>Aeronautical Information Publication - official charts and information published by a national organisation for the aerodromes and airspace for which they are responsible.</td>
			</tr>
			<tr>
				<th>AMSL</th>
				<td>Above Mean Sea Level - used when quoting an altitude which is measured from the Mean Sea Level.</td>
			</tr>
			<tr>
				<th>APU</th>
				<td>Auxiliary Power Unit - a small generator, usually located in the tail section of the aircraft, used for powering the aircraft from its own fuel for starting engines or as a backup.</td>
			</tr>
			<tr>
				<th>ETOPS</th>
				<td>Extended Operations - previously meaning Extended Twin-Engine Operations, a set of safety measures in place to ensure aircraft travelling over large bodies of water have enough fuel to return to land with an engine failure.</td>
			<tr>
				<th>FL</th>
				<td>Flight Level - an altitude given as the first three figures preceeded by FL (a 0 is used for altitudes lower than 10000 ft). Only used above the Transition Altitude.</td>
			</tr>
			<tr>
				<th>GPU</th>
				<td>Ground Power Unit - a portable generator which can be connected to aircraft on the ground, used to provide power to some systems.</td>
			</tr>
			<tr>
				<th>IATA</th>
				<td>International Air Transport Association</td>
			</tr>
			<tr>
				<th>ICAO</th>
				<td>International Civil Aviation Organization</td>
			</tr>
			<tr>
				<th>ILS</th>
				<td>Instrument Landing System - a navigational istallation used to assist aircraft in aligning with the runway, or sometimes fully landing the aircraft.</td>
			</tr>
			<tr>
				<th>METAR</th>
				<td>Meteorological Terminal Aviation Routine weather report - a weather report, usually given every 30 minutes, used by pilots and controllers alike.</td>
			</tr>
			<tr>
				<th>PDC</th>
				<td>Pre-Departure Clearance - text-based departure clearance, usually given via CPDLC, commonly used at busy aerodromes.</td>
			</tr>
			<tr>
				<th>RNAV</th>
				<td>Aera Navigation - a modern alternative to navigating via fixed installations which uses GPS-based waypoints.</td>
			<tr>
				<th>TAF</th>
				<td>Terminal Aerodrome Forecast - a weather forecast used by pilots and controllers alike.</td>
			</tr>
			<tr>
				<th>TCAS</th>
				<td>Traffic Collision Avoidance System - a system which modern aircraft are equipped with to advise pilots of potential mid-air hazards.</td>
			</tr>
			<tr>
				<th>WPT</th>
				<td>Waypoint</td>
			</tr>
			<tr>
				<th>WX</th>
				<td>Weather</td>
			</tr>
			<tr>
				<th>WXR</th>
				<td>Weather Radar - a device which can detect precipitation and display its approximate location and intensity on a map.</td>
			</tr>
		</tbody>

	</table>

</tr>

<script>
var $rows = $('#glossary tr:not(:first)');
$('#search').keyup(function() {
    var val = $.trim($(this).val()).replace(/ +/g, ' ').toLowerCase();

    $rows.show().filter(function() {
        var text = $(this).text().replace(/\s+/g, ' ').toLowerCase();
        return !~text.indexOf(val);
    }).hide();
});
</script>

<?php $call = 'academy'; include $_SERVER['DOCUMENT_ROOT'].'/../footer_sys.php'; ?>
