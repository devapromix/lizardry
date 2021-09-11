<?php

if ($action == 'forest') {

	$user['title'] = 'Темный Лес';
	$user['description'] = 'Вы вошли в Темный Лес.';
	$user['refresh'] = 'no_refresh';
	$user['links'] = array();
	$user['links'][0]['title'] = 'Искать золото';
	$user['links'][0]['link'] = 'index.php?action=findgold';	
	$user['links'][1]['title'] = 'Вернуться в город';
	$user['links'][1]['link'] = 'index.php?action=town';	
	
	$res = json_encode($user, JSON_UNESCAPED_UNICODE);

}

if ($action == 'findgold') {
	
	$value = rand(3, 9) + $user['char_level'];
	$user['char_gold'] += $value;
	save_character();
	
	$user['title'] = 'Находка!';
	$user['description'] = 'Вы подняли '.$value.' золотых монет.';
	$user['links'] = array();
	$user['links'][0]['title'] = 'Назад';
	$user['links'][0]['link'] = 'index.php?action=forest';	
	
	$res = json_encode($user, JSON_UNESCAPED_UNICODE);

}

?>