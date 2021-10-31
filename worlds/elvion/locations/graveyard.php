<?php

if ($action == 'graveyard') {

	$user['title'] = 'Городское Кладбище';
	if ($user['char_life_cur'] > 0) {
		
		switch ($user['char_region']) {
			case 1:
				$user['description'] = 'Вы пришли на городское кладбище Вильмара. Кругом одни могилы и склепы. Эта земля принадлежит мертвым. Здесь всегда царит тишина и спокойствие. В отдалении виднеются родовые склепы.';
				break;
			case 2:
				$user['description'] = 'Вы пришли на старое кладбище Морхольда. Здесь тихо и спокойно. Могилы расположены ровными рядами. За некоторыми ухаживают, некоторые заброшены. В самом отдаленном уголке Кладбища находится Старый Склеп. Металлическая решетка сорвана и валяется на земле у входа.';
				break;
			case 3:
				$user['description'] = 'Вы пришли на кладбище. Ночь. Полная луна. Мертвая тишина. Вы на едине с каменными плитами и душами предков. Здесь так спокойно. Но лучше поскорее убраться отсюда и не тревожить мир мертвых.';
				break;
			case 4:
				$user['description'] = 'Старое кладбище возле города. Миновав полуразрушенный каменный забор, Вы останавливаетесь возле склепа, полностью обвитого плющем. Здесь тихо и спокойно и можно надолго остаться, чтобы собраться с мыслями.';
				break;
			case 5:
				$user['description'] = 'Вы посетили старое кладбище возле городских стен. Здесь царит тишина и спокойствие. Дует легкий тревожный северный ветер. Вы стоите в раздумии, что же делать дальше.';
				break;
			case 6:
				$user['description'] = '';
				break;
			case 7:
				$user['description'] = '';
				break;
			case 8:
				$user['description'] = '';
				break;
			case 9:
				$user['description'] = '';
				break;
			case 10:
				$user['description'] = '';
				break;
		}
		
	} else {
		$user['description'] = 'Вы в виде бестелесного создания бродите в мире теней. У одной из могил вы видите красивую девушку с большими крыльями за спиной. Она говорит, что может воскресить и вернуть в мир живых...';
	}
	
	$user['links'] = array();
	if ($user['char_life_cur'] > 0) {
		go_to_the_gate('Покинуть Кладбище');
		switch ($user['char_region']) {
			case 2:
				addlink('Осмотреть Склеп', 'index.php?action=crypt', 1);
				break;
		}
	} else addlink('Вернуться к жизни', 'index.php?action=graveyard&do=revive_in_graveyard');
	
	if ($do == 'revive_in_graveyard') {
		$user['char_life_cur'] = 1;
		$user['char_mana_cur'] = 0;
		update_user_table("char_life_cur=".$user['char_life_cur'].",char_mana_cur=".$user['char_mana_cur']);
		$user['description'] = 'Вы открываете глаза и понимаете, что вернулись в мир живых. На тело наваливаетеся сильная усталость, кружится голова. Все происходящее кажется сном. Нужно отдохнуть и набраться сил.';
		$user['links'] = array();
		go_to_the_gate('Покинуть Кладбище');
		switch ($user['char_region']) {
			case 2:
				addlink('Осмотреть Склеп', 'index.php?action=crypt', 1);
				break;
		}
	}
	
	$res = json_encode($user, JSON_UNESCAPED_UNICODE);	
	
}

?>