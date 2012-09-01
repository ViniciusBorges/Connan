<?php

	class Connan_Factory
	{
		public static function &getApplication()
		{
			return Connan_Application::getInstance();
		}
		
		public static function &getController()
		{
			return self::getApplication()->getController();
		}
		
		public static function &getModel()
		{
			return self::getController()->getModel();
		}
		
		public static function &getDBO()
		{
			return Connan_Database_Dbo::getInstance();
		}
		
		public static function &getMailer()
		{
			return Connan_Mailer_Mailer::getInstance();
		}
		
		public static function &getSession()
		{
			return Connan_Session::getInstance();
		}
		
		public static function &getConfig()
		{
			return Connan_Config::getInstance();
		}
	}