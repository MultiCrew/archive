<?php

$tab = 'general';
include $_SERVER['DOCUMENT_ROOT'].'/assets/layout/header.php';
$page = 'wxscenery';
include $_SERVER['DOCUMENT_ROOT'].'/assets/layout/sidebar_general.php';

?>

<h1>Shared Cockpit</h1>
<h4 class="text-muted">Weather & Scenery</h4>

<p>When flying shared cockpit, it is absolutely necessary that both parties have the same scenery and weather settings, otherwise they may experience "desync" or other related issues.</p>

<h5>Scenery</h5>
<h6>Airport Scenery</h6>
<p>Can you imagine if one pilot has payware up-to-date scenery, but the other only has default or out-of-date freeware? This can cause issues such as one pilot being on the taxiway but the other being on the grass.</p>
<p>Both pilots should share scenery information and, if necessary, have one pilot temporarily downgrade to freeware, or the other pilot purcharse the payware, to ensure coincident sceneries.</p>
<h6>Global Scenery, Mesh, ORBX, etc.</h6>
<p>Global scenery, mesh scenery and ORBX Vector can all <strong>change the evelvation of aerodromes</strong>, so it is essential that pilots share their global scenery settings!</p>
<p>If they didn't, one pilot may be on their ground level, but the other pilot may be 10 feet underground or in the air.</p>

<h5>Weather</h5>
<p>Another example of problems that can happen when pilots use different weather engines, or even different settings: one pilot has a 10 KT headwind, but the other has a 15KT crosswind. The simulators are going to become confused, and aircraft may go astray from each other (aka. desync).</p>
<p>Pilots should try to use the same weather engines and each other, and the same settings if possible, too. Whilst it's impossible to have simulators depict weather in the same way, sharing the same engine and settings will ensure that these issues are kept to a minimum!</p>

<?php $call = 'academy'; include $_SERVER['DOCUMENT_ROOT'].'/../footer_sys.php'; ?>
