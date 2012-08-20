<?php

class Restarter {
		
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
		global $config;
		$br_info = 7;
		$i=0;
		$dump = $this->procitaj($config['apilink'].$feed);
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
	function procitaj($link) {
		global $config;
		
		if ($config['feedVrsta']==2) {
			if (!function_exists('curl_init')) $this->izbaciGresku("Nemate cURL na web serveru!<br />U config.php promenite feedVrsta!");
			$ch = curl_init();
			$timeout = 15;
		}
		
		if ($config['feedVrsta']==1) {
			ini_set('user_agent','Mozilla/4.0 (compatible; MSIE 6.0)'); 	// laziranje user agenta
			$podaci=file_get_contents($link); 
			
		} else if ($config['feedVrsta']==2) {
			/**
			 * @credits: http://proazis.com/
			 */
			$curl = curl_init();
			curl_setopt($curl, CURLOPT_URL, $link);
			curl_setopt($curl, CURLOPT_USERAGENT, "Mozilla/5.0 (Windows NT 6.1) AppleWebKit/536.11 (KHTML, like Gecko) Chrome/20.0.1132.57 Safari/536.11");
			curl_setopt($curl, CURLOPT_HTTP_VERSION, CURL_HTTP_VERSION_1_1);
			curl_setopt($curl, CURLOPT_HEADER, true);
			curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
			$podaci = curl_exec($curl);
			curl_close($curl);
			$podaci = str_replace("\r\n", "\n", $podaci);
			$lines = explode("\n", $podaci);
			foreach($lines as $key => $value) {
				if(strpos($lines[$key], "Set-Cookie: ") === 0) {
					$temp = str_replace("Set-Cookie: ", "", $lines[$key]);
					list($cookie, $bla) = explode(";", $temp, 2);
					break;
				}
			}
			
			$curl = curl_init();
			curl_setopt($curl, CURLOPT_URL, $link. "&attempt=1");
			curl_setopt($curl, CURLOPT_USERAGENT, "Mozilla/5.0 (Windows NT 6.1) AppleWebKit/536.11 (KHTML, like Gecko) Chrome/20.0.1132.57 Safari/536.11");
			curl_setopt($curl, CURLOPT_HTTP_VERSION, CURL_HTTP_VERSION_1_1);
			curl_setopt($curl, CURLOPT_HEADER, false);
			curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
			curl_setopt($curl, CURLOPT_COOKIE, $cookie);
			$podaci = curl_exec($curl);
			curl_close($curl);
			
		} else $this->izbaciGresku("Nepoznata vrsta feed-a!");
		
		
		
		if (is_bool($podaci) && $podaci == false) {
			$error = "Doslo je do greske!<br />Nije primljen nikakav sadrzaj sa linka:<br /><strong>{$link}</strong>";
			// prolazi kroz sve tokene i uklanja iz linka kako posetioci ne bi mogli da ga vide
			foreach ($config['tokens'] as $id=>$token) {
				$error = str_replace($token,"[token{$id} uklonjen]",$error);
			}
			$this->izbaciGresku($error);
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
		$ret = $this->procitaj($config['apilink'].$server_process);
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
			$server = unserialize($this->procitaj($config['gtapilink']."?".$link));
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
'<div style="margin:auto;padding:0px 30px 30px 30px;width:800px;border:2px solid blue;">
<h3>Greska</h3>
'.$tekst.'
</div>';
		die($out);
	}
}

$restarter = new Restarter();

?>
