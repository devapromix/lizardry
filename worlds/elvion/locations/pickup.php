<?php

if ($action == 'pickup_loot') {

	$user['title'] = 'Находка!';
	
	$user['description'] = pickup_equip_item();

	addlink('Назад', 'index.php?action='.$user['current_outlands']);
	$res = json_encode($user, JSON_UNESCAPED_UNICODE);
}

if ($action == 'use_item') {
	if ($itemindex > 0) {
		$item_ident = item_ident_by_index($itemindex);
		if (($item_ident > 0)&&(has_item($item_ident)))
			item_modify($item_ident, -1);
	}
	$res = 999;
}

?>