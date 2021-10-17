<?php

if ($action == 'guilds') {
	
	$user['title'] = 'Квартал Гильдий';
	if ($user['char_life_cur'] > 0) {
		$user['description'] = '';
	}else{
		$user['description'] = 'Ваша душа летает над городом.';
	}
	$user['links'] = array();
	if ($user['char_life_cur'] > 0) {	
		$user['links'][0]['title'] = 'На площадь города';
		$user['links'][0]['link'] = 'index.php?action=town';
		$user['links'][1]['title'] = 'Гильдия Силы';
		$user['links'][1]['link'] = 'index.php?action=guild_str';
		$user['links'][2]['title'] = 'Гильдия Тела';
		$user['links'][2]['link'] = 'index.php?action=guild_body';
		$user['links'][3]['title'] = 'Гильдия Стражников';
		$user['links'][3]['link'] = 'index.php?action=guild_adv';
	} else {
		$user['links'][0]['title'] = 'Городское Кладбище';
		$user['links'][0]['link'] = 'index.php?action=graveyard';
	}
	
	$res = json_encode($user, JSON_UNESCAPED_UNICODE);	

}

if ($action == 'guild_str') {

	$user['title'] = 'Гильдия Силы';
	$user['description'] = 'В Гильдии Силы можно увеличить минимальный и максимальный урон на 1 за каждый уровень.';
	$user['links'] = array();
	$user['links'][0]['title'] = 'Покинуть гильдию';
	$user['links'][0]['link'] = 'index.php?action=guilds';	
	$user['links'][1]['title'] = 'Приступить к тренировке';
	$user['links'][1]['link'] = 'index.php?action=guild_str&do=train_in_guild_str';

	if ($do == 'train_in_guild_str') {
		if ($user['char_exp'] < get_char_level_exp($user['char_level'])) die('{"error":"Вам сначала нужно набраться опыта!"}');
		$user['char_exp'] = $user['char_exp'] - get_char_level_exp($user['char_level']);
		$user['char_level']++;
		$user['char_damage_min']++;
		$user['char_damage_max']++;
		update_user_table("char_exp=".$user['char_exp'].",char_level=".$user['char_level'].",char_damage_min=".$user['char_damage_min'].",char_damage_max=".$user['char_damage_max']);
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
	$user['links'][0]['title'] = 'Покинуть гильдию';
	$user['links'][0]['link'] = 'index.php?action=guilds';	
	$user['links'][1]['title'] = 'Приступить к тренировке';
	$user['links'][1]['link'] = 'index.php?action=guild_body&do=train_in_guild_body';

	if ($do == 'train_in_guild_body') {
		if ($user['char_exp'] < get_char_level_exp($user['char_level'])) die('{"error":"Вам сначала нужно набраться опыта!"}');
		$user['char_exp'] = $user['char_exp'] - get_char_level_exp($user['char_level']);
		$user['char_level']++;
		$user['char_life_cur'] = $user['char_life_cur'] + 5;
		$user['char_life_max'] = $user['char_life_max'] + 5;
		update_user_table("char_exp=".$user['char_exp'].",char_level=".$user['char_level'].",char_life_cur=".$user['char_life_cur'].",char_life_max=".$user['char_life_max']);
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
	$user['links'][0]['title'] = 'Покинуть гильдию';
	$user['links'][0]['link'] = 'index.php?action=guilds';	
	$user['links'][1]['title'] = 'Приступить к тренировке';
	$user['links'][1]['link'] = 'index.php?action=guild_adv&do=train_in_guild_adv';

	if ($do == 'train_in_guild_adv') {
		if ($user['char_exp'] < get_char_level_exp($user['char_level'])) die('{"error":"Вам сначала нужно набраться опыта!"}');
		$user['char_exp'] = $user['char_exp'] - get_char_level_exp($user['char_level']);
		$user['char_level']++;
		$user['char_damage_max'] = $user['char_damage_max'] + 2;
		update_user_table("char_exp=".$user['char_exp'].",char_level=".$user['char_level'].",char_damage_max=".$user['char_damage_max']);
		$user['log'] = 'Вы потренировались и стали лучше!';
		$user['links'] = array();
		$user['links'][0]['title'] = 'Назад';
		$user['links'][0]['link'] = 'index.php?action=guild_adv';
	}

	$res = json_encode($user, JSON_UNESCAPED_UNICODE);	
	
}

?>