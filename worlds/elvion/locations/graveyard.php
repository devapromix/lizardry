<?php

if ($action == 'graveyard') {

	$user['title'] = 'Городское Кладбище';
	if ($user['char_life_cur'] > 0) {
		
		switch ($user['char_region']) {
			case 1:
				$user['description'] = 'Вы на городском кладбище. Кругом могилы. В самом отдаленном уголке Кладбища находится Старый Склеп.';
				break;
			case 2:
				$user['description'] = 'Вы находитесь на едине с каменными плитами и душами предков.';
				break;
			case 3:
				$user['description'] = 'Вы находитесь на едине с каменными плитами и душами предков.';
				break;
			
		}
		
	}else{
		$user['description'] = 'Ваша душа летает над могилами.';
	}
	
	$user['links'] = array();
	if ($user['char_life_cur'] > 0) {
		$user['links'][0]['title'] = 'Покинуть Кладбище';
		$user['links'][0]['link'] = 'index.php?action=gate';
		switch ($user['char_region']) {
			case 1:
				$user['links'][1]['title'] = 'Осмотреть Склеп';
				$user['links'][1]['link'] = 'index.php?action=crypt';
				break;
		}
	} else {	
		$user['links'][0]['title'] = 'Вернуться к жизни';
		$user['links'][0]['link'] = 'index.php?action=graveyard&do=revive_in_graveyard';	
	}
	
	if ($do == 'revive_in_graveyard') {
		$user['char_life_cur'] = 1;
		$user['char_mana_cur'] = 0;
		update_user_table("char_life_cur=".$user['char_life_cur'].",char_mana_cur=".$user['char_mana_cur']);
		$user['log'] = 'Вы вернулись в мир живых. Вы чувствуете сильную усталость и головокружение. Вам нужно отдохнуть и набраться сил.';
		$user['links'] = array();
		$user['links'][0]['title'] = 'Покинуть Кладбище';
		$user['links'][0]['link'] = 'index.php?action=gate';
		switch ($user['char_region']) {
			case 1:
				$user['links'][1]['title'] = 'Осмотреть Склеп';
				$user['links'][1]['link'] = 'index.php?action=crypt';
				break;
		}
	}
	
	$res = json_encode($user, JSON_UNESCAPED_UNICODE);	
	
}

?>