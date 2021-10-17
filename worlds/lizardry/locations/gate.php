<?php

if ($action == 'gate') {
	$user['title'] = 'Врата Города';
	if ($user['char_life_cur'] > 0) {
		$user['description'] = 'Вы находитесь у главных ворот города.';
	}else{
		$user['description'] = 'Ваша душа летает главными городскими воротами города.';
	}
	$user['links'] = array();
	if ($user['char_life_cur'] > 0) {	
		$user['links'][0]['title'] = 'Темный Лес';
		$user['links'][0]['link'] = 'index.php?action=forest';
		$user['links'][1]['title'] = 'Городское Кладбище';
		$user['links'][1]['link'] = 'index.php?action=graveyard';
		$user['links'][2]['title'] = 'Войти в Город';
		$user['links'][2]['link'] = 'index.php?action=town';
	} else {
		$user['links'][0]['title'] = 'Городское Кладбище';
		$user['links'][0]['link'] = 'index.php?action=graveyard';
	}
	
	$res = json_encode($user, JSON_UNESCAPED_UNICODE);
}

?>