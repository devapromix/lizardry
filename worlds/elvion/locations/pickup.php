<?php

if ($action == 'pickup_loot') {

	$user['title'] = 'Находка!';
	
	$user['description'] = pickup_equip_item();

	addlink('Назад', 'index.php?action='.$user['current_outlands']);
	$res = json_encode($user, JSON_UNESCAPED_UNICODE);
}

if ($action == 'item_info') {
	
	if ($itemindex > 0) {
		$item_ident = item_ident_by_index($itemindex);
		if (($item_ident > 0)&&(has_item($item_ident))){
			item_info($item_ident);
		}
	}
	$res = '{"inventory":'.json_encode($user['char_inventory'], JSON_UNESCAPED_UNICODE).'}';
}

if ($action == 'use_item') {
	
	$h = '';
	if ($itemindex > 0) {
		$item_ident = item_ident_by_index($itemindex);
		if (($item_ident > 0)&&(has_item($item_ident))){
			item_modify($item_ident, -1);
			$h = use_item($item_ident);
		}
	}
	$res = '{"inventory":'.json_encode($user['char_inventory'], JSON_UNESCAPED_UNICODE).$h.'}';
}

?>