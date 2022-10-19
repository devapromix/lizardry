<?php

	class Location {

		public function __construct() {
			
		}
		
		public function shades() {
			global $user;
			$user['description'] = 'Вы находитесь в мире теней и ищете проход в мир живых. Чувствуется необычайная легкость и безразличие ко всему происходящему. Ваша душа вздымается все выше и выше. Повсюду вокруг вас души погибших в бесконечных битвах. Их души преследуют вас и шепчут о своих муках и страданиях. В мире теней одиноко, холодно и не уютно. Вы ищите ближайшее кладбище чтобы поскорее вернуться в мир живых.';
		}
		
		public function after_travel() {
			global $user;
			$user['title'] = 'Путешествие';
			$user['description'] = 'После нескольких дней увлекательного путешествия Вы прибыли в другой город и вот уже виднеются высокие городские стены.';
			$user['links'] = array();
			$this->go_to_the_gate('Идти к воротам в город');
		}

		public function go_to_the_town($t = 'Вернуться в город', $n = 0) {
			addlink($t, 'index.php?action=town', $n);
		}

		public function go_to_the_graveyard($t = 'Идти на кладбище', $n = 0) {
			addlink($t, 'index.php?action=graveyard', $n);
		}

		public function go_to_the_gate($t = 'Идти в сторону города', $n = 0) {
			addlink($t, 'index.php?action=gate', $n);
		}		
		
		public function check_travel_req($level, $food, $gold) {
			global $user;
			if ($user['char_life_cur'] <= 0) die('{"error":"Вам сначала нужно вернуться к жизни!"}');
			if ($user['char_level'] < $level) die('{"info":"Для путешествия в другой регион нужен '.$level.'-й уровень!"}');
			if ($user['char_food'] < $food) die('{"info":"Возьмите в дорогу не менее '.$food.'-х мешков провизии!"}');
			if ($user['char_gold'] < $gold) die('{"info":"Возьмите в дорогу не менее '.$gold.' золотых монет!"}');
		}

		public function travel_req($level, $food, $gold) {
			return ' Но нужно выполнить определенные условия:#Уровень героя - не менее '.$level.'-го.#С собой иметь не менее '.$food.'-x пакетов с провиантом.#Стоимость путешествия - '.$gold.' золотых монет.';
		}

	}

?>