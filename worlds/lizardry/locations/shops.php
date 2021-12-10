<?php

if ($action == 'shops') {
	
	$user['title'] = 'Квартал Торговцев';
	if ($user['char_life_cur'] > 0) {
		$user['description'] = '';
	} else shades();
	$user['links'] = array();
	if ($user['char_life_cur'] > 0) {	
		go_to_the_town('Идти на площадь города');
		addlink('Лавка Оружейника', 'index.php?action=shop_weapon', 1);
		addlink('Лавка Бронника', 'index.php?action=shop_armor', 2);
		addlink('Лавка Алхимика', 'index.php?action=shop_alchemy', 3);
	} else go_to_the_graveyard();
	
	$res = json_encode($user, JSON_UNESCAPED_UNICODE);	

}

if ($action == 'shop_armor') {
	
	if ($user['char_life_cur'] <= 0) die('{"error":"Вам сначала нужно вернуться к жизни!"}');

	$user['title'] = '';
	$user['description'] = 'Лавка Бронника';
	$user['mainframe'] = $action;
	$user['links'] = array();
	addlink('Покинуть лавку', 'index.php?action=shops');

		switch ($user['char_region_level']) {
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
	$user['mainframe'] = $action;
	$user['links'] = array();
	addlink('Покинуть лавку', 'index.php?action=shops');

		switch ($user['char_region_level']) {
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

if ($action == 'shop_alchemy') {
	
	if ($user['char_life_cur'] <= 0) die('{"error":"Вам сначала нужно вернуться к жизни!"}');

	$user['title'] = 'Лавка Алхимика';
	$user['description'] = '';
	$user['mainframe'] = $action;
	$user['links'] = array();
	addlink('Покинуть лавку', 'index.php?action=shops');

		switch ($user['char_region_level']) {
			case 1:
				add_item_to_shop(1, 61);
				add_item_to_shop(2, 66);
				add_item_to_shop(3, 71);
				add_item_to_shop(4, 76);
				add_item_to_shop(5, 0);
				add_item_to_shop(6, 0);
				break;
			case 2:
				add_item_to_shop(1, 62);
				add_item_to_shop(2, 67);
				add_item_to_shop(3, 72);
				add_item_to_shop(4, 77);
				add_item_to_shop(5, 0);
				add_item_to_shop(6, 0);
				break;
			case 3:
				add_item_to_shop(1, 63);
				add_item_to_shop(2, 68);
				add_item_to_shop(3, 73);
				add_item_to_shop(4, 78);
				add_item_to_shop(5, 0);
				add_item_to_shop(6, 0);
				break;
			case 4:
				add_item_to_shop(1, 64);
				add_item_to_shop(2, 69);
				add_item_to_shop(3, 74);
				add_item_to_shop(4, 79);
				add_item_to_shop(5, 0);
				add_item_to_shop(6, 0);
				break;
			case 5:
				add_item_to_shop(1, 65);
				add_item_to_shop(2, 70);
				add_item_to_shop(3, 75);
				add_item_to_shop(4, 80);
				add_item_to_shop(5, 0);
				add_item_to_shop(6, 0);
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