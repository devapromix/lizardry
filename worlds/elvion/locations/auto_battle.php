<?php

if ($action == 'auto_battle') {

	$user['title'] = 'Сражение!!!';
	$user['mainframe'] = 'outlands';
	$user['links'] = array();
	$user['links'][0]['title'] = 'Покинуть поле боя';
	$user['links'][0]['link'] = 'index.php?action='.$user['current_outlands'];
	$user['battlelog'] = auto_battle();	
		
	update_user_table("enemy_name='',enemy_image='',char_life_cur=".$user['char_life_cur'].",char_exp=".$user['char_exp'].",char_gold=".$user['char_gold'].",enemy_life_cur=".$user['enemy_life_cur'].",stat_kills=".$user['stat_kills'].",stat_deads=".$user['stat_deads']);

	$res = json_encode($user, JSON_UNESCAPED_UNICODE);

}

?>