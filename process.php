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
		$return['status'] = $server['status'];
		if (!$return['status']) $return['players'] = "-";
		else $return['players'] = $server['players']."/".$server['playersmax'];
		$return['action'] = "display";
	}

	die(json_encode($return));

} else if ($_POST['task']=="restartServer") {
	$serverid = (int)$_POST['serverid'];
	$ip = $restarter->ocistiIP($_POST['ip']);
	$temp = (int)$_POST['auth'];
	$token = $config['tokens'][$temp];
	$server = $restarter->skenirajServer($ip);

	if (!$server || in_array($serverid, $config['ignorisi'])) {
		$return['msg'] = "No server";
	} else {
		if ($server['status']) {
			$return['msg'] = "Server online";
		} else {
			$return['msg'] = $restarter->restartujServer($serverid, $token);
		}
	}

	die(json_encode($return));

}
?>