<?php

if ($action == 'gate') {
	$user['title'] = 'Врата в '.$user['char_region_town_name'];
	if ($user['char_life_cur'] > 0) {
		$user['description'] = 'Вы стоите у главных ворот в город. Здесь всегда полно народу - кто-то спешит в город, кто-то его покидает. Угрюмые стражники подозрительно всматриваются в каждого проходящего. Глубоко вдохнув полной грудью вы решаете, что пора двигаться дальше.';
	} else shades();
	
	$user['links'] = array();
	if ($user['char_life_cur'] > 0) {
		
		go_to_the_town('Войти в '.$user['char_region_town_name']);
		go_to_the_graveyard('Идти на Кладбище', 1);
		switch ($user['char_region']) {
			case 1:
				addlink('Посетить Конюшни', 'index.php?action=stables', 2);
				addlink('Темный Лес', 'index.php?action=dark_forest', 3);
				break;
			case 2:
				addlink('Посетить Конюшни', 'index.php?action=stables', 2);
				addlink('Посетить Гавань', 'index.php?action=harbor', 3);
				addlink('Лес Энтов', 'index.php?action=treant_forest', 4);
				addlink('Старая Гавань', 'index.php?action=old_harbor', 5);
				addlink('Каменное Поле', 'index.php?action=stonefield', 6);
				break;
			case 3:
				addlink('Посетить Гавань', 'index.php?action=harbor', 2);
				addlink('Лес Каменных Гигантов', 'index.php?action=stone_giant_forest', 3);
				addlink('Монастырь', 'index.php?action=monast', 4);
				break;
		}
		
	} else go_to_the_graveyard();
	
	$res = json_encode($user, JSON_UNESCAPED_UNICODE);
}

?>