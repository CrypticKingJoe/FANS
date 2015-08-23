<?php
require "../inc/Settings.php";
require "../inc/Global.php";

$result = 0;

if (isset($_GET['username'])) {
	$username = addslashes($_GET['username']);
	$checkQ = $db->prepare("SELECT * FROM `users` WHERE `Username`='$username'");
	$checkQ->execute();
	$check = $checkQ->fetch(PDO::FETCH_ASSOC);
	
	if ($check == 0) {
		if (strlen($username) < $s_register_username_min)
			$result = 2;
		else {
			if (strlen($username) > $s_register_username_max)
				$result = 3;
			else {
				$whitelist = array_merge(range('A','Z'), range('a','z'));
				if ($s_register_username_whitespaces)
					array_push($whitelist, ' ');
				for ($i = 0; $i <= 9; $i++)
					array_push($whitelist, strval($i));
				
				$uarr = str_split($username);
				foreach ($uarr as $uchar) {
					$ok = false;
					foreach ($whitelist as $wchar) {
						if ($uchar == $wchar) {
							$ok = true;
						}
					}
					if (!$ok) {
						$result = 4;
					}
				}
			}
		}
	} else
		$result = 1;
}

if (isset($_POST['password'])) {
	if (strlen($_POST['password']) < $s_register_password_min)
		$result = 1;
}

if (isset($_GET['email'])) {
	if (!filter_var($_GET['email'], FILTER_VALIDATE_EMAIL)) 
		$result = 1;
}

echo $result;