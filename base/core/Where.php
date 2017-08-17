<?php namespace Snipe\Core;

class Where
{
    private $wherewobjects = "",
            $fields = [];

    private function addParam($param){
        if(is_array($param)){
            foreach ($param as $val) {
                $this->fields[] = $val;
            }
        }else{
            $this->fields[] = $param;
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

                        /*if(!strpos($field,'.') === false){
                                $field = explode('.',$field);
                                for ($i=0; $i < count($field); $i++) {
                                        $field[$i] = '`'.$field[$i].'`';
                                }
                                $field = implode('.',$field);
                        }else{
                                $field = '`'.$field.'`';
                        }*/

                        $this->addParam($value);

                        if ($this->wherewobjects == '') {
                                $this->wherewobjects = $field .' ' . $operator . ' ' . '?';
                        } else {
                                $this->wherewobjects .= ' AND ' . $field . ' ' . $operator . ' ' . '?';
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

                        /*if(!strpos($field,'.') === false){
                                $field = explode('.',$field);
                                for ($i=0; $i < count($field); $i++) {
                                        $field[$i] = '`'.$field[$i].'`';
                                }
                                $field = implode('.',$field);
                        }else{
                                $field = '`'.$field.'`';
                        }*/

            $this->addParam($value);

            if ($this->wherewobjects == '') {
                $this->wherewobjects = $field . ' ' . $operator . ' ' . '?';
            } else {
                $this->wherewobjects .= ' OR ' . $field . ' ' . $operator . ' ' . '?';
            }
            return $this;
        }
    }

        public function xorWhere() {
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

                        /*if(!strpos($field,'.') === false){
                                $field = explode('.',$field);
                                for ($i=0; $i < count($field); $i++) {
                                        $field[$i] = '`'.$field[$i].'`';
                                }
                                $field = implode('.',$field);
                        }else{
                                $field = '`'.$field.'`';
                        }*/

            $this->addParam($value);

            if ($this->wherewobjects == '') {
                $this->wherewobjects = $field . ' ' . $operator . ' ' . '?';
            } else {
                $this->wherewobjects .= ' OR ' . $field . ' ' . $operator . ' ' . '?';
            }
            return $this;
        }
    }
}