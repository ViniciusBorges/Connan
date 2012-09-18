<?php
	
	class Connan_Database_Mysql implements Connan_DatabaseInterface
	{
		public function connect($hostname, $username, $password, $database)
		{
			if($link = mysql_connect($hostname, $username, $password))
			{
				if(mysql_select_db($database, $link))
				{
					return $link;
				}
				else
				{
					return false;
				}
			}
			else
			{
				return false;
			}
		}
		
		public function getErrorMessage($link)
		{
			return mysql_error($link);
		}
		
		public function value($string)
		{
			return $string;
		}
		
		public function setQuery($query)
		{
			return trim($query);
		}
		
		public function query($queryString, $link)
		{
			return mysql_query($queryString, $link);
		}
		
		public function getNumRows($query)
		{
			return mysql_num_rows($query);
		}
		
		public function loadObject($query)
		{
			return mysql_fetch_object($query);
		}
		
		public function loadObjectList($query)
		{
			$arr = array();
			while($obj = mysql_fetch_object($query))
			{
				$arr[] = $obj;
			}
			return $arr;
		}
		
		public function tableExists($table, $link)
		{
			return (bool) mysql_num_rows(mysql_query("SHOW TABLES LIKE '".$table."'", $link));
		}
		
		public function disconnect($link)
		{
			return mysql_close($link);
		}
	}
	
?>