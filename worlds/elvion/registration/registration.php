<?php
$res = '0';

include '../common/common.php';
include '../common/connect.php';
include '../common/dbtables.php';


$charname = $_GET['charname'];
$chargender = $_GET['chargender'];
$charrace = $_GET['charrace'];
$action = $_GET['action'];

if ($charname == '') die('23');
if (strlen($charname) < 4) die('33');
if (strlen($charname) > 24) die('43');

$connection = mysqli_connect($db_host, $db_user, $db_pass, $db_name);
if (!$connection) {
	die('{"error":"Ошибка подключения к бд: '.mysqli_error($connection).'"}');
}

if ($action == 'registration') {
	if (check_user($username) == true) {
		$res = '1';
	} else{
		$query = "INSERT INTO ".$tb_user." (user_name, user_pass, char_name, char_gender, char_race) VALUES ('".$username."', '".$userpass."', '".$charname."', ".$chargender."', ".$charrace.")";
		if (mysqli_query($connection, $query)) {
			add_event(0, $charname, 1, $chargender);
			$res = '2';
		} else {
			die('{"error":"Ошибка сохранения данных: '.mysqli_error($connection).'"}');
		}
		mysqli_close($connection);		
	}
}

echo $res;
?>