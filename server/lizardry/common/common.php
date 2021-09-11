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
	global $user, $username, $userpass;
	
	$file .= "<?php\n\n";
	
	$file .= '$user = array();'."\n";
	$file .= '$user[\'user_name\'] = "'.$username.'";'."\n";
	$file .= '$user[\'user_pass\'] = "'.$userpass.'";'."\n";
	$file .= '$user[\'char_name\'] = "'.$user['char_name'].'";'."\n";
	$file .= '$user[\'char_level\'] = '.$user['char_level'].';'."\n";
	$file .= '$user[\'char_exp\'] = '.$user['char_exp'].';'."\n";
	$file .= '$user[\'char_food\'] = '.$user['char_food'].';'."\n";
	$file .= '$user[\'char_gold\'] = '.$user['char_gold'].';'."\n";
	$file .= '$user[\'char_bank\'] = '.$user['char_bank'].';'."\n";
	$file .= '$user[\'char_damage_min\'] = '.$user['char_damage_min'].';'."\n";
	$file .= '$user[\'char_damage_max\'] = '.$user['char_damage_max'].';'."\n";
	$file .= '$user[\'char_armor\'] = '.$user['char_armor'].';'."\n";
	$file .= '$user[\'char_life_cur\'] = '.$user['char_life_cur'].';'."\n";
	$file .= '$user[\'char_life_max\'] = '.$user['char_life_max'].';'."\n";
	$file .= '$user[\'char_mana_cur\'] = '.$user['char_mana_cur'].';'."\n";
	$file .= '$user[\'char_mana_max\'] = '.$user['char_mana_max'].';'."\n";
	
	$file .= "\n?>";

	file_put_contents($_SERVER['DOCUMENT_ROOT'].'/lizardry/characters/character.'.$username.'.php', $file, LOCK_EX);	
}

function auto_battle() {
	global $user;
	
	$r = '';
	
	while(true) {
		if (rand(1, 3) > 1) {
			if (rand(1, 5) > 2) {
				$d = rand($user['char_damage_min'], $user['char_damage_max']);
				$r .= 'Герой нанес урон '.$d.'. ';
				$user['enemy_life_cur'] -= $d;
			} else {
				$r .= 'Герой промахнулся. ';
			}
		} else {
			if (rand(1, 5) > 2) {
				$d = rand($user['enemy_damage_min'], $user['enemy_damage_max']);
				$r .= 'Враг нанес урон '.$d.'. ';
				$user['char_life_cur'] -= $d;
			} else {
				$r .= 'Враг промахнулся. ';
			}
		}
		if ($user['char_life_cur'] <= 0) {
			$user['char_life_cur'] = 0;
			$user['char_exp'] -= round($user['char_exp'] / 3);
			$user['char_gold'] -= round($user['char_gold'] / 7);
			$r .= 'Ваш герой погиб! Вы потеряли треть опыта и часть золота.';
			break;
		}
		if ($user['enemy_life_cur'] <= 0) {
			$user['enemy_life_cur'] = 0;
			$gold = rand(3, 9) + $user['char_level'];
			$user['char_gold'] += $gold;
			$exp = rand(4, 5);
			$user['char_exp'] += $exp;
			$r .= 'Враг побежден! Найдено золото +'.$gold.'. Опыт +'.$exp.'. ';
			break;
		}
	}
	
	return $r;
}

?>