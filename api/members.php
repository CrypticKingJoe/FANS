<?php
require "../inc/Settings.php";
require "../inc/Global.php";

$result = "";

if (isset($_GET['query'])) {
	$sql = "SELECT * FROM `users` ";

	if (isset($_GET['filter']) && $_GET['filter'] != '0') {
		$filter = $_GET['filter'];

		if ($filter == "1") {
			$sql .= "WHERE `Online`='1' ";	
		} elseif ($filter == 2) {
			$sql .= "WHERE (`Admin`='1' OR `Moderator`='1' OR `Artist`='1') AND `Online`='1' ";
		} elseif ($filter == 3) {
			$sql .= "WHERE `Moderator`='1' AND `Online`='1' ";
		} elseif ($filter == 4) {
			$sql .= "WHERE `Artist`='1' AND `Online`='1' ";
		}

		if (isset($_GET['q']) && !empty($_GET['q'])) {
			$q = addslashes($_GET['q']);
			$sql .= "AND `Username` LIKE '%$q%' ORDER BY `ID`";
		}

	} else {
		if (isset($_GET['q']) && !empty($_GET['q'])) {
			$q = addslashes($_GET['q']);
			$sql .= "WHERE `Username` LIKE '%$q%' ORDER BY `ID`";
		} else {
			$sql .= "ORDER BY `ID` DESC";
		}
	}

	if (isset($_GET['start']) && isset($_GET['stop'])) {
		if (is_numeric($_GET['start']) && is_numeric($_GET['stop'])) {
			$start = addslashes($_GET['start']);
			$stop = addslashes($_GET['stop']);
			$sql .= " LIMIT $start, $stop";
		}
	}

	$checkQ = $db->prepare($sql);
	$checkQ->execute();

	while ($check = $checkQ->fetch(PDO::FETCH_ASSOC)) {
		$result .= $check['ID'] . ',' . $check['Username'] . ':';
	}
} elseif (isset($_GET['stats'])) {
	$regQ = $db->prepare("SELECT * FROM `users` ORDER BY `ID`");
	$regQ->execute();
	$reg = $regQ->rowCount();
	
	$usroQ = $db->prepare("SELECT * FROM `users` WHERE `Online`='1' ORDER BY `ID`");
	$usroQ->execute();
	$usro = $usroQ->rowCount();
	
	$gueso = 0;
	
	$result = strval($reg) . ',' . strval($usro) . ',' . $gueso . ',';
}

$result = substr($result, 0, -1);
echo $result;