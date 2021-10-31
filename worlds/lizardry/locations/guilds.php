<?php

if ($action == 'guilds') {
	
	$user['title'] = 'Квартал Гильдий';
	if ($user['char_life_cur'] > 0) {
		$user['description'] = '';
	} else shades();
	$user['links'] = array();
	if ($user['char_life_cur'] > 0) {
		go_to_the_town('Идти на площадь города');
		addlink('Гильдия Тела', 'index.php?action=guild_body', 1);
		addlink('Гильдия Духа', 'index.php?action=guild_spirit', 2);
	} else go_to_the_graveyard();
	
	$res = json_encode($user, JSON_UNESCAPED_UNICODE);	

}

if ($action == 'guild_body') {

	$user['title'] = 'Гильдия Тела';
	$user['description'] = 'В Гильдии Тела можно увеличить запас здоровья на 5 за каждый уровень. ';
	$user['links'] = array();
	addlink('Покинуть гильдию', 'index.php?action=guilds');
	addlink('Приступить к тренировке', 'index.php?action=guild_body&do=train_in_guild_body', 1);

	if ($do == 'train_in_guild_body') {
		if ($user['char_life_cur'] <= 0) die('{"error":"Вам сначала нужно вернуться к жизни!"}');
		if ($user['char_exp'] < get_char_level_exp($user['char_level'])) die('{"error":"Вам сначала нужно набраться опыта!"}');
		$user['char_exp'] = $user['char_exp'] - get_char_level_exp($user['char_level']);
		$user['char_level']++;
		$user['char_life_cur'] = $user['char_life_cur'] + 5;
		$user['char_life_max'] = $user['char_life_max'] + 5;
		add_event(1, $user['char_name'], $user['char_level']);
		update_user_table("char_exp=".$user['char_exp'].",char_level=".$user['char_level'].",char_life_cur=".$user['char_life_cur'].",char_life_max=".$user['char_life_max']);
		$user['log'] = 'Вы потренировались и стали лучше!';
		$user['links'] = array();
		addlink('Назад', 'index.php?action=guild_body');
	}

	$res = json_encode($user, JSON_UNESCAPED_UNICODE);	
	
}

if ($action == 'guild_spirit') {

	$user['title'] = 'Гильдия Духа';
	$user['description'] = 'В Гильдии Духа можно увеличить запас маны на 10 за каждый уровень. ';
	$user['links'] = array();
	addlink('Покинуть гильдию', 'index.php?action=guilds');
	addlink('Приступить к тренировке', 'index.php?action=guild_spirit&do=train_in_guild_spirit', 1);

	if ($do == 'train_in_guild_spirit') {
		if ($user['char_life_cur'] <= 0) die('{"error":"Вам сначала нужно вернуться к жизни!"}');
		if ($user['char_exp'] < get_char_level_exp($user['char_level'])) die('{"error":"Вам сначала нужно набраться опыта!"}');
		$user['char_exp'] = $user['char_exp'] - get_char_level_exp($user['char_level']);
		$user['char_level']++;
		$user['char_mana_cur'] = $user['char_mana_cur'] + 10;
		$user['char_mana_max'] = $user['char_mana_max'] + 10;
		add_event(1, $user['char_name'], $user['char_level']);
		update_user_table("char_exp=".$user['char_exp'].",char_level=".$user['char_level'].",char_mana_cur=".$user['char_mana_cur'].",char_mana_max=".$user['char_mana_max']);
		$user['log'] = 'Вы потренировались и стали лучше!';
		$user['links'] = array();
		addlink('Назад', 'index.php?action=guild_spirit');
	}

	$res = json_encode($user, JSON_UNESCAPED_UNICODE);	
	
}

?>