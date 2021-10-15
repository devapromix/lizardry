<?php

if ($action == 'deepcave') {

	$user['enemy_block_refresh'] = 0;

	if ((!isset($user['enemy_block_refresh']))or($user['enemy_block_refresh'] == 0)) {
		$user['enemy_slot_1'] = rand(7, 9);
		$user['enemy_slot_2'] = rand(7, 9);
		$user['enemy_slot_3'] = rand(7, 9);
		$user['enemy_block_refresh'] = 1;
		save_character();
	}

	$user['title'] = 'Глубокие Пещеры';
	if ($user['char_life_cur'] > 0) {
		$user['description'] = '';
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