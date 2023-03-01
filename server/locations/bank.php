<?php

if ($action == 'bank') {
	
	$user['title'] = 'Банк';
	if ($user['char_life_cur'] > 0) {
		$user['description'] = $user['class']['location']->get_welcome_phrase(Location::BANK, false);
	} else $user['class']['location']->shades();	
	$user['frame'] = 'bank';
	$user['links'] = array();
	$user['class']['location']->go_to_the_town();
	
	if ($do == 'deposit') {
		if ($user['char_life_cur'] <= 0) die('{"error":"Вам сначала нужно вернуться к жизни!"}');
		if ($amount <= 0) die('{"error":"Сумма должна быть больше 0!"}');
		if ($amount > $user['char_gold']) die('{"error":"Введите правильную сумму!"}');
		$user['char_gold'] -= $amount;
		$user['char_bank'] += $amount;
		User::update("char_gold=".$user['char_gold'].",char_bank=".$user['char_bank']);
		$user['log'] = 'Вы положили в банк '.$amount.' золота.';
	}
	
	if ($do == 'withdraw') {
		if ($user['char_life_cur'] <= 0) die('{"error":"Вам сначала нужно вернуться к жизни!"}');
		if ($amount <= 0) die('{"error":"Сумма должна быть больше 0!"}');
		if ($amount > $user['char_bank']) die('{"error":"Введите правильную сумму!"}');
		$user['char_gold'] += $amount;
		$user['char_bank'] -= $amount;
		User::update("char_gold=".$user['char_gold'].",char_bank=".$user['char_bank']);
		$user['log'] = 'Вы забрали из банка '.$amount.' золота.';
	}
	
	$res = json_encode($user, JSON_UNESCAPED_UNICODE);	

}

?>