<!DOCTYPE html>
<html>
	<head>
		<title><?php if (!isset($TITLE)) echo $s_name; else echo $TITLE . ' | ' . $s_name; ?></title>
		
		<!-- stylesheets -->
		<link rel="stylesheet" href="<?php echo $s_home; ?>themes/<?php echo $s_theme; ?>/res/Style.css" />
	</head>
	<body>
		<?php require $_SERVER['DOCUMENT_ROOT'] . $s_home . 'themes/' . $s_theme . '/Head.php'; ?>