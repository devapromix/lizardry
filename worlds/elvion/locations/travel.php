<?php

if ($action == 'stables') {

	$travel = false;
	$travel_level = 12;
	$travel_food = 3;
	$travel_gold = 200;
	
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
				case 2:
					$user['description'] = 'В городских конюшнях всегда можно найти караванщика, который за звонкую монету готов отвезти вас хоть на край света.'.travel_req($travel_level, $travel_food, $travel_gold);
					break;
			}
		
		} else shades();
		
		$user['links'] = array();
		if ($user['char_life_cur'] > 0) {

			go_to_the_gate();
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
	$travel_level = 24;
	$travel_food = 4;
	$travel_gold = 500;
	
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
				case 3:
					$user['description'] = 'В гавани не многолюдно, но все заняты работой. Здесь достаточно легко отыскать корабль, капитан которого согласится взять вас на борт.'.travel_req($travel_level, $travel_food, $travel_gold);
					break;
			}
		
		} else shades();
		
		$user['links'] = array();
		if ($user['char_life_cur'] > 0) {

			go_to_the_gate();
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
	$travel_level = 36;
	$travel_food = 4;
	$travel_gold = 800;
	
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
				case 4:
					$user['description'] = 'На вершине башни пришвартованы несколько дирижаблей и достаточно легко отыскать пилота готового отвезти вас в другой регион.'.travel_req($travel_level, $travel_food, $travel_gold);
					break;
			}
		
		} else shades();
		
		$user['links'] = array();
		if ($user['char_life_cur'] > 0) {

			go_to_the_gate();
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
	$travel_level = 48;
	$travel_food = 3;
	$travel_gold = 1100;
	
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
				case 5:
					$user['description'] = 'На утесе всегда много свободных ветрокрылов и не так сложно отыскать погонщика, который согласится отвезти вас в другой город.'.travel_req($travel_level, $travel_food, $travel_gold);
					break;
			}
		
		} else shades();
		
		$user['links'] = array();
		if ($user['char_life_cur'] > 0) {

			go_to_the_gate();
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