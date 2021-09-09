<?php
$res = '0';

include 'common/common.php';

$action = $_GET['action'];
$amount = $_GET['amount'];

if (file_exists('characters/character.'.$username.'.php')) {
	require_once 'characters/character.'.$username.'.php';
	if (($userpass != '')&&($userpass == $user_pass)) {
		if ($action == 'login') {
			$res = '1';
		}
		// Town
		include 'locations/town.php';
		// Forest
		include 'locations/forest.php';
		// Tavern
		include 'locations/tavern.php';
		// Bank
		include 'locations/bank.php';
	}
}

echo $res;
?>