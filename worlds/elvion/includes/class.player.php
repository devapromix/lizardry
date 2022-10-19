<?php

	class Player {
		
		public function __construct() {
			
		}
		
		public function heal() {
			global $user;
			$user['char_life_cur'] = $user['char_life_max'];
		}
		
		public function rest() {
			global $user;
			$this->heal();
			$user['char_mana_cur'] += rand(2, 3);
			if ($user['char_mana_cur'] > $user['char_mana_max'])
				$user['char_mana_cur'] = $user['char_mana_max'];
		}
		
		
	}

?>