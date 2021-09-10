<?php

if ($action == 'bank') {
	
	$a = array();
	$a['title'] = 'Банк';
	$a['description'] = 'Краткое описание банка. Золото в банке: '.$char_bank;
	$a['links'] = array();
	$a['links'][0]['title'] = 'Вернуться в город';
	$a['links'][0]['link'] = 'index.php?action=town';	
	
	$res = json_encode($a, JSON_UNESCAPED_UNICODE);	

}

?>