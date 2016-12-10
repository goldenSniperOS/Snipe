<?php
/**
* Clase para crear modelos ORM
*
*   Ejemplo para obtener el id:
*   $salt = Hash::salt(32);
*   $id = UsersModel::create([
*      'username' => 'anguelsc',
*      'salt' => $salt,
*      'password' => Hash::make('Losmejores',$salt),
*   ]);
*
*/
class Eloquent {

    protected static $table = null,
            $prefix = null,
            $primaryKey = 'id';

    public function __construct($codigo = null) {
        if ($codigo) {
            $objeto = self::find($codigo);
            foreach ($objeto as $key => $value) {
                $this->{$key} = $value;
            }
        }
    }

    public static function create($fields = array()) {
        $columns = self::getNumberFields();
        if(!Tools::arrayAssoc($fields) && count($columns) != $fields && self::haveAutoIncrement()){
          $next = self::getNextId();
          array_unshift($fields,$next);
        }

        $id = DB::getInstance()->table(static::$table)->insert($fields);
        if (is_null($id)) {
            throw new Exception('Hubo un Problema Registrando ' . get_called_class(). ' id:'.$id);
        }else{
            return $id;
        }
    }

    //Find Busca un resultado que tenga el contenido de Valor en Field
    public static function find($valor = null, $unique = null) {
        if (!$unique) {
            $unique = static::$primaryKey;
        }
        if ($valor) {
            $data = DB::getInstance()->table(static::$table)->where($unique, $valor)->first();
            if ($data) {
                $clase = get_called_class();
                $object = new $clase;
                foreach ($data as $key => $value) {
                    $object->{$key} = $value;
                }
                return $object;
            }
        }
        return null;
    }

    public static function where() {
        if (func_num_args() > 0){
            if(is_callable(func_get_arg(0))){
                $_instanceDB = DB::getInstance()->table(static::$table)->tableLock()->where(func_get_arg(0));
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
                $_instanceDB = DB::getInstance()->table(static::$table)->tableLock()->where($field, $operator, $value);
            }
            return $_instanceDB;
        }
        return false;
    }

    public static function select() {
        if (func_num_args() > 0){
            $args = func_get_args();
            $_instanceDB = DB::getInstance()->table(static::$table)->tableLock();
            $_instanceDB = call_user_func_array([$_instanceDB, "select"], $args);
            return $_instanceDB;
        }
    }

    public static function join($table, $primarykey, $operator, $foreignkey) {
        $_instanceDB = DB::getInstance()->table(static::$table)->tableLock()->join($table, $primarykey, $operator, $foreignkey);
        return $_instanceDB;
    }

    public static function rightJoin($table, $primarykey, $operator, $foreignkey) {
        $_instanceDB = DB::getInstance()->table(static::$table)->tableLock()->rightJoin($table, $primarykey, $operator, $foreignkey);
        return $_instanceDB;
    }

    public static function leftJoin($table, $primarykey, $operator, $foreignkey) {
        $_instanceDB = DB::getInstance()->table(static::$table)->tableLock()->leftJoin($table, $primarykey, $operator, $foreignkey);
        return $_instanceDB;
    }

    //Crea un codigo con un prefijo otorgado en la clase mas un numero de N cifras
    public static function code($numeroFinal = 7) {
      if(self::haveAutoIncrement()){
        return self::getNextId();
      }else{
        $ultima = self::getLastInsertedKey();
        $numero = "0";
        if(!is_null($ultima)){
            $string = $ultima;
            for ($i = 0; $i < strlen($string); $i++) {
                if ($string[$i] != '0' && is_numeric($string[$i])) {
                    $numero = substr($string, $i, strlen($string) - 1);
                    break;
                }
            }
        }
        return static::$prefix . str_pad(((int) $numero) + 1, $numeroFinal, "0", STR_PAD_LEFT);
      }
    }

    private static function haveAutoIncrement(){
      $proof = DB::getInstance("INFORMATION_SCHEMA")
      ->select("COLUMN_NAME","COLUMN_TYPE","COLUMN_KEY","EXTRA")
      ->table("COLUMNS")
      ->where("TABLE_SCHEMA",Config::get('mysql/database'))
      ->where("TABLE_NAME",static::$table)
      ->where("COLUMN_NAME",static::$primaryKey)
      ->where("DATA_TYPE","int")
      ->whereNull("COLUMN_DEFAULT")
      ->where("IS_NULLABLE","NO")
      ->where("EXTRA",'LIKE',"%auto_increment%")
      ->first();
      if(empty($proof)){
        return false;
      }
      return true;
    }

    public static function getFields(){
      $fields = DB::getInstance("INFORMATION_SCHEMA")
      ->select("COLUMN_NAME","COLUMN_TYPE","COLUMN_KEY","EXTRA")
      ->table("COLUMNS")
      ->where("TABLE_SCHEMA",Config::get('mysql/database'))
      ->where("TABLE_NAME",static::$table)
      ->get();

      if(empty($fields)){
        throw new Exception('La tabla '.static::$table.' no esta definida en '.Config::get('mysql/database'));
      }else{
        return $fields;
      }
    }

    public static function getNumberFields(){
      $fields = DB::getInstance("INFORMATION_SCHEMA")
      ->select("COUNT(COLUMN_NAME) AS counter")
      ->table("COLUMNS")
      ->where("TABLE_SCHEMA",Config::get('mysql/database'))
      ->where("TABLE_NAME",static::$table)
      ->first();

      if(empty($fields)){
        throw new Exception('La tabla '.static::$table.' no esta definida en INFORMATION_SCHEMA');
      }else{
        return $fields->counter;
      }
    }

    public static function orderBy($field, $direction = null) {
        $_instanceDB = DB::getInstance()->table(static::$table)->orderBy($field,$direction);
        return $_instanceDB;
    }


    private static function getLastInsertedKey(){
      $class = get_called_class();
        $ultima = DB::getInstance()
        ->select($class::$primaryKey)
        ->table($class::$table)
        ->orderBy($class::$primaryKey, 'desc')
        ->first();
        if(is_null($ultima)){
            //No hay ninguna collumna
            return 0;
        }else{

          return $ultima->{static::$primaryKey};
        }
    }

    private static function getNextId(){
      $class = get_called_class();
      if($class::haveAutoIncrement()){
        $ultima = DB::getInstance("INFORMATION_SCHEMA")
        ->select("AUTO_INCREMENT")
        ->table("TABLES")
        ->where("TABLE_SCHEMA",Config::get('mysql/database'))
        ->where("TABLE_NAME",static::$table)
        ->first();
        return $ultima->AUTO_INCREMENT;
      }
      return false;
    }

    public static function update($fields = array(), $id = null, $key = null) {
        if (!$key) {
            $key = static::$primaryKey;
        }
        if (!DB::getInstance()->table(static::$table)->where($key, $id)->update($fields)) {
            throw new Exception('Hubo un Problema Actualizando ' . get_called_class());
        }
    }

    public static function delete($parameter = null, $key = null) {
        //Parameter puede ser 2 cosas : La llave primaria del Modelo, o El array con los campos del where 
        if (!$key) {
            $key = static::$primaryKey;
        }
        if(isset($parameter)){
          if(is_array($parameter)){
            $query = DB::getInstance()->table(static::$table)->where($parameter);
          }else{
            $query = DB::getInstance()->table(static::$table)->where($key,$parameter);
          }
          if (!$query->delete()) {
              throw new Exception('Hubo un Problema Eliminando ' . get_called_class());
          }
        }
    }

    public static function all() {
        return DB::getInstance()->table(static::$table)->get();
    }

    public static function count(){
        return DB::getInstance()->table(static::$table)->count();
    }

    public function getInfo($attrib = null) {
        if ($attrib)
            return static::$$attrib;
        return null;
    }

}
