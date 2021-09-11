<?php

$graveyard_description = 'Вы на городском кладбище. Кругом могилы.';

if ($action == 'graveyard') {

	$user['title'] = 'Городское Кладбище';
	if ($user['char_life_cur'] > 0) {
		$user['description'] = $graveyard_description;
	}else{
		$user['description'] = 'Ваша душа летает над могилами.';
	}
	$user['links'] = array();
	if ($user['char_life_cur'] > 0) {
		$user['links'][0]['title'] = 'Вернуться в город';
		$user['links'][0]['link'] = 'index.php?action=town';
	} else {	
		$user['links'][0]['title'] = 'Вернуться к жизни';
		$user['links'][0]['link'] = 'index.php?action=graveyard&do=revive_in_graveyard';	
	}
	
	if ($do == 'revive_in_graveyard') {
		$user['char_life_cur'] = 1;
		$user['char_mana_cur'] = 0;
		save_character();
		$user['log'] = 'Вы снова живы. Вы чувствуете головокружение. Вам нужно отдохнуть.';
		$user['title'] = 'Городское Кладбище';
		$user['description'] = $graveyard_description;
		$user['links'] = array();
		$user['links'][0]['title'] = 'Вернуться в город';
		$user['links'][0]['link'] = 'index.php?action=town';
	}
	
	$res = json_encode($user, JSON_UNESCAPED_UNICODE);	
	
}

?>