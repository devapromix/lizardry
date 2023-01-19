<?php

	class Location {

		public const SHOP_ARMOR				= 1;
		public const SHOP_WEAPON			= 2;
		public const SHOP_ALCHEMY			= 3;
		public const SHOP_MAGIC				= 4;
		public const TAVERN					= 7;
		public const BANK					= 9;
		
		public const REGION_VILMAR			= 1;
		public const REGION_EYRINOR			= 11;

		public const RAND_PLACE_COUNT 		= 7;

		public function __construct() {
			
		}
		
		public static function addlink($title, $link, $n = 0) {
			global $user;
			$user['links'][$n]['title'] = $title;
			$user['links'][$n]['link'] = $link;
		}
		
		public function shades() {
			Location::get_title_and_description('shades');
		}
		
		public function after_travel() {
			global $user;
			Location::get_title_and_description('after_travel');
			$user['links'] = array();
			$this->go_to_the_gate('Идти к воротам в город');
		}

		public function go_to_the_town($t = 'Вернуться в город', $n = 0) {
			Location::addlink($t, 'index.php?action=town', $n);
		}

		public function go_to_the_graveyard($t = 'Идти на кладбище', $n = 0) {
			Location::addlink($t, 'index.php?action=graveyard', $n);
		}

		public function go_to_the_gate($t = 'Идти в сторону города', $n = 0) {
			Location::addlink($t, 'index.php?action=gate', $n);
		}		
		
		public static function pickup_link() {
			Location::addlink('Взять!', 'index.php?action=pickup_loot&lootslot=1', 1);
		}
		
		public function check_travel_req($level, $food, $gold) {
			global $user;
			if ($user['char_life_cur'] <= 0) die('{"error":"Вам сначала нужно вернуться к жизни!"}');
			if ($user['char_level'] < $level) die('{"info":"Для путешествия в другой регион нужен '.$level.'-й уровень!"}');
			if ($user['char_food'] < $food) die('{"info":"Возьмите в дорогу не менее '.$food.'-х мешков провизии!"}');
			if ($user['char_gold'] < $gold) die('{"info":"Возьмите в дорогу не менее '.$gold.' золотых монет!"}');
		}

		public function travel_req($level, $food, $gold) {
			return ' Но нужно выполнить определенные условия:#Уровень героя - не менее '.$level.'-го.#С собой иметь не менее '.$food.'-x пакетов с провиантом.#Стоимость путешествия - '.$gold.' золотых монет.';
		}

		public function get_region_town_name($region_ident) {
			global $user, $tb_regions, $connection;
			$query = "SELECT * FROM ".$tb_regions." WHERE region_ident=".$region_ident;
			$result = mysqli_query($connection, $query) 
				or die('{"error":"Ошибка считывания данных: '.mysqli_error($connection).'"}');
			$region = $result->fetch_assoc();
			return $region['region_town_name'];
		}

		public function change_region($region_ident, $food, $gold) {
			global $user, $tb_regions, $connection;
			$query = "SELECT * FROM ".$tb_regions." WHERE region_ident=".$region_ident;
			$result = mysqli_query($connection, $query) 
				or die('{"error":"Ошибка считывания данных: '.mysqli_error($connection).'"}');
			$region = $result->fetch_assoc();
			$user['char_life_cur'] = $user['char_life_max'];
			$user['char_mana_cur'] = $user['char_mana_max'];
			$user['char_region'] = $region['region_ident'];
			$user['char_region_level'] = $region['region_level'];
			$user['char_gold'] -= $gold;
			$user['char_food'] -= $food;
			User::update("char_life_cur=".$user['char_life_cur'].",char_mana_cur=".$user['char_mana_cur'].",char_gold=".$user['char_gold'].",char_food=".$user['char_food'].",char_region=".$user['char_region'].",char_region_level=".$user['char_region_level']);
		}

		public static function get_location($location_ident) {
			global $connection, $tb_locations;
			$query = "SELECT * FROM ".$tb_locations." WHERE location_ident='".$location_ident."'";
			$result = mysqli_query($connection, $query) 
				or die('{"error":"Ошибка считывания данных: '.mysqli_error($connection).'"}');
			return $result->fetch_assoc();
		}

		public function outland($location_ident, $enemies, $prev_location = [], $next_location = [], $is_boss = false) {
			global $user, $res;
			$user['current_outlands'] = $location_ident;
			$this->add_enemies($enemies, $is_boss);	
			$location = self::get_location($location_ident);
			$user['title'] = $location['location_name'];
			$user['char_region_location_name'] = $location['location_name'];
			User::update("char_region_location_name='".$user['char_region_location_name']."'");

			if ($user['char_life_cur'] > 0) {
				$user['description'] = $location['location_description'];
			} else $this->shades();
			$user['frame'] = 'outlands';
			$user['links'] = array();
			$n = 0;
			if ($user['char_life_cur'] > 0) {
				if (count($prev_location) > 0) {
					Location::addlink($prev_location[0], $prev_location[1], $n);
					$n++;
				}
				if (count($prev_location) == 0) {
					$this->go_to_the_gate();
					$n++;
				}
				if (count($next_location) > 0) {
					Location::addlink($next_location[0], $next_location[1], $n);
					$n++;
				}
			} else
				$this->go_to_the_graveyard();

			$res = json_encode($user, JSON_UNESCAPED_UNICODE);

		}

		public function travel_to($action, $do, $regions) {
			global $user;
	
			$travel = false;
			$travel_level = 1;
	
			for ($i = 0; $i < count($regions); $i++) {
				if (($user['char_region'] == $regions[$i]) || ($user['char_region'] == $regions[$i] + 1)) {
					$travel_level = $regions[$i] * 12;
					$travel_food = 3;	
				}
		
			}
	
			$travel_gold = $this->travel_price($travel_level);
	
			for ($i = 0; $i < count($regions); $i++) {
				if (($do == $regions[$i])||($do == $regions[$i] + 1)) {
					$this->check_travel_req($travel_level, $travel_food, $travel_gold);
					$travel = true;
					$this->change_region($do, $travel_food, $travel_gold);
				}
			}
	
			if (!$travel) {
				if ($action == 'stables')
					$user['title'] = 'Конюшни';
				if ($action == 'harbor')
					$user['title'] = 'Гавань';
				if ($action == 'dir_tower')
					$user['title'] = 'Башня Дирижаблей';
				if ($action == 'fly')
					$user['title'] = 'Утес Ветрокрылов';
				if ($action == 'portal')
					$user['title'] = 'Магический Портал';
				if ($user['char_life_cur'] > 0) {
					for ($i = 0; $i < count($regions); $i++) {
						if (($user['char_region'] == $regions[$i])||($user['char_region'] == $regions[$i] + 1)) {
							if ($action == 'stables')
								$user['description'] = 'В городских конюшнях всегда можно найти караванщика, который за звонкую монету готов отвезти вас хоть на край света.';
							if ($action == 'harbor')
								$user['description'] = 'В гавани не многолюдно, но все заняты работой. Здесь достаточно легко отыскать корабль, капитан которого согласится взять вас на борт.';
							if ($action == 'dir_tower')
								$user['description'] = 'На вершине башни пришвартованы несколько дирижаблей и достаточно легко отыскать пилота готового отвезти вас в другой регион.';
							if ($action == 'fly')
								$user['description'] = 'На Утесе всегда много свободных ветрокрылов и не так сложно отыскать погонщика, который согласится отвезти вас в другой город.';
							if ($action == 'portal')
								$user['description'] = 'У Портала всегда можно отыскать мага, который за некоторое денежное вознаграждение согласится отправить вас в другой город.';
							$user['description'] .= $this->travel_req($travel_level, $travel_food, $travel_gold);
							break;
						}
					}
		
				} else $this->shades();
		
				$user['links'] = array();
				if ($user['char_life_cur'] > 0) {

					$this->go_to_the_gate();
					for ($i = 0; $i < count($regions); $i++) {
						if ($user['char_region'] == $regions[$i]) {
							$r = strval($regions[$i] + 1);
							Location::addlink('Путешествие в '.$this->get_region_town_name($r), 'index.php?action='.$action.'&do='.$r.'', 1);
						}
						if ($user['char_region'] == $regions[$i] + 1) {
							$r = strval($regions[$i]);
							Location::addlink('Путешествие в '.$this->get_region_town_name($r), 'index.php?action='.$action.'&do='.$r.'', 1);
						}
					}
		
				} else $this->go_to_the_graveyard();
	
			} else $this->after_travel();
	
			$res = json_encode($user, JSON_UNESCAPED_UNICODE);
	
			return $res;
		}

		public function travel_price($level) {
			return $level * 10;
		}

		public static function get_title_and_description($location_ident) {
			global $user;
			$location = Location::get_location($location_ident);
			$user['title'] = $location['location_name'];
			$user['description'] = $location['location_description'];
		}

		public function random_place() {
			global $user;

			$user['links'] = array();
			Location::addlink('Назад', 'index.php?action='.$user['current_outlands']);
			$frame = 'battle';

			switch ($user['current_random_place']) {
				case 1:
					$user['title'] = 'Лагерь старого алхимика';
					$user['description'] = 'Вы проходите несколько десятков шагов и останавливаетесь у старого вагончика. Недалеко пасется пони, горит костер. У костра сидит старый гном и приветливо машет вам рукой:#-Приветствую, путник!Будь гостем в моем лагере. Я вижу ты ранен - вот возьми эликсир...#Старик протягивает вам эликсир и вы, залпом выпив содержимое флакончика, чувствуете, как уходит усталость и заживляются раны.#-Садись рядом, угощайся и расскажи, что с тобой произошло.#Вы присаживаетесь у костра, достаете и свои припасы и начинаете рассказ...';
					$user['class']['player']->rest();
					User::update("char_life_cur=".$user['char_life_cur'].",char_mana_cur=".$user['char_mana_cur']);
					break;
				case 2:
					$user['title'] = 'Камнепад!!!';
					$user['description'] = 'Вы проходите несколько десятков шагов и внезапно слышите странный гул. Обвал! - краем сознания вдруг осознаете вы и бросаетесь в сторону...';
					$dam = rand($user['char_region_level'] * 3, $user['char_region_level'] * 5);
					$user['char_life_cur'] -= $dam;
					if ($user['char_life_cur'] > 0) {
						$user['description'] .= ' Грохочущая лавина камней проносится совсем рядом, лишь слегка зацепив вас. Вам чудом удалось избежать смерти!';
					} else {
						$user['char_life_cur'] = 0;
						$user['description'] .= ' Но уже слишком поздно и вы оказываетесь на пути гремящей каменной массы. Вы погибли!';
					}			
					User::update("char_life_cur=".$user['char_life_cur']);
					break;
				case 3:
					$user['title'] = 'Невидимый вор!';
					$user['description'] = 'Вы прошли всего несколько десятков шагов, когда заметили какое-то движение. Вор! Вы хватились кошелька на поясе и с сожалением обнаружили, что вас ограбили.';
					$gold = rand($user['char_region_level'] * 30, $user['char_region_level'] * 70);
					if ($user['char_gold'] > $gold) {
						$user['char_gold'] -= $gold;
						$user['description'] .= ' Вору удалось украсть у вас '.$gold.' золотых монет.';
					} else {
						$user['char_gold'] = 0;
						$user['description'] .= ' Вор украл у вас все золото.';
					}
					User::update("char_gold=".$user['char_gold']);
					break;
				case 4:
					$user['class']['item']->gen_alch_loot();
					$user['title'] = 'Сундук алхимика!';
					$user['description'] = 'Пройдя всего несколько десятков шагов, вы внезапно наткнулись на старый сундук. Путем нехитрых манипуляций с замком вы открываете сундук и видите, что в нем лежит '.$user['loot_slot_1_name'].'.';
					$frame = 'get_loot';
					Location::pickup_link();
					break;
				case 5:
					$user['class']['item']->gen_mage_loot();
					$user['title'] = 'Сундук мага!';
					$user['description'] = 'Недалеко от места сражения вы внезапно увидели старый сундук. Замок на нем настолько стар, что легко рассыпается в пыль от одного прикосновения. Вы открываете сундук и видите, что в нем лежит '.$user['loot_slot_1_name'].'.';
					$frame = 'get_loot';
					Location::pickup_link();
					break;
				case 6:
					$user['class']['item']->gen_herb_loot();
					$user['title'] = 'Сумка травника!';
					$user['description'] = 'Решив присесть отдохнуть после тяжелого боя, вы внезапно замечаете на земле небольшую серую сумку, какую обычно используют алхимики для сбора трав и алхимических ингридиентов. Вы открываете сумку и видите, что в ней находится '.$user['loot_slot_1_name'].'.';
					$frame = 'get_loot';
					Location::pickup_link();
					break;
				case 7:
					$gold = rand($user['char_region_level'] * 50, $user['char_region_level'] * 90);
					$user['title'] = 'Сундук с золотом!';
					$user['description'] = 'Вы оглядываете местность после битвы и вдалеке замечаете небольшой сундучок. Подойдя поближе вы видите, что на судучке изображен имперский герб. Кто-то очень важный обронил его здесь. Замок на сундучке выглядит не слишком сложным и после пяти минут сопротивления поддается. Вы открываете сундук и видите, что в нем находится '.strval($gold).' золотых монет. Вы забираете все золото себе.';		
					User::update("char_gold=".$user['char_gold']);
					break;
			}
			return $frame;
		}

		public function gen_random_place() {
			global $user, $connection;
	
			$user['current_random_place'] = 0;
			if (rand(1, 5) == 1)
				$user['current_random_place'] = rand(1, self::RAND_PLACE_COUNT);
	
			User::update("current_random_place=".$user['current_random_place']);
		}

		public function rest_in_tavern_cost() {
			global $user;
			return round($user['char_region_level'] * 10) + round(($user['char_region_level'] * 10) / 2);
		}

		public function food_in_tavern_cost() {
			global $user;
			return $user['char_region_level'] * 10;
		}
		
		private function add_enemies($enemy_idents, $is_boss = false) {
			global $user;
			for($i = 1; $i <= 3; $i++) {
				$r = $enemy_idents[array_rand($enemy_idents)];
				if ($is_boss == true) {
					if ($i == 1)
						$r = $enemy_idents[array_rand($enemy_idents)];
					else
						$r = Enemy::EMPTY_ID;
					if (Boss::is_killed($user['char_region']))
						$r = Enemy::EMPTY_ID;
				}
				$e = 0;
				if (rand(1, 20) == 1)
					$e = rand(1, 10);
				if ($r == Enemy::EMPTY_ID)
					$e = 0;
				Enemy::add($i, $r, $e);
			}
		}
		
		public function get_tavern_name() {
			global $user, $tb_regions, $connection;
			$query = "SELECT * FROM ".$tb_regions." WHERE region_ident=".$user['char_region'];
			$result = mysqli_query($connection, $query) 
				or die('{"error":"Ошибка считывания данных: '.mysqli_error($connection).'"}');
			$region = $result->fetch_assoc();
			return $region['region_tavern_name'];			
		}
		
		public function get_graveyard_description() {
			global $user, $tb_regions, $connection;
			$query = "SELECT region_graveyard_description FROM ".$tb_regions." WHERE region_ident=".$user['char_region'];
			$result = mysqli_query($connection, $query) 
				or die('{"error":"Ошибка считывания данных: '.mysqli_error($connection).'"}');
			$region = $result->fetch_assoc();
			return $region['region_graveyard_description'];			
		}
		
		public function get_town_name() {
			global $user, $tb_regions, $connection;
			$query = "SELECT region_town_name FROM ".$tb_regions." WHERE region_ident=".$user['char_region'];
			$result = mysqli_query($connection, $query) 
				or die('{"error":"Ошибка считывания данных: '.mysqli_error($connection).'"}');
			$region = $result->fetch_assoc();
			return $region['region_town_name'];			
		}
		
		public function get_town_description() {
			global $user, $tb_regions, $connection;
			$query = "SELECT region_town_description FROM ".$tb_regions." WHERE region_ident=".$user['char_region'];
			$result = mysqli_query($connection, $query) 
				or die('{"error":"Ошибка считывания данных: '.mysqli_error($connection).'"}');
			$region = $result->fetch_assoc();
			return $region['region_town_description'];			
		}
		
		public function get_welcome_phrase($category_ident, $flag = true) {
			global $connection, $tb_phrases;
			$v = ($flag)?" OR category=0":"";
			$query = "SELECT text FROM ".$tb_phrases." WHERE category=".$category_ident.$v." ORDER BY RAND() LIMIT 1";
			$result = mysqli_query($connection, $query) 
				or die('{"error":"Ошибка считывания данных: '.mysqli_error($connection).'"}');
			$phrase = $result->fetch_assoc();
			return $phrase['text'];
		}
		
		public static function get_race_start_location($charrace) {
			switch($charrace) {
				case Player::RACE_ELF:
					return self::REGION_EYRINOR;
					break;
				default:
					return self::REGION_VILMAR;
					break;
			}
		}

	}

?>