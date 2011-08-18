**** KGB Game Panel restarter ****

Da li vam se nekada desilo da vam server padnezbog loseg plugina ili mape, a da vi niste u
mogucnosti da ga restartujete posto niste online?

Pomocu ove skripte, bilo ko ce moci da restartuje vas server SAMO ukoliko je server offline,
bez ikakvog pristupa u game panelu!


1.) Instalacija
	1) Uploadujte komplet skriptu u neki folder na vasem webhostingu, na primer u folder "restarter"
	2) Ulogujte se na KGB Game Panel, otvorite tab Profil i tu generisite novi API Token
	3) Na vasem web nalogu gde ste uploadovali ovu skriptu, otvorite config.php i tu unesite token
	4) U browseru otvorite www.vas-sajt.com/restarter i imacete spisak svih vasih servera, zajedno sa opcijama za restartovanje ukoliko su serveri offline
	
2.) Problemi
	1) Ne prikazuje se lista servera, niti dobijam opcije za restartovanje
	Otvorite config.php, pronadjite $config['feedVrsta'] i promenite sa 1 na 2 da promenite nacin na koji skripta uzima podatke.
	Ovo u vecini slucajeva resi problem.
	U slucaju da ne resi, onda je problem do limita vaseg webhostinga (na vecini free webhostinga se javlja taj problem), a
	jedino resenje ovog problema jeste da promenite webhosting provajdera.

3.) Prednosti u odnosu na prethodnu verziju
	1) GT.rs status se ucitava asinhrono (AJAX-om), tako da je ucitavanje stranice mnogo brze od prethodne verzije,
	gde se stranica prikazivala tek posto se pokupe podaci i sa gpanela i sa GT.rs-a
	2) Restartovanje servera je asinhrono (AJAX-om), tako da se posle restarta ne refreshuje komplet stranica,
	vec samo taj server, i odmah vidite po statusu da li je restart servera bio uspesan ili ne
	3) Pregledniji, stabilniji i kvalitetniji kod