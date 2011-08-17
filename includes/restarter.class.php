<?php

class Restarter {
	
	function Restarter() {
		global $config;
	}
	
	function getServers() {
		global $config;
		$servers = array();
		foreach ($config['tokens'] as $tokenid=>$token) {
			$feed = "servers.php?auth=".$token;
			//echo $tokenid." ".$feed."<br />";
			
			$temp=$this->parseServersFromFeed($feed,$tokenid);
			array_push($servers,$temp);
			//$servers = $servers[0];
			
		}
		
		print_r($servers);
	}
	
	function parseServersFromFeed($feed,$tokenid) {
		$br_info = 7;
		$dump = $this->procitaj($feed);
		$info = explode("\n",$dump);
		
		if ($info[0]==0) $this->izbaciGresku($info[1]);
		
		$brojServera = $info[1];
		
		for ($j=1;$j<=$brojServera;$j++) {
			$server[$i]['serverid']		=	$info[(($j-1)*$br_info)+2+0];
			$server[$i]['name']			=	$info[(($j-1)*$br_info)+2+1];
			$server[$i]['game']			=	$info[(($j-1)*$br_info)+2+2];
			$server[$i]['ip']			=	$info[(($j-1)*$br_info)+2+3];
			$server[$i]['slots']		=	$info[(($j-1)*$br_info)+2+4];
			//$server[$i]['status']		=	$info[(($j-1)*$br_info)+2+5];
			$server[$i]['online']		=	$info[(($j-1)*$br_info)+2+6];
			$server[$i]['auth'] = $tokenid;
			
			/*
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
			 * 
			 */
			$i++;
		}
		
		return $server;
		
		
	}
	
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
	
	function izbaciGresku($text) {
		@ob_clean();
		die("GRESKA!<br />".$text);
	}
}

$restarter = new Restarter();

?>
