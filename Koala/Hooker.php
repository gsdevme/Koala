<?php

	namespace Koala;

	use \Koala\Interfaces\Hookable;
	use \Koala\Registry;

	class Hooker
	{

		const AFTER='after';

		private $_object;
		private $_hooks;
		private $_class;

		public function __construct($instance, Registry $registry)
		{
			// This seems to work for interfaces (although really it shouldn't)
			if($instance instanceof Hookable){
				$this->_object = $instance;

				$this->_class = get_class($instance);

				$this->_hooks = $registry->get('hooks');
				return;
			}

			throw new Exceptions\NotHookableException($this->_class . ' does not implement a hookable interface, therefore its not hookable');
		}

		public function __call($method, array $arguments)
		{
			$hookKey = md5($this->_class . '->' . $method);

			if(isset($this->_hooks->$hookKey)){
				$hook = $this->_hooks->$hookKey;
				$hookPoint = $hook->point;

				if($hookPoint == Hooker::AFTER){

					$return = call_user_func_array(array($this->_object, $method), $arguments);
					$callback = $hook->callback;

					return $callback($return);
				}
			}
			

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