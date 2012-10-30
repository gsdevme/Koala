<?php

	namespace Koala;

	class App
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
			$this->_registry->set('events', (object)array());
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
		 * @param string $when [description]
		 * @param string $hook [description]
		 * @param callback $callback [description]
		 *
		 * @return [type]  [description]
		 */
		public function event($when, $hook, $callback)
		{
			switch($when){
				case 'before':
				case 'after':
					break;
				default:
					throw new InvalidEventPointException('Only before:// and after:// are supported for hook points.');
			}

			return $this->_addEvent($when, $hook, $callback);
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
		private function _addEvent($point, $methodNS, $callback)
		{
			$methodHash = 'event' .sprintf('%u', crc32($methodNS));

			$this->_registry->get('events')->$methodHash = (object)array(
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
		public function run(Interfaces\Http\Request $request)
		{
			$request = new Events\Wrapper($request, $this->_registry);

			$request->getRequest();

			var_dump('Completed');
		}

		public function benchmark()
		{
			return '<pre>'.print_r(array(
				'runtime: ' . (microtime(true) - $this->_registry->get('benchmark')) . ' Seconds',
				'memory: ' . ((memory_get_usage(true) - $this->_registry->get('memory')) / 1000) . ' kb',
			), true).'</pre>';
		}
	}