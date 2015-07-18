<?php 
class DB{
	private static $_instance = null;
	private $_pdo, 
			$_query, 
			$_error = false,
			$_results,
			$_count = 0;
	
	private $sqlFinal  = [
		'select' => 'SELECT *',
		'table' => 'FROM table',
		'join' => '',
		'where' => '',
		'group' => '',
		'order' => ''
	];

	private function __construct(){
		try{
			$this->_pdo = new PDO(
				'mysql:host='.Config::get('mysql/host').
				';dbname='.Config::get('mysql/database'),
				Config::get('mysql/username'),
				Config::get('mysql/password'),
				array(PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES  \'UTF8\''));
				if(Config::get('database_errors')){
					$this->_pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);	
				}
				//echo 'Connected';
		}catch(PDOException $e){
			die($e->getMessage());
		}
	}

	public static function getInstance(){
		if(!isset(self::$instance)){
			self::$_instance = new DB();
		}
		return self::$_instance;
	}
	public function query($sql,$params=array()){
		$this_error = false;
		try{
			if($this->_query = $this->_pdo->prepare($sql)){
				$x = 1;
				if(count($params)){
					foreach ($params as $param) {
						$this->_query->bindValue($x,$param);
						$x++;
					}
				}
				if($this->_query->execute()){
					$this->_count = $this->_query->rowCount();
					if($this->_query->columnCount()){
						$this->_results = $this->_query->fetchAll(PDO::FETCH_OBJ);	
					}
				} else{
					$this->_error = true;
				}
			}
		}catch(PDOException $e){
			die($e->getMessage());
		}
		return $this;	
	}

	public function where(){
		if(func_num_args() > 0);{
			if(func_num_args() == 2){
				$field = func_get_arg(0);
				$operator = '=';
				$value = func_get_arg(1);
			}else{
				$field = func_get_arg(0);
				$operator = func_get_arg(1);
				$value = func_get_arg(2);
			}

			$value = (is_numeric($value))?$value:'"'.$value.'"';
			if($this->sqlFinal['where'] == ''){
				$this->sqlFinal['where'] = 'WHERE '.$field.' '.$operator.' '.$value;
			}else{
				$this->sqlFinal['where'] .= ' AND '.$field.' '.$operator.' '.$value;
			}
			return $this;
		}
	}

	public function orWhere(){
		if(func_num_args() > 0);{
			if(func_num_args() == 2){
				$field = func_get_arg(0);
				$operator = '=';
				$value = func_get_arg(1);
			}else{
				$field = func_get_arg(0);
				$operator = func_get_arg(1);
				$value = func_get_arg(2);
			}

			$value = (is_numeric($value))?$value:'"'.$value.'"';
			if($this->sqlFinal['where'] == ''){
				$this->sqlFinal['where'] = 'WHERE '.$field.' '.$operator.' '.$value;
			}else{
				$this->sqlFinal['where'] .= ' OR '.$field.' '.$operator.' '.$value;
			}
			return $this;
		}
	}

	public function select(){
		if(func_num_args() > 0);{
			$args = func_get_args();
			$this->sqlFinal['select'] = 'SELECT ';
		    foreach ($args as $index => $arg) {
		        if($index == count($args)-1){
		        	$this->sqlFinal['select'].= $arg;
		        }else{
		        	$this->sqlFinal['select'].= $arg.',';
		        }

		    }
			return $this;
		}
	}

	public function join($table,$primarykey,$operator,$foreignkey){
		$this->sqlFinal['join'] = 'INNER JOIN '.$table.' ON '.$primarykey.$operator.$foreignkey;
		return $this;
	}

	public function leftJoin($table,$primarykey,$operator,$foreignkey){
		$this->sqlFinal['join'] = 'LEFT JOIN '.$table.' ON '.$primarykey.$operator.$foreignkey;
		return $this;
	}

	public function rightJoin($table,$primarykey,$operator,$foreignkey){
		$this->sqlFinal['join'] = 'RIGHT JOIN '.$table.' ON '.$primarykey.$operator.$foreignkey;
		return $this;
	}

	public function table($table,$alias = null){
		$alias = ($alias)?" AS ".$alias:"";
		$this->sqlFinal['table'] = 'FROM '.$table.$alias;
		return $this;
	}

	public function groupBy($field){
		$this->sqlFinal['group'] = 'GROUP BY'.$field;
		return $this;
	}

	public function orderBy($field,$direction = null){
		if($direction){
			$this->sqlFinal['order'] = 'ORDER BY '.$field.' '.strtoupper($direction);
		}else{
			$this->sqlFinal['order'] = 'ORDER BY '.$field;
		}
	}

	public function exec(){
		$query = implode(" ", $this->sqlFinal);
		return $this->query($query)->results();
	}

	public function action($action,$table,$wheres = array()){
		if(!empty($wheres)){
			$sql = "{$action} FROM {$table} WHERE ";
			$counter = 0;
			$values;
			foreach ($wheres as $where) {
				$field 		= $where[0];
				$operator 	= $where[1];
				$value 		= $where[2];
				$counter++;
				$sql .="{$field} {$operator} ? ";
				if(count($wheres) > 1 && count($wheres) != $counter){
					$sql .= " AND ";
				}
				$values[] = $value;
			}
			if(!$this->query($sql,$values)->error()){
				return $this;
			}
		}else{
			$sql = "{$action} FROM {$table}";
			if(!$this->query($sql)->error()){
				return $this;
			}
		}
	}

	public function getFirst(){
		$query = implode(" ", $this->sqlFinal);
		$this->query($query)
		if($this->count() > 0){
			return $this->results()[0];
		}
		return null;
	}

	public function first(){
		if($this->count() > 0){
			return $this->results()[0];
		}
		return null;
	}
	
	public function get($table,$where){
		return $this->action('SELECT *',$table,$where);
	}
	
	public function insert($table,$fields = array()){
		try{
			if(count($fields)){
				$keys = array_keys($fields);
				$values = null;
				$x = 1;
				foreach ($fields as $field) {
					$values .= '?';
					if($x < count($fields)){
						$values .= ', ';
					}
					$x++;
				}
				$sql = "INSERT INTO {$table}(`".implode('`, `',$keys)."`) VALUES({$values})";
				if(!$this->query($sql,$fields)->error()){
					return true;
				}
			}
		}catch(PDOException $e){
			die($e->getMessage());
		}		
		return false;
	}

	public function call($procedure,$fields = array()){
		try{
			if(count($fields)){
				$values = null;
				$x = 1;
				foreach ($fields as $field) {
					$values .= '?';
					if($x < count($fields)){
						$values .= ', ';
					}
					$x++;
				}
				$sql = "CALL {$procedure}({$values})";
				if(!$this->query($sql,$fields)->error()){
					return $this;
				}
			}
		}catch(PDOException $e){
			die($e->getMessage());
		}		
		return false;
	}

	public function update($table,$id,$fields,$pk){
		$set = '';
		$x = 1;
		foreach ($fields as $name => $value) {
			$set .= $name.' = ?';
			if($x < count($fields)){
				$set .= ', ';
			}
			$x++;
		}
		if(is_numeric($id)){
			$sql = "UPDATE {$table} SET {$set} WHERE {$pk} = {$id}";
		}else{
			$sql = "UPDATE {$table} SET {$set} WHERE {$pk} = '{$id}'";
		}
		
		if(!$this->query($sql,$fields)->error()){
			return true;
		}
		return false;
	}
	public function delete($table,$where){
		return $this->action('DELETE',$table,$where);
	}
	public function count(){
		return $this->_count;
	}
	public function results(){
		return $this->_results;
	}
	public function error(){
		return $this->_error;
	}
}