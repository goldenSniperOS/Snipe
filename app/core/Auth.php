<?php
class Auth
{
	public static function get($attribute = null){
		if($attribute){
			if(Session::exists(Config::get('session/session_name'))){
				$user = Session::get(Config::get('session/session_name'));
				if($user){
					if(property_exists($user, $attribute)){
						return $user->{$attribute};
					}	
				}
			}
		}
		return null;
	}

	public static function login($username = null,$password = null,$remember = null){	
		if($username != null && $password != null){
			$class = Config::get('user/user_class');
			$user = $class::find($username,Config::get('user/userField'));
			if($user != null){
				if($user->{Config::get('user/passwordField')} === Hash::make($password)){
					//Estas Dos Lineas Loguean realmente al Usuario			
					Session::put(Config::get('session/session_name'),$user);
					Session::put('isLoggedIn',true);				
					if(Config::get('groups/active')){
						Session::put('listPermission',self::getPermissions($user));
					}
					
					if($remember && Config::get('session/active')){
						$hash = Hash::unique();
						$hashCheck = DB::getInstance()->table(Config::get('session/table'))->where(Config::get('session/primaryKey'),$user->{$user->getInfo('primaryKey')})->first();
						if($hashCheck == null){
							DB::getInstance()->table(Config::get('session/table'))->insert([
								Config::get('session/primaryKey') => $user->{$user->getInfo('primaryKey')},
								Config::get('session/hashField') => $hash
							]);
						}else{
							$hash = $hashCheck->{Config::get('session/hashField')};
						}
						Cookie::put(Config::get('remember/cookie_name'),$hash,Config::get('remember/cookie_expiry'));
					}
					return true;
				}
			}
		}
		return false;
	}

	public static function logout(){
		if(Session::exists(Config::get('session/session_name')) && Config::get('session/activeDatabase')){
			$user = Session::get(Config::get('session/session_name'));
			if($user){
				DB::getInstance()->delete(Config::get('session/table'),[
					[Config::get('session/primaryKey'),'=',$user->{$user->getInfo('primaryKey')}]
				]);
			}
		}
		Session::delete('isLoggedIn');
		if(Config::get('groups/activeDatabase')){
			Session::delete('listPermission');
		}
		Session::delete(Config::get('session/session_name'));
		Cookie::delete(Config::get('remember/cookie_name'));
	}

	public static function getPermissions($user = null){
		if($user && Config::get('groups/active')){
			$foreignGroup = Config::get('user/foreignGroup');
			$grupo =  DB::getInstance()->table(Config::get('groups/table'))->where(Config::get('groups/primaryKey'),$user->{$foreignGroup})->first();
			return json_decode($grupo->{Config::get('groups/permissionField')});
		}
		return false;
	}

	public static function updatePermissions(){
		if(Session::exists('isLoggedIn') && Session::exists(Config::get('session/session_name'))){
			$foreignGroup = Config::get('user/foreignGroup');
			$user = Session::get(Config::get('session/session_name'));
			if(property_exists($user, $foreignGroup)){
				if($user && Config::get('groups/active')){
					$grupo =  DB::getInstance()->table(Config::get('groups/table'))->where(Config::get('groups/primaryKey'),$user->{$foreignGroup})->first();
					Session::put('listPermission',json_decode($grupo->{Config::get('groups/permissionField')}));
				}
			}
		}
		return false;
	}

	public function hasPermission($key = null){
		if(Config::get('groups/active')){
			if(Session::exists('listPermission')){
				if(property_exists(Session::get('listPermission'), $key)){
					return Session::get('listPermission')->{$key};
				}
			}
			return false;
		}
		return true;
	}

	public function isLoggedIn(){
		if(Session::exists('isLoggedIn')){
			return Session::get('isLoggedIn');
		}else{
			if(Cookie::exists(Config::get('remember/cookie_name'))){
				$hashCheck = DB::getInstance()
					->table(Config::get('session/table'))
					->where(Config::get('session/hashField'),'=',Cookie::get(Config::get('remember/cookie_name')))
					->first();
				if($hashCheck){
					$class = Config::get('user/user_class');
					$user = $class::find($hashCheck->{Config::get('session/primaryKey')});				
					Session::put('isLoggedIn',true);
					Session::put(Config::get('session/session_name'),$user);
					if(Config::get('groups/active')){
						Session::put('listPermission',self::getPermissions($user));
					}
					return Session::get('isLoggedIn');
				}else{
					Cookie::delete(Config::get('remember/cookie_name'));
				}
			}
		}
		return false;
	}
}