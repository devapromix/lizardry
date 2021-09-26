<?php

define('DS', DIRECTORY_SEPARATOR);
define('PATH', dirname(__FILE__).DS);

echo file_get_contents(PATH."events".DS."events.txt");

?>