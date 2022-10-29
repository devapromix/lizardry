<?php

	class Player {
		
		const RACE_HUMAN 	= 0;
		const RACE_ELF 		= 1;
		const RACE_DWARF 	= 2;
		const RACE_LIZARD 	= 3;
		
		public function __construct() {
			
		}
		
		function get_life($level) {
			return ($level * 5) + 25;
		}

		public function get_level_exp($level) {
			return $level * (($level - 1) + 100);
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