<?php

if ($action == 'graveyard') {

	$user['title'] = 'Городское Кладбище';
	if ($user['char_life_cur'] > 0) {
		$user['description'] = $user['class']['location']->get_graveyard_description();
	} else {
		$user['description'] = 'Вы в виде бестелесного создания бродите в мире теней. У одной из могил вы видите красивую девушку с большими крыльями за спиной. Она говорит, что может воскресить и вернуть в мир живых...';
	}
	
	$user['links'] = array();
	if ($user['char_life_cur'] > 0) {
		$user['class']['location']->get_graveyard_links();
	} else Location::addlink('Вернуться к жизни', 'index.php?action=graveyard&do=revive_in_graveyard');
	
	if ($do == 'revive_in_graveyard') {
		$user['char_life_cur'] = 1;
		$user['char_mana_cur'] = 0;
		User::update("char_life_cur=".$user['char_life_cur'].",char_mana_cur=".$user['char_mana_cur']);
		$user['description'] = 'Вы открываете глаза и понимаете, что вернулись в мир живых. На тело наваливаетеся сильная усталость, кружится голова. Все происходящее кажется сном. Нужно отдохнуть и набраться сил.';
		$user['links'] = array();
		$user['class']['location']->get_graveyard_links();
	}
	
	$res = json_encode($user, JSON_UNESCAPED_UNICODE);	
	
}

?>