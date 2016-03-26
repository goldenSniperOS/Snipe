<?php
class Where
{
	private $wherewobjects = "",
            $fields = [];

    private function addParam($param){
        if(is_array($param)){
            foreach ($param as $val) {
                $this->_fields[] = $val;
            }
        }else{
            $this->_fields[] = $param;    
        }        
    }

	public function where() {
        if (func_num_args() > 0){
            if (func_num_args() == 2) {
                $field = func_get_arg(0);
                $operator = '=';
                $value = func_get_arg(1);
            } else {
                $field = func_get_arg(0);
                $operator = func_get_arg(1);
                $value = func_get_arg(2);
            }    
            //$value = (is_numeric($value)) ? $value : '"' . $value . '"';
            $this->addParam($value);
            if ($this->wherewobjects == '') {
                $this->wherewobjects = '`'.$field . '` ' . $operator . ' ' . '?';
            } else {
                $this->wherewobjects .= ' AND `' . $field . '` ' . $operator . ' ' . '?';
            }
            return $this;
        }
    }

    public function getParams(){
        return $this->fields;
    }

    public function getQuery(){
    	return '('.$this->wherewobjects.')';
    }

    public function orWhere() {
        if (func_num_args() > 0){
            if (func_num_args() == 2) {
                $field = func_get_arg(0);
                $operator = '=';
                $value = func_get_arg(1);
            } else {
                $field = func_get_arg(0);
                $operator = func_get_arg(1);
                $value = func_get_arg(2);
            }

            //$value = (is_numeric($value)) ? $value : '"' . $value . '"';
            $this->addParam($value);
            if ($this->wherewobjects == '') {
                $this->wherewobjects = '`'.$field . '` ' . $operator . ' ' . '?';
            } else {
                $this->wherewobjects .= ' OR ' . $field . ' ' . $operator . ' ' . '?';
            }
            return $this;
        }
    }
}