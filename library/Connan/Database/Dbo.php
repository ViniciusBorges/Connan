<?php
	
	class Connan_Database_Dbo extends Connan_Util_Singleton
	{
		protected $_hostname = '';
		protected $_username = '';
		protected $_password = '';
		protected $_database = '';
		
		protected $_dba = null;
		protected $_link = null;
		protected $_query = null;
		protected $_queries = array();
		protected $_queryString = '';
		protected $_prefix = array('#__' => 'jup_');
		
		public function __construct()
		{
			$config = (object) Connan_Factory::getConfig()->name('database')->get();
			$this->_hostname = $config->hostname;
			$this->_username = $config->username;
			$this->_password = $config->password;
			$this->_database = $config->database;
			
			$dba = 'Connan_Database_'.ucfirst(strtolower($config->dba));
			
			$loader = Connan_Factory::getLoader();
			if($loader->loadClass($dba))
			{
				$this->_dba = new $dba;
				$this->connect();
			}
			else
			{
				ConnanException::raise(array(
					'code' => 404,
					'message' => 'dba not found',
					'package' => 'database'
				));
			}
		}
		
		public function addPrefix($key, $value)
		{
			$this->_prefix[$key] = $value;
			return $this;
		}
		
		public function connect()
		{
			if(is_null($this->_link))
			{
				$this->_link = $this->_dba->connect($this->_hostname, $this->_username, $this->_password, $this->_database);
				if($this->_link)
				{
					ConnanException::raise(array(
						'code' => 404,
						'package' => 'database',
						'message' => $this->_dba->getErrorMessage()
					));
				}
			}
			return $this;
		}
		
		public function setQuery($query)
		{
			foreach($this->_prefix as $key => $value)
			{
				$query = str_replace($key, $value, $query);
			}
			$this->_queryString = $this->_dba->setQuery($query);
			$this->_query = null;
		}
		
		public function value($value)
		{
			return $this->_dba->value($value);
		}
		
		public function query()
		{
			if(!array_key_exists($this->_queryString, $this->_queries))
			{
				$this->_queries[$this->_queryString] = $this->_dba->query($this->_queryString, $this->_link);
			}
			$this->_query = $this->_queries[$this->_queryString];
			if($this->_query)
			{
				return $this->_query;
			}
			else
			{
				ConnanException::raise(array(
					'code' => 404,
					'package' => 'database',
					'message' => $this->_dba->getErrorMessage()
				));
			}
		}
		
		public function getNumRows()
		{
			if(is_null($this->_query))
			{
				$this->query();
			}
			return $this->_dba->getNumRows($this->_query);
		}
		
		public function loadObject()
		{
			if(is_null($this->_query))
			{
				$this->query();
			}
			return $this->_dba->loadObject($this->_query);
		}
		
		public function loadObjectList()
		{
			if(is_null($this->_query))
			{
				$this->query();
			}
			return $this->_dba->loadObjectList($this->_query);
		}
		
		public function tableExists($table)
		{
			$table = $this->value($table);
			foreach($this->_prefix as $key => $value)
			{
				$table = str_replace($key, $value, $table);
			}
			return $this->_dba->tableExists($table, $this->_link);
		}
		
		public function disconnect()
		{
			if(!is_null($this->_link))
			{
				return $this->_dba->disconnect($this->_link);
			}
			return true;
		}
	}
	
?>