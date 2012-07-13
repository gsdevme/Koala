<?php

	namespace Koala;

	class App implements Interfaces\Singleton
	{

		private $_registry;

		/**
		 * [__construct description]
		 * @author github:gsdevme, twitter:@gsphpdev
		 * @since 0.1 Alpha
		 *
		 * @param [type] $registry=null [description]
		 */
		public function __construct(Interfaces\Registry $registry=null)
		{
			$this->_registry = $registry;
			$this->_registry->set('hooks', (object)array());
		}

		/**
		 * [setConfiguration description]
		 * @author github:gsdevme, twitter:@gsphpdev
		 * @since 0.1 Alpha
		 *
		 * @param array $options [description]
		 */
		public function setConfiguration(array $options)
		{
			$options = (object)$options;
		}

		/**
		 * [hook description]
		 * @author github:gsdevme, twitter:@gsphpdev
		 * @since 0.1 Alpha
		 *
		 * @param [type] $hook [description]
		 * @param function $callback [description]
		 *
		 * @return [type]  [description]
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

			return $this->_addHook($hookPoint, substr(strstr($hook, '://'), 3), $callback);
		}

		/**
		 * [_addHook description]
		 * @author github:gsdevme, twitter:@gsphpdev
		 * @since 0.1 Alpha
		 *
		 * @param [type] $point [description]
		 * @param [type] $methodNS [description]
		 * @param function $callback [description]
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

		/**
		 * [run description]
		 * @author github:gsdevme, twitter:@gsphpdev
		 * @since 0.1 Alpha
		 *
		 * @return [type] [description]
		 */
		public function run()
		{
			$request = new Hooker(new Http\Request($_SERVER, $this->_registry), $this->_registry);

			$request->getRequest();
		}
	}