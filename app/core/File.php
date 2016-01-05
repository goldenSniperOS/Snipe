<?php
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
		$this->_name = basename($file['name']);
		$this->_extension = pathinfo($this->_name,PATHINFO_EXTENSION);
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
		return false;	
	}

	public static function upload($nameFile,$targetdir,$constraints = []){
		if(isset($_FILES[$nameFile])){
			$file = $_FILES[$nameFile];
			$object = new File($nameFile,$constraints);
			if($object->target($targetdir)){
				$object->save();
			}
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
		return false;
	}

	private function checkConstraints(){
		foreach ($this->_constraints as $param => $constraint) {
			switch ($param) {
				case 'format':
					$allowFormats = explode("|",$constraint);
					if(array_search($this->_extension, $allowFormats) === false){
						return false;
					}
					break;
				case 'maxsize':
					if($this->_size >= $constraint){
						return false;
					}
					break;
				case 'unique':
					if(file_exists($this->_targetfile)){
						return false;
					}
					break;
				default:
					
					break;
			}
		}
		echo 'Constraints Passed';
		return true;
	}

	public static function folder($targetdir){
		if (!file_exists($target_dir)) {
            if (!mkdir($target_dir, 0777, true)) {
                die('Create Folder Failed...');
            }
        }
	}

	public function name($name){
		$this->_name = $name;
		$this->_extension = pathinfo($this->_name,PATHINFO_EXTENSION);
		return $this;
	}

	public function save(){
		$this->_targetfile = $this->_targetdir.$this->_name;
		if($this->checkConstraints() && move_uploaded_file($this->_file['tmp_name'],$this->_targetfile)){
			echo 'Upload Passed';
			return true;	
		}
		return false;
	}

}