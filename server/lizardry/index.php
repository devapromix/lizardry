<?php
$res = '0';

include 'common/common.php';

$action = $_GET['action'];
$amount = $_GET['amount'];

if (file_exists('characters/character.'.$username.'.php')) {
	require_once 'characters/character.'.$username.'.php';
	if (($userpass != '')&&($userpass == $user_pass)) {
		if ($action == 'login') {
			$res = '1';
		}
		if ($action == 'get_character_info') {
			$res = 
			$char_name."\n".
			$char_level."\n".
			$char_exp."\n".
			$char_food."\n".
			$char_gold."\n".
			$char_bank."\n".
			$char_equip_weapon."\n".
			$char_equip_armor."\n".
			$char_damage_min."\n".
			$char_damage_max."\n".
			$char_armor."\n".

			$char_str."\n".
			$char_dex."\n".
			$char_int."\n".
			$char_per."\n".
			$char_life_cur."\n".
			$char_life_max."\n".
			$char_mana_cur."\n".
			$char_mana_max."\n".
			
			$char_inv_hppotion."\n".
			
			$char_x."\n".
			$char_y."\n".
			
			$char_stat_kills."\n".
			$char_stat_deads."\n";
			
			$char_monster."\n";
		}
		if ($action == 'get_gold_info') {
			$res = $char_gold."\n".
			$char_bank."\n";			
		}
		if ($action == 'deposit') {
			if ($amount <= 0)
				$res = die('e1');
			if ($amount > $char_gold)
				$res = die('e2');
			$char_gold = $char_gold - $amount;
			$char_bank = $char_bank + $amount;
			save_character();
			$res = $char_gold."\n".
			$char_bank."\n";			
		}
		if ($action == 'withdraw') {
			if ($amount <= 0)
				$res = die('e1');
			if ($amount > $char_bank)
				$res = die('e2');
			$char_bank = $char_bank - $amount;
			$char_gold = $char_gold + $amount;
			save_character();
			$res = $char_gold."\n".
			$char_bank."\n";			
		}
		if ($action == 'get_inn_info') {
			$res = $char_gold."\n".
			$char_food."\n".			
			$char_life_cur."\n".
			$char_life_max."\n".
			$char_mana_cur."\n".
			$char_mana_max."\n";
		}
		if ($action == 'get_food') {
			if ($char_gold < 10)
				$res = die('e1');
			if ($char_food >= 7)
				$res = die('e2');
			$char_gold = $char_gold - 10;
			$char_food++;
			save_character();
			$res = $char_gold."\n".
			$char_food."\n";
		}
		if ($action == 'get_room') {
			if ($char_gold < 10)
				$res = die('e1');
			$char_gold = $char_gold - 10;
			$char_life_cur = $char_life_max;
			$char_mana_cur = $char_mana_max;
			save_character();
			$res = $char_gold."\n".
			$char_life_max."\n".
			$char_mana_max."\n";
		}
		if ($action == 'get_inventory') {
			$res = $char_gold."\n".			
			$char_inv_hppotion."\n";
		}
		if ($action == 'get_healer_info') {
			$res = $char_gold."\n".			
			$char_life_cur."\n".
			$char_life_max."\n".
			$char_mana_cur."\n".
			$char_mana_max."\n";
		}
		if ($action == 'get_rest_info') {
			$res = $char_food."\n".			
			$char_life_cur."\n".
			$char_life_max."\n".
			$char_mana_cur."\n".
			$char_mana_max."\n";
		}
		if ($action == 'healer') {
			if ($char_gold < 10)
				$res = die('e1');
			$char_gold = $char_gold - 10;
			$char_life_cur = $char_life_max;
			$char_mana_cur = $char_mana_max;
			save_character();
			$res = $char_gold."\n".			
			$char_life_max."\n".
			$char_mana_max."\n";
		}
		if ($action == 'rest') {
			if ($char_food <= 0)
				$res = die('e1');
			if ($char_life_cur <= 0)
				$res = die('e2');
			$char_life_cur = $char_life_max;
			$char_mana_cur = $char_mana_max;
			$char_food--;
			save_character();
			$res = $char_food."\n".			
			$char_life_max."\n".
			$char_mana_max."\n";
		}
		if ($action == 'move_west') {
			$char_x--;
			save_character();
			$res = $char_x."\n".
			$char_y."\n";
		}
		if ($action == 'move_east') {
			$char_x++;
			save_character();
			$res = $char_x."\n".
			$char_y."\n";
		}
		if ($action == 'move_north') {
			$char_y--;
			save_character();
			$res = $char_x."\n".
			$char_y."\n";
		}
		if ($action == 'move_south') {
			$char_y++;
			save_character();
			$res = $char_x."\n".
			$char_y."\n";
		}
		if ($action == 'revive') {
			$char_life_cur = rand(1, 5);
			$char_mana_cur = 0;
			save_character();
			$res = $char_life_cur."\n".
			$char_life_max."\n".
			$char_mana_cur."\n".
			$char_mana_max."\n";
		}
		if ($action == 'gen_monster') {
			if ($char_monster == 0)
				$char_monster = rand(1, 9);
			save_character();
			$res = $char_monster."\n";
		}
		if ($action == 'atk_monster') {
			$char_monster = rand(1, 9);
			$char_life_cur = $char_life_cur - rand(1, 5);
			if ($char_life_cur < 0) {
				$char_stat_deads = $char_stat_deads + 1;
				$char_life_cur = 0;
				$char_monster = 0;
				$char_gold = 0;
			}
			if ($char_life_cur > 0) {
				$char_stat_kills = $char_stat_kills + 1;
				$char_gold = $char_gold + rand(5, 9);
			}
			save_character();
			$res = $char_monster."\n".
			$char_gold."\n".
			$char_life_cur."\n".
			$char_life_max."\n";
		}
		
		// Lizardry
		if ($action == 'in_town') {
			$res =
				"Главная Площадь|Вы находитесь на главной площади города.".all_response()."\n";
				$res = $res . "Таверна|index.php?action=tavern"."\n";
		}
		if ($action == 'tavern') {
			$res =
				"Таверна|Краткое описание таверны."."\n";
			if (($char_gold >= 10)&&($char_life_cur < $char_life_max))
				$res = $res . "Снять комнату на ночь|index.php?action=rest_in_tavern"."\n";
			if (($char_gold >= 10)&&($char_food < 7))
				$res = $res . "Купить провизию|index.php?action=buy_food_in_tavern"."\n";
				$res = $res . "Покинуть Таверну|index.php?action=in_town"."\n";
		}
		if ($action == 'rest_in_tavern') {
			if ($char_gold < 10)
				$res = die(
				"Таверна|У вас недостаточно золота!"."\n".
				"Покинуть Таверну|index.php?action=in_town"."\n"
				);
			$char_gold = $char_gold - 10;
			$char_life_cur = $char_life_max;
			save_character();
			$res =
				"Таверна|Вы выспались и полны сил.".rest_response()."\n";
				$res = $res . "Выйти из комнаты|index.php?action=tavern"."\n";
		}
		if ($action == 'buy_food_in_tavern') {
			if ($char_gold < 10)
				$res = die(
				"Таверна|У вас недостаточно золота!"."\n".
				"Покинуть Таверну|index.php?action=in_town"."\n"
				);
			if ($char_food < 7) {
				$char_gold = $char_gold - 10;
				$char_food = $char_food + 1;
				save_character();
				$res =
					"Таверна|Вы купили один мешок провианта.".rest_response()."\n";
				$res = $res . "Назад|index.php?action=tavern"."\n";
			} else {
				$res = "Назад|index.php?action=tavern"."\n";
			}
		}
	}
}

echo $res;
?>