<?php

if ($action == 'town') {
	
	$user['title'] = 'Главная Площадь';
	$user['description'] = 'Вы находитесь на главной площади города.';
	$user['links'] = array();
	$user['links'][0]['title'] = 'Темный Лес';
	$user['links'][0]['link'] = 'index.php?action=forest';
	$user['links'][1]['title'] = 'Банк';
	$user['links'][1]['link'] = 'index.php?action=bank';
//	$user['links'][2]['title'] = 'Таверна';
//	$user['links'][2]['link'] = 'index.php?action=tavern';
	
	$res = json_encode($user, JSON_UNESCAPED_UNICODE);
	
}

?>