<?php

if ($action == 'battle') {

	if ($enemyslot == '1')
		gen_enemy($user['enemy_slot_1']);
	if ($enemyslot == '2')
		gen_enemy($user['enemy_slot_2']);
	if ($enemyslot == '3')
		gen_enemy($user['enemy_slot_3']);

	$user['title'] = 'Сражение!!!';
	$user['mainframe'] = 'outlands';
	$user['links'] = array();
	$n = 0;
	if ($user['char_life_cur'] > 0) {
		addlink('Автобой!', 'index.php?action=battle&do=auto_battle');
		$n++;
	}
	addlink('Назад', 'index.php?action='.$user['current_outlands'], $n);
	
	$user['battlelog'] = '';
	
	if ($do == 'auto_battle') {

		$user['title'] = 'Сражение!!!';
		$user['mainframe'] = 'outlands';
		$user['battlelog'] = auto_battle();
		$user['links'] = array();
		addlink('Покинуть поле боя', 'index.php?action='.$user['current_outlands']);
		if ($user['loot_slot_1'] > 0) {
			switch($user['loot_slot_1_type']) {
				case 1:
					$m = 'Взять оружие!';
					break;
				case 8: case 9: case 10: case 11: case 12: case 13:
					$m = 'Взять эликсир!';
					break;
				case 21:
					$m = 'Взять трофей!';
					break;
				default:
					$m = 'Надеть броню!';
			}
			addlink($m, 'index.php?action=pickup_loot&lootslot=1', 1);
		}
		update_user_table("enemy_name='',enemy_image='',char_life_cur=".$user['char_life_cur'].",char_mana_cur=".$user['char_mana_cur'].",char_exp=".$user['char_exp'].",char_gold=".$user['char_gold'].",enemy_life_cur=".$user['enemy_life_cur'].",stat_kills=".$user['stat_kills'].",stat_deads=".$user['stat_deads']);
//		if ($user['loot_slot_1'] > 0)
//			$user['frame'] = 'loot';

	}
	
	$res = json_encode($user, JSON_UNESCAPED_UNICODE);

}

?>