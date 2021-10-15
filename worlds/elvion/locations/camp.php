<?php

if ($action == 'camp') {
	
	if ($user['char_life_cur'] <= 0) die('{"error":"Вам сначала нужно вернуться к жизни!"}');
	if ($user['char_food'] <= 0) die('{"error":"Вы не можете здесь отдыхать - нет провизии!"}');
	if (($user['char_life_cur'] == $user['char_life_max'])
		&&($user['char_mana_cur'] == $user['char_mana_max'])) die('{"info":"Вам незачем отдыхать - вы здоровы и полны сил!"}');

	$user['title'] = 'Лагерь!';
	$user['links'] = array();
	$user['links'][0]['title'] = 'Затушить костер';
	$user['links'][0]['link'] = 'index.php?action='.$user['current_outlands'];

	$user['char_life_cur'] = $user['char_life_max'];
	$user['char_mana_cur'] = $user['char_mana_max'];
	$user['char_food'] --;
	save_character();
	$user['log'] = 'Вы хорошо отдохнули и набрались сил.';

	$res = json_encode($user, JSON_UNESCAPED_UNICODE);

}

?>