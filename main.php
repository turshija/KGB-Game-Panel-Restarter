<?php
ob_start();
if (!@include "config.php") {
	ob_clean();
	die('<div style="margin:auto;padding:0px 30px 30px 30px;width:800px;border:2px solid blue;">
		<h3>Greska</h3>
		Morate renamovati config.php.default u config.php i upisati unutra svoj token izmedju navodnika !
		</div>');
}
include "assets/classes/restarter.class.php";
?>