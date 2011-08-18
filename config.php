<?
// auth token
// auth token generisete u vasem gpanelu pod stavkom "Profil"
// ako ga regenerisete, moracete da izmenite ovaj config i unesete novi token !
$config['tokens'] = array("82fe32a2a0113936343d5d5316626dcd22306dfd0019d4be8a66ae1574194002");

// Broj provera 
// Ovaj broj oznacava koliko ce skripta puta da se konektuje na GT.rs i proveri da li je neki server offline ili ne
// Desava se nekad da je server na GT-u prikazan kao offline, tako da ovaj broj sprecava iskoriscavanje te greske
// Sto je veci broj, to je proces restarta duzi za jednu sekundu
// Preporuceno je da stavite broj izmedju 3 i 5
$config['broj_skeniranja'] = 3;

// Vrsta Feed-a
// 1 - file_get_contents
// 2 - cURL
$config['feedVrsta'] = 1;

// link ka Gpanel i GT API-ju (ne menjati ako ne znate za sta sluzi !)
$config['apilink'] = "http://www.kgb-hosting.com/gpanel/api/"; 
$config['gtapilink'] = "http://www.gametracker.rs/feed.php";
?>