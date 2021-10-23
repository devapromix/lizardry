<?php
$res = '0';

include 'common/common.php';
include 'common/connect.php';

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
	// Gate
	include 'locations/gate.php';
	// Travel
	include 'locations/travel.php';
	include 'locations/stables.php';
	// Guilds
	include 'locations/guilds.php';
	// Shops
	include 'locations/shops.php';
	// Graveyard
	include 'locations/graveyard.php';
	// Crypt
	include 'locations/crypt.php';
	// Town
	include 'locations/town.php';
	// Forest
	include 'locations/forest.php';
	// Gray Cave
	include 'locations/graycave.php';
	// Deep Cave
	include 'locations/deepcave.php';
	// Stoneworm Lair
	include 'locations/stonewormlair.php';
	// Stone Field
	include 'locations/stonefield.php';
	// Tavern
	include 'locations/tavern.php';
	// Bank
	include 'locations/bank.php';
}

mysqli_close($connection);

echo $res;

?>