<?php

$tab = 'general';
include $_SERVER['DOCUMENT_ROOT'].'/assets/layout/header.php';
$page = 'setup';
include $_SERVER['DOCUMENT_ROOT'].'/assets/layout/sidebar_general.php';

?>

<h1>Shared Cockpit</h1>
<h4 class="text-muted">Setup</h4>

<p>For some, the setup required can be a bit of a nightmare, especially for those not too familiar with computer software and security. However, once you've done the initial setup, there isn't really much else to do. That's why we've created comprehensive, step-by-step guides to setting up shared cockpit for each of the aircraft we support.</p>

<p>Whilst some of the steps are the same, many of them are different for the various aircraft that exist. That is why we have individual guides for setting up each aircraft we support. You can view them in the respective aircraft's tab.</p>

<h5>What do I need to do?</h5>
<ol>
	<li>Firstly, you want to establish which aircraft you are going to fly with your copilot, and then establish how shared cockpit works in that aircraft. It will either be a peer-to-peer or client-server-client connection. The aircraft developer should tell you that, but we also have it noted for each of the aircraft we support.</li>
	<li>You may wish/need to create firewall and antivirus rules for the software which will be establishing the connection. This is <strong>crucial</strong> for peer-to-peer connections.</li>
	<li>Both pilots are going to need to coordinate scenery and weather settings. Flying with different scenery and weather can cause massive problems in a shared cockpit environment.</li>
	<li>Finally, plan your flight and make the connection!</li>
</ol>
<p>If alll goes well, you will be connected and can enjoy a highly-immersive flight together. However, if it's your first time trying this, you're probably going to experience some issues along the way.</p>
<p>To troubleshoot your issues, make sure you have read <strong>all of our guides</strong>, and then check the troubleshooting section for the specific aircraft addon more help.</p>

<?php $call = 'academy'; include $_SERVER['DOCUMENT_ROOT'].'/../footer_sys.php'; ?>
