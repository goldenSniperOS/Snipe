<?php namespace Snipe\Core;


class Field
{
    private $_name = '``',
        $_type = '',
        $_size = '',
        $_unsigned = '',
        $_null = 'NOT NULL',
        $_default = '',
        $_increments = '';

    public function __construct($name, $type, $size = null)
    {
        $this->_name = '`' . $name . '`';
        $this->_size = ((isset($size)) ? '(' . $size . ')' : '');
        $this->_type = strtolower($type);

    }

    public function nulled(){
        $this->_null = 'NULL';
        return $this;
    }

    public function unsigned()
    {
        $this->_unsigned= 'UNSIGNED';
        return $this;
    }

    public function defaultVal($value)
    {
        $this->_default = 'DEFAULT ' . $value;
        return $this;
    }

    public function increments(){
        $this->_default = 'AUTO_INCREMENT';
        return $this;
    }

    public function getline(){
        return $this->_name.' '.$this->_type.$this->_size.' '.$this->_null.' '.$this->_default.' '.$this->_increments;
    }
}