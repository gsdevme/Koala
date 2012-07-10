<?php

	namespace Koala;

	use \Koala\Interfaces\Hookable;

	class Hooker
	{

		private $_object;

		public function __construct($instance)
		{
			// This seems to work for interfaces (although really it shouldn't)
			if($instance instanceof Hookable){
				$this->_object = $instance;
				return;
			}

			// @todo replace with exception
			die('not hookable');
		}

		public function __call($method, array $arguments)
		{
			return call_user_func_array(array($this->_object, $method), $arguments);
		}

		public function __set($key, $value)
		{
			return $this->_object->$key = $value;
		}

		public function __get($key)
		{
			return $this->_object->$key;
		}

		public function __isset($name)
		{
			return (bool)isset($this->_object->$name);
		}

	}