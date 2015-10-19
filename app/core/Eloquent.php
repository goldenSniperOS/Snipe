<?php

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
        if (!DB::getInstance()->table(static::$table)->insert($fields)) {
            throw new Exception('Hubo un Problema Registrando ' . get_called_class());
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
        if (func_num_args() > 0)
            ; {
            $clase = get_called_class();

            if (func_num_args() == 2) {
                $field = func_get_arg(0);
                $operator = '=';
                $value = func_get_arg(1);
            } else {
                $field = func_get_arg(0);
                $operator = func_get_arg(1);
                $value = func_get_arg(2);
            }
            $_instanceDB = DB::getInstance()->table(static::$table)->tableLock()->where($field, $operator, $value);
            return $_instanceDB;
        }
    }

    public function join($table, $primarykey, $operator, $foreignkey) {
        $_instanceDB = DB::getInstance()->table(static::$table)->tableLock()->join($table, $primarykey, $operator, $foreignkey);
        return $_instanceDB;
    }

    public function rightJoin($table, $primarykey, $operator, $foreignkey) {
        $_instanceDB = DB::getInstance()->table(static::$table)->tableLock()->rightJoin($table, $primarykey, $operator, $foreignkey);
        return $_instanceDB;
    }

    public function leftJoin($table, $primarykey, $operator, $foreignkey) {
        $_instanceDB = DB::getInstance()->table(static::$table)->tableLock()->leftJoin($table, $primarykey, $operator, $foreignkey);
        return $_instanceDB;
    }

    //Crea un codigo con un prefijo otorgado en la clase mas un numero de N cifras
    public static function code($numeroFinal) {
        $ultima = DB::getInstance()->select(static::$primaryKey)->table(static::$table)->orderBy(static::$primaryKey, 'desc')->first();
        $string = $ultima->{static::$primaryKey};
        $numero = "0";
        for ($i = 0; $i < strlen($string); $i++) {
            if ($string[$i] != '0' && is_numeric($string[$i])) {
                $numero = substr($string, $i, strlen($string) - 1);
                break;
            }
        }
        return static::$prefix . str_pad(((int) $numero) + 1, $numeroFinal, "0", STR_PAD_LEFT);
    }

    public static function update($fields = array(), $id = null, $key = null) {
        if (!$key) {
            $key = static::$primaryKey;
        }
        if (!DB::getInstance()->table(static::$table)->where($key, $id)->update($fields)) {
            throw new Exception('Hubo un Problema Actualizando ' . get_called_class());
        }
    }

    public static function delete($fields = array(), $id = null, $key = null) {
        if (!$key) {
            $key = static::$primaryKey;
        }
        if (!DB::getInstance()->table(static::$table)->where($key, $id)->delete()) {
            throw new Exception('Hubo un Problema Eliminando ' . get_called_class());
        }
    }

    public static function all() {
        return DB::getInstance()->table(static::$table)->get();
    }

    public function getInfo($attrib = null) {
        if ($attrib)
            return static::$$attrib;
        return null;
    }

}
