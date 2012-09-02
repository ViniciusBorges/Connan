<?php
	
	class Connan_Application extends Connan_Util_Singleton
	{
		protected $_paths = array();
		protected $_redirect = null;
		protected $_controller = null;
		protected $_template = null;
		
		protected $component = '';
		protected $controller = '';
		protected $view = '';
		protected $template = '';
		
		public function __construct()
		{
			$this->_paths = array(
				'connan' => CONNAN_PATH_BASE
			);
			$this->getMessages();
			$session =& Connan_Factory::getSession();
			$session->clear('__messages', 'connan.redirect');
		}
		
		public function getPath($path, $default = '')
		{
			return isset($this->_paths[$path]) ? $this->_paths[$path] : '';
		}
		
		public function setPath($name, $path)
		{
			$this->_paths[$name] = $path;
			return $this;
		}
		
		public function setPaths(Array $paths)
		{
			foreach($paths as $name => $path)
			{
				$this->setPath($name, $path);
			}
			return $this;
		}
		
		public function setComponent($component)
		{
			$this->component = $component;
			return $this;
		}
		
		public function setController($controller)
		{
			$this->controller = ucfirst(strtolower($controller));
			return $this;
		}
		
		public function setView($view)
		{
			$this->view = $view;
		}
		
		public function setTemplate($template)
		{
			$this->template = $template;
			return $this;
		}
		
		public function getComponentName()
		{
			return $this->component;
		}
		
		public function getControllerName()
		{
			return $this->controller;
		}
		
		public function getViewName()
		{
			return $this->view;
		}
		
		public function getTemplateName()
		{
			return $this->template;
		}
		
		public function getMessages()
		{
			$session =& Connan_Factory::getSession();
			$messages = $session->get('__messages', '', 'connan.redirect');
			if($messages != '')
			{
				$document = $this->getDocument();
				if(is_array($messages))
				{
					foreach($messages as $message)
					{
						switch($message->type)
						{
							case 'error':
								$document->addError($message);
							break;
							case 'alert':
								$document->addAlert($message);
							break;
							default:
								$document->addMessage($message);
							break;
						}
					}
				}
				else
				{
					$document->addMessage($messages);
				}
			}
		}
		
		public function setRedirect($url, $messages = null)
		{
			$this->_redirect = $url;
			if(!is_null($messages))
			{
				$session =& Connan_Factory::getSession();
				$session->set('__messages', $messages, 'connan.redirect');
			}
		}
		
		public function loadComponent()
		{
			$controller_class = 'Connan_'.$this->controller.'Controller';
			$this->_controller = new $controller_class;
		}
		
		public function loadTemplate()
		{
			$this->_template = Connan_Factory::getTemplate();
		}
		
		public function redirect()
		{
			if(is_null($this->_controller))
			{
				$this->loadController();
			}
			if($this->_redirect != '')
			{
				header('Location:'.$this->_redirect);
			}
		}
		
		public function render()
		{
			if(is_null($this->_controller))
			{
				$this->loadController();
			}
			$this->_controller->render();
			if(is_null($this->_template))
			{
				$this->loadTemplate();
			}
		}
	}
	
?>