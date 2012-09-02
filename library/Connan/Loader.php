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
			$this->loadClass('Connan_Loader_Autoload');
			spl_autoload_register(array('Connan_Loader_Autoload', 'autoload'));
		}
		
		public function loadClass($name)
		{
			$name = preg_replace('/^Connan/', '', $name);
			$name = str_replace('_', '/', $name).'.php';
			
			$file = CONNAN_PATH_BASE.DS.$name;
			
			if(file_exists($file))
			{
				require_once $file;
				return true;
			}
			else
			{
				ConnanException::raise(array(
					'code' => 300,
					'message' => 'class not found',
					'package' => 'loader'
				));
				return false;
			}
		}
		
		public function loadException($name)
		{
			$name = preg_replace('/(^Connan|Exception$)/', '', $name);
			$name = str_replace('_', DS, $name).DS.'Exception.php';
			$file = CONNAN_PATH_BASE.DS.$name;
			
			if(file_exists($file))
			{
				require_once $file;
				return true;
			}
			else
			{
				ConnanException::raise(array(
					'code' => 300,
					'message' => 'exception not found',
					'package' => 'loader'
				));
				return false;
			}
		}
		
		public function loadController($name)
		{
			$name = preg_replace('/(^Connan_|Controller$)/', '', $name);
			$name = str_replace('_', DS, $name);
			$name .= '.php';
			$application = Connan_Factory::getApplication();
			$path = $application->getPath('controller');
			$file = $path.DS.$name;
			if(file_exists($file))
			{
				require_once $file;
				return true;
			}
			else
			{
				ConnanException::raise(array(
					'code' => 404,
					'message' => 'controler not found',
					'package' => 'loader'
				));
				return false;
			}
		}
		
		public function loadModel($name)
		{
			$name = preg_replace('/(^Connan_|Model$)/', '', $name);
			$name = str_replace('_', DS, $name);
			$name .= '.php';
			$application = Connan_Factory::getApplication();
			$path = $application->getPath('model');
			$file = $path.DS.$name;;
				
			if(file_exists($file))
			{
				require_once $file;
				return true;
			}
			else
			{
				ConnanException::raise(array(
						'code' => 404,
						'message' => 'model not found',
						'package' => 'loader'
				));
				return false;
			}
		}
	}