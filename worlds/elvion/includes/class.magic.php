<?php

	class Magic {

		public const MANA_SCROLL_BLESS		= 5;
		public const MANA_SCROLL_TP			= 8;
		public const MANA_SCROLL_HEAL		= 2;
		public const MANA_SCROLL_LEECH		= 9;

		public const PLAYER_EFFECT_BLESS	= 1;
		public const PLAYER_EFFECT_REGEN	= 2;
		public const PLAYER_EFFECT_LEECH	= 3;

		public function __construct() {
			
		}
		
		private function need_mana($mana) {
			die('{"info":"Вы пытаетесь произнести заклинание, но чувствуете, что магических сил недостаточно. Нужно '.strval($mana).' маны!"}');
		}
		
		public function use_scroll_leech($item_ident) {
			global $user;
			$mana = self::MANA_SCROLL_LEECH;
			$effect = self::PLAYER_EFFECT_LEECH;
			if ($user['char_mana_cur'] >= $mana) {
				$user['class']['item']->modify($item_ident, -1);
				$user['char_mana_cur'] -= $mana;
				$user['char_effect'] = $effect;
				User::update("char_effect=".$user['char_effect']);
				$result = ',"char_effect":"'.$user['char_effect'].'","char_mana_cur":"'.$user['char_mana_cur'].'","char_mana_max":"'.$user['char_mana_max'].'"';
				return $result;
			} else $this->need_mana($mana);
		}
		
		public function use_scroll_bless($item_ident) {
			global $user;
			$mana = self::MANA_SCROLL_BLESS;
			$effect = self::PLAYER_EFFECT_BLESS;
			if ($user['char_mana_cur'] >= $mana) {
				$user['class']['item']->modify($item_ident, -1);
				$user['char_mana_cur'] -= $mana;
				$user['char_effect'] = $effect;
				User::update("char_effect=".$user['char_effect']);
				$result = ',"char_effect":"'.$user['char_effect'].'","char_mana_cur":"'.$user['char_mana_cur'].'","char_mana_max":"'.$user['char_mana_max'].'"';
				return $result;
			} else $this->need_mana($mana);
		}
		
		public function use_scroll_tp($item_ident) {
			global $user;
			$mana = self::MANA_SCROLL_TP;
			if ($user['char_mana_cur'] >= $mana) {
				$user['class']['item']->modify($item_ident, -1);
				$user['char_mana_cur'] -= $mana;
				User::update("char_mana_cur=".$user['char_mana_cur']);
				$result = ',"action":"Перед вами открывается магический портал!|Войти!|index.php?action=magictower","char_mana_cur":"'.$user['char_mana_cur'].'","char_mana_max":"'.$user['char_mana_max'].'"';
				return $result;
			} else $this->need_mana($mana);
		}

		public function use_scroll_heal($item_ident) {
			global $user;
			$mana = self::MANA_SCROLL_HEAL;
			if ($user['char_mana_cur'] >= $mana) {
				$user['class']['item']->modify($item_ident, -1);
				$user['char_mana_cur'] -= $mana;
				$user['class']['player']->heal();
				User::update("char_life_cur=".$user['char_life_cur'].",char_mana_cur=".$user['char_mana_cur']);
				$result = ',"char_life_cur":"'.$user['char_life_cur'].'","char_life_max":"'.$user['char_life_max'].'","char_mana_cur":"'.$user['char_mana_cur'].'","char_mana_max":"'.$user['char_mana_max'].'"';
				return $result;
			} else $this->need_mana($mana);
		}

	}

?>