<?php
$res = '{"registration":"error"}';

require_once('../common/common.php');
require_once('../common/connect.php');
require_once('../common/dbtables.php');
require_once(IPATH.'class.event.php');
require_once(IPATH.'class.user.php');

$username = $_GET['username'];
$userpass = $_GET['userpass'];
$charname = $_GET['charname'];
$chargender = $_GET['chargender'];
$charrace = $_GET['charrace'];
$action = $_GET['action'];

$connection = mysqli_connect($db_host, $db_user, $db_pass, $db_name);
if (!$connection) {
	die('{"error":"Ошибка подключения к бд: '.mysqli_error($connection).'"}');
}

User::check_registration_data($username, $userpass, $charname);

if ($action == 'registration') {
	if (User::check_user($username) == true) {
		$res = '{"error":"Пользователь с таким именем существует!"}';
	} else{
		$query = "INSERT INTO ".$tb_user." (user_name, user_pass, char_name, char_gender, char_race) VALUES ('".$username."', '".$userpass."', '".$charname."', ".$chargender."', ".$charrace.")";
		if (mysqli_query($connection, $query)) {
			Event::add(0, $charname, 1, $chargender);
			$res = '{"registration":"ok"}';
		} else {
			die('{"error":"Ошибка сохранения данных: '.mysqli_error($connection).'"}');
		}
		mysqli_close($connection);		
	}
}

echo $res;
?>