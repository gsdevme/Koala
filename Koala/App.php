<?php

	namespace Koala;

	class App implements Interfaces\Singleton
	{

		private static $_instance;
		private $_registry;

		/**
		 * [__construct description]
		 * 
		 * @param Registry $registry=null
		 */
		public function __construct(Interfaces\Registry $registry=null)
		{
			$this->_registry = $registry;
			$this->_registry->set('hooks', (object)array());
		}

		/**
		 * [getInstance description]
		 * 
		 * @param  Registry $registry=null
		 * @return App
		 */
		public static function getInstance(Interfaces\Registry $registry=null)
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

		/**
		 * [hook description]
		 * 
		 * @param  String   $hook
		 * @param  callable $callback
		 * @return mixed
		 */
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

		/**
		 * [_addHook description]
		 * 
		 * @param string   $point
		 * @param string   $methodNS
		 * @param callable $callback
		 */
		private function _addHook($point, $methodNS, $callback)
		{
			$methodHash = md5($methodNS);

			$this->_registry->get('hooks')->$methodHash = (object)array(
				'point' => $point,
				'methodNS' => $methodNS,
				'callback' => $callback
			);

			return (bool)true;
		}

		public function run()
		{
			$request = new Hooker(new Http\Request($_SERVER, $this->_registry), $this->_registry);

			$request->getRequest();
		}
	}