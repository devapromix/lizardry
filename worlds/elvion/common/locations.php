<?php

function outland($location_ident, $enemies, $prev_location = [], $next_location = [], $is_boss = false) {
	global $user, $res, $connection, $tb_locations;
	$user['current_outlands'] = $location_ident;
	add_enemies($enemies, $is_boss);	
	$query = "SELECT * FROM ".$tb_locations." WHERE location_ident='".$location_ident."'";
	$result = mysqli_query($connection, $query) 
		or die('{"error":"Ошибка считывания данных: '.mysqli_error($connection).'"}');
	$location = $result->fetch_assoc();

	$user['title'] = $location['location_name'];
	$user['char_region_location_name'] = $location['location_name'];
	update_user_table("char_region_location_name='".$user['char_region_location_name']."'");

	if ($user['char_life_cur'] > 0) {
		$user['description'] = $location['location_description'];
	} else shades();
	$user['frame'] = 'outlands';
	$user['links'] = array();
	$n = 0;
	if ($user['char_life_cur'] > 0) {
		if (count($prev_location) > 0) {
			addlink($prev_location[0], $prev_location[1], $n);
			$n++;
		}
		if (count($prev_location) == 0) {
			go_to_the_gate();
			$n++;
		}
		if (count($next_location) > 0) {
			addlink($next_location[0], $next_location[1], $n);
			$n++;
		}
	} else
		go_to_the_graveyard();

	$res = json_encode($user, JSON_UNESCAPED_UNICODE);

}

function travel_to($action, $do, $regions) {
	global $user;
	
	$travel = false;
	$travel_level = 1;
	
	for ($i = 0; $i < count($regions); $i++) {
		if (($user['char_region'] == $regions[$i]) || ($user['char_region'] == $regions[$i] + 1)) {
			$travel_level = $regions[$i] * 12;
			$travel_food = 3;	
		}
		
	}
	
	$travel_gold = travel_price($travel_level);
	
	for ($i = 0; $i < count($regions); $i++) {
		if (($do == $regions[$i])||($do == $regions[$i] + 1)) {
			check_travel_req($travel_level, $travel_food, $travel_gold);
			$travel = true;
			change_region($do, $travel_food, $travel_gold);
		}
	}
	
	if (!$travel) {
		if ($action == 'stables')
			$user['title'] = 'Конюшни';
		if ($action == 'harbor')
			$user['title'] = 'Гавань';
		if ($action == 'dir_tower')
			$user['title'] = 'Башня Дирижаблей';
		if ($action == 'fly')
			$user['title'] = 'Утес Ветрокрылов';
		if ($action == 'portal')
			$user['title'] = 'Магический Портал';
		if ($user['char_life_cur'] > 0) {
		
			for ($i = 0; $i < count($regions); $i++) {
				if (($user['char_region'] == $regions[$i])||($user['char_region'] == $regions[$i] + 1)) {
					if ($action == 'stables')
						$user['description'] = 'В городских конюшнях всегда можно найти караванщика, который за звонкую монету готов отвезти вас хоть на край света.';
					if ($action == 'harbor')
						$user['description'] = 'В гавани не многолюдно, но все заняты работой. Здесь достаточно легко отыскать корабль, капитан которого согласится взять вас на борт.';
					if ($action == 'dir_tower')
						$user['description'] = 'На вершине башни пришвартованы несколько дирижаблей и достаточно легко отыскать пилота готового отвезти вас в другой регион.';
					if ($action == 'fly')
						$user['description'] = 'На Утесе всегда много свободных ветрокрылов и не так сложно отыскать погонщика, который согласится отвезти вас в другой город.';
					if ($action == 'portal')
						$user['description'] = 'У Портала всегда можно отыскать мага, который за некоторое денежное вознаграждение согласится отправить вас в другой город.';
					$user['description'] .= travel_req($travel_level, $travel_food, $travel_gold);
					break;
				}
			}
		
		} else shades();
		
		$user['links'] = array();
		if ($user['char_life_cur'] > 0) {

			go_to_the_gate();
			for ($i = 0; $i < count($regions); $i++) {
				if ($user['char_region'] == $regions[$i]) {
					$r = strval($regions[$i] + 1);
					addlink('Путешествие в '.get_region_town_name($r), 'index.php?action='.$action.'&do='.$r.'', 1);
				}
				if ($user['char_region'] == $regions[$i] + 1) {
					$r = strval($regions[$i]);
					addlink('Путешествие в '.get_region_town_name($r), 'index.php?action='.$action.'&do='.$r.'', 1);
				}
			}
		
		} else go_to_the_graveyard();
	
	} else after_travel();
	
	$res = json_encode($user, JSON_UNESCAPED_UNICODE);	
	return $res;
}

function after_travel() {
	global $user;
	$user['title'] = 'Путешествие';
	$user['description'] = 'После нескольких дней увлекательного путешествия Вы прибыли в другой город и вот уже виднеются высокие городские стены.';
	$user['links'] = array();
	go_to_the_gate('Идти к воротам в город');
}

function shades() {
	global $user;
	$user['description'] = 'Вы находитесь в мире теней и ищете проход в мир живых. Чувствуется необычайная легкость и безразличие ко всему происходящему. Ваша душа вздымается все выше и выше. Повсюду вокруг вас души погибших в бесконечных битвах. Их души преследуют вас и шепчут о своих муках и страданиях. В мире теней одиноко, холодно и не уютно. Вы ищите ближайшее кладбище чтобы поскорее вернуться в мир живых.';
}

function random_place() {
	global $user;
	
	switch ($user['current_random_place']) {
		case 1:
			$user['title'] = 'Лагерь старого алхимика';
			$user['description'] = 'Вы проходите несколько десятков шагов и останавливаетесь у старого вагончика. Недалеко пасется пони, горит костер. У костра сидит старый гном и приветливо машет вам рукой:#-Приветствую, путник!Будь гостем в моем лагере. Я вижу ты ранен - вот возьми эликсир...#Старик протягивает вам эликсир и вы, залпом выпив содержимое флакончика, чувствуете, как уходит усталость и заживляются раны.#-Садись рядом, угощайся и расскажи, что с тобой произошло.#Вы присаживаетесь у костра, достаете и свои припасы и начинаете рассказ...';
			$user['char_life_cur'] = $user['char_life_max'];
			update_user_table("char_life_cur=".$user['char_life_cur']);
			break;
		case 2:
			$user['title'] = 'Камнепад!!!';
			$user['description'] = 'Вы проходите несколько десятков шагов и внезапно слышите странный гул. Обвал! - краем сознания вдруг осознаете вы и бросаетесь в сторону... ';
			$dam = rand($user['char_region'] * 3, $user['char_region'] * 5);
			$user['char_life_cur'] -= $dam;
			if ($user['char_life_cur'] > 0) {
				$user['description'] .= 'Грохочущая лавина камней проносится совсем рядом, лишь слегка зацепив вас. Вам чудом удалось избежать смерти!';
			} else {
				$user['char_life_cur'] = 0;
				$user['description'] .= 'Но уже слишком поздно и вы оказываетесь на пути гремящей каменной массы. Вы погибли!';
			}			
			update_user_table("char_life_cur=".$user['char_life_cur']);
			break;
		case 3:
			$user['title'] = 'Невидимый вор!';
			$user['description'] = 'Вы прошли всего несколько десятков шагов, когда заметили какое-то движение. Вор! Вы хватились кошелька на поясе и с сожалением обнаружили, что вас ограбили. ';
			$gold = rand($user['char_region'] * 30, $user['char_region'] * 70);
			if ($user['char_gold'] > $gold) {
				$user['char_gold'] -= $gold;
				$user['description'] .= 'Вору удалось украсть у вас '.$gold.' золотых монет.';
			} else {
				$user['char_gold'] = 0;
				$user['description'] .= 'Вор украл у вас все золото.';
			}
			update_user_table("char_gold=".$user['char_gold']);
 			break;
	}
}

?>