<?php
include "main.php";

$servers = $restarter->getServers();

/*
foreach ($servers as $server) {
	echo $server['ip']." ".$server['name']."<br />";
}*/

?><html>
<head>
<title>Restarter</title>
<script src="assets/js/jquery.min.js" type="text/javascript"></script> 
<script src="assets/js/main.js" type="text/javascript"></script> 
<link href="assets/css/style.css" rel="stylesheet" type="text/css" />
</head>

<body>
	<table align="center">
		<tr>
			<th>Ime servera</th>
			<th>IP Adresa</th>
			<th width="100">Broj igraca</th>
			<th width="90">Status</th>
		</tr>
<?php
		foreach ($servers as $server) {
			echo <<<OUT
			<tr rel="{$server['ip']}" class="red" src="{$server['auth']}" id="{$server['serverid']}">
				<td>{$server['name']}</td>
				<td>{$server['ip']}</td>
				<td class="center"><img src="assets/images/players-loader.gif" /></td>
				<td class="center"><img src="assets/images/status-loader.gif" /></td>
			</tr>

OUT;

		}
?>
	</table>
	<p id="removedServersNotif" class="labelText">Uklonjeno <span></span> servera sa liste koji nisu dodati na GT.rs!</p>
</body>
</html>