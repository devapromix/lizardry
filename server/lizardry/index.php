<?php
$res = '0';

include 'common/common.php';

$action = $_GET['action'];
$do = $_GET['do'];
$amount = $_GET['amount'];

if (file_exists($_SERVER['DOCUMENT_ROOT'].'/lizardry/characters/character.'.$username.'.php')) {
	require $_SERVER['DOCUMENT_ROOT'].'/lizardry/characters/character.'.$username.'.php';
	if (($userpass != '')&&($userpass == $user['user_pass'])) {
		if ($action == 'login') {
			$res = '1';
		}
		// Gate
		include 'locations/gate.php';
		// Guilds
		include 'locations/guilds.php';
		// Graveyard
		include 'locations/graveyard.php';
		// Outlands
		include 'locations/battle.php';
		// Town
		include 'locations/town.php';
		// Forest
		include 'locations/forest.php';
		// Tavern
		include 'locations/tavern.php';
		// Bank
		include 'locations/bank.php';
	}
}

echo $res;
?>