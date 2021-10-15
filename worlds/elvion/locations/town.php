<?php

if ($action == 'town') {
	
	$user['title'] = 'Главная Площадь Города';
	if ($user['char_life_cur'] > 0) {
		$user['description'] = 'Небольшой изолированный городишко, в паре дней пути от других населенных пунктов. Городок по большей части может себя обеспечить и оттого его жителям нет нужды выезжать в соседние города. У них есть фермы, торговая лавка, школа, больница, банк, таверна, городской зал, несколько гильдий, церковь и ещё множество других строений, которые необходимы маленькому городку для выживания. Население невелико, каждый знает в лицо и по именам всех горожан, и редкие чужаки тут же бросаются в глаза. Хотя почва плодородная, а климат умеренный, жизнь в городке тяжела. Нужно работать от зари до зари и оттого все жители не страдают излишними сантиментами и возвышенными иллюзиями. Это крепкий, практичный трудовой народ, ценящий тишину и традиции.';
	}else{
		$user['description'] = 'Ваша душа летает главной площадью города.';
	}
	$user['links'] = array();
	if ($user['char_life_cur'] > 0) {	
		$user['links'][0]['title'] = 'Главные Ворота';
		$user['links'][0]['link'] = 'index.php?action=gate';
		$user['links'][1]['title'] = 'Банк';
		$user['links'][1]['link'] = 'index.php?action=bank';
		$user['links'][2]['title'] = 'Таверна';
		$user['links'][2]['link'] = 'index.php?action=tavern';
		$user['links'][3]['title'] = 'Гильдия Силы';
		$user['links'][3]['link'] = 'index.php?action=guild_str';
		$user['links'][4]['title'] = 'Гильдия Тела';
		$user['links'][4]['link'] = 'index.php?action=guild_body';
		$user['links'][5]['title'] = 'Гильдия Стражников';
		$user['links'][5]['link'] = 'index.php?action=guild_adv';
	} else {
		$user['links'][0]['title'] = 'Городское Кладбище';
		$user['links'][0]['link'] = 'index.php?action=graveyard';
	}
	
	$res = json_encode($user, JSON_UNESCAPED_UNICODE);
	
}

?>