/*
 * KGB Game Panel restarter
 * Author: Boris Vujicic
 */
var debug = 0;	// debug
var maxSimultaneous = 10;	// broj maksimalno dozvoljenih GT skeniranja u jednom trenutku
var currentSimultaneous = 0;
var removed=0,retry=[],ajaxHandler=[];	// globals

$(document).ready(function(){
	if (!debug) $(".debug").hide();		// sakrije debug kolonu ako je !debug
});

/*
 * Ovo je sa namerom izbaceno van .ready-ja, da bi sacekali da se ucitaju
 * sve slike (loading animacije) pre nego sto krene da se refreshuje GT.rs status
 */
$(window).load(function() {
	$(".red").each(function(i) {
		refreshGT($(this).attr("rel"),$(this).attr("id"),$(this).attr("src"),0);
	});
});

/*
 * Funkcija kupi informacije sa GT-a i prikazuje status servera ili restart dugme ako je offline
 */

function refreshGT(ip,id,auth,count) {
	if (currentSimultaneous>=maxSimultaneous) {
		count++;
		$("#"+id+" td:nth-child(5)").html(count)
		setTimeout("refreshGT('"+ip+"','"+id+"','"+auth+"','"+count+"')",100);
		return true;
	} else {
		currentSimultaneous++;
	}
	
	if (count=="-1") $("#"+id+" td:nth-child(5)").html("RETRY!");
	
	retry[id] = setTimeout("refreshGT('"+ip+"','"+id+"','"+auth+"','-1');ajaxHandler["+id+"].abort;return true;",10000);	// u slucaju da ne skenira za 10 sekundi, onda pokusa ponovo
	ajaxHandler[id] = $.ajax({
		type: "POST",
		url: "process.php",
		data: {
			'task': 'gtstatus',
			'ip': ip
		},
		dataType: "json",
		success: function(data){
			clearTimeout(retry[id]);		// u slucaju da je uspesno zavrseno, brise setTimeout koji bi trebao da uradi retry
			currentSimultaneous--;
			
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
			refreshGT(ip,id,auth,0);
		},
	});
}
