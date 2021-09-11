<?php

if ($action == 'town') {
	
	$user['title'] = 'Главная Площадь Города';
	if ($user['char_life_cur'] > 0) {
		$user['description'] = 'Вы находитесь на главной площади города.';
	}else{
		$user['description'] = 'Ваша душа летает главной площадью города.';
	}
	$user['links'] = array();
	if ($user['char_life_cur'] > 0) {	
		$user['links'][0]['title'] = 'Темный Лес';
		$user['links'][0]['link'] = 'index.php?action=forest';
		$user['links'][1]['title'] = 'Банк';
		$user['links'][1]['link'] = 'index.php?action=bank';
		$user['links'][2]['title'] = 'Таверна';
		$user['links'][2]['link'] = 'index.php?action=tavern';
		$user['links'][3]['title'] = 'Городское Кладбище';
		$user['links'][3]['link'] = 'index.php?action=graveyard';
	} else {
		$user['links'][0]['title'] = 'Идти на кладбище';
		$user['links'][0]['link'] = 'index.php?action=graveyard';
	}
	
	$res = json_encode($user, JSON_UNESCAPED_UNICODE);
	
}

?>