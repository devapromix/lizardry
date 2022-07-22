<?php

// #1
if ($action == 'dark_forest') outland($action, [1,2,3], [], ['Серая Пещера', 'index.php?action=gray_cave']);
if ($action == 'gray_cave') outland($action, [4,5,6], ['Темный Лес', 'index.php?action=dark_forest'], ['Глубокие Пещеры', 'index.php?action=deep_caves']);
if ($action == 'deep_caves') outland($action, [7,8,9], ['Серая Пещера', 'index.php?action=gray_cave'], ['Логово Каменных Червей', 'index.php?action=stoneworm_lair']);
if ($action == 'stoneworm_lair') outland($action, [10,11,12], ['Глубокие Пещеры', 'index.php?action=deep_caves']);
// #2
if ($action == 'crypt') outland($action, [13,14,15,16], ['Вернуться на Кладбище', 'index.php?action=graveyard']);
if ($action == 'treant_forest') outland($action, [17,18,19]);
if ($action == 'old_harbor') outland($action, [20,21,22]);
if ($action == 'stonefield') outland($action, [23,24,25]);
// #3
if ($action == 'stone_giant_forest') outland($action, [26,27,28,29], [], ['Лунная Поляна', 'index.php?action=moon_meadow']);
if ($action == 'moon_meadow') outland($action, [30,31,32], ['Лес Каменных Гигантов', 'index.php?action=stone_giant_forest']);
if ($action == 'monast') outland($action, [33,34,35], [], ['Подвал Монастыря', 'index.php?action=cellar']);
if ($action == 'cellar') outland($action, [36,37,38,39], ['Монастырь', 'index.php?action=monast']);
// #4
if ($action == 'abandoned_mines') outland($action, [40,41,42,43]);
if ($action == 'icy_lake') outland($action, [44,45,46]);
if ($action == 'vulture_valley') outland($action, [47,48,49]);
if ($action == 'cathedral_of_the_deep') outland($action, [50,51,52]);
// #5
if ($action == 'alone_mountain') outland($action, [53,54,55,56]);
if ($action == 'dark_valley') outland($action, [57,58,59]);
if ($action == 'forgotten_forest') outland($action, [60,61,62], [], ['Пещера Боли', 'index.php?action=cave_of_pain']);
if ($action == 'cave_of_pain') outland($action, [63,64,65], ['Забытый Лес', 'index.php?action=forgotten_forest']);
// #6
if ($action == 'red_desert') outland($action, [66,67,68,69]);
if ($action == '+') outland($action, [70,71,72]);
if ($action == '+') outland($action, [73,74,75]);
if ($action == '+') outland($action, [76,77,78]);
// #7
if ($action == '+') outland($action, [79,80,81,82]);
if ($action == '+') outland($action, [83,84,85]);
if ($action == '+') outland($action, [86,87,88]);
if ($action == '+') outland($action, [89,90,91]);
// #8
if ($action == '+') outland($action, [92,93,94,95]);
if ($action == '+') outland($action, [96,97,98]);
if ($action == '+') outland($action, [99,100,101]);
if ($action == '+') outland($action, [102,103,104]);
// #9
if ($action == '+') outland($action, [105,106,107,108]);
if ($action == '+') outland($action, [109,110,111]);
if ($action == '+') outland($action, [112,113,114]);
if ($action == '+') outland($action, [115,116,117]);
// #10
if ($action == '+') outland($action, [118,119,120,121]);
if ($action == '+') outland($action, [122,123,124]);
if ($action == '+') outland($action, [125,126,127]);
if ($action == '+') outland($action, [128,129,130]);

?>