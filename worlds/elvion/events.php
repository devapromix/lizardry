<?php

include 'common/connect.php';
include 'common/dbtables.php';

$connection = mysqli_connect($db_host, $db_user, $db_pass, $db_name);
if (!$connection) {
	die('{"error":"Ошибка подключения к бд: '.mysqli_error($connection).'"}');
}

$query = "SELECT event_type, event_char_name, event_char_level FROM ".$tb_events." LIMIT 10";
$result = mysqli_query($connection, $query) 
	or die('{"error":"Ошибка считывания данных: '.mysqli_error($connection).'"}');
$events = $result->fetch_all(MYSQLI_ASSOC);

echo json_encode($events, JSON_UNESCAPED_UNICODE);

mysqli_close($connection);

?>