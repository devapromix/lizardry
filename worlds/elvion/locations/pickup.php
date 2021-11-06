<?php

if ($action == 'pickup_loot') {

	$user['title'] = 'Находка!';
	
	$user['description'] = pickup_equip_item();

	addlink('Назад', 'index.php?action='.$user['current_outlands']);
	$res = json_encode($user, JSON_UNESCAPED_UNICODE);
}

?>