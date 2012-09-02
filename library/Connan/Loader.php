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
			$this->addControllerPath($application->getPath('controller'), 1);
			$this->addModelPath($application->getPath('model'), 1);
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
		
		public function addControllerPath($path, $priority)
		{
			$this->_paths['controller'][$path] = $priority;
			return $this;
		}
		
		public function addModelPath($path, $priority)
		{
			$this->_paths['model'][$path] = $priority;
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
			$_file = '';
			$_priority = 0;
			
			$name = preg_replace('/(^Connan_)(Exception$)/', '', $name);
			$name = str_replace('_', DS, $name).DS.'Exception.php';
			
			foreach($this->_paths['class'] as $path => $priority)
			{
				if(file_exists($path.DS.$name) && $priority > $_priority)
				{
					$_file = $path.DS.$name;
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
			$_file = '';
			$_priority = 0;
			
			$name = preg_replace('/(^Connan_)(Controller$)/', '', $name);
			$name = str_replace('_', DS, $name);
			$name .= '.php';
			
			foreach($this->_paths['controller'] as $path => $priority)
			{
				if(file_exists($path.DS.$name) && $priority > $_priority)
				{
					$_file = $path.DS.$name;
				}
			}
			
			if($_file != '')
			{
				require_once $_file;
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
			$_file = '';
			$_priority = 0;
				
			$name = preg_replace('/(^Connan_)(Model$)/', '', $name);
			$name = str_replace('_', DS, $name);
			$name .= '.php';
				
			foreach($this->_paths['model'] as $path => $priority)
			{
				if(file_exists($path.DS.$name) && $priority > $_priority)
				{
					$_file = $path.DS.$name;
				}
			}
				
			if($_file != '')
			{
				require_once $_file;
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