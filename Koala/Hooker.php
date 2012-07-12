<?php

	namespace Koala;

	class Hooker
	{

		const AFTER='after';
		const BEFORE='before';

		private $_object;
		private $_hooks;
		private $_class;

		/**
		 * [__construct description]
		 * 
		 * @param Hooker   $instance
		 * @param Registry $registry
		 */
		public function __construct(Interfaces\Hookable $instance, Interfaces\Registry $registry)
		{
			$this->_object = $instance;
			$this->_class = get_class($instance);

			$this->_hooks = $registry->get('hooks');
		}

		/**
		 * [__call description]
		 * 
		 * @param  string $method
		 * @param  array  $arguments
		 * @return mixed
		 */
		public function __call($method, array $arguments)
		{
			$hookKey = md5($this->_class . '->' . $method);

			if(isset($this->_hooks->$hookKey)){
				$hook = $this->_hooks->$hookKey;
				$hookPoint = $hook->point;

				/**
				 * @todo this needs to change to allow multiple hooks and allow both Before & After
				 */
				if($hookPoint == Hooker::AFTER){
					$return = call_user_func_array(array($this->_object, $method), $arguments);
					$callback = $hook->callback;

					return $callback($return);
				}
			}
			

			return call_user_func_array(array($this->_object, $method), $arguments);
		}

		/**
		 * [__set description]
		 * 
		 * @param string $key
		 * @param mixed $value
		 * @return  bool
		 */
		public function __set($key, $value)
		{
			return $this->_object->$key = $value;
		}

		/**
		 * [__get description]
		 * 
		 * @param  string $key
		 * @return  mixed
		 */
		public function __get($key)
		{
			return $this->_object->$key;
		}

		/**
		 * [__isset description]
		 * 
		 * @param  string  $name
		 * @return boolean
		 */
		public function __isset($name)
		{
			return (bool)isset($this->_object->$name);
		}

	}