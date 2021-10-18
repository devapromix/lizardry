<?php

if ($action == 'battle') {

	if ($enemyslot == '1')
		gen_enemy($user['enemy_slot_1']);
	if ($enemyslot == '2')
		gen_enemy($user['enemy_slot_2']);
	if ($enemyslot == '3')
		gen_enemy($user['enemy_slot_3']);

	$user['title'] = 'Сражение!!! '.$user['enemy_exp'];
	$user['mainframe'] = 'outlands';
	$user['links'] = array();
	$n = 0;
	if ($user['char_life_cur'] > 0) {
		$user['links'][0]['title'] = 'Автобой!';
		$user['links'][0]['link'] = 'index.php?action=battle&do=auto_battle';
		$n++;
	}
	$user['links'][$n]['title'] = 'Назад';
	$user['links'][$n]['link'] = 'index.php?action='.$user['current_outlands'];
	
	$user['battlelog'] = '';

	if ($do == 'auto_battle') {
		$user['title'] = 'Сражение!!!';
		$user['mainframe'] = 'outlands';
		$user['links'] = array();
		$user['links'][0]['title'] = 'Покинуть поле боя';
		$user['links'][0]['link'] = 'index.php?action='.$user['current_outlands'];
		$user['battlelog'] = auto_battle();	
		$user['enemy_block_refresh'] = 0;
			
		update_user_table("enemy_block_refresh=".$user['enemy_block_refresh'].",char_life_cur=".$user['char_life_cur'].",char_exp=".$user['char_exp'].",char_gold=".$user['char_gold'].",enemy_life_cur=".$user['enemy_life_cur'].",stat_kills=".$user['stat_kills'].",stat_deads=".$user['stat_deads']);
	
	}

	$res = json_encode($user, JSON_UNESCAPED_UNICODE);

}

?>