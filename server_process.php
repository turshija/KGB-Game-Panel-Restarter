<?php
require_once "config.php";


if (!$token) {
	die();
}

$id = $_GET['id'];
$task = $_GET['task'];
$auth = $token[$_GET['auth']];
//die($auth);
if ($task!="restart") die("Pogresna komanda!");


$server_info = "server_info.php?auth=$auth&id=$id";
$ret = procitaj($server_info);
$info = explode("\n",$ret);

if ($info[0]==0) die("Greska!<br />$info[1]");
$server['ip']		=	$info[4];
$server['online']	=	$info[7];
if ($server['online']!="Started") {
	header("Location:./?notif=stopiran");
	die();
}
if (in_array($server['ip'],$preskoci)) die("Greska!");

$ok = true;

while (($brojSkeniranja--)>0) {
	$gtlink = "ip=".$server['ip'];
	$gtresp = unserialize(procitaj($gtlink,"gt"));
	if ($gtresp['b']['status']=="1") {
		$ok = false;
		break;
	}
	sleep(1);
}

if ($ok) {
	$server_process = "server_process.php?task=$task&auth=$auth&id=$id";

	$ret = procitaj($server_process);
	$info = explode("\n",$ret);

	header("Location:./?notif=restartovan");
} else {
	header("Location:./?notif=online");
}


?>