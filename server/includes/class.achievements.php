<?php

	class Achievements {
		
		public const FIRST_BLOOD		= 1;
		
		public function add(int $achievement_ident) {
			global $user, $tb_achievements, $connection;
			if (!$this->has($achievement_ident)) {
				$strbox = new StringBox($user['char_achievements']);
				$strbox->add($achievement_ident, 1);
				$user['char_achievements'] = $strbox->get_string();
				$str = '';
				$query = "SELECT * FROM ".$tb_achievements." WHERE achievement_ident=".$achievement_ident." LIMIT 1";
				$result = mysqli_query($connection, $query) 
					or die('{"error":"Ошибка считывания данных: '.mysqli_error($connection).'"}');
				$achievements = $result->fetch_assoc();
				$str .= 'У вас новое достижение: "'.$achievements['achievement_name'].'" - '.$achievements['achievement_description'].'.#';
				User::update("char_achievements='".$user['char_achievements']."'");
				return $str;
			} else return "";
		}

		public function has(int $achievement_ident) {
			global $user;
			$strbox = new StringBox($user['char_achievements']);
			return $strbox->has($achievement_ident);
		}
		
		public static function get_achievements() {
			global $tb_achievements, $connection;

			$query = "SELECT * FROM ".$tb_achievements;
			$result = mysqli_query($connection, $query) 
				or die('{"error":"Ошибка считывания данных: '.mysqli_error($connection).'"}');
			$achievements = $result->fetch_all(MYSQLI_ASSOC);

			return json_encode($achievements, JSON_UNESCAPED_UNICODE);
		}

	}

?>