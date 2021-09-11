<?php

if ($action == 'forest') {

	$user['title'] = 'Темный Лес';
	if ($user['char_life_cur'] > 0) {
		$user['description'] = 'Вы находитесь в Темном Лесу.';
	}else{
		$user['description'] = 'Ваша душа летает над деревьями в Темном Лесу.';
	}
	$user['frame'] = 'outlands';
	$user['links'] = array();
	if ($user['char_life_cur'] > 0) {
		$user['links'][0]['title'] = 'Вернуться в город';
		$user['links'][0]['link'] = 'index.php?action=town';	
	} else {
		$user['links'][0]['title'] = 'Идти на кладбище';
		$user['links'][0]['link'] = 'index.php?action=graveyard';
	}

	if ($do == 'rest_in_outlands') {
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