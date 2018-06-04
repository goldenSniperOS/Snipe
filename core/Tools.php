<?php namespace Snipe\Core;


/**
* Esta Clase esta hecha para contener métodos para ayudar dentro de Snipe
* Puedes agregar más métodos si quieres, todos serán estáticos.
*/
class Tools
{
	//Retorna verdadero si el Array posee llaves asociativas
	public static function arrayAssoc($arr)	{
		return array_keys($arr) !== range(0, count($arr) - 1);
	}
	//Previene Ataques XSS quitando etiquetas html que  se pasen por parametro
	public static function escape($string) {
	    return htmlentities($string, ENT_QUOTES, 'UTF-8');
	}

	//Extension de la Funcion file_exist con la capacidad del case sensitive
	public static function fileExists($fileName, $caseSensitive = true) {
	    if(file_exists($fileName)) {
	        return $fileName;
	    }
	    if($caseSensitive) return false;

	    // Handle case insensitive requests            
	    $directoryName = dirname($fileName);
	    $fileArray = glob($directoryName . '/*', GLOB_NOSORT);
	    $fileNameLowerCase = strtolower($fileName);
	    foreach($fileArray as $file) {
	        if(strtolower($file) == $fileNameLowerCase) {
	            return $file;
	        }
	    }
	    return false;
	}

	public static function spanishTextDate($fecha)
	{
	    $FechaStamp = strtotime($fecha);
	    $ano = date('Y',$FechaStamp);
	    $mes = date('n',$FechaStamp);
	    $dia = date('d',$FechaStamp);
	    $diasemana = date('w',$FechaStamp);
	    $diassemanaN= array("Domingo","Lunes","Martes","Miércoles",
	                   "Jueves","Viernes","Sábado");
	    $mesesN=array(1=>"Enero","Febrero","Marzo","Abril","Mayo","Junio","Julio",
	              "Agosto","Septiembre","Octubre","Noviembre","Diciembre");
	    return $diassemanaN[$diasemana].", $dia de ". $mesesN[$mes] ." del $ano";
	}
}