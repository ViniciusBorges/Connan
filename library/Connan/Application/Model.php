<?php /*é*/

	class Connan_Application_Model extends Connan_Util_Object
	{
		protected $db = null;
		
		public function __construct()
		{
			$this->db = Connan_Factory::getDBO();
			if(method_exists($this, 'construct'))
			{
				$this->contruct();
			}
		}
		
		public function query($queryStr)
		{
			$this->db->setQuery($queryStr);
			return $this->db->query();
		}
		
		public function loadObject($queryStr)
		{
			$this->query($queryStr);
			$this->db->loadObject();
		}
		
		public function loadObjectList($queryStr)
		{
			$this->query($queryStr);
			return $this->db->loadObjectList();
		}
		
		public function getNumRows($queryStr)
		{
			$this->query($queryStr);
			return $this->db->getNumRows();
		}
		
		public function addPrefix($mask, $prefix)
		{
			return $this->db->addPrefix($mask, $prefix);
		}
		
		public function tableExists($table)
		{
			return $this->db->tableExists($table);
		}
		
		public function getInsertId()
		{
			return $this->db->getInsertId();
		}
	}