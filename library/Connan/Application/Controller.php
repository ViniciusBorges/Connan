<?php

	abstract class Connan_Application_Controller extends Connan_Util_Object
	{
		protected $component = '';
		protected $controller = '';
		protected $view = '';
		private $prepared = false;
		protected $model = null;
		
		public function __construct()
		{
			$application =& Connan_Factory::getApplication();
			$this->component = $application->getComponentName();
			$this->controller = $application->getControllerName();
			$this->view = $application->getViewName();
			
			if(method_exists($this, 'contruct'))
			{
				$this->construct();
			}
		}
		
		public function getModel()
		{
			if(is_null($this->model))
			{
				$model_class = 'Connan_'.$this->controller.'Model';
				$this->model = new $model_class;
			}
			return $this->model;
		}
		
		public function prepareView()
		{
			$view_method = $this->view.'View';
			if(method_exists($this, $view_method))
			{
				$this->$view_method();
				return true;
			}
			else
			{
				ConnanException::raise(array(
					'code' => 404,
					'message' => 'view not found',
					'package' => 'pplication'
				));
				return false;
			}
		}
		
		public function renderView()
		{
			$application =& Connan_Factory::getApplication();
			$component_path = $application->getPath('view');
			$template_path =
				$application->getPath('templates').DS.
				$application->getTemplateName().DS.
				'override'.DS.'components'.DS.
				$application->getComponentName();
			
			if(file_exists($template_path.DS.$this->view.'.php'))
			{
				require $template_path.DS.$this->view.'.php';
				return true;
			}
			else if(file_exists($component_path.DS.$this->view.'.php'))
			{
				require $component_path.DS.$this->view.'.php';
				return true;
			}
			else
			{
				ConnanException::raise(array(
					'code' => 404,
					'message' => 'view not found',
					'package' => 'application'
				));
				return false;
			}
		}
		
		public function render()
		{
			if(!$this->prepared)
			{
				$this->prepareView();
			}
			$this->renderView();
		}
		
		public function setRedirect($url, $messages = null)
		{
			$application =& Connan_Factory::getApplication();
			$application->getRedirect($url, $messages);
		}
	}