<?php

if ($action == 'stonewormlair') {

	$user['current_outlands'] = $action;

	add_enemies([10,11,12]);	
	
	$user['title'] = 'Логово Каменных Червей';
	if ($user['char_life_cur'] > 0) {
		$user['description'] = 'До сих пор самые опасные твари, что обитают в Глубокой Пещере, бояться подходить к этой яме. Ведь даже известный своей силой титан так и не сумел выйти из нее, его кости и по сей день торчат из скалы, словно жуткое предостережение для каждого, кому захочется войти туда. А желающих много, так как по слухам в ней сокрыты несметные сокровища и могущественные артефакты. Но это всего лишь слухи, так как не было еще того, кто сумел бы побывать там и вернуться...';
	}else shades();
	$user['frame'] = 'outlands';
	$user['links'] = array();
	if ($user['char_life_cur'] > 0)
		addlink('Покинуть Логово', 'index.php?action=deepcave');
	else
		go_to_the_graveyard();
	
	$res = json_encode($user, JSON_UNESCAPED_UNICODE);

}

?>