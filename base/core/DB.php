<?php

class DB {

    private static $_instance = null;
    private $_pdo,
            $_database = null,
            $_host = null,
            $_query,
            $_error = false,
            $_results = null,
            $_count = -1;

    private function __construct($database, $host) {
        try {
            $this->_database = $database;
            $this->_host = $host;
            $this->_pdo = new PDO(
                    'mysql:host=' . $host .
                    ';dbname=' . $database, Config::get('mysql/username'), Config::get('mysql/password'), array(PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES  \'UTF8\''));
            if (Config::get('database_errors')) {
                $this->_pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            }
            //echo 'Connected';
        } catch (PDOException $e) {
            die($e->getMessage());
        }
    }

    public function tableLock() {
        $this->_tableLock = true;
        return $this;
    }

    public function getLock() {
        return $this->_tableLock;
    }

    private static function initQuery() {
        self::$_instance->sql['action'] = 'SELECT *';
        self::$_instance->sql['table'] = 'FROM table';
        self::$_instance->sql['fields'] = '';
        self::$_instance->sql['join'] = '';
        self::$_instance->sql['where'] = '';
        self::$_instance->sql['group'] = '';
        self::$_instance->sql['order'] = '';
        self::$_instance->sql['limit'] = '';
        self::$_instance->_tableLock = false;

        self::$_instance->_fields['fields'] = [];
        self::$_instance->_fields['where'] = [];
        self::$_instance->_fields['limit'] = [];
    }

    public static function getInstance($database = null,$host = null) {
        if(is_null($database)){
            $database = Config::get('mysql/database');
        }
        if(is_null($host)){
          $host = Config::get('mysql/host');
        }

        if (!isset(self::$_instance) || ($database != self::$_instance->_database || $host != self::$_instance->_host)) {
          self::$_instance = null;
          self::$_instance = new DB($database,$host);
        }
        self::initQuery();
        return self::$_instance;
    }

    private function addParam($param,$querySection){
        if(is_array($param)){
            foreach ($param as $val) {
                $this->_fields[$querySection][] = $val;
            }
        }else{
            $this->_fields[$querySection][] = $param;
        }
    }

    public function query($sql, $params = array()) {
        $this_error = false;
        try {
            if ($this->_query = $this->_pdo->prepare($sql)) {
                $x = 1;
                if (count($params)) {
                    foreach ($params as $param) {
                        $this->_query->bindValue($x, $param);
                        $x++;
                    }
                }
                if ($this->_query->execute()) {
                    $this->_count = $this->_query->rowCount();
                    if ($this->_query->columnCount()) {
                        $this->_results = $this->_query->fetchAll(PDO::FETCH_OBJ);
                    }else{
                        if($this->sql['action'] == "INSERT INTO"){
                            return $this->_pdo->lastInsertId();
                        }
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

    public function where() {
        if (func_num_args() > 0){
            if(is_callable(func_get_arg(0))){
                $wheres = new Where();
                call_user_func_array(func_get_arg(0), [$wheres]);
                $this->sql['where'] .= ' AND '. $wheres->getQuery();
                $this->addParam($wheres->getParams(),"where");
            }else{
                if (func_num_args() == 2) {
                    $field = func_get_arg(0);
                    $operator = '=';
                    $value = func_get_arg(1);
                } else {
                    $field = func_get_arg(0);
                    $operator = func_get_arg(1);
                    $value = func_get_arg(2);
                }

                if(!strpos($field,'.') === false){
                    $field = explode('.',$field);
                    for ($i=0; $i < count($field); $i++) {
                        $field[$i] = '`'.$field[$i].'`';
                    }
                    $field = implode('.',$field);
                }else{
                    $field = '`'.$field.'`';
                }

                $this->addParam($value,"where");
                if ($this->sql['where'] == '') {
                    $this->sql['where'] = 'WHERE '. $field .' ' . $operator . ' ' . '?';
                } else {
                    $this->sql['where'] .= ' AND ' . $field . ' ' . $operator . ' ' . '?';
                }
            }
            return $this;
        }
    }

    public function whereNull($field){
      if(!strpos($field,'.') === false){
          $field = explode('.',$field);
          for ($i=0; $i < count($field); $i++) {
              $field[$i] = '`'.$field[$i].'`';
          }
          $field = implode('.',$field);
      }else{
          $field = '`'.$field.'`';
      }

      if ($this->sql['where'] == '') {
          $this->sql['where'] = 'WHERE '. $field .' IS NULL';
      } else {
          $this->sql['where'] .= ' AND ' . $field . ' IS NULL';
      }

      return $this;
    }

    public function orWhereNull($field){
      if(!strpos($field,'.') === false){
          $field = explode('.',$field);
          for ($i=0; $i < count($field); $i++) {
              $field[$i] = '`'.$field[$i].'`';
          }
          $field = implode('.',$field);
      }else{
          $field = '`'.$field.'`';
      }

      if ($this->sql['where'] == '') {
          $this->sql['where'] = 'WHERE '. $field .' IS NULL ';
      } else {
          $this->sql['where'] .= ' OR ' . $field . ' IS NULL ';
      }

      return $this;
    }

    public function orWhere() {
        if (func_num_args() > 0){
            if(is_callable(func_get_arg(0))){
                $wheres = new Where();
                call_user_func_array(func_get_arg(0), [$wheres]);
                $this->sql['where'] .= ' OR '. $wheres->getQuery();
                $this->addParam($wheres->getParams(),"where");
            }else{
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

                if(!strpos($field,'.') === false){
                    $field = explode('.',$field);
                    for ($i=0; $i < count($field); $i++) {
                        $field[$i] = '`'.$field[$i].'`';
                    }
                    $field = implode('.',$field);
                }else{
                    $field = '`'.$field.'`';
                }

                $this->addParam($value,"where");
                if ($this->sql['where'] == '') {
                    $this->sql['where'] = 'WHERE ' . $field . ' ' . $operator . ' ' . '?';
                } else {
                    $this->sql['where'] .= ' OR ' . $field . ' ' . $operator . ' ' . '?';
                }
            }
            return $this;
        }
    }

    public function select() {
        if (func_num_args() > 0){
            $args = func_get_args();
            $this->sql['action'] = 'SELECT';
            foreach ($args as $index => $arg) {

                //Buscar una Solucion
                /*if(!strpos($arg,'.') === false){
                    $arg = explode('.',$arg);
                    for ($i=0; $i < count($arg); $i++) {
                        $arg[$i] = '`'.$arg[$i].'`';
                    }
                    $arg = implode('.',$arg);
                }else{
                    $arg = '`'.$arg.'`';
                }*/

                if ($index == count($args) - 1) {
                    $this->sql['action'].= ' ' . $arg;
                } else {
                    $this->sql['action'].= ' ' . $arg . ',';
                }
            }
            return $this;
        }
    }

    public function distinct() {
        if (func_num_args() > 0){
            $args = func_get_args();
            $this->sql['action'] = 'SELECT DISTINCT';
            foreach ($args as $index => $arg) {

                if(!strpos($arg,'.') === false){
                    $arg = explode('.',$arg);
                    for ($i=0; $i < count($arg); $i++) {
                        $arg[$i] = '`'.$arg[$i].'`';
                    }
                    $arg = implode('.',$arg);
                }else{
                    $arg = '`'.$arg.'`';
                }

                if ($index == count($args) - 1) {
                    $this->sql['action'].= ' ' . $arg;
                } else {
                    $this->sql['action'].= ' ' . $arg . ',';
                }
            }
            return $this;
        }
    }

    public function join($table, $primarykey, $operator, $foreignkey) {

        if(!strpos($primarykey,'.') === false){
            $primarykey = explode('.',$primarykey);
            for ($i=0; $i < count($primarykey); $i++) {
                $primarykey[$i] = '`'.$primarykey[$i].'`';
            }
            $primarykey = implode('.',$primarykey);
        }else{
            $primarykey = '`'.$primarykey.'`';
        }

        if(!strpos($foreignkey,'.') === false){
            $foreignkey = explode('.',$foreignkey);
            for ($i=0; $i < count($foreignkey); $i++) {
                $foreignkey[$i] = '`'.$foreignkey[$i].'`';
            }
            $foreignkey = implode('.',$foreignkey);
        }else{
            $foreignkey = '`'.$foreignkey.'`';
        }

        $this->sql['join'] .= ' INNER JOIN ' . $table . ' ON ' . $primarykey .' '. $operator .' '. $foreignkey;
        return $this;
    }

    public function leftJoin($table, $primarykey, $operator, $foreignkey) {

        if(!strpos($primarykey,'.') === false){
            $primarykey = explode('.',$primarykey);
            for ($i=0; $i < count($primarykey); $i++) {
                $primarykey[$i] = '`'.$primarykey[$i].'`';
            }
            $primarykey = implode('.',$primarykey);
        }else{
            $primarykey = '`'.$primarykey.'`';
        }

        if(!strpos($foreignkey,'.') === false){
            $foreignkey = explode('.',$foreignkey);
            for ($i=0; $i < count($foreignkey); $i++) {
                $foreignkey[$i] = '`'.$foreignkey[$i].'`';
            }
            $foreignkey = implode('.',$foreignkey);
        }else{
            $foreignkey = '`'.$foreignkey.'`';
        }

        $this->sql['join'] .= ' LEFT JOIN ' . $table . ' ON ' . $primarykey .' '. $operator .' '. $foreignkey;
        return $this;
    }

    public function rightJoin($table, $primarykey, $operator, $foreignkey) {

        if(!strpos($primarykey,'.') === false){
            $primarykey = explode('.',$primarykey);
            for ($i=0; $i < count($primarykey); $i++) {
                $primarykey[$i] = '`'.$primarykey[$i].'`';
            }
            $primarykey = implode('.',$primarykey);
        }

        if(!strpos($foreignkey,'.') === false){
            $foreignkey = explode('.',$foreignkey);
            for ($i=0; $i < count($foreignkey); $i++) {
                $foreignkey[$i] = '`'.$foreignkey[$i].'`';
            }
            $foreignkey = implode('.',$foreignkey);
        }

        $this->sql['join'] .= ' RIGHT JOIN ' . $table . ' ON `' . $primarykey .'` '. $operator .' `'. $foreignkey.'`';
        return $this;
    }

    public function table($table, $alias = null) {
        if (!$this->_tableLock) {
            $alias = ($alias) ? " AS " . $alias : "";
            $this->sql['table'] = 'FROM `' . $table .'`'. $alias;
            $this->tableLock();
        }
        return $this;
    }

    public function groupBy($field) {

        if(!strpos($field,'.') === false){
            $field = explode('.',$field);
            for ($i=0; $i < count($field); $i++) {
                $field[$i] = '`'.$field[$i].'`';
            }
            $field = implode('.',$field);
        }else{
            $field = '`'.$field.'`';
        }

        $this->sql['group'] = 'GROUP BY ' . $field;
        return $this;
    }

    public function orderBy($field, $direction = null) {
        if(!strpos($field,'.') === false){
            $field = explode('.',$field);
            for ($i=0; $i < count($field); $i++) {
                $field[$i] = '`'.$field[$i].'`';
            }
            $field = implode('.',$field);
        }else{
            $field = '`'.$field.'`';
        }

        if ($direction) {
            $this->sql['order'] = 'ORDER BY ' . $field . ' ' . strtoupper($direction);
        } else {
            $this->sql['order'] = 'ORDER BY ' . $field;
        }
        return $this;
    }

    public function limit($param1, $param2 = null) {
        $this->sql['limit'] = 'LIMIT ?';
        $this->addParam($param1,'limit');
        if (!is_null($param2)) {
            $this->addParam($param2,'limit');
            $this->sql['limit'] .= ',?';
        }
        return $this;
    }

    public function get() {
        $query = implode(" ", $this->sql);
        $this->_fields = array_merge($this->_fields['fields'],$this->_fields['where'],$this->_fields['limit']);
        return $this->query($query,$this->_fields)->results();
    }

    public function first() {
        $this->sql['limit'] = "LIMIT 1";
        $query = implode(" ", $this->sql);
        $this->_fields = array_merge($this->_fields['fields'],$this->_fields['where'],$this->_fields['limit']);
        $this->query($query,$this->_fields);
        if ($this->count() > 0) {
            return $this->results()[0];
        }
        return null;
    }

    public function insert($fields = array()) {
        try {
            if (count($fields)) {
                $keys = array_keys($fields);
                $x = 1;
                $values = '';
                foreach ($fields as $field) {
                    $values .= '?';
                    if ($x < count($fields)) {
                        $values .= ', ';
                    }
                    $x++;
                }
                $this->sql['action'] = "INSERT INTO";

                if ($fields) {
                    if (Tools::arrayAssoc($fields)) {
                        $this->sql['table'] = substr($this->sql['table'], 5) . "(`" . implode('`, `', $keys) . "`)";
                    } else {
                        $this->sql['table'] = substr($this->sql['table'], 5);
                    }
                }

                $this->sql['fields'] = "VALUES({$values})";
                //Debug::varDump($this->sql);
                $query = implode(" ", $this->sql);
                //return $this;
                $lastID = $this->query($query, $fields);
                if(!$this->error()){
                    return $lastID;
                }else{
                    return false;
                }
            }
        } catch (PDOException $e) {
            die($e->getMessage());
        }
        return false;
    }

    public function call($procedure, $fields = array()) {
        try {
            if (count($fields)) {
                $values = null;
                $x = 1;
                foreach ($fields as $field) {
                    $values .= '?';
                    if ($x < count($fields)) {
                        $values .= ', ';
                    }
                    $x++;
                }
                $sql = "CALL {$procedure}({$values})";
                if (!$this->query($sql, $fields)->error()) {
                    if ($this->count() > 0) {
                        return $this->results();
                    } else {
                        return true;
                    }
                }
            }
        } catch (PDOException $e) {
            die($e->getMessage());
        }
        return false;
    }

    public function update($fields = array()) {
        try {
            $x = 1;
            $this->sql['fields'] = "SET ";
            foreach ($fields as $name => $value) {
                $this->sql['fields'] .= $name . ' = ?';
                if ($x < count($fields)) {
                    $this->sql['fields'] .= ', ';
                }
                $x++;
            }
            $this->sql['action'] = "UPDATE";
            $this->sql['table'] = substr($this->sql['table'], 5);
            $query = implode(" ", $this->sql);

            //return $query;
            return $this->query($query, $this->_fields);
            //return [$this->_fields,$query];
        } catch (PDOException $e) {
            die($e->getMessage());
        }
        return false;
    }

    public function delete() {
        try {
            $this->sql['action'] = "DELETE";
            $query = implode(" ", $this->sql);
            //return $this;
            return !$this->query($query)->error();
        } catch (PDOException $e) {
            die($e->getMessage());
        }
        return false;
    }

    public function count($field = null) {
        if($this->_count == -1 && $this->sql['table'] != 'FROM table'){
            $field = (is_null($field))?'*':$field;
            $this->sql['action'] = 'SELECT COUNT('.$field.') as COUNT';
            $query = implode(" ", $this->sql);
            $this->_fields = array_merge($this->_fields['fields'],$this->_fields['where'],$this->_fields['limit']);
            $this->query($query,$this->_fields);
            $this->_count = $this->results()[0]->COUNT;
        }
        return $this->_count;
    }

    public function results() {
        return $this->_results;
    }

    public function error() {
        return $this->_error;
    }
}
