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
	$user['enemy_damage_min'] = $enemy['enemy_damage_min'];
	$user['enemy_damage_max'] = $enemy['enemy_damage_max'];
	$user['enemy_armor'] = $enemy['enemy_armor'];
	$user['enemy_exp'] = $enemy['enemy_exp'];
	$user['enemy_gold'] = rand($enemy['enemy_gold_min'], $enemy['enemy_gold_max']);

	update_user_table("enemy_name='".$user['enemy_name']."',enemy_image='".$user['enemy_image']."',enemy_level=".$user['enemy_level'].",enemy_life_max=".$user['enemy_life_max'].",enemy_life_cur=".$user['enemy_life_cur'].",enemy_damage_min=".$user['enemy_damage_min'].",enemy_damage_max=".$user['enemy_damage_max'].",enemy_armor=".$user['enemy_armor'].",enemy_exp=".$user['enemy_exp'].",enemy_gold=".$user['enemy_gold']);

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

function add_event($type, $name){
	global $user;
	$f = PATH."events".DS."events.txt";
	$h = file($f);
	if ($h) {
		$c = count($h);
		if ($c > 0) {
			$fp = fopen($f,"w") or die("can't open file");
			fwrite($fp, "");
			fclose($fp);
			$fp = fopen($f,"a");
			$k = $c - 19;
			if ($k < 0)
				$k = 0;
			for ($i = $k; $i < $c; $i++) {
				fwrite($fp, $h[$i]);
			}
			fclose($fp);
		}
	}
	$data = array();
	$data[] = $type;
	$data[] = $name;
	file_put_contents($f, print_r(implode(",", $data), true) . PHP_EOL, FILE_APPEND | LOCK_EX);
}

function auto_battle() {
	global $user;
	
	$r = '';
	$c = 0;
	
	while(true) {

		if (rand(1, $c + 5) >= 2) {
			$d = rand($user['char_damage_min'], $user['char_damage_max']);
			$user['enemy_life_cur'] -= $d;
			if ($user['enemy_life_cur'] > 0) {
				$r .= 'Вы раните '.$user['enemy_name'].' на '.$d.' HP.#';
			}else{
				$r .= 'Вы наносите удар на '.$d.' HP и убиваете '.$user['enemy_name'].'.#';
			}
		} else {
			$r .= 'Вы промахиваетесь по '.$user['enemy_name'].'.#';
			$c++;
		}		
		
		if ($user['enemy_life_cur'] > 0) {
			if (rand(1, $c + 5) >= 2) {
				$d = rand($user['enemy_damage_min'], $user['enemy_damage_max']);
				$user['char_life_cur'] -= $d;
				if ($user['char_life_cur'] > 0) {
					$r .= $user['enemy_name'].' ранит вас на '.$d.' HP.#';
				}else{
					$r .= $user['enemy_name'].' наносит удар на '.$d.' HP и убивает вас.#';
				}
			} else {
				$r .= $user['enemy_name'].' промахивается по вам.#';
				$c++;
			}
		}
		
		if ($user['char_life_cur'] <= 0) {
			$user['char_life_cur'] = 0;
			$user['char_exp'] -= round($user['char_exp'] / 5);
			$user['char_gold'] -= round($user['char_gold'] / 7);
			$r .= 'Вы потеряли пятую часть опыта и седьмую часть золота.#';
			break;
		}
		
		if ($user['enemy_life_cur'] <= 0) {
			$user['enemy_life_cur'] = 0;
			$gold = $user['enemy_gold'];
			$user['char_gold'] += $gold;
			$exp = $user['enemy_exp'];
			$user['char_exp'] += $exp;
			$r .= 'Вы получаете '.$exp.' опыта.#';
			$r .= 'Вы обшариваете останки '.$user['enemy_name'].' и подбираете '.$gold.' золота.#';
			break;

		}
	}
	
	return $r;
}

?>