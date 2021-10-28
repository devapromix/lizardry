<?php

if ($action == 'stonefield') {

	$user['current_outlands'] = $action;

	add_enemies([23,24,25]);
	
	$user['title'] = 'Каменное Поле';
	if ($user['char_life_cur'] > 0) {
		$user['description'] = 'Огромная бескрайняя равнина к западу от Морхольда усеяна большими валунами. Их происхождение не известно, но благодаря им равнина и получила свое название. Это не дружелюбное место - на равнине обитает большое количество опасных тварей, а ночью чертовски холодно.';
	}else shades();
	$user['frame'] = 'outlands';
	$user['links'] = array();
	if ($user['char_life_cur'] > 0)
		go_to_the_gate();
	else
		go_to_the_graveyard();
	
	$res = json_encode($user, JSON_UNESCAPED_UNICODE);

}

?>