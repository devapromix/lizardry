<?php

if ($action == 'campfire') {
	
	if ($user['char_life_cur'] <= 0) die('{"error":"Вам сначала нужно вернуться к жизни!"}');
	if ($user['char_food'] <= 0) die('{"error":"Вы не можете здесь отдыхать - нет провизии!"}');
	if (($user['char_life_cur'] == $user['char_life_max'])
		&&($user['char_mana_cur'] == $user['char_mana_max'])) die('{"info":"Вам незачем отдыхать - вы здоровы и полны сил!"}');

	$user['title'] = 'Лагерь!';
	$user['description'] = 'Несколько веточек и маленькое пламя разогнало наступающую тьму и холод. Теперь можно удобно расположиться возле него. Под рукой вязанка дровишек и длинная тонкая палка для дирижирования огнём. Подвешен котелок, кипятится вода для чая. Огонь не обжигает, а плавными волнами приятно ласкает своим теплом. При этом становится невероятно уютно и спокойно на душе. Накопившиеся тревоги отступают на задний план, мысль проясняется, в таком состоянии комфортно думается, быстрее приходят новые оригинальные идеи и легче принимаются верные решения...';
	$user['frame'] = $action;
	$user['links'] = array();
	addlink('Затушить костер', 'index.php?action='.$user['current_outlands']);

	$user['char_life_cur'] = $user['char_life_max'];
	$user['char_mana_cur'] = $user['char_mana_max'];
	$user['char_food'] --;
	update_user_table("char_food=".$user['char_food'].",char_life_cur=".$user['char_life_cur'].",char_mana_cur=".$user['char_mana_cur']);
	$user['log'] = 'Вы хорошо отдохнули и набрались сил.';

	$res = json_encode($user, JSON_UNESCAPED_UNICODE);

}

?>