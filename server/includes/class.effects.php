<?php

	class Effects {
		
		public function clear() {
			global $user;
			$user['char_effects'] = '[]';
		}
		
		public function add(int $effect_ident) {
			global $user;
			$strbox = new StringBox($user['char_effects']);
			$strbox->add($effect_ident, 1);
			$user['char_effects'] = $strbox->get_string();
			User::update("char_effects='".$user['char_effects']."'");
		}

		public function has(int $effect_ident) {
			global $user;
			$strbox = new StringBox($user['char_effects']);
			return $strbox->has($effect_ident);
		}
	}

?>