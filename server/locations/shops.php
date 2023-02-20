<?php

if ($action == 'shops') {
	
	$user['title'] = 'Квартал Торговцев';
	if ($user['char_life_cur'] > 0) {
		$user['description'] = 'Вы спускаетесь в ту часть города, где много различных лавок и магазинов. Здесь тихо и уютно.';
	} else $user['class']['location']->shades();
	$user['links'] = array();
	if ($user['char_life_cur'] > 0) {	
		$user['class']['location']->go_to_the_town('Идти на площадь города');
		Location::addlink('Лавка Оружейника', 'index.php?action=shop_weapon', 1);
		Location::addlink('Лавка Бронника', 'index.php?action=shop_armor', 2);
		Location::addlink('Лавка Алхимика', 'index.php?action=shop_alchemy', 3);
	} else $user['class']['location']->go_to_the_graveyard();
	
	$res = json_encode($user, JSON_UNESCAPED_UNICODE);	

}

if ($action == 'shop_armor') {
	
	if ($user['char_life_cur'] <= 0) die('{"error":"Вам сначала нужно вернуться к жизни!"}');

	$user['title'] = 'Лавка Бронника';
	if ($user['char_life_cur'] > 0) {
		$user['description'] = $user['class']['location']->get_welcome_phrase(Location::SHOP_ARMOR);
	} else $user['class']['location']->shades();	
	$user['mainframe'] = $action;
	$user['links'] = array();
	Location::addlink('Покинуть лавку', 'index.php?action=shops');

	$current = ($user['char_region_level'] - 1) * 6;
	for ($i = 1; $i <= 6; $i++)
		$user['class']['item']->add_item_to_shop($i, $current + $i);

	if (($do == 'buy') && ($itemslot >= '1') && ($itemslot <= '6'))
			$user['class']['item']->equip_item($user['item_slot_'.strval($itemslot)]);

	$res = json_encode($user, JSON_UNESCAPED_UNICODE);	

}

if ($action == 'shop_weapon') {
	
	if ($user['char_life_cur'] <= 0) die('{"error":"Вам сначала нужно вернуться к жизни!"}');

	$user['title'] = 'Оружейная Лавка';
	if ($user['char_life_cur'] > 0) {
		$user['description'] = $user['class']['location']->get_welcome_phrase(Location::SHOP_WEAPON);
	} else $user['class']['location']->shades();	
	$user['mainframe'] = $action;
	$user['links'] = array();
	Location::addlink('Покинуть лавку', 'index.php?action=shops');

	$current = ($user['char_region_level'] - 1) * 6;
	for ($i = 1; $i <= 6; $i++)
		$user['class']['item']->add_item_to_shop($i, $current + $i + 300);

	if (($do == 'buy') && ($itemslot >= '1') && ($itemslot <= '6'))
			$user['class']['item']->equip_item($user['item_slot_'.strval($itemslot)]);

	$res = json_encode($user, JSON_UNESCAPED_UNICODE);	

}

if ($action == 'shop_alchemy') {
	
	if ($user['char_life_cur'] <= 0) die('{"error":"Вам сначала нужно вернуться к жизни!"}');

	$user['title'] = 'Лавка Алхимика';
	if ($user['char_life_cur'] > 0) {
		$user['description'] = $user['class']['location']->get_welcome_phrase(Location::SHOP_ALCHEMY);
	} else $user['class']['location']->shades();	
	$user['mainframe'] = $action;
	$user['links'] = array();
	Location::addlink('Покинуть лавку', 'index.php?action=shops');

	$user['class']['item']->add_item_to_shop(1, 601);
	$user['class']['item']->add_item_to_shop(2, 602);
	$user['class']['item']->add_item_to_shop(3, 603);
	$user['class']['item']->add_item_to_shop(4, 604);
	$user['class']['item']->add_item_to_shop(5, 605);
	$user['class']['item']->add_item_to_shop(6, 606);

	if (($do == 'buy') && ($itemslot >= '1') && ($itemslot <= '6'))
			$user['class']['item']->equip_item($user['item_slot_'.strval($itemslot)], $amount);

	$res = json_encode($user, JSON_UNESCAPED_UNICODE);	

}

if ($action == 'shop_magic') {
	
	if ($user['char_life_cur'] <= 0) die('{"error":"Вам сначала нужно вернуться к жизни!"}');

	$user['title'] = 'Магическая Лавка';
	if ($user['char_life_cur'] > 0) {
		$user['description'] = $user['class']['location']->get_welcome_phrase(Location::SHOP_MAGIC);
	} else $user['class']['location']->shades();	
	$user['mainframe'] = $action;
	$user['links'] = array();
	Location::addlink('Покинуть лавку', 'index.php?action=magictower');

	$user['class']['item']->add_item_to_shop(1, 701);
	$user['class']['item']->add_item_to_shop(2, 702);
	$user['class']['item']->add_item_to_shop(3, 703);
	$user['class']['item']->add_item_to_shop(4, 704);
	$user['class']['item']->add_item_to_shop(5, 705);
	$user['class']['item']->add_item_to_shop(6, 706);

	if (($do == 'buy') && ($itemslot >= '1') && ($itemslot <= '6'))
			$user['class']['item']->equip_item($user['item_slot_'.strval($itemslot)], $amount);

	$res = json_encode($user, JSON_UNESCAPED_UNICODE);	

}

if ($action == 'black_market') {
	
	if ($user['char_life_cur'] <= 0) die('{"error":"Вам сначала нужно вернуться к жизни!"}');

	$user['title'] = 'Черный Рынок';
	if ($user['char_life_cur'] > 0) {
		$user['description'] = $user['class']['location']->get_welcome_phrase(Location::SHOP_MAGIC);
	} else $user['class']['location']->shades();	
	$user['mainframe'] = $action;	
	$user['links'] = array();
	Location::addlink('Покинуть рынок', 'index.php?action=denofthieves');

	$user['class']['item']->add_item_to_shop(1, 951);


	if (($do == 'buy') && ($itemslot >= '1') && ($itemslot <= '6'))
			$user['class']['item']->equip_item($user['item_slot_'.strval($itemslot)], $amount);

	$res = json_encode($user, JSON_UNESCAPED_UNICODE);	

}

?>