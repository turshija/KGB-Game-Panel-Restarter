<?
// auth token
// auth token generisete u vasem gpanelu pod stavkom "Profil"
// ako ga regenerisete, moracete da izmenite ovaj config i unesete novi token !

$token = array("vas-token-ide-ovde-lasdldsalkadsljkjlk8289090312");

// naziv sajta
$title = "Server Restarter";

// Broj provera 
// Ovaj broj oznacava koliko ce skripta puta da se konektuje na GT.rs i proveri da li je neki server offline ili ne
// Desava se nekad da je server na GT-u prikazan kao offline, tako da ovaj broj sprecava iskoriscavanje te greske
// Sto je veci broj, to je proces restarta duzi za jednu sekundu
// Preporuceno je da stavite broj izmedju 3 i 5
$brojSkeniranja = 3;

// IP-ovi koji se ne prikazuju u listi, na primer: array("212.200.163.182:27025","217.26.212.10:27015")
$preskoci = array("178.63.2.6:27069","217.26.212.40:8888");

// Vrsta Feed-a
// 1 - file_get_contents
// 2 - cURL
$feedVrsta = 1;

// link ka Gpanel i GT API-ju (ne menjati ako ne znate za sta sluzi !)
$apilink = "http://www.kgb-hosting.com/gpanel/api/"; 
$gtapilink = "http://www.gametracker.rs/feed.php";

// broj informacija po serveru na servers.php stranici (ne menjati ako ne znate za sta sluzi !)
$br_info = 7;

/****************************
	KRAJ KONFIGURACIJE
****************************/


function procitaj($link,$vrsta="panel") {
	global $apilink,$gtapilink,$feedVrsta;
	if ($feedVrsta==2) {
		$ch = curl_init();
		$timeout = 15;
	}
	if ($vrsta=="panel")
		if ($feedVrsta==1)
			$podaci=file_get_contents($apilink.$link); 
		else if ($feedVrsta==2)
			curl_setopt ($ch, CURLOPT_URL, $apilink.$link);
		else die("Nepoznata vrsta feed-a!");
	else if ($vrsta=="gt")
		if ($feedVrsta==1)
			$podaci=file_get_contents($gtapilink."?".$link); 
		else if ($feedVrsta==2)
			curl_setopt ($ch, CURLOPT_URL, $gtapilink."?".$link);
		else die("Nepoznata vrsta feed-a!");
	else die("Pogresna vrsta!");
	
	if ($feedVrsta==2) {
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

?>