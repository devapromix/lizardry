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
		
		public function item_ident_by_index($item_index) {
			global $user;
			$result = 0;
			$items = json_decode($user['char_inventory'], true);
			for($i = 0; $i < count($items); $i++) {
				$item = $items[$i];
				$item_id = $item['id'];
				if ($i == ($item_index - 1)) {
					$result = $item_id;
					break;
				}
			}
			return $result;
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

		public function gold_trade($type) {
			global $user, $tb_item, $connection;

			$query = "SELECT * FROM ".$tb_item." WHERE item_type=".$type;
			$result = mysqli_query($connection, $query) 
				or die('{"error":"Ошибка считывания данных: '.mysqli_error($connection).'"}');
			$items = mysqli_fetch_all($result, MYSQLI_ASSOC);

			$gold = 0;
			foreach ($items as $item) {
				$id = $item['item_ident'];
				if ($this->has_item($id)) {
					$count = item_count($id);
					if ($count > 0) {
						$price = $price = $this->get_price($type, $item['item_price'], $count);
						$user['char_gold'] += $price;
						$gold += $price;
						item_modify($id, -$count);
						save_to_log($item['item_name'].' (x'.$count.') - предмет(ы) продан(ы).');
					}
				}
			}

			update_user_table("char_gold=".$user['char_gold']);

			return $gold;
		}
		
		public function buy_empty_elixir($count = 1) {
			global $user;
			if ($user['char_gold'] < 100) die('{"info":"Нужно не менее 100 золотых монет!"}');
			add_item(EMPTY_ELIX, $count);
			$user['char_gold'] -= 100;
			update_user_table("char_gold=".$user['char_gold']);
			$user['log'] = 'Вы купили Пустой Флакон.';
		}

	}

?>