<?php

if ($action == 'town') {
	
	$char['title'] = 'Главная Площадь';
	$char['description'] = 'Вы находитесь на главной площади города.';
	$char['links'] = array();
	$char['links'][0]['title'] = 'Темный Лес';
	$char['links'][0]['link'] = 'index.php?action=forest';
	$char['links'][1]['title'] = 'Банк';
	$char['links'][1]['link'] = 'index.php?action=bank';
//	$char['links'][2]['title'] = 'Таверна';
//	$char['links'][2]['link'] = 'index.php?action=tavern';
	
	$res = json_encode($char, JSON_UNESCAPED_UNICODE);
	
}

?>