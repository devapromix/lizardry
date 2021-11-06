<?php
define('DS', DIRECTORY_SEPARATOR);
define('PATH', dirname(__FILE__).DS.'..'.DS);

$username = $_GET['username'];
$userpass = $_GET['userpass'];

if ($username == '') die('21');
if ($userpass == '') die('22');

if (strlen($username) < 4) die('31');
if (strlen($userpass) < 4) die('32');

if (strlen($username) > 24) die('41');
if (strlen($userpass) > 24) die('42');
	
function gen_enemy($enemy_ident) {
	global $user, $tb_enemy, $connection;
	$query = "SELECT * FROM ".$tb_enemy." WHERE enemy_ident=".$enemy_ident;
	$result = mysqli_query($connection, $query) 
		or die('{"error":"Ошибка считывания данных: '.mysqli_error($connection).'"}');
	$enemy = $result->fetch_assoc();	

	$user['enemy_name'] = $enemy['enemy_name'];
	$user['enemy_image'] = $enemy['enemy_image'];
	$user['enemy_level'] = $enemy['enemy_level'];
	$user['enemy_life_max'] = rand($enemy['enemy_life_min'], $enemy['enemy_life_max']);
	$user['enemy_life_cur'] = $user['enemy_life_max'];
	$user['enemy_damage_min'] = round($enemy['enemy_level'] / 2) + 1;//$enemy['enemy_damage_min'];
	$user['enemy_damage_max'] = round($enemy['enemy_level'] / 2) + 3;//$enemy['enemy_damage_max'];
	$user['enemy_armor'] = round($enemy['enemy_level'] / 2.7);//$enemy['enemy_armor'];
	$user['enemy_exp'] = $enemy['enemy_exp'];
	$user['enemy_gold'] = rand($enemy['enemy_gold_min'], $enemy['enemy_gold_max']);

	update_user_table("enemy_name='".$user['enemy_name']."',enemy_image='".$user['enemy_image']."',enemy_level=".$user['enemy_level'].",enemy_life_max=".$user['enemy_life_max'].",enemy_life_cur=".$user['enemy_life_cur'].",enemy_damage_min=".$user['enemy_damage_min'].",enemy_damage_max=".$user['enemy_damage_max'].",enemy_armor=".$user['enemy_armor'].",enemy_exp=".$user['enemy_exp'].",enemy_gold=".$user['enemy_gold']);

}

function add_enemy($enemy_slot, $enemy_ident) {
	global $user, $tb_enemy, $connection;
	$query = "SELECT * FROM ".$tb_enemy." WHERE enemy_ident=".$enemy_ident;
	$result = mysqli_query($connection, $query) 
		or die('{"error":"Ошибка считывания данных: '.mysqli_error($connection).'"}');
	$enemy = $result->fetch_assoc();	
	
	switch($enemy_slot) {
		case 1:
			$user['enemy_slot_1'] = $enemy_ident;
			$user['enemy_slot_1_image'] = $enemy['enemy_image'];
			update_user_table("current_outlands='".$user['current_outlands']."',enemy_slot_1=".$user['enemy_slot_1'].",enemy_slot_1_image='".$user['enemy_slot_1_image']."'");
			break;
		case 2:
			$user['enemy_slot_2'] = $enemy_ident;
			$user['enemy_slot_2_image'] = $enemy['enemy_image'];
			update_user_table("current_outlands='".$user['current_outlands']."',enemy_slot_2=".$user['enemy_slot_2'].",enemy_slot_2_image='".$user['enemy_slot_2_image']."'");
			break;
		case 3:
			$user['enemy_slot_3'] = $enemy_ident;
			$user['enemy_slot_3_image'] = $enemy['enemy_image'];
			update_user_table("current_outlands='".$user['current_outlands']."',enemy_slot_3=".$user['enemy_slot_3'].",enemy_slot_3_image='".$user['enemy_slot_3_image']."'");
			break;
	}
	
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
			$user['char_equip_armor_name'] = $item['item_name'];
			$user['char_equip_armor_ident'] = $item['item_ident'];
			$user['char_gold'] = $user['char_gold'] - $item['item_price'];
			$user['char_armor'] = $item['item_armor'];
			update_user_table("char_equip_armor_name='".$user['char_equip_armor_name']."',char_equip_armor_ident=".$user['char_equip_armor_ident'].",char_armor=".$user['char_armor'].",char_gold=".$user['char_gold']);
			add_event(2, $user['char_name'], 1, $user['char_gender'], $item['item_name']);
			break;
		case 1:
			$user['char_equip_weapon_name'] = $item['item_name'];
			$user['char_equip_weapon_ident'] = $item['item_ident'];
			$user['char_gold'] = $user['char_gold'] - $item['item_price'];
			$user['char_damage_min'] = $item['item_damage_min'];
			$user['char_damage_max'] = $item['item_damage_max'];
			update_user_table("char_equip_weapon_name='".$user['char_equip_weapon_name']."',char_equip_weapon_ident=".$user['char_equip_weapon_ident'].",char_damage_min=".$user['char_damage_min'].",char_damage_max=".$user['char_damage_max'].",char_gold=".$user['char_gold']);
			add_event(2, $user['char_name'], 1, $user['char_gender'], $item['item_name']);
			break;
	}
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
	}
}

function add_item_to_shop($item_slot, $item_ident) {
	global $user, $tb_item, $connection;

	switch($item_slot) {
		case 1:
			$user['item_slot_1'] = $item_ident;
			$user['item_slot_1_values'] = item_values($item_ident);
			update_user_table("item_slot_1=".$user['item_slot_1']);
			break;
		case 2:
			$user['item_slot_2'] = $item_ident;
			$user['item_slot_2_values'] = item_values($item_ident);
			update_user_table("item_slot_2=".$user['item_slot_2']);
			break;
		case 3:
			$user['item_slot_3'] = $item_ident;
			$user['item_slot_3_values'] = item_values($item_ident);
			update_user_table("item_slot_3=".$user['item_slot_3']);
			break;
		case 4:
			$user['item_slot_4'] = $item_ident;
			$user['item_slot_4_values'] = item_values($item_ident);
			update_user_table("item_slot_4=".$user['item_slot_4']);
			break;
		case 5:
			$user['item_slot_5'] = $item_ident;
			$user['item_slot_5_values'] = item_values($item_ident);
			update_user_table("item_slot_5=".$user['item_slot_5']);
			break;
		case 6:
			$user['item_slot_6'] = $item_ident;
			$user['item_slot_6_values'] = item_values($item_ident);
			update_user_table("item_slot_6=".$user['item_slot_6']);
			break;
	}
}

function change_region($region_ident, $food, $gold) {
	global $user, $tb_regions, $connection;
	$query = "SELECT * FROM ".$tb_regions." WHERE region_ident=".$region_ident;
	$result = mysqli_query($connection, $query) 
		or die('{"error":"Ошибка считывания данных: '.mysqli_error($connection).'"}');
	$region = $result->fetch_assoc();
	$user['char_region'] = $region['region_ident'];
	$user['char_region_level'] = $region['region_level'];
	$user['char_region_town_name'] = $region['region_town_name'];
	$user['char_gold'] -= $gold;
	$user['char_food'] -= $food;
	update_user_table("char_gold=".$user['char_gold'].",char_food=".$user['char_food'].",char_region=".$user['char_region'].",char_region_level=".$user['char_region_level'].",char_region_town_name='".$user['char_region_town_name']."'");
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

function update_user_table($s) {
	global $connection, $user, $tb_user;
	$query = "UPDATE ".$tb_user." SET ".$s." WHERE user_name='".$user['user_name']."'";
	if (!mysqli_query($connection, $query)) {
		die('{"error":"Ошибка сохранения данных: '.mysqli_error($connection).'"}');
	}
}

function get_char_level_exp($level) {
	return $level * 100;
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

function outland($location_ident, $enemies, $prev_location = [], $next_location = []) {
	global $user, $res, $connection, $tb_locations;
	$user['current_outlands'] = $location_ident;
	add_enemies($enemies);	
	$query = "SELECT * FROM ".$tb_locations." WHERE location_ident='".$location_ident."'";
	$result = mysqli_query($connection, $query) 
		or die('{"error":"Ошибка считывания данных: '.mysqli_error($connection).'"}');
	$location = $result->fetch_assoc();

	$user['title'] = $location['location_name'];
	$user['char_region_location_name'] = $location['location_name'];
	update_user_table("char_region_location_name='".$user['char_region_location_name']."'");
	
	if ($user['char_life_cur'] > 0) {
		$user['description'] = $location['location_description'];
	} else shades();
	$user['frame'] = 'outlands';
	$user['links'] = array();
	$n = 0;
	if ($user['char_life_cur'] > 0) {
		if (count($prev_location) > 0) {
			addlink($prev_location[0], $prev_location[1], $n);
			$n++;
		}
		if (count($prev_location) == 0) {
			go_to_the_gate();
			$n++;
		}
		if (count($next_location) > 0) {
			addlink($next_location[0], $next_location[1], $n);
			$n++;
		}
	} else
		go_to_the_graveyard();

	$res = json_encode($user, JSON_UNESCAPED_UNICODE);

}

function add_event($type, $name, $level = 1, $gender = 0, $str = '') {
	global $connection, $user, $tb_events;
	$query = "INSERT INTO ".$tb_events." (event_type,event_char_gender,event_char_name,event_char_level,event_str) VALUES(".$type.", ".$gender.", '".$name."', ".$level.", '".$str."')";
	if (!mysqli_query($connection, $query)) {
		die('{"error":"Ошибка сохранения данных: '.mysqli_error($connection).'"}');
	}
}

function get_events() {
	global $connection, $tb_events;
	$query = "SELECT event_type, event_char_gender, event_char_name, event_char_level ,event_str FROM ".$tb_events." ORDER BY id  DESC LIMIT 0, 15";
	$result = mysqli_query($connection, $query) 
		or die('{"error":"Ошибка считывания данных: '.mysqli_error($connection).'"}');
	$events = $result->fetch_all(MYSQLI_ASSOC);
	return json_encode($events, JSON_UNESCAPED_UNICODE);
}

$stat = array();

function char_battle_round() {
	global $user, $stat;
	$r = '';
	if (($user['char_life_cur'] > 0)&&($user['enemy_life_cur'] > 0)) {
		if (rand(1, 5) >= 2) {
			$d = rand($user['char_damage_min'], $user['char_damage_max']) - $user['enemy_armor'];
			if ($d <= 0) {
				$r .= 'Вы не можете пробить защиту '.$user['enemy_name'].'.#';
			} else {
				$stat['char_damages'] += $d;
				$user['enemy_life_cur'] -= $d;
				if ($user['enemy_life_cur'] > 0) {
					$r .= 'Вы раните '.$user['enemy_name'].' на '.$d.' HP.#';
				}else{
					$r .= 'Вы наносите удар на '.$d.' HP и убиваете '.$user['enemy_name'].'.#';
				}
			}
		} else {
			$r .= 'Вы промахиваетесь по '.$user['enemy_name'].'.#';
			$stat['char_misses']++;
		}		
	}
	return $r;
}

function enemy_battle_round() {
	global $user, $stat;
	$r = '';
	if (($user['enemy_life_cur'] > 0)&&($user['char_life_cur'] > 0)) {
		if (rand(1, 5) >= 2) {
			$d = rand($user['enemy_damage_min'], $user['enemy_damage_max']) - $user['char_armor'];
			if ($d <= 0) {
				$r .= $user['enemy_name'].' не может пробить вашу защиту.#';
			} else {
				$stat['enemy_damages'] += $d;
				$user['char_life_cur'] -= $d;
				if ($user['char_life_cur'] > 0) {
					$r .= $user['enemy_name'].' ранит вас на '.$d.' HP.#';
				}else{
					$r .= $user['enemy_name'].' наносит удар на '.$d.' HP и убивает вас.#';
				}
			}
		} else {
			$r .= $user['enemy_name'].' промахивается по вам.#';
			$stat['enemy_misses']++;
		}
	}
	return $r;
}

function auto_battle() {
	global $user, $stat;
	
	$r = '';
	$rounds = 0;
	$stat['char_damages'] = 0;
	$stat['enemy_damages'] = 0;
	$stat['char_misses'] = 0;
	$stat['enemy_misses'] = 0;
	
	$c = rand(0, 2);
	$r .= 'Вы вступаете в схватку с '.$user['enemy_name'].'.#';
	if ($c == 0)
		$r .= 'Вы бросаетесь в атаку!#';
	else
		$r .= $user['enemy_name'].' бросается в атаку!#';
	$r .= '--------------------------------------------------------#';
	while(true) {
		
		if ($c == 0) {
			$r .= char_battle_round();
			$r .= enemy_battle_round();
		} else {
			$r .= enemy_battle_round();
			$r .= char_battle_round();
		}

		if ($user['char_life_cur'] <= 0) {
			$user['char_life_cur'] = 0;
			$user['char_mana_cur'] = 0;
			$user['stat_deads']++;
			$user['char_exp'] -= round($user['char_exp'] / 5);
			$user['char_gold'] -= round($user['char_gold'] / 7);
			$r .= '--------------------------------------------------------#';
			$r .= 'Вы потеряли пятую часть опыта и седьмую часть золота.#';
			add_event(3, $user['char_name'], 1, $user['char_gender'], $user['char_region_location_name']);
			break;
		}
		
		if ($user['enemy_life_cur'] <= 0) {
			$user['enemy_life_cur'] = 0;
			$user['stat_kills']++;
			$gold = get_value($user['enemy_gold']);
			$user['char_gold'] += $gold;
			$exp = get_value($user['enemy_exp']);
			$user['char_exp'] += $exp;
			$r .= '--------------------------------------------------------#';
			if ($exp > 0)
				$r .= 'Вы получаете '.$exp.' опыта.#';
			if ($gold <= 0)
				$r .= 'Вы роетесь в останках '.$user['enemy_name'].', но ничего не находите.#';
			else
				$r .= 'Вы обшариваете останки '.$user['enemy_name'].' и подбираете '.$gold.' золота.#';
			break;
		}
		$rounds++;
		$c = rand(0, 2);
	}

	$r .= '--------------------------------------------------------#';
	$r .= 'Всего раундов: '.$rounds."#";
	$r .= 'Сумма урона: '.$stat['char_damages']." (".$user['char_name'].") / ".$stat['enemy_damages']." (".$user['enemy_name'].")#";
	$r .= 'Промахи: '.$stat['char_misses']." (".$user['char_name'].") / ".$stat['enemy_misses']." (".$user['enemy_name'].")#";
	if (ch_level_exp()) {
		$r .= '--------------------------------------------------------#';
		$r .= 'Вы стали намного опытнее для текущего уровня и поэтому получаете меньше опыта и золота! Нужно посетить Квартал Гильдий и повысить уровень!#';
	}
	return $r;
}

function ch_level_exp() {
	global $user;
	$r = false;
	if ($user['char_exp'] > get_char_level_exp($user['char_level'] + 1))
		$r = true;
	return $r;
}

function get_value($value) {
	global $user, $stat;
	
	if ($user['enemy_level'] < $user['char_level'] - 1)
		$r = round($value / round($stat['char_damages'] / $stat['enemy_damages']));
	else
		$r = $value;
	
	if (($r > 0) && (ch_level_exp())) {
		$r = rand(round($value / 10), round($value / 5));
		if ($r <= 0)
			$r = 1;
	}
	
	return $r;
}

/*
function has_item($id) {
	global $user;
	$inventory = $user['char_inventory'];
	$pos = strripos($inventory, '-'.$id.'-');
	if ($pos === false) {
		return false;
	} else {
		return true;
	}
}

function mod_item($id, $value) {
	global $user;
	$inventory = $user['char_inventory'];
	$items = split(',', $inventory);
	for($i = 0; $i < count($items); $i++) {
		
	}
}
*/
/*
function has_item($id) {
	global $user;
	$inventory = $user['char_inventory'];
	$pos = strripos($inventory, '"id":'.$id);
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
			$count = $count + $value;
			$items[$i]['count'] = $count;
			if ($count <= 0)
				unset($items[$i]);
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
*/
function get_inventory() {
	global $user;
	//$inventory = $user['char_inventory'];
	
	//item_modify(61, 1);
	//add_item(61, 1);
	//return item_count(99);
	
//	$items = array();
	$items = json_decode($user['char_inventory'], true);

	//$rr = $items[0];
	//$v = $rr['id'];
	//return $v;
	
	//$s = '0-61-0=6,0-33-1=1';
	//return strripos($s, '-67-');
	
	//$rr = $items['61'];
	//return $rr[1];
	//$items = ['61' => 3];
	//$items['61'] = 3;
	//return $items['65'];
	//if ($items['62'] == 5)
	//	$items['62'] = 7;
	//return var_dump($items['61']);
	//$r = 0;
	//if (isset($items['67']))
	//	$r = $items['67'];
	//return $r;
	
	return json_encode($items, JSON_UNESCAPED_UNICODE);
}

function add_enemies($enemy_idents) {
	for($i = 1; $i <= 3; $i++) {
		$r = $enemy_idents[array_rand($enemy_idents)];
		add_enemy($i, $r);
	}
}

function addlink($t, $j, $n = 0) {
	global $user;
	$user['links'][$n]['title'] = $t;
	$user['links'][$n]['link'] = $j;	
}

function go_to_the_town($t = 'Вернуться в город', $n = 0) {
	addlink($t, 'index.php?action=town', $n);
}

function go_to_the_graveyard($t = 'Идти на кладбище', $n = 0) {
	addlink($t, 'index.php?action=graveyard', $n);
}

function go_to_the_gate($t = 'Идти в сторону города', $n = 0) {
	addlink($t, 'index.php?action=gate', $n);
}

function shades() {
	global $user;
	$user['description'] = 'Вы находитесь в мире теней и ищете проход в мир живых. Чувствуется необычайная легкость и безразличие ко всему происходящему. Ваша душа вздымается все выше и выше. Повсюду вокруг вас души погибших в бесконечных битвах. Их души преследуют вас и шепчут о своих муках и страданиях. В мире теней одиноко, холодно и не уютно. Вы ищите ближайшее кладбище чтобы поскорее вернуться в мир живых.';
}

?>