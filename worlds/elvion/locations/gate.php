<?php

if ($action == 'gate') {
	$user['title'] = 'Врата в '.$user['char_region_town_name'];
	if ($user['char_life_cur'] > 0) {
		$user['description'] = 'Вы стоите у главных ворот в город. Здесь всегда полно народу - кто-то спешит в город, кто-то его покидает. Угрюмые стражники подозрительно всматриваются в каждого проходящего. Глубоко вдохнув полной грудью вы решаете, что пора двигаться дальше.';
	} else $user['class']['location']->shades();
	
	$user['links'] = array();
	if ($user['char_life_cur'] > 0) {
		
		$user['class']['location']->go_to_the_town('Войти в '.$user['char_region_town_name']);
		$user['class']['location']->go_to_the_graveyard('Идти на Кладбище', 1);
		switch ($user['char_region']) {
			case 1:
				Location::addlink('Посетить Конюшни', 'index.php?action=stables', 2);
				Location::addlink('Темный Лес', 'index.php?action=dark_forest', 3);
				break;
			case 2:
				Location::addlink('Посетить Конюшни', 'index.php?action=stables', 2);
				Location::addlink('Загон Единорогов', 'index.php?action=uni_stables', 3);
				Location::addlink('Посетить Гавань', 'index.php?action=harbor', 4);
				Location::addlink('Лес Энтов', 'index.php?action=treant_forest', 5);
				Location::addlink('Старая Гавань', 'index.php?action=old_harbor', 6);
				Location::addlink('Каменное Поле', 'index.php?action=stonefield', 7);
				break;
			case 3:
				Location::addlink('Посетить Гавань', 'index.php?action=harbor', 2);
				Location::addlink('Башня Дирижаблей', 'index.php?action=dir_tower', 3);
				Location::addlink('Лес Каменных Гигантов', 'index.php?action=stone_giant_forest', 4);
				Location::addlink('Монастырь', 'index.php?action=monast', 5);
				break;
			case 4:
				Location::addlink('Башня Дирижаблей', 'index.php?action=dir_tower', 2);
				Location::addlink('Утес Ветрокрылов', 'index.php?action=fly', 3);
				Location::addlink('Заброшенные Рудники', 'index.php?action=abandoned_mines', 4);
				Location::addlink('Ледяное Озеро', 'index.php?action=icy_lake', 5);
				Location::addlink('Долина Грифов', 'index.php?action=vulture_valley', 6);
				Location::addlink('Храм Глубин', 'index.php?action=cathedral_of_the_deep', 7);
				break;
			case 5:
				Location::addlink('Утес Ветрокрылов', 'index.php?action=fly', 2);
				Location::addlink('Посетить Гавань', 'index.php?action=harbor', 3);
				Location::addlink('Одинокая Гора', 'index.php?action=alone_mountain', 4);
				Location::addlink('Темная Долина', 'index.php?action=dark_valley', 5);
				Location::addlink('Забытый Лес', 'index.php?action=forgotten_forest', 6);
				break;
			case 6:
				Location::addlink('Магический Портал', 'index.php?action=portal', 2);
				Location::addlink('Посетить Гавань', 'index.php?action=harbor', 3);
				Location::addlink('Черная Гора', 'index.php?action=black_mountain', 4);
				Location::addlink('Река Ашиот', 'index.php?action=ashiot_river', 5);
				Location::addlink('Желтый Лес', 'index.php?action=yellow_forest', 6);
				Location::addlink('Старый Бастион', 'index.php?action=old_bastion', 7);
				break;
			case 7:
				Location::addlink('Посетить Конюшни', 'index.php?action=stables', 2);
				Location::addlink('Магический Портал', 'index.php?action=portal', 3);
				Location::addlink('Красная Пустыня', 'index.php?action=red_desert', 4);
				Location::addlink('Огненное Море', 'index.php?action=fire_sea', 5);
				Location::addlink('Руины Тинии', 'index.php?action=tinias_ruins', 6);
				Location::addlink('Далекий Остров', 'index.php?action=far_island', 7);
				Location::addlink('Водоворот', 'index.php?action=vodovorot', 8);
				break;
			case 8:
				Location::addlink('Посетить Конюшни', 'index.php?action=stables', 2);
				Location::addlink('Море Снов', 'index.php?action=dr_sea', 3);
				Location::addlink('Черная Пещера', 'index.php?action=black_cave', 4);
				break;
			case 9:
				break;
			case 10:
				break;
			case 11:
				break;
			case 12:
				break;
			case 13:
				break;
			case 14:
				break;
			case 15:
				break;
		}
		
	} else $user['class']['location']->go_to_the_graveyard();
	
	$res = json_encode($user, JSON_UNESCAPED_UNICODE);
}

?>