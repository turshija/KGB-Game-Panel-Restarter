<html>
<head>
<title><?=$config['title']?></title>
<script src="template/js/jquery.min.js" type="text/javascript"></script> 
<script src="template/js/main.js" type="text/javascript"></script> 
<link href="template/style.css" rel="stylesheet" type="text/css" />

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
	<? if (!empty($notifikacija)) { ?>
	<div id="notif">
	<?=$notifikacija?>
	</div>
	<? } ?>

	<table align="center">
		<tr>
			<th>Ime servera</th>
			<th>Broj igraca</th>
			<th>IP Adresa</th>
			<th>Status</th>
		</tr>
		<? foreach ($server as $info) {
			if (in_array($info['ip'],$config['preskoci'])) continue;
			if ($info['status']=="offline") $status = "<a class=\"restartDugme\" href=\"server_process.php?task=restart&id=$info[serverid]&auth=$info[auth]\">Restartuj</a>";
			else $status = $info['status'];

			echo "<tr><td>$info[name]</td><td>$info[players]</td><td>$info[ip]</td><td>$status</td></tr>\n";

		} ?>
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