<?php
define('DS', DIRECTORY_SEPARATOR);
define('PATH', dirname(__FILE__).DS.'..'.DS);
define('IPATH', 'includes'.DS);

$username = $_GET['username'];
$userpass = $_GET['userpass'];
$usersession = $_GET['usersession'];

if ($username == '') die('21');
if ($userpass == '') die('22');

if (strlen($username) < 4) die('31');
if (strlen($userpass) < 4) die('32');

if (strlen($username) > 24) die('41');
if (strlen($userpass) > 24) die('42');

const EMPTY_ELIX 		= '600';
const HP_ELIX 			= '601';
const MP_ELIX 			= '602';
const ST_ELIX 			= '603';
const RF_ELIX 			= '604';
const TROLL_ELIX		= '605';

const MASH_HERB			= '750';
const HP_HERB			= '751';
const MP_HERB			= '752';
const ST_HERB			= '753';
const TROLL_BLOOD		= '811';

function get_user($username, $userpass) {
	global $tb_user, $connection;

	$query = 'SELECT * FROM '.$tb_user." WHERE user_name='".$username."' AND user_pass='".$userpass."'";
	$result = mysqli_query($connection, $query) 
		or die('{"error":"Ошибка считывания данных: '.mysqli_error($connection).'"}');

	return $result->fetch_assoc();
}

function gen_user_session() {
	global $user;
	$user['user_session'] = time();
	update_user_table("user_session='".$user['user_session']."'");
	return $user['user_session'];
}

function check_user($user_name) {
	global $connection, $tb_user;
	$query = "SELECT user_name FROM ".$tb_user." WHERE user_name='".$user_name."'";
	$user = mysqli_query($connection, $query) 
	  or die('{"error":"Ошибка сохранения данных: '.mysqli_error($connection).'"}');
	if(mysqli_num_rows($user) > 0) {
		return true;
	} else {
		return false;
	}
}

function check_char($char_name) {
	global $user;
	if (strtolower($user['char_name']) == strtolower($char_name)) {
		return true;
	} else {
		return false;
	}
}

function update_user_table($s) {
	global $user, $tb_user, $connection;
	$query = "UPDATE ".$tb_user." SET ".$s." WHERE user_name='".$user['user_name']."'";
	if (!mysqli_query($connection, $query)) {
		die('{"error":"Ошибка сохранения данных: '.mysqli_error($connection).'"}');
	}
}

function get_version() {
	return get_file_int(PATH.'version.txt');
}

function gettime() {
	return date('d.m.Y H:i'); 
}

function get_file_int($fn) {
	$r = '';
	if(file_exists($fn)) {
		$array = file($fn);
		$r = join("", $array);
	}
	return $r;
}

function get_param($value, $default) {
	$res = $default;
	if(IsSet($_GET[$value])) {
		$res = $_GET[$value];
	}
	return $res;
}

function post_param($value, $default) {
	$res = $default;
	if(IsSet($_POST[$value])) {
		$res = $_POST[$value];
	}
	return $res;
}

function add_event($type, $name, $level = 1, $gender = 0, $str = '', $loc_name = '') {
	global $connection, $user, $tb_events;
	$query = "INSERT INTO ".$tb_events." (event_type,event_char_gender,event_char_name,event_char_level,event_str,event_loc) VALUES(".$type.", ".$gender.", '".$name."', ".$level.", '".$str."', '".$loc_name."')";
	if (!mysqli_query($connection, $query)) {
		die('{"error":"Ошибка сохранения данных: '.mysqli_error($connection).'"}');
	}
}

function get_events() {
	global $connection, $tb_events;
	$query = "SELECT event_type, event_char_gender, event_char_name, event_char_level ,event_str, event_loc FROM ".$tb_events." ORDER BY id  DESC LIMIT 0, 15";
	$result = mysqli_query($connection, $query) 
		or die('{"error":"Ошибка считывания данных: '.mysqli_error($connection).'"}');
	$events = $result->fetch_all(MYSQLI_ASSOC);
	return json_encode($events, JSON_UNESCAPED_UNICODE);
}

function get_messages() {
	global $tb_chat, $connection;

	$query = "SELECT message_author, message_text FROM ".$tb_chat;
	$result = mysqli_query($connection, $query) 
		or die('{"error":"Ошибка считывания данных: '.mysqli_error($connection).'"}');
	$messages = $result->fetch_all(MYSQLI_ASSOC);

	return json_encode($messages, JSON_UNESCAPED_UNICODE);
}

function addlink($t, $j, $n = 0) {
	global $user;
	$user['links'][$n]['title'] = $t;
	$user['links'][$n]['link'] = $j;	
}

?>