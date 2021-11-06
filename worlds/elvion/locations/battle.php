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
		$user['links'] = array();
		addlink('Покинуть поле боя', 'index.php?action='.$user['current_outlands']);
		$user['battlelog'] = auto_battle();
		update_user_table("enemy_name='',enemy_image='',char_life_cur=".$user['char_life_cur'].",char_mana_cur=".$user['char_mana_cur'].",char_exp=".$user['char_exp'].",char_gold=".$user['char_gold'].",enemy_life_cur=".$user['enemy_life_cur'].",stat_kills=".$user['stat_kills'].",stat_deads=".$user['stat_deads']);

	}
	
	$res = json_encode($user, JSON_UNESCAPED_UNICODE);

}

?>