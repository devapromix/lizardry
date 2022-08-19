<?php

if ($action == 'magictower') {
	
	$user['title'] = 'Магическая Башня';
	if ($user['char_life_cur'] > 0) {
		$user['description'] = '';
	} else shades();
	$user['links'] = array();
	go_to_the_town();
	
	$res = json_encode($user, JSON_UNESCAPED_UNICODE);	

}

?>