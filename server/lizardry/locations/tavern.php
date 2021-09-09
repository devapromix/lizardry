<?php

if ($action == 'tavern') {
	$res =
		"Таверна|Краткое описание таверны."."\n";
	if (($char_gold >= 10)&&($char_life_cur < $char_life_max))
		$res = $res . "Снять комнату на ночь|index.php?action=rest_in_tavern"."\n";
	if (($char_gold >= 10)&&($char_food < 7))
		$res = $res . "Купить провизию|index.php?action=buy_food_in_tavern"."\n";
		$res = $res . "Выйти в город|index.php?action=town"."\n";
}

if ($action == 'rest_in_tavern') {
	if ($char_gold < 10)
		$res = die(
		"Таверна|У вас недостаточно золота!"."\n".
		"Выйти в город|index.php?action=town"."\n"
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
		"Выйти в город|index.php?action=town"."\n"
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

?>