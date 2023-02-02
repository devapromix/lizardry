<?php

	class Effects {
		
		public const BLESS		= 1;
		public const REGEN		= 2;
		public const LEECH		= 3;
		public const REFLECT	= 4;
		public const DESTRUCT	= 5;
		public const IMMUN		= 6;
		public const DECAY		= 7;
		
		public const PORTAL		= 999;
		
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
		
		public static function get_effects() {
			global $tb_effects, $connection;

			$query = "SELECT * FROM ".$tb_effects;
			$result = mysqli_query($connection, $query) 
				or die('{"error":"Ошибка считывания данных: '.mysqli_error($connection).'"}');
			$effects = $result->fetch_all(MYSQLI_ASSOC);

			return json_encode($effects, JSON_UNESCAPED_UNICODE);
		}

	}

?>