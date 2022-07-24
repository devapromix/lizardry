<?php

include 'common/connect.php';
include 'common/dbtables.php';

$connection = mysqli_connect($db_host, $db_user, $db_pass, $db_name);
if (!$connection) {
	die('{"error":"Ошибка подключения к бд: '.mysqli_error($connection).'"}');
}

$query = "SELECT message_author, message_text FROM ".$tb_chat;
$result = mysqli_query($connection, $query) 
	or die('{"error":"Ошибка считывания данных: '.mysqli_error($connection).'"}');
$messages = $result->fetch_all(MYSQLI_ASSOC);

echo json_encode($messages, JSON_UNESCAPED_UNICODE);

mysqli_close($connection);

?>