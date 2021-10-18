<?php

if ($action == 'stonewormlair') {

	$user['current_outlands'] = $action;

	add_enemy(1, rand(10, 10));
	add_enemy(2, rand(10, 10));
	add_enemy(3, rand(10, 10));	
	
	$user['title'] = 'Логово Каменного Червя';
	if ($user['char_life_cur'] > 0) {
		$user['description'] = 'До сих пор самые опасные твари, что обитают в Глубокой Пещере, бояться подходить к этой яме. Ведь даже известный своей силой титан так и не сумел выйти из нее, его кости и по сей день торчат из скалы, словно жуткое предостережение для каждого, кому захочется войти туда. А желающих много, так как по слухам в ней сокрыты несметные сокровища и могущественные артефакты. Но это всего лишь слухи, так как не было еще того, кто сумел бы побывать там и вернуться...';
	}else{
		$user['description'] = 'Ваша душа взмыла ввысь над валунами...';
	}
	$user['frame'] = 'outlands';
	$user['links'] = array();
	if ($user['char_life_cur'] > 0) {
		$user['links'][0]['title'] = 'Покинуть Логово';
		$user['links'][0]['link'] = 'index.php?action=deepcave';	
	} else {
		$user['links'][0]['title'] = 'Отправиться на кладбище';
		$user['links'][0]['link'] = 'index.php?action=graveyard';
	}

	$res = json_encode($user, JSON_UNESCAPED_UNICODE);

}

?>