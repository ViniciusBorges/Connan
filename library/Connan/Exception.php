<?php

	class ConnanException
	{
		public static $_messages = array();
		
		public static function raise(Array $error)
		{
			/**
			 * Codes:
			 * 404: fatal, not found
			 * 300: warning, not found
			 */
			$default = array(
				'code' => 0,
				'message' => '',
				'package' => 'connan'
			);
			$error = array_merge($default, $error);
			self::$_messages[] = $error;
		}
	}