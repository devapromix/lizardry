<?php

if ($action == 'guilds') {
	
	$user['title'] = 'Квартал Гильдий';
	if ($user['char_life_cur'] > 0) {
		$user['description'] = '';
	} else shades();
	$user['links'] = array();
	if ($user['char_life_cur'] > 0) {
		go_to_the_town('Идти на площадь города');
		addlink('Тренировочный Зал', 'index.php?action=guild_main', 1);
		addlink('Гильдия Воинов', 'index.php?action=guild_warrior', 2);
	} else go_to_the_graveyard();
	
	$res = json_encode($user, JSON_UNESCAPED_UNICODE);	

}

if ($action == 'guild_main') {

	$user['title'] = 'Тренировочный Зал';
	$user['description'] = 'После занятий с Мастером в Тренировочном Зале вы получаете новый уровень и очки развития навыков, которые можете потратить в других гильдиях на изучение новых навыков или улучшения уже известных.##Сейчас у вас '.$user['char_lp'].' свободных оч.';
	$user['links'] = array();
	addlink('Покинуть зал', 'index.php?action=guilds');
	addlink('Приступить к тренировке', 'index.php?action=guild_main&do=train_in_guild_main', 1);
	addlink('Забыть все навыки!', 'index.php?action=guild_main&do=clear', 2);

	if ($do == 'train_in_guild_main') {
		if ($user['char_life_cur'] <= 0) die('{"error":"Сначала нужно вернуться к жизни!"}');
		if ($user['char_exp'] < get_char_level_exp($user['char_level'])) die('{"error":"Сначала нужно набраться опыта!"}');
		$user['char_exp'] = $user['char_exp'] - get_char_level_exp($user['char_level']);
		$user['char_level']++;
		$user['char_lp']++;
		$user['char_life_cur'] = get_char_life($user['char_level']);
		$user['char_life_max'] = get_char_life($user['char_level']);
		add_event(1, $user['char_name'], $user['char_level']);
		update_user_table("char_exp=".$user['char_exp'].",char_level=".$user['char_level'].",char_life_cur=".$user['char_life_cur'].",char_life_max=".$user['char_life_max'].",char_lp=".$user['char_lp']);
		$user['log'] = 'Вы потренировались и стали лучше!';
		$user['links'] = array();
		addlink('Назад', 'index.php?action=guild_main');
	}
	
	if ($do == 'clear') {
		if ($user['char_life_cur'] <= 0) die('{"error":"Сначала нужно вернуться к жизни!"}');
		$user['description'] = 'Вы входите в маленькую комнатушку. Мастер дает прочитать вам магический свиток. Через мгновение вы понимаете, что забыли все свои навыки и все надо начинать с самого начала.';
		$user['char_lp'] = $user['char_level'];
		update_user_table("char_lp=".$user['char_lp'].",skill_dodge=0,skill_parry=0");
		$user['log'] = 'Вы забыли все!';
		$user['links'] = array();
		addlink('Назад', 'index.php?action=guild_main');
	}

	$res = json_encode($user, JSON_UNESCAPED_UNICODE);	
	
}

if ($action == 'guild_warrior') {

	$user['title'] = 'Гильдия Воинов';
	$t = 'Вы спускаетесь в просторный зал. К вам подходит старый гном:#- Приветствую! В нашей гильдии тренируются воины. У вас сейчас '.$user['char_lp'].' свободных оч. ';
	if ($user['char_lp'] > 0)
		$t .= 'Выбирайте навык и приступайте к тренировкам.';
	else
		$t .= 'К сожалению я не могу сейчас тренировать вас - нужны очки развития навыков.';
	$t .= '##Ваши навыки:#============#';
	if ($user['skill_dodge'] > 0)
		$t .= 'Уклонение: '.$user['skill_dodge'].'/50#';
	if ($user['skill_parry'] > 0)
		$t .= 'Парирование: '.$user['skill_parry'].'/50#';
	if ($user['skill_bewil'] > 0)
		$t .= 'Ошеломление: '.$user['skill_bewil'].'/50#';
	$user['description'] = $t;
	$user['links'] = array();
	addlink('Покинуть гильдию', 'index.php?action=guilds');
	addlink('Информация по навыкам', 'index.php?action=guild_warrior&do=info', 1);
	addlink('Тренировать "Уклонение"', 'index.php?action=guild_warrior&do=train_dodge', 2);
	addlink('Тренировать "Парирование"', 'index.php?action=guild_warrior&do=train_parry', 3);
	addlink('Тренировать "Ошеломление"', 'index.php?action=guild_warrior&do=train_bewil', 4);

	if ($do == 'info') {
		$user['description'] = 'Вы просите мастера рассказать вам больше о навыках воина. Старый гном что-то невнятно бурчит себе под нос, но соглашается:#- Какой навык интересует? Выбирай.';
		$user['links'] = array();
		addlink('Мне уже все понятно!', 'index.php?action=guild_warrior');
		addlink('Навык "Уклонение"', 'index.php?action=guild_warrior&do=train_dodge_info', 1);
		addlink('Навык "Парирование"', 'index.php?action=guild_warrior&do=train_parry_info', 2);
		addlink('Навык "Ошеломление"', 'index.php?action=guild_warrior&do=train_bewil_info', 3);
	}
	
	if ($do == 'train_dodge') {
		if ($user['char_life_cur'] <= 0) die('{"error":"Вам сначала нужно вернуться к жизни!"}');
		if ($user['char_lp'] == 0) die('{"error":"Для тренировки нужны очки развития навыков!"}');
		if ($user['skill_dodge'] >= 50) die('{"error":"Вы достигли максимума в развитии навыка!"}');
		$user['char_lp']--;
		$user['skill_dodge']++;
		$user['description'] = 'Вы тренируетесь уклоняться от атак противника. В умение "Уклонение" вложено '.$user['skill_dodge'].' оч.';
		update_user_table("char_lp=".$user['char_lp'].",skill_dodge=".$user['skill_dodge']);
		$user['log'] = 'Вы потренировались и стали лучше!';
		$user['links'] = array();
		addlink('Назад', 'index.php?action=guild_warrior');
	}
	if ($do == 'train_dodge_info') {
		$user['description'] = 'Развитие навыка "Уклонение" позволит вам более часто уклоняться от вражеских атак и избегать урона. Вероятность уклониться от вражеского удара (используя навык) равна '.$user['skill_dodge'].'%.';
		$user['links'] = array();
		addlink('Мне уже все понятно!', 'index.php?action=guild_warrior&do=info');
	}
	
	if ($do == 'train_parry') {
		if ($user['char_life_cur'] <= 0) die('{"error":"Вам сначала нужно вернуться к жизни!"}');
		if ($user['char_lp'] == 0) die('{"error":"Для тренировки нужны очки развития навыков!"}');
		if ($user['skill_parry'] >= 50) die('{"error":"Вы достигли максимума в развитии навыка!"}');
		$user['char_lp']--;
		$user['skill_parry']++;
		$user['description'] = 'Вы тренируетесь парировать атаки противника. В умение "Парирование" вложено '.$user['skill_parry'].' оч.';
		update_user_table("char_lp=".$user['char_lp'].",skill_parry=".$user['skill_parry']);
		$user['log'] = 'Вы потренировались и стали лучше!';
		$user['links'] = array();
		addlink('Назад', 'index.php?action=guild_warrior');
	}

	if ($do == 'train_parry_info') {
		$user['description'] = 'Парирование позволяет вам отбить в сторону удар врага и таким образом избежать урона. Вероятность парировать атаку противника равна '.$user['skill_parry'].'%.';
		$user['links'] = array();
		addlink('Мне уже все понятно!', 'index.php?action=guild_warrior&do=info');
	}
	
	if ($do == 'train_bewil') {
		if ($user['char_life_cur'] <= 0) die('{"error":"Вам сначала нужно вернуться к жизни!"}');
		if ($user['char_lp'] == 0) die('{"error":"Для тренировки нужны очки развития навыков!"}');
		if ($user['skill_bewil'] >= 50) die('{"error":"Вы достигли максимума в развитии навыка!"}');
		$user['char_lp']--;
		$user['skill_bewil']++;
		$user['description'] = 'Вы тренируете ошеломляющий удар. Пока враг в растерянности, вы атакуете снова и снова. В умение "Ошеломление" вложено '.$user['skill_bewil'].' оч.';
		update_user_table("char_lp=".$user['char_lp'].",skill_bewil=".$user['skill_bewil']);
		$user['log'] = 'Вы потренировались и стали лучше!';
		$user['links'] = array();
		addlink('Назад', 'index.php?action=guild_warrior');
	}

	if ($do == 'train_bewil_info') {
		$user['description'] = 'Ошеломляющий удар позволяет вам обескуражить врага и пока враг находится в смятении провести еще одну атаку за этот раунд. Вероятность того, что вы обрушите на врага ошеломляющий удар равна '.$user['skill_bewil'].'%.';
		$user['links'] = array();
		addlink('Мне уже все понятно!', 'index.php?action=guild_warrior&do=info');
	}
	
	$res = json_encode($user, JSON_UNESCAPED_UNICODE);	
	
}

?>