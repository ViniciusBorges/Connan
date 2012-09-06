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
			 * 200: warning, database
			 * 100: user error
			 * 101: user alert
			 * 102: user message
			 * 0: undefined
			 */
			$default = array(
				'code' => 0,
				'message' => '',
				'package' => 'connan'
			);
			$error = (object) array_merge($default, $error);
			self::$_messages[] = $error;
		}
	}