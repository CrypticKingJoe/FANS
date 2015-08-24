<?php
ob_start();
session_start();

if (!isset($SETTINGS)) {
	die("Uninitialised.");
}

require $_SERVER['DOCUMENT_ROOT'] . $s_home . 'libs/FernImage.php';

function encrypt($password, $salt) {
	$format = '$2y$10$';
	$fsalt = $format . $salt;
	$encrypted = crypt($password, $fsalt);
	return $encrypted;
}

function generateSalt() {
	$rstr = md5(uniqid(mt_rand(), true));
	$b64str = base64_encode($rstr);
	$mb64str = str_replace('+', '.', $b64str);
	$salt = substr($mb64str, 0, 22);
	
	return $salt;
}

if (!defined("CRYPT_BLOWFISH") || !CRYPT_BLOWFISH) {
	die("Blowfish is not enabled in this version of PHP.<br />Please consider upgrading to PHP 5.4 or later.");
}

// attempt to connect to the database
try {
	$db = new PDO('mysql:host=' . $s_mysql_host . ';dbname=' . $s_mysql_dbname, $s_mysql_usname, $s_mysql_uspass);
} catch (PDOException $e) {
	die("Could not connect to database: " . $e->getMessage());
}

// user specific variables
$ip = $_SERVER['REMOTE_ADDR'];

$user = null;
$logged = false;
if (isset($_SESSION['logged']) && isset($_SESSION['uid'])) {
	if ($_SESSION['logged'] && $_SESSION['uid'] != 0) {
		$uid = $_SESSION['uid'];
		$checkQ = $db->prepare("SELECT * FROM `users` WHERE `ID`='$uid'");
		$checkQ->execute();
		$check = $checkQ->fetch(PDO::FETCH_ASSOC);
		
		if ($check != 0) {
			$user = $check;
			$logged = true;
		}
	}
}

// other variables
if (!isset($PAGE))
	$PAGE = "";