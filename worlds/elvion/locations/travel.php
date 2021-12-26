<?php

if ($action == 'stables') {

	$travel = false;
	$travel_level = 1;
	$travel_food = 0;
	$travel_gold = 0;
	
	if (($do == 1)||($do == 2)) {
		check_travel_req($travel_level, $travel_food, $travel_gold);
		$travel = true;
		change_region($do, $travel_food, $travel_gold);
	}
	
	if (!$travel) {
		$user['title'] = 'Конюшни';
		if ($user['char_life_cur'] > 0) {
		
			switch ($user['char_region']) {
				case 1:
					$user['description'] = 'Вы входите в Конюшни. Эрида - милая хозяйка Конюшен - радо встречает Вас и рассказывет, что посетить Морхольд можно в любое удобное для Вас время. Но нужно выполнить определенные  условия:#Уровень персонажа - не менее 12-го.#Взять в дорогу хотя бы 3-и пакета с провиантом.#И последнее - Вы должны заплатить караванщику за проез в Морхольд 200 золотых монет.';
					break;
				case 2:
					$user['description'] = 'Вас встречает внушительного вида коренастый гном в потертой кожаной броне и с гномьим боевым топором за плечами. Он сообщает Вам, что караван в Вильмар отправится в любое время, но нужно выполнить определенные условия:#Уровень героя - не менее 12-го.#С собою иметь не менее 3-х пакетов с провиантом.#Стоимость проезда в Вильмар - 200 золотых монет.';
					break;
			}
		
		} else shades();
		
		$user['links'] = array();
		if ($user['char_life_cur'] > 0) {

			go_to_the_gate('Покинуть Конюшни');
			switch ($user['char_region']) {
				case 1:
					addlink('Путешествие в '.get_region_town_name(2), 'index.php?action=stables&do=2', 1);
					break;
				case 2:
					addlink('Путешествие в '.get_region_town_name(1), 'index.php?action=stables&do=1', 1);
					break;
			}
		
		} else go_to_the_graveyard();
	
	} else after_travel();
	
	$res = json_encode($user, JSON_UNESCAPED_UNICODE);
	
}

if ($action == 'harbor') {

	$travel = false;
	$travel_level = 1;
	$travel_food = 0;
	$travel_gold = 0;
	
	if (($do == 2)||($do == 3)) {
		check_travel_req($travel_level, $travel_food, $travel_gold);
		$travel = true;
		change_region($do, $travel_food, $travel_gold);
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
					addlink('Путешествие в '.get_region_town_name(3), 'index.php?action=harbor&do=3', 1);
					break;
				case 3:
					addlink('Путешествие в '.get_region_town_name(2), 'index.php?action=harbor&do=2', 1);
					break;
			}
		
		} else go_to_the_graveyard();
	
	} else after_travel();
	
	$res = json_encode($user, JSON_UNESCAPED_UNICODE);
	
}

if ($action == 'dir_tower') {

	$travel = false;
	$travel_level = 1;
	$travel_food = 0;
	$travel_gold = 0;
	
	if (($do == 3)||($do == 4)) {
		check_travel_req($travel_level, $travel_food, $travel_gold);
		$travel = true;
		change_region($do, $travel_food, $travel_gold);
	}
	
	if (!$travel) {
		$user['title'] = 'Башня Дирижаблей';
		if ($user['char_life_cur'] > 0) {
		
			switch ($user['char_region']) {
				case 3:
					$user['description'] = 'Вы пришли в Гавань Морхольда. Здесь можно найти корабль в Миран. Но нужно выполнить определенные  условия:#Уровень персонажа - не менее 24-го.#Взять в дорогу хотя бы 2-a пакета с провиантом.#И последнее - Вы должны заплатить капитану за проез в Миран 800 золотых монет.';
					break;
				case 4:
					$user['description'] = 'В гавани Мирана не многолюдно, но все заняты работой. Здесь можно отыскать корабль, капитан которого согласится взять Вас на борт до Морхольда. Но нужно выполнить определенные условия:#Уровень героя - не менее 24-го.#С собою иметь не менее 2-х пакетов с провиантом.#Стоимость - 800 золотых монет.';
					break;
			}
		
		} else shades();
		
		$user['links'] = array();
		if ($user['char_life_cur'] > 0) {

			go_to_the_gate('Покинуть Башню Дирижаблей');
			switch ($user['char_region']) {
				case 3:
					addlink('Путешествие в '.get_region_town_name(4), 'index.php?action=dir_tower&do=4', 1);
					break;
				case 4:
					addlink('Путешествие в '.get_region_town_name(3), 'index.php?action=dir_tower&do=3', 1);
					break;
			}
		
		} else go_to_the_graveyard();
	
	} else after_travel();
	
	$res = json_encode($user, JSON_UNESCAPED_UNICODE);
	
}

if ($action == 'fly') {

	$travel = false;
	$travel_level = 1;
	$travel_food = 0;
	$travel_gold = 0;
	
	if (($do == 4)||($do == 5)) {
		check_travel_req($travel_level, $travel_food, $travel_gold);
		$travel = true;
		change_region($do, $travel_food, $travel_gold);
	}
	
	if (!$travel) {
		$user['title'] = 'Утес Ветрокрылов';
		if ($user['char_life_cur'] > 0) {
		
			switch ($user['char_region']) {
				case 4:
					$user['description'] = ' Но нужно выполнить определенные  условия:#Уровень персонажа - не менее 24-го.#Взять в дорогу хотя бы 2-a пакета с провиантом.#И последнее - Вы должны заплатить капитану за проез в Миран 800 золотых монет.';
					break;
				case 5:
					$user['description'] = ' Но нужно выполнить определенные условия:#Уровень героя - не менее 24-го.#С собою иметь не менее 2-х пакетов с провиантом.#Стоимость - 800 золотых монет.';
					break;
			}
		
		} else shades();
		
		$user['links'] = array();
		if ($user['char_life_cur'] > 0) {

			go_to_the_gate('Покинуть Утес Ветрокрылов');
			switch ($user['char_region']) {
				case 4:
					addlink('Путешествие в '.get_region_town_name(5), 'index.php?action=fly&do=5', 1);
					break;
				case 5:
					addlink('Путешествие в '.get_region_town_name(4), 'index.php?action=fly&do=4', 1);
					break;
			}
		
		} else go_to_the_graveyard();
	
	} else after_travel();
	
	$res = json_encode($user, JSON_UNESCAPED_UNICODE);
	
}

?>