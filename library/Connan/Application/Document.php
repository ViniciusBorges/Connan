<?php

	class Connan_Application_Document extends Connan_Util_Singleton
	{
		protected $_messages = array();
		protected $_title = '';
		protected $_component = '';
		protected $_header = '';
		
		public function __construct()
		{
			
		}
		
		public function addMessage($message)
		{
			$this->_messages[] = (object) array(
				'message' => $message,
				'type' => 'message'
			);
			return $this;
		}
		
		public function getMessages($type = 'all')
		{
			switch($type)
			{
				case 'all':
					return $this->_messages;
				break;
				default:
					$messages = array();
					foreach($this->_messages as $message)
					{
						if($message->type == $type)
						{
							$messages[] = $message->message;
						}
					}
					return $message;
				break;
			}
		}
		
		public function title($title = null)
		{
			if(is_null($title))
			{
				return $this->_title;
			}
			$this->_title = $title;
			return $this;
		}
		
		public function component($component = null)
		{
			echo $component;
			if(is_null($component))
			{
				return $component;
			}
			$this->_component = $component;
			return $this;
		}
		
		public function header($header = null)
		{
			if(is_null($header))
			{
				$this->_header .= "<title>{$this->_title}</title>";
				return $this->_header;
			}
			$this->_header = $header;
			return $this;
		}
		
		public function addScript($code)
		{
			$this->_header .= "<script type=\"text/javascript\">{$code}</script>";
			return $this;
		}
		
		public function addScriptPath($path)
		{
			$this->_header .= "<script type=\"text/javascript\" src=\"{$path}\"></script>";
			return $this;
		}
		
		public function addStyle($code)
		{
			$this->_header .= "<style type=\"text/css\">{$code}</style>";
			return $this;
		}
		
		public function addStylePath($path)
		{
			$this->_header .= "<link rel=\"stylesheet\" type=\"text/css\" href=\"{$path}\" />";
			return $this;
		}
	}