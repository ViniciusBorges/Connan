<?php
	
	class Connan_Loader extends Connan_Util_Singleton
	{
		protected $_paths = array(
			'controller' => array(),
			'model' => array(),
			'class' => array()		
		);
		
		public function __construct()
		{
			$application =& Connan_Application::getInstance();
			/*$this->addControllerPath($application->getPath('controller'), 1);
			$this->addModelPath($application->getPath('model'), 1);*/
			$this->addClassPath($application->getPath('connan'), 1);
			$this->addClassPath($application->getPath('class'), 2);
			
			$this->loadClass('Connan_Loader_Autoload');
			spl_autoload_register(array('Connan_Loader_Autoload', 'autoload'));
		}
		
		public function addClassPath($path, $priority)
		{
			$this->_paths['class'][$path] = $priority;
			return $this;
		}
		
		public function loadClass($name)
		{
			$_file = '';
			$_priority = 0;
			
			$name = preg_replace('/^Connan/', '', $name);
			$name = str_replace('_', '/', $name).'.php';
			
			foreach($this->_paths['class'] as $path => $priority)
			{
				if(file_exists($path.$name) && $priority > $_priority)
				{
					$_file = $path.$name;
					$_priority = $priority;
				}
			}
			
			if($_file != '')
			{
				require_once $_file;
				return true;
			}
			else
			{
				throw new Connan_Loader_Exception('class not found');
			}
		}
	}