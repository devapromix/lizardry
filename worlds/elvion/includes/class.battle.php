<?php

	class Battle {
		
		private $user;
		private $statistics;
		private $rounds;
		
		public function __construct($user) {
			
			$this->user = $user;
			$this->$statistics = array();
			$this->rounds = 0;
			
		}
		
		public function get_battle() {
			
			require_once('common/common.php');
			
			if ($this->user['char_life_cur'] <= 0)
				die('{"error":"Вам сначала нужно вернуться к жизни!"}');
			if ($this->user['enemy_life_cur'] <= 0)
				die('{"error":"Враг и так мертв!"}');
			
			$r = '';
			
			$this->rounds = 1;
			$this->statistics['char_damages'] = 0;
			$this->statistics['enemy_damages'] = 0;
			$this->statistics['char_dodges'] = 0;
			$this->statistics['char_parries'] = 0;
			$this->statistics['char_hits'] = 0;
			$this->statistics['enemy_hits'] = 0;
			$this->statistics['char_misses'] = 0;
			$this->statistics['enemy_misses'] = 0;
			
			$c = rand(0, 2);
			$r .= 'Вы вступаете в схватку с '.$this->user['enemy_name'].'.#';
			if (($c == 0) && ($this->user['enemy_boss'] == 0))
				$r .= 'Вы первыми бросаетесь в атаку!#';
			else
				$r .= $this->user['enemy_name'].' первым бросается в атаку!#';			
			
			while(true) {

				$r .= '--- '.strval($this->rounds).'-й раунд: ---#';
				if ($c == 0) {
					$r .= $this->player_battle_round();
					$r .= $this->monster_battle_round();
				} else {
					$r .= $this->monster_battle_round();
					$r .= $this->player_battle_round();
				}

				if (($this->user['char_life_cur'] < round($this->user['char_life_max'] / 10))
					&&($this->user['char_life_cur'] > 0)&&($this->user['enemy_life_cur'] > 0)) {
					$r .= 'Понимая, что результат боя складывается не в вашу пользу, вы пытаетесь уклониться от боя...#';
					if (rand(1, 100) <= (($this->user['skill_run'] * 5) + 25)) {
						$r .= 'Вы отступаете!#';
						break;
					} else
						$r .= 'Неудачно! '.$this->user['enemy_name'].' снова бросается в атаку! Поединок продолжается...#';
				}
				
				if ($this->user['char_life_cur'] <= 0) {
					$this->user['char_life_cur'] = 0;
					$this->user['char_mana_cur'] = 0;
					$this->user['stat_deads']++;
					$this->user['char_exp'] -= round($this->user['char_exp'] / 5);
					$this->user['char_gold'] -= round($this->user['char_gold'] / 7);
					$r .= '--------------------------------------------------------#';
					$r .= 'Вы потеряли пятую часть опыта и седьмую часть золота.#';
					add_event(3, $this->user['char_name'], 1, $this->user['char_gender'], '', $this->user['char_region_location_name']);
					break;
				}

				if ($this->user['enemy_life_cur'] <= 0) {
					$this->user['enemy_life_cur'] = 0;
					$this->user['stat_kills']++;
					$r .= '--------------------------------------------------------#';
					gen_loot();
					if ($this->user['enemy_boss'] > 0) {
						kill_boss($this->user['char_region']);
						$r .= 'Вы победили босса! Вы добыли ценный трофей!#';
					} else
						gen_random_place();
					$gold = get_value($this->user['enemy_gold']); 
					if ($gold > 0)
						$gold += ($this->user['char_region_level'] * ($this->user['skill_gold'] * rand(3, 5)));
					$this->user['char_gold'] += $gold;
					$exp = get_value($this->user['enemy_exp']);
					$this->user['char_exp'] += $exp;
					if ($exp > 0)
						$r .= 'Вы получаете '.$exp.' опыта.#';
					if ($gold <= 0)
						$r .= 'Вы роетесь в останках '.$this->user['enemy_name'].', но не находите золота.#';
					else
						$r .= 'Вы обшариваете останки '.$this->user['enemy_name'].' и подбираете '.$gold.' золота.#';
					if ($this->user['loot_slot_1'] > 0) {
						$r .= 'Ваше внимание привлекает '.$this->user['loot_slot_1_name'].'.#';
					} else if ($this->user['current_random_place'] > 0) {
						$r .= 'Ваше внимание привлекает загадочная локация, которую вы только что обнаружили...#';
					}
					if ($this->user['enemy_champion'] == 1)
						add_event(4, $this->user['char_name'], 1, $this->user['char_gender'], $this->user['enemy_name'], $this->user['char_region_location_name']);
					break;
				}
				$this->rounds++;
				$c = rand(0, 2);
				
			}

			$r .= '--------------------------------------------------------#';
			$r .= "Всего раундов: ".$this->rounds."#";
			$r .= "Сумма урона: ".$this->statistics['char_damages']." (".$this->user['char_name'].") / ".$this->statistics['enemy_damages']." (".$this->user['enemy_name'].")#";
			$r .= "Попадания: ".$this->statistics['char_hits']." (".$this->user['char_name'].") / ".$this->statistics['enemy_hits']." (".$this->user['enemy_name'].")#";
			$r .= "Промахи: ".$this->statistics['char_misses']." (".$this->user['char_name'].") / ".$this->statistics['enemy_misses']." (".$this->user['enemy_name'].")#";
			$r .= "Уклонения: ".$this->statistics['char_dodges']." Парирования: ".$this->statistics['char_parries']."#";
	
			if (ch_level_exp()) {
				$r .= '--------------------------------------------------------#';
				$r .= 'Вы стали намного опытнее для текущего уровня и поэтому получаете меньше опыта и золота! Нужно посетить Квартал Гильдий и повысить уровень!#';
			}
			
			$this->user['battlelog'] = $r;
			
			return $this->user;
			
		}
		
		public function player_battle_round() {
			
			$r = '';
			
			if (($this->user['char_life_cur'] > 0)&&($this->user['enemy_life_cur'] > 0)) {
				if (rand(1, $this->user['enemy_armor']) <= rand(1, $this->user['char_armor'])) {
					$d = rand($this->user['char_damage_min'], $this->user['char_damage_max']);
					$d = get_real_damage($d, $this->user['enemy_armor'], $this->user['char_level'], $this->user['enemy_level']);
					$this->statistics['char_hits']++;
					if ($d <= 0) {
						$r .= 'Вы не можете пробить защиту '.$this->user['enemy_name'].'.#';
					} else {
						if (rand(1, 100) <= $this->user['skill_bewil']) {
							$d = get_bewildering_strike_damage($d);
							$this->statistics['char_damages'] += $d;
							$this->user['enemy_life_cur'] -= $d;
							if ($this->user['enemy_life_cur'] > 0) {
								$r .= 'Вы наносите ошеломляющий удар и раните '.$this->user['enemy_name'].' на '.$d.' HP! '.$this->user['enemy_name'].' в смятении.#';
								$r .= char_battle_round();
							} else {
								$r .= 'Вы наносите ошеломляющий удар на '.$d.' HP и убиваете '.$this->user['enemy_name'].'.#';
							}
							return $r;
						} else if (rand(1, 100) <= 5) {
							$d = get_glancing_blow_damage($d);
							$this->statistics['char_damages'] += $d;
							$this->user['enemy_life_cur'] -= $d;
							if ($this->user['enemy_life_cur'] > 0) {
								$r .= 'Вы наносите скользящий удар и раните '.$this->user['enemy_name'].' на '.$d.' HP.#';
							} else {
								$r .= 'Вы наносите скользящий удар на '.$d.' HP и убиваете '.$this->user['enemy_name'].'.#';
							}
							return $r;
						} else if (rand(1, 100) <= 1) {
							$d += rand($this->user['char_damage_max'], $this->user['char_damage_max'] * 2);
							$this->statistics['char_damages'] += $d;
							$this->user['enemy_life_cur'] -= $d;
							if ($this->user['enemy_life_cur'] > 0) {
								$r .= 'Вы наносите критический удар и раните '.$this->user['enemy_name'].' на '.$d.' HP!#';
							} else {
								$r .= 'Вы наносите критический удар на '.$d.' HP и убиваете '.$this->user['enemy_name'].'!#';
							}
						} else {
							$crushing_blow_damage = get_crushing_blow_damage($d);
							if ((rand(1, 100) <= 0)&&($crushing_blow_damage >= $this->user['enemy_life_cur'])) {
								$this->statistics['char_damages'] += $crushing_blow_damage;
								$this->user['enemy_life_cur'] = 0;
								$r .= 'Вы наносите сокрушающий удар на '.$crushing_blow_damage.' HP и убиваете '.$this->user['enemy_name'].'!#';
								return $r;
							}
							$this->statistics['char_damages'] += $d;
							$this->user['enemy_life_cur'] -= $d;
							if ($this->user['enemy_life_cur'] > 0) {
								$r .= 'Вы раните '.$this->user['enemy_name'].' на '.$d.' HP.#';
							} else {
								$r .= 'Вы наносите удар на '.$d.' HP и убиваете '.$this->user['enemy_name'].'.#';
							}
						}
					}
				} else {
					$r .= 'Вы пытаетесь атаковать, но промахиваетесь по '.$this->user['enemy_name'].'.#';
					$this->statistics['char_misses']++;
				}
			}
			
			return $r;
			
		}
		
		public function monster_battle_round() {
			
			$r = '';
			
			if (($this->user['enemy_life_cur'] > 0) && ($this->user['char_life_cur'] > 0)) {
				if (rand(1, $this->user['char_armor'] + 1) <= rand(1, $this->user['enemy_armor'])) {
					if (rand(1, 100) > $this->user['skill_dodge']) {
						if (rand(1, 100) > $this->user['skill_parry']) {
							if (rand(1, 100) > 10) { // todo: Расовый навык уклонения у людей, ящеров и эльфов
								if (rand(1, 3) > 1)
									$d = rand($this->user['enemy_damage_min'], $this->user['enemy_damage_max']);
								else
									$d = $this->user['enemy_damage_min'];
								$d = get_real_damage($d, $this->user['char_armor'], $this->user['enemy_level'], $this->user['char_level']);
								$this->statistics['enemy_hits']++;
								if ($d <= 0) {
									$r .= $this->user['enemy_name'].' атакует, но не может пробить вашу защиту.#';
									$d = 0;
								} else {
									if (rand(1, 100) <= 15) {
										$d = get_glancing_blow_damage($d);
										$this->statistics['enemy_damages'] += $d;
										$this->user['char_life_cur'] -= $d;
										if ($this->user['char_life_cur'] > 0) {
											$r .= $this->user['enemy_name'].' наносит скользящий удар и ранит вас на '.$d.' HP.#';
										} else {
											$r .= $this->user['enemy_name'].' наносит скользящий удар на '.$d.' HP и убивает вас.#';
										}
										return $r;
									}
									$this->statistics['enemy_damages'] += $d;
									$this->user['char_life_cur'] -= $d;
									if ($this->user['char_life_cur'] > 0) {
										$r .= $this->user['enemy_name'].' ранит вас на '.$d.' HP.#';
									} else {
										$r .= $this->user['enemy_name'].' наносит удар на '.$d.' HP и убивает вас.#';
									}
								}
							} else {
								$r .= $this->user['enemy_name'].' пытается атаковать, но ваш расовый навык позволяет уклониться от атаки!#';
								$this->statistics['char_dodges']++;
							}
						} else {
							$r .= 'Вы парируете атаку '.$this->user['enemy_name'].'.#';
							$this->statistics['char_parries']++;
						}
					} else {
						$r .= 'Вы ловко уклоняетесь от атаки '.$this->user['enemy_name'].'.#';
						$this->statistics['char_dodges']++;
					}
				} else {
					$r .= $this->user['enemy_name'].' промахивается по вам.#';
					$this->statistics['enemy_misses']++;
				}
			}
			
			return $r;
			
		}
		
	}

?>