<?php
require "../inc/Settings.php";
require "../inc/Global.php";

$output = 0;

if (isset($_POST['ID']) && isset($_POST['About'])) {
	if ($logged && $user['ID'] == $_POST['ID']) {
		$ID = $user['ID'];
		$about = addslashes(strip_tags($_POST['About']));
		
		$upd = $db->prepare("UPDATE `users` SET `About`='$about' WHERE `ID`='$ID'");
		$upd->execute();
		
		$output = stripslashes($about);
	}
}

echo $output; 