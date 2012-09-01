<?php

	if(!defined('CONNAN_PATH_BASE'))
	{
		define('CONNAN_PATH_BASE', dirname(__FILE__));
	}
	
	if(!defined('DS'))
	{
		define('DS', DIRECTORY_SEPARATOR);
	}

	require CONNAN_PATH_BASE.DS.'Util/Singleton.php';
	require CONNAN_PATH_BASE.DS.'Loader.php';
	require CONNAN_PATH_BASE.DS.'Application.php';
	
	$loader = Connan_Loader::getInstance();