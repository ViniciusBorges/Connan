<?php

	/**
	 * Get defaults application info
	 */
	$default_component = 'content';
	$default_controller = 'articles';
	$default_view = 'blog';
	$default_template = 'connan';
	$default_language = 'pt-br';

	define('CONNAN_PATH_APPLICATION', dirname(__FILE__));

	require 'library/Connan/Connan.php';

	/**
	 * Custom application info by request values
	 */
	$component = Connan_Request::getComponent($default_component);
	$controller = Connan_Request::getController($default_controller);
	$view = Connan_Request::getView($default_view);
	$template = Connan_Request::getTemplate($default_template);
	$language = Connan_Request::getLanguage($default_language);


	$application = Connan_Factory::getApplication();
	/**
	 * Set application paths
	 */
	$application->setPaths(array(
		'controller' => CONNAN_PATH_APPLICATION.DS.'components'.DS.$component.DS.'controllers',
		'model' => CONNAN_PATH_APPLICATION.DS.'components'.DS.$component.DS.'models',
		'view' => CONNAN_PATH_APPLICATION.DS.'components'.DS.$component.DS.'views'.DS.$controller,
		'language' => CONNAN_PATH_APPLICATION.DS.'languages',
		'configuration' => CONNAN_PATH_APPLICATION.DS.'configuration',
		'templates' => CONNAN_PATH_APPLICATION.DS.'templates',
	));

	/**
	 * Set application values
	 */
	$application
		->setComponent($component)
		->setController($controller)
		->setView($view)
		->setTemplate($template)
		->setLanguage($language);

	/**
	 * Finish application execution
	 */
	$application->redirect();
	$application->render();