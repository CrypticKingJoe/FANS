<?php
$SETTINGS = true;

$s_mysql_host = 'localhost';
$s_mysql_dbname = 'fans';
$s_mysql_usname = 'fansuser';
$s_mysql_uspass = 'fans';

$s_name = 'FANS';
$s_home = '/FANS/FANS/';
$s_theme = 'default';
$s_logo = 'logo.png';

$s_navlinks = array(
	array('Home', ''),
	array('Members', 'members/'),
	array('Store', 'store/'),
	array('Forums', 'forums/'),
	array('Blog', 'blog/')
);

$s_usernavlinks = array(
	array('Test', 'test/'),
	array('Test2', 'test2/'),
	array('Test3', 'test3/')
);

$s_register_username_min = 3;
$s_register_username_max = 12;
$s_register_username_whitespaces = true;
$s_register_password_min = 6;