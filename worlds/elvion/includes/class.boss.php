<?php

	class Boss {
		
		public const START_ID = 800;
		
		public static function kill($region_ident) {
			global $user;
			$user['stat_boss_kills']++;
			$bosses = json_decode($user['char_bosses'], true);
			$n = count($bosses);
			$bosses[$n]['id'] = $region_ident;
			$bosses[$n]['killed'] = 1;
			$user['char_bosses'] = json_encode($bosses, JSON_UNESCAPED_UNICODE);
			User::update("char_bosses='".$user['char_bosses']."'");
		}

		public static function is_killed($region_ident) {
			global $user;
			$bosses = $user['char_bosses'];
			$pos = strripos($bosses, '"id":"'.$region_ident.'"');
			if ($pos === false) {
				return false;
			} else {
				return true;
			}
		}
		
		public static function gen($enemy) {
			global $user;
			$user['enemy_boss'] = 1;
			$user['enemy_champion'] = 1;
			$user['enemy_name'] = $enemy['enemy_name'].' '.$enemy['enemy_rand_name'];
			$user['enemy_name'] .= ' (Босс)';
			// Life
			$user['enemy_life_max'] = ($user['class']['player']->get_life($enemy['enemy_level']) - 5) + rand(1, 10);
			$user['enemy_life_max'] = round($user['enemy_life_max'] * 1.7);
			$user['enemy_life_cur'] = $user['enemy_life_max'];
			// Damage
			$user['enemy_damage_min'] = round($enemy['enemy_level'] * 0.5) - 1;
			$user['enemy_damage_max'] = round($enemy['enemy_level'] * 0.5) + 1;
			$user['enemy_damage_max'] = round($user['enemy_damage_max'] * (1 + (rand(1, 3) * 0.1)));
			// Armour
			$user['enemy_armor'] = round($enemy['enemy_level'] * 0.5);
			$user['enemy_armor'] = round($user['enemy_armor'] * (1 + (rand(1, 3) * 0.1)));
			// Experience
			$user['enemy_exp'] = round($enemy['enemy_level'] * 3) + rand(round($enemy['enemy_level'] * 0.1), round($enemy['enemy_level'] * 0.3));
			$user['enemy_exp'] = round($user['enemy_exp'] * 1.8);		}
			//  Gold
			$user['enemy_gold'] = round($enemy['enemy_level'] * 2.5) + rand(1, 20);
			$user['enemy_gold'] += $enemy['enemy_level'] * 12;
	}

?>