<?php

if ($action == 'crypt') {
	
	$user['current_outlands'] = $action;
	
	add_enemy(1, rand(11, 14));
	add_enemy(2, rand(11, 14));
	add_enemy(3, rand(11, 14));	
	
	$user['title'] = 'Старый Склеп';
	if ($user['char_life_cur'] > 0) {
		$user['description'] = '';
	}else{
		$user['description'] = 'Ваша душа летает над могилами...';
	}
	$user['frame'] = 'outlands';
	$user['links'] = array();
	$user['links'][0]['title'] = 'Вернуться на Кладбище';
	$user['links'][0]['link'] = 'index.php?action=graveyard';
	
	$res = json_encode($user, JSON_UNESCAPED_UNICODE);

}

?>