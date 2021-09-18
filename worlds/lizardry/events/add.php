<?php

require "../common/common.php";

$aa = $_GET["aa"];
$bb = $_GET["bb"];
$cc = $_GET["cc"];
$dd = $_GET["dd"];
$ee = $_GET["ee"];

$f = "events.txt";
$h = file($f);
if ($h) {
	$c = count($h);
	if ($c > 0) {
		$fp = fopen($f,"w") or die("can't open file");
		fwrite($fp, "");
		fclose($fp);

		$fp = fopen($f,"a");
		$k = $c - 9;
		if ($k < 0)
			$k = 0;
		for ($i = $k; $i < $c; $i++) {
			fwrite($fp, $h[$i]);
		}
		fclose($fp);
	}
}
$fp = fopen($f, "a");
$ss = "$aa,$bb,$cc,$dd,$ee|"."\n";
fwrite($fp, $ss);
fclose($fp);

?>
