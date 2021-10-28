<?php

if ($action == 'crypt') {
	
	$user['current_outlands'] = $action;

	add_enemies([13,14,15,16]);
	
	$user['title'] = 'Старый Склеп';
	if ($user['char_life_cur'] > 0) {

		$user['description'] = 'Вы входите в старинный родовой склеп. Здесь узко и мало места. В стенах вырезаны ниши для гробов. Сами гробы вскрыты и находятся в плачевном состоянии. Какие-то старанные шелестящие звуки привлекают ваше внимание.';

	} else shades();
	
	$user['frame'] = 'outlands';
	$user['links'] = array();
	go_to_the_graveyard('Вернуться на Кладбище');
	
	$res = json_encode($user, JSON_UNESCAPED_UNICODE);

}

?>