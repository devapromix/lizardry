<?php

if ($action == 'forest') {
	
	$user['current_outlands'] = 'forest';
	$user['enemy_block_refresh'] = 0;

	if ((!isset($user['enemy_block_refresh']))or($user['enemy_block_refresh'] == 0)) {
		$user['enemy_slot_1'] = rand(1, 3);
		$user['enemy_slot_2'] = rand(1, 3);
		$user['enemy_slot_3'] = rand(1, 3);
		$user['enemy_block_refresh'] = 1;
		gen_enemy(1);
		save_character();
	}
	
	$user['title'] = 'Темный Лес';
	if ($user['char_life_cur'] > 0) {
		$user['description'] = 'Темный Лес раскинулся на востоке от города. Его странность была отмечена первыми поселенцами и привела к возникновению этого названия. Дело в том, что в любое время года, днем и ночью, в пределах леса царит странная тьма. Ночью густой непроницаемый туман затягивает лесные тропы, днем серая хмарь скрывает над ним свет солнца. Осенью горы опавшей листы укрывают толстым ковром подножия деревьев – этих старых исполинов, царапающих кривыми ветвями воздух.';
	}else{
		$user['description'] = 'Ваша душа летает над деревьями в Темном Лесу...';
	}
	$user['frame'] = 'outlands';
	$user['links'] = array();
	if ($user['char_life_cur'] > 0) {
		$user['links'][0]['title'] = 'Идти в сторону города';
		$user['links'][0]['link'] = 'index.php?action=gate';	
		$user['links'][1]['title'] = 'Осмотреть Серую Пещеру';
		$user['links'][1]['link'] = 'index.php?action=graycave';	
	} else {
		$user['links'][0]['title'] = 'Отправиться на кладбище';
		$user['links'][0]['link'] = 'index.php?action=graveyard';
	}

	$res = json_encode($user, JSON_UNESCAPED_UNICODE);

}

?>