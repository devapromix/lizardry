<?php

if ($action == 'denofthieves') {

	$user['title'] = 'Логово Воров';
	if ($user['char_life_cur'] > 0) {
		$user['description'] = '';
	} else $user['class']['location']->shades();
	
	$user['links'] = array();
	if ($user['char_life_cur'] > 0) {
		Location::addlink('Покинуть Логово', 'index.php?action=guild_hunter&do=guild_cellar');
		Location::addlink('Черный Рынок', 'index.php?action=black_market', 1);
	} else $user['class']['location']->go_to_the_graveyard();
	
	$res = json_encode($user, JSON_UNESCAPED_UNICODE);	

}

?>