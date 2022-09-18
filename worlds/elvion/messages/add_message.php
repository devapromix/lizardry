<?php
$res = '0';

include '../common/common.php';
include '../common/connect.php';
include '../common/dbtables.php';


$charname = $_REQUEST['charname'];
$action = $_REQUEST['action'];
$message = $_REQUEST['message'];

$connection = mysqli_connect($db_host, $db_user, $db_pass, $db_name);
if (!$connection) {
	die('{"error":"Ошибка подключения к бд: '.mysqli_error($connection).'"}');
}

if ($action == 'add_message') {
	if ((check_user($username) == true) && (trim($charname) != '')) {
		$message = str_replace('_', ' ', $message);
		$query = "INSERT INTO ".$tb_chat." (message_author, message_text) VALUES ('".$charname."', '".$message."')";
		if (mysqli_query($connection, $query)) {
			$res = '2';
		} else {
			die('{"error":"Ошибка сохранения данных: '.mysqli_error($connection).'"}');
		}
		mysqli_close($connection);		
	}
}

echo $res;
?>