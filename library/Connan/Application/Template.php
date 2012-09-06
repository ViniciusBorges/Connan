<?php /*é*/

	class Connan_Application_Template extends Connan_Util_Singleton
	{
		public $baseurl = '';
		public $template = '';
		
		public function __construct()
		{
			$application =& Connan_Factory::getApplication();
			$this->template = $template = $application->getTemplateName();
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
		
		public function component()
		{
			$document =& Connan_Factory::getDocument();
			echo $document->component();
		}
		
		public function header()
		{
			$document =& Connan_Factory::getDocument();
			echo $document->header();
		}
		
		public function modules($position, $style = 'default')
		{
			$db =& Connan_Factory::getDBO();
			$application =& Connan_Factory::getApplication();
			$db->setQuery("
				SELECT
					m.id, m.title, m.params,
					p.position
				FROM #__modules m
				JOIN #__modules_relations r
				JOIN #__positions p
				WHERE p.position = '$position' AND m.position = p.id
				AND (r.module = m.id)
				AND published = 1
			");
			$modules = $db->loadObjectList();
			
			$modules_file = CONNAN_PATH_BASE.DS.$application->getPath('tempaltes').DS.$this->tempalte.DS.'override'.DS.'modues.php';
			if(file_exists($modules_file))
			{
				require $modules_file;
			}
			$obj = 'CustomModulesStyles';
			$modules_method = $style.'Style';
			if(!method_exists($this, $modules_method) || class_exists('CustomModulesStyles'))
			{
				$obj = $this;
				$modules_method = 'defaultStyle';
			}
			foreach($modules as $module)
			{
				$params = $this->getModuleParams($module);
				call_user_func_array(array($obj, $modules_method), array(
					$module->module,
					$module->title,
					$params
				));
			}
		}
		
		public function getModuleParams($id)
		{
			$db =& Connan_Factory::getDBO();
			$db->setQuery("
				SELECT
					v.value as value, f.name as name
				FROM #__modules_values v
				JOIN #__modules_fields f
				WHERE v.module_id = '$id' AND f.id = v.field_id
			");
			$params = (object) array();
			$_params = $db->loadObjectList();
			foreach($_params as $param)
			{
				$params->{$param->name} = $param->value;
			}
			return $params;
		}
		
		public function defaultStyle($module, $title, $params)
		{
			
		}
		
		public function countModules($position)
		{
			$db =& Connan_Factory::getDBO();
			if(!$db->tableExists('#__modules'))
			{
				ConnanException::raise(array(
					'message' => 'modules not suported',
					'package' => 'application',
					'code' => 200
				));
				return 0;
			}
		}
		
		public function debug()
		{
			if(count(ConnanException::$_messages))
			{
				$output = '<ul class="connan_debug">';
				foreach(ConnanException::$_messages as $message)
				{
					$text = "{$message->package}.{$message->message}";
					$output .= "<li>[{$message->code}] - {$text}</li>";
				}
				$output .= '</ul>';
				echo $output;
			}
			return;
		}
	}