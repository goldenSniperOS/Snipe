<?php
class Eloquent{
	
	private $_db,
			$_data,
			$_sessionName,
			$_cookieName,
			$_dataHasOne;

	protected $table = null,
			$prefix = null,
			$primaryKey = null,

	public function __construct(){
		$this->_db = DB::getInstance();
	}

	public function create($fields = array()){
		if(!$this->_db->insert($this->table, $fields)){
			throw new Exception('Hubo un Problema registrando');
		}
	}

	public function find($consultorio = null){
		if($consultorio){
			$data = $this->_db->get($this->table,[array($this->primaryKey,'=',$consultorio)]);
			if($data->count()){
				$this->_data = $data->first();
				return true;
			}
		}
		return false;
	}

	public function code(){
		$count = DB::getInstance()->get($this->table,array())->count();
		return $this->prefix.str_pad($count+1, 7, "0", STR_PAD_LEFT);
	}

	public function update($fields = array(),$id = null){
		if(!$this->_db->update($this->table,$id,$fields,$this->primaryKey)){
			throw new Exception('Hubo un Problema Actualizando');
		}
	}

	public function exists(){
		return (!empty($this->_data)) ? true : false;
	}

	public function data(){
		return $this->_data;
	}

	public function all(){
		return $this->_db->get($this->table,[])->results();
	}

	public function relation($class){
		$this->_dataHasOne = new $class;
		$this->_dataHasOne->find($this->data()->{$this->primaryKey});
		return (!is_null($this->_dataHasOne)) ? $this->_dataHasOne->data(): false;
	}
}
?>