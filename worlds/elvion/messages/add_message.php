<?php
$res = '{"login":"error"}';

require_once('../common/common.php');
require_once('../common/connect.php');
require_once('../common/dbtables.php');


$charname = $_REQUEST['charname'];
$action = $_REQUEST['action'];
$message = $_REQUEST['message'];

$connection = mysqli_connect($db_host, $db_user, $db_pass, $db_name);
if (!$connection) {
	die('{"error":"Ошибка подключения к бд: '.mysqli_error($connection).'"}');
}

$query = 'SELECT char_name FROM '.$tb_user." WHERE user_name='".$username."' AND user_pass='".$userpass."'";
$result = mysqli_query($connection, $query) 
	or die('{"error":"Ошибка считывания данных: '.mysqli_error($connection).'"}');
$user = $result->fetch_assoc();

if ($action == 'add_message') {
	if ((check_user($username) == true) && (check_char($charname) == true)) {
		$message = str_replace('_', ' ', $message);
		$query = "INSERT INTO ".$tb_chat." (message_author, message_text) VALUES ('".$charname."', '".$message."')";
		if (mysqli_query($connection, $query)) {
			$res = '{"login":"ok"}';
		} else {
			die('{"error":"Ошибка сохранения данных: '.mysqli_error($connection).'"}');
		}
		mysqli_close($connection);		
	}
}

echo $res;
?>