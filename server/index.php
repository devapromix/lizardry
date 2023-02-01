<?php
$res = '{"login":"error"}';

require_once('common/common.php');
require_once('common/connect.php');
require_once('common/dbtables.php');
require_once(IPATH.'class.location.php');
require_once(IPATH.'class.battle.php');
require_once(IPATH.'class.player.php');
require_once(IPATH.'class.server.php');
require_once(IPATH.'class.magic.php');
require_once(IPATH.'class.item.php');
require_once(IPATH.'class.event.php');
require_once(IPATH.'class.enemy.php');
require_once(IPATH.'class.boss.php');
require_once(IPATH.'class.user.php');
require_once(IPATH.'class.stringbox.php');
require_once(IPATH.'class.effects.php');

$do = $_GET['do'];
$action = $_GET['action'];
$amount = $_GET['amount'];
$itemslot = $_GET['itemslot'];
$lootslot = $_GET['lootslot'];
$enemyslot = $_GET['enemyslot'];
$itemindex = $_GET['itemindex'];
$username = $_GET['username'];
$userpass = $_GET['userpass'];
$usersession = $_GET['usersession'];

$connection = mysqli_connect($db_host, $db_user, $db_pass, $db_name);
if (!$connection)
	die('{"error":"Ошибка подключения к бд: '.mysqli_error($connection).'"}');

$user = User::init($username, $userpass);

if (($userpass != '') && ($userpass == $user['user_pass'])) {
	if ($action == 'login') $res = '{"login":"ok","session":"'.User::session().'"}';
	if ($action == 'version') $res = Server::VERSION;
	if ($action == 'events') $res = Event::get_events();
	if ($usersession == $user['user_session']) {
		if ($action == 'items') $res = Item::get_items();
		if ($action == 'enemies') $res = Enemy::get_enemies();
		if ($action == 'effects') $res = Effects::get_effects();
	
		$user['class'] = array();
		$user['class']['location'] = new Location();
		$user['class']['battle'] = new Battle();
		$user['class']['effect'] = new Effects();
		$user['class']['player'] = new Player();
		$user['class']['magic'] = new Magic();
		$user['class']['item'] = new Item();
	
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