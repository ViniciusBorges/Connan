<?php /*é*/

	class Connan_Application_Template extends Connan_Util_Singleton
	{
		public function __construct()
		{
			$application =& Connan_Factory::getApplication();
			$template = $application->getTemplateName();
			$path = $application->getPath('templates');
			if(file_exists($path.DS.$template.DS.'index.php'))
			{
				require $path.DS.$template.DS.'index.php';
			}
			else
			{
				ConnanException::raise(array(
					'code' => 404,
					'message' => 'template not found',
					'package' => 'application'
				));
			}
		}
	}