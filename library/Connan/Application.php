<?php
	
	if(!defined('CONNAN_PATH_BASE'))
	{
		define('CONNAN_PATH_BASE', dirname(__FILE__));
	}
	
	class Connan_Application extends Connan_Util_Singleton
	{
		protected $_paths = array();
		
		public function __construct()
		{
			$this->_paths = array(
				'connan' => CONNAN_PATH_BASE
			);
		}
		
		public function getPath($path, $default = '')
		{
			return isset($this->_paths[$path]) ? $this->_paths[$path] : '';
		}
		
		public function setPath($name, $path)
		{
			$this->_paths[$name] = $path;
			return $this;
		}
		
		public function setPaths(Array $paths)
		{
			foreach($paths as $name => $path)
			{
				$this->setPath($name, $path);
			}
			return $this;
		}
	}
	
?>