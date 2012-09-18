<?php
	
	class Connan_User_Tasks extends Connan_Util_Singleton
	{
		public $model = null;
		
		public function __construct()
		{
			$this->model = Connan_User_Model::getInstance();
		}
		
		public function registerUser($user)
		{
			$user->password = $this->_password($user->password);
			$model = Connan_User_Model::getInstance();
			if($this->model->hasEmail($user->email))
			{
				return 'email exists';
			}
			else if($this->model->hasUsername($user->username))
			{
				return 'username exists';
			}
			else
			{
				return $this->model->registerUser($user);
			}
		}
		
		public function deleteUser($id)
		{
			return $this->model->deleteUser($id);
		}
		
		public function updateUser()
		{
			
		}
		
		public function _password($str)
		{
			return md5($str);
		}
	}