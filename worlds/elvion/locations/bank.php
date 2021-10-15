<?php

if ($action == 'bank') {
	
	$user['title'] = 'Банк';
	$user['description'] = 'Краткое описание банка.';
	$user['frame'] = 'bank';
	$user['links'] = array();
	$user['links'][0]['title'] = 'Вернуться в город';
	$user['links'][0]['link'] = 'index.php?action=town';	
	
	if ($do == 'deposit') {
		if ($amount <= 0) die('{"error":"Сумма должна быть больше 0!"}');
		if ($amount > $user['char_gold']) die('{"error":"Введите правильную сумму!"}');
		$user['char_gold'] -= $amount;
		$user['char_bank'] += $amount;
		update_user_table("char_gold=".$user['char_gold'].",char_bank=".$user['char_bank']);
		$user['log'] = 'Вы положили в банк '.$amount.' зол. мон.';
	}
	
	if ($do == 'withdraw') {
		if ($amount <= 0) die('{"error":"Сумма должна быть больше 0!"}');
		if ($amount > $user['char_bank']) die('{"error":"Введите правильную сумму!"}');
		$user['char_gold'] += $amount;
		$user['char_bank'] -= $amount;
		update_user_table("char_gold=".$user['char_gold'].",char_bank=".$user['char_bank']);
		$user['log'] = 'Вы забрали из банка '.$amount.' зол. мон.';
	}
	
	$res = json_encode($user, JSON_UNESCAPED_UNICODE);	

}

?>