<?php

	class Magic {

		public const PLAYER_EFFECT_BLESS	= 1;
		public const PLAYER_EFFECT_REGEN	= 2;
		public const PLAYER_EFFECT_LEECH	= 3;
		public const PLAYER_EFFECT_REFLECT	= 4;
		public const PLAYER_EFFECT_DESTRUCT	= 5;
		public const PLAYER_EFFECT_IMMUN	= 6;
		public const PLAYER_EFFECT_DECAY	= 7;
		
		public const PLAYER_EFFECT_PORTAL	= 999;

		public function __construct() {
			
		}
		
		private function need_mana($need_mana) {
			die('{"info":"Вы пытаетесь произнести заклинание, но чувствуете, что магических сил недостаточно. Нужно '.strval($need_mana).' маны!"}');
		}
		
		public function use_scroll($item_ident, $need_mana, $effect_ident) {
			global $user;
			if ($user['char_mana_cur'] >= $need_mana) {
				$user['class']['item']->modify($item_ident, -1);
				$user['char_mana_cur'] -= $need_mana;
				User::update("char_mana_cur=".$user['char_mana_cur']);
				switch ($effect_ident) {
					case self::PLAYER_EFFECT_PORTAL:
						$result = ',"action":"Перед вами открывается магический портал!|Войти!|index.php?action=magictower","char_mana_cur":"'.$user['char_mana_cur'].'","char_mana_max":"'.$user['char_mana_max'].'"';
						break;
					default:
						$user['class']['effect']->add($effect_ident);
						$result = ',"char_effects":'.json_encode($user['char_effects'], JSON_UNESCAPED_UNICODE).',"char_mana_cur":"'.$user['char_mana_cur'].'","char_mana_max":"'.$user['char_mana_max'].'"';
						break;
				}
				return $result;
			} else $this->need_mana($need_mana);
		}

	}

?>