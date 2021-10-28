<?php

if ($action == 'old_harbor') {
	
	$user['current_outlands'] = $action;
	
	add_enemies([20,21,22]);	
	
	$user['title'] = 'Старая Гавань';
	if ($user['char_life_cur'] > 0) {
		$user['description'] = 'В другую сторону от городской гавани раскинулась давно не используемая Старая Гавань. Белый песок и чистая вода, ракушки и яркие морские звезды, которыми усеян берег этого побережья, - не оставят равнодушными любителей морских красот. С другой стороны путники здесь не часто появляются так как Старая Гавань у местных жителей пользуется дурной славой.';
	}else shades();
	$user['frame'] = 'outlands';
	$user['links'] = array();
	if ($user['char_life_cur'] > 0)
		go_to_the_gate();
	else
		go_to_the_graveyard();

	$res = json_encode($user, JSON_UNESCAPED_UNICODE);

}

?>