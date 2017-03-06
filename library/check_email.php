<?php

if($_SERVER['REMOTE_ADDR'] == '127.0.0.1') {
	DEFINE ('DB_HOST', 'localhost');
	DEFINE ('DB_USER', 'root');
	DEFINE ('DB_PASSWORD', '');
	DEFINE ('DB_NAME', 'help');
}
else {
	DEFINE ('DB_HOST', 'localhost');
	DEFINE ('DB_USER', 'pindobi1_pindobi');
	DEFINE ('DB_PASSWORD', 'rc2600');
	DEFINE ('DB_NAME', 'pindobi1_pindobi');
}

$link = @mysql_connect (DB_HOST, DB_USER, DB_PASSWORD) OR die ('Could not connect to MySQL; ' . mysql_connect());
mysql_query("SET NAMES 'utf8'");

@mysql_select_db(DB_NAME) OR die ('Could not select the database: ' . mysql_error());

$email = trim(strtolower($_REQUEST['email']));
$query = "SELECT id FROM member WHERE email = '" . $email ."'";

$result = mysql_query($query);
if($result && mysql_num_rows($result)) {
	echo 'false';
}
else {
	echo 'true';
}
?>