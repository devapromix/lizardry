<?php

if ($action == 'gate') {
	$user['title'] = 'Врата Города';
	if ($user['char_life_cur'] > 0) {
		$user['description'] = 'Вы стоите у главных ворот в город. Здесь всегда полно народу - кто-то спешит в город, кто-то его покидает. Угрюмые стражники подозрительно всматриваются в каждого проходящего. Глубоко вдохнув полной грудью вы решаете, что пора двигаться дальше.';
	}else{
		$user['description'] = 'Ваша душа парит над главными городскими воротами города. Вас с необъяснимой силой тянет к ближайшему кладбищу.';
	}
	$user['links'] = array();
	if ($user['char_life_cur'] > 0) {
		
		$user['links'][0]['title'] = 'Войти в Город';
		$user['links'][0]['link'] = 'index.php?action=town';
		$user['links'][1]['title'] = 'Идти на Кладбище';
		$user['links'][1]['link'] = 'index.php?action=graveyard';
		switch ($user['char_region']) {
			case 1:
				$user['links'][2]['title'] = 'Посетить Конюшни';
				$user['links'][2]['link'] = 'index.php?action=stables';
				$user['links'][3]['title'] = 'Темный Лес';
				$user['links'][3]['link'] = 'index.php?action=forest';
				break;
			case 2:
				$user['links'][2]['title'] = 'Посетить Конюшни';
				$user['links'][2]['link'] = 'index.php?action=stables';
				//$user['links'][3]['title'] = 'Посетить Гавань';
				//$user['links'][3]['link'] = 'index.php?action=stables';
				break;
			case 3:
				$user['links'][2]['title'] = 'Посетить Гавань';
				$user['links'][2]['link'] = 'index.php?action=stables';
				break;
		}
		
	} else {
		$user['links'][0]['title'] = 'Городское Кладбище';
		$user['links'][0]['link'] = 'index.php?action=graveyard';
	}
	
	$res = json_encode($user, JSON_UNESCAPED_UNICODE);
}

?>