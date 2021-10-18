<?php

if ($action == 'deepcave') {

	$user['current_outlands'] = $action;

	add_enemy(1, rand(7, 9));
	add_enemy(2, rand(7, 9));
	add_enemy(3, rand(7, 9));	
	
	$user['title'] = 'Глубокие Пещеры';
	if ($user['char_life_cur'] > 0) {
		$user['description'] = 'Эти пещеры обширны и извилисты. Никогда не знаешь, что может тебе встретится за поворотом. Тут надо быть начеку. Это место не терпит невнимательности. Один шаг и можно попасть в ловушку или липкую паутину, что прочнее канатов.';
	}else{
		$user['description'] = 'Ваша душа взмыла ввысь над валунами...';
	}
	$user['frame'] = 'outlands';
	$user['links'] = array();
	if ($user['char_life_cur'] > 0) {
		$user['links'][0]['title'] = 'Войти в Темный Пролом';
		$user['links'][0]['link'] = 'index.php?action=graycave';	
		$user['links'][1]['title'] = 'Спуститься в Логово';
		$user['links'][1]['link'] = 'index.php?action=stonewormlair';
	} else {
		$user['links'][0]['title'] = 'Отправиться на кладбище';
		$user['links'][0]['link'] = 'index.php?action=graveyard';
	}

	$res = json_encode($user, JSON_UNESCAPED_UNICODE);

}

?>