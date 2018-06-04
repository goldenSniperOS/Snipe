<?php namespace Snipe\Core;

/**
*	Clase para subir archivos y crear carpetas
*	Ejemplo en functionamiento
*	$targetdir = Path::to('public').'carpeta';
*   File::folder($targetdir);
*   File::upload('archivo',$targetdir,['formats' => 'png|jpg','maxsize' => 1000,'unique' => true],'nombre_personalizado.jpg');
*
*
*
*/

class File
{
	private $_file = null,
			$_constraints = [],
			$_targetdir = "",
			$_size = 0,
			$_extension = "",
			$_targetfile = "",
			$_name ="";



	function __construct($file,$constraints = null)
	{
		$this->_file = $file;
		$this->_extension = strtolower(pathinfo($file['name'],PATHINFO_EXTENSION));
		$this->_name = basename($file['name']);
		$this->_size = $file['size'];
		
		if(isset($constraints)){
			$this->_constraints = $constraints;	
		}
		

	}

	public static function get($nameFile){
		if(isset($_FILES[$nameFile])){
			$file = $_FILES[$nameFile];	
			$object = new File($nameFile);
			return $object;
		}
		//echo 'El archivo no Existe';
		return false;	
	}

	public static function upload($nameFile,$targetdir,$constraints = [],$customName = null){
		if(isset($_FILES[$nameFile])){
			$file = $_FILES[$nameFile];
			$object = new File($file,$constraints);
			if($object->target($targetdir)){
				if(isset($customName)){
					$object->name($customName);
				}
				$object->save();
				return true;
			}
			//echo 'La ruta no Existe';
		}else{
			//echo 'El archivo no Existe';	
		}
		return false;
	}

	public function constraints($data = []){
		$this->_constraints = $constraints;
		return $this;
	}

	public function target($targetdir = ""){
		if(file_exists($targetdir.DIRECTORY_SEPARATOR)){
			$this->_targetdir = $targetdir.DIRECTORY_SEPARATOR;	
			echo 'Target Passed';
			return $this;
		}
		//echo 'La ruta no Existe';
		return false;
	}

	private function checkConstraints(){
		foreach ($this->_constraints as $param => $constraint) {
			switch ($param) {
				case 'formats':
					$allowFormats = explode("|",$constraint);
					if(array_search($this->_extension, $allowFormats) === false){
						//echo 'El Archivo no corresponde con el formato';
						return false;
					}
					break;
				case 'maxsize':
					var_dump($this->_size);
					if($this->_size >= $constraint){
						//echo 'El Archivo excede';
						return false;
					}
					break;
				case 'unique':
					if(file_exists($this->_targetfile) && $constraint){
						//echo 'El archivo ya existe';
						return false;
					}
					break;
				default:
					
					break;
			}
		}
		//echo 'El Archivo es correcto';
		return true;
	}

	//No Funciona en algunas PC's - Linux
	public static function folder($targetdir){
		if (!file_exists($targetdir)) {
            if (!mkdir($targetdir, 0777, true)) {
                die('Fallo al crear la carpeta...');
            }
            return true;
        }
	}

	public function name($name){
		$analyzer = explode('.', $name);
		if(count($analyzer) == 2){
			$this->_extension = strtolower($analyzer[1]);
			$this->_name = $analyzer[0].'.'.$this->_extension;
			return $this;
		}
		//echo 'Nombre de archivo mal escrito o no se encuentra';
		return false;
	}

	public function save(){
		$this->_targetfile = $this->_targetdir.$this->_name;
		if($this->checkConstraints() && move_uploaded_file($this->_file['tmp_name'],$this->_targetfile)){
			//echo 'Subido Correctamente';
			return true;	
		}
		//echo 'Error al subir';
		return false;
	}

}