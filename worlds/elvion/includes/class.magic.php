<?php

	class Magic {

		const MANA_SCROLL_BLESS		= 5;
		const MANA_SCROLL_TP		= 8;
		const MANA_SCROLL_HEAL		= 10;

		const PLAYER_EFFECT_BLESS	= 1;

		public function __construct() {
			
		}
		
		private function need_mana($mana) {
			die('{"info":"Вы пытаетесь произнести заклинание, но чувствуете, что магических сил недостаточно. Нужно '.strval($mana).' маны!"}');
		}
		
		public function use_scroll_bless($item_ident) {
			global $user;
			$mana = self::MANA_SCROLL_BLESS;
			$effect = self::PLAYER_EFFECT_BLESS;
			if ($user['char_mana_cur'] >= $mana) {
				item_modify($item_ident, -1);
				$user['char_mana_cur'] -= $mana;
				$user['char_effect'] = $effect;
				update_user_table("char_effect=".$user['char_effect']);
				$result = ',"char_effect":"'.$user['char_effect'].'","char_mana_cur":"'.$user['char_mana_cur'].'","char_mana_max":"'.$user['char_mana_max'].'"';
				return $result;
			} else $this->need_mana($mana);
		}
		
		public function use_scroll_tp($item_ident) {
			global $user;
			if ($user['char_mana_cur'] >= self::MANA_SCROLL_TP) {
				item_modify($item_ident, -1);
				$user['char_mana_cur'] -= self::MANA_SCROLL_TP;
				update_user_table("char_mana_cur=".$user['char_mana_cur']);
				$result = ',"action":"Перед вами открывается магический портал!|Войти!|index.php?action=magictower","char_mana_cur":"'.$user['char_mana_cur'].'","char_mana_max":"'.$user['char_mana_max'].'"';
				return $result;
			} else $this->need_mana(self::MANA_SCROLL_TP);
		}

		public function use_scroll_heal($item_ident) {
			global $user;
			if ($user['char_mana_cur'] >= self::MANA_SCROLL_HEAL) {
				item_modify($item_ident, -1);
				$user['char_mana_cur'] -= self::MANA_SCROLL_HEAL;
				$user['class']['player']->heal();
				update_user_table("char_life_cur=".$user['char_life_cur'].",char_mana_cur=".$user['char_mana_cur']);
				$result = ',"char_life_cur":"'.$user['char_life_cur'].'","char_life_max":"'.$user['char_life_max'].'","char_mana_cur":"'.$user['char_mana_cur'].'","char_mana_max":"'.$user['char_mana_max'].'"';
				return $result;
			} else $this->need_mana(self::MANA_SCROLL_HEAL);
		}

	}

?>