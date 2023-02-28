<?php

	class Boss {
		
		public const START_ID = 800;
		
		public static function kill(int $region_ident) {
			global $user;
			$user['stat_boss_kills']++;	
			$strbox = new StringBox($user['char_bosses']);
			$strbox->add($region_ident);
			$user['char_bosses'] = $strbox->get_string();
			User::update("char_bosses='".$user['char_bosses']."'");
		}

		public static function is_killed(int $region_ident) {
			global $user;			
			$strbox = new StringBox($user['char_bosses']);
			return $strbox->has($region_ident);
		}
		
		public static function gen($enemy, int $enemy_life) {
			global $user;
			$user['enemy_boss'] = 1;
			$user['enemy_champion'] = 1;
			$user['enemy_name'] = $enemy['enemy_name'].' '.$enemy['enemy_rand_name'];
			$user['enemy_name'] .= ' (Босс)';
			// Life
			$user['enemy_life_max'] = $enemy_life;
			$user['enemy_life_max'] = round($user['enemy_life_max'] * 2);
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
			$user['enemy_exp'] = round($user['enemy_exp'] * 1.8);		
			//  Gold
			$user['enemy_gold'] = round($enemy['enemy_level'] * 2.5) + rand(1, 20);
			$user['enemy_gold'] += $enemy['enemy_level'] * 12;
		}
	}

?>