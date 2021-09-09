<?php
$username = $_GET['username'];
$userpass = $_GET['userpass'];

if ($username == '') die('21');
if ($userpass == '') die('22');

if (strlen($username) < 4) die('31');
if (strlen($userpass) < 4) die('32');

if (strlen($username) > 24) die('41');
if (strlen($userpass) > 24) die('42');

function save_character() {
	global $user_name, $user_pass, $char_name, $char_level, $char_exp, $char_food, $char_gold, $char_bank,
	$char_equip_weapon, $char_equip_armor, $char_damage_min, $char_damage_max, $char_armor,
	$char_str, $char_dex, $char_int, $char_per, $char_life_cur, $char_life_max, $char_mana_cur, $char_mana_max,
	$char_inv_hppotion,
	$char_x, $char_y, $char_stat_kills, $char_stat_deads, $char_monster;
	
	$file .= "<?php\n\n";
	
	$file .= '$user_name = "'.$user_name.'";'."\n";
	$file .= '$user_pass = "'.$user_pass.'";'."\n";
	$file .= '$char_name = "'.$char_name.'";'."\n";
	$file .= '$char_level = '.$char_level.';'."\n";
	$file .= '$char_exp = '.$char_exp.';'."\n";
	$file .= '$char_food = '.$char_food.';'."\n";
	$file .= '$char_gold = '.$char_gold.';'."\n";
	$file .= '$char_bank = '.$char_bank.';'."\n";
	$file .= '$char_equip_weapon = '.$char_equip_weapon.';'."\n";
	$file .= '$char_equip_armor = '.$char_equip_armor.';'."\n";
	$file .= '$char_damage_min = '.$char_damage_min.';'."\n";
	$file .= '$char_damage_max = '.$char_damage_max.';'."\n";
	$file .= '$char_armor = '.$char_armor.';'."\n";
	$file .= '$char_str = '.$char_str.';'."\n";
	$file .= '$char_dex = '.$char_dex.';'."\n";
	$file .= '$char_int = '.$char_int.';'."\n";
	$file .= '$char_per = '.$char_per.';'."\n";
	$file .= '$char_life_cur = '.$char_life_cur.';'."\n";
	$file .= '$char_life_max = '.$char_life_max.';'."\n";
	$file .= '$char_mana_cur = '.$char_mana_cur.';'."\n";
	$file .= '$char_mana_max = '.$char_mana_max.';'."\n";
	$file .= '$char_inv_hppotion = '.$char_inv_hppotion.';'."\n";
	$file .= '$char_x = '.$char_x.';'."\n";
	$file .= '$char_y = '.$char_y.';'."\n";
	$file .= '$char_stat_kills = '.$char_stat_kills.';'."\n";
	$file .= '$char_stat_deads = '.$char_stat_deads.';'."\n";
	$file .= '$char_monster = '.$char_monster.';'."\n";
	
	$file .= "\n?>";

	file_put_contents('../characters/character.'.$user_name.'.php', $file);	
}

function all_response() {
	global $char_name, $char_level, $char_exp, $char_food, $char_gold, $char_life_cur, $char_life_max;
	return "|all:".$char_name.":".$char_level.":".$char_exp.":".$char_food.":".$char_gold.":".$char_life_cur.":".$char_life_max;
}

function rest_response() {
	global $char_gold, $char_food, $char_life_cur, $char_life_max;
	return "|rest:".$char_gold.":".$char_food.":".$char_life_cur.":".$char_life_max;
}

?>