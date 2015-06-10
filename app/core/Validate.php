<?php
	class Validate{
		private $_passed = false,
				$_errors = array(),
				$_db = null;
		public function __construct(){
			$this->_db = DB::getInstance();
		}
		public function check($source, $items = array()){
			foreach ($items as $item => $rules) {
				foreach ($rules as $rule => $rule_value) {
					//echo "{$item} {$rule} must be {$rule_value}<br>";
					$value = $source[$item];
					if($rule === 'required' && empty($value)){
						$this->addError($item,'Este campo es Requerido');
					} else if(!empty($value)){
						switch ($rule) {
							case 'min':
								if(strlen($value) < $rule_value){
									$this->addError($item ,'Este campo debe Tener debe tener un mínimo de '.$rule_value.' caracteres');
								}
								break;
							case 'max':
								if(strlen($value) > $rule_value){
									$this->addError($item ,'Este campo debe Tener debe tener un máximo de '.$rule_value.' caracteres');
								}
								break;
							case 'matches':
								if($value != $source[$rule_value]){
									$this->addError($item ,'Este campo de confirmación no es el mismo');
								}
								break;
							case 'unique':
								$check = $this->_db->get($rule_value[0],[array($rule_value[1],"=",$value)]);
								if($check->count()){
									$this->addError($item ,'Este Campo ya fue registrado, intente con otro');
								}
								break;
							default:
								# code...
								break;
						}
					}
				}
			}
			if(empty(($this->errors()))){
				$this->_passed = true;
			}
			return $this;
		}

		private function addError($item, $message){
			$this->_errors[$item] = $message;
		}

		public function errors(){
			return $this->_errors;
		}

		public function passed(){
			return $this->_passed;
		}
	}
?>