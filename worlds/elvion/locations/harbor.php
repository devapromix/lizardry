<?php

if ($action == 'harbor') {

	$travel = false;
	
	if ($do == 2) {
		if ($user['char_life_cur'] <= 0) die('{"error":"Вам сначала нужно вернуться к жизни!"}');
		if ($user['char_level'] < 24) die('{"info":"Для путешествия в другой регион нужен 24-й уровень!"}');
		if ($user['char_food'] < 4) die('{"info":"Возьмите в дорогу не менее четырех мешков провизии!"}');
		if ($user['char_gold'] < 500) die('{"info":"Возьмите в дорогу не менее 500 золотых монет!"}');
		$travel = true;
		change_region($do, 4, 500);
	}
	if ($do == 3) {
		if ($user['char_life_cur'] <= 0) die('{"error":"Вам сначала нужно вернуться к жизни!"}');
		if ($user['char_level'] < 24) die('{"info":"Для путешествия в другой регион нужен 24-й уровень!"}');
		if ($user['char_food'] < 4) die('{"info":"Возьмите в дорогу не менее четырех мешков провизии!"}');
		if ($user['char_gold'] < 500) die('{"info":"Возьмите в дорогу не менее 500 золотых монет!"}');
		$travel = true;
		change_region($do, 4, 500);
	}
	
	if (!$travel) {
		$user['title'] = 'Гавань';
		if ($user['char_life_cur'] > 0) {
		
			switch ($user['char_region']) {
				case 2:
					$user['description'] = 'Вы пришли в Гавань Морхольда. Здесь можно найти корабль в Миран. Но нужно выполнить определенные  условия:#Уровень персонажа - не менее 24-го.#Взять в дорогу хотя бы 4-е пакета с провиантом.#И последнее - Вы должны заплатить капитану за проез в Миран 500 золотых монет.';
					break;
				case 3:
					$user['description'] = 'В гавани Мирана не многолюдно, но все заняты работой. Здесь можно отыскать корабль, капитан которого согласится взять Вас на борт до Морхольда. Но нужно выполнить определенные условия:#Уровень героя - не менее 24-го.#С собою иметь не менее 4-х пакетов с провиантом.#Стоимость - 500 золотых монет.';
					break;
			}
		
		} else shades();
		
		$user['links'] = array();
		if ($user['char_life_cur'] > 0) {

			go_to_the_gate('Покинуть Гавань');
			switch ($user['char_region']) {
				case 2:
					addlink('Путешествие в Миран', 'index.php?action=harbor&do=3', 1);
					break;
				case 3:
					addlink('Путешествие в Морхольд', 'index.php?action=harbor&do=2', 1);
					break;
			}
		
		} else go_to_the_graveyard();
	
	} else {
		$user['title'] = 'Путешествие';
		$user['description'] = 'После многих дней увлекательного морского путешествия Вы приплыли в другую гавань и вот уже виднеются стены города.';
		$user['links'] = array();
		go_to_the_gate('Идти к воротам в город');
	}
	
	$res = json_encode($user, JSON_UNESCAPED_UNICODE);
	
}













?>