<?php

if ($action == 'magictower') {

	$user['title'] = 'Магическая Башня';
	if ($user['char_life_cur'] > 0) {
		$user['description'] = 'Вы находитесь на последнем этаже самого высокого строения в городе. Отсюда открывается прекрасный вид на город.';
	} else $user['class']['location']->shades();
	
	$user['links'] = array();
	if ($user['char_life_cur'] > 0) {
		$user['class']['location']->go_to_the_town();
		Location::addlink('Магическая Лавка', 'index.php?action=shop_magic', 1);
		switch ($user['char_region']) {
			case 8:
				Location::addlink('Порталл в Забытый Храм', 'index.php?action=forgotten_temple', 2);
				break;
		}
	} else $user['class']['location']->go_to_the_graveyard();
	
	$res = json_encode($user, JSON_UNESCAPED_UNICODE);	

}

?>