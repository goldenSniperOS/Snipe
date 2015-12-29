<?php

class DB {

    private static $_instance = null;
    private $_pdo,
            $_query,
            $_error = false,
            $_results = null,
            $_count = -1;

    private function __construct() {
        try {
            $this->_pdo = new PDO(
                    'mysql:host=' . Config::get('mysql/host') .
                    ';dbname=' . Config::get('mysql/database'), Config::get('mysql/username'), Config::get('mysql/password'), array(PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES  \'UTF8\''));
            if (Config::get('database_errors')) {
                $this->_pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            }
            //echo 'Connected';
        } catch (PDOException $e) {
            die($e->getMessage());
        }
    }

    protected function tableLock() {
        $this->_tableLock = true;
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
    }

    public static function getInstance() {
        if (!isset(self::$_instance)) {
            self::$_instance = new DB();
        }
        self::initQuery();
        return self::$_instance;
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
        if (func_num_args() > 0)
            ; {
            if (func_num_args() == 2) {
                $field = func_get_arg(0);
                $operator = '=';
                $value = func_get_arg(1);
            } else {
                $field = func_get_arg(0);
                $operator = func_get_arg(1);
                $value = func_get_arg(2);
            }

            $value = (is_numeric($value)) ? $value : '"' . $value . '"';
            if ($this->sql['where'] == '') {
                $this->sql['where'] = 'WHERE ' . $field . ' ' . $operator . ' ' . $value;
            } else {
                $this->sql['where'] .= ' AND ' . $field . ' ' . $operator . ' ' . $value;
            }
            return $this;
        }
    }

    public function orWhere() {
        if (func_num_args() > 0)
            ; {
            if (func_num_args() == 2) {
                $field = func_get_arg(0);
                $operator = '=';
                $value = func_get_arg(1);
            } else {
                $field = func_get_arg(0);
                $operator = func_get_arg(1);
                $value = func_get_arg(2);
            }

            $value = (is_numeric($value)) ? $value : '"' . $value . '"';
            if ($this->sql['where'] == '') {
                $this->sql['where'] = 'WHERE ' . $field . ' ' . $operator . ' ' . $value;
            } else {
                $this->sql['where'] .= ' OR ' . $field . ' ' . $operator . ' ' . $value;
            }
            return $this;
        }
    }

    public function select() {
        if (func_num_args() > 0)
            ; {
            $args = func_get_args();
            $this->sql['action'] = 'SELECT';
            foreach ($args as $index => $arg) {
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
        if (func_num_args() > 0)
            ; {
            $args = func_get_args();
            $this->sql['action'] = 'SELECT DISTINCT';
            foreach ($args as $index => $arg) {
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
        $this->sql['join'] += ' INNER JOIN ' . $table . ' ON ' . $primarykey . $operator . $foreignkey;
        return $this;
    }

    public function leftJoin($table, $primarykey, $operator, $foreignkey) {
        $this->sql['join'] += ' LEFT JOIN ' . $table . ' ON ' . $primarykey . $operator . $foreignkey;
        return $this;
    }

    public function rightJoin($table, $primarykey, $operator, $foreignkey) {
        $this->sql['join'] += ' RIGHT JOIN ' . $table . ' ON ' . $primarykey . $operator . $foreignkey;
        return $this;
    }

    public function table($table, $alias = null) {
        if (!$this->_tableLock) {
            $alias = ($alias) ? " AS " . $alias : "";
            $this->sql['table'] = 'FROM ' . $table . $alias;
            $this->tableLock();
        }
        return $this;
    }

    public function groupBy($field) {
        $this->sql['group'] = 'GROUP BY' . $field;
        return $this;
    }

    public function orderBy($field, $direction = null) {
        if ($direction) {
            $this->sql['order'] = 'ORDER BY ' . $field . ' ' . strtoupper($direction);
        } else {
            $this->sql['order'] = 'ORDER BY ' . $field;
        }
        return $this;
    }

    public function limit($param1, $param2 = null) {
        $this->sql['limit'] = 'LIMIT ' . $param1;
        if ($param2) {
            $this->sql['limit']+=',' . $param2;
        }
        return $this;
    }

    public function get() {
        $query = implode(" ", $this->sql);
        return $this->query($query)->results();
    }

    public function first() {
        $this->sql['limit'] = "LIMIT 1";
        $query = implode(" ", $this->sql);
        $this->query($query);
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
                    if (isAssoc($fields)) {
                        $this->sql['table'] = substr($this->sql['table'], 5) . "(`" . implode('`, `', $keys) . "`)";
                    } else {
                        $this->sql['table'] = substr($this->sql['table'], 5);
                    }
                }
                $this->sql['fields'] = "VALUES({$values})";
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
            //return $this;
            return $this->query($query, $fields);
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
        if($this->_count == -1 && $this->select['table'] == 'FROM table'){
            $this->select['join'] = 'SELECT COUNT('.(is_null($field))?'*':$field.') as COUNT';
            $query = implode(" ", $this->sql);
            $this->query($query);
            if ($this->count() > 0) {
                $this->_count = $this->results()[0];
            }
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
