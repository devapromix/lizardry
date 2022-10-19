<?php

	class Player {
		
		public function __construct() {
			
		}
		
		public static function rest() {
			global $user;
			$user['char_life_cur'] = $user['char_life_max'];
			$user['char_mana_cur'] += rand(2, 3);
			if ($user['char_mana_cur'] > $user['char_mana_max'])
				$user['char_mana_cur'] = $user['char_mana_max'];
		}
		
		
	}

?>