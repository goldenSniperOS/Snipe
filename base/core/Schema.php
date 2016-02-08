<?php
class Schema
{
    private $_pdo,
        $_query,
        $_error = false,
        $_results = null,
        $_count = -1;
        

    private function __construct($database = null) {
        try {
            if(is_null($database)){
                $database = Config::get('mysql/database');
            }
            $this->_pdo = new PDO(
                    'mysql:host=' . Config::get('mysql/host') .
                    ';dbname=' .$database, Config::get('mysql/username'), Config::get('mysql/password'), array(PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES  \'UTF8\''));
            if (Config::get('database_errors')) {
                $this->_pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            }
            //echo 'Connected';
        } catch (PDOException $e) {
            die($e->getMessage());
        }
    }

    public function query($sql) {
        $this->_error = false;
        try {
            if ($this->_query = $this->_pdo->prepare($sql)) {
                if ($this->_query->execute()) {
                    $this->_error = false;
                    $this->_count = $this->_query->rowCount();
                    if ($this->_query->columnCount()) {
                        $this->_results = $this->_query->fetchAll(PDO::FETCH_OBJ);
                    }
                } else {
                    $this->_error = true;
                }
            }
        } catch (PDOException $e) {
            die($e->getMessage());
        }
        return $this;
    }

    public static function exist($database = null,$table = null){
        if(is_null($database)){
            $database = Config::get('mysql/database');
        }
        if(is_null($table)){
            $sql = 'SELECT SCHEMA_NAME FROM INFORMATION_SCHEMA.SCHEMATA WHERE SCHEMA_NAME = \''.$database.'\'';

        }else{
            $sql = 'SELECT * FROM information_schema.tables WHERE table_schema = \''.$database.'\' AND table_name = \''.$table.'\' LIMIT 1';
        }

        $object = new self('INFORMATION_SCHEMA');
        if(!$object->query($sql)->_error){
            if($object->count() > 0){

                return true;
            }
        }
        return false;
    }

    public function count (){
        return $this->_count;
    }
    public function results (){
        return $this->_results;
    }

   	public static function create($name,$function){
        $sql = 'CREATE TABLE `'.$name.'` (';
        $table = new Table();
        call_user_func_array($function,[$table]);
        $primary = empty($table->getPrimary())?'':','.$table->getPrimary();
        $sql = $sql.implode(',',$table->getFields()).$primary.') ENGINE=InnoDB DEFAULT CHARSET=utf8';
        $object = new self;
        return !($object->query($sql)->_error);
	}

    public static function createDatabase(){
        try {
            $sql = "CREATE DATABASE `".Config::get('mysql/database')."`";
            $pdo = new PDO('mysql:host=' . Config::get('mysql/host'), Config::get('mysql/username'), Config::get('mysql/password'), array(PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES  \'UTF8\''));
            if($query = $pdo->prepare($sql)){
                if ($query->execute()) {
                    return true;
                }
            }
            return false;
        } catch (PDOException $e) {
            die("DB ERROR: ". $e->getMessage());
        }
    }
}