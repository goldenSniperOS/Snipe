<?php 
class DB{
	private static $_instance = null;
	private $_pdo, 
			$_query, 
			$_error = false,
			$_results,
			$_count = 0;

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