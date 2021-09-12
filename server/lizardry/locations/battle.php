<?php

if ($action == 'battle') {

	$user['title'] = 'Сражение!!!';
	$user['mainframe'] = 'outlands';
	$user['links'] = array();
	$n = 0;
	if ($user['char_life_cur'] > 0) {
		$user['links'][0]['title'] = 'Автобой!';
		$user['links'][0]['link'] = 'index.php?action=battle&do=auto_battle';
		$n++;
	}
	$user['links'][$n]['title'] = 'Назад';
	$user['links'][$n]['link'] = 'index.php?action=forest';

	$user['enemy_name'] = 'Серый Волк';
	$user['enemy_life_cur'] = 15;
	$user['enemy_life_max'] = 15;
	$user['enemy_damage_min'] = 2;
	$user['enemy_damage_max'] = 3;
	$user['enemy_exp'] = 5;
	$user['battlelog'] = '';

	if ($do == 'auto_battle') {
		$user['title'] = 'Сражение!!!';
		$user['mainframe'] = 'outlands';
		$user['links'] = array();
		$user['links'][0]['title'] = 'Назад';
		$user['links'][0]['link'] = 'index.php?action=forest';
		$user['battlelog'] = auto_battle();		
		save_character();
	}

	$res = json_encode($user, JSON_UNESCAPED_UNICODE);

}

?>