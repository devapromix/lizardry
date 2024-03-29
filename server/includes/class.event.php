<?php

	class Event {

		public const BORN 	= 0;
		public const LEVEL 	= 1;
		public const ITEM 	= 2;
		public const DEAD 	= 3;
		public const KILL 	= 4;

		public const MAX 	= 15;

		public function __construct() {
			
		}
		
		public static function add(int $type, $name, int $level = 1, int $gender = 0, $str = '', $loc_name = '') {
			global $connection, $user, $tb_events;
			$query = "INSERT INTO ".$tb_events." (event_type,event_char_gender,event_char_name,event_char_level,event_str,event_loc) VALUES(".$type.", ".$gender.", '".$name."', ".$level.", '".$str."', '".$loc_name."')";
			if (!mysqli_query($connection, $query)) {
				die('{"error":"Ошибка сохранения данных: '.mysqli_error($connection).'"}');
			}
		}
		
		public static function get_events() {
			global $connection, $tb_events;
			$query = "SELECT event_type, event_char_gender, event_char_name, event_char_level ,event_str, event_loc FROM ".$tb_events." ORDER BY id  DESC LIMIT 0, ".self::MAX;
			$result = mysqli_query($connection, $query) 
				or die('{"error":"Ошибка считывания данных: '.mysqli_error($connection).'"}');
			$events = $result->fetch_all(MYSQLI_ASSOC);
			return json_encode($events, JSON_UNESCAPED_UNICODE);
		}

	}

?>