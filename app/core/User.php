<?php
class User{
	private $_db,
			$_data,
			$_sessionName,
			$_cookieName,
			$_isLoggedIn,
			$_listPermission;

	protected $table = null,
			$prefix = null,
			$primaryKey = null,
			$tbSession = null,
			$foreignKeySession = null,
			$hashFieldSession = null,
			$tbGroups = null,
			$primaryKeyGroups = null,
			$userField = null,
			$passwordField = null,
			$hashSessionField = null;

	public function __construct($user = null){
		$this->_db = DB::getInstance();
		$this->_sessionName = Config::get('session/session_name');
		$this->_cookieName = Config::get('remember/cookie_name');
		if(!$user){
			if(Session::exists($this->_sessionName)){
				$user = Session::get($this->_sessionName);
				if($this->find($user)){
					$this->_isLoggedIn = true;
				} else {
					$this->logout();
				}
			}
		}else{
			$this->find($user);
		}
	}

	public function create($fields = array()){
		if(!$this->_db->insert($this->table, $fields)){
			throw new Exception('Hubo un problema registrando el usuario');
		}
	}

	public function find($user = null){
		if($user){
			$where = array($this->primaryKey,'=',$user);
			$data = $this->_db->get($this->table,[$where]);
			if($data->count()){
				$this->_data = $data->first();
				$groups = $this->_db->get($this->tbGroups,[array( $this->primaryKeyGroups,'=',$this->_data->per_grupo_Codigo)]);
				if($groups->count()){
					$this->_listPermission = json_decode($groups->first()->grupo_Permisos);
				}
				return true;
			}
		}
		return false;
	}

	public function findUsername($user = null){
		if($user){
			$where = array($this->userField,'=',$user);
			$data = $this->_db->get($this->table,[$where]);
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

		if(!$id && $this->isLoggedIn()){
			$id = $this->data()->id;
		}


		if(!$this->_db->update($this->table,$id,$fields,$this->primaryKey)){
			throw new Exception('There was a problem updating');
		}
	}


	public function login($username = null,$password = null,$remember = null){
		if(!$username && !$passwords && $this->exists()){
			Session::put($this->_sessionName,$this->data()->id);
		}else{
			$user = $this->findUsername($username);
			if($user){
				if($this->data()->{$this->passwordField} === Hash::make($password)){
					Session::put($this->_sessionName,$this->data()->{$this->primaryKey});
					if($remember){
						$hash = Hash::unique();
						$hashCheck = $this->_db->get($this->tbSession,array(
							[$this->foreignKeySession, '=' ,$this->data()->{$this->primaryKey}]
						));
						if(!$hashCheck->count()){
							$this->_db->insert($this->tbSession,array(
								$this->foreignKeySession => $this->data()->{$this->primaryKey},
								$this->hashSessionField => $hash
							));
						} else{
							$hash = $hashCheck->first()->hash;
						}
						Cookie::put($this->_cookieName,$hash,Config::get('remember/cookie_expiry'));
					}
					return true;
				}
			}
			return false;
		}
	}

	public function hasPermission($key){
		if(property_exists($this->listPermission(), $key)){
			return true;
		}
		return false;
	}

	public function exists(){
		return (!empty($this->_data)) ? true : false;
	}

	public function logout(){
		$this->_db->delete($this->tbSession,array([$this->foreignKeySession,'=',$this->data()->{$this->primaryKey}]));
		Session::delete($this->_sessionName);
		Cookie::delete($this->_cookieName);
	}

	public function data(){
		return $this->_data;
	}

	public function isLoggedIn(){
		return $this->_isLoggedIn;
	}

	public function listPermission(){
		return $this->_listPermission;
	}

	public function findPermission($key){

	}

	public static function auth(){
		$per = new Persona();
		if($per->isLoggedIn()){
			return $per;
			exit;
		}
		return null;
	}
}
?>