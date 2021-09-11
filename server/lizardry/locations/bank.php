<?php

if ($action == 'bank') {
	
	$user['title'] = 'Банк';
	$user['description'] = 'Краткое описание банка.';
	$user['refresh'] = 'no_refresh';
	$user['frame'] = 'bank';
	$user['links'] = array();
	$user['links'][0]['title'] = 'Вернуться в город';
	$user['links'][0]['link'] = 'index.php?action=town';	
	$user['links'][1]['title'] = 'Положить 100 золотых';
	$user['links'][1]['link'] = 'index.php?action=deposit&amount=100';	
	
	$res = json_encode($user, JSON_UNESCAPED_UNICODE);	

}

if ($action == 'deposit') {
	
	//if ($amount <= 0)
	//	die({"error":"Число должно быть больше 0!"});
	//if ($amount > $user['char_gold'])
	//	die({"error":"У Вас нет столько золота!"});

	$user['char_gold'] -= $amount;
	$user['char_bank'] += $amount;

	save_character();

	$user['title'] = 'Банк';
	$user['description'] = 'Краткое описание банка.';
	$user['frame'] = 'bank';
	$user['links'] = array();
	$user['links'][0]['title'] = 'Вернуться в город';
	$user['links'][0]['link'] = 'index.php?action=town';	
		
	$res = json_encode($user, JSON_UNESCAPED_UNICODE);	

}

?>