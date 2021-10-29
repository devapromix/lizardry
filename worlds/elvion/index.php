<?php
$res = '0';

include 'common/common.php';
include 'common/connect.php';
include 'common/dbtables.php';

$do = $_GET['do'];
$action = $_GET['action'];
$amount = $_GET['amount'];
$itemslot = $_GET['itemslot'];
$enemyslot = $_GET['enemyslot'];

$connection = mysqli_connect($db_host, $db_user, $db_pass, $db_name);
if (!$connection) {
	die('{"error":"Ошибка подключения к бд: '.mysqli_error($connection).'"}');
}

$query = 'SELECT * FROM '.$tb_user." WHERE user_name='".$username."' AND user_pass='".$userpass."'";
$result = mysqli_query($connection, $query) 
	or die('{"error":"Ошибка считывания данных: '.mysqli_error($connection).'"}');
$user = $result->fetch_assoc();

if (($userpass != '')&&($userpass == $user['user_pass'])) {
	if ($action == 'login') {
		$res = '1';
	}
	if ($action == 'version') {
		$res = get_file_int(PATH.'version.txt');
	}
	// Camp
	include 'locations/camp.php';
	// Battle
	include 'locations/battle.php';
	include 'locations/auto_battle.php';
	// Town
	include 'locations/town.php';
	// Tavern
	include 'locations/tavern.php';
	// Bank
	include 'locations/bank.php';
	// Gate
	include 'locations/gate.php';
	// Travel
	include 'locations/travel.php';
	// Outlands
	include 'locations/outlands.php';
	// Guilds
	include 'locations/guilds.php';
	// Shops
	include 'locations/shops.php';
	// Graveyard
	include 'locations/graveyard.php';
}

mysqli_close($connection);

echo $res;

?>