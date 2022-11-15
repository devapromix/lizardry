<?php

if ($action == 'town') {
	$user['title'] = $user['class']['location']->get_town_name();
	if ($user['char_life_cur'] > 0)
		$user['description'] = $user['class']['location']->get_town_description();
	else $user['class']['location']->shades();
	$user['links'] = array();
	if ($user['char_life_cur'] > 0) {	
		$user['class']['location']->go_to_the_gate('Покинуть '.$user['title']);
		Location::addlink('Посетить Таверну', 'index.php?action=tavern', 1);
		Location::addlink('Отправиться в Банк', 'index.php?action=bank', 2);
		Location::addlink('Идти в Магическую Башню', 'index.php?action=magictower', 3);
		Location::addlink('Квартал Гильдий', 'index.php?action=guilds', 4);
		Location::addlink('Квартал Торговцев', 'index.php?action=shops', 5);
	} else $user['class']['location']->go_to_the_graveyard();
	$res = json_encode($user, JSON_UNESCAPED_UNICODE);
}

?>