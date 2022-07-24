<?php

if ($action == 'stables') 	{$res = travel_to($action, $do, [1]);}
if ($action == 'harbor') 	{$res = travel_to($action, $do, [2,5]);}
if ($action == 'dir_tower')	{$res = travel_to($action, $do, [3]);}
if ($action == 'fly') 		{$res = travel_to($action, $do, [4]);}
//if ($action == 'portal')	{$res = travel_to($action, $do, []);}

?>