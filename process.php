<?php
include "main.php";
$br_skeniranja = $config['broj_skeniranja'];

if ($_POST['task']=="gtstatus") {
	$ip = $restarter->ocistiIP($_POST['ip']);
	
	$server = $restarter->skenirajServer($ip);
	
	if (!$server) {
		$return['status'] = "No server";
		$return['players'] = "-";
		$return['action'] = "hide";
	} else {
		$return['status'] = $server['b']['status'];
		if (!$return['status']) $return['players'] = "-";
		else $return['players'] = $server['s']['players']."/".$server['s']['playersmax'];
		$return['action'] = "display";
	}
	die(json_encode($return));
}
?>