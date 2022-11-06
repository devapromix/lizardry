<?php

if ($action == 'tavern') {

	$user['title'] = 'Таверна "'.$user['class']['location']->get_tavern_name().'"';
	if ($user['char_life_cur'] > 0) {
		$user['description'] = $user['class']['location']->get_welcome_phrase(Location::TAVERN, false);
	} else $user['class']['location']->shades();	
	$user['mainframe'] = $action;
	$user['frame'] = 'tavern';	
	$user['links'] = array();
	$user['class']['location']->go_to_the_town();
	Location::addlink('Снять комнату на ночь', 'index.php?action=tavern&do=rest_in_tavern', 1);
	
	$user['class']['item']->add_item_to_shop(1, $user['char_region_level'] + 940);
	$user['class']['item']->add_item_to_shop(2, 0);
	$user['class']['item']->add_item_to_shop(3, 0);
	$user['class']['item']->add_item_to_shop(4, 0);
	$user['class']['item']->add_item_to_shop(5, 0);
	$user['class']['item']->add_item_to_shop(6, 0);

	if (($do == 'buy') && ($itemslot >= '1') && ($itemslot <= '6'))
			$user['class']['item']->equip_item($user['item_slot_'.strval($itemslot)], $amount);

	if ($do == 'rest_in_tavern') {
		if ($user['char_life_cur'] <= 0) die('{"error":"Вам сначала нужно вернуться к жизни!"}');
		if ($user['char_gold'] < $user['class']['location']->rest_in_tavern_cost()) die('{"error":"Не достаточно золота!"}');
		if (($user['char_life_cur'] == $user['char_life_max'])
			&&($user['char_mana_cur'] == $user['char_mana_max'])) die('{"info":"Вы здоровы и полны сил!"}');
		$user['char_life_cur'] = $user['char_life_max'];
		$user['char_mana_cur'] = $user['char_mana_max'];
		$user['char_gold'] -= $user['class']['location']->rest_in_tavern_cost();
		User::update("char_gold=".$user['char_gold'].",char_life_cur=".$user['char_life_cur'].",char_mana_cur=".$user['char_mana_cur']);
		$user['log'] = 'Вы хорошо выспались, совершенно здоровы и полны сил! И у вас высокий боевой дух!';
	}
	
	if ($do == 'buy_food_in_tavern') {
		if ($user['char_life_cur'] <= 0) die('{"error":"Вам сначала нужно вернуться к жизни!"}');
		if ($user['char_food'] >= 7) die('{"info":"У Вас максимальный запас провианта!"}');
		if ($amount <= 0) die('{"error":"Количество сумок с провиaнтом должно быть больше 0!"}');
		if ($user['char_gold'] < $amount * $user['class']['location']->food_in_tavern_cost()) die('{"error":"Не достаточно золота!"}');
		if ($amount + $user['char_food'] > 7) die('{"error":"Введите правильное число!"}'); 
		$user['char_gold'] -= $amount * $user['class']['location']->food_in_tavern_cost();
		$user['char_food'] += $amount;
		User::update("char_gold=".$user['char_gold'].",char_food=".$user['char_food']);
		$user['log'] = 'Вы купили провизию (+'.$amount.')';
	}

	$res = json_encode($user, JSON_UNESCAPED_UNICODE);	
	
}

?>