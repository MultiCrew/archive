<?php

$tab = 'general';
include $_SERVER['DOCUMENT_ROOT'].'/assets/layout/header.php';
$page = 'security';
include $_SERVER['DOCUMENT_ROOT'].'/assets/layout/sidebar_general.php';

?>

<h1>Shared Cockpit</h1>
<p class="lead">Further Reading: <a href="https://docs.google.com/document/d/1oi6T5oXxQ21L9k1WT8as9ZgMDOpxxoteLwoIrJfb8LA">https://docs.google.com/document/d/1oi6T5oXxQ21L9k1WT8as9ZgMDOpxxoteLwoIrJfb8LA</a></p>
<h4 class="text-muted">Security</h4>

<p>You might not think much of it, but flying with a shared cockpit can be <strong>very dangerous</strong> to your computer, personal idenity and information if not set up properly.</p>
<p>Poor computer security whilst flying with a shared cockpit in the past has led to people having their entire identity, money and financial data <strong>stolen and sold</strong> on the Deep Web, <strong><em>but it is all avoidable</em></strong>!</p>

<h5>Peer-to-peer Security</h5>
<p>When attempting to make a peer-to-peer (direct) connection between two computers, most antivirus and firewall software is going to try and stop you. Why? Because it can pose a huge risk. You are effectively opening up your computer and network and allowing data to be transferred through a less common method (your browser lets data in, but in a very secure manner).</p>
<p>There are two methods of allowing this shared cockpit connection to happen, and one is significantly safer than the other.</p>

<div class="row">

	<div class="col-md-6">

		<h5>Port Forwarding</h5>
		<p>Imagine your router's firewall (yes, your router has a firewall too) is a brick wall. Each brick is a "port", a communication line that allows data through. If the port is "closed" (i.e. the brick is in place), the data cannot pass through. However, if you "open" the port (i.e. remove the brick), the data can pass through. If you open lots of ports, though, your security becomes unstable (just like the wall would if you removed lots of bricks)!</p>
		<p>Port forwarding is the process of opening a port on your router's firewall and forwarding all of that data to a specific device on the network; in this case, your computer running the simulator.</p>
		<p>We will only open the ports that we need to in order to allow the shared cockpit connection to be made, otherwise we are compromising our security.</p>

		<h6>How do I open ports?</h6>
		<p>Each router will have a web interface where you can configure settings and, of course, the firewall. <strong>Some routers don't allow port forwarding</strong>, but most good-quality routers from renowned networking companies will, and these routers will cost under $50. Some standard ISP routers may also allow port forwarding.</p>
		<p>MultiCrew cannot, of course, tell you how to forward ports on <em>every single router</em> out there, but we can tell you what ports and protocols you need allowed through your router. These are detailed for each aircraft we support on their respective setup pages.</p>
		<p>If you need help forwarding ports on your router, <a href="https://portforward.com/">portforward.com</a> provides guides for almost every router out there, complete with screenshots of each page of the interface.</p>

	</div>

	<div class="col-md-6">

		<h5>Tunnelling Engines and VPNs</h5>
		<p>Whilst considerably easier to set up, tunnelling engines like Hamachi, and Virtual Private Networks, create a fully open peer-to-peer connection between computers, offering almost no security between them.</p>
		<p>In some cases, it may be impossible to port forward on the router you are using, and buying a new router which allows this may not be an option. We still <strong>highly discourage</strong> the use of this kind of software, but it may be the only option available to some.</p>
		<p>If you are using this kind of software, we seriously suggest you install a full and trusted computer security suite which can provide you with extended antivirus checking and firewall security.</p>

	</div>

</div>

<h5>Client-Server-Client Security</h5>
<p>Relatively new to flight simulation, and currently only employed by Aerosoft's new (yet to be released) Connected Flight Deck system, the client-server-client setup allows each client to be much more secure, because they are not making a direct connection. Instead, both clients connect to a server, and the server sends each clients' data to the other client.</p>
<p>Whilst no router firewall setup is usually required, MultiCrew still recommends the use of at least the standard Windows Firewall and Security Centre, if not a full antivirus suite.</p>

<?php $call = 'academy'; include $_SERVER['DOCUMENT_ROOT'].'/../footer_sys.php'; ?>
