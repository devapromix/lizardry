<?php

if ($action == 'forest') {

	$a = array();
	$a['title'] = 'Темный Лес';
	$a['description'] = 'Вы вошли в Темный Лес.';
	$a['links'] = array();
	$a['links'][0]['title'] = 'Вернуться в город';
	$a['links'][0]['link'] = 'index.php?action=town';	
	
	$res = json_encode($a, JSON_UNESCAPED_UNICODE);

}

?>