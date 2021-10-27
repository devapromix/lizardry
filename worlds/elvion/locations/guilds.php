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
		$user['links'][1]['title'] = 'Гильдия Тела';
		$user['links'][1]['link'] = 'index.php?action=guild_body';
		$user['links'][2]['title'] = 'Гильдия Духа';
		$user['links'][2]['link'] = 'index.php?action=guild_spirit';
	} else {
		$user['links'][0]['title'] = 'Городское Кладбище';
		$user['links'][0]['link'] = 'index.php?action=graveyard';
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
		add_event(1, $user['char_name'], $user['char_level']);
		update_user_table("char_exp=".$user['char_exp'].",char_level=".$user['char_level'].",char_life_cur=".$user['char_life_cur'].",char_life_max=".$user['char_life_max']);
		$user['log'] = 'Вы потренировались и стали лучше!';
		$user['links'] = array();
		$user['links'][0]['title'] = 'Назад';
		$user['links'][0]['link'] = 'index.php?action=guild_body';
	}

	$res = json_encode($user, JSON_UNESCAPED_UNICODE);	
	
}

if ($action == 'guild_spirit') {

	$user['title'] = 'Гильдия Духа';
	$user['description'] = 'В Гильдии Духа можно увеличить запас маны на 10 за каждый уровень. ';
	$user['links'] = array();
	$user['links'][0]['title'] = 'Покинуть гильдию';
	$user['links'][0]['link'] = 'index.php?action=guilds';	
	$user['links'][1]['title'] = 'Приступить к тренировке';
	$user['links'][1]['link'] = 'index.php?action=guild_spirit&do=train_in_guild_spirit';

	if ($do == 'train_in_guild_spirit') {
		if ($user['char_exp'] < get_char_level_exp($user['char_level'])) die('{"error":"Вам сначала нужно набраться опыта!"}');
		$user['char_exp'] = $user['char_exp'] - get_char_level_exp($user['char_level']);
		$user['char_level']++;
		$user['char_mana_cur'] = $user['char_mana_cur'] + 10;
		$user['char_mana_max'] = $user['char_mana_max'] + 10;
		add_event(1, $user['char_name'], $user['char_level']);
		update_user_table("char_exp=".$user['char_exp'].",char_level=".$user['char_level'].",char_mana_cur=".$user['char_mana_cur'].",char_mana_max=".$user['char_mana_max']);
		$user['log'] = 'Вы потренировались и стали лучше!';
		$user['links'] = array();
		$user['links'][0]['title'] = 'Назад';
		$user['links'][0]['link'] = 'index.php?action=guild_spirit';
	}

	$res = json_encode($user, JSON_UNESCAPED_UNICODE);	
	
}

?>