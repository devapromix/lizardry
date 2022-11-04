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

function get_file_int($fn) {
	$r = '';
	if(file_exists($fn)) {
		$array = file($fn);
		$r = join("", $array);
	}
	return $r;
}

function addlink($t, $j, $n = 0) {
	global $user;
	$user['links'][$n]['title'] = $t;
	$user['links'][$n]['link'] = $j;	
}

?>