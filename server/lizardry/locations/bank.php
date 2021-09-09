<?php

if ($action == 'bank') {
	$res = "Банк|Краткое описание банка. Золото на руках: ".$char_gold.". Золото в банке: ".$char_bank.".\n";
//	if (($char_gold >= 10)&&($char_life_cur < $char_life_max))
//		$res = $res . "Снять комнату на ночь|index.php?action=rest_in_tavern"."\n";
//	if (($char_gold >= 10)&&($char_food < 7))
//		$res = $res . "Купить провизию|index.php?action=buy_food_in_tavern"."\n";
	$res = $res . "Выйти в город|index.php?action=town"."\n";
}

?>