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
		$user['links'][0]['title'] = 'Автобой!';
		$user['links'][0]['link'] = 'index.php?action=auto_battle';
		$n++;
	}
	$user['links'][$n]['title'] = 'Назад';
	$user['links'][$n]['link'] = 'index.php?action='.$user['current_outlands'];
	
	$user['battlelog'] = '';

	$res = json_encode($user, JSON_UNESCAPED_UNICODE);

}

?>