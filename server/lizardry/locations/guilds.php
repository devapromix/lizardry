<?php

if ($action == 'guild_str') {

	$user['title'] = 'Гильдия Силы';
	$user['description'] = 'В Гильдии Силы можно увеличить минимальный и максимальный урон на 1 за каждый уровень.';
	$user['links'] = array();
	$user['links'][0]['title'] = 'Вернуться в город';
	$user['links'][0]['link'] = 'index.php?action=town';	
	$user['links'][1]['title'] = 'Тренировать Атаку';
	$user['links'][1]['link'] = 'index.php?action=guild_str&do=train_in_guild_str';

	if ($do == 'train_in_guild_str') {
		if ($user['char_exp'] < get_char_level_exp($user['char_level'])) die('{"error":"Вам сначала нужно набраться опыта!"}');
		$user['char_exp'] = $user['char_exp'] - get_char_level_exp($user['char_level']);
		$user['char_level']++;
		$user['char_damage_min']++;
		$user['char_damage_max']++;
		save_character();
		$user['log'] = 'Вы потренировались и стали лучше!';
		$user['links'] = array();
		$user['links'][0]['title'] = 'Назад';
		$user['links'][0]['link'] = 'index.php?action=guild_str';
	}

	$res = json_encode($user, JSON_UNESCAPED_UNICODE);	
	
}

if ($action == 'guild_body') {

	$user['title'] = 'Гильдия Тела';
	$user['description'] = 'В Гильдии Тела можно увеличить запас здоровья на 5 за каждый уровень. ';
	$user['links'] = array();
	$user['links'][0]['title'] = 'Вернуться в город';
	$user['links'][0]['link'] = 'index.php?action=town';	
	$user['links'][1]['title'] = 'Тренировать Тело';
	$user['links'][1]['link'] = 'index.php?action=guild_body&do=train_in_guild_body';

	if ($do == 'train_in_guild_body') {
		if ($user['char_exp'] < get_char_level_exp($user['char_level'])) die('{"error":"Вам сначала нужно набраться опыта!"}');
		$user['char_exp'] = $user['char_exp'] - get_char_level_exp($user['char_level']);
		$user['char_level']++;
		$user['char_life_cur'] = $user['char_life_cur'] + 5;
		$user['char_life_max'] = $user['char_life_max'] + 5;
		save_character();
		$user['log'] = 'Вы потренировались и стали лучше!';
		$user['links'] = array();
		$user['links'][0]['title'] = 'Назад';
		$user['links'][0]['link'] = 'index.php?action=guild_body';
	}

	$res = json_encode($user, JSON_UNESCAPED_UNICODE);	
	
}

if ($action == 'guild_adv') {

	$user['title'] = 'Гильдия Стражников';
	$user['description'] = 'В Гильдии Стражников можно увеличить максимальный урон на 2 за каждый уровень. ';
	$user['links'] = array();
	$user['links'][0]['title'] = 'Вернуться в город';
	$user['links'][0]['link'] = 'index.php?action=town';	
	$user['links'][1]['title'] = 'Тренировать Тело';
	$user['links'][1]['link'] = 'index.php?action=guild_body&do=train_in_guild_adv';

	if ($do == 'train_in_guild_adv') {
		if ($user['char_exp'] < get_char_level_exp($user['char_level'])) die('{"error":"Вам сначала нужно набраться опыта!"}');
		$user['char_exp'] = $user['char_exp'] - get_char_level_exp($user['char_level']);
		$user['char_level']++;
		$user['char_damage_max'] = $user['char_damage_max'] + 2;
		save_character();
		$user['log'] = 'Вы потренировались и стали лучше!';
		$user['links'] = array();
		$user['links'][0]['title'] = 'Назад';
		$user['links'][0]['link'] = 'index.php?action=guild_adv';
	}

	$res = json_encode($user, JSON_UNESCAPED_UNICODE);	
	
}

?>