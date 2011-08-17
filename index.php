<?php
include "main.php";

$servers = $restarter->getServers();

foreach ($servers as $server) {
	echo $server['ip']." ".$server['name']."<br />";
}

?>