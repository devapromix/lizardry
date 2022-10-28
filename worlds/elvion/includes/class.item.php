<?php

	class Item {
		
		public function __construct() {

		}
		
		public function get_price($type, $price, $count) {
			global $user;
			$r = 0;
			switch($type) {
				case 0: case 1:
					$r = $count * round($price * 0.35);
					break;
				case 21:
					$r = $count * round($price * $user['char_region'] * 0.35);
					break;
				case 30:
					$r = $count * round($price * 0.85);
					break;
			}
			return $r;
		}
		
		public function get_loot_level() {
			global $user;
			$r = $user['enemy_level'];
			if ($r > $user['char_level'])
				$r = $user['char_level'];
			return $r;
		}
		
		public function pickup_all() {
			global $user, $tb_item, $connection;
	
			$r = '';
	
			return $r;
		}
		
		public function get_slot_ident($item_slot) {
			global $user;
			return $user['item_slot_'.strval($item_slot)]; 
		}
		
		public function has_item($id) {
			global $user;
			$inventory = $user['char_inventory'];
			$pos = strripos($inventory, '"id":"'.$id.'"');
			if ($pos === false) {
				return false;
			} else {
				return true;
			}
		}

	}

?>