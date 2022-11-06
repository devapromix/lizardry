<?php

	class Item {
		
		// Категории предметов
		const CAT_ARMOR 		= 0;
		const CAT_WEAPON 		= 1;
		const CAT_FOOD			= 75;
		const CAT_TROPHY		= 21;
		const CAT_ING			= 30;
		
		// Эликсиры
		const EMPTY_ELIX 		= 600;
		const HP_ELIX 			= 601;
		const MP_ELIX 			= 602;
		const ST_ELIX 			= 603;
		const RF_ELIX 			= 604;
		const TROLL_ELIX		= 605;

		// Ингредиенты
		const MASH_HERB			= 750;
		const HP_HERB			= 751;
		const MP_HERB			= 752;
		const ST_HERB			= 753;
		const TROLL_BLOOD		= 811;
		
		public function __construct() {

		}
		
		public function get_price($type, $price, $count) {
			global $user;
			$r = 0;
			switch($type) {
				case self::CAT_ARMOR: case self::CAT_WEAPON:
					$r = $count * round($price * 0.35);
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
		
		public function buy_empty_elixir($count = 1) {
			global $user;
			if ($user['char_gold'] < 100) die('{"info":"Нужно не менее 100 золотых монет!"}');
			$this->add(self::EMPTY_ELIX, $count);
			$user['char_gold'] -= 100;
			User::update("char_gold=".$user['char_gold']);
			$user['log'] = 'Вы купили Пустой Флакон.';
		}

		private function add($id, $count = 1) {
			global $user;
			if ($this->has_item($id)) {
				$this->modify($id, $count);
			} else {
				$items = json_decode($user['char_inventory'], true);
				$n = count($items);
				$items[$n]['id'] = $id;
				$items[$n]['count'] = $count;
				$user['char_inventory'] = json_encode($items, JSON_UNESCAPED_UNICODE);
				User::update("char_inventory='".$user['char_inventory']."'");
			}
		}

		public function make_elixir($elix_id, $t, $ing1_name, $ing1_id, $ing1_amount, $ing2_name, $ing2_id, $ing2_amount) {
			if ($this->has_item(self::EMPTY_ELIX)) {
				if ($this->has_item($ing1_id)) {
					$amount = $this->amount($ing1_id);
					if ($amount >= $ing1_amount) {
						if ($this->has_item($ing2_id)) {
							$amount = $this->amount($ing2_id);
							if ($amount >= $ing2_amount) {
								$this->modify($ing1_id, -$ing1_amount);
								$this->modify($ing2_id, -$ing2_amount);
								$this->modify(self::EMPTY_ELIX, -1);
								$this->add($elix_id);
								return $t;
							} die('{"info":"Нужно больше количество компонента - '.$ing2_name.'!"}');
						} die('{"info":"Нужен компонент - '.$ing2_name.'!"}');
					} die('{"info":"Нужно больше количество компонента - '.$ing1_name.'!"}');
				} die('{"info":"Нужен компонент - '.$ing1_name.'!"}');
			} else die('{"info":"Нужен Пустой Флакон!"}');
		}

		public function item_info($item_ident) {
			global $user, $tb_item, $connection;
			if ($user['char_life_cur'] <= 0) die('{"error":"Вам сначала нужно вернуться к жизни!"}');

			$query = "SELECT * FROM ".$tb_item." WHERE item_ident=".$item_ident;
			$result = mysqli_query($connection, $query) 
				or die('{"error":"Ошибка считывания данных: '.mysqli_error($connection).'"}');
			$item = $result->fetch_assoc();

			$ef = '';
			$eq = '';
			switch($item['item_type']) {
				case self::CAT_ARMOR:
					$ef = 'Броня: '.$item['item_armor'];
					$eq = 'Доспех.';
					break;
				case self::CAT_WEAPON:
					$ef = 'Урон: '.$item['item_damage_min'].'-'.$item['item_damage_max'];
					$eq = 'Одноручный Меч.';
					break;
				case 8:
					$ef = 'Полностью исцеляет от ран.';
					$eq = 'Целительный Эликсир.';
					break;
				case 9:
					$ef = 'Восполняет всю ману.';
					$eq = 'Магический Эликсир.';
					break;
				case 10:
					$ef = 'Исцеляет и увеличивает запас здоровья на 20%.';
					$eq = 'Магический Эликсир.';
					break;
				case 11:
					$ef = 'Восполнение здоровья и маны.';
					$eq = 'Магический Эликсир.';
					break;
				case 12:
					$ef = 'Регенерация.';
					$eq = 'Целительный Эликсир.';
					break;
				case 13:
					$ef = 'Покрывает оружие ядом на '.strval($item['item_level']*5).' битв.';
					$eq = 'Яд.';
					break;
				case self::CAT_TROPHY:
					$ef = 'Часть тела монстра.';
					$eq = 'Трофей.';
					break;
				case 25:
					$ef = 'Открывает портал в город.';
					$eq = 'Магический свиток.';
					break;
				case 26:
					$ef = 'Полностью исцеляет от ран.';
					$eq = 'Магический свиток.';
					break;
				case 27:
					$ef = 'Весь урон становится максимальным.';
					$eq = 'Магический свиток.';
					break;
				case 28:
					$ef = 'Необходим для создания эликсиров.';
					$eq = '';
					break;
				case self::CAT_ING:
					$ef = 'Алхимический ингредиент для зелий.';
					$eq = 'Ингредиент.';
					break;
				case self::CAT_FOOD:
					$ef = 'Провизия.';
					$eq = '';
					break;
				case 76:
					$ef = 'Открывает замки.';
					$eq = '';
					break;
				case 77:
					$ef = 'Источник света.';
					$eq = '';
					break;
			}
			if ($ef == '')
				die('{"item":""}');
			else 
				if ($eq != '')
					die('{"item":"'.$item['item_name'].'\n'.$eq.' Уровень предмета: '.$item['item_level'].'\n'.$ef.'"}');
				else
					die('{"item":"'.$item['item_name'].'\nУровень предмета: '.$this->get_region_item_level($item['item_level']).'\n'.$ef.'"}');
		}

		private function item_values($item_ident) {
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

		public function add_item_to_shop($item_slot, $item_ident) {
			global $user;
			$user['item_slot_'.strval($item_slot)] = $item_ident;
			$user['item_slot_'.strval($item_slot).'_values'] = $this->item_values($item_ident);
			User::update('item_slot_'.strval($item_slot).'='.$user['item_slot_'.strval($item_slot)]);
		}

		public function use_item($item_ident) {
			global $user, $tb_item, $connection;
			if ($user['char_life_cur'] <= 0) die('{"error":"Вам сначала нужно вернуться к жизни!"}');

			$query = "SELECT * FROM ".$tb_item." WHERE item_ident=".$item_ident;
			$result = mysqli_query($connection, $query) 
				or die('{"error":"Ошибка считывания данных: '.mysqli_error($connection).'"}');
			$item = $result->fetch_assoc();

			$result = '';

			if ($user['char_level'] < $this->get_region_item_level($item['item_level'])) die('{"info":"Нужен уровень выше!"}');

			switch($item['item_type']) {
				case 8:
					$this->modify($item_ident, -1);
					$item_level = $item['item_level'];
					$user['class']['player']->heal();
					User::update("char_life_cur=".$user['char_life_cur']);
					$result = ',"char_life_cur":"'.$user['char_life_cur'].'","char_life_max":"'.$user['char_life_max'].'"';
					break;
				case 9:
					$this->modify($item_ident, -1);
					$item_level = $item['item_level'];
					$user['char_mana_cur'] = $user['char_mana_max'];
					User::update("char_mana_cur=".$user['char_mana_cur']);
					$result = ',"char_mana_cur":"'.$user['char_mana_cur'].'","char_mana_max":"'.$user['char_mana_max'].'"';
					break;
				case 10:
					$this->modify($item_ident, -1);
					$item_level = $item['item_level'];
					$user['char_life_cur'] = $user['char_life_max'] + round($user['char_life_max'] / 5);
					User::update("char_life_cur=".$user['char_life_cur']);
					$result = ',"char_life_cur":"'.$user['char_life_cur'].'","char_life_max":"'.$user['char_life_max'].'"';
					break;
				case 11:
					$this->modify($item_ident, -1);
					$item_level = $item['item_level'];
					$user['class']['player']->heal();
					$user['char_mana_cur'] = $user['char_mana_max'];
					User::update("char_life_cur=".$user['char_life_cur'].",char_mana_cur=".$user['char_mana_cur']);
					$result = ',"char_life_cur":"'.$user['char_life_cur'].'","char_life_max":"'.$user['char_life_max'].'","char_mana_cur":"'.$user['char_mana_cur'].'","char_mana_max":"'.$user['char_mana_max'].'"';
					break;
				case 12:
					$this->modify($item_ident, -1);
					$user['char_effect'] = Magic::PLAYER_EFFECT_REGEN;
					User::update("char_effect=".$user['char_effect']);			
					$result = ',"char_effect":"'.$user['char_effect'].'"';
					break;
				case 25:
					$result = $user['class']['magic']->use_scroll_tp($item_ident);
					break;
				case 26:
					$result = $user['class']['magic']->use_scroll_heal($item_ident);
					break;
				case 27:
					$result = $user['class']['magic']->use_scroll_bless($item_ident);
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

		public function inv_item_list($type) {
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
						break;
					case self::CAT_WEAPON:
						$r .= 'Ваше оружие:';
						break;
					case self::CAT_TROPHY:
						$r .= 'Ваши трофеи:';
						break;
					case self::CAT_ING:
						$r .= 'Ваши ингредиенты:';
						break;
				}
				$r .= '#============#'.$t.'============#Всего: '.$gold.' зол.';
			}

			return $r;
		}

		private function get_region_item_level($item_level) {
			$result = 1;
			if ($item_level > 1)
				$result = ($item_level - 1) * 12;
			return $result;
		}

		public function save_loot_slot($item_ident, $item_name, $item_type, $item_slot = 1) {
			global $user;
	
			$user['loot_slot_'.strval($item_slot)] = $item_ident;
			$user['loot_slot_'.strval($item_slot).'_name'] = $item_name;
			$user['loot_slot_'.strval($item_slot).'_type'] = $item_type;

			if ($user['loot_slot_'.strval($item_slot)] > 0)
				User::update("loot_slot_".strval($item_slot)."=".$user['loot_slot_'.strval($item_slot)].",loot_slot_".strval($item_slot)."_type=".$user['loot_slot_'.strval($item_slot).'_type'].",loot_slot_".strval($item_slot)."_name='".$user['loot_slot_'.strval($item_slot).'_name']."'");
		}

		private function gen_random_loot($loot_type_array, $loot_level) {
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
			$this->gen_random_loot([8,9,10,11,12,25,26,27,28,self::CAT_ING], 1);
		}

		private function gen_alch_loot() {
			$this->gen_random_loot([8,9,10,11,12,28], 1);
		}

		private function gen_mage_loot() {
			$this->gen_random_loot([9,25,26,27], 1);
		}

		public function gen_herb_loot() {
			$this->gen_random_loot([self::CAT_ING], 1);
		}

		public function gen_loot() {
			global $user;
	
			// Обычные враги
			if (($user['enemy_boss'] == 0) && ($user['enemy_champion'] == 0)) {
				// Трофеи 25%
				if (rand(1, 4) == 1) {
					$this->gen_trophy_loot();
				} else 
				// Обычный лут: зелья, свитки, травы 10%
				if (rand(1, 10) == 1) {
					$this->gen_else_loot();
				} else
				// Экипировка 1%
				if (rand(1, 100) == 1) {
					$this->gen_equip_loot();
				}
			// Чемпионы 
			} elseif (($user['enemy_champion'] > 1) && ($user['enemy_boss'] == 0)) {
				// Экипировка 5%
				if (rand(1, 20) == 1) {
					$this->gen_equip_loot();
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

		public function equip_item($item_ident, $item_amount = 1) {
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
					Event::add(2, $user['char_name'], 1, $user['char_gender'], $item['item_name']);
					break;
				case self::CAT_WEAPON:
					$this->add($user['char_equip_weapon_ident']);
					$user['char_equip_weapon_name'] = $item['item_name'];
					$user['char_equip_weapon_ident'] = $item['item_ident'];
					$user['char_gold'] -= $item['item_price'];
					$user['char_damage_min'] = $item['item_damage_min'];
					$user['char_damage_max'] = $item['item_damage_max'];
					User::update("char_equip_weapon_name='".$user['char_equip_weapon_name']."',char_equip_weapon_ident=".$user['char_equip_weapon_ident'].",char_damage_min=".$user['char_damage_min'].",char_damage_max=".$user['char_damage_max'].",char_gold=".$user['char_gold']);
					Event::add(2, $user['char_name'], 1, $user['char_gender'], $item['item_name']);
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
						Event::add(2, $user['char_name'], 1, $user['char_gender'], $item['item_name']);
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
						Event::add(2, $user['char_name'], 1, $user['char_gender'], $item['item_name']);
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

		private function amount($id) {
			global $user;
			$result = 0;
			$items = json_decode($user['char_inventory'], true);
			for($i = 0; $i < count($items); $i++) {
				$item = $items[$i];
				$item_id = $item['id'];
				if ($item_id == $id) {
					$result = $item['count'];
					break;
				}
			}
			return $result;
		}

		public function modify($id, $value) {
			global $user;
			$items = json_decode($user['char_inventory'], true);
			for($i = 0; $i < count($items); $i++) {
				$item = $items[$i];
				$item_id = $item['id'];
				if ($item_id == $id) {
					$count = $item['count'];
					$count += $value;
					if ($count <= 0) {
						unset($items[$i]);
					} else {
						$items[$i]['count'] = $count;
					}
					$items = array_values($items);
					$user['char_inventory'] = json_encode($items, JSON_UNESCAPED_UNICODE);
					User::update("char_inventory='".$user['char_inventory']."'");
					break;
				}
			}
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