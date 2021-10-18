<?php

if ($action == 'crypt') {
	
	$user['current_outlands'] = $action;
	$user['enemy_block_refresh'] = 0;

	if ((!isset($user['enemy_block_refresh']))or($user['enemy_block_refresh'] == 0)) {
		$user['enemy_slot_1'] = rand(1, 3);
		$user['enemy_slot_2'] = rand(1, 3);
		$user['enemy_slot_3'] = rand(1, 3);
		$user['enemy_block_refresh'] = 1;
	}
	
	update_user_table("current_outlands='".$user['current_outlands']."',enemy_slot_1=".$user['enemy_slot_1'].",enemy_slot_2=".$user['enemy_slot_2'].",enemy_slot_3=".$user['enemy_slot_3'].",enemy_block_refresh=".$user['enemy_block_refresh']);
	
	$user['title'] = 'Старый Склеп';
	if ($user['char_life_cur'] > 0) {
		$user['description'] = '';
	}else{
		$user['description'] = 'Ваша душа летает над могилами...';
	}
	$user['frame'] = 'outlands';
	$user['links'] = array();
	$user['links'][0]['title'] = 'Вернуться на Кладбище';
	$user['links'][0]['link'] = 'index.php?action=graveyard';
	
	$res = json_encode($user, JSON_UNESCAPED_UNICODE);

}

?>