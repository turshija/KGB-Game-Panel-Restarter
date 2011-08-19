KGB Game Panel restarter
========================

Da li vam se nekada desilo da vam server padnezbog loseg plugina ili mape, a da vi niste u
mogucnosti da ga restartujete posto niste online?

Pomocu ove skripte, bilo ko ce moci da restartuje vas server SAMO ukoliko je server offline,
bez ikakvog pristupa u game panelu!


Instalacija
-----------
	* Uploadujte komplet skriptu u neki folder na vasem webhostingu, na primer u folder "restarter"
	* Ulogujte se na KGB Game Panel, otvorite tab Profil i tu generisite novi API Token
	* Na vasem web nalogu gde ste uploadovali ovu skriptu, otvorite config.php i tu unesite token
	* U browseru otvorite www.vas-sajt.com/restarter i imacete spisak svih vasih servera, zajedno sa opcijama za restartovanje ukoliko su serveri offline
	
Problemi
--------
	* Ne prikazuje se lista servera, niti dobijam opcije za restartovanje
	Otvorite config.php, pronadjite $config['feedVrsta'] i promenite sa 1 na 2 da promenite nacin na koji skripta uzima podatke.
	Ovo u vecini slucajeva resi problem.
	U slucaju da ne resi, onda je problem do limita vaseg webhostinga (na vecini free webhostinga se javlja
	taj problem), a	jedino resenje ovog problema jeste da promenite webhosting provajdera.

Prednosti u odnosu na prethodnu verziju
---------------------------------------
	* GT.rs status se ucitava asinhrono (AJAX-om), tako da je ucitavanje stranice mnogo brze od prethodne verzije,
	gde se stranica prikazivala tek posto se pokupe podaci i sa gpanela i sa GT.rs-a
	* Restartovanje servera je asinhrono (AJAX-om), tako da se posle restarta ne refreshuje komplet stranica,
	vec samo taj server, i odmah vidite po statusu da li je restart servera bio uspesan ili ne
	* Pregledniji, stabilniji i kvalitetniji kod
	* Serveri koji nisu dodati na GT.rs se automatski uklanjaju sa liste, zbog preglednosti