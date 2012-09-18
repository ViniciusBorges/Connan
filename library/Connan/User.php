<?php
	
	class Connan_User extends Connan_Util_Singleton
	{
		public $auth = null;
		public $task = null;
		
		public function __constructor()
		{
			$this->auth = Connan_User_Auth::getInstance();
			$this->task = Connan_User_Tasks::getInstance();
			$this->model = Connan_User_Model::getInstance();
		}
		
		public function get($id = null)
		{
			
		}
	}