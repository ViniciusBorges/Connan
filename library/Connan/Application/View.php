<?php /*é*/

	class Connan_Application_View extends Connan_Util_Object
	{
		protected $component = '';
		protected $controller = '';
		protected $view = '';
		
		public function __construct($component, $controller, $view, $data = array())
		{
			$this->component = $component;
			$this->controller = strtolower($controller);
			$this->view = $view;
			foreach($data as $key => $value)
			{
				$this->$key = $value;
			}
			ob_start();
			$this->render();
			$output = ob_get_contents();
			ob_end_clean();
			
			$document =& Connan_Factory::getDocument();
			$document->component($output);
		}
		
		public function render()
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
	}