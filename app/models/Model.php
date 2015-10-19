<?php

/*
  |--------------------------------------------------------------------------
  | Ejemplo de Modelo
  |--------------------------------------------------------------------------
  |
  | Esta es una plantilla para construir un Modelo. Sustituyendo el nombre de la Clase,
  | por el nombre del archivo, refiriéndose este a la tabla que vamos a usar.
  | Los campos table, y primaryKey son respectivamente, el nombre de la tabla y la llave primaria.
  | Si esta última no se declara, Se tomará por defecto la llave primaria "id".
  | El atributo prefix, define un prefijo de N letras, con el que se podrá usar el método code() de Eloquent.
  | Este método genera un codigo anteponiendo esas 3 letras y un número de cifras exactas, autoincrementales,
  | de la forma "TAB0000001","TAB0000002"... y así sucesivamente.
  |
 */

class Model extends Eloquent {

    protected static $table = 'tabla',
            $prefix = 'TAB',
            $primaryKey = 'tab_codigo';

}

?>