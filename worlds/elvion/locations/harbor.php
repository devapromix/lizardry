<?php

if ($action == 'harbor') {

	$travel = false;
	
	if ($do == 2) {
		if ($user['char_life_cur'] <= 0) die('{"error":"Вам сначала нужно вернуться к жизни!"}');
		if ($user['char_level'] < 12) die('{"info":"Для путешествия в другой регион нужен 24-й уровень!"}');
		if ($user['char_food'] < 3) die('{"info":"Возьмите в дорогу не менее четырех мешков провизии!"}');
		if ($user['char_gold'] < 200) die('{"info":"Возьмите в дорогу не менее 500 золотых монет!"}');
		$travel = true;
		change_region($do, 3, 200);
	}
	if ($do == 3) {
		if ($user['char_life_cur'] <= 0) die('{"error":"Вам сначала нужно вернуться к жизни!"}');
		if ($user['char_level'] < 12) die('{"info":"Для путешествия в другой регион нужен 24-й уровень!"}');
		if ($user['char_food'] < 3) die('{"info":"Возьмите в дорогу не менее четырех мешков провизии!"}');
		if ($user['char_gold'] < 200) die('{"info":"Возьмите в дорогу не менее 500 золотых монет!"}');
		$travel = true;
		change_region($do, 3, 200);
	}
	
	if (!$travel) {
		$user['title'] = 'Гавань';
		if ($user['char_life_cur'] > 0) {
		
			switch ($user['char_region']) {
				case 2:
					$user['description'] = ' Но нужно выполнить определенные  условия:#Уровень персонажа - не менее 24-го.#Взять в дорогу хотя бы 4-и пакета с провиантом.#И последнее - Вы должны заплатить караванщику за проез в Морхольд 200 золотых монет.';
					break;
				case 3:
					$user['description'] = 'Но нужно выполнить определенные условия:#Уровень героя - не менее 24-го.#С собою иметь не менее 4-х пакетов с провиантом.#Стоимость проезда в Вильмар - 200 золотых монет.';
					break;
			}
		
		} else {
			$user['description'] = 'Вы находитесь в мире теней и ищете дорогу в мир живых. Вас с необъяснимой силой тянет к ближайшему кладбищу.';
		}
		$user['links'] = array();
		if ($user['char_life_cur'] > 0) {

			$user['links'][0]['title'] = 'Покинуть Гавань';
			$user['links'][0]['link'] = 'index.php?action=gate';
			switch ($user['char_region']) {
				case 2:
					$user['links'][1]['title'] = 'Путешествие в Морхольд';
					$user['links'][1]['link'] = 'index.php?action=harbor&do=3';
					break;
				case 3:
					$user['links'][1]['title'] = 'Путешествие в Морхольд';
					$user['links'][1]['link'] = 'index.php?action=harbor&do=2';
					break;
			}
		
		} else {
			$user['links'][0]['title'] = 'Городское Кладбище';
			$user['links'][0]['link'] = 'index.php?action=graveyard';
		}
	
	} else {
		$user['title'] = 'Путешествие';
		$user['description'] = 'После нескольких дней увлекательного путешествия Вы приплыли в другой регион и вот уже виднеются стены города.';
		$user['links'] = array();
		$user['links'][0]['title'] = 'Идти к воротам в город';
		$user['links'][0]['link'] = 'index.php?action=gate';
	}
	
	$res = json_encode($user, JSON_UNESCAPED_UNICODE);
	
}













?>