<?php

class Restarter {
		
	function procitaj($link,$vrsta="panel") {
		global $config;
		if ($config['feedVrsta']==2) {
			$ch = curl_init();
			$timeout = 15;
		}
		if ($vrsta=="panel")
			if ($config['feedVrsta']==1)
				$podaci=file_get_contents($config['apilink'].$link); 
			else if ($config['feedVrsta']==2)
				curl_setopt ($ch, CURLOPT_URL, $config['apilink'].$link);
			else die("Nepoznata vrsta feed-a!");
		else if ($vrsta=="gt")
			if ($config['feedVrsta']==1)
				$podaci=file_get_contents($config['gtapilink']."?".$link); 
			else if ($config['feedVrsta']==2)
				curl_setopt ($ch, CURLOPT_URL, $config['gtapilink']."?".$link);
			else die("Nepoznata vrsta feed-a!");
		else die("Pogresna vrsta!");
		
		if ($config['feedVrsta']==2) {
			curl_setopt ($ch, CURLOPT_RETURNTRANSFER, 1);
			curl_setopt ($ch, CURLOPT_CONNECTTIMEOUT, $timeout);
			$podaci = curl_exec($ch);
			curl_close($ch);
		}
		
		if (is_bool($podaci) && $podaci == false) { 
			die("Doslo je do greske!");
		} else {
			return $podaci;
		}
	}
}

$restarter = new Restarter();

?>
