<?php
$res = '0';

include '../common/common.php';

$charname = $_GET['charname'];
$action = $_GET['action'];

if ($charname == '') die('23');
if (strlen($charname) < 4) die('33');
if (strlen($charname) > 24) die('43');

if ($action == 'registration') {
	if (file_exists(PATH.'characters'.DS.'character.'.$username.'.php')) {
		$res = '1';
	} else{
		$user = array();
		$user['user_name'] = $username;
		$user['user_pass'] = $userpass;
		$user['char_name'] = $charname;
		$user['char_level'] = 1;
		$user['char_exp'] = 0;
		$user['char_food'] = 7;
		$user['char_gold'] = 50;
		$user['char_bank'] = 100;
		$user['char_damage_min'] = 2;
		$user['char_damage_max'] = 3;
		$user['char_armor'] = 0;
		$user['char_life_cur'] = 30;
		$user['char_life_max'] = 30;
		$user['char_mana_cur'] = 10;
		$user['char_mana_max'] = 10;

		$user['enemy_slot_1'] = 0;
		$user['enemy_slot_2'] = 0;
		$user['enemy_slot_3'] = 0;
		$user['enemy_block_refresh'] = 0;

		$user['enemy_name'] = "";
		$user['enemy_image'] = "";
		$user['enemy_level'] = 1;
		$user['enemy_exp'] = 5;
		$user['enemy_gold'] = 5;
		$user['enemy_damage_min'] = 1;
		$user['enemy_damage_max'] = 2;
		$user['enemy_armor'] = 0;
		$user['enemy_life_cur'] = 10;
		$user['enemy_life_max'] = 10;

		$user['current_outlands'] = "";

		save_character();
		add_event(0);
		$res = '2';
	}
}
echo $res;
?>