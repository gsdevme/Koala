<?php

	namespace Koala;

	use \ArrayAccess;

	/**
	 * This was inspired by Silms class, very nice.
	 * https://github.com/codeguy/Slim/blob/master/Slim/Environment.php
	 */
	class Environment implements ArrayAccess
	{

		private $_defaults = array(
			'SCRIPT_NAME' => '',
			'REQUEST_METHOD' => 'GET',
			'SCRIPT_NAME' => '',
			'PATH_INFO' => '',
			'QUERY_STRING' => '',
			'SERVER_NAME' => 'localhost',
			'SERVER_PORT' => 80,
			'ACCEPT' => 'text/html,application/xhtml+xml,application/xml;q=0.9,*/*;q=0.8',
			'ACCEPT_LANGUAGE' => 'en-US,en;q=0.8',
			'ACCEPT_CHARSET' => 'ISO-8859-1,utf-8;q=0.7,*;q=0.3',
			'USER_AGENT' => 'Mozzila',
			'REMOTE_ADDR' => '127.0.0.1',
		);

		private $_environment;

		private function __construct(array $environment=null)
		{
			if($environment !== null){
				$this->_environment = array_merge($this->_defaults, $environment);

				var_dump($this->_environment);
			}
		}

		public static function getInstance(array $environment=null)
		{
			if(!self::$_instance instanceof self){
				self::$_instance = new self($environment);
			}

			return self::$_instance;
		}

		public function offsetExists($offset)
		{

		}

		public function offsetGet($offset)
		{

		}

		public function offsetSet($offset, $value)
		{

		}

		public function offsetUnset($offset)
		{

		}

	}