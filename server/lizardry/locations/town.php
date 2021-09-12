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
		$user['links'][0]['title'] = 'Главные Ворота';
		$user['links'][0]['link'] = 'index.php?action=gate';
		$user['links'][1]['title'] = 'Банк';
		$user['links'][1]['link'] = 'index.php?action=bank';
		$user['links'][2]['title'] = 'Таверна';
		$user['links'][2]['link'] = 'index.php?action=tavern';
		$user['links'][3]['title'] = 'Гильдия Силы';
		$user['links'][3]['link'] = 'index.php?action=guild_str';
		$user['links'][4]['title'] = 'Гильдия Тела';
		$user['links'][4]['link'] = 'index.php?action=guild_body';
		$user['links'][5]['title'] = 'Гильдия Стражников';
		$user['links'][5]['link'] = 'index.php?action=guild_adv';
	} else {
		$user['links'][0]['title'] = 'Городское Кладбище';
		$user['links'][0]['link'] = 'index.php?action=graveyard';
	}
	
	$res = json_encode($user, JSON_UNESCAPED_UNICODE);
	
}

?>