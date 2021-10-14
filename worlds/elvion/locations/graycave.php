<?php

if ($action == 'graycave') {

	$user['enemy_block_refresh'] = 0;

	if ((!isset($user['enemy_block_refresh']))or($user['enemy_block_refresh'] == 0)) {
		$user['enemy_slot_1'] = rand(4, 6);
		$user['enemy_slot_2'] = rand(4, 6);
		$user['enemy_slot_3'] = rand(4, 6);
		$user['enemy_block_refresh'] = 1;
		save_character();
	}

	$user['title'] = 'Серая Пещера';
	if ($user['char_life_cur'] > 0) {
		$user['description'] = 'Весьма мрачная пещера, которая состоит из двух частей. Первая часть, что находится рядом со входом - это мелкий водоём, из которого выглядывают небольшие валуны и целые глыбы. Вторая же - каменный просторный зал, в дальнем конце которого темнеет вход в мрачные глубины подземелья. Единственным источником освещения здесь является щель в каменном своде.';
	}else{
		$user['description'] = 'Ваша душа взмыла ввысь над валунами...';
	}
	$user['frame'] = 'outlands';
	$user['links'] = array();
	if ($user['char_life_cur'] > 0) {
		$user['links'][0]['title'] = 'Искать выход из пещеры';
		$user['links'][0]['link'] = 'index.php?action=forest';	
	} else {
		$user['links'][0]['title'] = 'Отправиться на кладбище';
		$user['links'][0]['link'] = 'index.php?action=graveyard';
	}

	if ($do == 'rest_in_outlands') {
		if ($user['char_life_cur'] <= 0) die('{"error":"Вам сначала нужно вернуться к жизни!"}');
		if ($user['char_food'] <= 0) die('{"error":"Вы не можете здесь отдыхать - нет провизии!"}');
		if (($user['char_life_cur'] == $user['char_life_max'])
			&&($user['char_mana_cur'] == $user['char_mana_max'])) die('{"info":"Вам незачем отдыхать - вы здоровы и полны сил!"}');
		$user['char_life_cur'] = $user['char_life_max'];
		$user['char_mana_cur'] = $user['char_mana_max'];
		$user['char_food'] --;
		save_character();
		$user['log'] = 'Вы хорошо отдохнули и набрались сил.';
	}

	$res = json_encode($user, JSON_UNESCAPED_UNICODE);

}

?>