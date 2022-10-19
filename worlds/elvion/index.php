<?php
$res = '{"login":"error"}';

require_once('common/common.php');
require_once('common/locations.php');
require_once('common/connect.php');
require_once('common/dbtables.php');

$do = $_GET['do'];
$action = $_GET['action'];
$amount = $_GET['amount'];
$itemslot = $_GET['itemslot'];
$lootslot = $_GET['lootslot'];
$enemyslot = $_GET['enemyslot'];
$itemindex = $_GET['itemindex'];

$connection = mysqli_connect($db_host, $db_user, $db_pass, $db_name);
if (!$connection)
	die('{"error":"Ошибка подключения к бд: '.mysqli_error($connection).'"}');
$user = get_user($username, $userpass);

if (($userpass != '') && ($userpass == $user['user_pass'])) {
	if ($action == 'login') $res = '{"login":"ok","session":"'.gen_user_session().'"}';
	if ($action == 'version') $res = get_version();
	if ($action == 'events') $res = get_events();
	if ($usersession == $user['user_session']) {
		if ($action == 'inventory') $res = get_inventory();
		if ($action == 'items') $res = get_items();
		if ($action == 'enemies') $res = get_enemies();
		if ($action == 'messages') $res = get_messages();
	
		require_once(IPATH.'class.location.php');
		require_once(IPATH.'class.player.php');
		require_once(IPATH.'class.battle.php');

		$user['class'] = array();
		$user['class']['player'] = new Player();
		$user['class']['battle'] = new Battle();
		$user['class']['location'] = new Location();
	
		require_once('locations/battle.php');
		require_once('locations/campfire.php');
		require_once('locations/town.php');
		require_once('locations/tavern.php');
		require_once('locations/bank.php');
		require_once('locations/magictower.php');
		require_once('locations/gate.php');
		require_once('locations/travel.php');
		require_once('locations/outlands.php');
		require_once('locations/guilds.php');
		require_once('locations/shops.php');
		require_once('locations/graveyard.php');
	}
}

mysqli_close($connection);

echo $res;

?>