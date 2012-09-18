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
		
		/**
		 * addPrefix
		 * add or edit a prefix table in prefixs list
		 * @param $key {string} : mask to prefix
		 * @param $value {string} : real prefix
		 * @access public
		 * @return void
		 */
		public function addPrefix($key, $value)
		{
			$this->_prefix[$key] = $value;
		}
		
		/**
		 * Connect
		 * connect with database
		 * @access public
		 * @return bool
		 */
		public function connect()
		{
			if(is_null($this->_link))
			{
				$this->_link = $this->_dba->connect($this->_hostname, $this->_username, $this->_password, $this->_database);
				if(!$this->_link)
				{
					ConnanException::raise(array(
						'code' => 404,
						'package' => 'database',
						'message' => $this->_dba->getErrorMessage()
					));
					return false;
				}
			}
			return true;
		}
		
		/**
		 * setQuery
		 * set a query to execute after
		 * @param query {string} : the query string
		 * @access public
		 * @return void
		 */
		public function setQuery($query)
		{
			foreach($this->_prefix as $key => $value)
			{
				$query = str_replace($key, $value, $query);
			}
			$this->_queryString = $this->_dba->setQuery($query);
			$this->_query = null;
		}
		
		/**
		 * value
		 * clear the value to insert in query
		 * @param value {string} : the value to clear
		 * @access public
		 * @return string
		 */
		public function value($value)
		{
			return $this->_dba->value($value);
		}
		
		/**
		 * query
		 * execute the last query setted by self::setQuery
		 * @access public
		 * @return resource
		 */
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
		
		/**
		 * getNumRows
		 * get num of rows returned in last query
		 * @access public
		 * @return int
		 */
		public function getNumRows()
		{
			if(is_null($this->_query))
			{
				$this->query();
			}
			return $this->_dba->getNumRows($this->_query);
		}
		
		/**
		 * loadObject
		 * get an object with an result of last query executed
		 * @access public
		 * @return object
		 */
		public function loadObject()
		{
			if(is_null($this->_query))
			{
				$this->query();
			}
			return $this->_dba->loadObject($this->_query);
		}
		
		/**
		 * loadObjectList
		 * get a list of results of last query executed
		 * @access public
		 * @return array
		 */
		public function loadObjectList()
		{
			if(is_null($this->_query))
			{
				$this->query();
			}
			return $this->_dba->loadObjectList($this->_query);
		}
		
		/**
		 * tableExists
		 * verify if table exists
		 * @param $table {string} : name of table to verify
		 * @access public
		 * @return bool
		 */
		public function tableExists($table)
		{
			$table = $this->value($table);
			foreach($this->_prefix as $key => $value)
			{
				$table = str_replace($key, $value, $table);
			}
			return $this->_dba->tableExists($table, $this->_link);
		}
		
		public function getInsertId()
		{
			return $this->_dba->getInsertId($this->_link);
		}
		
		/**
		 * disconnect
		 * close connection in self::$_link
		 * @return void
		 */
		public function disconnect()
		{
			if(!is_null($this->_link))
			{
				$this->_dba->disconnect($this->_link);
			}
		}
		
		public function __destruct()
		{
			// if caching is enabled, save the cached queries
		}
	}
	
?>