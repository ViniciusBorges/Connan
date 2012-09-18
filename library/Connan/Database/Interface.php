<?php

	interface Connan_DatabaseInterface
	{
		public function connect($hostname, $username, $password, $database);
		
		public function getErrorMessage($link);
		
		public function value($value);
		
		public function setQuery($query);
		
		public function query($queryString, $link);
		
		public function getNumRows($query);
		
		public function loadObject($query);
		
		public function loadObjectList($query);
		
		public function tableExists($query, $link);
		
		public function disconnect($link);
	}