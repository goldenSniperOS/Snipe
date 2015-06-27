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
	}

	public static function create($fields = array()){
		if(!DB::getInstance()->insert(static::$table, $fields)){
			throw new Exception('Hubo un Problema registrando');
		}
	}

	//Find Busca un resultado que tenga el contenido de Valor en Field
	public static function find($valor = null,$field = null){
		if(!$field){
			$field = static::$primaryKey;
		}
		if($valor){
			$data = DB::getInstance()->get(static::$table,[array($field,'=',$valor)]);
			if($data->count()){
				$clase = get_called_class();
				$object = new $clase;
				foreach ($data->first() as $key => $value) {
					$object->{$key} = $value;
				}
				return $object;
			}
		}
		return null;
	}

	//Crea un codigo con un prefijo otorgado en la clase mas un numero de 7 cifras
	public static function code(){
		$sql = 'SELECT  `'.static::$primaryKey.'` FROM  `'.static::$table.'` ORDER BY  `'.static::$table.'`.`'.static::$primaryKey.'` DESC ';
		$ultima = DB::getInstance()->query($sql,[])->first();
		$string = $ultima->{static::$primaryKey};
		
		for ($i=0; $i < strlen($string); $i++) { 
			if($string[$i] != '0' && is_numeric($string[$i])){
				$numero = substr($string,$i,strlen($string)-1);
				break;
			}
		}		
		return static::$prefix.str_pad(((int)$numero)+1, 7, "0", STR_PAD_LEFT);
	}

	public static function update($fields = array(),$id = null){
		if(!DB::getInstance()->update(static::$table,$id,$fields,static::$primaryKey)){
			throw new Exception('Hubo un Problema Actualizando');
		}
	}

	public static function delete($fields = array()){
		if(!DB::getInstance()->delete(static::$table,$fields)){
			throw new Exception('Hubo un Problema Eliminando');
		}
	}

	public static function all(){
		return DB::getInstance()->get(static::$table,[])->results();
	}

	public function relation($hasOne){
		$clase = get_called_class();
		$foreign = strtolower($hasOne::$prefix).'_'.$clase::$primaryKey;
		$foreignvalue = $this->{$clase::$primaryKey};
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

	public function getInfo($attrib = null){
		if($attrib)
			return static::$$attrib;
		return null;
	}
}
?>