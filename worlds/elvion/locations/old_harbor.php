<?php

if ($action == 'old_harbor') {
	
	$user['current_outlands'] = $action;
	
	add_enemy(1, rand(22, 24));
	add_enemy(2, rand(22, 24));
	add_enemy(3, rand(22, 24));	
	
	$user['title'] = 'Старая Гавань';
	if ($user['char_life_cur'] > 0) {
		$user['description'] = 'В другую сторону от городской гавани раскинулась давно не используемая Старая Гавань. Белый песок и чистая вода, ракушки и яркие морские звезды, которыми усеян берег этого побережья, - не оставят равнодушными любителей морских красот. С другой стороны путники здесь не часто появляются так как Старая Гавань у местных жителей пользуется дурной славой.';
	}else{
		$user['description'] = 'Вы в бестелесной форме духа бродите берегом моря. Вам хочется поскорее отыскать ближайшее кладбище.';
	}
	$user['frame'] = 'outlands';
	$user['links'] = array();
	if ($user['char_life_cur'] > 0) {
		$user['links'][0]['title'] = 'Идти в сторону города';
		$user['links'][0]['link'] = 'index.php?action=gate';	
	} else {
		$user['links'][0]['title'] = 'Отправиться на кладбище';
		$user['links'][0]['link'] = 'index.php?action=graveyard';
	}
	
	$res = json_encode($user, JSON_UNESCAPED_UNICODE);

}

?>