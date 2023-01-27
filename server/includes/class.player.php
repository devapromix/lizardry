<?php

	class Player {
		
		public const RACE_HUMAN 	= 0;
		public const RACE_ELF 		= 1;
		public const RACE_DWARF 	= 2;
		public const RACE_LIZARD 	= 3;
		
		public function __construct() {
			
		}
		
		public function get_life(int $level) {
			return ($level * 5) + 25;
		}

		public function get_level_exp(int $level) {
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