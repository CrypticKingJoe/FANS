<?php
require "Global.php";
?>
<!DOCTYPE html>
<html>
	<head>
		<?php
		if (isset($TITLE)) { ?><title><?php echo $TITLE . ' | ' . $s_name; ?></title><?php } ?>
		
		<!-- stylesheets -->
		<link rel="stylesheet" href="<?php echo $s_home; ?>themes/<?php echo $s_theme; ?>/res/Style.css" />
		<link rel="stylesheet" href="<?php echo $s_home; ?>res/Responsive.css" />
		<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.4.0/css/font-awesome.min.css" >
		
		<!-- scripts -->
		<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.4/jquery.min.js"></script>
	</head>
	<body>
		<?php require $_SERVER['DOCUMENT_ROOT'] . $s_home . 'themes/' . $s_theme . '/Head.php'; ?>