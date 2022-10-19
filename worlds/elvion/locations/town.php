<?php

if ($action == 'town') {
	
	$user['title'] = $user['char_region_town_name'];
	if ($user['char_life_cur'] > 0) {

		switch ($user['char_region']) {
			case 1:
				$user['description'] = 'Небольшой изолированный городишко, в паре дней пути от других населенных пунктов. Городок по большей части может себя обеспечить и его жителям нет нужды выезжать в соседние города. У них есть фермы, торговая лавка, школа, больница, банк, таверна, городской зал, несколько гильдий, церковь и ещё множество других строений, которые необходимы маленькому городку для выживания. Население невелико, каждый знает в лицо и по именам всех горожан, и редкие чужаки тут же бросаются в глаза. Хотя почва плодородная, а климат умеренный, жизнь в городке тяжела. Нужно работать от зари до зари и оттого все жители не страдают излишними сантиментами и возвышенными иллюзиями. Это крепкий, практичный трудовой народ, ценящий тишину и традиции.';
				break;
			case 2:
				$user['description'] = 'Бывший шахтёрский поселок, населённый преимущественно гномами, полуорками и людьми. Ныне город, с населением более 2-х тысяч человек и большим портом. Славен он своими ремесленниками и пастбищами, на которых пасутся тучные стада. Основной поставщик руды, древесины и технических новинок. Единственное место, где магия практически не используется, за исключением самых насущных случаев, а также единственное место в северной части материка, где строят паровые машины и дирижабли для всей Империи.';
				break;
			case 3:
				$user['description'] = 'Город-крепость западнее Титанических Гор на севере материка. Население небольшое, но много военных, а так же искателей приключений. Ничего примечательного в городке нет кроме того, что по периметру крепости на стенах установлены катапульты большого радиуса действия. Собственно, в этом и заключается эффективность города-крепости, как объекта охраны границы.';
				break;
			case 4:
				$user['description'] = 'Среди высоких гор, в неприступной долине, окружённой отвесными скалами, стоит город Толесад. Попасть в город путешественнику просто: дварфы поддерживают в прекрасном состоянии дорогу. Надо лишь свернуть с основного тракта – и ждёт странника отдых и возможность получше снарядиться в дальнейшую дорогу. Добротный острый дварфийский топор и тёплый шерстяной плащ ещё никому не помешали в пути! Испокон веков населённый дварфами город знавал и взлёты, и падения, но никогда на горных лугах не заканчивалась трава, а в недрах земли – металлы и драгоценные камни.';
				break;
			case 5:
				$user['description'] = 'Среди бескрайних полей расположился Эндалион, один из величайших человеческих городов Империи. Активная торговля с соседними городами снабжает его жителей всей необходимой продукцией. Точную дату основания города установить не удаётся. Известно только, что он был заложен в последнем веке Второй эпохи. Примерно в то же время значительно увеличилось число жителей и была достроена стена, ныне опоясывающая старые кварталы города.';
				break;
			case 6:
				$user['description'] = 'Город расположен в живописной долине горной реки Ашиот. Сразу же после основания этот город нередко называли Городом Беглецов, поскольку сюда переезжали те, кто по тем или иным причинам покидали другие города Империи. Но это лишь первое впечатление о городе — стоит чуть внимательнее изучить его, как за атмосферой безмятежности открывается совсем другая грань местной истории — история свободной разгульной вольницы, история мятежей и народных восстаний.';
				break;
			case 7:
				$user['description'] = 'Это прекраснейший город, в котором сочетаются стили архитектуры разных рас. Выгодное расположение, мягкий климат и наличие у местных алхимиков особых снадобий неизменно привлекает в этот город множество героев и странников. Благодаря чистому воздуху, исцеляющей магии, здоровой пище, доброму отношению и современным технологиям в лечебницах города лекари ставят на ноги даже безнадёжно больных.';
				break;
			case 8:
				$user['description'] = 'Бывший некогда небольшой дварфийской заставой городок за последние десятилетия вырос до размеров приличного города, население которого пополнилось переселенцами всех известных рас, живущих друг с другом в мире и согласии. Сначала невдалеке от дварфийского поселения появились дома других рас, а затем все они слились в один большой город с разнообразной архитектурой и множеством парков.';
				break;
			case 9:
				$user['description'] = 'Городок по праву считается одним из древнейших городов Империи, чья дата основания утеряна в веках. Некоторые даже считают, что его стены помнят Войну Древних, но достоверных подтверждений этому нет. Также известен он своими охотничьими угодьями и густыми непроходимыми лесами. Во вторую эпоху дварфы-ремесленники покинули город. Их место заняли эльфы. Город перестал быть городом мастеров, но стал прекрасным городом эльфов, затерянным в лесах.';
				break;
			case 10:
				$user['description'] = 'Город расположен в низине между холмов, что обнимают его со всех сторон. За высоким частоколом часть домов плотно прилегает друг к другу, образуя несколько улиц, другие дома более рассеяны по округе. Есть также несколько небольших домов, больше похожих на поместья и большая усадьба чуть поодаль остальных.';
				break;
		}
		
	} else $user['class']['location']->shades();

	$user['links'] = array();
	if ($user['char_life_cur'] > 0) {
		
		$user['class']['location']->go_to_the_gate('Покинуть '.$user['char_region_town_name']);
		addlink('Посетить Таверну', 'index.php?action=tavern', 1);
		addlink('Отправиться в Банк', 'index.php?action=bank', 2);
		addlink('Идти в Магическую Башню', 'index.php?action=magictower', 3);
		addlink('Квартал Гильдий', 'index.php?action=guilds', 4);
		addlink('Квартал Торговцев', 'index.php?action=shops', 5);
		
	} else $user['class']['location']->go_to_the_graveyard();
	
	$res = json_encode($user, JSON_UNESCAPED_UNICODE);
	
}

?>