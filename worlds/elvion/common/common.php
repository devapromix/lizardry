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

function save_character() {
	global $user, $username, $userpass;

	$file .= "<?php\n\n";	
	$file .= '$user = array();'."\n";

	$file .= '$user[\'user_name\'] = "'.$username.'";'."\n";
	$file .= '$user[\'user_pass\'] = "'.$userpass.'";'."\n";

	$file .= '$user[\'char_name\'] = "'.$user['char_name'].'";'."\n";
	$file .= '$user[\'char_level\'] = '.$user['char_level'].';'."\n";
	$file .= '$user[\'char_exp\'] = '.$user['char_exp'].';'."\n";
	$file .= '$user[\'char_gold\'] = '.$user['char_gold'].';'."\n";
	$file .= '$user[\'char_bank\'] = '.$user['char_bank'].';'."\n";
	$file .= '$user[\'char_food\'] = '.$user['char_food'].';'."\n";
	$file .= '$user[\'char_damage_min\'] = '.$user['char_damage_min'].';'."\n";
	$file .= '$user[\'char_damage_max\'] = '.$user['char_damage_max'].';'."\n";
	$file .= '$user[\'char_armor\'] = '.$user['char_armor'].';'."\n";
	$file .= '$user[\'char_life_cur\'] = '.$user['char_life_cur'].';'."\n";
	$file .= '$user[\'char_life_max\'] = '.$user['char_life_max'].';'."\n";
	$file .= '$user[\'char_mana_cur\'] = '.$user['char_mana_cur'].';'."\n";
	$file .= '$user[\'char_mana_max\'] = '.$user['char_mana_max'].';'."\n";

	$file .= '$user[\'enemy_slot_1\'] = '.$user['enemy_slot_1'].';'."\n";
	$file .= '$user[\'enemy_slot_2\'] = '.$user['enemy_slot_2'].';'."\n";
	$file .= '$user[\'enemy_slot_3\'] = '.$user['enemy_slot_3'].';'."\n";
	$file .= '$user[\'enemy_block_refresh\'] = '.$user['enemy_block_refresh'].';'."\n";

	$file .= '$user[\'enemy_name\'] = "'.$user['enemy_name'].'";'."\n";
	$file .= '$user[\'enemy_image\'] = "'.$user['enemy_image'].'";'."\n";
	$file .= '$user[\'enemy_level\'] = '.$user['enemy_level'].';'."\n";
	$file .= '$user[\'enemy_exp\'] = '.$user['enemy_exp'].';'."\n";
	$file .= '$user[\'enemy_gold\'] = '.$user['enemy_gold'].';'."\n";
	$file .= '$user[\'enemy_damage_min\'] = '.$user['enemy_damage_min'].';'."\n";
	$file .= '$user[\'enemy_damage_max\'] = '.$user['enemy_damage_max'].';'."\n";
	$file .= '$user[\'enemy_armor\'] = '.$user['enemy_armor'].';'."\n";
	$file .= '$user[\'enemy_life_cur\'] = '.$user['enemy_life_cur'].';'."\n";
	$file .= '$user[\'enemy_life_max\'] = '.$user['enemy_life_max'].';'."\n";

	$file .= "\n?>";

	file_put_contents(PATH.'characters'.DS.'character.'.$username.'.php', $file, LOCK_EX);	
}

function gen_enemy($enemy_id) {
	global $user;
	if ($enemy_id == 1) {
		$user['enemy_name'] = 'Серый Волк';
		$user['enemy_image'] = 'ENEMY_GRAY_WOLF';
		$user['enemy_level'] = 1;
		$user['enemy_life_max'] = (rand(1, 4) - 2) + 15;
		$user['enemy_life_cur'] = $user['enemy_life_max'];
		$user['enemy_damage_min'] = 2;
		$user['enemy_damage_max'] = 3;
	} else {
		$user['enemy_name'] = 'Бурый Медведь';
		$user['enemy_image'] = 'ENEMY_BROWN_BEAR';
		$user['enemy_level'] = 1;
		$user['enemy_life_max'] = (rand(1, 4) - 2) + 25;
		$user['enemy_life_cur'] = $user['enemy_life_max'];
		$user['enemy_damage_min'] = 3;
		$user['enemy_damage_max'] = 4;
	}
	$user['enemy_exp'] = round($user['enemy_life_max'] / 2);
	save_character();
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

function add_event($type){
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
	$data[] = $user['char_name'];
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
			$gold = rand(1, 10) + ($user['char_level'] * 5);
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