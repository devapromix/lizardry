<?php

if ($action == 'shops') {
	
	$user['title'] = 'Квартал Торговцев';
	if ($user['char_life_cur'] > 0) {
		$user['description'] = '';
	}else{
		$user['description'] = 'Ваша душа летает над городом.';
	}
	$user['links'] = array();
	if ($user['char_life_cur'] > 0) {	
		$user['links'][0]['title'] = 'На площадь города';
		$user['links'][0]['link'] = 'index.php?action=town';
		$user['links'][1]['title'] = 'Лавка Бронника';
		$user['links'][1]['link'] = 'index.php?action=shop_armor';
	} else {
		$user['links'][0]['title'] = 'Городское Кладбище';
		$user['links'][0]['link'] = 'index.php?action=graveyard';
	}
	
	$res = json_encode($user, JSON_UNESCAPED_UNICODE);	

}

if ($action == 'shop_armor') {
	
	if ($user['char_life_cur'] <= 0) die('{"error":"Вам сначала нужно вернуться к жизни!"}');

	$user['title'] = 'Лавка Бронника';
	$user['description'] = '';
	$user['mainframe'] = 'shop_armor';
	$user['links'] = array();
	$user['links'][0]['title'] = 'Покинуть лавку';
	$user['links'][0]['link'] = 'index.php?action=shops';

	add_item(1, 5);
	add_item(2, 4);
	add_item(3, 3);
	add_item(4, 2);
	add_item(5, 1);

	if ($do == 'buy') {
		if ($itemslot == '1')
			equip_item($user['item_slot_1']);
		if ($itemslot == '2')
			equip_item($user['item_slot_2']);
		if ($itemslot == '3')
			equip_item($user['item_slot_3']);
		if ($itemslot == '4')
			equip_item($user['item_slot_4']);
		if ($itemslot == '5')
			equip_item($user['item_slot_5']);
	}

	$res = json_encode($user, JSON_UNESCAPED_UNICODE);	

}

?>