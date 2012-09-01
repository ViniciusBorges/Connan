<?php
	
	class Connan_Config extends Connan_Util_Singleton
	{
		
		protected $_name;
		protected $_type;
		protected $_path;
		public $ds = '/';
		
		public function __construct($name = '', $type = 'json')
		{
			$this->name($name);
			$this->type($type);
			
			$application =& Connan_Factory::getApplication();
			$this->_path = $application->getPath('configuration');
			
			return;
		}
		
		public function name($name = null)
		{
			if(!is_null($name))
			{
				$this->_name = (string) $name;
				return $this;
			}
			return $this->_name;
		}
		
		public function type($type = null)
		{
			if(!is_null($type))
			{
				$this->_type = (string) $type;
				return $this;
			}
			return $this->_type;
		}
		
		public function get()
		{
			if(!$this->exists())
			{
				ConnanException::raise(array(
					'code' => 404,
					'message' => "config {$this->_name} not found",
					'package' => 'config'
				));
				return false;
			}
			switch($this->_type)
			{
				case 'json':
					return $this->getJson();
				break;
				case 'xml':
					return $this->getXML();
				break;
				default:
					ConnanException::raise(array(
						'code' => 404,
						'message' => "config type {$this->_type} not exists",
						'package' => 'config'
					));
					return false;
				break;
			}
		}
		
		public function exists()
		{
			return file_exists($this->_path.DS.$this->_name.'.'.$this->_type);
		}
		
		public function getJson()
		{
			if(!$content = json_decode(file_get_contents($this->_path.DS.$this->_name.'.'.$this->_type)))
			{
				ConnanException::raise(array(
					'code' => 404,
					'message' => "config {$this->_name} invalid {$this->_type}",
					'package' => 'config'
				));
				return false;
			}
			return $content;
		}
		
		public function getXML()
		{
			return simplexml_load_file($this->_path.DS.$this->_name.'.'.$this->_type);
		}
	}