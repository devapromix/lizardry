<?php
define('DS', DIRECTORY_SEPARATOR);
define('PATH', dirname(__FILE__).DS.'..'.DS);
define('IPATH', 'includes'.DS);

require_once(IPATH.'class.location.php');

$username = $_GET['username'];
$userpass = $_GET['userpass'];
$usersession = $_GET['usersession'];

if ($username == '') die('21');
if ($userpass == '') die('22');

if (strlen($username) < 4) die('31');
if (strlen($userpass) < 4) die('32');

if (strlen($username) > 24) die('41');
if (strlen($userpass) > 24) die('42');

const RAND_PLACE_COUNT 	= 7;

const EMPTY_ELIX 		= '600';
const HP_ELIX 			= '601';
const MP_ELIX 			= '602';
const ST_ELIX 			= '603';
const RF_ELIX 			= '604';

const MASH_HERB			= '750';
const HP_HERB			= '751';
const MP_HERB			= '752';
const ST_HERB			= '753';

const MANA_SCROLL_TP	= 8;
const MANA_SCROLL_HEAL	= 10;

$location = new Location();

function gen_enemy($enemy_ident) {
	global $user, $tb_enemy, $connection;
	$query = "SELECT * FROM ".$tb_enemy." WHERE enemy_ident=".$enemy_ident;
	$result = mysqli_query($connection, $query) 
		or die('{"error":"Ошибка считывания данных: '.mysqli_error($connection).'"}');
	$enemy = $result->fetch_assoc();	

	$un_champion_name = '';
	while ($un_champion_name == '') {
		$query = "SELECT enemy_rand_name FROM ".$tb_enemy." ORDER BY RAND() LIMIT 1";
		$result = mysqli_query($connection, $query) 
			or die('{"error":"Ошибка считывания данных: '.mysqli_error($connection).'"}');
		$un_enemy = $result->fetch_assoc();
		$un_champion_name = trim($un_enemy['enemy_rand_name']);
	}

	$user['enemy_boss'] = 0;
	$user['enemy_champion'] = 0;

	$user['enemy_name'] = $enemy['enemy_name'];
	
	if (rand(1, 20) == 1)
		$user['enemy_champion'] = rand(1, 10);
	switch($user['enemy_champion']) {
		case 1: // Уникальный
			$user['enemy_name'] = $enemy['enemy_uniq_name'];
			$user['enemy_name'] .= ' '.$un_enemy['enemy_rand_name'].' (Уникальный)';
			break;
		case 2: // Здоровье I
			$user['enemy_name'] .= ' (Крупень)';
			break;
		case 3: // Здоровье II
			$user['enemy_name'] .= ' (Здоровяк)';
			break;
		case 4: // Здоровье III
			$user['enemy_name'] .= ' (Голиаф)';
			break;
		case 5: // Урон I
			$user['enemy_name'] .= ' (Убийца)';
			break;
		case 6: // Урон II
			$user['enemy_name'] .= ' (Громила)';
			break;
		case 7: // Урон III
			$user['enemy_name'] .= ' (Берсерк)';
			break;
		case 8: // Броня I
			$user['enemy_name'] .= ' (Твердолоб)';
			break;
		case 9: // Броня II
			$user['enemy_name'] .= ' (Титан)';
			break;
		case 10: // Броня III
			$user['enemy_name'] .= ' (Колосс)';
			break;
	}

	if ($enemy_ident >= 800) {
		$user['enemy_boss'] = 1;
		$user['enemy_champion'] = 1;
		$user['enemy_name'] = $enemy['enemy_name'];
		$user['enemy_name'] .= ' (Босс)';
	}

	$user['enemy_image'] = $enemy['enemy_image'];
	$user['enemy_level'] = $enemy['enemy_level'];
	// Life
	$user['enemy_life_max'] = (get_char_life($enemy['enemy_level']) - 5) + rand(1, 10);
	if ($user['enemy_champion'] == 2)
		$user['enemy_life_max'] = round($user['enemy_life_max'] * 1.3);
	if (($user['enemy_champion'] == 3) or ($user['enemy_champion'] == 1))
		$user['enemy_life_max'] = round($user['enemy_life_max'] * 1.4);
	if ($user['enemy_champion'] == 4)
		$user['enemy_life_max'] = round($user['enemy_life_max'] * 1.5);
	$user['enemy_life_cur'] = $user['enemy_life_max'];
	// Damage
	$user['enemy_damage_min'] = round($enemy['enemy_level'] * 0.5) - 1;
	$user['enemy_damage_max'] = round($enemy['enemy_level'] * 0.5) + 1;
	if ($user['enemy_champion'] == 1) {
		// Уникальный
		$user['enemy_damage_max'] = round($user['enemy_damage_max'] * (1 + (rand(1, 3) * 0.1)));
	}
	if ($user['enemy_champion'] == 5)
		$user['enemy_damage_max'] = round($user['enemy_damage_max'] * 1.1);
	if ($user['enemy_champion'] == 6)
		$user['enemy_damage_max'] = round($user['enemy_damage_max'] * 1.2);
	if ($user['enemy_champion'] == 7)
		$user['enemy_damage_max'] = round($user['enemy_damage_max'] * 1.3);	
	if ($user['enemy_damage_max'] < 2)
		$user['enemy_damage_max'] = 2;
	if ($user['enemy_damage_min'] < 1)
		$user['enemy_damage_min'] = 1;
	// Armour
	$user['enemy_armor'] = round($enemy['enemy_level'] * 0.5);
	if ($user['enemy_champion'] == 1) {
		// Уникальный
		$user['enemy_armor'] = round($user['enemy_armor'] * (1 + (rand(1, 3) * 0.1)));
	}
	if ($user['enemy_champion'] == 8)
		$user['enemy_armor'] = round($user['enemy_armor'] * 1.1);
	if ($user['enemy_champion'] == 9)
		$user['enemy_armor'] = round($user['enemy_armor'] * 1.2);
	if ($user['enemy_champion'] == 10)
		$user['enemy_armor'] = round($user['enemy_armor'] * 1.3);
	// Experience
	$user['enemy_exp'] = round($enemy['enemy_level'] * 3) + rand(round($enemy['enemy_level'] * 0.1), round($enemy['enemy_level'] * 0.3));
	if ($user['enemy_champion'] == 1)
		$user['enemy_exp'] = round($user['enemy_exp'] * 1.7);
	if ($user['enemy_champion'] >= 2)
		$user['enemy_exp'] = round($user['enemy_exp'] * 1.3);
	//  Gold
	$user['enemy_gold'] = round($enemy['enemy_level'] * 2.5) + rand(1, 20);
	if ($user['enemy_champion'] == 1)
		$user['enemy_gold'] += $enemy['enemy_level'] * 12;
	if ($user['enemy_champion'] >= 2)
		$user['enemy_gold'] += $enemy['enemy_level'] * 7;
	$user['current_random_place'] = 0;
	update_user_table("enemy_ident=".$enemy_ident.",enemy_name='".$user['enemy_name']."',enemy_image='".$user['enemy_image']."',enemy_level=".$user['enemy_level'].",enemy_boss=".$user['enemy_boss'].",enemy_champion=".$user['enemy_champion'].",enemy_life_max=".$user['enemy_life_max'].",enemy_life_cur=".$user['enemy_life_cur'].",enemy_damage_min=".$user['enemy_damage_min'].",enemy_damage_max=".$user['enemy_damage_max'].",enemy_armor=".$user['enemy_armor'].",enemy_exp=".$user['enemy_exp'].",enemy_gold=".$user['enemy_gold'].",loot_slot_1=0,loot_slot_1_name='',current_random_place=".$user['current_random_place']);

}

function add_enemy($enemy_slot, $enemy_ident) {
	global $user, $tb_enemy, $connection;

	$query = "SELECT * FROM ".$tb_enemy." WHERE enemy_ident=".$enemy_ident;
	$result = mysqli_query($connection, $query) 
		or die('{"error":"Ошибка считывания данных: '.mysqli_error($connection).'"}');
	$enemy = $result->fetch_assoc();

	$user['enemy_slot_'.strval($enemy_slot)] = $enemy_ident;
	$user['enemy_slot_'.strval($enemy_slot).'_image'] = $enemy['enemy_image'];
	$user['enemy_slot_'.strval($enemy_slot).'_level'] = $enemy['enemy_level'];
	update_user_table("current_outlands='".$user['current_outlands']."',enemy_slot_".strval($enemy_slot)."=".$user['enemy_slot_'.strval($enemy_slot)].",enemy_slot_".strval($enemy_slot)."_image='".$user['enemy_slot_'.strval($enemy_slot).'_image']."',enemy_slot_".strval($enemy_slot)."_level=".$user['enemy_slot_'.strval($enemy_slot).'_level']);
}

function get_user($username, $userpass) {
	global $tb_user, $connection;

	$query = 'SELECT * FROM '.$tb_user." WHERE user_name='".$username."' AND user_pass='".$userpass."'";
	$result = mysqli_query($connection, $query) 
		or die('{"error":"Ошибка считывания данных: '.mysqli_error($connection).'"}');

	return $result->fetch_assoc();
}

function gen_user_session() {
	global $user;
	$user['user_session'] = time();
	update_user_table("user_session='".$user['user_session']."'");
	return $user['user_session'];
}

function equip_item($item_ident) {
	global $user, $tb_item, $connection;
	$query = "SELECT * FROM ".$tb_item." WHERE item_ident=".$item_ident;
	$result = mysqli_query($connection, $query) 
		or die('{"error":"Ошибка считывания данных: '.mysqli_error($connection).'"}');
	$item = $result->fetch_assoc();

	if ($user['char_gold'] < $item['item_price']) die('{"info":"Нужно больше золота!"}');
	if ($user['char_level'] < $item['item_level']) die('{"info":"Нужен уровень выше!"}');

	switch($item['item_type']) {
		case 0:
			save_to_log($user['char_equip_armor_name'].' - предмет перемещен в инвентарь.');
			add_item($user['char_equip_armor_ident']);
			save_to_log($item['item_name'].' - предмет куплен и надет.');
			$user['char_equip_armor_name'] = $item['item_name'];
			$user['char_equip_armor_ident'] = $item['item_ident'];
			$user['char_gold'] = $user['char_gold'] - $item['item_price'];
			$user['char_armor'] = $item['item_armor'];
			update_user_table("char_equip_armor_name='".$user['char_equip_armor_name']."',char_equip_armor_ident=".$user['char_equip_armor_ident'].",char_armor=".$user['char_armor'].",char_gold=".$user['char_gold']);
			add_event(2, $user['char_name'], 1, $user['char_gender'], $item['item_name']);
			break;
		case 1:
			save_to_log($user['char_equip_weapon_name'].' - предмет перемещен в инвентарь.');
			add_item($user['char_equip_weapon_ident']);
			save_to_log($item['item_name'].' - предмет куплен и надет.');
			$user['char_equip_weapon_name'] = $item['item_name'];
			$user['char_equip_weapon_ident'] = $item['item_ident'];
			$user['char_gold'] = $user['char_gold'] - $item['item_price'];
			$user['char_damage_min'] = $item['item_damage_min'];
			$user['char_damage_max'] = $item['item_damage_max'];
			update_user_table("char_equip_weapon_name='".$user['char_equip_weapon_name']."',char_equip_weapon_ident=".$user['char_equip_weapon_ident'].",char_damage_min=".$user['char_damage_min'].",char_damage_max=".$user['char_damage_max'].",char_gold=".$user['char_gold']);
			add_event(2, $user['char_name'], 1, $user['char_gender'], $item['item_name']);
			break;
		case 8:
		case 9:
		case 10:
		case 11:
		case 12:
		case 13:
		case 25:
		case 26:
		case 28:
		case 30:
			$user['char_gold'] = $user['char_gold'] - $item['item_price'];
			save_to_log($item['item_name'].' - предмет куплен и перемещен в инвентарь.');
			add_item($item['item_ident']);
			update_user_table("char_gold=".$user['char_gold']);
			break;
	}
}

function pickup_equip_item() {
	global $user, $tb_item, $connection;
	$query = "SELECT * FROM ".$tb_item." WHERE item_ident=".$user['loot_slot_1'];
	$result = mysqli_query($connection, $query) 
		or die('{"error":"Ошибка считывания данных: '.mysqli_error($connection).'"}');
	$item = $result->fetch_assoc();

	if ($user['char_level'] < $item['item_level']) die('{"info":"Нужен уровень выше!"}');

	$r = '';
	switch($item['item_type']) {
		case 0:
			if ($item['item_ident'] > $user['char_equip_armor_ident']) {
				save_to_log($user['char_equip_armor_name'].' - предмет перемещен в инвентарь.');
				add_item($user['char_equip_armor_ident']);
				$r .= 'Вы снимаете свой старый '.$user['char_equip_armor_name'];
				$user['char_equip_armor_name'] = $item['item_name'];
				$user['char_equip_armor_ident'] = $item['item_ident'];
				$user['char_armor'] = $item['item_armor'];
				update_user_table("char_equip_armor_name='".$user['char_equip_armor_name']."',char_equip_armor_ident=".$user['char_equip_armor_ident'].",char_armor=".$user['char_armor'].",loot_slot_1=0,loot_slot_1=''");
				$r .= ' и надеваете новый '.$user['char_equip_armor_name'].'.';
				save_to_log($user['char_equip_armor_name'].' - предмет надет.');
				add_event(2, $user['char_name'], 1, $user['char_gender'], $item['item_name']);
			} else {
				save_to_log($item['item_name'].' - предмет перемещен в инвентарь.');
				$r = 'Вы забираете '.$item['item_name'].' себе.';
				add_item($item['item_ident']);
			}
			break;
		case 1:
			if ($item['item_ident'] > $user['char_equip_weapon_ident']) {
				save_to_log($user['char_equip_weapon_name'].' - предмет перемещен в инвентарь.');
				add_item($user['char_equip_weapon_ident']);
				$r .= 'Вы бросаете свой старый '.$user['char_equip_weapon_name'];
				$user['char_equip_weapon_name'] = $item['item_name'];
				$user['char_equip_weapon_ident'] = $item['item_ident'];
				$user['char_damage_min'] = $item['item_damage_min'];
				$user['char_damage_max'] = $item['item_damage_max'];
				update_user_table("char_equip_weapon_name='".$user['char_equip_weapon_name']."',char_equip_weapon_ident=".$user['char_equip_weapon_ident'].",char_damage_min=".$user['char_damage_min'].",char_damage_max=".$user['char_damage_max'].",loot_slot_1=0,loot_slot_1=''");
				$r .= ' и берете в руки новый '.$user['char_equip_weapon_name'].'.';
				save_to_log($user['char_equip_weapon_name'].' - предмет надет.');
				add_event(2, $user['char_name'], 1, $user['char_gender'], $item['item_name']);
			} else {
				save_to_log($item['item_name'].' - предмет перемещен в инвентарь.');
				$r = 'Вы забираете '.$item['item_name'].' себе.';
				add_item($item['item_ident']);
			}
			break;
		case 8:
		case 9:
		case 10:
		case 11:
		case 12:
		case 13:
		case 21:
		case 25:
		case 26:
		case 28:
		case 30:
			$r = 'Вы забираете '.$item['item_name'].' себе.';
			save_to_log($item['item_name'].' - предмет перемещен в инвентарь.');
			add_item($item['item_ident']);
			break;
	}
	return $r;
}

function item_values($item_ident) {
	global $user, $tb_item, $connection;
	$query = "SELECT * FROM ".$tb_item." WHERE item_ident=".$item_ident;
	$result = mysqli_query($connection, $query) 
		or die('{"error":"Ошибка считывания данных: '.mysqli_error($connection).'"}');
	$item = $result->fetch_assoc();
	switch($item['item_type']) {
		case 0:
			return $item['item_name'].','.$item['item_armor'].','.$item['item_level'].','.$item['item_price'];
			break;
		case 1:
			return $item['item_name'].','.$item['item_damage_min'].'-'.$item['item_damage_max'].','.$item['item_level'].','.$item['item_price'];
			break;
		case 8:	
			return $item['item_name'].','.strval($item['item_level']*25).','.get_region_item_level($item['item_level']).','.$item['item_price'];
			break;
		case 9:	
			return $item['item_name'].','.strval($item['item_level']*10).','.get_region_item_level($item['item_level']).','.$item['item_price'];
			break;
		case 10:
			return $item['item_name'].','.strval($item['item_level']*20).','.get_region_item_level($item['item_level']).','.$item['item_price'];
			break;
		case 11:
			return $item['item_name'].','.strval($item['item_level']*15).','.get_region_item_level($item['item_level']).','.$item['item_price'];
			break;
		case 12:
			return $item['item_name'].','.strval($item['item_level']*25).','.get_region_item_level($item['item_level']).','.$item['item_price'];
			break;
		case 13:
			return $item['item_name'].','.strval($item['item_level']*25).','.get_region_item_level($item['item_level']).','.$item['item_price'];
			break;
		case 25:
		case 26:
		case 28:
		case 30:
			return $item['item_name'].','.strval($item['item_level']).','.get_region_item_level($item['item_level']).','.$item['item_price'];
			break;
	}
}

function add_item_to_shop($item_slot, $item_ident) {
	global $user, $tb_item, $connection;
	$user['item_slot_'.strval($item_slot)] = $item_ident;
	$user['item_slot_'.strval($item_slot).'_values'] = item_values($item_ident);
	update_user_table('item_slot_'.strval($item_slot).'='.$user['item_slot_'.strval($item_slot)]);
}

function get_slot_item_ident($item_slot) {
	global $user;
	return $user['item_slot_'.strval($item_slot)]; 
}

function get_region_town_name($region_ident) {
	global $user, $tb_regions, $connection;
	$query = "SELECT * FROM ".$tb_regions." WHERE region_ident=".$region_ident;
	$result = mysqli_query($connection, $query) 
		or die('{"error":"Ошибка считывания данных: '.mysqli_error($connection).'"}');
	$region = $result->fetch_assoc();
	return $region['region_town_name'];
}

function change_region($region_ident, $food, $gold) {
	global $user, $tb_regions, $connection;
	$query = "SELECT * FROM ".$tb_regions." WHERE region_ident=".$region_ident;
	$result = mysqli_query($connection, $query) 
		or die('{"error":"Ошибка считывания данных: '.mysqli_error($connection).'"}');
	$region = $result->fetch_assoc();
	$user['char_life_cur'] = $user['char_life_max'];
	$user['char_mana_cur'] = $user['char_mana_max'];
	$user['char_region'] = $region['region_ident'];
	$user['char_region_level'] = $region['region_level'];
	$user['char_region_town_name'] = $region['region_town_name'];
	$user['char_gold'] -= $gold;
	$user['char_food'] -= $food;
	update_user_table("char_life_cur=".$user['char_life_cur'].",char_mana_cur=".$user['char_mana_cur'].",char_gold=".$user['char_gold'].",char_food=".$user['char_food'].",char_region=".$user['char_region'].",char_region_level=".$user['char_region_level'].",char_region_town_name='".$user['char_region_town_name']."'");
}

function check_user($user_name) {
	global $connection, $tb_user;
	$query = "SELECT user_name FROM ".$tb_user." WHERE user_name='".$user_name."'";
	$user = mysqli_query($connection, $query) 
	  or die('{"error":"Ошибка сохранения данных: '.mysqli_error($connection).'"}');
	if(mysqli_num_rows($user) > 0) {
		return true;
	} else {
		return false;
	}
}

function check_char($char_name) {
	global $user;
	if (strtolower($user['char_name']) == strtolower($char_name)) {
		return true;
	} else {
		return false;
	}
}

function update_user_table($s) {
	global $connection, $user, $tb_user;
	$query = "UPDATE ".$tb_user." SET ".$s." WHERE user_name='".$user['user_name']."'";
	if (!mysqli_query($connection, $query)) {
		die('{"error":"Ошибка сохранения данных: '.mysqli_error($connection).'"}');
	}
}

function get_char_level_exp($level) {
	return $level * (($level - 1) + 100);
}

function get_version() {
	return get_file_int(PATH.'version.txt');
}

function gettime() {
	return date('d.m.Y H:i'); 
}

function get_file_int($fn) {
	$r = '';
	if(file_exists($fn)) {
		$array = file($fn);
		$r = join("", $array);
	}
	return $r;
}

function get_param($value, $default) {
	$res = $default;
	if(IsSet($_GET[$value])) {
		$res = $_GET[$value];
	}
	return $res;
}

function post_param($value, $default) {
	$res = $default;
	if(IsSet($_POST[$value])) {
		$res = $_POST[$value];
	}
	return $res;
}

function add_event($type, $name, $level = 1, $gender = 0, $str = '', $loc_name = '') {
	global $connection, $user, $tb_events;
	$query = "INSERT INTO ".$tb_events." (event_type,event_char_gender,event_char_name,event_char_level,event_str,event_loc) VALUES(".$type.", ".$gender.", '".$name."', ".$level.", '".$str."', '".$loc_name."')";
	if (!mysqli_query($connection, $query)) {
		die('{"error":"Ошибка сохранения данных: '.mysqli_error($connection).'"}');
	}
}

function get_loot_level() {
	global $user;
	$r = $user['enemy_level'];
	if ($r > $user['char_level'])
		$r = $user['char_level'];
	return $r;
}

function get_events() {
	global $connection, $tb_events;
	$query = "SELECT event_type, event_char_gender, event_char_name, event_char_level ,event_str, event_loc FROM ".$tb_events." ORDER BY id  DESC LIMIT 0, 15";
	$result = mysqli_query($connection, $query) 
		or die('{"error":"Ошибка считывания данных: '.mysqli_error($connection).'"}');
	$events = $result->fetch_all(MYSQLI_ASSOC);
	return json_encode($events, JSON_UNESCAPED_UNICODE);
}

function get_messages() {
	global $tb_chat, $connection;

	$query = "SELECT message_author, message_text FROM ".$tb_chat;
	$result = mysqli_query($connection, $query) 
		or die('{"error":"Ошибка считывания данных: '.mysqli_error($connection).'"}');
	$messages = $result->fetch_all(MYSQLI_ASSOC);

	return json_encode($messages, JSON_UNESCAPED_UNICODE);
}

function save_loot_slot($item_ident, $item_name, $item_type, $item_slot = 1) {
	global $user;
	
	$user['loot_slot_'.strval($item_slot)] = $item_ident;
	$user['loot_slot_'.strval($item_slot).'_name'] = $item_name;
	$user['loot_slot_'.strval($item_slot).'_type'] = $item_type;

	if ($user['loot_slot_'.strval($item_slot)] > 0)
		update_user_table("loot_slot_".strval($item_slot)."=".$user['loot_slot_'.strval($item_slot)].",loot_slot_".strval($item_slot)."_type=".$user['loot_slot_'.strval($item_slot).'_type'].",loot_slot_".strval($item_slot)."_name='".$user['loot_slot_'.strval($item_slot).'_name']."'");
}

function gen_random_loot($loot_type_array, $loot_level) {
	global $user, $tb_item, $connection;

	$loot_type = $loot_type_array[array_rand($loot_type_array)];	
	
	$query = "SELECT item_ident,item_name,item_level FROM ".$tb_item." WHERE item_level=".$loot_level." AND item_type=".$loot_type." ORDER BY RAND() LIMIT 1";
	$result = mysqli_query($connection, $query) 
		or die('{"error":"Ошибка считывания данных: '.mysqli_error($connection).'"}');
	$item = $result->fetch_assoc();

	save_loot_slot($item['item_ident'],	$item['item_name'],	$loot_type);
}

function gen_equip_loot() {
	$loot_level = get_loot_level();
	if ($loot_level % 2 != 0)
		gen_random_loot([0], $loot_level);
	else
		gen_random_loot([1], $loot_level);
}

function gen_else_loot() {
	gen_random_loot([8,9,10,11,25,26,28,30], 1);
}

function gen_alch_loot() {
	gen_random_loot([8,9,10,11,28], 1);
}

function gen_mage_loot() {
	gen_random_loot([9,25,26], 1);
}

function gen_herb_loot() {
	gen_random_loot([30], 1);
}

function gen_trophy_loot() {
	global $user, $tb_item, $tb_enemy, $connection;

	$query = "SELECT enemy_trophy FROM ".$tb_enemy." WHERE enemy_ident=".$user['enemy_ident'];
	$result = mysqli_query($connection, $query) 
		or die('{"error":"Ошибка считывания данных: '.mysqli_error($connection).'"}');
	$enemy = $result->fetch_assoc();

	$trophy_ident = $enemy['enemy_trophy'];	
	if ($trophy_ident > 0) {
		$query = "SELECT item_name FROM ".$tb_item." WHERE item_ident=".$trophy_ident;
		$result = mysqli_query($connection, $query) 
			or die('{"error":"Ошибка считывания данных: '.mysqli_error($connection).'"}');
		$item = $result->fetch_assoc();

		save_loot_slot($trophy_ident, $item['item_name'], 21);
	}
}

function gen_loot() {
	global $user, $tb_item, $tb_enemy, $connection;
	
	// Обычные враги
	if (($user['enemy_boss'] == 0) && ($user['enemy_champion'] == 0)) {
		// Трофеи 25%
		if (rand(1, 4) == 1) {
			gen_trophy_loot();
		} else 
		// Обычный лут: зелья, свитки, травы 10%
		if (rand(1, 10) == 1) {
			gen_else_loot();
		} else
		// Экипировка 1%
		if (rand(1, 100) == 1) {
			gen_equip_loot();
		}
	// Чемпионы 
	} elseif (($user['enemy_champion'] > 1) && ($user['enemy_boss'] == 0)) {
		// Экипировка 5%
		if (rand(1, 20) == 1) {
			gen_equip_loot();
		} else {
			gen_else_loot();
		}
	// Уникальные
	} elseif (($user['enemy_champion'] == 1) && ($user['enemy_boss'] == 0)) {
		// Экипировка
		gen_equip_loot();		
	// Босс
	} elseif ($user['enemy_boss'] > 0) {
		// Экипировка
		gen_equip_loot();
	}
}

function has_item($id) {
	global $user;
	$inventory = $user['char_inventory'];
	$pos = strripos($inventory, '"id":"'.$id.'"');
	if ($pos === false) {
		return false;
	} else {
		return true;
	}
}

function item_count($id) {
	global $user;
	$result = 0;
	$items = json_decode($user['char_inventory'], true);
	for($i = 0; $i < count($items); $i++) {
		$item = $items[$i];
		$item_id = $item['id'];
		if ($item_id == $id) {
			$result = $item['count'];
			break;
		}
	}
	return $result;
}

function item_modify($id, $value) {
	global $user;
	$items = json_decode($user['char_inventory'], true);
	for($i = 0; $i < count($items); $i++) {
		$item = $items[$i];
		$item_id = $item['id'];
		if ($item_id == $id) {
			$count = $item['count'];
			$count += $value;
			if ($count <= 0) {
				unset($items[$i]);
			} else {
				$items[$i]['count'] = $count;
			}
			$items = array_values($items);
			$user['char_inventory'] = json_encode($items, JSON_UNESCAPED_UNICODE);
			update_user_table("char_inventory='".$user['char_inventory']."'");
			break;
		}
	}
}

function add_item($id, $count = 1) {
	global $user;
	if (has_item($id)) {
		item_modify($id, $count);
	} else {
		$items = json_decode($user['char_inventory'], true);
		$n = count($items);
		$items[$n]['id'] = $id;
		$items[$n]['count'] = $count;
		$user['char_inventory'] = json_encode($items, JSON_UNESCAPED_UNICODE);
		update_user_table("char_inventory='".$user['char_inventory']."'");
	}
}

function get_region_item_level($item_level) {
	$result = 1;
	if ($item_level > 1)
		$result = ($item_level - 1) * 12;
	return $result;
}

function item_info($item_ident) {
	global $user, $tb_item, $connection;
	if ($user['char_life_cur'] <= 0) die('{"error":"Вам сначала нужно вернуться к жизни!"}');

	$query = "SELECT * FROM ".$tb_item." WHERE item_ident=".$item_ident;
	$result = mysqli_query($connection, $query) 
		or die('{"error":"Ошибка считывания данных: '.mysqli_error($connection).'"}');
	$item = $result->fetch_assoc();

	$ef = '';
	$eq = '';
	switch($item['item_type']) {
		case 0:
			$ef = 'Броня: '.$item['item_armor'];
			$eq = 'Кожаный Доспех.';
			break;
		case 1:
			$ef = 'Урон: '.$item['item_damage_min'].'-'.$item['item_damage_max'];
			$eq = 'Одноручный Меч.';
			break;
		case 8:
			$ef = 'Полностью исцеляет от ран.';
			$eq = 'Целительный Эликсир.';
			break;
		case 9:
			$ef = 'Восполняет всю ману.';
			$eq = 'Магический Эликсир.';
			break;
		case 10:
			$ef = 'Исцеляет и увеличивает запас здоровья на 20%.';
			$eq = 'Магический Эликсир.';
			break;
		case 11:
			$ef = 'Восполнение здоровья и маны.';
			$eq = 'Магический Эликсир.';
			break;
		case 12:
			$ef = 'Излечение от отравления и защита от ядов в течении '.strval($item['item_level']*3).' битв.';
			$eq = 'Противоядие.';
			break;
		case 13:
			$ef = 'Покрывает оружие ядом на '.strval($item['item_level']*5).' битв.';
			$eq = 'Яд.';
			break;
		case 21:
			$ef = 'Часть тела монстра.';
			$eq = 'Трофей.';
			break;
		case 25:
			$ef = 'Открывает портал в город.';
			$eq = 'Магический свиток.';
			break;
		case 26:
			$ef = 'Полностью исцеляет от ран.';
			$eq = 'Свиток Исцеления.';
			break;
		case 28:
			$ef = 'Необходим для создания эликсиров.';
			$eq = '';
			break;
		case 30:
			$ef = 'Алхимический ингредиент для зелий.';
			$eq = 'Ингредиент.';
			break;
	}
	if ($ef == '')
		die('{"item":""}');
	else 
		if ($eq != '')
			die('{"item":"'.$item['item_name'].'\n'.$eq.' Уровень предмета: '.$item['item_level'].'\n'.$ef.'"}');
		else
			die('{"item":"'.$item['item_name'].'\nУровень предмета: '.get_region_item_level($item['item_level']).'\n'.$ef.'"}');
}

function use_item($item_ident) {
	global $user, $tb_item, $connection;
	if ($user['char_life_cur'] <= 0) die('{"error":"Вам сначала нужно вернуться к жизни!"}');

	$query = "SELECT * FROM ".$tb_item." WHERE item_ident=".$item_ident;
	$result = mysqli_query($connection, $query) 
		or die('{"error":"Ошибка считывания данных: '.mysqli_error($connection).'"}');
	$item = $result->fetch_assoc();

	$result = '';

	if ($user['char_level'] < get_region_item_level($item['item_level'])) die('{"info":"Нужен уровень выше!"}');

	switch($item['item_type']) {
		case 8:
			item_modify($item_ident, -1);
			$item_level = $item['item_level'];
			$user['char_life_cur'] = $user['char_life_max'];
			update_user_table("char_life_cur=".$user['char_life_cur']);
			$result = ',"char_life_cur":"'.$user['char_life_cur'].'","char_life_max":"'.$user['char_life_max'].'"';
			break;
		case 9:
			item_modify($item_ident, -1);
			$item_level = $item['item_level'];
			$user['char_mana_cur'] = $user['char_mana_max'];
			update_user_table("char_mana_cur=".$user['char_mana_cur']);
			$result = ',"char_mana_cur":"'.$user['char_mana_cur'].'","char_mana_max":"'.$user['char_mana_max'].'"';
			break;
		case 10:
			item_modify($item_ident, -1);
			$item_level = $item['item_level'];
			$user['char_life_cur'] = $user['char_life_max'] + round($user['char_life_max'] / 5);
			update_user_table("char_life_cur=".$user['char_life_cur']);
			$result = ',"char_life_cur":"'.$user['char_life_cur'].'","char_life_max":"'.$user['char_life_max'].'"';
			break;
		case 11:
			item_modify($item_ident, -1);
			$item_level = $item['item_level'];
			$user['char_life_cur'] = $user['char_life_max'];
			$user['char_mana_cur'] = $user['char_mana_max'];
			update_user_table("char_life_cur=".$user['char_life_cur'].",char_mana_cur=".$user['char_mana_cur']);
			$result = ',"char_life_cur":"'.$user['char_life_cur'].'","char_life_max":"'.$user['char_life_max'].'","char_mana_cur":"'.$user['char_mana_cur'].'","char_mana_max":"'.$user['char_mana_max'].'"';
			break;
		case 25:
			if ($user['char_mana_cur'] >= MANA_SCROLL_TP) {
				item_modify($item_ident, -1);
				$user['char_mana_cur'] -= MANA_SCROLL_TP;
				update_user_table("char_mana_cur=".$user['char_mana_cur']);
				$result = ',"action":"Перед вами открывается магический портал!|Войти!|index.php?action=magictower","char_mana_cur":"'.$user['char_mana_cur'].'","char_mana_max":"'.$user['char_mana_max'].'"';
			} else need_mana(MANA_SCROLL_TP);
			break;
		case 26:
			if ($user['char_mana_cur'] >= MANA_SCROLL_HEAL) {
				item_modify($item_ident, -1);
				$user['char_mana_cur'] -= MANA_SCROLL_HEAL;
				$user['char_life_cur'] = $user['char_life_max'];
				update_user_table("char_life_cur=".$user['char_life_cur'].",char_mana_cur=".$user['char_mana_cur']);
				$result = ',"char_life_cur":"'.$user['char_life_cur'].'","char_life_max":"'.$user['char_life_max'].'","char_mana_cur":"'.$user['char_mana_cur'].'","char_mana_max":"'.$user['char_mana_max'].'"';
			} else need_mana(MANA_SCROLL_HEAL);
			break;
	}
	return $result;
}

function item_ident_by_index($item_index) {
	global $user;
	$result = 0;
	$items = json_decode($user['char_inventory'], true);
	for($i = 0; $i < count($items); $i++) {
		$item = $items[$i];
		$item_id = $item['id'];
		if ($i == ($item_index - 1)) {
			$result = $item_id;
			break;
		}
	}
	return $result;
}

function add_enemies($enemy_idents, $is_boss = false) {
	global $user;
	
	for($i = 1; $i <= 3; $i++) {
		$r = $enemy_idents[array_rand($enemy_idents)];
		if ($is_boss == true) {
			if ($i == 1)
				$r = $enemy_idents[array_rand($enemy_idents)];
			else
				$r = 999;
			if (is_killed_boss($user['char_region']))
				$r = 999;
		}
		add_enemy($i, $r);
	}
}

function get_enemies() {
	global $tb_enemy, $connection;

	$query = "SELECT enemy_image FROM ".$tb_enemy;
	$result = mysqli_query($connection, $query) 
		or die('{"error":"Ошибка считывания данных: '.mysqli_error($connection).'"}');
	$enemies = $result->fetch_all(MYSQLI_ASSOC);

	return json_encode($enemies, JSON_UNESCAPED_UNICODE);
}

function get_items() {
	global $tb_item, $connection;

	$query = "SELECT * FROM ".$tb_item;
	$result = mysqli_query($connection, $query) 
		or die('{"error":"Ошибка считывания данных: '.mysqli_error($connection).'"}');
	$items = $result->fetch_all(MYSQLI_ASSOC);

	return json_encode($items, JSON_UNESCAPED_UNICODE);
}

function addlink($t, $j, $n = 0) {
	global $user;
	$user['links'][$n]['title'] = $t;
	$user['links'][$n]['link'] = $j;	
}

function rest_in_tavern_cost() {
	global $user;
	return round($user['char_region_level'] * 10) + round(($user['char_region_level'] * 10) / 2);
}

function food_in_tavern_cost() {
	global $user;
	return $user['char_region_level'] * 10;
}

function get_char_life($level) {
	return ($level * 5) + 25;
}

function inv_item_price($type, $price, $count) {
	global $user;
	$r = 0;
	switch($type) {
		case 0:
		case 1:
			$r = $count * round($price * 0.35);
			break;
		case 21:
			$r = $count * round($price * $user['char_region'] * 0.35);
			break;
		case 30:
			$r = $count * round($price * 0.85);
			break;
	}
	return $r;
}

function inv_item_list($type) {
	global $tb_item, $connection;

	$query = "SELECT * FROM ".$tb_item." WHERE item_type=".$type;
	$result = mysqli_query($connection, $query) 
		or die('{"error":"Ошибка считывания данных: '.mysqli_error($connection).'"}');
	$items = mysqli_fetch_all($result, MYSQLI_ASSOC);

	$r = '';
	$t = '';
	$gold = 0;
	foreach ($items as $item) {
		$id = $item['item_ident'];
		if (has_item($id)) {
			$count = item_count($id);
			$price = inv_item_price($type, $item['item_price'], $count);
			$t .= $item['item_name'].' '.$count.'x - '.$price.' зол.#';
			$gold += $price;
		}
	}

	if ($t != '') {
		switch($type) {
			case 0:
				$r .= 'Ваши брони:';
				break;
			case 1:
				$r .= 'Ваше оружие:';
				break;
			case 21:
				$r .= 'Ваши трофеи:';
				break;
			case 30:
				$r .= 'Ваши ингредиенты:';
				break;
		}
		$r .= '#============#'.$t.'============#Всего: '.$gold.' зол.';
	}

	return $r;
}

function inv_item_trade($type) {
	global $user, $tb_item, $connection;

	$query = "SELECT * FROM ".$tb_item." WHERE item_type=".$type;
	$result = mysqli_query($connection, $query) 
		or die('{"error":"Ошибка считывания данных: '.mysqli_error($connection).'"}');
	$items = mysqli_fetch_all($result, MYSQLI_ASSOC);

	$gold = 0;
	foreach ($items as $item) {
		$id = $item['item_ident'];
		if (has_item($id)) {
			$count = item_count($id);
			if ($count > 0) {
				$price = inv_item_price($type, $item['item_price'], $count);
				$user['char_gold'] += $price;
				$gold += $price;
				item_modify($id, -$count);
				save_to_log($item['item_name'].' (x'.$count.') - предмет(ы) продан(ы).');
			}
		}
	}

	update_user_table("char_gold=".$user['char_gold']);

	return $gold;
}

function save_to_log($msg) {
	global $connection, $user, $tb_log;
	$query = "INSERT INTO ".$tb_log." (log_char_name,log_message) VALUES('".$user['char_name']."', '".$msg."')";
	if (!mysqli_query($connection, $query)) {
		die('{"error":"Ошибка сохранения данных: '.mysqli_error($connection).'"}');
	}
}

function pickup_loot_title() {
	global $user;
	
	$m = '';
	switch($user['loot_slot_1_type']) {
		case 1:
			$m = 'Взять оружие!';
			break;
		case 8: case 9: case 10: case 11: case 12: case 13:
			$m = 'Взять эликсир!';
			break;
		case 21:
			$m = 'Взять трофей!';
			break;
		case 25: case 26:
			$m = 'Взять свиток!';
			break;
		case 28:
			$m = 'Взять флакон!';
			break;
		case 30:
			$m = 'Взять ингридиент!';
			break;
		default:
			$m = 'Взять броню!';
	}

	return $m;
}

function travel_price($level) {
	return $level * 10;
}

function gen_random_place() {
	global $user, $connection;
	
	$user['current_random_place'] = 0;
	if (rand(0, 2) == 0)
		$user['current_random_place'] = rand(1, RAND_PLACE_COUNT);
	
	update_user_table("current_random_place=".$user['current_random_place']);
}

function buy_empty_elix($count = 1) {
	global $user;
	$r = 'Старик улыбается и приближается к вам, на ходу открывая сумку на поясе:#-Да, конечно. У меня всегда есть Пустые Флаконы для твоих экспериментов. Цена одного - 100 золотых монет.';
	if ($user['char_gold'] < 100) die('{"info":"Нужно не менее 100 золотых монет!"}');
	add_item(EMPTY_ELIX, $count);
	$user['char_gold'] -= 100;
	update_user_table("char_gold=".$user['char_gold']);
	return $r;
}

function make_elix($elix_id, $t, $ing1_name, $ing1_id, $ing1_amount, $ing2_name, $ing2_id, $ing2_amount) {
	if (has_item(EMPTY_ELIX)) {
		if (has_item($ing1_id)) {
			$amount = item_count($ing1_id);
			if ($amount >= $ing1_amount) {
				if (has_item($ing2_id)) {
					$amount = item_count($ing2_id);
					if ($amount >= $ing2_amount) {
						item_modify($ing1_id, -$ing1_amount);
						item_modify($ing2_id, -$ing2_amount);
						item_modify(EMPTY_ELIX, -1);
						add_item($elix_id);
						return $t;
					} die('{"info":"Нужно больше количество компонента - '.$ing2_name.'!"}');
				} die('{"info":"Нужен компонент - '.$ing2_name.'!"}');
			} die('{"info":"Нужно больше количество компонента - '.$ing1_name.'!"}');
		} die('{"info":"Нужен компонент - '.$ing1_name.'!"}');
	} else die('{"info":"Нужен Пустой Флакон!"}');
}

function kill_boss($region_ident) {
	global $user;
	$user['stat_boss_kills']++;
	$bosses = json_decode($user['char_bosses'], true);
	$n = count($bosses);
	$bosses[$n]['id'] = $region_ident;
	$bosses[$n]['killed'] = 1;
	$user['char_bosses'] = json_encode($bosses, JSON_UNESCAPED_UNICODE);
	update_user_table("char_bosses='".$user['char_bosses']."'");
}

function is_killed_boss($region_ident) {
	global $user;
	$bosses = $user['char_bosses'];
	$pos = strripos($bosses, '"id":"'.$region_ident.'"');
	if ($pos === false) {
		return false;
	} else {
		return true;
	}
}

function need_mana($mana) {
	die('{"info":"Вы пытаетесь прочитать свиток, но чувствуете, что магических сил недостаточно. Нужно '.strval($mana).' маны!"}');
}

?>