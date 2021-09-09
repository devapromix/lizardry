<?php

if ($action == 'town') {
	$res =
		"Главная Площадь|Вы находитесь на главной площади города.".all_response()."\n";
		$res = $res . "Лес|index.php?action=forest"."\n";
		$res = $res . "Таверна|index.php?action=tavern"."\n";
		$res = $res . "Банк|index.php?action=bank"."\n";
}

?>