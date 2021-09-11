<?php

if ($action == 'tavern') {
	
	$user['title'] = 'Таверна';
	$user['description'] = 'Вы вошли в Таверну.';
	$user['frame'] = 'tavern';	
	$user['links'] = array();
	$user['links'][0]['title'] = 'Вернуться в город';
	$user['links'][0]['link'] = 'index.php?action=town';	
	$user['links'][1]['title'] = 'Снять комнату на ночь';
	$user['links'][1]['link'] = 'index.php?action=tavern&do=rest_in_tavern';	
	
	if ($do == 'rest_in_tavern') {
		if ($user['char_gold'] <= 10) die('{"error":"Недостаточно денег!"}');
		if (($user['char_life_cur'] == $user['char_life_max'])
			&&($user['char_mana_cur'] == $user['char_mana_max'])) die('{"info":"Вы здоровы и полны сил!"}');
		$user['char_life_cur'] = $user['char_life_max'];
		$user['char_mana_cur'] = $user['char_mana_max'];
		$user['char_gold'] -= 10;
		save_character();
		
	}
	if ($do == 'buy_food_in_tavern') {
		if ($amount <= 0) die('{"error":"Количество сумок с провинтом должно быть больше 0!"}');
		if ($user['char_food'] >= 7) die('{"error":"У Вас максимальный запас провианта!"}');
		if ($user['char_gold'] < $amount * 10) die('{"error":"Недостаточно денег!"}');
		if ($amount + $user['char_food'] > 7) die('{"error":"Введите правильное число!"}'); 
		$user['char_gold'] -= $amount * 10;
		$user['char_food'] += $amount;
		save_character();
}
	$res = json_encode($user, JSON_UNESCAPED_UNICODE);	

}

?>