<?php

	class Connan_Loader_Autoload
	{
		public static function autoload($name)
		{
			if(preg_match('/^Connan/', $name))
			{
				$loader =& Connan_Loader::getInstance();
				switch(true)
				{
					case preg_match('/[^_]Exception/', $name):
						return $loader->loadException($name);
					break;
					case preg_match('/[^_]Interface$/', $name):
						return $loader->loadInterface($name);
					break;
					case preg_match('/[^_]Abstract/', $name):
						return $loader->loadAbstract($name);
					break;
					case preg_match('/[^_]Controller/', $name):
						return $loader->loadController($name);
					break;
					case preg_match('/[^_]Model/', $name):
						return $loader->loadModel($name);
					break;
					default:
						return $loader->loadClass($name);
					break;
				}
			}
		}
	}