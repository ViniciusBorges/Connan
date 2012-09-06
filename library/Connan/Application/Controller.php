<?php

	class Connan_Application_Controller extends Connan_Util_Object
	{
		protected $component = '';
		protected $controller = '';
		protected $view = '';
		protected $_view = null;
		private $prepared = false;
		protected $model = null;
		protected $data = array();
		
		public function __construct()
		{
			$this->data = (object) array();
			$application =& Connan_Factory::getApplication();
			$this->component = $application->getComponentName();
			$this->controller = $application->getControllerName();
			$this->view = $application->getViewName();
			
			if(method_exists($this, 'construct'))
			{
				$this->construct();
			}
			
			$this->prepareView();
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
					'package' => 'aplication'
				));
				return false;
			}
		}
		
		public function renderView()
		{
			$this->_view = new Connan_Application_View($this->component, $this->controller, $this->view, $this->data);
		}
		
		public function set($key, $value = '')
		{
			$this->data->$key = $value;
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
			$application->setRedirect($url, $messages);
		}
	}