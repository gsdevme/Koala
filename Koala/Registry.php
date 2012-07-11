<?php

	namespace Koala;

	class Registry
	{

		private static $_instance;
		private $_registry;

		public function __construct()
		{
			$this->_registry = (object)array(

				// This is public... in the sense the application should be setting & getting here
				'public' => (object)array(),
				'private' => (object)array()
			);
		}

		public static function getInstance()
		{
			if(!self::$_instance instanceof self){
				self::$_instance = new self();
			}

			return self::$_instance;
		}

		public function get($key)
		{
			return $this->_registry->public->$key;
		}

		public function set($key, $value)
		{
			return $this->_registry->public->$key = $value;
		}

		public function getPrivate($key)
		{
			return $this->_registry->private->$key;
		}

		public function setPrivate($key, $value)
		{
			$this->_registry->private->$key = $value;
		}

		public function __get($key)
		{
			return $this->get($key);
		}

		public function __set($key, $value)
		{
			return $this->set($key, $value);
		}

	}