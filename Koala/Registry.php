<?php

	namespace Koala;

	use \LogicException;

	/**
	 *
	 */
	class Registry implements Interfaces\Registry
	{

		private static $_instance;
		private $_registry;

		/**
		 * [__construct description]
		 * @author github:gsdevme, twitter:@gsphpdev
		 * @since 0.1 Alpha
		 */
		private function __construct()
		{
			$this->_registry = (object)array();
		}

		/**
		 * [__clone description]
		 * @author github:gsdevme, twitter:@gsphpdev
		 * @since 0.1 Alpha
		 *
		 * @return [type] [description]
		 */
		public function __clone()
		{
			throw new LogicException('Cloning is not allowed, Singleton Pattern');
		}

		/**
		 * [getInstance description]
		 * @author github:gsdevme, twitter:@gsphpdev
		 * @since 0.1 Alpha
		 *
		 * @return [type] [description]
		 */
		public static function getInstance()
		{
			if(!self::$_instance instanceof self){
				self::$_instance = new self();
			}

			return self::$_instance;
		}

		/**
		 * [get description]
		 * @author github:gsdevme, twitter:@gsphpdev
		 * @since 0.1 Alpha
		 *
		 * @param [type] $key [description]
		 *
		 * @return [type]  [description]
		 */
		public function get($key)
		{
			return (isset($this->_registry->$key)) ? $this->_registry->$key : null;
		}

		/**
		 * [set description]
		 * @author github:gsdevme, twitter:@gsphpdev
		 * @since 0.1 Alpha
		 *
		 * @param [type] $key [description]
		 * @param [type] $value [description]
		 */
		public function set($key, $value)
		{
			return $this->_registry->$key = $value;
		}

		/**
		 * [__isset description]
		 * @author github:gsdevme, twitter:@gsphpdev
		 * @since 0.1 Alpha
		 *
		 * @param [type] $key [description]
		 *
		 * @return boolean  [description]
		 */
		public function __isset($key)
		{
			return (bool)isset($this->_registry->$key);
		}

	}