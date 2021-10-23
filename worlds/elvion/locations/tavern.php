<?php

if ($action == 'tavern') {

		switch ($user['char_region']) {
			case 1:
				$user['title'] = 'Таверна ""';
				$user['description'] = '';
				break;
			case 2:
				$user['title'] = 'Таверна ""';
				$user['description'] = 'Вы входите в таверну. Здесь шумно и людно. Трактирщик - старый злой гном - то и дело, что успевает материть каждого на чем свет стоит и напоминать, что будет с ними, если кто-то что-то умыкнет. Ясное дело, его никто не слушает. Все столы заняты и любопытных глаз уйма. Можно даже сказать, что каждая пара глаз любопытна и каждого вновь вошедшего встречают хмурым негодованием.';
				break;
			case 3:
				$user['title'] = 'Таверна ""';
				$user['description'] = '';
				break;
			case 4:
				$user['title'] = 'Таверна ""';
				$user['description'] = '';
				break;
			case 5:
				$user['title'] = 'Таверна ""';
				$user['description'] = '';
				break;				
			case 6:
				$user['title'] = 'Таверна ""';
				$user['description'] = '';
				break;				
			case 7:
				$user['title'] = 'Таверна ""';
				$user['description'] = '';
				break;				
			case 8:
				$user['title'] = 'Таверна ""';
				$user['description'] = '';
				break;				
			case 9:
				$user['title'] = 'Таверна ""';
				$user['description'] = '';
				break;				
		}
	$user['frame'] = 'tavern';	
	$user['links'] = array();
	$user['links'][0]['title'] = 'Вернуться в город';
	$user['links'][0]['link'] = 'index.php?action=town';	
	$user['links'][1]['title'] = 'Снять комнату на ночь';
	$user['links'][1]['link'] = 'index.php?action=tavern&do=rest_in_tavern';	
	
	if ($do == 'rest_in_tavern') {
		if ($user['char_gold'] < 15) die('{"error":"Недостаточно денег!"}');
		if (($user['char_life_cur'] == $user['char_life_max'])
			&&($user['char_mana_cur'] == $user['char_mana_max'])) die('{"info":"Вы здоровы и полны сил!"}');
		$user['char_life_cur'] = $user['char_life_max'];
		$user['char_mana_cur'] = $user['char_mana_max'];
		$user['char_gold'] -= 15;
		update_user_table("char_gold=".$user['char_gold'].",char_life_cur=".$user['char_life_cur'].",char_mana_cur=".$user['char_mana_cur']);
		$user['log'] = 'Вы хорошо выспались, совершенно здоровы и полны сил! И у вас высокий боевой дух!';
	}
	
	if ($do == 'buy_food_in_tavern') {
		if ($user['char_food'] >= 7) die('{"error":"У Вас максимальный запас провианта!"}');
		if ($amount <= 0) die('{"error":"Количество сумок с провинтом должно быть больше 0!"}');
		if ($user['char_gold'] < $amount * 10) die('{"error":"Недостаточно денег!"}');
		if ($amount + $user['char_food'] > 7) die('{"error":"Введите правильное число!"}'); 
		$user['char_gold'] -= $amount * 10;
		$user['char_food'] += $amount;
		update_user_table("char_gold=".$user['char_gold'].",char_food=".$user['char_food']);
		$user['log'] = 'Вы купили провизию (+'.$amount.')';
}

	$res = json_encode($user, JSON_UNESCAPED_UNICODE);	
	
}

?>