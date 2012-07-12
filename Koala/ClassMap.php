<?php

	namespace Koala;

	/**
	 * This class is used to load in third party libraries & applicaions.
	 *
	 * So if you want to use Wideimage you can map 'WideImage' to load the folder Libraries/WideImage/WideImage.php
	 */
	class ClassMap
	{

		private $_root;
		private $_map;
		private $_prefixMap;

		/**
		 * [__construct description]
		 * @param Interfaces\Registry $registry [description]
		 */
		public function __construct(Interfaces\Registry $registry)
		{
			$this->_root = $registry->get('root');

			spl_autoload_register(array($this, '_autoloader'), true);		
		}

		/**
		 * [add description]
		 * 
		 * @param string $class
		 * @param string $directory
		 */
		public function add($class, $directory)
		{
			$this->_map[md5($class)] = $this->_root . $directory;
		}

		/**
		 * [addPrefix description]
		 * 
		 * @param string $class
		 * @param string $directory
		 */
		public function addPrefix($class, $directory, $setIncludePath=false)
		{
			if(strpos($class, '_')){
				if($setIncludePath !== false){
					set_include_path($this->_root . $directory);
				}

				return $this->_prefixMap[md5(strstr($class, '_', true) . '_')] = $this->_root . $directory;
			}

			if(strpos($class, '\\')){
				if($setIncludePath !== false){
					set_include_path($this->_root . $directory);
				}

				return $this->_prefixMap[md5(strstr($class, '\\', true) . '_')] = $this->_root . $directory;
			}		
		}

		/**
		 * [_autoloader description]
		 * 
		 * @param  string $class
		 */
		private function _autoloader($class)
		{
			var_dump($class);

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

		private function _require()
		{

		}
	}