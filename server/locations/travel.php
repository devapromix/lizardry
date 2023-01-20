<?php

if ($action == 'stables') 		{$res = $user['class']['location']->travel_to($action, $do, [1, 7], [2, 8]);}
if ($action == 'harbor') 		{$res = $user['class']['location']->travel_to($action, $do, [2, 5], [3, 6]);}
if ($action == 'dir_tower')		{$res = $user['class']['location']->travel_to($action, $do, [3], [4]);}
if ($action == 'fly') 			{$res = $user['class']['location']->travel_to($action, $do, [4], [5]);}
if ($action == 'portal')		{$res = $user['class']['location']->travel_to($action, $do, [6], [7]);}
if ($action == 'uni_stables')	{$res = $user['class']['location']->travel_to($action, $do, [2], [11]);}

?>