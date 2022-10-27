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
		
		public function pickup_all() {
			global $user, $tb_item, $connection;
	
			$r = '';
	
			return $r;
		}
		
		public function get_slot_ident($item_slot) {
			global $user;
			return $user['item_slot_'.strval($item_slot)]; 
		}
		
	}

?>