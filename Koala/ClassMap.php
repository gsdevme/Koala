<?php

	namespace Koala;

	class ClassMap
	{

		private $_root;
		private $_map;

		public function __construct(Interfaces\Registry $registry)
		{
			$this->_root = $registry->get('root');

			spl_autoload_register(array($this, '_autoloader'), true);		
		}

		public function add($class, $directory)
		{
			$this->_map[md5($class)] = $this->_root . $directory . '.php';
		}

		private function _autoloader($class)
		{
			$hash = md5($class);

			if(isset($this->_map[$hash])){
				$file = $this->_map[$hash];

				if(file_exists($file)){
					return require $file;
				}
			}
		}
	}