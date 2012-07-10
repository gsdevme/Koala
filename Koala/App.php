<?php

	namespace Koala;

	use \Koala\Interfaces\Singleton as Singleton;
	use \Koala\Registry as Registry;

	class App implements Singleton
	{

		private static $_instance;
		private $_registry;

		/**
		 * [__construct description]
		 * 
		 * @param Registry $registry=null
		 */
		public function __construct(Registry $registry=null)
		{
			$this->_registry = $registry;
		}

		/**
		 * [getInstance description]
		 * 
		 * @param  Registry $registry=null
		 * @return App
		 */
		public static function getInstance(Registry $registry=null)
		{
			if(!self::$_instance instanceof self){
				self::$_instance = new self($registry);
			}

			return self::$_instance;
		}

	}