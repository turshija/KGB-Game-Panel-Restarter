$(document).ready(function(){
	// trenutno nista :)
});

/*
 * Ovo je sa namerom izbaceno van .ready-ja, da bi sacekali da se ucitaju
 * sve slike (loading animacije) pre nego sto krene da se refreshuje GT.rs status
 */
$(window).load(function() {
	$(".red").each(function(i) {
		refreshGT($(this).attr("rel"),$(this).attr("id"),$(this).attr("src"));
	});
});

/*
 * Funkcija kupi informacije sa GT-a i prikazuje status servera ili restart dugme ako je offline
 */
var removed=0;	// global
function refreshGT(ip,id,auth) {
	$.ajax({
		type: "POST",
		url: "process.php",
		data: {
			'task': 'gtstatus',
			'ip': ip
		},
		dataType: "json",
		success: function(data){
			if (data.action=="hide") {
				$("#"+id).fadeOut();
				removed++;
				$("#removedServersNotif").show().find("span").text(removed);
			} else {
				restart = "<span class=\"restartBtn\" onclick=\"restartujServer('"+id+"','"+auth+"','"+ip+"')\">Restartuj</span>";
				$("#"+id+" td:nth-child(3)").html(data.players).next().html((data.status=="1")?'Online':restart);
			}
		},
	});
}
/*
 * Funkcija podesi loading sliku i asinhrono poziva skriptu koja ce restartovati server ako je offline
 */
function restartujServer(id,auth,ip) {
	$("#"+id+" td:nth-child(4)").html("<img src=\"assets/images/status-loader.gif\" /> restarting");
	$.ajax({
		type: "POST",
		url: "process.php",
		data: {
			'task': 'restartServer',
			'serverid': id,
			'auth':auth,
			'ip':ip
		},
		dataType: "json",
		success: function(data){
			refreshGT(ip,id,auth);
		},
	});
}
