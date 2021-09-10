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
		$user = array();
		$user['user_name'] = $username;
		$user['user_pass'] = $userpass;
		$user['char_name'] = $charname;
		$user['char_level'] = 1;
		$user['char_exp'] = 0;
		$user['char_food'] = 0;
		$user['char_gold'] = 0;
		$user['char_bank'] = 0;
		$user['char_damage_min'] = 2;
		$user['char_damage_max'] = 3;
		$user['char_armor'] = 0;
		$user['char_life_cur'] = 10;
		$user['char_life_max'] = 30;
		$user['char_mana_cur'] = 10;
		$user['char_mana_max'] = 20;

		save_character();
		$res = '2';
	}
}
echo $res;
?>