<?php
$res = '0';

include 'common/common.php';

$do = $_GET['do'];
$action = $_GET['action'];
$amount = $_GET['amount'];
$enemyslot = $_GET['enemyslot'];

if (file_exists(PATH.'characters'.DS.'character.'.$username.'.php')) {
	require PATH.'characters'.DS.'character.'.$username.'.php';
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
		// Gate
		include 'locations/gate.php';
		// Guilds
		include 'locations/guilds.php';
		// Graveyard
		include 'locations/graveyard.php';
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
		// Tavern
		include 'locations/tavern.php';
		// Bank
		include 'locations/bank.php';
	}
}

echo $res;
?>