<?php

	class User {

		public static function init($username, $userpass) {
			global $tb_user, $connection;
			self::check_login_data($username, $userpass);
			$query = 'SELECT * FROM '.$tb_user." WHERE user_name='".$username."' AND user_pass='".$userpass."'";
			$result = mysqli_query($connection, $query) 
				or die('{"error":"Ошибка считывания данных: '.mysqli_error($connection).'"}');
			return $result->fetch_assoc();
		}

		public static function session() {
			global $user;
			$user['user_session'] = time();
			User::update("user_session='".$user['user_session']."'");
			return $user['user_session'];
		}

		public static function check_user($user_name) {
			global $connection, $tb_user;
			$query = "SELECT user_name FROM ".$tb_user." WHERE user_name='".$user_name."'";
			$user = mysqli_query($connection, $query) or die('{"error":"Ошибка сохранения данных: '.mysqli_error($connection).'"}');
			if(mysqli_num_rows($user) > 0) {
				return true;
			} else {
				return false;
			}
		}

		public static function clear_message() {
			User::update("user_message=''");
		}

		public static function check_char($char_name) {
			global $user;
			if (strtolower($user['char_name']) == strtolower($char_name)) {
				return true;
			} else {
				return false;
			}
		}

		public static function update($s) {
			global $user, $tb_user, $connection;
			$query = "UPDATE ".$tb_user." SET ".$s." WHERE user_name='".$user['user_name']."'";
			if (!mysqli_query($connection, $query)) {
				die('{"error":"Ошибка сохранения данных: '.mysqli_error($connection).'"}');
			}
		}

		public static function check_login_data($username, $userpass) {
			if ($username == '') die('{"error":"Введите имя учетной записи!"}');
			if (strlen($username) < 4) die('{"error":"Имя учетной записи не должно быть короче 4 символов!"}');
			if (strlen($username) > 24) die('{"error":"Имя учетной записи должно быть длиннее 24 символов!"}');
			if ($userpass == '') die('{"error":"Введите пароль!"}');
			if (strlen($userpass) < 4) die('{"error":"Пароль не должен быть короче 4 символов!"}');
		}

		public static function check_registration_data($username, $userpass, $charname) {
			if ($username == '') die('{"error":"Введите имя учетной записи!"}');
			if (strlen($username) < 4) die('{"error":"Имя учетной записи не должно быть короче 4 символов!"}');
			if (strlen($username) > 24) die('{"error":"Имя учетной записи должно быть длиннее 24 символов!"}');
			if ($userpass == '') die('{"error":"Введите пароль!"}');
			if (strlen($userpass) < 4) die('{"error":"Пароль не должен быть короче 4 символов!"}');
			if ($charname == '') die('{"error":"Введите имя персонажа!"}');
			if (strlen($charname) < 4) die('{"error":"Имя персонажа не должно быть короче 4 символов!"}');
			if (strlen($charname) > 24) die('{"error":"Имя персонажа не должно быть длиннее 24 символов!"}');
		}

	}

?>