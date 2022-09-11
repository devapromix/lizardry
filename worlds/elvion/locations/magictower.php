<?php

if ($action == 'magictower') {

	$user['title'] = 'Магическая Башня';
	if ($user['char_life_cur'] > 0) {
		$user['description'] = 'Вы находитесь на последнем этаже самого высокого строения в городе. Отсюда открывается прекрасный вид на город.';
	} else shades();
	$user['links'] = array();
	if ($user['char_life_cur'] > 0) {
		go_to_the_town();
	} else go_to_the_graveyard();
	
	$res = json_encode($user, JSON_UNESCAPED_UNICODE);	

}

?>