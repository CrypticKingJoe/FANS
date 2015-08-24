<?php
require "../inc/Settings.php";
require "../inc/Global.php";

if (isset($_GET['ID'])) {
	$ID = addslashes($_GET['ID']);
	$checkQ = $db->prepare("SELECT * FROM `users` WHERE `ID`='$ID'");
	$checkQ->execute();
	$check = $checkQ->fetch(PDO::FETCH_ASSOC);
	
	if ($check != 0) {
		// check online or offline
		$online = false;
		if (($check['LastSeen'] + 180) >= time())
			$online = true;
		
		$online_n = $online ? 1 : 0;
		
		$upd = $db->prepare("UPDATE `users` SET `Online`='$online_n' WHERE `ID`='$ID'");
		$upd->execute();
		
		$fimg = new FernImage('', 100, 200);
		$fimg->addLayer($_SERVER['DOCUMENT_ROOT'] . $s_home . 'img/avatar/default.png');
		
		if ($online)
			$fimg->addLayer($_SERVER['DOCUMENT_ROOT'] . $s_home . 'img/avatar/online.png');
		else
			$fimg->addLayer($_SERVER['DOCUMENT_ROOT'] . $s_home . 'img/avatar/offline.png');
		
		$fimg->collapse();
		$fimg->draw();
	}
}