<?php

// #1
if ($action == 'dark_forest') outland($action, [1,2,3], ['Идти в сторону города', 'index.php?action=gate'], ['Серая Пещера', 'index.php?action=gray_cave']);
if ($action == 'gray_cave') outland($action, [4,5,6], ['Темный Лес', 'index.php?action=dark_forest'], ['Глубокие Пещеры', 'index.php?action=deep_caves']);
if ($action == 'deep_caves') outland($action, [7,8,9], ['Серая Пещера', 'index.php?action=gray_cave'], ['Логово Каменных Червей', 'index.php?action=stoneworm_lair']);
if ($action == 'stoneworm_lair') outland($action, [10,11,12], ['Глубокие Пещеры', 'index.php?action=deep_caves']);

// #2
if ($action == 'crypt') outland($action, [13,14,15,16], ['Вернуться на Кладбище', 'index.php?action=graveyard']);
if ($action == 'treant_forest') outland($action, [17,18,19]);
if ($action == 'old_harbor') outland($action, [20,21,22]);
if ($action == 'stonefield') outland($action, [23,24,25]);
// #3
// #4
// #5
// #6
// #7
// #8
// #9

?>