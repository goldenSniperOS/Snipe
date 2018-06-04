<?php namespace Snipe\Core;


class Validate {

    private $_passed = false,
            $_errors = array();
            
    public function check($source, $items = array()) {
        foreach ($items as $item => $rules) {
            foreach ($rules as $rule => $rule_value) {
                //echo "{$item} {$rule} must be {$rule_value}<br>";
                $value = $source[$item];
                if ($rule === 'required' && empty($value)) {
                    $this->addError($item, 'Este campo es Requerido');
                } else if (!empty($value)) {
                    switch ($rule) {
                        case 'min':
                            if (strlen($value) < $rule_value) {
                                $this->addError($item, 'Este campo debe Tener debe tener un mínimo de ' . $rule_value . ' caracteres');
                            }
                            break;
                        case 'max':
                            if (strlen($value) > $rule_value) {
                                $this->addError($item, 'Este campo debe Tener debe tener un máximo de ' . $rule_value . ' caracteres');
                            }
                            break;
                        case 'matches':
                            if ($value != $source[$rule_value]) {
                                $this->addError($item, 'Este campo de confirmación no es el mismo');
                            }
                            break;
                        case 'unique':
                            $check = DB::getInstance()->table($rule_value[0])->where($rule_value,$value)->count();
                            if ($check > 0) {
                                $this->addError($item, 'Este Campo ya fue registrado, intente con otro');
                            }
                            break;
                        default:
                            # code...
                            break;
                    }
                }
            }
        }
        if (empty(($this->errors()))) {
            $this->_passed = true;
        }else{
            $this->_fields = $source;
        }
        return $this;
    }

    private function addError($item, $message) {
        $this->_errors[$item] = $message;
    }

    public function errors() {
        return $this->_errors;
    }

    public function field($field = null) {
        if(!is_null($field)){
            return $this->_fields[$field];    
        }
        return $this->_fields;
    }

    public function passed() {
        return $this->_passed;
    }
}
