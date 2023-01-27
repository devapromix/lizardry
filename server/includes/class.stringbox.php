<?php

	class StringBox {
		
		protected $values = array();
		protected $str = "";
		protected $num = 0;
		
		public function __construct($str) {
			$this->values = json_decode($str, true);
			$this->str = $str;
			$this->num = count($this->values);
		}
		
		public function add(int $item_ident, int $item_count = 1) {
			if ($this->has($item_ident)) {
				$this->modify($item_ident, $item_count);
			} else {
				$this->values[$this->num]['id'] = strval($item_ident);
				$this->values[$this->num]['count'] = intval($item_count);
			}
			
		}
		
		public function amount(int $item_ident) {
			$result = 0;
			for($i = 0; $i < $this->num; $i++) {
				$item = $this->values[$i];
				if (strval($item['id']) == strval($item_ident)) {
					$result = intval($item['count']);
					break;
				}
			}
			return $result;
		}
		
		public function modify(int $item_ident, int $item_count = 1) {
			for($i = 0; $i < $this->num; $i++) {
				$item = $this->values[$i];
				if (strval($item['id']) == strval($item_ident)) {
					$count = intval($item['count']);
					$count += $item_count;
					if ($count <= 0) {
						unset($this->values[$i]);
						$this->num = count($this->values);
					} else {
						$this->values[$i]['count'] = intval($count);
					}
					$this->values = array_values($this->values);
					break;
				}
			}
		}

		public function has(int $item_ident) {
			$pos = strripos($this->str, '"id":"'.strval($item_ident).'"');
			if ($pos === false) {
				return false;
			} else {
				return true;
			}
		}

		public function get_string() {
			return json_encode($this->values, JSON_UNESCAPED_UNICODE);
		}
		
	}

?>