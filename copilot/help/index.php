<?php

$sect = 'copilot';
$title = ' - Copilot Support';
$page = 'help';

require_once('/var/www/copilot/assets/includes/core.php');

?>

<h3 class="text-center"><i class="fas fa-question-circle"></i> &nbsp;Help</h3>



<p>You will find instructions on how to use Copilot to maximise efficiency and enjoyment in a shared cockpit environment below. At the very bottom of this page, you will also find links to the <a href="https://academy.multicrew.co.uk/">MultiCrew Academy</a> where you can find lots of resources to help you with shared cockpit connections and aircraft procedures!</p>

<div class="card w-25 mb-3">

	<div class="card-body p-3">

		<h5 class="card-title">Contents</h5>

		<ol class="card-text">
			<a href="#intro"><li>Introduction</li></a>
			<a href="#discord"><li>Discord Integration</li></a>
			<a href="#search"><li>Searching for Requests</li></a>
			<a href="#manage"><li>Managing your Requests</li></a>
			<a href="#dispatch"><li>Dispatcher</li></a>
			<a href="#log"><li>Logbook</li></a>
			<a href="#agreement"><li>User Agreement</li></a>
		</ol>

	</div>

</div>

<h4 id="intro"><i class="fas fa-info-circle"></i> &nbsp;Introduction</h4>

<h5>What is Copilot?</h5>
<p>Copilot is a web and Discord based system which allows users to coordinate and organise shared cockpit flights. Users are put in touch with each other via our Discord server, where they can then discuss the flight. By using the Copilot dispatcher, users can also review and agree on a flight plan, fly the flight, and add it to their very own shared cockpit logbook!</p>

<h5>How do I use it?</h5>
<p>Firstly, you will need to create a <a href="https://portal.multicrew.co.uk/">MultiCrew Portal</a> account and link this with a Discord account on our server. You can read more about Discord integration below.</p>

<p>Keep on reading to get a description of each function in the system.</p>

<h4 id="discord"><i class="fas fa-info-circle"></i> &nbsp;Discord Integration</h4>

<p>Copilot is fully integrated with the MultiCrew Discord server, which you can join at <a href="https://discord.gg/3jHRAkE">https://discord.gg/3jHRAkE</a>. You need to link your MultiCrew Portal account with your Discord account, so please watch out for a PM from the "MTC" bot upon joining. The PM will contain your Discord ID, which you need to paste in to the relevant field on your MultiCrew Portal account profile. The rest will happen automatically!</p>

<p>Once your accounts are linked, you will have access to the Copilot system. The Discord "MTC Copilot" bot will send Direct Messages, and messages to the #shared-cockpit and #dispatch channels, to help you coordinate and plan your flight.</p>

<p>You can also manage your requests on the Discord server - just read below for more information!</p>

<h4 id="search"><i class="fas fa-info-circle"></i> &nbsp;Searching for Requests</h4>

<h5>Web</h5>
<p>To search for requests, go to the <a href="https://copilot.multicrew.co.uk/search.php">Search</a> tab and have a look through the table. You can see the user making the request ('requestee'), the aircraft, and the departure and arrival airports.</p>
<p>To accept a request, simply click the button on the row in the table you wish to accept. Both users will receive messages on the Discord server, and you should contact each other from there.</p>

<h5>Discord</h5>
<p>For a list of commands to interact with the "MTC Copilot" bot, join the Discord server and type ".sc search" into the #shared-cockpit channel.</p>

<h4 id="manage"><i class="fas fa-info-circle"></i> &nbsp;Managing your Requests</h4>

<h5>Web</h5>
<p>Head to the <a href="https://copilot.multicrew.co.uk/manage.php">Manage</a> tab to add or delete requests in the Copilot system. You can add a request based on aircraft, departure and arrival, or you can delete existing requests. You can also unaccept a request here, or delete a request that's already been accepted.

<h5>Discord</h5>
<p>For a list of commands to interact with the "MTC Copilot" bot, join the Discord server and type ".sc search" into the #shared-cockpit channel.</p>

<h4 id="dispatch"><i class="fas fa-info-circle"></i> &nbsp;Dispatcher</h4>

<h5>Web</h5>
<p>Upon accepting a request, the <a href="https://copilot.multicrew.co.uk/dispatch/plan.php">Dispatch</a> tab will show a semi-completed flight plan form. You will need a SimBrief account, and all flight plans will be dispatched via the SimBrief API.</p>
<p>After creating a flight plan, both users involved in the flight must "accept" the flight plan, otherwise a new plan will have to be created. After it's been accepted, the plan will be exportable into a PDF, as well as all company route formats which SimBrief supports.</p>

<h5>Discord</h5>
<p>The dispatcher is only available via the Web, however "MTC Copilot" will provide you with a link to the dispatch planning page.</p>

<h4 id="log"><i class="fas fa-info-circle"></i> &nbsp;Logbook</h4>
<p>Following successful completion of a flight, mark the flight "complete" via the Dispatcher. By visiting the <a href="https://copilot.multicrew.co.uk/logbook.php">Logbook</a> tab, you can view a log of all flights completed through MultiCrew Copilot. This will become much more feature-rich in the future!</p>
<p>You can also cancel the flight if, for example, the simulator crashes.</p>

<h4 id="agreement"><i class="fas fa-info-circle"></i> &nbsp;User Agreement</h4>

<p>Need a reminder of the user agreement? Here it is.</p>

<h5>Networking</h5>
<p>Sometimes, when flying with a shared cockpit, you may create a direct peer-to-peer connection with another computer. This has various implications to the secuirty of both devices, and their networks. By using Copilot, you agree to:</p>
<ul>
	<li>where possible, use port forwarding to provide maximum possible router firewall protection;</li>
	<li>secure your own home networks with a password-protected router;</li>
	<li>keep all operating system antivirus and firewall software on at least default settings, unless troubleshooting, and to use appropriate rules and exceptions to allow desired connections;</li>
	<li>report violations of these regulations to a member of staff.</li>
</ul>

<h5>Simulator Content and Settings</h5>
<p>It is vital that both pilots share their simulator scenery, weather and nav data settings with each other to ensure a trouble-free connection in a shared cockpit environment. By using Copilot, you also agree to:</p>
<ul>
	<li>match up with another pilot with the same, or similar, simulator content and settings;</li>
	<li>be truthful about these criteria on your profile;</li>
	<li>keep your profile fields up to date with your simulator and preferences.</li>
</ul>

<h5>Troubleshooting</h5>
<p>It is common for users to experience issues establishing a shared cockpit connection. To resolve these, you agree to:</p>
<ul>
	<li>have some understanding, technical knowledge and experience with your computer, operating system, software and network;</li>
	<li>install remote desktop connection software, such as TeamViewer, if requested;</li>
	<li>only allow a MultiCrew staff member, mentor, or other personally truster person access to your computer via a remote desktop connection.</li>
</ul>

<?php require_once('/var/www/copilot/assets/layout/footer.php'); ?>
