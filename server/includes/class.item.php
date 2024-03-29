<?php

	class Item {
		
		// Категории предметов
		public const CAT_ARMOR 				= 0;
		public const CAT_WEAPON 			= 1;
		public const CAT_ELIXIR_HP			= 8;
		public const CAT_ELIXIR_MP			= 9;
		public const CAT_ELIXIR_ST			= 10;
		public const CAT_ELIXIR_RF			= 11;
		public const CAT_ELIXIR_TROLL		= 12;
		public const CAT_ELIXIR_ANTIDOTE	= 13;
		public const CAT_FOOD				= 75;
		public const CAT_TROPHY				= 21;
		public const CAT_SCROLL_TP			= 25;
		public const CAT_SCROLL_DECAY		= 26;
		public const CAT_SCROLL_BLESS		= 27;
		public const CAT_ELIXIR_EMPTY		= 28;
		public const CAT_ING				= 30;
		public const CAT_SCROLL_LEECH		= 40;
		public const CAT_SCROLL_REFLECT		= 41;
		public const CAT_SCROLL_DESTRUCT	= 42;
		public const CAT_PICKLOCK			= 76;
		
		// Отмычка
		public const LOCKPICK	 			= 951;
		
		// Эликсиры
		public const ELIXIR_EMPTY 			= 600;
		public const ELIXIR_HP 				= 601;
		public const ELIXIR_MP 				= 602;
		public const ELIXIR_ST 				= 603;
		public const ELIXIR_RF 				= 604;
		public const ELIXIR_TROLL			= 605;

		// Ингредиенты
		public const MASH_HERB				= 750;
		public const HP_HERB				= 751;
		public const MP_HERB				= 752;
		public const ST_HERB				= 753;
		public const TROLL_BLOOD			= 811;
		
		public function __construct() {

		}
		
		public function get_price(int $type, int $price, int $count) {
			global $user;
			$r = 0;
			switch($type) {
				case self::CAT_ARMOR: case self::CAT_WEAPON: case self::CAT_SCROLL_LEECH:
					$r = $count * round($price * 0.30);
					break;
				case self::CAT_TROPHY:
					$r = $count * round($price * $user['char_region_level'] * 0.35);
					break;
				case self::CAT_ING:
					$r = $count * round($price * 0.85);
					break;
			}
			return $r;
		}
		
		public function item_ident_by_index(int $item_index) {
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
		
		public function get_slot_ident(int $item_slot) {
			global $user;
			return $user['item_slot_'.strval($item_slot)]; 
		}
		
		public function gold_trade(int $type) {
			global $user, $tb_item, $connection;

			$query = "SELECT * FROM ".$tb_item." WHERE item_type=".$type;
			$result = mysqli_query($connection, $query) 
				or die('{"error":"Ошибка считывания данных: '.mysqli_error($connection).'"}');
			$items = mysqli_fetch_all($result, MYSQLI_ASSOC);

			$gold = 0;
			foreach ($items as $item) {
				$id = $item['item_ident'];
				if ($this->has_item($id)) {
					$count = $this->amount($id);
					if ($count > 0) {
						$price = $price = $this->get_price($type, $item['item_price'], $count);
						$user['char_gold'] += $price;
						$gold += $price;
						$this->modify($id, -$count);
					}
				}
			}

			User::update("char_gold=".$user['char_gold']);

			return $gold;
		}
		
		public function buy_empty_elixir(int $count = 1) {
			global $user;
			if ($user['char_gold'] < 100) die('{"info":"Нужно не менее 100 золотых монет!"}');
			$this->add(self::ELIXIR_EMPTY, $count);
			$user['char_gold'] -= 100;
			User::update("char_gold=".$user['char_gold']);
			$user['log'] = 'Вы купили Пустой Флакон.';
		}

		private function add(int $item_ident, int $item_count = 1) {
			global $user;
			$strbox = new StringBox($user['char_inventory']);
			$strbox->add($item_ident, $item_count);
			$user['char_inventory'] = $strbox->get_string();
			User::update("char_inventory='".$user['char_inventory']."'");
		}

		public function make_elixir($elix_id, $t, $ing1_name, $ing1_id, $ing1_amount, $ing2_name, $ing2_id, $ing2_amount) {
			if ($this->has_item(self::ELIXIR_EMPTY)) {
				if ($this->has_item($ing1_id)) {
					$amount = $this->amount($ing1_id);
					if ($amount >= $ing1_amount) {
						if ($this->has_item($ing2_id)) {
							$amount = $this->amount($ing2_id);
							if ($amount >= $ing2_amount) {
								$this->modify($ing1_id, -$ing1_amount);
								$this->modify($ing2_id, -$ing2_amount);
								$this->modify(self::ELIXIR_EMPTY, -1);
								$this->add($elix_id);
								return $t;
							} die('{"info":"Нужно большеe количество компонента - '.$ing2_name.'!"}');
						} die('{"info":"Нужен компонент - '.$ing2_name.'!"}');
					} die('{"info":"Нужно большеe количество компонента - '.$ing1_name.'!"}');
				} die('{"info":"Нужен компонент - '.$ing1_name.'!"}');
			} else die('{"info":"Нужен Пустой Флакон!"}');
		}

		private function item_values(int $item_ident) {
			global $user, $tb_item, $connection;
			$query = "SELECT * FROM ".$tb_item." WHERE item_ident=".$item_ident;
			$result = mysqli_query($connection, $query) 
				or die('{"error":"Ошибка считывания данных: '.mysqli_error($connection).'"}');
			$item = $result->fetch_assoc();
			switch($item['item_type']) {
				case self::CAT_ARMOR:
					return $item['item_name'].','.$item['item_armor'].','.$item['item_level'].','.$item['item_price'];
					break;
				case self::CAT_WEAPON:
					return $item['item_name'].','.$item['item_damage_min'].'-'.$item['item_damage_max'].','.$item['item_level'].','.$item['item_price'];
					break;
				default:
					return $item['item_name'].','.strval($item['item_level']).','.$this->get_region_item_level($item['item_level']).','.$item['item_price'];
					break;
			}
		}

		public function add_item_to_shop(int $item_slot, int $item_ident) {
			global $user;
			$user['item_slot_'.strval($item_slot)] = $item_ident;
			$user['item_slot_'.strval($item_slot).'_values'] = $this->item_values($item_ident);
			User::update('item_slot_'.strval($item_slot).'='.$user['item_slot_'.strval($item_slot)]);
		}

		public function use_item(int $item_ident) {
			global $user, $tb_item, $connection;
			if ($user['char_life_cur'] <= 0) die('{"error":"Вам сначала нужно вернуться к жизни!"}');

			$query = "SELECT * FROM ".$tb_item." WHERE item_ident=".$item_ident;
			$result = mysqli_query($connection, $query) 
				or die('{"error":"Ошибка считывания данных: '.mysqli_error($connection).'"}');
			$item = $result->fetch_assoc();

			$result = '';

			if ($user['char_level'] < $this->get_region_item_level($item['item_level'])) die('{"info":"Нужен уровень выше!"}');

			switch($item['item_type']) {
				case self::CAT_ELIXIR_HP:
					$this->modify($item_ident, -1);
					$item_level = $item['item_level'];
					$user['class']['player']->heal();
					User::update("char_life_cur=".$user['char_life_cur']);
					$result = ',"char_life_cur":"'.$user['char_life_cur'].'","char_life_max":"'.$user['char_life_max'].'"';
					break;
				case self::CAT_ELIXIR_MP:
					$this->modify($item_ident, -1);
					$item_level = $item['item_level'];
					$user['char_mana_cur'] = $user['char_mana_max'];
					User::update("char_mana_cur=".$user['char_mana_cur']);
					$result = ',"char_mana_cur":"'.$user['char_mana_cur'].'","char_mana_max":"'.$user['char_mana_max'].'"';
					break;
				case self::CAT_ELIXIR_ST:
					$this->modify($item_ident, -1);
					$item_level = $item['item_level'];
					$user['char_life_cur'] = $user['char_life_max'] + round($user['char_life_max'] / 5);
					User::update("char_life_cur=".$user['char_life_cur']);
					$result = ',"char_life_cur":"'.$user['char_life_cur'].'","char_life_max":"'.$user['char_life_max'].'"';
					break;
				case self::CAT_ELIXIR_RF:
					$this->modify($item_ident, -1);
					$item_level = $item['item_level'];
					$user['class']['player']->heal();
					$user['char_mana_cur'] = $user['char_mana_max'];
					User::update("char_life_cur=".$user['char_life_cur'].",char_mana_cur=".$user['char_mana_cur']);
					$result = ',"char_life_cur":"'.$user['char_life_cur'].'","char_life_max":"'.$user['char_life_max'].'","char_mana_cur":"'.$user['char_mana_cur'].'","char_mana_max":"'.$user['char_mana_max'].'"';
					break;
				case self::CAT_ELIXIR_TROLL:
					$this->modify($item_ident, -1);
					$user['class']['effect']->add(Effects::REGEN);			
					$result = ',"char_effects":'.json_encode($user['char_effects'], JSON_UNESCAPED_UNICODE);
					break;
				case self::CAT_ELIXIR_ANTIDOTE:
					$this->modify($item_ident, -1);
					$user['class']['effect']->add(Effects::IMMUN);			
					$result = ',"char_effects":'.json_encode($user['char_effects'], JSON_UNESCAPED_UNICODE);
					break;
				case self::CAT_SCROLL_TP:
					$result = $user['class']['magic']->use_scroll($item_ident, 8, Effects::PORTAL);
					break;
				case self::CAT_SCROLL_DECAY:
					$result = $user['class']['magic']->use_scroll($item_ident, 7, Effects::DECAY);
					break;
				case self::CAT_SCROLL_BLESS:
					$result = $user['class']['magic']->use_scroll($item_ident, 5, Effects::BLESS);
					break;
				case self::CAT_SCROLL_LEECH:
					$result = $user['class']['magic']->use_scroll($item_ident, 9, Effects::LEECH);
					break;
				case self::CAT_SCROLL_REFLECT:
					$result = $user['class']['magic']->use_scroll($item_ident, 10, Effects::REFLECT);
					break;
				case self::CAT_SCROLL_DESTRUCT:
					$result = $user['class']['magic']->use_scroll($item_ident, 5, Effects::DESTRUCT);
					break;
				case self::CAT_FOOD:
					if ($user['char_food'] >= 7) die('{"info":"У вас полный запас провизии!"}');
					$this->modify($item_ident, -1);
					$user['char_food']++;
					User::update("char_food=".$user['char_food']);
					$result = ',"char_food":"'.$user['char_food'].'"';
					break;
			}
			return $result;
		}

		public function inv_item_list(int $type) {
			global $user, $tb_item, $connection;

			$query = "SELECT * FROM ".$tb_item." WHERE item_type=".$type;
			$result = mysqli_query($connection, $query) 
				or die('{"error":"Ошибка считывания данных: '.mysqli_error($connection).'"}');
			$items = mysqli_fetch_all($result, MYSQLI_ASSOC);

			$r = '';
			$t = '';
			$gold = 0;
			foreach ($items as $item) {
				$id = $item['item_ident'];
				if ($user['class']['item']->has_item($id)) {
					$count = $this->amount($id);
					$price = $user['class']['item']->get_price($type, $item['item_price'], $count);
					$t .= $item['item_name'].' '.$count.'x - '.$price.' зол.#';
					$gold += $price;
				}
			}

			if ($t != '') {
				switch($type) {
					case self::CAT_ARMOR:
						$r .= 'Ваши брони:';
						$r .= '#============#'.$t.'============#Всего: '.$gold.' зол.';
						break;
					case self::CAT_WEAPON:
						$r .= 'Ваше оружие:';
						$r .= '#============#'.$t.'============#Всего: '.$gold.' зол.';
						break;
					case self::CAT_TROPHY:
						$r .= 'Ваши трофеи:';
						$r .= '#============#'.$t.'============#Всего: '.$gold.' зол.';
						break;
					case self::CAT_ING:
						$r .= 'Ваши ингредиенты:';
						$r .= '#============#'.$t.'============#Всего: '.$gold.' зол.';
						break;
					case self::CAT_SCROLL_LEECH:
						$r .= 'Ваши cвитки:';
						$r .= '#============#'.$t.'============#Всего: '.$gold.' зол.##';
						break;
				}
			}
			return $r;
		}

		private function get_region_item_level(int $item_level) {
			$result = 1;
			if ($item_level > 1)
				$result = ($item_level - 1) * 12;
			return $result;
		}

		public function save_loot_slot(int $item_ident, $item_name, int $item_type, int $item_slot = 1) {
			global $user;
	
			$user['loot_slot_'.strval($item_slot)] = $item_ident;
			$user['loot_slot_'.strval($item_slot).'_name'] = $item_name;
			$user['loot_slot_'.strval($item_slot).'_type'] = $item_type;

			if ($user['loot_slot_'.strval($item_slot)] > 0)
				User::update("loot_slot_".strval($item_slot)."=".$user['loot_slot_'.strval($item_slot)].",loot_slot_".strval($item_slot)."_type=".$user['loot_slot_'.strval($item_slot).'_type'].",loot_slot_".strval($item_slot)."_name='".$user['loot_slot_'.strval($item_slot).'_name']."'");
		}

		private function gen_random_loot($loot_type_array, int $loot_level) {
			global $user, $tb_item, $connection;

			$loot_type = $loot_type_array[array_rand($loot_type_array)];	
	
			$query = "SELECT item_ident,item_name,item_level FROM ".$tb_item." WHERE item_level=".$loot_level." AND item_type=".$loot_type." ORDER BY RAND() LIMIT 1";
			$result = mysqli_query($connection, $query) 
				or die('{"error":"Ошибка считывания данных: '.mysqli_error($connection).'"}');
			$item = $result->fetch_assoc();

			$this->save_loot_slot($item['item_ident'], $item['item_name'], $loot_type);
		}

		private function gen_trophy_loot() {
			global $user, $tb_item, $tb_enemy, $connection;

			$query = "SELECT enemy_trophy FROM ".$tb_enemy." WHERE enemy_ident=".$user['enemy_ident'];
			$result = mysqli_query($connection, $query) 
				or die('{"error":"Ошибка считывания данных: '.mysqli_error($connection).'"}');
			$enemy = $result->fetch_assoc();

			$trophy_ident = $enemy['enemy_trophy'];	
			if ($trophy_ident > 0) {
				$query = "SELECT item_name FROM ".$tb_item." WHERE item_ident=".$trophy_ident;
				$result = mysqli_query($connection, $query) 
					or die('{"error":"Ошибка считывания данных: '.mysqli_error($connection).'"}');
				$item = $result->fetch_assoc();

				$this->save_loot_slot($trophy_ident, $item['item_name'], self::CAT_TROPHY);
			}
		}
	
		private function gen_equip_loot() {
			global $user;
			$loot_level = $this->get_loot_level();
			if ($loot_level % 2 != 0)
				$this->gen_random_loot([self::CAT_ARMOR], $loot_level);
			else
				$this->gen_random_loot([self::CAT_WEAPON], $loot_level);
		}

		private function gen_else_loot() {
			$this->gen_random_loot([
				self::CAT_ELIXIR_HP,
				self::CAT_ELIXIR_MP,
				self::CAT_ELIXIR_ST,
				self::CAT_ELIXIR_RF,
				self::CAT_ELIXIR_TROLL,
				self::CAT_ELIXIR_ANTIDOTE,
				self::CAT_SCROLL_TP,
				self::CAT_SCROLL_DECAY,
				self::CAT_SCROLL_BLESS,
				self::CAT_SCROLL_LEECH,
				self::CAT_SCROLL_REFLECT,
				self::CAT_SCROLL_DESTRUCT,
				self::CAT_ELIXIR_EMPTY,
				self::CAT_ING,
				self::CAT_PICKLOCK
				], 1);
		}

		public function gen_alch_loot() {
			$this->gen_random_loot([
				self::CAT_ELIXIR_HP,
				self::CAT_ELIXIR_MP,
				self::CAT_ELIXIR_ST,
				self::CAT_ELIXIR_RF,
				self::CAT_ELIXIR_TROLL,
				self::CAT_ELIXIR_ANTIDOTE,
				self::CAT_ELIXIR_EMPTY
				], 1);
		}

		private function gen_thief_loot() {
			$this->gen_random_loot([
				self::CAT_PICKLOCK
				], 1);
		}
		public function gen_mage_loot() {
			$this->gen_random_loot([
				self::CAT_ELIXIR_MP,
				self::CAT_SCROLL_TP,
				self::CAT_SCROLL_DECAY,
				self::CAT_SCROLL_BLESS,
				self::CAT_SCROLL_LEECH,
				self::CAT_SCROLL_REFLECT,
				self::CAT_SCROLL_DESTRUCT
				], 1);
		}

		public function gen_herb_loot() {
			$this->gen_random_loot([self::CAT_ING], 1);
		}

		public function gen_loot() {
			global $user;
	
			// Обычные враги
			if (($user['enemy_boss'] == 0) && ($user['enemy_champion'] == 0)) {
				// Трофеи
				if (rand(1, 4) == 1) {
					$this->gen_trophy_loot();
				} else 
				// Обычный лут: зелья, свитки, травы...
				if (rand(1, 10) == 1) {
					$this->gen_else_loot();
				} else
				// Экипировка
				if (rand(1, 100) == 1) {
					$this->gen_equip_loot();
				}
			// Чемпионы 
			} elseif (($user['enemy_champion'] > 1) && ($user['enemy_boss'] == 0)) {
				// Экипировка
				if (rand(1, 20) == 1) {
					$this->gen_equip_loot();
				// Обычный лут: зелья, свитки, травы...
				} else {
					$this->gen_else_loot();
				}
			// Уникальные
			} elseif (($user['enemy_champion'] == 1) && ($user['enemy_boss'] == 0)) {
				// Экипировка
				$this->gen_equip_loot();		
			// Босс
			} elseif ($user['enemy_boss'] > 0) {
				// Экипировка
				$this->gen_equip_loot();
			}
		}

		public function gen_chest_i_loot() {
			if (rand(1, 100) <= 95) {
				$this->gen_else_loot();
			} else {
				$this->gen_equip_loot();
			}
		}
		
		public function gen_chest_ii_loot() {
			if (rand(1, 100) <= 50) {
				$this->gen_else_loot();
			} else {
				$this->gen_equip_loot();
			}
		}
		
		public function gen_chest_iii_loot() {
			$this->gen_equip_loot();
		}

		public function equip_item(int $item_ident, int $item_amount = 1) {
			global $user, $tb_item, $connection;
			$query = "SELECT * FROM ".$tb_item." WHERE item_ident=".$item_ident;
			$result = mysqli_query($connection, $query) 
				or die('{"error":"Ошибка считывания данных: '.mysqli_error($connection).'"}');
			$item = $result->fetch_assoc();

			if ($user['char_gold'] < ($item['item_price'] * $item_amount)) die('{"info":"Нужно больше золота!"}');
			if ($user['char_level'] < $item['item_level']) die('{"info":"Нужен уровень выше!"}');

			switch($item['item_type']) {
				case self::CAT_ARMOR:
					$this->add($user['char_equip_armor_ident']);
					$user['char_equip_armor_name'] = $item['item_name'];
					$user['char_equip_armor_ident'] = $item['item_ident'];
					$user['char_gold'] -= $item['item_price'];
					$user['char_armor'] = $item['item_armor'];
					User::update("char_equip_armor_name='".$user['char_equip_armor_name']."',char_equip_armor_ident=".$user['char_equip_armor_ident'].",char_armor=".$user['char_armor'].",char_gold=".$user['char_gold']);
					Event::add(Event::ITEM, $user['char_name'], 1, $user['char_gender'], $item['item_name']);
					break;
				case self::CAT_WEAPON:
					$this->add($user['char_equip_weapon_ident']);
					$user['char_equip_weapon_name'] = $item['item_name'];
					$user['char_equip_weapon_ident'] = $item['item_ident'];
					$user['char_gold'] -= $item['item_price'];
					$user['char_damage_min'] = $item['item_damage_min'];
					$user['char_damage_max'] = $item['item_damage_max'];
					User::update("char_equip_weapon_name='".$user['char_equip_weapon_name']."',char_equip_weapon_ident=".$user['char_equip_weapon_ident'].",char_damage_min=".$user['char_damage_min'].",char_damage_max=".$user['char_damage_max'].",char_gold=".$user['char_gold']);
					Event::add(Event::ITEM, $user['char_name'], 1, $user['char_gender'], $item['item_name']);
					break;
				default:
					$user['char_gold'] -= $item['item_price'] * $item_amount;
					$this->add($item_ident, $item_amount);
					User::update("char_gold=".$user['char_gold']);
					break;
			}
		}

		public function pickup_equip_item() {
			global $user, $tb_item, $connection;
			$query = "SELECT * FROM ".$tb_item." WHERE item_ident=".$user['loot_slot_1'];
			$result = mysqli_query($connection, $query) 
				or die('{"error":"Ошибка считывания данных: '.mysqli_error($connection).'"}');
			$item = $result->fetch_assoc();

			if ($user['char_level'] < $item['item_level']) die('{"info":"Нужен уровень выше!"}');

			$r = '';
			switch($item['item_type']) {
				case self::CAT_ARMOR:
					if ($item['item_ident'] > $user['char_equip_armor_ident']) {
						$this->add($user['char_equip_armor_ident']);
						$r .= 'Вы снимаете свой старый '.$user['char_equip_armor_name'];
						$user['char_equip_armor_name'] = $item['item_name'];
						$user['char_equip_armor_ident'] = $item['item_ident'];
						$user['char_armor'] = $item['item_armor'];
						User::update("char_equip_armor_name='".$user['char_equip_armor_name']."',char_equip_armor_ident=".$user['char_equip_armor_ident'].",char_armor=".$user['char_armor'].",loot_slot_1=0,loot_slot_1=''");
						$r .= ' и надеваете новый '.$user['char_equip_armor_name'].'.';
						Event::add(Event::ITEM, $user['char_name'], 1, $user['char_gender'], $item['item_name']);
					} else {
						$r = 'Вы забираете '.$item['item_name'].' себе.';
						$this->add($item['item_ident']);
					}
					break;
				case self::CAT_WEAPON:
					if ($item['item_ident'] > $user['char_equip_weapon_ident']) {
						$this->add($user['char_equip_weapon_ident']);
						$r .= 'Вы бросаете свой старый '.$user['char_equip_weapon_name'];
						$user['char_equip_weapon_name'] = $item['item_name'];
						$user['char_equip_weapon_ident'] = $item['item_ident'];
						$user['char_damage_min'] = $item['item_damage_min'];
						$user['char_damage_max'] = $item['item_damage_max'];
						User::update("char_equip_weapon_name='".$user['char_equip_weapon_name']."',char_equip_weapon_ident=".$user['char_equip_weapon_ident'].",char_damage_min=".$user['char_damage_min'].",char_damage_max=".$user['char_damage_max'].",loot_slot_1=0,loot_slot_1=''");
						$r .= ' и берете в руки новый '.$user['char_equip_weapon_name'].'.';
						Event::add(Event::ITEM, $user['char_name'], 1, $user['char_gender'], $item['item_name']);
					} else {
						$r = 'Вы забираете '.$item['item_name'].' себе.';
						$this->add($item['item_ident']);
					}
					break;
				default:
					$r = 'Вы забираете '.$item['item_name'].' себе.';
					$this->add($item['item_ident']);
					break;
			}
			return $r;
		}

		public function has_item(int $item_ident) {
			global $user;
			$strbox = new StringBox($user['char_inventory']);
			return $strbox->has($item_ident);
		}

		private function amount(int $item_ident) {
			global $user;
			$strbox = new StringBox($user['char_inventory']);
			return $strbox->amount($item_ident);
		}

		public function modify(int $item_ident, int $item_count) {
			global $user;
			$strbox = new StringBox($user['char_inventory']);
			$strbox->modify($item_ident, $item_count);
			$user['char_inventory'] = $strbox->get_string();
			User::update("char_inventory='".$user['char_inventory']."'");
		}

		public static function get_items() {
			global $tb_item, $connection;

			$query = "SELECT * FROM ".$tb_item;
			$result = mysqli_query($connection, $query) 
				or die('{"error":"Ошибка считывания данных: '.mysqli_error($connection).'"}');
			$items = $result->fetch_all(MYSQLI_ASSOC);

			return json_encode($items, JSON_UNESCAPED_UNICODE);
		}

	}

?>