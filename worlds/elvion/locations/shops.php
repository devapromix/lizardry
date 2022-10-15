<?php

if ($action == 'shops') {
	
	$user['title'] = 'Квартал Торговцев';
	if ($user['char_life_cur'] > 0) {
		$user['description'] = '';
	} else $location->shades();
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

	$user['title'] = 'Лавка Бронника';
	$user['description'] = '';
	$user['mainframe'] = $action;
	$user['links'] = array();
	addlink('Покинуть лавку', 'index.php?action=shops');

	$current = ($user['char_region_level'] - 1) * 6;
	for ($i = 1; $i <= 6; $i++)
		add_item_to_shop($i, $current + $i);

	if (($do == 'buy') && ($itemslot >= '1') && ($itemslot <= '6'))
			equip_item($user['item_slot_'.strval($itemslot)]);

	$res = json_encode($user, JSON_UNESCAPED_UNICODE);	

}

if ($action == 'shop_weapon') {
	
	if ($user['char_life_cur'] <= 0) die('{"error":"Вам сначала нужно вернуться к жизни!"}');

	$user['title'] = 'Оружейная Лавка';
	$user['description'] = '';
	$user['mainframe'] = $action;
	$user['links'] = array();
	addlink('Покинуть лавку', 'index.php?action=shops');

	$current = ($user['char_region_level'] - 1) * 6;
	for ($i = 1; $i <= 6; $i++)
		add_item_to_shop($i, $current + $i + 300);

	if (($do == 'buy') && ($itemslot >= '1') && ($itemslot <= '6'))
			equip_item($user['item_slot_'.strval($itemslot)]);

	$res = json_encode($user, JSON_UNESCAPED_UNICODE);	

}

if ($action == 'shop_alchemy') {
	
	if ($user['char_life_cur'] <= 0) die('{"error":"Вам сначала нужно вернуться к жизни!"}');

	$user['title'] = 'Лавка Алхимика';
	$user['description'] = '';
	$user['mainframe'] = $action;
	$user['links'] = array();
	addlink('Покинуть лавку', 'index.php?action=shops');

	add_item_to_shop(1, 601);
	add_item_to_shop(2, 602);
	add_item_to_shop(3, 603);
	add_item_to_shop(4, 604);
	add_item_to_shop(5, 0);
	add_item_to_shop(6, 0);

	if (($do == 'buy') && ($itemslot >= '1') && ($itemslot <= '6'))
			equip_item($user['item_slot_'.strval($itemslot)]);

	$res = json_encode($user, JSON_UNESCAPED_UNICODE);	

}

if ($action == 'shop_magic') {
	
	if ($user['char_life_cur'] <= 0) die('{"error":"Вам сначала нужно вернуться к жизни!"}');

	$user['title'] = 'Магическая Лавка';
	$user['description'] = '';
	$user['mainframe'] = $action;
	$user['links'] = array();
	addlink('Покинуть лавку', 'index.php?action=magictower');

	add_item_to_shop(1, 701);
	add_item_to_shop(2, 702);
	add_item_to_shop(3, 0);
	add_item_to_shop(4, 0);
	add_item_to_shop(5, 0);
	add_item_to_shop(6, 0);

	if (($do == 'buy') && ($itemslot >= '1') && ($itemslot <= '6'))
			equip_item($user['item_slot_'.strval($itemslot)]);

	$res = json_encode($user, JSON_UNESCAPED_UNICODE);	

}

?>