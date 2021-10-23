<?php

if ($action == 'stonefield') {

	$user['current_outlands'] = $action;

	add_enemy(1, rand(19, 21));
	add_enemy(2, rand(19, 21));
	add_enemy(3, rand(19, 21));	
	
	$user['title'] = 'Каменное Поле';
	if ($user['char_life_cur'] > 0) {
		$user['description'] = 'Огромная бескрайняя равнина к западу от Морхольда усеяна большими валунами. Их происхождение не известно, но благодаря им равнина и получила свое название. Это не дружелюбное место - на равнине обитает большое количество опасных тварей, а ночью чертовски холодно.';
	}else{
		$user['description'] = 'Ваша душа взмыла ввысь над безконечной каменной равниной. В мире теней одиноко, холодно и не уютно. Вы ищите ближайшее кладбище чтобы поскорее вернуться в мир живых.';
	}
	$user['frame'] = 'outlands';
	$user['links'] = array();
	if ($user['char_life_cur'] > 0) {
		$user['links'][0]['title'] = 'Идти в сторону города';
		$user['links'][0]['link'] = 'index.php?action=gate';	
	} else {
		$user['links'][0]['title'] = 'Отправиться на кладбище';
		$user['links'][0]['link'] = 'index.php?action=graveyard';
	}

	$res = json_encode($user, JSON_UNESCAPED_UNICODE);

}

?>