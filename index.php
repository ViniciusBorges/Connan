<?php
	
	require 'library/Connan/Util/Singleton.php';
	require 'library/Connan/Application.php';
	require 'library/Connan/Loader.php';
	
	$loader = Connan_Loader::getInstance();
	
	new Connan_Database_Dbo();
	
?>