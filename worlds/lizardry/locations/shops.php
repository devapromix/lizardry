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

		switch ($user['char_region']) {
			case 1:
				add_item_to_shop(1, 1);
				add_item_to_shop(2, 2);
				add_item_to_shop(3, 3);
				add_item_to_shop(4, 4);
				add_item_to_shop(5, 5);
				add_item_to_shop(6, 6);
				break;
			case 2:
				add_item_to_shop(1, 7);
				add_item_to_shop(2, 8);
				add_item_to_shop(3, 9);
				add_item_to_shop(4, 10);
				add_item_to_shop(5, 11);
				add_item_to_shop(6, 12);
				break;
			case 3:
				add_item_to_shop(1, 13);
				add_item_to_shop(2, 14);
				add_item_to_shop(3, 15);
				add_item_to_shop(4, 16);
				add_item_to_shop(5, 17);
				add_item_to_shop(6, 18);
				break;
			case 4:
				add_item_to_shop(1, 19);
				add_item_to_shop(2, 20);
				add_item_to_shop(3, 21);
				add_item_to_shop(4, 22);
				add_item_to_shop(5, 23);
				add_item_to_shop(6, 24);
				break;
		}

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
		if ($itemslot == '6')
			equip_item($user['item_slot_6']);
	}

	$res = json_encode($user, JSON_UNESCAPED_UNICODE);	

}

?>