<?php

if ($action == 'crypt') {
	
	$user['current_outlands'] = $action;
	
	add_enemy(1, rand(13, 15));
	add_enemy(2, rand(13, 15));
	add_enemy(3, rand(13, 15));	
	
	$user['title'] = 'Старый Склеп';
	if ($user['char_life_cur'] > 0) {
		$user['description'] = 'Вы входите в старинный родовой склеп. Здесь достаточно узко и мало места. В стенах вырезаны ниши для гробов. Сами гробы вскрыты и находятся в плачевном состоянии. Какие-то старанные шелестящие звуки привлекают ваше внимание.';
	}else{
		$user['description'] = 'Вы в виде бестелесного духа парите под потолком склепа. Вам хочется поскорее отыскать ближайшее кладбище.';
	}
	$user['frame'] = 'outlands';
	$user['links'] = array();
	$user['links'][0]['title'] = 'Вернуться на Кладбище';
	$user['links'][0]['link'] = 'index.php?action=graveyard';
	
	$res = json_encode($user, JSON_UNESCAPED_UNICODE);

}

?>