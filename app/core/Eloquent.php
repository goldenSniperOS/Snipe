<?php
class Eloquent{
	protected static $table = null,
					 $prefix = null,
					 $primaryKey = 'id';

	public function __construct($codigo = null){
		if($codigo){
			$objeto = self::find($codigo);
			foreach ($objeto as $key => $value) {
				$this->{$key} = $value;
			}
		}
		$this->_db = DB::getInstance();
	}

	public static function create($fields = array()){
		if(!DB::getInstance()->insert($this->table, $fields)){
			throw new Exception('Hubo un Problema registrando');
		}
	}

	public static function find($codigo = null){
		if($codigo){
			$data = DB::getInstance()->get(static::$table,[array(static::$primaryKey,'=',$codigo)]);
			if($data->count()){
				return $data->first();
			}
		}
		return null;
	}

	//Crea un codigo con un prefijo otorgado en la clase mas un numero de 7 cifras
	public static function code(){
		$count = DB::getInstance()->get(static::$table,array())->count();
		return static::$prefix.str_pad($count+1, 7, "0", STR_PAD_LEFT);
	}

	public static function update($fields = array(),$id = null){
		if(!DB::getInstance()->update($this->table,$id,$fields,$this->primaryKey)){
			throw new Exception('Hubo un Problema Actualizando');
		}
	}

	public static function all(){
		return DB::getInstance()->get(static::$table,[])->results();
	}

	public function relation($hasOne){
		$this->_HasOneObject = new $hasOne;
		$total = $this->_HasOneObject->get([[strtolower($this->_HasOneObject->prefix).'_'.$this->primaryKey,'=',$this->data()->{$this->primaryKey}]])->results();
		return (!is_null($total)) ? $total: false;
	}
}
?>