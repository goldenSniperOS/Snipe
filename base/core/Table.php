<?php namespace Snipe\Core;

class Table
{
    private $_fields = [],
            $_primary = '';

    public function increments($name){
        $index = count($this->_fields);
        $this->_fields[] = new Field($name,'int');
        $this->primary($name);
        return $this->_fields[$index];
    }

    public function string($name,$size = null){
        $index = count($this->_fields);
        if(is_null($size)){$size = 100;}
        $this->_fields[] = new Field($name,'varchar',$size);
        return $this->_fields[$index];
    }

    public function getFields(){
        foreach($this->_fields as $row){
            $rows[] = $row->getline();
        }
        return (isset($rows)?$rows:false);
    }

    public function primary($key){
        $this->_primary= "PRIMARY KEY (`".$key."`)";
        return $this;
    }

    public function getPrimary(){
        return $this->_primary;
    }
}