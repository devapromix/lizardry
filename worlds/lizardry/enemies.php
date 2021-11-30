<?php

include 'common/connect.php';
include 'common/dbtables.php';

$connection = mysqli_connect($db_host, $db_user, $db_pass, $db_name);
if (!$connection) {
	die('{"error":"Ошибка подключения к бд: '.mysqli_error($connection).'"}');
}

$query = "SELECT enemy_image FROM ".$tb_enemy;
$result = mysqli_query($connection, $query) 
	or die('{"error":"Ошибка считывания данных: '.mysqli_error($connection).'"}');
$enemies = $result->fetch_all(MYSQLI_ASSOC);

echo json_encode($enemies, JSON_UNESCAPED_UNICODE);

mysqli_close($connection);

?>