<?php

if ($action == 'guilds') {
	
	$user['title'] = 'Квартал Гильдий';
	if ($user['char_life_cur'] > 0) {
		$user['description'] = 'Вы спускаетесь в нижнюю часть города. Здесь тихо и не так многолюдно как в центральной части города.';
	} else shades();
	$user['links'] = array();
	if ($user['char_life_cur'] > 0) {
		go_to_the_town('Идти на площадь города');
		addlink('Тренировочный Зал', 'index.php?action=guild_main', 1);
		addlink('Гильдия Воинов', 'index.php?action=guild_warrior', 2);
		addlink('Гильдия Охотников', 'index.php?action=guild_hunter', 3);
		addlink('Гильдия Кузнецов', 'index.php?action=guild_forge', 4);
		addlink('Гильдия Кожевников', 'index.php?action=guild_lw', 5);
		addlink('Гильдия Выживания', 'index.php?action=guild_surv', 6);
	} else go_to_the_graveyard();
	
	$res = json_encode($user, JSON_UNESCAPED_UNICODE);	

}

if ($action == 'guild_main') {

	$user['title'] = 'Тренировочный Зал';
	$user['description'] = 'После занятий с Мастером в Тренировочном Зале вы получаете новый уровень и очки развития навыков, которые можете потратить в других гильдиях на изучение новых навыков или улучшения уже известных.##Сейчас у вас '.$user['char_lp'].' свободных оч.';
	$user['links'] = array();
	addlink('Покинуть зал', 'index.php?action=guilds');
	addlink('Приступить к тренировке', 'index.php?action=guild_main&do=train_in_guild_main', 1);
	addlink('Забыть все навыки!', 'index.php?action=guild_main&do=try_clear', 2);

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
	
	if ($do == 'try_clear') {
		if ($user['char_life_cur'] <= 0) die('{"error":"Сначала нужно вернуться к жизни!"}');
		$user['description'] = 'Вы подтверждаете, что готовы сбросить все очки развития навыков персонажа?';
		$user['links'] = array();
		addlink('Назад', 'index.php?action=guild_main');
		addlink('Подтвердить!', 'index.php?action=guild_main&do=clear', 1);
	}
	
	if ($do == 'clear') {
		if ($user['char_life_cur'] <= 0) die('{"error":"Сначала нужно вернуться к жизни!"}');
		$user['description'] = 'Вы входите в маленькую комнатушку. Мастер дает прочитать вам магический свиток. Через мгновение вы понимаете, что забыли все свои навыки и все надо начинать с самого начала.';
		$user['char_lp'] = $user['char_level'];
		update_user_table("char_lp=".$user['char_lp'].",skill_dodge=0,skill_parry=0,skill_bewil=0,skill_run=0,skill_gold=0");
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
	$t .= '##Ваши навыки Гильдии Воинов:#============#';
	if ($user['skill_dodge'] > 0)
		$t .= 'Уклонение: '.$user['skill_dodge'].'/50#';
	if ($user['skill_parry'] > 0)
		$t .= 'Парирование: '.$user['skill_parry'].'/50#';
	if ($user['skill_bewil'] > 0)
		$t .= 'Ошеломление: '.$user['skill_bewil'].'/25#';
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
		if ($user['skill_bewil'] >= 25) die('{"error":"Вы достигли максимума в развитии навыка!"}');
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

if ($action == 'guild_hunter') {

	$user['title'] = 'Гильдия Охотников';
	$t = 'Вы входите в светлый просторный зал, обставленый чучелами различных птиц и зверей. Вас встречает высокий эльф в добротной кожаной броне и длинным луком за плечами:#-Здраствуй, '.$user['char_name'].'! Добро пожаловать в Гильдию Охотников. У нас можно улучшить свои навыки охоты или изучить новые.#Также я щедро плачу золотом за ценные охотничьи трофеи.##';
	$t .= inv_item_list(21);
	$user['description'] = $t;
	$user['links'] = array();
	addlink('Покинуть гильдию', 'index.php?action=guilds');
	addlink('Продать Трофеи', 'index.php?action=guild_hunter&do=trophy_trade', 1);

	if ($do == 'trophy_trade') {
		if ($user['char_life_cur'] <= 0) die('{"error":"Вам сначала нужно вернуться к жизни!"}');
		$gold = inv_item_trade(21);
		$user['description'] = 'Вы продали все свои трофеи и заработали '.$gold.' золотых монет.';
		$user['links'] = array();
		addlink('Назад', 'index.php?action=guild_hunter');
	}

	$res = json_encode($user, JSON_UNESCAPED_UNICODE);	

}

if ($action == 'guild_forge') {

	$user['title'] = 'Гильдия Кузнецов';
	$t = 'Вы входите в Кузницу. К вам выходит старый гном в испачканой угoльной пылью одежде:#-Приветствую, '.$user['char_name'].'! Рад видеть тебя в Гильдии Кузнецов. У нас ты можешь потренироваться, отремонтировать свою экипировку, купить нужные вещи кузнеца или продать старое оружие.##';
	$t .= inv_item_list(1);
	$user['description'] = $t;
	$user['links'] = array();
	addlink('Покинуть гильдию', 'index.php?action=guilds');
	addlink('Продать Оружие', 'index.php?action=guild_forge&do=weapon_trade', 1);

	if ($do == 'weapon_trade') {
		if ($user['char_life_cur'] <= 0) die('{"error":"Вам сначала нужно вернуться к жизни!"}');
		$gold = inv_item_trade(1);
		$user['description'] = 'Вы продали старое оружие и заработали '.$gold.' золотых монет.';
		$user['links'] = array();
		addlink('Назад', 'index.php?action=guild_forge');
	}

	$res = json_encode($user, JSON_UNESCAPED_UNICODE);	

}

if ($action == 'guild_lw') {

	$user['title'] = 'Гильдия Кожевников';
	$t = 'В Гильдии Кожевников к вам подходит красивая эльфийка в дорогой кожаной эльфийской броне:#-Здраствуйте! Рада видеть вас в нашей гильдии. Мы рады помочь каждому путнику, кому нужна наша помощь. Я с удовольствием обучаю исскуству снятия кожи с убитых животных и достаточно дорого выкупаю уже не нужную кожаную броню.##';
	$t .= inv_item_list(0);
	$user['description'] = $t;
	$user['links'] = array();
	addlink('Покинуть гильдию', 'index.php?action=guilds');
	addlink('Продать Броню', 'index.php?action=guild_lw&do=armor_trade', 1);

	if ($do == 'armor_trade') {
		if ($user['char_life_cur'] <= 0) die('{"error":"Вам сначала нужно вернуться к жизни!"}');
		$gold = inv_item_trade(0);
		$user['description'] = 'Вы продали старую кожаную броню и заработали '.$gold.' золотых монет.';
		$user['links'] = array();
		addlink('Назад', 'index.php?action=guild_lw');
	}

	$res = json_encode($user, JSON_UNESCAPED_UNICODE);	

}

if ($action == 'guild_surv') {

	$user['title'] = 'Гильдия Выживания';
	$t = ' У вас-с сейчас-с-с '.$user['char_lp'].' свободных оч. ';
	if ($user['char_lp'] > 0)
		$t .= 'Выбирайте навык и прис-с-ступайте к тренировкам-с-с.';
	else
		$t .= 'К с-сожалению я не могу с-сейчас-с-с тренировать вас-с - нужны очки развития навыков-с-с.';
	$t .= '##Ваши навыки Гильдии Выживания:#============#';
	if ($user['skill_run'] > 0)
		$t .= 'Обман: '.$user['skill_run'].'/10#';
	if ($user['skill_gold'] > 0)
		$t .= 'Жадность: '.$user['skill_gold'].'/10#';
	$user['description'] = 'Вы спускаетесь по ступенькам в подвальное помещение. Здесь достаточно темно и только часть помещения освещена факелами и свечами. К вам подходит худой высокий ящер в темных одеяниях:#-Здрас-с-ствуйте-с-с! Могу я вам-с-с помочь-с-с?'.$t;
	$user['links'] = array();
	addlink('Покинуть гильдию', 'index.php?action=guilds');
	addlink('Информация по навыкам', 'index.php?action=guild_surv&do=info', 1);
	addlink('Тренировать "Обман"', 'index.php?action=guild_surv&do=train_run', 2);
	addlink('Тренировать "Жадность"', 'index.php?action=guild_surv&do=train_gold', 3);

	if ($do == 'info') {
		$user['description'] = 'Мастер с удовольствием рассказывает о навыках Гильдии Выживания, которые вам доступны для изучения..';
		$user['links'] = array();
		addlink('Мне уже все понятно!', 'index.php?action=guild_surv');
		addlink('Навык "Обман"', 'index.php?action=guild_surv&do=train_run_info', 1);
		addlink('Навык "Жадность"', 'index.php?action=guild_surv&do=train_gold_info', 2);
	}

	if ($do == 'train_run') {
		if ($user['char_life_cur'] <= 0) die('{"error":"Вам сначала нужно вернуться к жизни!"}');
		if ($user['char_lp'] == 0) die('{"error":"Для тренировки нужны очки развития навыков!"}');
		if ($user['skill_run'] >= 10) die('{"error":"Вы достигли максимума в развитии навыка!"}');
		$user['char_lp']--;
		$user['skill_run']++;
		$user['description'] = 'Вы тренируетесь совершать обманные движения в поединке, чтобы повысить свои шансы спастись и выйти из боя живым. В умение "Обман" вложено '.$user['skill_run'].' оч.';
		update_user_table("char_lp=".$user['char_lp'].",skill_run=".$user['skill_run']);
		$user['log'] = 'Вы потренировались и стали лучше!';
		$user['links'] = array();
		addlink('Назад', 'index.php?action=guild_surv');
	}

	if ($do == 'train_run_info') {
		$user['description'] = 'Совершив в бою обманный маневр и перехитрив противника, вы увеличите свои шансы покинуть поле битвы живым. Вероятность обмануть противника в бою увеличена на '.strval($user['skill_run'] * 5).'%.';
		$user['links'] = array();
		addlink('Мне уже все понятно!', 'index.php?action=guild_surv&do=info');
	}
	
	if ($do == 'train_gold') {
		if ($user['char_life_cur'] <= 0) die('{"error":"Вам сначала нужно вернуться к жизни!"}');
		if ($user['char_lp'] == 0) die('{"error":"Для тренировки нужны очки развития навыков!"}');
		if ($user['skill_gold'] >= 10) die('{"error":"Вы достигли максимума в развитии навыка!"}');
		$user['char_lp']--;
		$user['skill_gold']++;
		$user['description'] = 'Вы тренируетесь получше обыскивать трупы врагов, чтобы добыть побольше золота. В умение "Жадность" вложено '.$user['skill_gold'].' оч.';
		update_user_table("char_lp=".$user['char_lp'].",skill_gold=".$user['skill_gold']);
		$user['log'] = 'Вы потренировались и стали лучше!';
		$user['links'] = array();
		addlink('Назад', 'index.php?action=guild_surv');
	}

	if ($do == 'train_gold_info') {
		$user['description'] = 'Навык позволяет вам получше обыскивать поверженых врагов и получать больше золота от монстров.';
		$user['links'] = array();
		addlink('Мне уже все понятно!', 'index.php?action=guild_surv&do=info');
	}

	$res = json_encode($user, JSON_UNESCAPED_UNICODE);	

}

?>