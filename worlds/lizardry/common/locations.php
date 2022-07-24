<?php

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
		$user['title'] = 'Гавань';
		if ($user['char_life_cur'] > 0) {
		
			for ($i = 0; $i < count($regions); $i++) {
				if (($user['char_region'] == $regions[$i])||($user['char_region'] == $regions[$i] + 1)) {
					$user['description'] = 'В гавани не многолюдно, но все заняты работой. Здесь достаточно легко отыскать корабль, капитан которого согласится взять вас на борт.'.travel_req($travel_level, $travel_food, $travel_gold);
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
					addlink('Путешествие в '.get_region_town_name($r), 'index.php?action=harbor&do='.$r.'', 1);
				}
				if ($user['char_region'] == $regions[$i] + 1) {
					$r = strval($regions[$i]);
					addlink('Путешествие в '.get_region_town_name($r), 'index.php?action=harbor&do='.$r.'', 1);
				}
			}
		
		} else go_to_the_graveyard();
	
	} else after_travel();
	
	$res = json_encode($user, JSON_UNESCAPED_UNICODE);	
	return $res;
}

?>