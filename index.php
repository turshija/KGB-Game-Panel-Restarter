<?php
include "main.php";

$servers = $restarter->getServers();

/*
foreach ($servers as $server) {
	echo $server['ip']." ".$server['name']."<br />";
}*/

?>
<html>
<head>
<title>Restarter</title>
<script src="assets/js/jquery.min.js" type="text/javascript"></script> 
<script src="assets/js/main.js" type="text/javascript"></script> 
<link href="assets/css/style.css" rel="stylesheet" type="text/css" />

<script type="text/javascript"> 
<!--
$(document).ready(function(){
	$("#notif").delay(3000).animate({
		opacity: 'hide',
		height: 'toggle'
	}, 1000, function() {
		// kraj animacije
	});
	
});
-->
</script> 

</head>

<body>
	<?php if (!empty($notifikacija)) { ?>
	<div id="notif">
	<?=$notifikacija?>
	</div>
	<?php } ?>

	<table align="center">
		<tr>
			<th>Ime servera</th>
			<th>IP Adresa</th>
			<th>Broj igraca</th>
			<th>Status</th>
		</tr>
		<?php
		foreach ($servers as $server) {
			echo "<tr><td>$server[name]</td><td>$server[ip]</td><td>$server[players]</td><td>$status</td></tr>\n";

		}
		?>
	</table>
</body>
</html>


<div id="mrak" style="width:100%;height:100%;display:none;margin:0px;background-color:#111122;border:0px solid black;filter:alpha(opacity=60);opacity:0.6;position:fixed;top:0px;left:0px;"></div> 
 
 
<div id="load_popup" class="prozor" > 
<center> 
	Restartovanje u toku ...<br />
	<img src="template/load.gif" />
	
	
</center> 
</div> 