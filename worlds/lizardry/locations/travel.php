<?php

if ($action == 'stables') 	{$res = $user['class']['location']->travel_to($action, $do, [1,7]);}
if ($action == 'harbor') 	{$res = $user['class']['location']->travel_to($action, $do, [2,5]);}
if ($action == 'dir_tower')	{$res = $user['class']['location']->travel_to($action, $do, [3]);}
if ($action == 'fly') 		{$res = $user['class']['location']->travel_to($action, $do, [4]);}
if ($action == 'portal')	{$res = $user['class']['location']->travel_to($action, $do, [6]);}

?>