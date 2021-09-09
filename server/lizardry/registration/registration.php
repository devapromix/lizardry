<?php
$res = '0';

include '../common/common.php';

$charname = $_GET['charname'];
$action = $_GET['action'];

if ($charname == '') die('23');
if (strlen($charname) < 4) die('33');
if (strlen($charname) > 24) die('43');

if ($action == 'registration') {
	if (file_exists('../characters/character.'.$username.'.php')) {
		$res = '1';
	} else{
		$user_name = $username; 
		$user_pass = $userpass; 
		$char_name = $charname; 
		$char_level = 1;
		$char_exp = 0;
		$char_food = 7;
		$char_gold = 50;
		$char_bank = 10;
		$char_equip_weapon = 101;
		$char_equip_armor = 201;
		$char_damage_min = 1;
		$char_damage_max = 3; 
		$char_armor = 1;
		$char_str = 5; 
		$char_dex = 5;
		$char_int = 5;
		$char_per = 5;
		$char_life_cur = 25;
		$char_life_max = 25; 
		$char_mana_cur = 10; 
		$char_mana_max = 10;
		$char_inv_hppotion = 3;
		$char_x = 1000; 
		$char_y = 1000;
		$char_stat_kills = 0;
		$char_stat_deads = 0;
		$char_monster = 0;
	
		save_character();
		$res = '2';
	}
}
echo $res;
?>