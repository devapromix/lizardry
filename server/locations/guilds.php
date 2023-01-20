<?php

if ($action == 'guilds') {
	
	$user['title'] = 'Квартал Гильдий';
	if ($user['char_life_cur'] > 0) {
		$user['description'] = 'Вы спускаетесь в нижнюю часть города. Здесь тихо и не так многолюдно как в центральной части города.';
	} else $user['class']['location']->shades();
	$user['links'] = array();
	if ($user['char_life_cur'] > 0) {
		$user['class']['location']->go_to_the_town('Идти на площадь города');
		Location::addlink('Тренировочный Зал', 'index.php?action=guild_main', 1);
		Location::addlink('Гильдия Воинов', 'index.php?action=guild_warrior', 2);
		Location::addlink('Гильдия Охотников', 'index.php?action=guild_hunter', 3);
		Location::addlink('Гильдия Кузнецов', 'index.php?action=guild_forge', 4);
		Location::addlink('Гильдия Кожевников', 'index.php?action=guild_lw', 5);
		Location::addlink('Гильдия Выживания', 'index.php?action=guild_surv', 6);
		Location::addlink('Гильдия Алхимиков', 'index.php?action=guild_alch', 7);
		Location::addlink('Гильдия Магов', 'index.php?action=guild_mage', 8);
	} else $user['class']['location']->go_to_the_graveyard();
	
	$res = json_encode($user, JSON_UNESCAPED_UNICODE);	

}

if ($action == 'guild_main') {

	$user['title'] = 'Тренировочный Зал';
	$user['description'] = 'После занятий с Мастером в Тренировочном Зале вы получаете новый уровень и очки развития навыков, которые можете потратить в других гильдиях на изучение новых навыков или улучшения уже известных.##Сейчас у вас '.$user['char_lp'].' свободных оч.';
	$user['links'] = array();
	Location::addlink('Покинуть зал', 'index.php?action=guilds');
	Location::addlink('Приступить к тренировке', 'index.php?action=guild_main&do=train_in_guild_main', 1);
	Location::addlink('Забыть все навыки!', 'index.php?action=guild_main&do=try_clear', 2);

	if ($do == 'train_in_guild_main') {
		if ($user['char_life_cur'] <= 0) die('{"error":"Сначала нужно вернуться к жизни!"}');
		if ($user['char_exp'] < $user['class']['player']->get_level_exp($user['char_level'])) die('{"error":"Сначала нужно набраться опыта!"}');
		$user['char_exp'] = $user['char_exp'] - $user['class']['player']->get_level_exp($user['char_level']);
		$user['char_level']++;
		$user['char_lp']++;
		$user['char_life_max'] = $user['class']['player']->get_life($user['char_level']);
		$user['char_life_cur'] = $user['char_life_max'];
		Event::add(1, $user['char_name'], $user['char_level']);
		User::update("char_exp=".$user['char_exp'].",char_level=".$user['char_level'].",char_life_cur=".$user['char_life_cur'].",char_life_max=".$user['char_life_max'].",char_lp=".$user['char_lp']);
		$user['log'] = 'Вы потренировались и стали лучше!';
		$user['links'] = array();
		Location::addlink('Назад', 'index.php?action=guild_main');
	}
	
	if ($do == 'try_clear') {
		if ($user['char_life_cur'] <= 0) die('{"error":"Сначала нужно вернуться к жизни!"}');
		$user['description'] = 'Вы подтверждаете, что готовы сбросить все очки развития навыков персонажа?';
		$user['links'] = array();
		Location::addlink('Назад', 'index.php?action=guild_main');
		Location::addlink('Подтвердить!', 'index.php?action=guild_main&do=clear', 1);
	}
	
	if ($do == 'clear') {
		if ($user['char_life_cur'] <= 0) die('{"error":"Сначала нужно вернуться к жизни!"}');
		$user['description'] = 'Вы входите в маленькую комнатушку. Мастер дает прочитать вам магический свиток. Через мгновение вы понимаете, что забыли все свои навыки и все надо начинать с самого начала.';
		$user['char_lp'] = $user['char_level'];
		User::update("char_lp=".$user['char_lp'].",skill_dodge=0,skill_parry=0,skill_bewil=0,skill_run=0,skill_gold=0");
		$user['log'] = 'Вы забыли все!';
		$user['links'] = array();
		Location::addlink('Назад', 'index.php?action=guild_main');
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
	Location::addlink('Покинуть гильдию', 'index.php?action=guilds');
	Location::addlink('Информация по навыкам', 'index.php?action=guild_warrior&do=info', 1);
	Location::addlink('Тренировать "Уклонение"', 'index.php?action=guild_warrior&do=train_dodge', 2);
	Location::addlink('Тренировать "Парирование"', 'index.php?action=guild_warrior&do=train_parry', 3);
	Location::addlink('Тренировать "Ошеломление"', 'index.php?action=guild_warrior&do=train_bewil', 4);

	if ($do == 'info') {
		$user['description'] = 'Вы просите мастера рассказать вам больше о навыках воина. Старый гном что-то невнятно бурчит себе под нос, но соглашается:#- Какой навык интересует? Выбирай.';
		$user['links'] = array();
		Location::addlink('Мне уже все понятно!', 'index.php?action=guild_warrior');
		Location::addlink('Навык "Уклонение"', 'index.php?action=guild_warrior&do=train_dodge_info', 1);
		Location::addlink('Навык "Парирование"', 'index.php?action=guild_warrior&do=train_parry_info', 2);
		Location::addlink('Навык "Ошеломление"', 'index.php?action=guild_warrior&do=train_bewil_info', 3);
	}
	
	if ($do == 'train_dodge') {
		if ($user['char_life_cur'] <= 0) die('{"error":"Вам сначала нужно вернуться к жизни!"}');
		if ($user['char_lp'] == 0) die('{"error":"Для тренировки нужны очки развития навыков!"}');
		if ($user['skill_dodge'] >= 50) die('{"error":"Вы достигли максимума в развитии навыка!"}');
		$user['char_lp']--;
		$user['skill_dodge']++;
		$user['description'] = 'Вы тренируетесь уклоняться от атак противника. В умение "Уклонение" вложено '.$user['skill_dodge'].' оч.';
		User::update("char_lp=".$user['char_lp'].",skill_dodge=".$user['skill_dodge']);
		$user['log'] = 'Вы потренировались и стали лучше!';
		$user['links'] = array();
		Location::addlink('Назад', 'index.php?action=guild_warrior');
	}
	if ($do == 'train_dodge_info') {
		$user['description'] = 'Развитие навыка "Уклонение" позволит вам более часто уклоняться от вражеских атак и избегать урона. Вероятность уклониться от вражеского удара (используя навык) равна '.$user['skill_dodge'].'%.';
		$user['links'] = array();
		Location::addlink('Мне уже все понятно!', 'index.php?action=guild_warrior&do=info');
	}
	
	if ($do == 'train_parry') {
		if ($user['char_life_cur'] <= 0) die('{"error":"Вам сначала нужно вернуться к жизни!"}');
		if ($user['char_lp'] == 0) die('{"error":"Для тренировки нужны очки развития навыков!"}');
		if ($user['skill_parry'] >= 50) die('{"error":"Вы достигли максимума в развитии навыка!"}');
		$user['char_lp']--;
		$user['skill_parry']++;
		$user['description'] = 'Вы тренируетесь парировать атаки противника. В умение "Парирование" вложено '.$user['skill_parry'].' оч.';
		User::update("char_lp=".$user['char_lp'].",skill_parry=".$user['skill_parry']);
		$user['log'] = 'Вы потренировались и стали лучше!';
		$user['links'] = array();
		Location::addlink('Назад', 'index.php?action=guild_warrior');
	}

	if ($do == 'train_parry_info') {
		$user['description'] = 'Парирование позволяет вам отбить в сторону удар врага и таким образом избежать урона. Вероятность парировать атаку противника равна '.$user['skill_parry'].'%.';
		$user['links'] = array();
		Location::addlink('Мне уже все понятно!', 'index.php?action=guild_warrior&do=info');
	}
	
	if ($do == 'train_bewil') {
		if ($user['char_life_cur'] <= 0) die('{"error":"Вам сначала нужно вернуться к жизни!"}');
		if ($user['char_lp'] == 0) die('{"error":"Для тренировки нужны очки развития навыков!"}');
		if ($user['skill_bewil'] >= 25) die('{"error":"Вы достигли максимума в развитии навыка!"}');
		$user['char_lp']--;
		$user['skill_bewil']++;
		$user['description'] = 'Вы тренируете ошеломляющий удар. Пока враг в растерянности, вы атакуете снова и снова. В умение "Ошеломление" вложено '.$user['skill_bewil'].' оч.';
		User::update("char_lp=".$user['char_lp'].",skill_bewil=".$user['skill_bewil']);
		$user['log'] = 'Вы потренировались и стали лучше!';
		$user['links'] = array();
		Location::addlink('Назад', 'index.php?action=guild_warrior');
	}

	if ($do == 'train_bewil_info') {
		$user['description'] = 'Ошеломляющий удар позволяет вам обескуражить врага и пока враг находится в смятении провести еще одну атаку за этот раунд. Вероятность того, что вы обрушите на врага ошеломляющий удар равна '.$user['skill_bewil'].'%.';
		$user['links'] = array();
		Location::addlink('Мне уже все понятно!', 'index.php?action=guild_warrior&do=info');
	}
	
	$res = json_encode($user, JSON_UNESCAPED_UNICODE);	

}

if ($action == 'guild_hunter') {

	$user['title'] = 'Гильдия Охотников';
	$t = 'Вы входите в светлый просторный зал, обставленый чучелами различных птиц и зверей. Вас встречает высокий эльф в добротной кожаной броне и длинным луком за плечами:#-Здраствуй, '.$user['char_name'].'! Добро пожаловать в Гильдию Охотников. У нас можно улучшить свои навыки охоты или изучить новые.#Также я щедро плачу золотом за ценные охотничьи трофеи.##';
	$t .= $user['class']['item']->inv_item_list(Item::CAT_TROPHY);
	$user['description'] = $t;
	$user['links'] = array();
	Location::addlink('Покинуть гильдию', 'index.php?action=guilds');
	Location::addlink('Продать Трофеи', 'index.php?action=guild_hunter&do=trophy_trade', 1);

	if ($do == 'trophy_trade') {
		if ($user['char_life_cur'] <= 0) die('{"error":"Вам сначала нужно вернуться к жизни!"}');
		$gold = $user['class']['item']->gold_trade(Item::CAT_TROPHY);
		$user['description'] = 'Вы продали все свои трофеи и заработали '.$gold.' золотых монет.';
		$user['links'] = array();
		Location::addlink('Назад', 'index.php?action=guild_hunter');
	}

	$res = json_encode($user, JSON_UNESCAPED_UNICODE);	

}

if ($action == 'guild_forge') {

	$user['title'] = 'Гильдия Кузнецов';
	$t = 'Вы входите в Кузницу. К вам выходит старый гном в испачканой угoльной пылью одежде:#-Приветствую, '.$user['char_name'].'! Рад видеть тебя в Гильдии Кузнецов. У нас ты можешь потренироваться, отремонтировать свою экипировку, купить нужные вещи кузнеца или продать старое оружие.##';
	$t .= $user['class']['item']->inv_item_list(Item::CAT_WEAPON);
	$user['description'] = $t;
	$user['links'] = array();
	Location::addlink('Покинуть гильдию', 'index.php?action=guilds');
	Location::addlink('Продать Оружие', 'index.php?action=guild_forge&do=weapon_trade', 1);

	if ($do == 'weapon_trade') {
		if ($user['char_life_cur'] <= 0) die('{"error":"Вам сначала нужно вернуться к жизни!"}');
		$gold = $user['class']['item']->gold_trade(Item::CAT_WEAPON);
		$user['description'] = 'Вы продали старое оружие и заработали '.$gold.' золотых монет.';
		$user['links'] = array();
		Location::addlink('Назад', 'index.php?action=guild_forge');
	}

	$res = json_encode($user, JSON_UNESCAPED_UNICODE);	

}

if ($action == 'guild_lw') {

	$user['title'] = 'Гильдия Кожевников';
	$t = 'В Гильдии Кожевников к вам подходит красивая эльфийка в дорогой кожаной эльфийской броне:#-Здраствуйте! Рада видеть вас в нашей гильдии. Мы рады помочь каждому путнику, кому нужна наша помощь. Я с удовольствием обучаю исскуству снятия кожи с убитых животных и достаточно дорого выкупаю уже не нужную кожаную броню.##';
	$t .= $user['class']['item']->inv_item_list(Item::CAT_ARMOR);
	$user['description'] = $t;
	$user['links'] = array();
	Location::addlink('Покинуть гильдию', 'index.php?action=guilds');
	Location::addlink('Продать Броню', 'index.php?action=guild_lw&do=armor_trade', 1);

	if ($do == 'armor_trade') {
		if ($user['char_life_cur'] <= 0) die('{"error":"Вам сначала нужно вернуться к жизни!"}');
		$gold = $user['class']['item']->gold_trade(Item::CAT_ARMOR);
		$user['description'] = 'Вы продали старую кожаную броню и заработали '.$gold.' золотых монет.';
		$user['links'] = array();
		Location::addlink('Назад', 'index.php?action=guild_lw');
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
	Location::addlink('Покинуть гильдию', 'index.php?action=guilds');
	Location::addlink('Информация по навыкам', 'index.php?action=guild_surv&do=info', 1);
	Location::addlink('Тренировать "Обман"', 'index.php?action=guild_surv&do=train_run', 2);
	Location::addlink('Тренировать "Жадность"', 'index.php?action=guild_surv&do=train_gold', 3);

	if ($do == 'info') {
		$user['description'] = 'Мастер с удовольствием рассказывает о навыках Гильдии Выживания, которые вам доступны для изучения..';
		$user['links'] = array();
		Location::addlink('Мне уже все понятно!', 'index.php?action=guild_surv');
		Location::addlink('Навык "Обман"', 'index.php?action=guild_surv&do=train_run_info', 1);
		Location::addlink('Навык "Жадность"', 'index.php?action=guild_surv&do=train_gold_info', 2);
	}

	if ($do == 'train_run') {
		if ($user['char_life_cur'] <= 0) die('{"error":"Вам сначала нужно вернуться к жизни!"}');
		if ($user['char_lp'] == 0) die('{"error":"Для тренировки нужны очки развития навыков!"}');
		if ($user['skill_run'] >= 10) die('{"error":"Вы достигли максимума в развитии навыка!"}');
		$user['char_lp']--;
		$user['skill_run']++;
		$user['description'] = 'Вы тренируетесь совершать обманные движения в поединке, чтобы повысить свои шансы спастись и выйти из боя живым. В умение "Обман" вложено '.$user['skill_run'].' оч.';
		User::update("char_lp=".$user['char_lp'].",skill_run=".$user['skill_run']);
		$user['log'] = 'Вы потренировались и стали лучше!';
		$user['links'] = array();
		Location::addlink('Назад', 'index.php?action=guild_surv');
	}

	if ($do == 'train_run_info') {
		$user['description'] = 'Совершив в бою обманный маневр и перехитрив противника, вы увеличите свои шансы покинуть поле битвы живым. Вероятность обмануть противника в бою увеличена на '.strval($user['skill_run'] * 5).'%.';
		$user['links'] = array();
		Location::addlink('Мне уже все понятно!', 'index.php?action=guild_surv&do=info');
	}
	
	if ($do == 'train_gold') {
		if ($user['char_life_cur'] <= 0) die('{"error":"Вам сначала нужно вернуться к жизни!"}');
		if ($user['char_lp'] == 0) die('{"error":"Для тренировки нужны очки развития навыков!"}');
		if ($user['skill_gold'] >= 10) die('{"error":"Вы достигли максимума в развитии навыка!"}');
		$user['char_lp']--;
		$user['skill_gold']++;
		$user['description'] = 'Вы тренируетесь получше обыскивать трупы врагов, чтобы добыть побольше золота. В умение "Жадность" вложено '.$user['skill_gold'].' оч.';
		User::update("char_lp=".$user['char_lp'].",skill_gold=".$user['skill_gold']);
		$user['log'] = 'Вы потренировались и стали лучше!';
		$user['links'] = array();
		Location::addlink('Назад', 'index.php?action=guild_surv');
	}

	if ($do == 'train_gold_info') {
		$user['description'] = 'Навык позволяет вам получше обыскивать поверженых врагов и получать больше золота от монстров.';
		$user['links'] = array();
		Location::addlink('Мне уже все понятно!', 'index.php?action=guild_surv&do=info');
	}

	$res = json_encode($user, JSON_UNESCAPED_UNICODE);	

}

if ($action == 'guild_alch') {

	$user['title'] = 'Гильдия Алхимиков';
	$t = 'Вы входите в тесное подвальное помещение, обставленое алхимическими столами, комодами и шкафами с различными разноцветными пузырьками. Вас встречает седой старичок в сером халате:#-Здраствуй, '.$user['char_name'].'! Добро пожаловать в Гильдию Алхимиков. У нас ты можешь улучшить свои познания в алхимии. Еще можешь приготовить нужные тебе эликсиры.#Также я щедро плачу золотом за алхимические ингредиенты: грибы, травы, корни...##';
	$t .= $user['class']['item']->inv_item_list(Item::CAT_ING);
	$user['description'] = $t;
	$user['links'] = array();
	Location::addlink('Покинуть гильдию', 'index.php?action=guilds');
	Location::addlink('Продать ингредиенты', 'index.php?action=guild_alch&do=ing_trade', 1);
	Location::addlink('Подойти к столу', 'index.php?action=guild_alch&do=alchemy', 2);

	if ($do == 'ing_trade') {
		if ($user['char_life_cur'] <= 0) die('{"error":"Вам сначала нужно вернуться к жизни!"}');
		$gold = $user['class']['item']->gold_trade(Item::CAT_ING);
		$user['description'] = 'Вы продали все ингредиенты и заработали '.$gold.' золотых монет.';
		$user['links'] = array();
		Location::addlink('Назад', 'index.php?action=guild_alch');
	}

	if ($do == 'alchemy') {
		$user['description'] = 'Вы подходите к алхимическому столу и достаете из заплечной сумки все необходимое для зельеварения. Старик молча уходит в сторону, оставляя вас в одиночестве.';
		$user['links'] = array();
		Location::addlink('Назад', 'index.php?action=guild_alch');
		Location::addlink('Рецепты Эликсиров', 'index.php?action=guild_alch&do=elix_recipes', 1);
		Location::addlink('Купить Пустой Флакон', 'index.php?action=guild_alch&do=empty_elix', 2);
		Location::addlink('Варить "Эликсир Исцеления"', 'index.php?action=guild_alch&do=hp_elix', 3);
		Location::addlink('Варить "Эликсир Маны"', 'index.php?action=guild_alch&do=mp_elix', 4);
		Location::addlink('Варить "Эликсир Огра"', 'index.php?action=guild_alch&do=st_elix', 5);
		Location::addlink('Варить "Эликсир Омоложения"', 'index.php?action=guild_alch&do=rf_elix', 6);
		Location::addlink('Варить "Эликсир Тролля"', 'index.php?action=guild_alch&do=troll_elix', 7);
	}

	if ($do == 'elix_recipes') {
		$user['description'] = 'Алхимик мелкими шажками приближается к Вам, достает из заплечной сумки старую потрепаную книгу и говорит:#-Ты спрашивай, a я с удовольствием поделюсь с тобой рецептом.';
		$user['links'] = array();
		Location::addlink('Назад', 'index.php?action=guild_alch&do=alchemy');
		Location::addlink('Рецепт "Эликсир Исцеления"', 'index.php?action=guild_alch&do=hp_recipe', 1);
		Location::addlink('Рецепт "Эликсир Маны"', 'index.php?action=guild_alch&do=mp_recipe', 2);
		Location::addlink('Рецепт "Эликсир Огра"', 'index.php?action=guild_alch&do=st_recipe', 3);
		Location::addlink('Рецепт "Эликсир Омоложения"', 'index.php?action=guild_alch&do=rf_recipe', 4);
		Location::addlink('Рецепт "Эликсир Тролля"', 'index.php?action=guild_alch&do=troll_recipe', 5);
	}

	if ($do == 'hp_recipe') {
		$user['description'] = 'Старик открывает старую книгу и что-то там долго ищет...#-Так-c, посмотрим...##Эликсир Исцеления:#============#Ингредиенты:#------------#Цветок Трубкоцвета - 3 шт.#Черный Гриб - 1 шт.';
		$user['links'] = array();
		Location::addlink('Назад', 'index.php?action=guild_alch&do=elix_recipes');
	}

	if ($do == 'mp_recipe') {
		$user['description'] = 'Старик открывает старую книгу и что-то там долго ищет...#-Так-c, посмотрим...##Эликсир Маны:#============#Ингредиенты:#------------#Цветок Снежноцвета - 3 шт.#Черный Гриб - 1 шт.';
		$user['links'] = array();
		Location::addlink('Назад', 'index.php?action=guild_alch&do=elix_recipes');
	}

	if ($do == 'st_recipe') {
		$user['description'] = 'Старик открывает старую книгу и что-то там долго ищет...#-Так-c, посмотрим...##Эликсир Огра:#============#Ингредиенты:#------------#Цветок Болеголова - 3 шт.#Эликсир Исцеления - 1 шт.';
		$user['links'] = array();
		Location::addlink('Назад', 'index.php?action=guild_alch&do=elix_recipes');
	}

	if ($do == 'rf_recipe') {
		$user['description'] = 'Старик открывает старую книгу и что-то там долго ищет...#-Так-c, посмотрим...##Эликсир Омоложения:#============#Ингредиенты:#------------#Эликсир Исцеления - 1 шт.#Эликсир Маны - 1 шт.';
		$user['links'] = array();
		Location::addlink('Назад', 'index.php?action=guild_alch&do=elix_recipes');
	}

	if ($do == 'troll_recipe') {
		$user['description'] = 'Старик открывает старую книгу и что-то там долго ищет...#-Так-c, посмотрим...##Эликсир Тролля:#============#Трофеи:#------------#Кровь Тролля - 1 шт.##Ингредиенты:#------------#Эликсир Огра - 1 шт.';
		$user['links'] = array();
		Location::addlink('Назад', 'index.php?action=guild_alch&do=elix_recipes');
	}

	if ($do == 'empty_elix') {
		if ($user['char_life_cur'] <= 0) die('{"error":"Вам сначала нужно вернуться к жизни!"}');
		$user['description'] = 'Старик улыбается и приближается к вам, на ходу открывая сумку на поясе:#-Да, конечно. У меня всегда есть Пустые Флаконы для твоих экспериментов. Цена одного - 100 золотых монет.';
		$user['class']['item']->buy_empty_elixir(1);
		$user['links'] = array();
		Location::addlink('Назад', 'index.php?action=guild_alch&do=alchemy');
	}

	if ($do == 'hp_elix') {
		if ($user['char_life_cur'] <= 0) die('{"error":"Вам сначала нужно вернуться к жизни!"}');
		$t = 'Вы делаете отвар из Черного Гриба. Затем в него бросаете цветки Трубкоцвета и снова варите примерно два часа. Содержимое котелка Вы заливаете в Пустой Флакон и получаете Эликсир Исцеления!';
		$user['description'] = $user['class']['item']->make_elixir(Item::ELIXIR_HP, $t, 'Трубкоцвет', Item::HP_HERB, 3, 'Черный Гриб', Item::MASH_HERB, 1);
		$user['links'] = array();
		Location::addlink('Назад', 'index.php?action=guild_alch&do=alchemy');
	}

	if ($do == 'mp_elix') {
		if ($user['char_life_cur'] <= 0) die('{"error":"Вам сначала нужно вернуться к жизни!"}');
		$t = 'Вы берете несколько цветков Снежноцвета, один Черный Гриб, бросаете все в котелок и варите на медленном огне примерно около часа. Затем путем нехитрых манипуляций с перегонным кубом Вы получаете Эликсир Маны!';
		$user['description'] = $user['class']['item']->make_elixir(Item::ELIXIR_MP, $t, 'Снежноцвет', Item::MP_HERB, 3, 'Черный Гриб', Item::MASH_HERB, 1);
		$user['links'] = array();
		Location::addlink('Назад', 'index.php?action=guild_alch&do=alchemy');
	}

	if ($do == 'st_elix') {
		if ($user['char_life_cur'] <= 0) die('{"error":"Вам сначала нужно вернуться к жизни!"}');
		$t = 'Вы на медленном огне доводите до кипения все содержимое Эликсира Исцеления и, добавив в чан с пенящейся густой жидкостью несколько цветков Болеголова, варите примерно еще час. Затем отстаиваете и переливаете в Пустой Флакон. Эликсир Огра готов!';
		$user['description'] = $user['class']['item']->make_elixir(Item::ELIXIR_ST, $t, 'Болеголов', Item::ST_HERB, 3, 'Эликсир Исцеления', Item::ELIXIR_HP, 1);
		$user['links'] = array();
		Location::addlink('Назад', 'index.php?action=guild_alch&do=alchemy');
	}

	if ($do == 'rf_elix') {
		if ($user['char_life_cur'] <= 0) die('{"error":"Вам сначала нужно вернуться к жизни!"}');
		$t = 'Когда закипает все содержиое Эликсира Исцеления, вы небольшими порциями добавляете Эликсир Маны, тщательно перемешивая и варите еще примерно три часа. Затем жидкость отстаиваете и переливаете в Пустой Флакон. Эликсир Омоложения готов!';
		$user['description'] = $user['class']['item']->make_elixir(Item::ELIXIR_RF, $t, 'Эликсир Исцеления', Item::ELIXIR_HP, 1, 'Эликсир Маны', Item::ELIXIR_MP, 1);
		$user['links'] = array();
		Location::addlink('Назад', 'index.php?action=guild_alch&do=alchemy');
	}

	if ($do == 'troll_elix') {
		if ($user['char_life_cur'] <= 0) die('{"error":"Вам сначала нужно вернуться к жизни!"}');
		$t = 'Вы выливаете содержимое Эликсира Огра в медный чан и доводите до кипения на медленном огне. Затем небольшими порциями вливаете Кровь Тролля и варите еще примерно два часа. Затем жидкость отстаиваете и переливаете в Пустой Флакон. Эликсир Тролля готов!';
		$user['description'] = $user['class']['item']->make_elixir(Item::ELIXIR_TROLL, $t, 'Эликсир Огра', Item::ELIXIR_ST, 1, 'Кровь Тролля', Item::TROLL_BLOOD, 1);
		$user['links'] = array();
		Location::addlink('Назад', 'index.php?action=guild_alch&do=alchemy');
	}

	$res = json_encode($user, JSON_UNESCAPED_UNICODE);	

}

if ($action == 'guild_mage') {

	$item_categories = [Item::CAT_SCROLL_TP, Item::CAT_SCROLL_HEAL, Item::CAT_SCROLL_BLESS, Item::CAT_SCROLL_LEECH];
	$user['title'] = 'Гильдия Магов';
	$t = '+++++++++##';
	$h = $user['class']['item']->inv_item_lists($item_categories);
	$user['description'] = $t.'Ваши свитки:#============#'.$h[0].'============#Всего: '.$h[1].' зол.';
	$user['links'] = array();
	Location::addlink('Покинуть гильдию', 'index.php?action=guilds');
	Location::addlink('Продать Свитки', 'index.php?action=guild_mage&do=scroll_trade', 1);

	if ($do == 'scroll_trade') {
		if ($user['char_life_cur'] <= 0) die('{"error":"Вам сначала нужно вернуться к жизни!"}');
		$gold = $user['class']['item']->gold_trades($item_categories);
		$user['description'] = 'Вы продали все свои магические свитки и заработали '.$gold.' золотых монет.';
		$user['links'] = array();
		Location::addlink('Назад', 'index.php?action=guild_mage');
	}

	$res = json_encode($user, JSON_UNESCAPED_UNICODE);	

}

?>