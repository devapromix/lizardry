<?php

if ($action == 'forest') {

	$user['title'] = 'Темный Лес';
	$user['description'] = 'Вы вошли в Темный Лес.';
	$user['links'] = array();
	$user['links'][0]['title'] = 'Вернуться в город';
	$user['links'][0]['link'] = 'index.php?action=town';	
	
	$res = json_encode($user, JSON_UNESCAPED_UNICODE);

}

?>