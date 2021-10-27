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
		$user['links'][1]['title'] = 'Лавка Оружейника';
		$user['links'][1]['link'] = 'index.php?action=shop_weapon';
		$user['links'][2]['title'] = 'Лавка Бронника';
		$user['links'][2]['link'] = 'index.php?action=shop_armor';
	} else {
		$user['links'][0]['title'] = 'Городское Кладбище';
		$user['links'][0]['link'] = 'index.php?action=graveyard';
	}
	
	$res = json_encode($user, JSON_UNESCAPED_UNICODE);	

}

if ($action == 'shop_armor') {
	
	if ($user['char_life_cur'] <= 0) die('{"error":"Вам сначала нужно вернуться к жизни!"}');

	$user['title'] = '';
	$user['description'] = 'Лавка Бронника';
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
			case 5:
				add_item_to_shop(1, 25);
				add_item_to_shop(2, 26);
				add_item_to_shop(3, 27);
				add_item_to_shop(4, 28);
				add_item_to_shop(5, 29);
				add_item_to_shop(6, 30);
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

if ($action == 'shop_weapon') {
	
	if ($user['char_life_cur'] <= 0) die('{"error":"Вам сначала нужно вернуться к жизни!"}');

	$user['title'] = 'Оружейная Лавка';
	$user['description'] = '';
	$user['mainframe'] = 'shop_weapon';
	$user['links'] = array();
	$user['links'][0]['title'] = 'Покинуть лавку';
	$user['links'][0]['link'] = 'index.php?action=shops';

		switch ($user['char_region']) {
			case 1:
				add_item_to_shop(1, 31);
				add_item_to_shop(2, 32);
				add_item_to_shop(3, 33);
				add_item_to_shop(4, 34);
				add_item_to_shop(5, 35);
				add_item_to_shop(6, 36);
				break;
			case 2:
				add_item_to_shop(1, 37);
				add_item_to_shop(2, 38);
				add_item_to_shop(3, 39);
				add_item_to_shop(4, 40);
				add_item_to_shop(5, 41);
				add_item_to_shop(6, 42);
				break;
			case 3:
				add_item_to_shop(1, 43);
				add_item_to_shop(2, 44);
				add_item_to_shop(3, 45);
				add_item_to_shop(4, 46);
				add_item_to_shop(5, 47);
				add_item_to_shop(6, 48);
				break;
			case 4:
				add_item_to_shop(1, 49);
				add_item_to_shop(2, 50);
				add_item_to_shop(3, 51);
				add_item_to_shop(4, 52);
				add_item_to_shop(5, 53);
				add_item_to_shop(6, 54);
				break;
			case 5:
				add_item_to_shop(1, 55);
				add_item_to_shop(2, 56);
				add_item_to_shop(3, 57);
				add_item_to_shop(4, 58);
				add_item_to_shop(5, 59);
				add_item_to_shop(6, 60);
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