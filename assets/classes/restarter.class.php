<?php

class Restarter {
	
	function Restarter() {
		global $config;
	}
	
	/*
	 * Metoda poziva parsiranje, i vraca listu servera u nizu
	 */
	function getServers() {
		global $config;
		$servers = array();
		foreach ($config['tokens'] as $tokenid=>$token) {
			$feed = "servers.php?auth=".$token;
			$temp=$this->parseServersFromFeed($feed,$tokenid);
			foreach ($temp as $server) {
				array_push($servers,$server);	
			}
		}
		return $servers;
	}
	
	/*
	 * Metoda cita Gpanel feed, parsira i vraca niz servera sa informacijama
	 */
	function parseServersFromFeed($feed,$tokenid) {
		$br_info = 7;
		$i=0;
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
			$server[$i]['online']		=	$info[(($j-1)*$br_info)+2+6];
			$server[$i]['auth']			=	$tokenid;
			
			$i++;
		}
		return $server;
	}
	
	/*
	 * Metoda vrati ceo sadrzaj datog linka
	 */
	function procitaj($link,$vrsta="panel") {
		global $config;
		if ($config['feedVrsta']==2) {
			if (!function_exists('curl_init')) $this->izbaciGresku("Nemate cURL na web serveru!<br />U config.php promenite feedVrsta!");
			$ch = curl_init();
			$timeout = 15;
		}
		if ($vrsta=="panel")
			if ($config['feedVrsta']==1)
				$podaci=file_get_contents($config['apilink'].$link); 
			else if ($config['feedVrsta']==2)
				curl_setopt ($ch, CURLOPT_URL, $config['apilink'].$link);
			else $this->izbaciGresku("Nepoznata vrsta feed-a!");
		else if ($vrsta=="gt")
			if ($config['feedVrsta']==1)
				$podaci=file_get_contents($config['gtapilink']."?".$link); 
			else if ($config['feedVrsta']==2)
				curl_setopt ($ch, CURLOPT_URL, $config['gtapilink']."?".$link);
			else $this->izbaciGresku("Nepoznata vrsta feed-a!");
		else $this->izbaciGresku("Pogresna vrsta!");
		
		if ($config['feedVrsta']==2) {
			curl_setopt ($ch, CURLOPT_RETURNTRANSFER, 1);
			curl_setopt ($ch, CURLOPT_CONNECTTIMEOUT, $timeout);
			$podaci = curl_exec($ch);
			curl_close($ch);
		}
		
		if (is_bool($podaci) && $podaci == false) { 
			$this->izbaciGresku("Doslo je do greske!");
		} else {
			return $podaci;
		}
	}
	
	/*
	 * Metoda restartuje server pozivom KGB API-ja
	 */
	function restartujServer($serverid,$token) {
		global $config;
		$server_process = "server_process.php?task=restart&auth=$token&id=$serverid";
		$ret = $this->procitaj($server_process);
		//$info = explode("\n",$ret);
		return true;
	}
	
	/*
	 * metoda skenira server na GT.rs i vraca informacije
	 */
	function skenirajServer($ip) {
		global $config;
		$br_skeniranja = $config['broj_skeniranja'];
		$link = "ip={$ip}";
		while (($br_skeniranja--)>0) {
			$server = unserialize($this->procitaj($link,"gt"));
			if (!$server) break;
			if ($server['b']['status']=="1") break;
			sleep(1);
		}
		return $server;
	}

	/*
	 * Sigurnosna metoda, iz IP adrese izbaci sve sto nije broj, tacka ili dvotacka
	 */
	function ocistiIP($ip) {
		return ereg_replace("[^0-9\.\:]", "", $ip );
	}
	
	/*
	 * Metoda ocisti output buffer, a zatim ispise gresku
	 */
	function izbaciGresku($tekst) {
		@ob_clean();
		$out = 
'<div style="margin:auto;padding:0px 30px 30px 30px;width:500px;border:2px solid blue;">
<h3>Greska</h3>
'.$tekst.'
</div>';
		die($out);
	}
}

$restarter = new Restarter();

?>
