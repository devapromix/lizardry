<?php

	class Enemy {
		
		public const EMPTY_ID = 999;
		
		static public function gen(int $enemy_ident, int $enemy_elite) {
			global $user, $tb_enemy, $connection;
			$query = "SELECT * FROM ".$tb_enemy." WHERE enemy_ident=".$enemy_ident;
			$result = mysqli_query($connection, $query) 
				or die('{"error":"Ошибка считывания данных: '.mysqli_error($connection).'"}');
			$enemy = $result->fetch_assoc();	

			$un_champion_name = '';
			while ($un_champion_name == '') {
				$query = "SELECT enemy_rand_name FROM ".$tb_enemy." ORDER BY RAND() LIMIT 1";
				$result = mysqli_query($connection, $query) 
					or die('{"error":"Ошибка считывания данных: '.mysqli_error($connection).'"}');
				$un_enemy = $result->fetch_assoc();
				$un_champion_name = trim($un_enemy['enemy_rand_name']);
			}

			$user['enemy_boss'] = 0;
			$user['enemy_champion'] = 0;

			$user['enemy_name'] = $enemy['enemy_name'];
	
			if ($enemy_elite > 0)
				$user['enemy_champion'] = $enemy_elite;
			
			if ($user['enemy_champion'] > 0) {
				switch($user['enemy_champion']) {
					case 1: // Уникальный
						$user['enemy_name'] = $enemy['enemy_uniq_name'];
						$user['enemy_name'] .= ' '.$un_enemy['enemy_rand_name'].' (Элита)';
						break;
					default:
						$elite_name = array(2 => "Крупень", 
											3 => "Здоровяк",
											4 => "Голиаф",
											5 => "Убийца",
											6 => "Громила",
											7 => "Берсерк",
											8 => "Твердолоб",
											9 => "Титан",
											10 => "Колосс");
						$user['enemy_name'] .= ' ('.$elite_name[$user['enemy_champion']].')';
						break;
				}
			}

			$user['enemy_image'] = $enemy['enemy_image'];
			$user['enemy_level'] = $enemy['enemy_level'];
			$enemy_life = ($user['class']['player']->get_life($enemy['enemy_level']) - 5) + rand(1, 10);

			// Boss
			if ($enemy_ident >= Boss::START_ID)
				Boss::gen($enemy, $enemy_life);
			else {
				// Life
				$user['enemy_life_max'] = $enemy_life;
				if ($user['enemy_champion'] == 2)
					$user['enemy_life_max'] = round($user['enemy_life_max'] * 1.4);
				if ($user['enemy_champion'] == 3)
					$user['enemy_life_max'] = round($user['enemy_life_max'] * 1.5);
				if (($user['enemy_champion'] == 4) or ($user['enemy_champion'] == 1))
					$user['enemy_life_max'] = round($user['enemy_life_max'] * 1.6);
				$user['enemy_life_cur'] = $user['enemy_life_max'];
				// Damage
				$user['enemy_damage_min'] = round($enemy['enemy_level'] * 0.5) - 1;
				$user['enemy_damage_max'] = round($enemy['enemy_level'] * 0.5) + 1;
				if ($user['enemy_champion'] == 1) {
					// Уникальный
					$user['enemy_damage_max'] = round($user['enemy_damage_max'] * (1 + (rand(1, 3) * 0.1)));
				}
				if ($user['enemy_champion'] == 5)
					$user['enemy_damage_max'] = round($user['enemy_damage_max'] * 1.1);
				if ($user['enemy_champion'] == 6)
					$user['enemy_damage_max'] = round($user['enemy_damage_max'] * 1.2);
				if ($user['enemy_champion'] == 7)
					$user['enemy_damage_max'] = round($user['enemy_damage_max'] * 1.3);	
				if ($user['enemy_damage_max'] < 2)
					$user['enemy_damage_max'] = 2;
				if ($user['enemy_damage_min'] < 1)
					$user['enemy_damage_min'] = 1;
				// Armour
				$user['enemy_armor'] = round($enemy['enemy_level'] * 0.5);
				if ($user['enemy_champion'] == 1) {
					// Уникальный
					$user['enemy_armor'] = round($user['enemy_armor'] * (1 + (rand(1, 3) * 0.1)));
				}
				if ($user['enemy_champion'] == 8)
					$user['enemy_armor'] = round($user['enemy_armor'] * 1.1);
				if ($user['enemy_champion'] == 9)
					$user['enemy_armor'] = round($user['enemy_armor'] * 1.2);
				if ($user['enemy_champion'] == 10)
					$user['enemy_armor'] = round($user['enemy_armor'] * 1.3);
				// Experience
				$user['enemy_exp'] = round($enemy['enemy_level'] * 3) + rand(round($enemy['enemy_level'] * 0.1), round($enemy['enemy_level'] * 0.3));
				if ($user['enemy_champion'] == 1)
					$user['enemy_exp'] = round($user['enemy_exp'] * 1.7);
				if ($user['enemy_champion'] >= 2)
					$user['enemy_exp'] = round($user['enemy_exp'] * 1.3);
				//  Gold
				$user['enemy_gold'] = round($enemy['enemy_level'] * 2.5) + rand(1, 20);
				if ($user['enemy_champion'] == 1)
					$user['enemy_gold'] += $enemy['enemy_level'] * 12;
				if ($user['enemy_champion'] >= 2)
					$user['enemy_gold'] += $enemy['enemy_level'] * 7;
			}
			$user['current_random_place'] = 0;
			User::update("enemy_ident=".$enemy_ident.",enemy_name='".$user['enemy_name']."',enemy_image='".$user['enemy_image']."',enemy_level=".$user['enemy_level'].",enemy_boss=".$user['enemy_boss'].",enemy_champion=".$user['enemy_champion'].",enemy_life_max=".$user['enemy_life_max'].",enemy_life_cur=".$user['enemy_life_cur'].",enemy_damage_min=".$user['enemy_damage_min'].",enemy_damage_max=".$user['enemy_damage_max'].",enemy_armor=".$user['enemy_armor'].",enemy_exp=".$user['enemy_exp'].",enemy_gold=".$user['enemy_gold'].",loot_slot_1=0,loot_slot_1_name='',current_random_place=".$user['current_random_place']);
		}
		
		static public function add(int $enemy_slot, int $enemy_ident, int $enemy_elite = 0) {
			global $user, $tb_enemy, $connection;

			$query = "SELECT * FROM ".$tb_enemy." WHERE enemy_ident=".$enemy_ident;
			$result = mysqli_query($connection, $query) 
				or die('{"error":"Ошибка считывания данных: '.mysqli_error($connection).'"}');
			$enemy = $result->fetch_assoc();

			$user['enemy_slot_'.strval($enemy_slot)] = $enemy_ident;
			$user['enemy_slot_'.strval($enemy_slot).'_image'] = $enemy['enemy_image'];
			$user['enemy_slot_'.strval($enemy_slot).'_level'] = $enemy['enemy_level'];
			if (($enemy_ident > Boss::START_ID) && ($enemy_ident < self::EMPTY_ID))
				$enemy_elite = 1;
			$user['enemy_slot_'.strval($enemy_slot).'_elite'] = $enemy_elite;
			User::update("current_outlands='".$user['current_outlands']."',enemy_slot_".strval($enemy_slot)."=".$user['enemy_slot_'.strval($enemy_slot)].",enemy_slot_".strval($enemy_slot)."_image='".$user['enemy_slot_'.strval($enemy_slot).'_image']."',enemy_slot_".strval($enemy_slot)."_level=".$user['enemy_slot_'.strval($enemy_slot).'_level'].",enemy_slot_".strval($enemy_slot)."_elite=".$user['enemy_slot_'.strval($enemy_slot).'_elite']);
		}
		
		static public function get_enemies() {
			global $tb_enemy, $connection;

			$query = "SELECT enemy_image FROM ".$tb_enemy;
			$result = mysqli_query($connection, $query) 
				or die('{"error":"Ошибка считывания данных: '.mysqli_error($connection).'"}');
			$enemies = $result->fetch_all(MYSQLI_ASSOC);

			return json_encode($enemies, JSON_UNESCAPED_UNICODE);
		}

	}

?>