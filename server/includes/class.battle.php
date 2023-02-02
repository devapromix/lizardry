<?php

	class Battle {
		
		private $statistics;
		private $rounds;
		private $poisoned;
		
		public function __construct() {
			
			$this->$statistics = array();
			$this->rounds = 0;
			$this->poisoned = 0;
			
		}
		
		public function start_battle() {
			global $user;

			if ($user['char_life_cur'] <= 0)
				die('{"error":"Вам сначала нужно вернуться к жизни!"}');
			if ($user['enemy_life_cur'] <= 0)
				die('{"error":"Враг и так мертв!"}');
			
			$r = '';
			
			$this->rounds = 1;
			$this->poisoned = 0;
			$this->statistics['char_damages'] = 0;
			$this->statistics['enemy_damages'] = 0;
			$this->statistics['char_dodges'] = 0;
			$this->statistics['char_parries'] = 0;
			$this->statistics['char_hits'] = 0;
			$this->statistics['enemy_hits'] = 0;
			$this->statistics['char_misses'] = 0;
			$this->statistics['enemy_misses'] = 0;
			
			$c = rand(0, 2);
			$r .= 'Вы вступаете в схватку с '.$user['enemy_name'].'.#';
			if (($c == 0) && ($user['enemy_boss'] == 0))
				$r .= 'Вы первыми бросаетесь в атаку!#';
			else
				$r .= $user['enemy_name'].' первым бросается в атаку!#';			
			
			while(true) {

				$r .= '--- '.strval($this->rounds).'-й раунд: ---#';
				
				if (($user['class']['effect']->has(Magic::PLAYER_EFFECT_DESTRUCT))&&(rand(1, 3) == 1)) {
					$user['enemy_armor']--;
					$r .= 'Броня '.$user['enemy_name'].' разрушается.#';
				}
				
				if ($c == 0) {
					$r .= $this->player_battle_round();
					$r .= $this->enemy_battle_round();
				} else {
					$r .= $this->enemy_battle_round();
					$r .= $this->player_battle_round();
				}

				if (($user['char_life_cur'] < round($user['char_life_max'] / 10))
					&&($user['char_life_cur'] > 0)&&($user['enemy_life_cur'] > 0)) {
					$r .= 'Понимая, что результат боя складывается не в вашу пользу, вы пытаетесь уклониться от боя...#';
					if (rand(1, 100) <= (($user['skill_run'] * 5) + 25)) {
						$r .= 'Вы отступаете!#';
						break;
					} else
						$r .= 'Неудачно! '.$user['enemy_name'].' снова бросается в атаку! Поединок продолжается...#';
				}
				
				if ($user['char_life_cur'] <= 0) {
					$user['char_life_cur'] = 0;
					$user['char_mana_cur'] = 0;
					$user['stat_deads']++;
					$user['char_exp'] -= round($user['char_exp'] / 5);
					$user['char_gold'] -= round($user['char_gold'] / 7);
					$r .= $this->str_line();
					$r .= 'Вы потеряли пятую часть опыта и седьмую часть золота.#';
					Event::add(3, $user['char_name'], 1, $user['char_gender'], '', $user['char_region_location_name']);
					break;
				}

				if ($user['enemy_life_cur'] <= 0) {
					$user['enemy_life_cur'] = 0;
					$user['stat_kills']++;
					$r .= $this->str_line();
					$user['class']['item']->gen_loot();
					if ($user['enemy_boss'] > 0) {
						Boss::kill($user['char_region']);
						$r .= 'Вы победили босса! Вы добыли ценный трофей!#';
					} else
						$user['class']['location']->gen_random_place();
					$gold = $this->get_value($user['enemy_gold']); 
					if ($gold > 0)
						$gold += ($user['char_region_level'] * ($user['skill_gold'] * rand(3, 5)));
					$user['char_gold'] += $gold;
					$exp = $this->get_value($user['enemy_exp']);
					$user['char_exp'] += $exp;
					if ($exp > 0)
						$r .= 'Вы получаете '.$exp.' опыта.#';
					if ($gold <= 0)
						$r .= 'Вы роетесь в останках '.$user['enemy_name'].', но не находите золота.#';
					else
						$r .= 'Вы обшариваете останки '.$user['enemy_name'].' и подбираете '.$gold.' золота.#';
					if ($user['loot_slot_1'] > 0) {
						$r .= 'Ваше внимание привлекает '.$user['loot_slot_1_name'].'.#';
					} else if ($user['current_random_place'] > 0) {
						$r .= 'Ваше внимание привлекает загадочная локация, которую вы только что обнаружили...#';
					}
					if ($user['enemy_champion'] == 1)
						Event::add(4, $user['char_name'], 1, $user['char_gender'], $user['enemy_name'], $user['char_region_location_name']);
					break;
				}
				$this->rounds++;
				$c = rand(0, 2);
				
			}

			$r .= $this->str_line();
			$r .= "Всего раундов: ".$this->rounds."#";
			$r .= "Сумма урона: ".$this->statistics['char_damages']." (".$user['char_name'].") / ".$this->statistics['enemy_damages']." (".$user['enemy_name'].")#";
			$r .= "Попадания: ".$this->statistics['char_hits']." (".$user['char_name'].") / ".$this->statistics['enemy_hits']." (".$user['enemy_name'].")#";
			$r .= "Промахи: ".$this->statistics['char_misses']." (".$user['char_name'].") / ".$this->statistics['enemy_misses']." (".$user['enemy_name'].")#";
			$r .= "Уклонения: ".$this->statistics['char_dodges']." Парирования: ".$this->statistics['char_parries']."#";
	
			if ($this->ch_level_exp()) {
				$r .= $this->str_line();
				$r .= 'Вы стали намного опытнее для текущего уровня и поэтому получаете меньше опыта и золота! Нужно посетить Квартал Гильдий и повысить уровень!#';
			}
			
			$this->poisoned = 0;
			$user['class']['effect']->clear();
			$user['battlelog'] = $r;

		}
		
		private function player_battle_round() {
			global $user;
			
			$r = '';
			
			if (($user['char_life_cur'] > 0) && ($user['enemy_life_cur'] > 0)) {
				if ($this->poisoned > 0)
					$r .= $this->effect_poison();
				if ($user['class']['effect']->has(Magic::PLAYER_EFFECT_REGEN))
					$r .= $this->effect_regen();
				if (rand(1, $user['enemy_armor']) <= rand(1, $user['char_armor'])) {
					if ($user['class']['effect']->has(Magic::PLAYER_EFFECT_BLESS))
						$d = $user['char_damage_max'];
					else
						$d = rand($user['char_damage_min'], $user['char_damage_max']);
					$d = $this->get_real_damage($d, $user['enemy_armor'], $user['char_level'], $user['enemy_level']);
					$this->statistics['char_hits']++;
					if ($d <= 0) {
						$r .= 'Вы не можете пробить защиту '.$user['enemy_name'].'.#';
					} else {
						if ($user['class']['effect']->has(Magic::PLAYER_EFFECT_LEECH))
							if ((rand(1, 2) == 1) && ($user['char_life_cur'] < $user['char_life_max']) && ($user['enemy_life_cur'] > 0))
								$r .= $this->effect_leech();
						if (rand(1, 100) <= $user['skill_bewil']) {
							$d = $this->get_bewildering_strike_damage($d);
							$this->statistics['char_damages'] += $d;
							$user['enemy_life_cur'] -= $d;
							if ($user['enemy_life_cur'] > 0) {
								$r .= 'Вы наносите ошеломляющий удар и раните '.$user['enemy_name'].' на '.$d.' HP! '.$user['enemy_name'].' в смятении.#';
								$r .= $this->player_battle_round();
							} else {
								$r .= 'Вы наносите ошеломляющий удар на '.$d.' HP и убиваете '.$user['enemy_name'].'.#';
							}
							return $r;
						} else if (rand(1, 100) <= 5) {
							$d = $this->get_glancing_blow_damage($d);
							$this->statistics['char_damages'] += $d;
							$user['enemy_life_cur'] -= $d;
							if ($user['enemy_life_cur'] > 0) {
								$r .= 'Вы наносите скользящий удар и раните '.$user['enemy_name'].' на '.$d.' HP.#';
							} else {
								$r .= 'Вы наносите скользящий удар на '.$d.' HP и убиваете '.$user['enemy_name'].'.#';
							}
							return $r;
						} else if (rand(1, 100) <= 1) {
							$d += rand($user['char_damage_max'], $user['char_damage_max'] * 2);
							$this->statistics['char_damages'] += $d;
							$user['enemy_life_cur'] -= $d;
							if ($user['enemy_life_cur'] > 0) {
								$r .= 'Вы наносите критический удар и раните '.$user['enemy_name'].' на '.$d.' HP!#';
							} else {
								$r .= 'Вы наносите критический удар на '.$d.' HP и убиваете '.$user['enemy_name'].'!#';
							}
						} else {
							$crushing_blow_damage = $this->get_crushing_blow_damage($d);
							if ((rand(1, 100) <= 0)&&($crushing_blow_damage >= $user['enemy_life_cur'])) {
								$this->statistics['char_damages'] += $crushing_blow_damage;
								$user['enemy_life_cur'] = 0;
								$r .= 'Вы наносите сокрушающий удар на '.$crushing_blow_damage.' HP и убиваете '.$user['enemy_name'].'!#';
								return $r;
							}
							$this->statistics['char_damages'] += $d;
							$user['enemy_life_cur'] -= $d;
							if ($user['enemy_life_cur'] > 0) {
								$r .= 'Вы раните '.$user['enemy_name'].' на '.$d.' HP.#';
							} else {
								$r .= 'Вы наносите удар на '.$d.' HP и убиваете '.$user['enemy_name'].'.#';
							}
						}
					}
				} else {
					$r .= 'Вы пытаетесь атаковать, но промахиваетесь по '.$user['enemy_name'].'.#';
					$this->statistics['char_misses']++;
				}
			}
			
			return $r;
			
		}
		
		private function enemy_battle_round() {
			global $user;
			
			$r = '';
			
			if (($user['enemy_life_cur'] > 0) && ($user['char_life_cur'] > 0)) {
				if ($user['class']['effect']->has(Magic::PLAYER_EFFECT_DECAY) && (rand(1, 4) == 1))
					$r .= $this->enemy_effect_decay();
				if (rand(1, $user['char_armor'] + 1) <= rand(1, $user['enemy_armor'])) {
					if (rand(1, 100) > $user['skill_dodge']) {
						if (rand(1, 100) > $user['skill_parry']) {
							if (rand(1, 100) > 10) { // todo: Расовый навык уклонения у людей, ящеров и эльфов
								if (rand(1, 3) > 1)
									$d = rand($user['enemy_damage_min'], $user['enemy_damage_max']);
								else
									$d = $user['enemy_damage_min'];
								$d = $this->get_real_damage($d, $user['char_armor'], $user['enemy_level'], $user['char_level']);
								$this->statistics['enemy_hits']++;
								if ($d <= 0) {
									$r .= $user['enemy_name'].' атакует, но не может пробить вашу защиту.#';
									$d = 0;
								} else {
									if (rand(1, 100) <= 15) {
										$d = $this->get_glancing_blow_damage($d);
										$this->statistics['enemy_damages'] += $d;
										$user['char_life_cur'] -= $d;
										if ($user['char_life_cur'] > 0) {
											$r .= $user['enemy_name'].' наносит скользящий удар и ранит вас на '.$d.' HP.#';
										} else {
											$r .= $user['enemy_name'].' наносит скользящий удар на '.$d.' HP и убивает вас.#';
										}
										return $r;
									}
									if (($user['class']['effect']->has(Magic::PLAYER_EFFECT_REFLECT))&&(rand(1, 4) == 1)) {
										$reflect_damage = round($d / rand(2, 5));
										if ($$reflect_damage < 1) $reflect_damage = 1;
										$d -= $reflect_damage;
										if ($d < 1) $d = 1;
										$this->statistics['enemy_damages'] += $d;
										$user['char_life_cur'] -= $d;
										if ($user['char_life_cur'] > 0) {
											$r .= 'Враг атакует вас, но часть урона ('.strval($reflect_damage).') отражается и '.$user['enemy_name'].' ранит вас на '.$d.' HP.#';
										} else {
											$r .= 'Враг атакует вас, но часть урона ('.strval($reflect_damage).') отражается. '.$user['enemy_name'].' наносит урон на '.$d.' HP и убивает вас.#';
										}
										$this->statistics['char_damages'] += $reflect_damage;
										$user['enemy_life_cur'] -= $reflect_damage;									
										if ($user['enemy_life_cur'] > 0) {
											$r .= $user['enemy_name'].' получает отраженный урон '.strval($reflect_damage).' HP.#';
										} else {
											$r .= $user['enemy_name'].' получает отраженный урон '.strval($reflect_damage).' HP и погибает.#';
										}
										return $r;
									}
									$this->statistics['enemy_damages'] += $d;
									$user['char_life_cur'] -= $d;
									if ($user['char_life_cur'] > 0) {
										$r .= $user['enemy_name'].' ранит вас на '.$d.' HP.#';
									} else {
										$r .= $user['enemy_name'].' наносит удар на '.$d.' HP и убивает вас.#';
									}
									if ((rand(1, 4) == 1) && ($user['enemy_can_poison'] > 0) && ($user['char_life_cur'] > 0) && ($this->poisoned == 0) && !$user['class']['effect']->has(Magic::PLAYER_EFFECT_IMMUN)) {
										$r .= $this->poisoning();
										return $r;
									}
								}
							} else {
								$r .= $user['enemy_name'].' пытается атаковать, но ваш расовый навык позволяет уклониться от атаки!#';
								$this->statistics['char_dodges']++;
							}
						} else {
							$r .= 'Вы парируете атаку '.$user['enemy_name'].'.#';
							$this->statistics['char_parries']++;
						}
					} else {
						$r .= 'Вы ловко уклоняетесь от атаки '.$user['enemy_name'].'.#';
						$this->statistics['char_dodges']++;
					}
				} else {
					$r .= $user['enemy_name'].' промахивается по вам.#';
					$this->statistics['enemy_misses']++;
				}
			}
			
			return $r;
			
		}

		private function str_line() {
			return '--------------------------------------------------------#';
		}

		private function get_real_damage(int $atk_damage, int $def_armor, int $atk_level, int $def_level) {
			return $atk_damage - round($atk_damage * $def_armor / 100);
		}

		private function get_glancing_blow_damage(int $damage){
			$r = round($damage / rand(2, 3));
			if ($r < 1)
				$r = 1;
			return $r;
		}

		private function get_crushing_blow_damage(int $damage) {
			return $damage * rand(3, 5);
		}

		private function get_bewildering_strike_damage(int $damage) {
			return rand(round($damage * 0.75), round($damage * 1.2));
		}		
		
		private function get_value(int $value) {
			global $user;

			if ($user['enemy_level'] < $user['char_level'] - 1) {
				$v = $user['char_level'] - $user['enemy_level'];
				$r = round($value / $v);
				if ($r < 1)
					$r = 1;
			} else
				$r = $value;

			if (($r > 0) && ($this->ch_level_exp())) {
				$r = rand(round($r / 5), round($r / 2));
				if ($r < 1)
					$r = 1;
			}

			return $r;
		}

		private function ch_level_exp() {
			global $user;
			$r = false;
			if ($user['char_exp'] > $user['class']['player']->get_level_exp($user['char_level'] + 1))
				$r = true;
			return $r;
		}
		
		private function get_current_region_value() {
			global $user;
			$v = round($user['char_region_level'] / 2);
			if ($v < 1)
				$v = 1;
			return $v;
		}
		
		private function effect_regen() {
			global $user;
			$r = '';
			if ($user['char_life_cur'] < $user['char_life_max']) {
				$hp = rand(1, $this->get_current_region_value());
				$user['char_life_cur'] += $hp;
				$r .= 'Вы восстановили '.$hp.' HP.#';
				if ($user['char_life_cur'] > $user['char_life_max'])
					$user['char_life_cur'] = $user['char_life_max'];
			}
			return $r;
		}

		private function effect_leech() {
			global $user;
			$r = '';
			$hp = rand($this->get_current_region_value(), $user['char_region_level']);
			if (intval($user['enemy_life_cur'] - $hp) > 1) {
				$user['enemy_life_cur'] -= $hp;
				if ($user['enemy_life_cur'] <= 0)
					$user['enemy_life_cur'] = 1;
				$user['char_life_cur'] += $hp;
				if ($user['char_life_cur'] > $user['char_life_max'])
					$user['char_life_cur'] = $user['char_life_max'];
				$r .= 'Вы украли '.$hp.' HP у '.$user['enemy_name'].'.#';
			}
			return $r;
		}
		
		private function poisoning() {
			$this->poisoned = rand($this->get_current_region_value(), $user['char_region_level']) + 2;
			return 'Вы отравлены!#';
		}
		
		private function effect_poison() {
			global $user;
			$r = '';
			if (($user['char_life_cur'] - $this->poisoned) > 0) {
				$user['char_life_cur'] -= $this->poisoned;
				$r .= 'Яд забирает '.$this->poisoned.' HP.#';
				$this->poisoned--;
				if ($this->poisoned <= 0) {
					$this->poisoned = 0;
					$r .= 'Действие яда закончилось!#';
				}
			}
			return $r;
		}
		
		private function enemy_effect_decay() {
			global $user;
			$r = '';
			$hp = rand($this->get_current_region_value(), $user['char_region_level']) + 2;
			if (($user['enemy_life_cur'] - $hp) > 0) {
				$user['enemy_life_cur'] -= $hp;
				$r .= $user['enemy_name'].' теряет '.$hp.' HP.#';
			}
			return $r;
		}

	}

?>