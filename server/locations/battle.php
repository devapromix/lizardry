<?php

if ($action == 'battle') {
	
	if ($user['char_life_cur'] <= 0) 
		die('{"error":"Вам сначала нужно вернуться к жизни!"}');
	
	if ($enemyslot == '1')
		Enemy::gen($user['enemy_slot_1'], $user['enemy_slot_1_elite']);
	if ($enemyslot == '2')
		Enemy::gen($user['enemy_slot_2'], $user['enemy_slot_2_elite']);
	if ($enemyslot == '3')
		Enemy::gen($user['enemy_slot_3'], $user['enemy_slot_3_elite']);

	if ($user['enemy_level'] < 1)
		die('{"error":"Вам нужен живой враг!"}');

	$user['title'] = 'Сражение!!!';
	$user['mainframe'] = 'outlands';
	if ($user['char_life_cur'] > 0)
		$user['frame'] = 'before_battle';
	else
		$user['frame'] = 'battle';
	$user['links'] = array();
	$n = 0;
	if ($user['char_life_cur'] > 0) {
		Location::addlink('Автобой!', 'index.php?action=battle&do=auto_battle');
		$n++;
	}
	Location::addlink('Назад', 'index.php?action='.$user['current_outlands'], $n);
	
	$user['battlelog'] = '';
	
	if ($do == 'auto_battle') {

		$user['title'] = 'Сражение!!!';
		$user['mainframe'] = 'outlands';
		$user['frame'] = $action;
		$user['class']['battle']->start_battle();
		$user['links'] = array();
		Location::addlink('Покинуть поле боя', 'index.php?action='.$user['current_outlands']);
		if ($user['loot_slot_1'] > 0) {
			$user['frame'] = 'get_loot';
			Location::pickup_link();
		} else if ($user['current_random_place'] > 0) {
			$user['frame'] = 'get_random_place';
			Location::addlink('Осмотреть локацию', 'index.php?action=random_place', 1);
		}
		User::update("enemy_name='',enemy_image='',char_life_cur=".$user['char_life_cur'].",char_mana_cur=".$user['char_mana_cur'].",char_exp=".$user['char_exp'].",char_gold=".$user['char_gold'].",enemy_life_cur=".$user['enemy_life_cur'].",stat_kills=".$user['stat_kills'].",stat_boss_kills=".$user['stat_boss_kills'].",stat_deads=".$user['stat_deads'].",char_effects='".$user['char_effects']."'");

	}
	
	$res = json_encode($user, JSON_UNESCAPED_UNICODE);

}

if ($action == 'pickup_loot') {

	$user['title'] = 'Находка!';
	$user['description'] = $user['class']['item']->pickup_equip_item();
	$user['frame'] = 'battle';
	Location::addlink('Назад', 'index.php?action='.$user['current_outlands']);
	$res = json_encode($user, JSON_UNESCAPED_UNICODE);

}

if ($action == 'pickup_all_loot') {

	$user['title'] = 'Находка!!!';
	$user['description'] = $user['class']['item']->pickup_all();
	$user['frame'] = 'battle';
	Location::addlink('Назад', 'index.php?action='.$user['current_outlands']);
	$res = json_encode($user, JSON_UNESCAPED_UNICODE);

}

if ($action == 'use_item') {

	$h = '';
	if ($itemindex > 0) {
		$item_ident = $user['class']['item']->item_ident_by_index($itemindex);
		if (($item_ident > 0)&&($user['class']['item']->has_item($item_ident))){
			$h = $user['class']['item']->use_item($item_ident);
		}
	}
	$res = '{"inventory":'.json_encode($user['char_inventory'], JSON_UNESCAPED_UNICODE).$h.'}';

}

if ($action == 'random_place') {

	$user['frame'] = $user['class']['location']->random_place();
	$res = json_encode($user, JSON_UNESCAPED_UNICODE);
	
}

?>