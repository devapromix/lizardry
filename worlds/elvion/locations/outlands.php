<?php

// #1
if ($action == 'dark_forest') $user['class']['location']->outland($action, [1,2,3], [], ['Серая Пещера', 'index.php?action=gray_cave']);
if ($action == 'gray_cave') $user['class']['location']->outland($action, [4,5,6], ['Темный Лес', 'index.php?action=dark_forest'], ['Глубокие Пещеры', 'index.php?action=deep_caves']);
if ($action == 'deep_caves') $user['class']['location']->outland($action, [7,8,9], ['Серая Пещера', 'index.php?action=gray_cave'], ['Логово Каменных Червей', 'index.php?action=stoneworm_lair']);
if ($action == 'stoneworm_lair') $user['class']['location']->outland($action, [10,11,12], ['Глубокие Пещеры', 'index.php?action=deep_caves'], ['Черная Пучина', 'index.php?action=black_abysm']);
if ($action == 'black_abysm') $user['class']['location']->outland($action, [801], ['Логово Каменных Червей', 'index.php?action=stoneworm_lair'], [], true);
// #2
if ($action == 'crypt') $user['class']['location']->outland($action, [13,14,15,16], ['Вернуться на Кладбище', 'index.php?action=graveyard'], ['Мерцающий Провал', 'index.php?action=merc_proval']);
if ($action == 'treant_forest') $user['class']['location']->outland($action, [17,18,19]);
if ($action == 'old_harbor') $user['class']['location']->outland($action, [20,21,22]);
if ($action == 'stonefield') $user['class']['location']->outland($action, [23,24,25]);
if ($action == 'merc_proval') $user['class']['location']->outland($action, [802], ['Родовой Склеп', 'index.php?action=crypt'], [], true);
// #3
if ($action == 'stone_giant_forest') $user['class']['location']->outland($action, [26,27,28,29], [], ['Лунная Поляна', 'index.php?action=moon_meadow']);
if ($action == 'moon_meadow') $user['class']['location']->outland($action, [30,31,32], ['Лес Каменных Гигантов', 'index.php?action=stone_giant_forest']);
if ($action == 'monast') $user['class']['location']->outland($action, [33,34,35], [], ['Подвал Монастыря', 'index.php?action=cellar']);
if ($action == 'cellar') $user['class']['location']->outland($action, [36,37,38,39], ['Монастырь', 'index.php?action=monast'], ['Брешь в стене', 'index.php?action=bresh_v_stene']);
if ($action == 'bresh_v_stene') $user['class']['location']->outland($action, [803], ['Подвал Монастыря', 'index.php?action=cellar'], [], true);
// #4
if ($action == 'abandoned_mines') $user['class']['location']->outland($action, [40,41,42,43]);
if ($action == 'icy_lake') $user['class']['location']->outland($action, [44,45,46]);
if ($action == 'vulture_valley') $user['class']['location']->outland($action, [47,48,49]);
if ($action == 'cathedral_of_the_deep') $user['class']['location']->outland($action, [50,51,52], [], ['Логово Зла', 'index.php?action=den_of_evil']);
if ($action == 'den_of_evil') $user['class']['location']->outland($action, [804], ['Храм Глубин', 'index.php?action=cathedral_of_the_deep'], [], true);
// #5
if ($action == 'alone_mountain') $user['class']['location']->outland($action, [53,54,55,56]);
if ($action == 'dark_valley') $user['class']['location']->outland($action, [57,58,59]);
if ($action == 'forgotten_forest') $user['class']['location']->outland($action, [60,61,62], [], ['Пещера Боли', 'index.php?action=cave_of_pain']);
if ($action == 'cave_of_pain') $user['class']['location']->outland($action, [63,64,65], ['Забытый Лес', 'index.php?action=forgotten_forest'], ['Каменное Логово', 'index.php?action=stony_lair']);
if ($action == 'stony_lair') $user['class']['location']->outland($action, [805], ['Пещера Боли', 'index.php?action=cave_of_pain'], [], true);
// #6
if ($action == 'black_mountain') $user['class']['location']->outland($action, [66,67,68,69]);
if ($action == 'ashiot_river') $user['class']['location']->outland($action, [70,71,72]);
if ($action == 'yellow_forest') $user['class']['location']->outland($action, [73,74,75]);
if ($action == 'old_bastion') $user['class']['location']->outland($action, [76,77,78]);
// #7
if ($action == 'red_desert') $user['class']['location']->outland($action, [79,80,81,82]);
if ($action == 'fire_sea') $user['class']['location']->outland($action, [83,84,85]);
if ($action == 'tinias_ruins') $user['class']['location']->outland($action, [86,87,88]);
if ($action == 'far_island') $user['class']['location']->outland($action, [89,90,91]);
// #8
if ($action == 'dr_sea') $user['class']['location']->outland($action, [92,93,94,95]);
if ($action == 'mavz') $user['class']['location']->outland($action, [96,97,98], ['Вернуться на Кладбище', 'index.php?action=graveyard']);
if ($action == 'black_cave') $user['class']['location']->outland($action, [99,100,101], [], ['Дыра', 'index.php?action=the_hole']);
if ($action == 'the_hole') $user['class']['location']->outland($action, [102,103,104], ['Черная Пещера', 'index.php?action=black_cave']);
// #9
if ($action == '+') $user['class']['location']->outland($action, [105,106,107,108]);
if ($action == '+') $user['class']['location']->outland($action, [109,110,111]);
if ($action == '+') $user['class']['location']->outland($action, [112,113,114]);
if ($action == '+') $user['class']['location']->outland($action, [115,116,117]);
// #10
if ($action == '+') $user['class']['location']->outland($action, [118,119,120,121]);
if ($action == '+') $user['class']['location']->outland($action, [122,123,124]);
if ($action == '+') $user['class']['location']->outland($action, [125,126,127]);
if ($action == '+') $user['class']['location']->outland($action, [128,129,130]);

?>