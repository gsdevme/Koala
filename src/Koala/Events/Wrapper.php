<?php

	namespace Koala\Events;

	/**
	 * This is how the Events work, basically a class
	 * infront of every Wrappable class
	 */
	class Wrapper
	{

		const AFTER='after';
		const BEFORE='before';

		private $_object;
		private $_events;
		private $_class;

		/**
		 * Ensures the $instance is Wrappable, and ther user
		 * is awhere its Wrappable by enforcing the interface.
		 *
		 * Grabs the registry so we can pull out of the events
		 *
		 * @param Wrappable   $instance
		 * @param Registry $registry
		 */
		public function __construct(\Koala\Interfaces\Events\Wrappable $instance, \Koala\Interfaces\Registry $registry)
		{
			$this->_object = $instance;

			// gets the class name
			$this->_class = get_class($instance);

			// Copies all the events into the Wrapper instance
			$this->_events = $registry->get('events');
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
			// Create a checksum
			$eventKey = 'event' . sprintf('%u', crc32($this->_class . '->' . $method));

			if(isset($this->_events->$eventKey)){

				$event = $this->_events->$eventKey;
				$eventPoint = $event->point;

				/**
				 * @todo this needs to change to allow multiple events and allow both Before & After
				 */
				if($eventPoint == self::AFTER){
					$return = call_user_func_array(array($this->_object, $method), $arguments);
					$callback = $event->callback;

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