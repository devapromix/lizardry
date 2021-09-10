<?php

if ($action == 'bank') {
	
	$user['title'] = 'Банк';
	$user['description'] = 'Краткое описание банка. Золото в банке: '.$char_bank;
	$user['links'] = array();
	$user['links'][0]['title'] = 'Вернуться в город';
	$user['links'][0]['link'] = 'index.php?action=town';	
	
	$res = json_encode($user, JSON_UNESCAPED_UNICODE);	

}

?>