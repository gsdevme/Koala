<?php

	namespace Koala;

	use \Koala\Interfaces\Singleton;

	use \Koala\Registry;
	use \Koala\Hooker;
	use \Koala\Http\Request;

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
			$this->_registry->hooks = (object)array();
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

		/**
		 * [setConfiguration description]
		 * 
		 * @param array $options
		 */
		public function setConfiguration(array $options)
		{
			$options = (object)$options;
		}

		public function hook($hook, $callback)
		{
			$hookPoint = strtolower(strstr($hook, '://', true));

			switch($hookPoint){
				case 'before':
					break;
				case 'after':
					break;	
				default:
					throw new InvalidHookPointException('Only before:// and after:// are supported for hook points.');
			}

			$methodNS = substr(strstr($hook, '://'), 3);

			return $this->_addHook($hookPoint, $methodNS, $callback);
		}

		private function _addHook($point, $methodNS, $callback)
		{
			$methodHash = md5($methodNS);

			$this->_registry->hooks->$methodHash = (object)array(
				'point' => $point,
				'methodNS' => $methodNS,
				'callback' => $callback
			);

			return (bool)true;
		}

		public function run()
		{
			$request = new Hooker(new Request($_SERVER, $this->_registry), $this->_registry);

			$request->getRequest();
		}
	}