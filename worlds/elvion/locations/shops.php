<?php

if ($action == 'shops') {
	
	$user['title'] = 'Квартал Торговцев';
	if ($user['char_life_cur'] > 0) {
		$user['description'] = '';
	}else{
		$user['description'] = 'Ваша душа летает над городом.';
	}
	$user['links'] = array();
	if ($user['char_life_cur'] > 0) {	
		$user['links'][0]['title'] = 'На площадь города';
		$user['links'][0]['link'] = 'index.php?action=town';
		$user['links'][1]['title'] = 'Лавка Бронника';
		$user['links'][1]['link'] = 'index.php?action=shop_armor';
	} else {
		$user['links'][0]['title'] = 'Городское Кладбище';
		$user['links'][0]['link'] = 'index.php?action=graveyard';
	}
	
	$res = json_encode($user, JSON_UNESCAPED_UNICODE);	

}

if ($action == 'shop_armor') {
	
	if ($user['char_life_cur'] <= 0) die('{"error":"Вам сначала нужно вернуться к жизни!"}');
	if ($user['char_gold'] <= 0) die('{"error":"Вы не можете здесь ничего купить - нет денег!"}');

	$user['title'] = 'Лавка Бронника';
	$user['description'] = '';
	$user['mainframe'] = 'shop_armor';
	$user['links'] = array();
	$user['links'][0]['title'] = 'Покинуть лавку';
	$user['links'][0]['link'] = 'index.php?action=shops';

	$user['char_life_cur'] = $user['char_life_max'];
	$user['char_mana_cur'] = $user['char_mana_max'];
	$user['char_food'] --;
	update_user_table("char_food=".$user['char_food'].",char_life_cur=".$user['char_life_cur'].",char_mana_cur=".$user['char_mana_cur']);
	$user['log'] = 'Вы хорошо отдохнули и набрались сил.';

	$res = json_encode($user, JSON_UNESCAPED_UNICODE);

}

?>