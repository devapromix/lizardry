<?php

if ($action == 'campfire') {
	
	if ($user['char_life_cur'] <= 0) die('{"error":"Вам сначала нужно вернуться к жизни!"}');
	if ($user['char_food'] <= 0) die('{"info":"Вы не можете здесь отдыхать - нет провизии!"}');
	if ($user['char_life_cur'] == $user['char_life_max']) die('{"info":"Вам незачем отдыхать - вы здоровы и полны сил!"}');

	$location = Location::get_location($action);
	$user['title'] = $location['location_name'];
	$user['description'] = $location['location_description'];
	$user['frame'] = $action;
	$user['links'] = array();
	Location::addlink('Затушить костер', 'index.php?action='.$user['current_outlands']);
	if (rand(1, 5) == 1)
		$user['class']['item']->gen_herb_loot();
	else
		$user['class']['item']->save_loot_slot(0, '', 0);
	if ($user['loot_slot_1'] > 0) {
		switch($user['loot_slot_1_type']) {
			case Item::CAT_ING:
				$user['description'] .= '##Ваше внимание привлекает '.$user['loot_slot_1_name'].'.#';
				break;
		}
		$user['frame'] = 'get_loot';
		Location::pickup_link();
	}
	$user['class']['player']->rest();
	$user['char_food']--;
	User::update("char_food=".$user['char_food'].",char_life_cur=".$user['char_life_cur'].",char_mana_cur=".$user['char_mana_cur']);
	$user['log'] = 'Вы хорошо отдохнули и набрались сил.';

	$res = json_encode($user, JSON_UNESCAPED_UNICODE);

}

?>