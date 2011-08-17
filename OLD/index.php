<?php

//require_once "config.php";
require_once "main.php";

$auth = $config['token'];
if (!$auth) {
	die();
}


$i=1;
foreach ($auth as $broj=>$token) {	// broj -> redni broj tokena
	 
	$servers = "servers.php?auth=$token";
	$ret = $restarter->procitaj($servers);
	$info = explode("\n",$ret);


	if ($info[0]==0) die("Error!<br />$info[1]");

	$broj_servera = $info[1];
	
	for ($j=1;$j<=$broj_servera;$j++) {
		$server[$i]['serverid']		=	$info[(($j-1)*$br_info)+2+0];
		$server[$i]['name']			=	$info[(($j-1)*$br_info)+2+1];
		$server[$i]['game']			=	$info[(($j-1)*$br_info)+2+2];
		$server[$i]['ip']			=	$info[(($j-1)*$br_info)+2+3];
		$server[$i]['slots']		=	$info[(($j-1)*$br_info)+2+4];
		//$server[$i]['status']		=	$info[(($j-1)*$br_info)+2+5];
		$server[$i]['online']		=	$info[(($j-1)*$br_info)+2+6];
		$server[$i]['auth'] = $broj;
		
		$gtlink = "ip=".$server[$i]['ip'];
		$gtresp = unserialize($restarter->procitaj($gtlink,"gt"));
		if ($gtresp['b']['ip']=="") $server[$i]['status']="Nema servera na GT-u";
		else {
			if ($server[$i]['online']=="Started")
				if ($gtresp['b']['status']=="1") {
					$server[$i]['status']="online";
					$server[$i]['players']=$gtresp['s']['players']."/".$gtresp['s']['playersmax'];
				} else $server[$i]['status']="offline";
			else $server[$i]['status']="Server je stopiran!";
		}
		$i++;
	}
}
if (isset($_GET['notif'])) 
	if ($_GET['notif']=="online") $notifikacija = "Server je vec online, tako da restartovanje nije potrebno!";
	else if ($_GET['notif']=="restartovan") $notifikacija = "Hvala vam sto ste restartovali server!";
	else if ($_GET['notif']=="stopiran") $notifikacija = "Zao mi je, ali server je stopiran, pa ga ne mozete restartovati!";


include "template/servers.php";
?>