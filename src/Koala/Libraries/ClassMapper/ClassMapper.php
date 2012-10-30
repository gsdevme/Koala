<?php

	namespace Koala\Libraries\ClassMapper;

	use \Koala\Interfaces\Registry as iRegistry;

	class ClassMapper
	{

		private $_root;
		private $_map;
		private $_prefixMap;

		/**
		 * [__construct description]
		 * @author github:gsdevme, twitter:@gsphpdev
		 * @since 0.1 Alpha
		 *
		 * @param Interfaces\Registry $registry [description]
		 */
		public function __construct(iRegistry $registry)
		{
			$this->_root = $registry->get('root');
			$this->_map = array();
			$this->_prefixMap = array();

			spl_autoload_register(array($this, '_autoloader'), true);
		}

		/**
		 * [add description]
		 * @author github:gsdevme, twitter:@gsphpdev
		 * @since 0.1 Alpha
		 *
		 * @param [type] $class [description]
		 * @param [type] $directory [description]
		 */
		public function add($class, $directory)
		{
			$this->_map[md5($class)] = $this->_root . $directory;
		}

		/**
		 * [addPrefix description]
		 * @author github:gsdevme, twitter:@gsphpdev
		 * @since 0.1 Alpha
		 *
		 * @param [type] $class [description]
		 * @param [type] $directory [description]
		 * @param boolean $setIncludePath=false [description]
		 */
		public function addPrefix($class, $directory, $setIncludePath=false)
		{
			if($setIncludePath !== false){
				set_include_path($this->_root . $directory);
			}

			if(strpos($class, '_')){
				return $this->_prefixMap[md5(strstr($class, '_', true) . '_')] = $this->_root . $directory;
			}

			if(strpos($class, '\\')){
				$strstr = function($val){
					return strstr($class, '\\', true) . '\\';
				};
			}

			if(isset($strstr)){
				return $this->_prefixMap[md5($strstr($class))] = $this->_root . $directory;
			}

			// @todo we need to throw an exception
		}

		/**
		 * [_autoloader description]
		 * @author github:gsdevme, twitter:@gsphpdev
		 * @since 0.1 Alpha
		 *
		 * @param [type] $class [description]
		 *
		 * @return [type]  [description]
		 */
		private function _autoloader($class)
		{
			// Check for Prefix Map
			if(strpos($class, '_')){
				$hash = md5(strstr($class, '_', true) . '_');

				if(isset($this->_prefixMap[$hash])){
					$file = $this->_prefixMap[$hash] . str_replace('_', '/', $class) . '.php';

					if(file_exists($file)){
						return require $file;
					}
				}
			}

			$hash = md5($class);

			// Check for Map
			if(isset($this->_map[$hash])){
				// Namespace Style
				$file = $this->_map[$hash] . str_replace('\\', '/', $class) . '.php';

				if(file_exists($file)){
					return require $file;
				}

				// Undercore Style
				$file = $this->_map[$hash] . str_replace('_', '/', $class) . '.php';

				if(file_exists($file)){
					return require $file;
				}
			}
		}
	}