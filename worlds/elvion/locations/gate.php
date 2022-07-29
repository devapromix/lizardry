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
				addlink('Башня Дирижаблей', 'index.php?action=dir_tower', 3);
				addlink('Лес Каменных Гигантов', 'index.php?action=stone_giant_forest', 4);
				addlink('Монастырь', 'index.php?action=monast', 5);
				break;
			case 4:
				addlink('Башня Дирижаблей', 'index.php?action=dir_tower', 2);
				addlink('Утес Ветрокрылов', 'index.php?action=fly', 3);
				addlink('Заброшенные Рудники', 'index.php?action=abandoned_mines', 4);
				addlink('Ледяное Озеро', 'index.php?action=icy_lake', 5);
				addlink('Долина Грифов', 'index.php?action=vulture_valley', 6);
				addlink('Храм Глубин', 'index.php?action=cathedral_of_the_deep', 7);
				break;
			case 5:
				addlink('Утес Ветрокрылов', 'index.php?action=fly', 2);
				addlink('Посетить Гавань', 'index.php?action=harbor', 3);
				addlink('Одинокая Гора', 'index.php?action=alone_mountain', 4);
				addlink('Темная Долина', 'index.php?action=dark_valley', 5);
				addlink('Забытый Лес', 'index.php?action=forgotten_forest', 6);
				break;
			case 6:
				addlink('Башня Дирижаблей', 'index.php?action=dir_tower', 2);
				addlink('Посетить Гавань', 'index.php?action=harbor', 3);
				addlink('Красная Пустыня', 'index.php?action=red_desert', 4);
				addlink('Огненное Море', 'index.php?action=fire_sea', 5);
				break;
			case 7:
				break;
			case 8:
				break;
			case 9:
				break;
			case 10:
				break;
		}
		
	} else go_to_the_graveyard();
	
	$res = json_encode($user, JSON_UNESCAPED_UNICODE);
}

?>