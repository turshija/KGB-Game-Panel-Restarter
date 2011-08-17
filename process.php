<?php
include "main.php";

if ($_POST['task']=="gtstatus") {
	$ip = $restarter->ocistiIP($_POST['ip']);
	
	$link = "ip={$ip}";
	$server = unserialize($restarter->procitaj($link,"gt"));
	
	if (!$server['b']['status']) {
		$return['status'] = "No server";
		$return['players'] = "-";
		$return['action'] = "hide";
	} else {
		$return['status'] = $server['b']['status'];
		$return['players'] = $server['s']['players']."/".$server['s']['playersmax'];
		$return['action'] = "display";
	}
	die(json_encode($return));
}
?>