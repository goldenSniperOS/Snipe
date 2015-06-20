<?php
class Eloquent{
	protected static $table = null,
					 $prefix = null,
					 $primaryKey = 'id';

	public function __construct($codigo = null){
		if($codigo){
			$objeto = self::find($codigo);
			$this->table = static::$table;
			$this->prefix = static::$prefix;
			$this->primaryKey = static::$primaryKey;
			foreach ($objeto as $key => $value) {
				$this->{$key} = $value;
			}
		}
	}

	public static function create($fields = array()){
		if(!DB::getInstance()->insert(static::$table, $fields)){
			throw new Exception('Hubo un Problema registrando');
		}
	}

	public static function find($codigo = null){
		if($codigo){
			$data = DB::getInstance()->get(static::$table,[array(static::$primaryKey,'=',$codigo)]);
			if($data->count()){
				$object = new self;
				foreach ($data->first() as $key => $value) {
					$object->{$key} = $value;
					$object->primaryKey = static::$primaryKey;
					$object->table = static::$table;
					$object->prefix = static::$prefix;
				}
				return $object;
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
		if(!DB::getInstance()->update(static::$table,$id,$fields,static::$primaryKey)){
			throw new Exception('Hubo un Problema Actualizando');
		}
	}

	public static function all(){
		return DB::getInstance()->get(static::$table,[])->results();
	}

	public function relation($hasOne){
		$foreign = strtolower($hasOne::$prefix).'_'.$this->primaryKey;
		$foreignvalue = $this->{$this->primaryKey};
		$total = DB::getInstance()->get($hasOne::$table,[[$foreign,'=',$foreignvalue]])->results();
		$final = [];
		if(!empty($total)){
			foreach ($total as $value) {
				$HasOneObject = new $hasOne($value->{$hasOne::$primaryKey});
				$final[] = $HasOneObject;
			}	
		}
		return (!is_null($final)) ? $final: false;
	}
}
?>