<?php

	class User {
		
		static function init($username, $userpass) {
			global $tb_user, $connection;
			$query = 'SELECT * FROM '.$tb_user." WHERE user_name='".$username."' AND user_pass='".$userpass."'";
			$result = mysqli_query($connection, $query) 
				or die('{"error":"Ошибка считывания данных: '.mysqli_error($connection).'"}');
			return $result->fetch_assoc();
		}
	
		static function session() {
			global $user;
			$user['user_session'] = time();
			update_user_table("user_session='".$user['user_session']."'");
			return $user['user_session'];

		}
	
		static function check_user($user_name) {
			global $connection, $tb_user;
			$query = "SELECT user_name FROM ".$tb_user." WHERE user_name='".$user_name."'";
			$user = mysqli_query($connection, $query) or die('{"error":"Ошибка сохранения данных: '.mysqli_error($connection).'"}');
			if(mysqli_num_rows($user) > 0) {
				return true;
			} else {
				return false;
			}
		}
	
		static function check_char($char_name) {
			global $user;
			if (strtolower($user['char_name']) == strtolower($char_name)) {
				return true;
			} else {
				return false;
			}
		}
	
		static function update($s) {
			global $user, $tb_user, $connection;
			$query = "UPDATE ".$tb_user." SET ".$s." WHERE user_name='".$user['user_name']."'";
			if (!mysqli_query($connection, $query)) {
				die('{"error":"Ошибка сохранения данных: '.mysqli_error($connection).'"}');
			}
		}
	
	}

?>