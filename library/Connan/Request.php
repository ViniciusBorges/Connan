<?php
	
	class Connan_Request
	{
		/*
		 * getVar method
		 * Pega um valor de uma vari�vel global
		 * @param key {string}    : Chave a ser pega
		 * @param default {mixed} : Valor padr�o, no caso de a chave n�o existir
		 * @param method {string} : A vari�vel em que ser� pego o valor
		 * @param type {string}   : Tipo de dado a ser retornado
		 * @param secure {bool}   : Modo seguro
		 * @return {mixed}
		 */
		public static function getVar($key, $default = '', $method = 'request', $type = null, $secure = true)
		{
			$var = '_'.strtoupper($method);
			switch(strtolower($type))
			{
				case 'string':
					$res = isset($GLOBALS[$var][$key]) ? (string) $GLOBALS[$var][$key] : $default;
				break;
				case 'int':
					$res = isset($GLOBALS[$var][$key]) ? (int) $GLOBALS[$var][$key] : $default;
				break;
				case 'array':
					$res = isset($GLOBALS[$var][$key]) ? (array) $GLOBALS[$var][$key] : $default;
				break;
				case 'object':
					$res = isset($GLOBALS[$var][$key]) ? (object) $GLOBALS[$var][$key] : $default;
				break;
				default:
					$res = isset($GLOBALS[$var][$key]) ? $GLOBALS[$var][$key] : $default;
				break;
			}
			return is_string($res) && $secure === true ? addcslashes($res, "%_'.\"") : $res;
		}
		
		/*
		 * issetVar method
		 * Verifica se a chave passada em @key existe em @method
		 * @param key {string}    : chave a ser verificada em @method
		 * @param method {string} : vari�vel em que @key ser� buscada
		 * @return {bool}
		 */
		public static function issetVar($key, $method = 'request')
		{
			$var = '_'.strtoupper($method);
			return isset($$var[$key]);
		}
		
		/*
		 * setVar method
		 * Seta um valor na vari�vel passada em @request
		 * @param key {string}    : chave a ser setada
		 * @param value {mixed}   : valor para a chave
		 * @param method {string} : vari�vel a inserir a chave
		 * @return self {object}
		 */
		public static function setVar($key, $value, $method = 'request')
		{
			$var = '_'.strtoupper($method);
			$$var[$key] = $value;
			return self;
		}
		
		/*
		 * getComponent method
		 * Pega a vari�vel component
		 * @param default {string} : valor padr�o, no caso de n�o ter sido setado o componente
		 * @return {string}
		 */
		public static function getComponent($default = '')
		{
			return self::getVar('component', $default, 'request', 'string');
		}
		
		/*
		 * getController method
		 * Pega a vari�vel controller
		 * @param default {string} : valor padr�o, no caso de n�o ter sido setado o controller
		 * @return {string}
		 */
		public static function getController($default = '')
		{
			return self::getVar('controller', $default, 'request', 'string');
		}
		
		/*
		 * getView method
		 * Pega a vari�vel view
		 * @param default {string} : valor padr�o, no caso de n�o ter sido setado a view
		 * @return {string}
		 */
		public static function getView($default = '')
		{
			return self::getVar('view', $default, 'request', 'string');
		}
		
		/*
		 * getAction method
		 * Pega a vari�vel action
		 * @param default {string} : valor padr�o, no caso de n�o ter sido setado a action
		 * @return {string}
		 */
		public static function getAction($default = '')
		{
			return self::getVar('action', $default, 'request', 'string');
		}
		
		/*
		 * getLanguage method
		 * Pega a vari�vel language
		 * @param default {string} : valor padr�o, no caso de n�o ter sido setado a language
		 * @return {string}
		 */
		public static function getLanguage($default = '')
		{
			return self::getVar('language', $default, 'request', 'string');
		}
		
		/*
		 * getTemplate method
		 * Pega a vari�vel template
		 * @param default {string} : valor padr�o, no caso de n�o ter sido setado o template
		 * @return {string}
		 */
		public static function getTemplate($default = '')
		{
			return self::getVar('template', $default, 'request', 'string');
		}
	}