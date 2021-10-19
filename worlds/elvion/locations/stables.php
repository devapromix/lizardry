<?php

if ($action == 'stables') {
	
	$user['title'] = 'Конюшни';
	if ($user['char_life_cur'] > 0) {
		$user['description'] = '';
	} else {
		$user['description'] = '';
	}
	$res = json_encode($user, JSON_UNESCAPED_UNICODE);
	
}













?>