<?php

if ($action == 'stables') {

	if ($do == 1) {
		if ($user['char_life_cur'] <= 0) die('{"error":"Вам сначала нужно вернуться к жизни!"}');
		if ($user['char_food'] < 3) die('{"info":"Возьмите в дорогу не менее трех мешков провизии!"}');
		change_region($do);
	}
	if ($do == 2) {
		if ($user['char_life_cur'] <= 0) die('{"error":"Вам сначала нужно вернуться к жизни!"}');
		if ($user['char_food'] < 3) die('{"info":"Возьмите в дорогу не менее трех мешков провизии!"}');
		change_region($do);
	}
	
	$user['title'] = 'Конюшни';
	if ($user['char_life_cur'] > 0) {
		
		switch ($user['char_region']) {
			case 1:
				$user['description'] = 'Вы входите в Конюшни. Эрида - милая хозяйка Конюшен - радо встречает Вас и рассказывет, что посетить другой регион можно в любое удобное для Вас время. Просто нужно выполнить определенные  условия:#Уровень не менее 12-го.#Взять в дорогу хотя бы 3-и пакета с провиантом.#И последнее - Вы должны заплатить караванщику за проез в Морхольд 200 золотых монет.';
				break;
			case 2:
				$user['description'] = 'Вас встречает внушительного вида коренастый гном в потертой кожаной броне и с гномьим боевым топором за плечами. Он сообщает Вам, что караван в Вильмар отправится в любое время, но нужно выполнить определенные условия:#Уровень - не менее 12-го.#С собою иметь не менее 3-х пакетов с провиантом.#Стоимость проезда в Вильмар - 200 золотых монет.';
				break;
		}
		
	} else {
		$user['description'] = 'Ваша душа летает главными городскими воротами города.';
	}
	$user['links'] = array();
	if ($user['char_life_cur'] > 0) {

		$user['links'][0]['title'] = 'Покинуть Конюшни';
		$user['links'][0]['link'] = 'index.php?action=gate';
		switch ($user['char_region']) {
			case 1:
				$user['links'][1]['title'] = 'Путешествие в Морхольд';
				$user['links'][1]['link'] = 'index.php?action=stables&do=2';
				break;
			case 2:
				$user['links'][1]['title'] = 'Путешествие в Вильмар';
				$user['links'][1]['link'] = 'index.php?action=stables&do=1';
				break;
		}
		
	} else {
		$user['links'][0]['title'] = 'Городское Кладбище';
		$user['links'][0]['link'] = 'index.php?action=graveyard';
	}
	
	$res = json_encode($user, JSON_UNESCAPED_UNICODE);
	
}













?>