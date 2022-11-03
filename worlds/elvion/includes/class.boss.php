<?php

	class Boss {
		
		const START_ID = 800;
		
		static public function kill($region_ident) {
			global $user;
			$user['stat_boss_kills']++;
			$bosses = json_decode($user['char_bosses'], true);
			$n = count($bosses);
			$bosses[$n]['id'] = $region_ident;
			$bosses[$n]['killed'] = 1;
			$user['char_bosses'] = json_encode($bosses, JSON_UNESCAPED_UNICODE);
			update_user_table("char_bosses='".$user['char_bosses']."'");
		}

		static public function is_killed($region_ident) {
			global $user;
			$bosses = $user['char_bosses'];
			$pos = strripos($bosses, '"id":"'.$region_ident.'"');
			if ($pos === false) {
				return false;
			} else {
				return true;
			}
		}
		
		static public function gen($enemy) {
			global $user;
			$user['enemy_boss'] = 1;
			$user['enemy_champion'] = 1;
			$user['enemy_name'] = $enemy['enemy_name'].' '.$enemy['enemy_rand_name'];
			$user['enemy_name'] .= ' (Босс)';
		}

	}

?>