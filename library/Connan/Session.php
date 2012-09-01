<?php
	
	class Connan_Session extends Connan_Util_Singleton
	{
		public function __construct()
		{
			if(session_id())
			{
				session_unset();
				session_destroy();
			}
			$this->_start();
		}
		
		protected function _createId($length = 30)
		{
			$id = 0;
			while($length)
			{
				$id .= mt_rand(0, mt_getrandmax());
				$length--;
			}
			return md5(uniqid($id));
		}
		
		protected function _start()
		{
			session_start($this->_createId());
		}
		
		public function set($key, $value, $namespace = null)
		{
			if(is_null($namespace))
			{
				$_SESSION[$key] = $value;
			}
			else
			{
				$_SESSION[$namespace][$key] = $value;
			}
			return $this;
		}
		
		public function get($key, $default = '', $namespace = null)
		{
			if(is_null($namespace))
			{
				return isset($_SESSION[$key]) ? $_SESSION[$key] : $default;
			}
			else
			{
				return isset($_SESSION[$namespace][$key]) ? $_SESSION[$namespace][$key] : $default;
			}
		}
		
		public function clear($key, $namespace = null)
		{
			if(is_null($namespace))
			{
				unset($_SESSION[$key]);
				return;
			}
			else
			{
				unset($_SESSION[$namespace][$key]);
				return;
			}
		}
	}